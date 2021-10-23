<div class="col-lg-3 col-6">
<div class="product-item">
	<div class="pi-pic">
		<img src="{{ $prod->thumbnail ? asset('public/assets/images/thumbnails/'.$prod->thumbnail):asset('public/assets/images/noimage.png') }}" alt="">
		<ul>
			<li class="w-icon active"><a href="javascript:;" class="add-to-cart" data-href="{{ route('product.cart.add',$prod->id) }}"><i class="icon_bag_alt"></i></a></li>
			<li class="quick-view"><a class="quick-a" title="{{ $langg->lang55 }}" href="javascript:;" data-href="{{ route('product.quick',$prod->id) }}" data-toggle="modal" data-target="#quickview">+ Quick View</a></li>
		</ul>
	</div>
	<div class="pi-text">

	<div class="stars">
			<div class="ratings">
				<div class="empty-stars"></div>
				<div class="full-stars" style="width:0%"></div>
			</div>
	</div>

		<!-- <div class="catagory-name">Towel</div> -->
		<a target="_self" href="{{ route('front.product',$prod->slug) }}">
			<h5>{{ $prod->showName() }}</h5>
		</a>
		<div class="product-price">
			{{ $prod->setCurrency() }}
			<span>{{ $prod->showPreviousPrice() }}</span>
		</div>
	</div>
</div>
</div>