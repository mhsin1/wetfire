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


    .process-steps li.active:after{
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
			<li class="breadcrumb-item active">Order Return</li>
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
							@include('includes.user-dashboard-sidebar')
                        </div>
                        <div class="col-lg-9 box-shadow">
                            <!-- Tab panes -->
                            <div class="tab-content dashboard-content mt-all-40">
                                    <div class="view-order-page">
                                    <h3 class="order-code">{{ $langg->lang285 }} {{$order->order_number}} [{{$order->status}}]
                                    </h3>

                                    <!-- <div class="print-order text-right">
                                        <a href="{{route('user-order-print',$order->id)}}" target="_blank"
                                            class="print-order-btn">
                                            <i class="fa fa-print"></i> {{ $langg->lang286 }}
                                        </a>
                                    </div> -->
                                    <p class="order-date">{{ $langg->lang301 }} {{date('d-M-Y',strtotime($order->created_at))}}
                                    </p>
        
                                    @if($order->dp == 1)
        
                                    @else
                                    <div class="billing-add-area">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3>{{ $langg->lang287 }}</h3>
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
                                                <h3>{{ $langg->lang292 }}</h3>
        
                                                <p>{{ $langg->lang798 }}
                                                     {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>" !!}
                                                </p>
        
        
        
                                                <p>{{ $langg->lang293 }}
                                                    {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 0) }}
                                                </p>
        
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <br>
        
        
        
        
                                    <div class="table-responsive">
                                        <h3>{{ $langg->lang308 }}</h3>
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
                                                    <td>{{$order->currency_sign}}{{round($product['item']['price'] * $order->currency_value,0)}}
                                                    </td>
                                                    <td>{{$order->currency_sign}}{{round($product['price'] * $order->currency_value,0)}}
                                                    </td>
        
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
        

                                    </div>
                                    <!-- Return Form Start -->
                                    <div id="success-trigger" class="">
                                    <h3>Return Form</h3>
                                    <hr>
                                        <div class="col-md-6 col-md-offset-3 mt-50">
                                            @if(Session::has('success'))
                                            <div class="alert alert-success validation">
                                            <button type="button" class="close alert-close"><span>×</span></button>
                                                    <p class="text-left">
                                                        {{ Session::get('success') }}
                                                    </p> 
                                            </div>                                                
                                            @endif
                                            <form class="return_order_form" action="{{ route('order-return-submit') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                                <input type="hidden" name="order_id" value="{{$order->id}}" />
                                                <div class="form-group row">
                                                    <label for="reason" class="col-form-label pl-0">Reason of return</label>
                                                    <select name="reason" class="form-control" required id="reason">
                                                        @foreach($reasons as $reason)
                                                        <option value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="details" class="pl-0 col-form-label">Details</label>
                                                    <textarea name="details" class="form-control" id="details" cols="30" required rows="5">{{ old('details') }}</textarea>
                                                </div>
                                                <div class="form-group row">
                                                    <div id="image-preview" class="img-preview">
                                                        <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>Upload Icon</label>
                                                        <input type="file" name="images[]" multiple class="img-upload form-control" id="image-upload">
                                                    </div>
                                                </div>
                                                <div class="login-details text-center mb-25">
                                                    <button type="submit" class="login-btn btn btn-block">Send Request</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                    <!-- Return Form End-->
                                
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