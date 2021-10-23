@extends('layouts.front')
@section('styles')
<style>
        .box-shadow{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.10);
            padding:20px 5% 20px 5%;
        }
        h3{
            font-size: 20px;
            font-weight:bold;
            text-transform: uppercase;
            margin-bottom:5%;
        }
        .box-shadow img{
            height:80px;
            width:80px;
        }
        .col-2 .column-left, .col-2 .column-right {
            width: 24%;
        }
</style>
@endsection
@section('content')

   <!-- Breadcrumb Area Start Here -->
   <div class="breadcrumb-area">
		<div class="container">
			<ol class="breadcrumb breadcrumb-list">
				<li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
				<li class="breadcrumb-item active">Wishlist</li>
			</ol>
		</div>
	</div>
	<!-- Breadcrumb Area End Here -->
        <div class="cart-main-area wish-list white-bg ptb-90">
            <div class="container">
			@if(count($wishlists) > 0)
                <div class="row">

                    <div class="col-sm-3 hidden-xs column-left" id="column-left">
                        @include('includes.user-dashboard-sidebar')
                    </div>
                    <div class="col-lg-9 box-shadow">
                                            <!-- Form Start -->
                                            <form action="#">
                            <!-- Table Content Start -->
                            <div class="table-content table-responsive">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="product-remove"></th>
                                            <th width="10%" class="product-thumbnail"></th>
                                            <th width="30%" class="product-name">Product</th>
                                            <th width="10%" class="product-price">Unit Price</th>
                                            <th width="10%" class="product-quantity">Stock Status</th>
                                            <th width="15%" class="product-subtotal">Add to cart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($wishlists as $wishlist)
                                        <tr>
											<td class="product-remove"> <a href="#" class="remove wishlist-remove" data-href="{{ route('user-wishlist-remove',$wishlist->id) }}"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                                            <td class="product-thumbnail">
                                                <a href="#">
													<img src="{{ $wishlist->product->thumbnail ? asset('public/assets/images/thumbnails/'.$wishlist->product->thumbnail):asset('assets/images/noimage.png') }}" alt="cart-image" />													
												</a>
                                            </td>
                                            <td class="product-name">
												<a href="{{ route('front.product', $wishlist->product->slug) }}">
													{{ $wishlist->product->name }}
												</a>
											</td>
                                            <td class="product-price"><span class="amount">{{ $wishlist->product->showPrice() }}</span></td>
                                            <td class="product-stock-status"><span>in stock</span></td>
											<input id="{{ $wishlist->product->id}}_input" class="qt_val" type="hidden" value="1" />
                                            <td class="product-add-to-cart"><a class="btn btn-default addcart_wishlist" id="{{ $wishlist->product->id}}" href="javascript:;" style="text-transform:capitalize;">add to cart </a></td>											
                                        </tr>
									@endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Table Content Start -->
                        </form>
                        <!-- Form End -->

                    </div>

                </div>
                <!-- Row End -->
				@else
				<div class="row">
					<div class="mt-5 mb-5 pt-5 pb-5 col-md-12 text-center">
						<h1>Wishlist Empty</h1>
					</div>
				</div>
				@endif
            </div>
        </div>
        <!-- Wish List End -->




@endsection

@section('scripts')

<script type="text/javascript">
        $("#sortby").on('change',function () {
        var sort = $("#sortby").val();
        window.location = "{{url('/user/wishlists')}}?sort="+sort;
		});
		

		$('.minuso').click(function(e){
			e.preventDefault();
			var val = $('#'+this.id+'_input').val();
			if(val>1){
				val--;
				$('#'+this.id+'_input').attr('value', val);
			}
		});

		$('.pluso').click(function(e){
			e.preventDefault();
			var val = $('#'+this.id+'_input').val();
			val++;
			$('#'+this.id+'_input').attr('value', val);
		});
</script>

@endsection
