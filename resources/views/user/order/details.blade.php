@extends('layouts.front')
@section('title' , 'Order')
@section('styles')
    <style>
    .process-steps-area {
            margin-top: 5%;
            margin-bottom: 15%;
            display: block;
        }
    .process-steps {
        margin: 0;
        padding: 0;
        list-style: none;
        display: block;
    }
    .process-steps li {
        width: 25%;
        float: left;
        text-align: center;
        position: relative;
    }
    .process-steps li.done:after, .process-steps li.active:after, .process-steps li.active .icon {
        background: #0f78f2;
    }
    .process-steps li.done:after, .process-steps li.active:after, .process-steps li.active .icon {
        color: #fff;
        background: #c7b270;
    }
    .process-steps li .icon {
        height: 30px;
        width: 30px;
        margin: auto;
        background: #efefef;
        border-radius: 50%;
        line-height: 30px;
        font-size: 14px;
        font-weight: 700;
        color: #000000;
        position: relative;
    }
    .process-steps li:after {
        position: absolute;
        content: "";
        height: 3px;
        width: calc(100% - 30px);
        background: #efefef;
        top: 14px;
        z-index: 0;
        right: calc(50% + 15px);
    }
    .process-steps li .title {
        font-weight: 600;
        font-size: 13px;
        color: #777;
        margin-top: 8px;
    }


    .process-steps li:first-child.active:after{
        color: #fff;
        background: #fff;
    }
    .process-steps li:first-child:after{
        color: #fff;
        background: #fff;
    }


    h3{
        font-size: 20px;
        font-weight:bold;
        text-transform: uppercase;
    }
    p{
        font-size:15px;
    }
    .list{
        list-style-type:none;
    }
    .mt-20 {
        margin-top: 5%;
        margin-bottom: 10%;
    }
    .box-shadow{
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.10);
        margin-bottom:10px;
        margin-top:10px;
        padding:20px;
    }
    </style>
@endsection
@section('content')

<!-- Breadcrumb Area Start Here -->
<div class="breadcrumb-area">
	<div class="container">
		<ol class="breadcrumb breadcrumb-list">
			<li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
			<li class="breadcrumb-item active">My Orders</li>
		</ol>
	</div>
