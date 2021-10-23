@extends('layouts.front')

@section('styles')
	<style>
		.nice-select .list {
			height: 300px;
			overflow-y: scroll !important;
		}
		.checkout-form-list input[type="number"]{
			background: #ffffff none repeat scroll 0 0;
			border: 1px solid #ebebeb;
			border-radius: 0;
			-webkit-box-shadow: 0 0px 2px rgba(0, 0, 0, 0.075);
			box-shadow: 0 0px 2px rgba(0, 0, 0, 0.075);
			height: 35px;
			padding: 0 0 0 10px;
			width: 100%;
        }
        
        .col-2 #content {
            width: 100%;
        }

        .your-order {
    background: #f2f2f2 none repeat scroll 0 0;
    padding: 30px 40px 45px;
}
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
}
.your-order-table table {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    width: 100%;
}
.your-order-table table th {
    border-top: medium none;
    font-family: Montserrat, Arial, Helvetica, sans-serif;
    font-weight: normal;
    text-align: center;
    text-transform: uppercase;
    vertical-align: middle;
    white-space: nowrap;
    width: 250px;
    font-weight: 600;
}
.your-order-table table th, .your-order-table table td {
    border-bottom: 1px solid #d8d8d8;
    border-right: medium none;
    font-size: 14px;
    padding: 15px 0;
    text-align: center;
}
.your-order h3 {
    border-bottom: 1px solid #ebebeb;
    font-size: 24px;
    margin: 0 0 20px;
    padding-bottom: 10px;
    text-transform: uppercase;
    width: 100%;
    font-weight: 600;
}

.checkbox-form > h3 {
    border-bottom: 1px solid #ebebeb;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 30px;
    padding-bottom: 10px;
    text-transform: uppercase;
}

.checkout-form-list input[type="text"], .checkout-form-list input[type="password"], .checkout-form-list input[type="email"] {
    background: #ffffff none repeat scroll 0 0;
    border: 1px solid #ebebeb;
    border-radius: 0;
    -webkit-box-shadow: 0 0px 2px rgba(0, 0, 0, 0.075);
    box-shadow: 0 0px 2px rgba(0, 0, 0, 0.075);
    height: 35px;
    padding: 0 0 0 10px;
    width: 100%;
}

.checkbox-form input {
    color: #626262;
}

.country-select select{
    height: 37px;
    line-height: 35px;
    display:block;
    width:100%;
}
.mb-30 {
    margin-bottom: 20px;
}
#ship-box-info{
    display:none;
}
.btn-block{
    margin-top:5%;
    width:100%;
}
	</style>
@endsection


