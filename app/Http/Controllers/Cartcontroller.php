<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class Cartcontroller extends Controller
{
    public function save_cart(Request $Request){
    
    	$productID = $Request->productid_hidden;
    	$quantity = $Request->qty;
        $product_info = DB::table('tbl_product')->where('product_id',$productID)->first();
        //Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] ='123';
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        return Redirect::to('/show-cart');

    	return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product);

    }
    public function show_cart(){
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
    $brand_product = DB::table('tbl_band_product')->where('brand_status','0')->orderby('brand_id','desc')->get();    
    return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product);

    }
    public function delete_to_cart($rowId){
      cart::update($rowId,0);
      return Redirect::to('/show-cart');

    }
    public function update_to_cart(Request $Request){
        $rowId = $Request->rowId_cart;
        $qty   = $Request->cart_quantity;
        cart::update($rowId,$qty);
        return Redirect::to('/show-cart');

    }
}
