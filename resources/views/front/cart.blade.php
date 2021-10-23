@extends('layouts.front')
@section('styles')
<style>
      @media only screen and (max-width: 600px) {
            .qtybtns {
                padding:0px 3px;
            }
            .cart-block{
                margin-top:10%;
            }
            .cart-block table{
                width:100%;
            }
            .cart-block table th{
                text-align:left;
            }
            .cart-block .wc-proceed-to-checkout a{
                width:100%;
                text-align:center;
            }
      }

      .col-2 #content {
            width: 100%;
        }
        .img-thumbnail{
            height:120px;
            width:120px;
        }
        .qttotal1{
            padding:0px 10px;
        }
        #cpn{
            margin-bottom:5%;
            width:100%;
        }
        .text-mobile-right{
            text-align:left;
        }
        @media only screen and (max-width:600px){
            .img-thumbnail{
                height:auto;
                width:auto;
            }
            #button-coupon{
                width:44%;
            }
            .text-mobile-right{
                text-align:left;
            }
        }

        #coupon-discount{
            display:none;
        }
</style>
@endsection
@section('class','cart')
@section('content')
<!-- Breadcrumb Area Start Here -->
<div class="breadcrumb-area">
    <div class="container">
        <ol class="breadcrumb breadcrumb-list">
            <li><a href="{{ route('front.index') }}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item active">
                Cart
            </li>
        </ol>
    </div>
</div>
<!-- Breadcrumb Area End -->