@section('content')
 

  <!-- Breadcrumb Area Start Here -->
  <div class="breadcrumb-area">
            <div class="container">
                <ol class="breadcrumb breadcrumb-list">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </div>
        </div>
        <!-- Breadcrumb Area End Here -->
        


        <!-- checkout-area start -->
        <div class="checkout-area white-bg pb-90 pt-90">
            <div class="container">
			<form id="" action="{{ route('paypal.submit') }}" method="POST" class="checkout-form">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="checkbox-form mb-sm-40">
                            <h3>Billing Details</h3>
                            <div class="row">
                            <div class="col-md-12">
                                <p style="display:none" id="card_error_msg" class="alert alert-danger">Please fill all the mendatory fields first</p>
                                @include('includes.form-success')
                                @include('includes.form-error')
                            </div>

							{{ csrf_field() }}

                                <div class="col-md-12">
                                    <div class="country-select clearfix mb-30">
                                        <label>Country <span class="required">*</span></label>
										<select id="cun" class="wide" name="customer_country" required>
											@include('includes.countries')
										</select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list mb-30">
                                        <label>Name <span class="required">*</span></label>
										<input type="text" id="checkout_user_name" name="name" value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->name : '' }}" required/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list mb-30">
                                        <label>Company Name</label>
										<input type="text" name="company_name" value="{{old('company_name')}}" required/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Address <span class="required">*</span></label>
										<input type="text" id="checkout_user_address" name="address" placeholder="{{ $langg->lang155 }}" required
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->address : '' }}" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list mb-30">
										<input placeholder="Apartment, suite, unit etc." name="street_adrress" value="{{old('street_address1')}}" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list mb-30">
                                        <label>Town / City <span class="required">*</span></label>
										<input type="text" id="checkout_user_city" name="city" placeholder="{{ $langg->lang158 }}" required
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->city : '' }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-30">
                                        <label>State / County <span class="required">*</span></label>
                                        <input type="text" id="checkout_user_state" name="state" value="{{ old('state') }}" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-30">
                                        <label>Postcode / Zip <span class="required">*</span></label>
                                        <input type="text" id="zip" type="text" name="zip" placeholder="{{ $langg->lang159 }}" required="" value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->zip : '' }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-30">
                                        <label>Email Address <span class="required">*</span></label>
										<input type="text" id="checkout_user_email" name="email" placeholder="{{ $langg->lang154 }}" required
															value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->email : '' }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-30">
                                        <label>Phone <span class="required">*</span></label>
										<input type="number" id="checkout_user_phone" name="phone" placeholder="{{ $langg->lang153 }}" required
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->phone : '' }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="different-address">
                                <div class="ship-different-title">
                                    <h3>
                                        <label>Ship to a different address?</label>
                                        <input id="ship-box" type="checkbox" />
                                    </h3>
                                </div>
                                <div id="ship-box-info">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="country-select clearfix mb-30">
                                                <label>Country <span class="required">*</span></label>
												<select id="shipping_cun" class="wide" name="shipping_country" required>
													@include('includes.countries')
												</select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkout-form-list mb-30">
                                                <label>Name <span class="required">*</span></label>
												<input type="text" name="shipping_name" value="{{old('shipping_name')}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="checkout-form-list mb-30">
                                                <label>Address <span class="required">*</span></label>
												<input type="text" name="shipping_address" value="{{old('shipping_address')}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="checkout-form-list mb-30">
                                                <label>Town / City <span class="required">*</span></label>
												<input type="text" name="shipping_city" value="{{old('shipping_city')}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkout-form-list mb-30">
                                                <label>Postcode / Zip <span class="required">*</span></label>
												<input type="text" name="shipping_zip" value="{{old('shipping_zip')}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkout-form-list mb-30">
                                                <label>Email Address <span class="required">*</span></label>
												<input type="email" name="shipping_email" value="{{old('shipping_email')}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkout-form-list mb-30">
                                                <label>Phone <span class="required">*</span></label>
												<input type="number" name="shipping_phone" value="{{old('shipping_phone')}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-notes">
                                        <div class="checkout-form-list">
                                            <label>Order Notes</label>
                                            <textarea name="order_note" id="checkout-mess" cols="30" rows="10" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="your-order">
                            <h3>Your order</h3>
                            <div class="your-order-table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product</th>
                                            <th class="product-total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@php
									$discount = 0;
									@endphp

                                    @if($products)
									@foreach($products as $product)
									@php
									$discount = $discount + App\Models\Product::find($product['item']['id'])->dsc_amt;
									@endphp
                                        <tr class="cart_item">
                                            <td class="product-name">
											{{ str_limit($product['item']['name'] , 20) }} <span class="product-quantity"> × {{ $product['qty'] }}</span>
                                            </td>
                                            <td class="product-total">
                                                <span class="amount">{{ App\Models\Product::convertPrice($product['price']) }}</span>
                                            </td>
                                        </tr>

									@endforeach
                                    @endif 
                                    
                                    @if(isset(Session::get('cart')->offers))
                                    @foreach(Session::get('cart')->offers as $offer)
                                        <tr class="cart_item">
                                        @php 
                                            $offr = \App\Models\Offer::query()->where("id",$offer['id'])->first();
                                        @endphp                        
                                            <td class="product-name">
                                            {{ str_limit($offr->name , 20) }} <span class="product-quantity"> × {{ $offer['qty'] }}</span>
                                            </td>
                                            <td class="product-total">
                                                <span class="amount">{{ $offr->showPrice() }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif

                                    </tbody>
                                    <tfoot>
                                        <tr class="cart-subtotal">
                                            <th>Cart Subtotal</th>
                                            <td><span class="amount">{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}</span></td>
                                        </tr>
                                        <tr class="cart-subtotal">
                                        @php 
                                            if($gs->tax != 0)
                                            {
                                                if(Session::has('cart')){
                                                    $total = Session::get('cart')->totalPrice;
                                                }
                                                $tax = ($total / 100) * $gs->tax;
                                            }
                                        @endphp
                                            <th>Tax</th>
                                            <td><span class="amount">{{ App\Models\Product::convertPrice($tax) }}</span></td>
                                        </tr>
                                        <tr class="discount">
                                            <input type="hidden" id="inbuild_discount" value="{{ App\Models\Product::convertOnlyPrice($discount) }}">
                                            <th>Discount <small>(In Build)</small></th>
                                            <td>
                                            <span class="amount">{{ App\Models\Product::convertPrice($discount) }}</span> 
                                            </td>
                                        </tr>

										@if(Session::has('coupon'))							
										<tr class="discount">
                                            <th>Discount <small>(Coupon)</small></th>
                                            <td><span class="amount">{{ $curr->sign }}{{ Session::get('coupon')}}</span></td>
                                        </tr>
										@endif


						@if(Session::has('coupon_total'))
							@php 
							$d = App\Models\Product::convertOnlyPrice($discount);					
							$t = $totalPrice - $d;
							@endphp

								@if($gs->currency_format == 0)
								<tr class="order-total">
									<th>Order Total</th>
									<td><span id="alltotal" class=" total amount">{{ $curr->sign }}{{ round($t , 2) }}</span>
									</td>
								</tr>

								@endif								
						@elseif(Session::has('coupon_total1'))
								<tr class="order-total">
									<th>Order Total</th>
									<td><span id="alltotal" class=" total amount">{{ round(Session::get('coupon_total1') - $discount , 2) }}</span>
									</td>
								</tr>

								@else
								<tr class="order-total">
									<th>Order Total</th>
									<td><span id="alltotal" class="total amount">{{$curr->sign}}{{ round($totalPrice - ($discount * $curr->value) , 2) }}</span>
									</td>
								</tr>

						@endif

                                    </tfoot>
                                </table>
                            </div>


                            {{-- Shipping Method Area Start --}}
						<div class="packeging-area mt-5">
								<h3 style="margin-top:5%;" class="title mb-3">{{ $langg->lang765 }}</h3>

                                @foreach($shipping_data as $key => $data)

                                @if($products)
                                @php $pr=0; @endphp
                                @foreach($products as $product)
                                    @php 
                                        $prod = \App\Models\Product::query()->where("id",$product['item']['id'])->first();
                                        if($prod->shipping && isset(explode(',',$prod->shipping)[$key])){
                                            $pr = $pr + ($product['qty'] * explode(',',$prod->shipping)[$key]);
                                        }
                                    @endphp                        
                                @endforeach
                                @php $ttt =  Session::has('cart') ? App\Models\Product::convertOnlyPrice(Session::get('cart')->totalPrice) : '0.00'; 
                                    if($ttt > $gs->delivery_free){
                                        $pr = 0;
                                    }
                                @endphp
                                @endif						

								<div class="radio-design">
                                        <input type="radio" class="shipping" id="free-shepping{{ $data->id }}" name="shipping" value="{{round($pr * $curr->value,2)}}" {{ ($loop->first) ? 'checked' : '' }}> 
										<span class="checkmark"></span>
										<label for="free-shepping{{ $data->id }}"> 
												{{ $data->title }}
                                                + {{ $curr->sign }}{{round($pr * $curr->value,2)}}
												<small>{{ $data->subtitle }}</small>
										</label>
								</div>

							@endforeach		

						</div>
						{{-- Shipping Method Area End --}}


                            <div class="payment-method">
                                <!-- <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingone">
                                            <h5 class="mb-0">
                                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Direct Bank Transfer
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingone" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Make your payment directly into our bank account. Please use your
                                                    Order ID as the payment reference. Your order won’t be shipped until
                                                    the funds have cleared in our account.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingtwo">
                                            <h5 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Cheque Payment
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingtwo" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Please send your cheque to Store Name, Store Street, Store Town,
                                                    Store State / County, Store Postcode.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingthree">
                                            <h5 class="mb-0">
                                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    PayPal
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingthree" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a
                                                    PayPal account.</p>
                                            </div>
                                        </div> -->

							<input type="hidden" id="shipping-cost" name="shipping_cost" value="0">
                            <input type="hidden" id="packing-cost" name="packing_cost" value="0">
                            <input type="hidden" name="dp" value="{{$digital}}">
                            <input type="hidden" name="tax" value="{{$gs->tax}}">
                            <input type="hidden" name="totalQty" value="{{$totalQty}}">

                            <input type="hidden" name="vendor_shipping_id" value="{{ $vendor_shipping_id }}">
                            <input type="hidden" name="vendor_packing_id" value="{{ $vendor_packing_id }}">


							@if(Session::has('coupon_total'))
                            	<input type="hidden" name="total" id="grandtotal" value="{{ $totalPrice }}">
                            	<input type="hidden" id="tgrandtotal" value="{{ $totalPrice }}">
							@elseif(Session::has('coupon_total1'))
								<input type="hidden" name="total" id="grandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
								<input type="hidden" id="tgrandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
							@else
                            	<input type="hidden" name="total" id="grandtotal" value="{{$totalPrice}}">
                            	<input type="hidden" id="tgrandtotal" value="{{$totalPrice}}">
							@endif


                            <input type="hidden" name="coupon_code" id="coupon_code" value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
                            <input type="hidden" name="coupon_discount" id="coupon_discount" value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
                            <input type="hidden" name="coupon_id" id="coupon_id" value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->id : '' }}">


                                    <!-- </div>
                                </div> -->
							<button class="mt-5 btn btn-danger btn-block" id="final-btn" type="submit">Pay With Paypal</button>
							<br>
							<button type="button" id="final-btn-card" class="mt-5 btn btn-danger btn-block">Pay With Debit/Credit Card</button>
                            </div>
                        </div>
                    </div>
                </div>
   			  </form>
	        </div>
        </div>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog" style="z-index:1111111">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Pay with Debot/Credit Card</h4>
                </div>
                
                 <form method="post" action="https://wetfire.co.uk/pay-with-card/process.php?amount={{$totalPrice}}&return_url=https://wetfire.co.uk/checkout/payment/return-card-payment">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Card Holder Name</label><br>
                                    <!--4012001037141112-->
                                    <input type="text" class="form-control" required name="CardHolder" placeholder="John Doe" value=""><br>
                                </div>
                                <div class="form-group">
                                    <label>Card Number</label><br>
                                    <input type="text" class="form-control" required name="CardNumber" placeholder="4012**********" value=""><br>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Expiration Month</label><br>
                                            <select class="form-control" name="exp_month">
                                                <option value="0" selected disabled>Select Here</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Expiration Year</label><br>
                                            <select class="form-control" name="exp_year">
                                                <option value="0" selected disabled>Select Here</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-4">
                                            <label>CVV</label><br>
                                            <input type="text" class="form-control" required name="CVV" value="" placeholder="123"><br>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Total Amount<br>
                                    <input type="hidden" readonly class="form-control" name="customerName" id="customerName" value="">
                                    <input type="hidden" readonly class="form-control" name="customerEmail" id="customerEmail" value="">
                                    <input type="hidden" readonly class="form-control" name="customerAddress" id="customerAddress" value="">
                                    <input type="hidden" readonly class="form-control" name="customerPostCode" id="customerPostCode" value="">
                                    <input type="hidden" readonly class="form-control" name="Amount" value="{{round($totalPrice, 0)}}">
                                    <input type="text" readonly class="form-control" name="FrontAmount" value="{{$totalPrice}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button style="width:100%" type="submit" class="btn btn-success"><i class="fa fa-lock"></i> Pay Now</button>
                      <br>
                      <div class="row">
                            <div class="col-md-12" style="margin-top: 15px;">
                                <div class="">
                                    <ul style="display: flex;float: right;list-style: none;text-align: center;">
                                        <li style="margin-right: 10px;" class="mastero"><a href="#"><img alt="" src="public/assets/front/image/payment/mastero.jpg"></a></li>
                                        <li style="margin-right: 10px;" class="visa"><a href="#"><img alt="" src="public/assets/front/image/payment/visa.jpg"></a></li>
                                        <li style="margin-right: 10px;" class="currus"><a href="#"><img alt="" src="public/assets/front/image/payment/currus.jpg"></a></li>
                                        <li style="margin-right: 10px;" class="discover"><a href="#"><img alt="" src="public/assets/front/image/payment/discover.jpg"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        <!-- checkout-area end -->
