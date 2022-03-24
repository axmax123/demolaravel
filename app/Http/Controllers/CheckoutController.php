<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
Session_start();
class CheckoutController extends Controller
{
     public function AuthLogin()
    {
      $admin_id = Session::get('admin_id');
      if($admin_id)
      {
       return Redirect::to('admin.dashboard');     
      }
      else{
       return Redirect::to('admin')->send();
      }
    }   
    public function view_order($orderId)
    {
          $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')->where('tbl_order.order_id',$orderId)
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_order_details.*')->first();
        $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.manager_order', $manager_order_by_id);
    }
    public function login_checkout(){
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    $brand_product = DB::table('tbl_band_product')->where('brand_status','0')->orderby('brand_id','desc')->get();
    return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);

    }
    public function add_customer(Request $Request){
    	$data = array();
    	$data['customer_name'] = $Request ->customer_name;
    	$data['customer_phone'] = $Request ->customer_phone; 
    	$data['customer_email'] = $Request ->customer_email; 
    	$data['customer_password'] = mD5($Request ->customer_password); 
    	$customer_id = DB::table('tbl_customers')->insertGetId($data);
        Session::put('customer_id',$customer_id); 
        Session::put('customer_name',$Request ->customer_name);
        return Redirect::to('/checkout');

    }
    public function checkout()
    {
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    $brand_product = DB::table('tbl_band_product')->where('brand_status','0')->orderby('brand_id','desc')->get();
    return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function save_checkout_customer(Request $Request){
   
        $data = array();
    	$data['shopping_name'] = $Request ->shopping_name;
    	$data['shopping_phone'] = $Request ->shopping_phone; 
    	$data['shopping_email'] = $Request ->shopping_email; 
    	$data['shopping_note'] = $Request ->shopping_note; 
    	$data['shopping_address'] = $Request ->shopping_address; 

    	$shopping_id = DB::table('tbl_shopping')->insertGetId($data);
      
        Session::put('shopping_id',$shopping_id); 
        return Redirect::to('/payment');
    }
    public function payment()
    {
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    $brand_product = DB::table('tbl_band_product')->where('brand_status','0')->orderby('brand_id','desc')->get();
     return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);

    }
    public function order_place(Request $request){
        //insert payment_method
     
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang xử lý';
        $payment_id = DB::table('tbl_payments')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shopping_id'] = Session::get('shopping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order_details
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sale_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if($data['payment_method']==1){

            echo 'Thanh toán bằng atm';

        }elseif($data['payment_method']==2){
            Cart::destroy();

            $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_band_product')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product);

        }else{
            echo 'Thẻ ghi nợ';

        }
        
        //return Redirect::to('/payment');
    }
    public function logout_checkout()
    {
    	Session::flush();
    	return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $Request)
    {
	$email = $Request->email_account;
	$password = MD5($Request->password_account);
	$result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
	if($result){
		 Session::put('customer_id',$result->customer_id);
         Session::put('customer_email',$result->customer_email);  
		 return Redirect::to('/checkout');

	}else{
		return Redirect::to('/login-checkout');
	}

    }
    public function manager_order(){ 
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order  = view('admin.manager_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manager_order', $manager_order);
    }
      public function manager_customer()
                {
     $this->AuthLogin();
     $all_customer = DB::table('tbl_customers')->get();
     $manager_customer = view('admin.all_customer')->with('all_customer',$all_customer);
     return  view('admin_layout') -> with('admin.all_customer',$manager_customer);

                }
                 public function delete_order(Request $Request , $orderId){
        DB::table('tbl_order')->where('order_id',$orderId)->delete();
                 Session::put('message','xóa  sản phẩm thành công');
                 return Redirect::to('manager-order');
     }
     // public function login_customer(Request $Request )
     //    {
     //        $this->validate($Request,
     //        [
     //         'email_account' =>'required|email_account',
     //         'password_account'=>'required|min:6|max:20'  
     //        ], 
     //        [
     //            'email.required' =>'vui lòng nhập email',
     //            'email.email'    =>'email không đúng',
     //            'password.required'=>'Vui lòng nhập mật khẩu',
     //            'password.min'     =>'mật khẩu không quá 6 kí tự'

     //        ]  
     //        );
     //        $credentials = array('email'=>$request->email_account,'password'=>$request->password_account);
     //        if(Auth::attempt($credentials)){
     //            return Redirect()->back()->with('thongbao','đăng nhập thành công');
     //        }
     //        else{
     //                             return Redirect()->back()->with('thatbai','đăng nhập thành công');


     //        }
        
}
