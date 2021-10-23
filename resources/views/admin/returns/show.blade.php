@extends('layouts.admin')
     
@section('styles')

<style type="text/css">
    .order-table-wrap table#example2 {
    margin: 10px 20px;
}
    .btn.sendEmail , .btn.sendEmail:hover {
        background: #c82333;
        color: #fff;
    }
</style>

@endsection


@section('content')
    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('Order Details') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Return Order') }}</a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Order#') }}{{ $order->id }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>

                        <div class="order-table-wrap">
                            @include('includes.admin.form-both')
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                            {{ __('Returning Reason') }}
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('Reason ID') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">#{{$data->id}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('User Name') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$data->user->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('Reason') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{ $data->reason }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('Details') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{!! $data->details !!}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                            @php $images = json_decode($data->images) @endphp
                                            @if($images)
                                            @foreach($images as $image)
                                            <div class="col-md-4 mt-2 mb-2">
                                                <a href="{{ asset('public/assets/images/returns/'.$image) }}">                                                
                                                    <img src="{{ asset('public/assets/images/returns/'.$image) }}" class="img" alt="">
                                                </a>
                                            </div>
                                            @endforeach
                                            @endif
                                            </div>
                                        </div>
                                        <div class="mt-3 footer-area">
                                            @if($order->status == 'declined')
                                            <button disabled class="btn btn-block btn-danger"> {{ __('Order Canceled') }}</button>
                                            @else
                                            <a href="{{ route('admin-return_order-reason' , $order->id) }}" class="btn btn-success"> {{ __('Accept') }}</a>
                                            <a class="btn btn-danger sendEmail send ml-3" href="javascript:;" data-email="{{ $order->customer_email }}" data-toggle="modal" data-target="#vendorform">
                                                 {{ __('Reject & Send Email') }}
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                            {{ __('Order Details') }}
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('Order ID') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">{{$order->order_number}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('Total Product') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->totalQty}}</td>
                                                </tr>
                                                @if($order->shipping_cost != 0)
                                                @php 
                                                $price = round(($order->shipping_cost / $order->currency_value),2);
                                                @endphp
                                                @if(DB::table('shippings')->where('price','=',$price)->count() > 0)
                                                <tr>
                                                    <th width="45%">{{ DB::table('shippings')->where('price','=',$price)->first()->title }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{ $order->currency_sign }}{{ round($order->shipping_cost, 2) }}</td>
                                                </tr>
                                                @endif
                                                @endif
                                                @if($order->packing_cost != 0)
                                                @php 
                                                $pprice = round(($order->packing_cost / $order->currency_value),2);
                                                @endphp
                                                @if(DB::table('packages')->where('price','=',$pprice)->count() > 0)
                                                <tr>
                                                    <th width="45%">{{ DB::table('packages')->where('price','=',$pprice)->first()->title }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{ $order->currency_sign }}{{ round($order->packing_cost, 2) }}</td>
                                                </tr>
                                                @endif
                                                @endif

                                                <tr>
                                                    <th width="45%">{{ __('Total Cost') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('Ordered Date') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{date('d-M-Y H:i:s a',strtotime($order->created_at))}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('Payment Method') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->method}}</td>
                                                </tr>
                
                                                @if($order->method != "Cash On Delivery")
                                                @if($order->method=="Stripe")
                                                <tr>
                                                    <th width="45%">{{$order->method}} {{ __('Charge ID') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->charge_id}}</td>
                                                </tr>                        
                                                @endif
                                                <tr>
                                                    <th width="45%">{{$order->method}} {{ __('Transaction ID') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->txnid}}</td>
                                                </tr>                         
                                                @endif

                                                <tr>
                                                    <th width="45%">{{ __('Payment Status') }}</th>
                                                    <th width="10%">:</th>
                                                    <td width="45%">{!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>Unpaid</span>":"<span class='badge badge-success'>Paid</span>" !!}</td>
                                                </tr>  
                                                @if(!empty($order->order_note))
                                                <tr>
                                                    <th width="45%">{{ __('Order Note') }}</th>
                                                    <th width="10%">:</th>
                                                    <td width="45%">{{$order->order_note}}</td>
                                                </tr>  
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="footer-area">
                                            <a href="{{ route('admin-order-invoice',$order->id) }}" class="mybtn1"><i class="fas fa-eye"></i> {{ __('View Invoice') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                            {{ __('Billing Details') }}
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <table class="table">
                                                <tbody>
                                                        <tr>
                                                            <th width="45%">{{ __('Name') }}</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{$order->customer_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">{{ __('Email') }}</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{$order->customer_email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">{{ __('Phone') }}</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{$order->customer_phone}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">{{ __('Address') }}</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{$order->customer_address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">{{ __('Country') }}</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{$order->customer_country}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">{{ __('City') }}</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{$order->customer_city}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">{{ __('Postal Code') }}</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{$order->customer_zip}}</td>
                                                        </tr>
                            @if($order->coupon_code != null)
                            <tr>
                                <th width="45%">{{ __('Coupon Code') }}</th>
                                <th width="10%">:</th>
                                <td width="45%">{{$order->coupon_code}}</td>
                            </tr>
                            @endif
                            @if($order->coupon_discount != null)
                            <tr>
                                <th width="45%">{{ __('Coupon Discount') }}</th>
                                <th width="10%">:</th>
                                @if($gs->currency_format == 0)
                                <td width="45%">{{ $order->currency_sign }}{{ $order->coupon_discount }}</td>
                                @else 
                                <td width="45%">{{ $order->coupon_discount }}{{ $order->currency_sign }}</td>
                                @endif
                            </tr>
                            @endif
                            @if($order->affilate_user != null)
                            <tr>
                                <th width="45%">{{ __('Affilate User') }}</th>
                                <th width="10%">:</th>
                                <td width="45%">{{$order->affilate_user}}</td>
                            </tr>
                            @endif
                            @if($order->affilate_charge != null)
                            <tr>
                                <th width="45%">{{ __('Affilate Charge') }}</th>
                                <th width="10%">:</th>
                                @if($gs->currency_format == 0)
                                <td width="45%">{{ $order->currency_sign }}{{$order->affilate_charge}}</td>
                                @else 
                                <td width="45%">{{$order->affilate_charge}}{{ $order->currency_sign }}</td>
                                @endif
                            </tr>
                            @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                @if($order->dp == 0)
                                <div class="col-lg-6">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                            {{ __('Shipping Details') }}
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <table class="table">
                                                <tbody>
                            @if($order->shipping == "pickup")
                        <tr>
                                    <th width="45%"><strong>{{ __('Pickup Location') }}:</strong></th>
                                    <th width="10%">:</th>
                                    <td width="45%">{{$order->pickup_location}}</td>
                                </tr>
                            @else
                                <tr>
                                    <th width="45%"><strong>{{ __('Name') }}:</strong></th>
                                    <th width="10%">:</th>
                <td>{{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Email') }}:</strong></th>
                                    <th width="10%">:</th>
                <td width="45%">{{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Phone') }}:</strong></th>
                                    <th width="10%">:</th>
                <td width="45%">{{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Address') }}:</strong></th>
                                    <th width="10%">:</th>
                <td width="45%">{{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Country') }}:</strong></th>
                                    <th width="10%">:</th>
                <td width="45%">{{$order->shipping_country == null ? $order->customer_country : $order->shipping_country}}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('City') }}:</strong></th>
                                    <th width="10%">:</th>
                <td width="45%">{{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Postal Code') }}:</strong></th>
                                    <th width="10%">:</th>
                <td width="45%">{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}</td>
                                </tr>
                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>



                            <div class="row">
                                    <div class="col-lg-12 order-details-table">
                                        <div class="mr-table">
                                            <h4 class="title">{{ __('Products') }}</h4>
                                            <div class="table-responsiv">
                                                    <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                        <thead>
                                <tr>
                                    <th width="10%">{{ __('Product ID#') }}</th>
                                    <th width="20%">{{ __('Shop Name') }}</th>
                                    <th width="20%">{{ __('Product Title') }}</th>
                                    <th width="30%">{{ __('Details') }}</th>
                                    <th width="10%">{{ __('Total Price') }}</th>
                                </tr>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                @if($cart->items)                                
                                @foreach($cart->items as $key => $product)
                                    <tr>
                                        
                                            <td><input type="hidden" value="{{$key}}">{{ $product['item']['id'] }}</td>

                                            <td>
                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                @endphp
                                                @if(isset($user))
                                                <a target="_blank" href="{{route('admin-vendor-show',$user->id)}}">{{$user->shop_name}}</a>
                                                @else
                                                {{ __('Vendor Removed') }}
                                                @endif
                                                @else 
                                                <a  href="javascript:;">{{ App\Models\Admin::find(1)->shop_name }}</a>
                                                @endif

                                            </td>


                                            <td>
                                                <input type="hidden" value="{{ $product['license'] }}">

                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                @endphp
                                                @if(isset($user))
                                              <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                @else
                                                <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                @endif
                                                @else 

                                                <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                            
                                                @endif


                                                @if($product['license'] != '')
                              <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> {{ __('View License') }}</a>
                                                @endif

                                            </td>
                                            <td>
                                                @if($product['size'])
                                               <p>
                                                    <strong>{{ __('Size') }} :</strong> {{str_replace('-',' ',$product['size'])}}
                                               </p>
                                               @endif
                                               @if($product['color'])
                                                <p>
                                                        <strong>{{ __('color') }} :</strong> <span
                                                        style="width: 40px; height: 20px; display: block; background: #{{$product['color']}};"></span>
                                                </p>
                                                @endif
                                                <p>
                                                        <strong>{{ __('Price') }} :</strong> {{$order->currency_sign}}{{ round($product['item']['price'] * $order->currency_value , 2) }}
                                                </p>
                                               <p>
                                                    <strong>{{ __('Qty') }} :</strong> {{$product['qty']}} {{ $product['item']['measure'] }}
                                               </p>
                                                    @if(!empty($product['keys']))

                                                    @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)
                                                    <p>

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} 

                                                    </p>
                                                    @endforeach

                                                    @endif




                                            </td>

                                            <td>{{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }}</td>

                                    </tr>
                                @endforeach
                                @endif
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>




    <div class="col-lg-12 order-details-table">
        <div class="mr-table">
            <h4 class="title">{{ __('Offers') }}</h4>
            <div class="table-responsiv">
                    <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <tr>
                                    <th width="10%">{{ __('Offer ID#') }}</th>
                                    <th width="20%">{{ __('Offer Name') }}</th>
                                    <th width="10%">{{ __('Quantity') }}</th>
                                    <th width="40%">{{ __('Details') }}</th>
                                    <th width="10%">{{ __('Total Price') }}</th>
                                </tr>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                @if($cart->offers)                                
                                @foreach($cart->offers as $offer)
                                    <tr>
                                    @php 
                                        $offr = \App\Models\Offer::query()->where("id",$offer['id'])->first();
                                    @endphp                        
                                            <td>{{ $offer['id'] }}</td>

                                            <td>
                                                {{ $offr->name }}
                                            </td>
                                            <td>
                                                {{ $offer['qty'] }}
                                            </td>


                                            <td>
        
                                            <a target="_blank" class="d-block"
                                                        href="javascript:;">{{mb_strlen($offr->name,'utf-8') > 30 ? mb_substr($offr->name,0,30,'utf-8').'...' : $offr->name}}</a>

                                                    <small><b>Offer Type</b> : @if($offr->type == 0) Buy One/Get One @elseif($offr->type == 1) Special Discount @else Special Quantity @endif</small><br>
                                                    @if($offr->type == 0)
                                                    <small><b>Buying Item</b> : {{$offr->product->name}}</small><br>
                                                    <small><b>Free Item</b> : {{$offr->free->name}}</small>
                                                    @endif
                                                    @if($offr->type == 1)
                                                    <small><b>Original Price</b> : {{ $offr->product->showPrice() }}</small><br>
                                                    <small><b>Special Discount</b> : {{ $offr->discount }}%</small><br>
                                                    @endif
                                                    @if($offr->type == 2)
                                                    <small><b>Product</b> : {{ $offr->product->name }}</small><br>
                                                    <small><b>Original Price</b> : {{ $offr->product->showPrice() }}</small><br>
                                                    <small><b>Discount</b> : {{ $offr->discount_q }}%</small><br>
                                                    <small><b>Quantity</b> : {{ $offr->quantity }}</small><br>
                                                    @endif

                                            </td>

                                            <td>{{$order->currency_sign}}{{ round($offer['price'] * $order->currency_value , 2) }}</td>

                                    </tr>
                                @endforeach
                                @endif
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-lg-12 text-center mt-2">
                                        <a class="btn sendEmail send" href="javascript:;" class="send" data-email="{{ $order->customer_email }}" data-toggle="modal" data-target="#vendorform">
                                                <i class="fa fa-send"></i> {{ __('Send Email') }}
                                        </a>
                                    </div> -->
                                </div>
                        </div>
                    </div>
                    <!-- Main Content Area End -->
                </div>
            </div>


    </div>

{{-- LICENSE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{ __('License Key') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

                <div class="modal-body">
                    <p class="text-center">{{ __('The Licenes Key is') }} :  <span id="key"></span> <a href="javascript:;" id="license-edit">{{ __('Edit License') }}</a><a href="javascript:;" id="license-cancel" class="showbox">{{ __('Cancel') }}</a></p>
                    <form method="POST" action="{{route('admin-order-license',$order->id)}}" id="edit-license" style="display: none;">
                        {{csrf_field()}}
                        <input type="hidden" name="license_key" id="license-key" value="">
                        <div class="form-group text-center">
                    <input type="text" name="license" placeholder="{{ __('Enter New License Key') }}" style="width: 40%; border: none;" required=""><input type="submit" name="submit" class="btn btn-primary" style="border-radius: 0; padding: 2px; margin-bottom: 2px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>


{{-- LICENSE MODAL ENDS --}}

{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __('Send Email') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-form">
                                <form id="emailreply">
                                    {{csrf_field()}}
                                    <ul>
                                        <li>
                                            <input type="email" class="input-field eml-val" id="eml" name="to" placeholder="{{ __('Email') }} *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ __('Subject') }} *" required="">
                                        </li>
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }} *" required=""></textarea>
                                        </li>
                                    </ul>
                                    <!-- <button class="submit-btn" id="emlsub" type="submit">{{ __('Send Email') }}</button> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}

@endsection

