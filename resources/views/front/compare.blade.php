@extends('layouts.front')

@section('styles')
	<style>
		.first-column{
			width:18%;
			font-weight:bold;
			color:black;
			font-size:18px;
			background:#dfdfdf;
		}
		.category{
			color:black;
			text-align:center;
		}
		.prod-img{
			height:180px;
			width:180px;
		}
		td{
			border-right:1px solid #dfdfdf;
			border-bottom:1px solid #dfdfdf;
		}
	</style>
@endsection
@section('content')

        <!-- Breadcrumb Area Start Here -->
  <div class="breadcrumb-area">
  <div class="container">
	  <ol class="breadcrumb breadcrumb-list">
		  <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
		  <li class="breadcrumb-item active">Compare</li>
	  </ol>
  </div>
</div>
<!-- Breadcrumb Area End Here -->

	<!-- Compare Area Start -->
	<section class="compare-page">


		            <!-- Compare area start -->
		<div class="compare-area mtb-60px">
			<div class="container">
				<div class="row">
					@if(isset($products))
                        <div class="col-12">
                            <form action="#">
                                <!-- Compare Table -->
                                <div class="compare-table table-responsive">
                                    <table class="table mb-0">
                                        <tbody>
	<tr>
		<td class="first-column">Product</td>
		@foreach($products as $product)
		<td class="product-image-title c{{$product['item']['id']}}">
			<a href="{{ route('front.product', $product['item']['slug']) }}" class="image">
				<img class="img-responsive prod-img" src="{{ $product['item']['thumbnail'] ? asset('public/assets/images/thumbnails/'.$product['item']['thumbnail']):asset('assets/images/noimage.png') }}" alt="Compare product['item']">
			</a>
			@php
				$prod = \App\models\Product::query()->where("id",$product['item']['id'])->first();
			@endphp
			<br><br>
			<a href="{{ route('front.product', $product['item']['slug']) }}" class="title"><b>{{ $product['item']['name'] }}</b></a>
		</td>
		@endforeach
	</tr>
	<tr>
		<td class="first-column">Category</td>
		@foreach($products as $product)
		<td class="pro-desc c{{$product['item']['id']}}">
			@php
				$prod = \App\models\Product::query()->where("id",$product['item']['id'])->first();
			@endphp

			<br>
			<a href="compare.html#" class="category">{{ $prod->category->name }}</a>

		</td>
		@endforeach
	</tr>
	<tr>
		<td class="first-column">Description</td>
		@foreach($products as $product)
		<td class="pro-desc c{{$product['item']['id']}}">
			@php
				$prod = \App\models\Product::query()->where("id",$product['item']['id'])->first();
			@endphp

			<p>
				{!!  substr(strip_tags($prod->details), 0, 150) !!}...
			</p>
		</td>
		@endforeach
	</tr>
	<tr>
		<td class="first-column">Price</td>
		@foreach($products as $product)
			@php
				$prod = \App\models\Product::query()->where("id",$product['item']['id'])->first();
			@endphp

		<td class="pro-price c{{$product['item']['id']}}">{{ $prod->showPrice() }}</td>
		@endforeach
	</tr>
	<tr>
		<td class="first-column">Stock</td>
		@foreach( $products as $product)
			<td class="pro-stock c{{$product['item']['id']}}">In Stock</td>
		@endforeach
	</tr>
	<tr>
		<td class="first-column">Add to cart</td>
		@foreach( $products as $product)
		<td class="pro-addtocart c{{$product['item']['id']}}">
			<a href="javascript:;" data-href="{{ route('product.cart.add',$product['item']['id']) }}" class="btn__bg add-to-cart btn btn-default">{{ $langg->lang75 }}</a>
		</td>
		@endforeach
	</tr>
	<tr>
		<td class="first-column">Remove</td>
		@foreach($products as $product)
		<td class="pro-remove c{{$product['item']['id']}}">
			<button><i class="fa fa-times compare-remove" data-href="{{ route('product.compare.remove',$product['item']['id']) }}" data-class="c{{$product['item']['id']}}"></i></button>
		</td>
		@endforeach

	</tr>
	<tr>
		<td class="first-column">Rating</td>
		@foreach($products as $product)
		<td class="pro-ratting c{{$product['item']['id']}}">
		@php
			$prod = \App\models\Product::query()->where("id",$product['item']['id'])->first();
		@endphp

			{!! $prod->showRating() !!}
		</td>
		@endforeach
	</tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
						@else
						<div class="col-md-12 mt-5 mb-5 pt-5 pb-b">
							<h1 class="text-center">Empty</h1>
						</div>
						@endif
                    </div>
                </div>
            </div>
            <!-- Compare area end -->

	</section>
	<!-- Compare Area End -->

@endsection