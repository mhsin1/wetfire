@extends('layouts.front')
@section('styles')
    <style>
    
        a.link:hover{
            color:#007bff;
        }
        h3{
            margin-top:5%;
            margin-bottom:5%;
            font-size: 20px;
            font-weight:bold;
            text-transform: uppercase;
        }
        h5,h4{
            margin-top:2%;
            margin-bottom:2%;
            font-size: 17px;
            font-weight:bold;
            text-transform: uppercase;
        }
    </style>
@endsection
@section('content')

  <!-- Breadcrumb Area Start Here -->
  <div class="breadcrumb-area">
        <div class="container">
            <ol class="breadcrumb breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Success</li>
            </ol>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->


<section class="tempcart">

@if(!empty($tempcart))

     <!-- checkout-area start -->
     <div class="checkout-area white-bg pb-90 pt-90">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Starting of Dashboard data-table area -->
<div class="content-box section-padding add-product-1">
    <div class="top-area">
            <div class="content">
                <h4 class="heading">
                    {{ $langg->order_title }}
                </h4>
                <p class="text">
                    {{ $langg->order_text }}
                </p>
                <a href="{{ route('front.index') }}" class="link">{{ $langg->lang170 }}</a>
                </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

                <div class="product__header">
                    <div class="row reorder-xs">
                        <div class="col-lg-12">
                            <div class="product-header-title">
                                <h2>{{ $langg->lang285 }} {{$order->order_number}}</h2>
                    </div>   
                </div>
                    @include('includes.form-success')
                        <div class="col-md-12" id="tempview">
                            <div class="dashboard-content">
                                <div class="view-order-page" id="print">
                                    <p class="order-date">{{ $langg->lang301 }} {{date('d-M-Y',strtotime($order->created_at))}}</p>


@if($order->dp == 1)

    <div class="billing-add-area">
        <div class="row">
            <div class="col-md-6">
                <h5>{{ $langg->lang287 }}</h5>
                <address>
                    {{ $langg->lang288 }} {{$order->customer_name}}<br>
                    {{ $langg->lang289 }} {{$order->customer_email}}<br>
                    {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                    {{ $langg->lang291 }} {{$order->customer_address}}<br>
                    {{$order->customer_city}}-{{$order->customer_zip}}
                </address>
            </div>
            <div class="col-md-6">
                <h5>{{ $langg->lang292 }}</h5>
                <p>{{ $langg->lang293 }} {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</p>
                <p>{{ $langg->lang294 }} {{$order->method}}</p>

                @if($order->method != "Cash On Delivery")
                    @if($order->method=="Stripe")
                        {{$order->method}} {{ $langg->lang295 }} <p>{{$order->charge_id}}</p>
                    @endif
                    {{$order->method}} {{ $langg->lang296 }} <p id="ttn">{{$order->txnid}}</p>

                @endif
            </div>
        </div>
    </div>

@else

<div class="billing-add-area mt-5">
    <div class="row">
        <div class="col-md-6">
            <h5>{{ $langg->lang287 }}</h5>
            <address>
                {{ $langg->lang288 }} {{$order->customer_name}}<br>
                {{ $langg->lang289 }} {{$order->customer_email}}<br>
                {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                {{ $langg->lang291 }} {{$order->customer_address}}<br>
                {{$order->customer_city}}-{{$order->customer_zip}}
            </address>
        </div>
        <div class="col-md-6">
            <h5>{{ $langg->lang292 }}</h5>
            <p>{{ $langg->lang293 }} {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</p>
            <p>{{ $langg->lang294 }} {{$order->method}}</p>

            @if($order->method != "Cash On Delivery")
                @if($order->method=="Stripe")
                    {{$order->method}} {{ $langg->lang295 }} <p>{{$order->charge_id}}</p>
                @endif
                @if($order->method=="Paypal")
                {{$order->method}} {{ $langg->lang296 }} <p id="ttn">{{ isset($_GET['tx']) ? $_GET['tx'] : '' }}</p>
                @else
                {{$order->method}} {{ $langg->lang296 }} <p id="ttn">{{$order->txnid}}</p>
                @endif

            @endif
        </div>
    </div>
</div>
@endif
                                                        <br>
                    <div class="table-responsive">
                            <table  class="table">
                                <h3 class="mt-2 mb-4 text-center">{{ $langg->lang308 }}</h3>
                                <thead>
                                <tr>

                                    <th width="60%">{{ $langg->lang310 }}</th>
                                    <th width="20%">{{ $langg->lang539 }}</th>
                                    <th width="10%">{{ $langg->lang314 }}</th>
                                    <th width="10%">{{ $langg->lang315 }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($tempcart->items))
                                @foreach($tempcart->items as $product)
                                    <tr>

                                            <td>{{ $product['item']['name'] }}</td>
                                            <td>
                                                <b>{{ $langg->lang311 }}</b>: {{$product['qty']}} <br>
                                                @if(!empty($product['size']))
                                                <b>{{ $langg->lang312 }}</b>: {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}} <br>
                                                @endif
                                                @if(!empty($product['color']))
                                                <div class="d-flex mt-2">
                                                <b>{{ $langg->lang313 }}</b>:  <span id="color-bar" style="border: 10px solid #{{$product['color'] == "" ? "white" : $product['color']}};"></span>
                                                </div>
                                                @endif

                                                    @if(!empty($product['keys']))

                                                    @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} <br>
                                                    @endforeach

                                                    @endif

                                                  </td>
                                            <td>{{$order->currency_sign}}{{round($product['item']['price'] * $order->currency_value,2)}}</td>
                                            <td>{{$order->currency_sign}}{{round($product['price'] * $order->currency_value,2)}}</td>

                                    </tr>
                                @endforeach
                                @endif


                                </tbody>
                            </table>

                                @if(isset($tempcart->offers))

                                                        <table  class="table">
                                <h3 class="mt-5 mb-4 text-center">Ordered Offers</h3>
                                <thead>
                                <tr>

                                    <th width="30%">{{ $langg->lang310 }}</th>
                                    <th width="50%">{{ $langg->lang539 }}</th>
                                    <th width="10%">{{ $langg->lang314 }}</th>
                                    <th width="10%">{{ $langg->lang315 }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($tempcart->offers as $offer)
                                    <tr>
                                    @php 
                                        $offr = \App\Models\Offer::query()->where("id",$offer['id'])->first();
                                    @endphp                        
                                            <td>{{ $offr->name }}</td>
                                            <td>

                                                    {{mb_strlen($offr->name,'utf-8') > 30 ? mb_substr($offr->name,0,30,'utf-8').'...' : $offr->name}}

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
                                            <td>{{$order->currency_sign}}{{round($offer['price'] * $order->currency_value,2)}}</td>
                                            <td>{{$order->currency_sign}}{{round($offer['price'] * $offer['qty'] * $order->currency_value,2)}}</td>

                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                            @endif


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>
            </div>

@endif

  </section>

@endsection