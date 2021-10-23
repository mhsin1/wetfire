<input type="hidden" value="{{ $prods->total() }}" id="total-pp" />
<div class="grid-list-wrapper filtered-products">
@if (count($prods) > 0)
	@foreach ($prods as $key => $prod)
    <div class="product-layout product-grid col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <div class="product-thumb">
            <div class="image product-imageblock"> 
                <a href="{{ route('front.product',$prod->slug) }}">
                    <img src="{{ $prod->photo ? asset('public/assets/images/products/'.$prod->photo):asset('public/assets/images/noimage.png') }}" alt="iPod Classic" title="iPod Classic" class="img-responsive" /> 
                </a>


              <div class="button-group">
                <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
              </div>
            </div>
            <div class="caption product-detail">
              <h4 class="product-name"> <a href="product.html" title="iPod Classic"> {{ $prod->showName() }} </a> </h4>
              <div class="product-desc"> 
                 <div> {!! $prod->details !!} </div>
               </div>
              <p class="price product-price"><span class="price-old">{{ $prod->showPreviousPrice() }}</span> {{ $prod->setCurrency() }} <span class="price-tax">Ex Tax: $100.00</span> </p>
              <div class="rating">
                {!! $prod->showRating() !!}
              </div>
              <!-- {!! $prod->showRating() !!} -->
            </div>
            <div class="button-group">
              <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
              <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
              <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
            </div>
          </div>
        </div>

@endforeach    
        <div class="col-lg-12" style="clear:both">
            <div class="page-center mt-5">
                {!! $prods->appends(['search' => request()->input('search')])->links('pagination.default') !!}
            </div>
        </div>
@else
<div class="col-lg-12" style="clear:both">
		<div class="page-center">
				<h4 class="text-center">{{ $langg->lang60 }}</h4>
		</div>
	</div>
@endif
</div> 



@if(isset($ajax_check))


<script type="text/javascript">


// Tooltip Section


$('[data-toggle="tooltip"]').tooltip({
});
$('[data-toggle="tooltip"]').on('click',function(){
$(this).tooltip('hide');
});




$('[rel-toggle="tooltip"]').tooltip();

$('[rel-toggle="tooltip"]').on('click',function(){
$(this).tooltip('hide');
});


// Tooltip Section Ends

</script>

@endif