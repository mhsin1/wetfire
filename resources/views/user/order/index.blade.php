@extends('layouts.front')
@section('styles')
	<style>
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
@section('title' , 'Order')
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
							@if(count($orders) > 0)
                            <div class="tab-content dashboard-content mt-all-40">
                                    <h3>Orders</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
												<tr>
													<th>#Order No</th>
													<th>{{ $langg->lang279 }}</th>
													<th>{{ $langg->lang280 }}</th>
													<th>{{ $langg->lang281 }}</th>
													<th>Return Order</th>
													<th>{{ $langg->lang282 }}</th>
												</tr>
                                            </thead>
                                            <tbody>
												@foreach($orders as $order)
												<tr>
													<td>
															{{$order->order_number}}
													</td>
													<td>
															{{date('d M Y',strtotime($order->created_at))}}
													</td>
													<td>
															{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
													</td>
													<td>
														<div class="order-status {{ $order->status }}">
																{{ucwords($order->status)}}
														</div>
													</td>
													<td>
														@php $return = \App\Models\ReturnOrder::where(['user_id' => Auth::user()->id])->where(['order_id' => $order->id])->first(); @endphp
														@if($return && $order->status != 'declined')
														<button class="btn btn-sm btn-danger" disabled>Requested Submitted</button>
														@else
														@if($order->status == 'declined')
														<button class="btn btn-sm btn-danger" disabled>Order Canceled</button>
														@else														
														@php $val = $order->created_at->diffInDays(\Carbon\Carbon::now()); @endphp 
														@if($val < 30)
														<a class="btn btn-sm btn-warning" href="{{route('order.return',$order->id)}}">Return Order</a>
														@else
														<button class="btn btn-sm btn-danger" disabled>Expired</button>
														@endif
														@endif
														@endif
													</td>
													<td>
   														<a class="view btn btn-default" href="{{route('user-order',$order->id)}}">{{ $langg->lang283 }}</a>
													</td>
												</tr>
												@endforeach
									</tbody>
                                        </table>
                                    </div>
                            </div>
							@else
							<div class="tab-content dashboard-content mt-all-40">
								<h3 class="text-center">No Orders Found</h3>
							</div>
							@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
        <!-- My Account Page End Here -->


@endsection