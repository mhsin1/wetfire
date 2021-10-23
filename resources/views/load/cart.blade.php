@if(Session::has('cart'))
<li>
	<table class="table table-striped">
		<tbody>
		@if(Session::has('cart') && Session::get('cart')->items)
		@foreach(Session::get('cart')->items as $product)
			<tr class="single-cart-box product cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">
				<td class="text-center">
					<a href="{{ route('front.product',$product['item']['slug']) }}">
						<img style="height:50px; width:50px;" class="img-thumbnail" title="iPhone" alt="iPhone" src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('public/assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}">
					</a>
				</td>
				<td class="text-left">
					<a href="{{ route('front.product',$product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 45 ? mb_substr($product['item']['name'],0,45,'utf-8').'...' : $product['item']['name']}}</a>
				</td>
				<td width="10%" class="text-right" id="cqt{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">x {{$product['qty']}}</td>
				<td class="text-right">{{ App\Models\Product::convertPrice($product['item']['price']) }}</td>
				<td class="text-center del-icone cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}"><button class="btn btn-danger btn-xs" title="Remove" type="button"><i class="fa fa-times"></i></button></td>
			</tr>
		@endforeach
		@endif
		</tbody>
	</table>
</li>
<li>
	<div>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<td class="text-right"><strong>Sub-Total</strong></td>
					<td class="text-right">{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}</td>
				</tr>
				<!-- <tr>
					<td class="text-right"><strong>Eco Tax (-2.00)</strong></td>
					<td class="text-right">$2.00</td>
				</tr>
				<tr>
					<td class="text-right"><strong>VAT (20%)</strong></td>
					<td class="text-right">$42.00</td>
				</tr>
				<tr>
					<td class="text-right"><strong>Total</strong></td>
					<td class="text-right">$254.00</td>
				</tr> -->
			</tbody>
		</table>
		<p class="text-right"> <span class="btn-viewcart"><a href="{{ route('front.cart') }}"><strong><i class="fa fa-shopping-cart"></i> View Cart</strong></a></span> <span class="btn-checkout"><a href="{{ route('front.checkout') }}"><strong><i class="fa fa-share"></i> Checkout</strong></a></span> </p>
	</div>
</li>

@else 
<p class="mt-1 p-2 text-center">{{ $langg->lang8 }}</p>
@endif



