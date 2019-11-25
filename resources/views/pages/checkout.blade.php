@extends('layout')
@section('content')

	<section id="cart_items">
		<div class="container">
		
			<div class="register-req ">
				<p>Please enter your details here...................</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Shipping Informations</p>
							<div class="form-one">
								<form action="{{url('/save-shipping-info')}}" method="post">
									{{ csrf_field() }}
									<input type="email" name="shipping_email" placeholder="Email*">
									<input type="text" name="shipping_firstname" placeholder="First Name *">
									<input type="text" name="shipping_lastname" placeholder="Last Name *">
									<input type="text" name="shipping_address" placeholder="Address 1 *">
									<input type="text" name="shipping_mobile" placeholder="Mobile Number *">
									<input type="text" name="shipping_city" placeholder="City *">
									<input type="submit" name="submit" value="Done" class="btn btn-warning">
								</form>
							</div>
						</div>
					</div>
										
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->



@endsection