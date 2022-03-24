@extends('layout')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán giỏ hàng</li>
				</ol>
			</div><!--/breadcrums-->
           <div class="review-payment">
				<h2>Xem lại giỏ hàng</h2>
			</div>

		
              <div class="table-responsive cart_info">
				<?php
                $content = Cart::content();  
				?>
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Tên sản phẩm</td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tổng</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($content as $v_content)
						<tr>
							<th class="cart_product">
								<a href=""><img src="{{URL::to('public/upload/product/'.$v_content->options->image)}}" width="20%"  alt=""></a>
							</th>
							<th class="cart_description">
								<h4><a href="">{{$v_content->name}}</a></h4>
							</th>
							<th class="cart_price">
								<p>{{number_format($v_content->price).''.'VND'}}</p>
							</th>
							<th class="cart_quantity">
								<div class="cart_quantity_button">
									<form action="{{URL::to('/update-to-cart')}}" method="post">
								    {{csrf_field()}}
									<input class="cart_quantity_input" type="number" name="cart_quantity" value="{{$v_content->qty}}" autocomplete="off" size="2">
									<input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
									<input type="submit" value="cập nhật" name="update_qty" class="btn btn-default btn-sm">
								</form>
								</div>

							</th>
							<th class="cart_total">
								<p class="cart_total_price">
									<?php
                                     $subtotal = $v_content->price * $v_content->qty;
                                     echo number_format($subtotal).''.'VND';
									?>
								</p>
							</th>
							<th class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
							</th>
						</tr>
			      @endforeach
					</tbody>
				</table>
			</div>
			<h4 style="margin: 40px 0;">Chọn hình thức thanh toán</h4>
			<form method="post" action="{{URL::to('/order-place')}}">  
			{{csrf_field() }}	
			<div class="payment-options">
					<span>
						<label><input name="payment_option" value="1" type="checkbox">Tiền mặt</label>
					</span>
					<span>
						<label><input name="payment_option" value="2" type="checkbox"> ATM</label>
					</span>
					<span>
						<label><input name="payment_option" value="3" type="checkbox"> Ghi nợ</label>
					</span>
					 <input type="submit" value="Đặt hàng" name="send_order_place" class="btn btn-primary  btn-sm" >
					
		</div>
	</form>
		</div>
	</section> <!--/#cart_items-->
	@endsection