@endsection
@section('scripts')
@section('scripts')

<script src="https://js.paystack.co/v1/inline.js"></script>


<script type="text/javascript">

$("#final-btn-card").click(function(){
    var checkout_user_name = $("#checkout_user_name").val();
    var checkout_user_address = $("#checkout_user_address").val();
    var checkout_user_city = $("#checkout_user_city").val();
    var checkout_user_state = $("#checkout_user_state").val();
    var zip = $("#zip").val();
    var checkout_user_email = $("#checkout_user_email").val();
    var checkout_user_phone = $("#checkout_user_phone").val();
    
    if(checkout_user_name == '' || checkout_user_address == '' || checkout_user_city == '' || checkout_user_state == '' || zip == '' || checkout_user_email == '' || checkout_user_phone == ''){
        $("#card_error_msg").show();
        $('html, body').animate({
            scrollTop: $("#card_error_msg").offset().top
        }, 500);
    }else{
        $("#card_error_msg").hide();
        var customerName = $("#customerName").val(checkout_user_name)
        var customerEmail = $("#customerEmail").val(checkout_user_email)
        var customerAddress = $("#customerAddress").val(checkout_user_address)
        var customerPostCode = $("#customerPostCode").val(zip)
        $('#myModal').modal('show');
    }
})

	$('a.payment:first').addClass('active');
	$('.checkout-form').prop('action',$('a.payment:first').data('form'));
	$($('a.payment:first').attr('href')).load($('a.payment:first').data('href'));


		var show = $('a.payment:first').data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
	$($('a.payment:first').attr('href')).addClass('active').addClass('show');
	
		   $('.submit-loader').hide();