</div>
<!-- Breadcrumb Area End Here -->



   <!-- My Account Page Start Here -->
   <div class="my-account white-bg ptb-90">
            <div class="container">
                <div class="account-dashboard">
                    <div class="row">
                    <div class="col-sm-3 hidden-xs column-left" id="column-left">
                            <!-- Nav tabs -->
                            @include('includes.user-dashboard-sidebar')

                        </div>
                        <div class="col-lg-9 box-shadow">
                            <!-- Tab panes -->
                            <div class="tab-content dashboard-content mt-all-40">
                                    <div class="view-order-page">
                                    <h3 class="order-code">{{ $langg->lang285 }} {{$order->order_number}} [{{$order->status}}]
                                    </h3>

                                    <div class="process-steps-area">
                                        @include('includes.order-process')
                                    </div>


                                    <!-- <div class="print-order text-right">
                                        <a href="{{route('user-order-print',$order->id)}}" target="_blank"
                                            class="print-order-btn">
                                            <i class="fa fa-print"></i> {{ $langg->lang286 }}
                                        </a>
                                    </div> -->
                                    <p class="order-date">{{ $langg->lang301 }} {{date('d-M-Y',strtotime($order->created_at))}}
                                    </p>
        
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
                                                    @if($order->order_note != null)
                                                    {{ $langg->lang801 }}: {{$order->order_note}}<br>
                                                    @endif
                                                    {{$order->customer_city}}-{{$order->customer_zip}}
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>{{ $langg->lang292 }}</h5>
        
                                                <p>{{ $langg->lang798 }}:
                                                     {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>" !!}
                                                </p>

                                                <p>Tax {{$order->currency_sign}}{{$order->tax}}</p>

                                                <p>{{ $langg->lang293 }}
                                                    {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                                </p>
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
                                    <div class="shipping-add-area">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($order->shipping == "shipto")
                                                <h5>{{ $langg->lang302 }}</h5>
                                                <address>
                                                    {{ $langg->lang288 }}
                                                    {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                                                    {{ $langg->lang289 }}
                                                    {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                                                    {{ $langg->lang290 }}
                                                    {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                                                    {{ $langg->lang291 }}
                                                    {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
                                                    {{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}-{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                                </address>
                                                @else
                                                <h5>{{ $langg->lang303 }}</h5>
                                                <address>
                                                    {{ $langg->lang304 }} {{$order->pickup_location}}<br>
                                                </address>
                                                @endif
        
                                            </div>
                                            <div class="col-md-6">
                                                <h5>{{ $langg->lang305 }}</h5>
                                                @if($order->shipping == "shipto")
                                                <p>{{ $langg->lang306 }}</p>
                                                @else
                                                <p>{{ $langg->lang307 }}</p>
                                                @endif
        
                                                @if($order->shipping_cost != 0)
                                                @php 
                                                $price = round(($order->shipping_cost / $order->currency_value),2);
                                                @endphp
                                                @if(DB::table('shippings')->where('price','=',$price)->count() > 0)
                                        <p>
                                            {{ DB::table('shippings')->where('price','=',$price)->first()->title }}: {{$order->currency_sign}}{{ round($order->shipping_cost, 2) }}
                                        </p>
                                                @endif
                                            @endif
        
                                            @if($order->packing_cost != 0)
        
                                                @php 
                                                $pprice = round(($order->packing_cost / $order->currency_value),2);
                                                @endphp
        
        
                                                @if(DB::table('packages')->where('price','=',$pprice)->count() > 0)
                                        <p>
                                            {{ DB::table('packages')->where('price','=',$pprice)->first()->title }}: {{$order->currency_sign}}{{ round($order->packing_cost, 2) }}
                                        </p>
                                                @endif
                                            @endif
        
        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="billing-add-area">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>{{ $langg->lang287 }}</h5>
                                                <address>
                                                    {{ $langg->lang288 }} {{$order->customer_name}}<br>
                                                    {{ $langg->lang289 }} {{$order->customer_email}}<br>
                                                    {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                                                    {{ $langg->lang291 }} {{$order->customer_address}}<br>
                                                    @if($order->order_note != null)
                                                    {{ $langg->lang801 }}: {{$order->order_note}}<br>
                                                    @endif
                                                    {{$order->customer_city}}-{{$order->customer_zip}}
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>{{ $langg->lang292 }}</h5>
        
                                                <p>{{ $langg->lang798 }}
                                                     {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>" !!}
                                                </p>
        
        
        
                                                <p>{{ $langg->lang293 }}
                                                    {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                                </p>
                                                <p>{{ __('Tax') }}
                                                    {{ $order->tax  }}%
                                                </p>
                                                <p>{{ $langg->lang294 }} {{$order->method}}</p>
        
                                                @if($order->method != "Cash On Delivery")
                                                @if($order->method=="Stripe")
                                                {{$order->method}} {{ $langg->lang295 }} <p>{{$order->charge_id}}</p>
                                                @endif
                                                {{$order->method}} {{ $langg->lang296 }} <p id="ttn"> {{$order->txnid}}</p>
        
                                                <a id="tid" style="cursor: pointer;" class="mybtn2">{{ $langg->lang297 }}</a> 
        
                                                <form id="tform">
                                                    <input style="display: none; width: 100%;" type="text" id="tin" placeholder="{{ $langg->lang299 }}" required="" class="mb-3">
                                                    <input type="hidden" id="oid" value="{{$order->id}}">
        
                                                    <button style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tbtn" type="submit" class="mybtn1">{{ $langg->lang300 }}</button>
                                                        
                                                        <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tc"  class="mybtn1">{{ $langg->lang298 }}</a>
                                                        
                                                        {{-- Change 1 --}}
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <br>
        
        
        
        
                                    <div class="table-responsive">
                                        @if($cart->items)
                                            <h5>{{ $langg->lang308 }}</h5>
                                        @endif
                                        <table class="table table-bordered veiw-details-table">
                                            <thead>
                                                <tr>
                                                    <th width="5%">{{ $langg->lang309 }}</th>
                                                    <th width="35%">{{ $langg->lang310 }}</th>
                                                    <th width="20%">{{ $langg->lang539 }}</th>
                                                    <th>{{ $langg->lang314 }}</th>
                                                    <th>{{ $langg->lang315 }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($cart->items)
                                                @foreach($cart->items as $product)
                                                <tr>
                                                    <td>{{ $product['item']['id'] }}</td>
                                                    <td>
                                                        <input type="hidden" value="{{ $product['license'] }}">
        
                                                        @if($product['item']['user_id'] != 0)
                                                        @php
                                                        $user = App\Models\User::find($product['item']['user_id']);
                                                        @endphp
                                                        @if(isset($user))
                                                        <a target="_blank"
                                                            href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                        @else
                                                        <a target="_blank"
                                                            href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                        @endif
                                                        @else
        
                                                        <a target="_blank" class="d-block"
                                                            href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
        
                                                        @endif
                                                        @if($product['item']['type'] != 'Physical')
                                                        @if($order->payment_status == 'Completed')
                                                        @if($product['item']['file'] != null)
                                                        <a href="{{ route('user-order-download',['slug' => $order->order_number , 'id' => $product['item']['id']]) }}"
                                                            class="btn btn-sm btn-primary mt-1">
                                                            <i class="fa fa-download"></i> {{ $langg->lang316 }}
                                                        </a>
                                                        @else
                                                        <a target="_blank" href="{{ $product['item']['link'] }}"
                                                            class="btn btn-sm btn-primary mt-1">
                                                            <i class="fa fa-download"></i> {{ $langg->lang316 }}
                                                        </a>
                                                        @endif
                                                        @if($product['license'] != '')
                                                        <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete"
                                                            class="btn btn-sm btn-info product-btn mt-1" id="license"><i
                                                                class="fa fa-eye"></i> {{ $langg->lang317 }}</a>
                                                        @endif
                                                        @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <b>{{ $langg->lang311 }}</b>: {{$product['qty']}} <br>
                                                        @if(!empty($product['size']))
                                                        <b>{{ $langg->lang312 }}</b>: {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}} <br>
                                                        @endif
                                                        @if(!empty($product['color']))
                                                        <div class="d-flex mt-2">
                                                        <b>{{ $langg->lang313 }}</b>:  <span id="color-bar" style="border: 10px solid {{$product['color'] == "" ? "white" : '#'.$product['color']}};"></span>
                                                        </div>
                                                        @endif
        
                                                            @if(!empty($product['keys']))
        
                                                            @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)
        
                                                                <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} <br>
                                                            @endforeach
        
                                                            @endif
        
                                                          </td>
                                                    <td>{{$order->currency_sign}}{{round($product['item']['price'] * $order->currency_value,2)}}
                                                    </td>
                                                    <td>{{$order->currency_sign}}{{round($product['price'] * $order->currency_value,2)}}
                                                    </td>
        
                                                </tr>
                                                @endforeach
                                                @endif 

                                                @if($cart->offers)
                                                @foreach($cart->offers as $offer)
                                                <tr>
                                                @php 
                                                    $offr = \App\Models\Offer::query()->where("id",$offer['id'])->first();
                                                @endphp                        
                                                    <td>{{ $offer['id'] }}</td>
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
                                                    <td>
                                                        <b>Quantity</b>:{{ $offer['qty'] }}<br>
                                                    </td>
                                                    <td>{{$order->currency_sign}}{{round($offer['price'] * $order->currency_value,2)}}
                                                    </td>
                                                    <td>{{$order->currency_sign}}{{round($offer['price'] * $order->currency_value,2)}}
                                                    </td>
        
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
        
                                        <div class="edit-account-info-div">
                                            <div class="form-group">
                                                <a class="view-cart" href="{{ route('user-orders') }}">{{ $langg->lang318 }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
        <!-- My Account Page End Here -->


@endsection


@section('scripts')

<script type="text/javascript">
    $('#example').dataTable({
        "ordering": false,
        'paging': false,
        'lengthChange': false,
        'searching': false,
        'ordering': false,
        'info': false,
        'autoWidth': false,
        'responsive': true
    });
</script>
<script>
    $(document).on("click", "#tid", function (e) {
        $(this).hide();
        $("#tc").show();
        $("#tin").show();
        $("#tbtn").show();
    });
    $(document).on("click", "#tc", function (e) {
        $(this).hide();
        $("#tid").show();
        $("#tin").hide();
        $("#tbtn").hide();
    });
    $(document).on("submit", "#tform", function (e) {
        var oid = $("#oid").val();
        var tin = $("#tin").val();
        $.ajax({
            type: "GET",
            url: "{{URL::to('user/json/trans')}}",
            data: {
                id: oid,
                tin: tin
            },
            success: function (data) {
                $("#ttn").html(data);
                $("#tin").val("");
                $("#tid").show();
                $("#tin").hide();
                $("#tbtn").hide();
                $("#tc").hide();
            }
        });
        return false;
    });
</script>
<script type="text/javascript">
    $(document).on('click', '#license', function (e) {
        var id = $(this).parent().find('input[type=hidden]').val();
        $('#key').html(id);
    });
</script>
@endsection