<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class ProductController extends Controller
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
    public function add_product()
    {
      $this->AuthLogin();
    $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
    $brand_product = DB::table('tbl_band_product')->orderby('brand_id','desc')->get();
        return 	view('admin.add_product') -> with('cate_product',$cate_product)->with('brand_product',$brand_product);
    }
        	    public function all_product()
        	    {
              $this->AuthLogin();
        	    $all_product = DB::table('tbl_product')
              ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
              ->join('tbl_band_product','tbl_band_product.brand_id','=','tbl_product.brand_id')
              ->orderby('tbl_product.product_id','desc')->get();
        	    $manager_product = view('admin.all_product')->with('all_product',$all_product);
              return view('admin_layout') -> with('admin.all_product',$manager_product);

        	    }
                   public function save_product(Request $Request)
                   {
                    $this->AuthLogin();
                   	$data=array();
                   	$data['product_name'] = $Request->product_name;
                    $data['product_price'] = $Request->product_price;
                    $data['product_desc']=$Request->product_desc;
                    $data['product_content']=$Request->product_content;
                    $data['category_id']=$Request->product_cate;
                    $data['brand_id'] = $Request->product_brand;
                    $data['product_status'] = $Request->product_status;
                     $get_image= $Request-> file('product_image');
                     if($get_image)
                     {
                    $get_name_image =$get_image->getClientOriginalName();  
                    $name_image = current(explode('.',$get_name_image));  
                    $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move('public/upload/product',$new_image);
                     $data['product_image'] = $new_image;
                      DB::table('tbl_product')->insert($data);
     	                Session::put('message','Thêm  phẩm thành công');
       	              return Redirect::to('add-product');
                     }
                    $data['product_image'] = '';
                    DB::table('tbl_product')->insert($data);
     	            Session::put('message','Thêm  phẩm thành công');
       	            return Redirect::to('all-product');
                   } 
            public function unactive_product($product_id)
            {
              $this->AuthLogin();      
             DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' =>1]);
              Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
              return Redirect::to('all-product');

            }
                        public function active_product($product_id)
{
        $this->AuthLogin();
			DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
              Session::put('message',' kích hoạt danh mục sản phẩm thành công');
              return Redirect::to('all-product');

}
           public function edit_product($product_id)
           {
            $this->AuthLogin();
    $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
    $brand_product = DB::table('tbl_band_product')->orderby('brand_id','desc')->get();
           $edit_product =DB::table('tbl_product')->where('product_id',$product_id)->first();
           $manager_product = view('admin.edit_product')->with('pro',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);             
           return 	view('admin_layout') -> with('admin.edit_product',$manager_product);           }
           public function update_product(Request	$Request, $product_id)
           {
            $this->AuthLogin();      
           	 $data=array();
           	        $data['product_name'] = $Request->product_name;
                    $data['product_price'] = $Request->product_price;
                    $data['product_desc']=$Request->product_desc;
                    $data['product_content']=$Request->product_content;
                    $data['category_id']=$Request->product_cate;
                    $data['brand_id'] = $Request->product_brand; 
                    $data['product_status'] = $Request->product_status;
                    $get_image = $Request->file('product_image');

             if($get_image) {
                    $get_name_image =$get_image->getClientOriginalName();  
                    $name_image = current(explode('.',$get_name_image));  
                    $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move('public/upload/product',$new_image);
                    $data['product_image'] = $new_image;
                    DB::table('tbl_product')->where('product_id',$product_id)->update($data);
                    Session::put('message','Cập nhật  sản phẩm thành công');
                    return Redirect::to('all-product');  
                    }
                DB::table('tbl_product')->where('product_id',$product_id)->update($data);
                Session::put('message',' cập nhật sản phẩm thất bại');
                return Redirect::to('all-product');
           

           }
            public function delete_product(Request	$Request, $product_id)
           {
                 $this->AuthLogin();
                 DB::table('tbl_product')->where('product_id',$product_id)->delete();
                 Session::put('message','xóa  sản phẩm thành công');
                 return Redirect::to('all-product');
           

           }
           //end admin page
        public function details_product($product_id)
        {
       $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
       $brand_product = DB::table('tbl_band_product')->where('brand_status','0')->orderby('brand_id','desc')->get();
       $details_product = DB::table('tbl_product')
      ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
      ->join('tbl_band_product','tbl_band_product.brand_id','=','tbl_product.brand_id')
      ->where('tbl_product.product_id',$product_id)->get();     

      foreach ($details_product as $key => $val){ 
       $category_id = $val->category_id;
     }
        
         $related_product = DB::table('tbl_product')
      ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
      ->join('tbl_band_product','tbl_band_product.brand_id','=','tbl_product.brand_id')
      ->where('tbl_category_product.category_id',[$category_id])->whereNotIn('tbl_product.product_id',[$product_id])->get();

      return view('pages.sanpham.show_details')->with('category',$cate_product)->with('brand',$brand_product)->with('product_details',$details_product)->with('relate',$related_product);  
        }

     public function see_product($id)
     {
     $see_product = DB::table('tbl_product')
      ->where('category_id','=',$id)
     ->orderby('tbl_product.category_id','desc')->paginate(5);  
     $see_by_id = view('admin.see_product')->with('see_product',$see_product);
     return view('admin.see_product',['see_product'=>$see_product]);
     }
}  