var coup = 0;
var pos = {{ $gs->currency_format }};

@if(isset($checked))

	$('#comment-log-reg1').modal('show');

@endif

var mship = $('.shipping').length > 0 ? $('.shipping').first().val() : 0;
var mpack = $('.packing').length > 0 ? $('.packing').first().val() : 0;

mship = parseFloat(mship);
mpack = parseFloat(mpack);

$('#shipping-cost').val(mship);
$('#packing-cost').val(mpack);
var ftotal = parseFloat($('#grandtotal').val()) + mship + mpack;
ftotal = parseFloat(ftotal);
      if(ftotal % 1 != 0)
      {
        ftotal = ftotal.toFixed(2);
      }
		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ftotal)
		}
		else{
			$('#final-cost').html(ftotal+'{{ $curr->sign }}')
        }
        
$('#grandtotal').val(ftotal);

$('#shipop').on('change',function(){

	var val = $(this).val();
	if(val == 'pickup'){
		$('#shipshow').removeClass('d-none');
		$("#ship-diff-address").parent().addClass('d-none');
        $('.ship-diff-addres-area').addClass('d-none');  
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);  
	}
	else{
		$('#shipshow').addClass('d-none');
		$("#ship-diff-address").parent().removeClass('d-none');
        $('.ship-diff-addres-area').removeClass('d-none');  
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true); 
	}

});


