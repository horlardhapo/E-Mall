@extends('admin_layout')
@section('admin_content')

          	<div class="row-fluid sortable">
				<div class="box span6">
					<div class="box-header">
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>Customer Details</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table">
							  <thead>
								  <tr>
									  <th>Username</th>
									  <th>Mobile </th>
									                                          
								  </tr>
							  </thead>   
							  <tbody>
							  	@foreach($order_by_id as $v_order)
								@endforeach
								<tr> 
									   
									<td>{{$v_order->customer_name}}</td>
									<td class="center">{{$v_order->mobile_number}}</td>	
									                                       
								</tr>
							                                
							  </tbody>
						 </table>  
						     
					</div>
				</div><!--/span-->
				
				<div class="box span6">
					<div class="box-header">
						<h2><i class="halflings-icon align-justify"></i><span class="break"></span>Shipping Details </h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped">
							  <thead>
								  <tr>
									  <th>Username</th>
									  <th>Address </th> 
									  <th>Mobile</th>
									  <th>Email</th>
									                                          
								  </tr>
							  </thead>   
							  <tbody>
							  	@foreach($order_by_id as $v_order)
							  	@endforeach 
								<tr>									
								<td>{{$v_order->shipping_firstname}}</td>
								<td class="center">{{$v_order->shipping_address}}</td>
								<td class="center">{{$v_order->shipping_mobile}}</td>
								<td class="center">{{$v_order->shipping_email}}</td>									                                       
								</tr>
								
							                                  
							  </tbody>
						 </table>  
						    
					</div>
				</div><!--/span-->
			</div><!--/row-->
			
			<!-- start: Content -->				
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Orders Details</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered ">
						  <thead>
							  <tr>
							  	 <th> Order Id</th>
								  <th>Product Name</th>
								  <th>Product Price</th>
								  <th>Product Sales Quantity </th>
								  <th>Product Sub Total</th>
							
							  </tr>
						  </thead> 

						<tbody>   
						@foreach($order_by_id as $v_order)
						<tr>					  							  	
						<td>{{$v_order->order_id}}</td>
						<td>{{$v_order->product_name}}</td>
						<td>{{$v_order->product_price}} </td>
						<td>{{$v_order->product_sales_quantity}} </td>
						<td>{{$v_order->product_price*$v_order->product_sales_quantity}}</td>
					   </tr>
					   @endforeach 

						</tbody>
						<tfoot>
							<td colspan="4">Total with vat: </td>
						  	<td><strong> {{$v_order->order_total}} $</strong></td>
						</tfoot>
						 </table>  
						     
					</div>
				</div><!--/span-->
			</div><!--/row-->
		

@endsection