<div class="row">
    <div class="col-sm-12" id="content">
      <h1>Shopping Cart</h1>
      <form enctype="multipart/form-data" method="post" action="#">
        @php
            $discount = 0;
        @endphp
        @if(Session::has('cart') && Session::get('cart')->items)

        <div class="table-responsive">
          <table class="table table-bordered">
          @include('includes.form-success')

            <thead>
              <tr>
                <td class="text-center">Image</td>
                <td class="text-left">Product Name</td>
                <td wudth="20%" class="text-left">Quantity</td>
                <td class="text-right">Unit Price</td>
                <td class="text-right">Total</td>
                <td class="text-left">Remove</td>
              </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                @php
                    $discount = $discount + (App\Models\Product::find($product['item']['id'])->dsc_amt * $product['qty']);
                @endphp

            <tr class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">

                <td class="text-center">
                    <a href="{{ route('front.product', $product['item']['slug']) }}">
                        <img class="img-responsive img-thumbnail" title="iPhone" alt="iPhone" src="{{ $product['item']['photo'] ? asset('public/assets/images/products/'.$product['item']['photo']):asset('public/assets/images/noimage.png') }}">
                    </a>                    
                </td>
                <td class="text-left">
                    <a href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 35 ? mb_substr($product['item']['name'],0,35,'utf-8').'...' : $product['item']['name']}}</a>
                    <br>                                     
                    @if(!empty($product['size']))
                    <b>{{ $langg->lang312 }}</b>: {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}} <br>
                    @endif
                    @if(!empty($product['color']))
                    <div class="mt-1 mb-1">
                    <b>{{ $langg->lang313 }}</b>:   &nbsp;<span id="color-bar" style="padding-right:20px; border: 5px solid #{{$product['color'] == "" ? "white" : $product['color']}}; background:#{{$product['color'] == "" ? "white" : $product['color']}};"></span>
                    </div>
                    @endif

                    @if(!empty($product['keys']))
                    @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

                        <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} <br>
                    @endforeach
                    @endif
                </td>
                <td class="text-left">
                    @if($product['item']['type'] == 'Physical')
                    <input type="hidden" class="prodid" value="{{$product['item']['id']}}">  
                    <input type="hidden" class="itemid" value="{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">     
                    <input type="hidden" class="size_qty" value="{{$product['size_qty']}}">     
                    <input type="hidden" class="size_price" value="{{$product['item']['price']}}">   
                    <div class="plus-minus">
                            <div class="dec qtybutton reducing" style="display: inline-block;">
                                <span class="qtybtns btn btn-default"><i class="fa fa-minus"></i></span>                                    
                            </div>
                            <span class="qttotal1" id="qty{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{ $product['qty'] }}</span>
                            <div class="inc qtybutton adding" style="display: inline-block;">
                                <span class="qtybtns btn btn-default"><i class="fa fa-plus"></i></span>
                            </div>
                    </div>
                    @endif
                </td>
                <td class="text-right">
                    <span class="amount">{{ App\Models\Product::convertPrice($product['item']['price']) }}</span>
                </td>
                <td class="text-right">
                    @if($product['size_qty'])
                    <input type="hidden" id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}" value="{{$product['size_qty']}}">
                    @elseif($product['item']['type'] != 'Physical') 
                    <input type="hidden" id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}" value="1">
                    @else
                    <input type="hidden" id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}" value="{{$product['stock']}}">
                    @endif

                    <span id="prc{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                        {{ App\Models\Product::convertPrice($product['price']) }}                 
                    </span>

                </td>
                <td class="text-center">
                    <button data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}" class="btn btn-danger removecart cart-remove" title="" data-toggle="tooltip" type="button" data-original-title="Remove"><i class="fa fa-times-circle"></i></button>
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
        @endif
      </form>
      <br>
      <div class="row">
        <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
            <form action="">
            <div class="form-group">
              <div id="cpn" class="input-group">
                <input type="text" class="form-control" id="code" placeholder="Enter your coupon here" value="" name="coupon">
                <span class="input-group-btn">
                <input type="button" class="btn btn-default coupon-submit coupon-btn" data-loading-text="Loading..." id="button-coupon" value="Apply Coupon">
                </span>
              </div>
              </div>
            </form>

            </div>
        </div>

        </div>
        <div class="col-sm-4">
          <table class="table table-bordered">

                <input type="hidden" id="d-val" value="{{ App\Models\Product::convertPrice($discount)}}">
                <input type="hidden" id="c-val" value="{{ $curr->sign }}">
                <input type="hidden" id="c-sign-length" value="{{ mb_strlen($curr->sign) }}">

                <input type="hidden" class="coupon-total" id="grandtotal" value="{{ Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}">
                <input type="hidden" id="coupon_val" value="0">

            <tbody>
              <tr>
                <td class="text-right text-mobile-right"><strong>Sub-Total:</strong></td>
                <td class="text-right"><span class="amount cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00' }}</span></td>
              </tr>
              <tr>
                <td class="text-right text-mobile-right"><strong>Tax <small>({{$gs->tax}}%)</small>:</strong></td>
                @php 
                if($gs->tax != 0)
                    {
                        $tax = ($totalPrice / 100) * $gs->tax;
                        $mainTotal = $totalPrice + $tax;
                    }
                @endphp
                <td class="text-right"><span id="tax-total" class="amount">{{ App\Models\Product::convertPrice($tax)}}</span></td>
              </tr>
              @if($discount != 0)                    
              <tr>
                <td class="text-right text-mobile-right"><strong>Discount <small>(In Build)</small></strong></th>
                <td class="text-right"><span class="amount" id="in_discount">{{ App\Models\Product::convertPrice($discount)}}</span></td>
              </tr>
              @endif
              <tr id="coupon-discount">
                <td class="text-right text-mobile-right"><strong>Discount <small>(Coupon)</small></strong></th>
                <td class="text-right"><span class="amount discount">{{ $curr->sign }} 0</span></td>
              </tr>
              <tr>
                <td class="text-right text-mobile-right"><strong>Total:</strong></td>
                <td class="text-right">
                    <strong><span class="amount main-total">@if(Session::has('cart')) {{$curr->sign}}@endif{{ Session::has('cart') ?  App\Models\Product::convertOnlyPrice($mainTotal) - App\Models\Product::convertOnlyPrice($discount)  : '0.00' }}</span></strong>                                    
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="buttons">
        <div class="pull-left"><a class="btn btn-default" href="{{ url('/') }}">Continue Shopping</a></div>
        <div class="pull-right"><a class="btn btn-primary" href="{{ route('front.checkout') }}">Checkout</a></div>
      </div>
    </div>
  </div>


    @endsection