$('.shipping').on('click',function(){
	mship = $(this).val();

$('#shipping-cost').val(mship);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal).toFixed(2);
      if(ttotal % 1 != 0)
      {
        ttotal = parseFloat(ttotal).toFixed(2);
      }
		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+parseFloat(ttotal).toFixed(2));
		}
		else{
			$('#final-cost').html(parseFloat(ttotal).toFixed(2)+'{{ $curr->sign }}');
		}
	
    var inbuild_discount = $('#inbuild_discount').val();
    var ttt = parseFloat(ttotal).toFixed(2) - parseFloat(inbuild_discount).toFixed(2);
    $('#alltotal').text('{{ $curr->sign }}' + parseFloat(ttt).toFixed(2));

})

$('.packing').on('click',function(){
	mpack = $(this).val();
$('#packing-cost').val(mpack);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }

		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ttotal);
		}
		else{
			$('#final-cost').html(ttotal+'{{ $curr->sign }}');
		}	

$('#grandtotal').val(ttotal);
		
})

    $("#check-coupon-form").on('submit', function () {
        var val = $("#code").val();
        var total = $("#grandtotal").val();
        var ship = 0;
            $.ajax({
                    type: "GET",
                    url:mainurl+"/carts/coupon/check",
                    data:{code:val, total:total, shipping_cost:ship},
                    success:function(data){
                        if(data == 0)
                        {
                        	toastr.error(langg.no_coupon);
                            $("#code").val("");
                        }
                        else if(data == 2)
                        {
                        	toastr.error(langg.already_coupon);
                            $("#code").val("");
                        }
                        else
                        {
                            $("#check-coupon-form").toggle();
                            $(".discount-bar").removeClass('d-none');

							if(pos == 0){
								$('#total-cost').html('{{ $curr->sign }}'+data[0]);
								$('#discount').html('{{ $curr->sign }}'+data[2]);
							}
							else{
								$('#total-cost').html(data[0]+'{{ $curr->sign }}');
								$('#discount').html(data[2]+'{{ $curr->sign }}');
							}
								$('#grandtotal').val(data[0]);
								$('#tgrandtotal').val(data[0]);
								$('#coupon_code').val(data[1]);
								$('#coupon_discount').val(data[2]);
								if(data[4] != 0){
								$('.dpercent').html('('+data[4]+')');
								}
								else{
								$('.dpercent').html('');									
								}


var ttotal = parseFloat($('#grandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }

		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ttotal)
		}
		else{
			$('#final-cost').html(ttotal+'{{ $curr->sign }}')
		}	

                        	toastr.success(langg.coupon_found);
                            $("#code").val("");
                        }
                      }
              }); 
              return false;
    });

