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

			<div class="register-req">
				<p>Đăng kí hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Điền thông tin giao hàng</p>
							<div class="form-one">
								<form action="{{URL::to('/save-checkout-customer')}}" method="post">
									{{csrf_field()}}
									<input type="text" name="shopping_name" placeholder="Họ và tên">
									<input type="text" name="shopping_email" placeholder="Email">
									<input type="text" name="shopping_address" placeholder="Địa chỉ">
					                <input type="text" name="shopping_phone" placeholder="Số điện thoại">
					                <textarea  name="shopping_note" placeholder="ghi chú gửi hàng" rows="16"></textarea>
					                <input type="submit" value="Xác nhận" name="send_order" class="btn btn-primary  btn-sm" >
								</form>
							</div>
							<div class="form-two">
								
							</div>
						</div>
					</div>
					
					</div>					
				</div>
			</div>
			<div class="review-payment">
				<h2><a href="{{URL::to('/show-cart')}}">Xem lại giỏ hàng</a></h2>
			</div>

			
			
		</div>
	</section> <!--/#cart_items-->
	@endsection