// Password Checking

        $("#open-pass").on( "change", function() {
            if(this.checked){
             $('.set-account-pass').removeClass('d-none');  
             $('.set-account-pass input').prop('required',true); 
             $('#personal-email').prop('required',true);
             $('#personal-name').prop('required',true);
            }
            else{
             $('.set-account-pass').addClass('d-none');   
             $('.set-account-pass input').prop('required',false); 
             $('#personal-email').prop('required',false);
             $('#personal-name').prop('required',false);

            }
        });

// Password Checking Ends


// Shipping Address Checking

		$("#ship-diff-address").on( "change", function() {
            if(this.checked){
             $('.ship-diff-addres-area').removeClass('d-none');  
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true); 
            }
            else{
             $('.ship-diff-addres-area').addClass('d-none');  
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);  
            }
            
        });


// Shipping Address Checking Ends


</script>


<script type="text/javascript">
var ck = 0;

	$('.checkout-form').on('submit',function(e){
		if(ck == 0) {
			e.preventDefault();			
		$('#pills-step2-tab').removeClass('disabled');
		$('#pills-step2-tab').click();

	}else {
		$('#preloader').show();
	}
	$('#pills-step1-tab').addClass('active');
	});

	$('#step1-btn').on('click',function(){
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step2-tab').addClass('disabled');
		$('#pills-step3-tab').addClass('disabled');

		$('#pills-step1-tab').click();

	});

// Step 2 btn DONE

	$('#step2-btn').on('click',function(){
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').addClass('disabled');
		$('#pills-step2-tab').click();
		$('#pills-step1-tab').addClass('active');

	});

	$('#step3-btn').on('click',function(){
	 	if($('a.payment:first').data('val') == 'paystack'){
			$('.checkout-form').prop('id','step1-form');
		}
		else {
			$('.checkout-form').prop('id','');
		}
		$('#pills-step3-tab').removeClass('disabled');
		$('#pills-step3-tab').click();

		var shipping_user  = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $('input[name="shipping_name"]').val();
		var shipping_location  = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $('input[name="shipping_address"]').val();
		var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $('input[name="shipping_phone"]').val();
		var shipping_email= !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $('input[name="shipping_email"]').val();

		$('#shipping_user').html('<i class="fas fa-user"></i>'+shipping_user);
		$('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>'+shipping_location);
		$('#shipping_phone').html('<i class="fas fa-phone"></i>'+shipping_phone);
		$('#shipping_email').html('<i class="fas fa-envelope"></i>'+shipping_email);

		$('#pills-step1-tab').addClass('active');
		$('#pills-step2-tab').addClass('active');
	});

	$('#final-btn').on('click',function(){
		ck = 1;
	})


	$('.payment').on('click',function(){
	    
      $('.submit-loader').show();
		if($(this).data('val') == 'paystack'){
			$('.checkout-form').prop('id','step1-form');
		}
		else {
			$('.checkout-form').prop('id','');
		}
		$('.checkout-form').prop('action',$(this).data('form'));
		$('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
		var show = $(this).data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
		$($(this).attr('href')).load($(this).data('href'), function() {
            $('.submit-loader').hide();
        });		  
	})

        $(document).on('submit','#step1-form',function(){
        	$('#preloader').hide();
            var val = $('#sub').val();
            var total = $('#grandtotal').val();
			total = Math.round(total);
                if(val == 0)
                {
                var handler = PaystackPop.setup({
                  key: '{{$gs->paystack_key}}',
                  email: $('input[name=email]').val(),
                  amount: total * 100,
                  currency: "{{$curr->name}}",
                  ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                  callback: function(response){
                    $('#ref_id').val(response.reference);
                    $('#sub').val('1');
                    $('#final-btn').click();
                  },
                  onClose: function(){
                  	window.location.reload();
                  	
                  }
                });
                handler.openIframe();
                    return false;                    
                }
                else {
                	$('#preloader').show();
                    return true;   
                }
        });

    $('#ship-box').on('click', function () {
        $('#ship-box-info').slideToggle();
    });
</script>
@endsection