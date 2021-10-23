@extends('layouts.front')
@section('title' , 'Product')

@section('styles')
    <style>
#content{
    width:100% !important;
}
.col-2 #product-thumbnail.owl-carousel {
    width: 400px;
}
.social-sharing ul li a {
    background: white none repeat scroll 0 0;
    border: 1px solid #777;
    border-radius: 100%;
    color: #4b4b4b;
    display: block;
    height: 40px;
    line-height: 40px;
    text-align: center;
    width: 40px;
}

.social-sharing ul li {
    display: inline-block;
}

.social-sharing {
    margin-top: 5%;
}

.social-sharing ul li:not(:last-child) {
    margin-right: 10px;
}
.social-sharing ul li a .fa {
    font-size: 20px !important;
}

 .custom-control {
    position: relative;
    display: inline-block;
    min-height: 1.5rem;
    padding-left: 1.5rem;
    padding-top:2px;
}
.custom-radio .custom-control-input:checked~.custom-control-label::before {
    background-color: #c7b270;
}
.custom-control-label{
    margin-bottom:7px;
    color:black;
}
.product-attributes strong{
    font-size:20px;
    text-transform:capitalize;
}

.ml-3{
    margin-left:2%;
}

ol{
  width: 100%;
  overflow: hidden;
  list-style: none;
}
    </style>
@endsection
@section('class','product')
@section('content')

   <!-- Breadcrumb Area Start Here -->
   <div class="breadcrumb-area">
            <div class="container">
                <ol class="breadcrumb breadcrumb-list">
                    <li><a href="{{ route('front.index') }}"><i class="fa fa-home"></i></a></li>

                    <li class="breadcrumb-item">
                        <a href="{{route('front.category',$productt->category->slug)}}">{{$productt->category->name}}</a>
                    </li>
                    @if($productt->subcategory_id != null)
                    <li class="breadcrumb-item">
                        <a href="{{ route('front.subcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug]) }}">{{$productt->subcategory->name}}</a>
                    </li>                        
                    @endif
                    @if($productt->childcategory_id != null)
                    <li class="breadcrumb-item"><a
                        href="{{ route('front.childcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug, 'slug3' => $productt->childcategory->slug]) }}">{{$productt->childcategory->name}}</a></li>
                    @endif
                    <li class="breadcrumb-item active">
                        {{ $productt->name }}
                    </li>
                </ol>
            </div>
        </div>
        <!-- Breadcrumb Area End Here -->



    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <ul class="thumbnails">
                        <li id="pr_image_main">
                            <a class="thumbnail fancybox" href="{{asset('public/assets/images/products/'.$productt->photo)}}" title="{{ $productt->name }}">
                                <img src="{{asset('public/assets/images/products/'.$productt->photo)}}" title="{{ $productt->name }}" alt="{{ $productt->name }}" />
                            </a>
                        </li>
                        <div id="product-thumbnail" class="owl-carousel">
                            @foreach($productt->galleries as $gal)
                                <div class="item">
                                    <li class="image-additional">
                                        <a class="thumbnail fancybox" rel="gallery1"  href="{{asset('public/assets/images/galleries/'.$gal->photo)}}" title="{{ $productt->name }}"> 
                                        	<img src="{{asset('public/assets/images/galleries/'.$gal->photo)}}" title="{{ $productt->name }}" alt="{{ $productt->name }}" />
                                        </a>
                                    </li>
                                </div>
                            @endforeach
                        </div>
                    </ul>
                </div>
                <div class="col-sm-7 ml-3">
                    <h1 class="productpage-title">{{ $productt->name }}</h1>

                    <div class="rating product"> 
                        {!! $productt->showRating() !!}
                        <span class="review-count"> 
                            <a href="#" onClick="$('a[href=\'#tab-review\']').trigger('click'); return false;">({{count($productt->ratings)}}) reviews</a> / 
                            <a href="#" onClick="$('a[href=\'#tab-review\']').trigger('click'); return false;">Write a review
                            </a>
                        </span>
                        <hr>
                        <!-- AddThis Button BEGIN -->
                        <!-- <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like" ></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
                        <script type="text/javascript" src="../s7.addthis.com/js/300/addthis_widget.html#pubid=ra-515eeaf54693130e"></script>  -->
                        <!-- AddThis Button END --> 
                    </div>

                    <ul class="list-unstyled productinfo-details-top">
                        <li>
                            <h2 id="sizeprice" class="productpage-price">{{ $productt->showPrice() }}</h2>
                        </li>
                        @if($productt->dsc != 0)
                        <li><span class="productinfo-tax">Discount: {{$productt->dsc}}%</span></li>
                        @endif
                    </ul>
                    <hr>
                    <input type="hidden" id="product_price" value="{{ round($productt->vendorPrice() * $curr->value,2) }}">
                    <input type="hidden" id="product_id" value="{{ $productt->id }}">
                    <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
                    <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">

                    <ul class="list-unstyled product_info">
                        <li>
                            <label>Category:</label>
                            <span> <a href="#">{{ $productt->category->name }}</a></span>
                        </li>
                        <li>
                            <label>Product Code:</label>
                            <span> product {{ $productt->id}}</span>
                        </li>
                        @if($productt->stock != null)
                        <li>
                            <label>Availability:</label>
                            <span id="pr_stock_availability"> In Stock</span>
                        </li>
                        @endif
                    </ul>
                    <hr>
                    <div class="product-desc">
                        {!!  substr(strip_tags($productt->details), 0, 150) !!}...
                    </div>


    <div class="info-meta-3">
        <ul class="meta-list">
            @if (!empty($productt->attributes))
                @php
                    $attrArr = json_decode($productt->attributes, true);
                @endphp
            @endif
            @if (!empty($attrArr))
            
                <div class="product-attributes my-4">
                    <div class="row">
                        @foreach ($attrArr as $attrKey => $attrVal)
                            @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)
                            @php
                            if(isset($attrVal["values"])){
                                $attr_val = $attrVal["values"];
                        @endphp
                                <div class="col-lg-6">
                                    <div class="form-group mb-2">
                                        <strong for="" class="text-capitalize">
                                            {{ str_replace("_", " ", $attrKey) }} :
                                        </strong>
                                        <div style="margin-top:3%;" class="mt-3">
                                            @foreach ($attr_val as $optionKey => $optionVal)
                                                <div class="custom-control custom-radio" style="clear:both; display:block;">
                                                    <input type="hidden" class="keys" value="">
                                                    <input type="hidden" class="values" value="">
                                                    
                                                    <input type="radio" id="{{$attrKey}}{{ $optionKey }}" name="{{ $attrKey }}" class="custom-control-input product-attr" onchange="radio_changed('{{$attrKey}}',{{ $optionKey }})" data-index="{{ $optionKey }}"  data-key="{{ $attrKey }}" data-price = "{{ $attrVal['prices'][$optionKey] * $curr->value }}" value="{{ $optionVal }}" {{ $loop->first ? 'checked' : '' }}>
                                                    
                                                    <label class="custom-control-label radio-inline" for="{{$attrKey}}{{ $optionKey }}">
                                                        {{ $optionVal }}
                                                
                                                        @if (!empty($attrVal['prices'][$optionKey]))
                                                            +
                                                            {{$curr->sign}} {{$attrVal['prices'][$optionKey] * $curr->value}}
                                                        @endif
                                                        
                                                        @if (!empty($attrVal['quantities'][$optionKey]))
                                                            &nbsp; &nbsp; 
                                                            @if(!empty($attrVal['quantities'][$optionKey]) && $attrVal['quantities'][$optionKey]!=0)
                                                                in Stock [{{$attrVal['quantities'][$optionKey]}}]
                                                            @else
                                                                Out of Stock
                                                            @endif
                                                            <span style="display:none" id="sp_stock_{{$attrKey}}_{{ $optionKey }}">
                                                            @if(!empty($attrVal['quantities'][$optionKey]) && $attrVal['quantities'][$optionKey]!=0)
                                                                in Stock [{{$attrVal['quantities'][$optionKey]}}]
                                                            @else
                                                                Out of Stock
                                                            @endif
                                                            </span>
                                                        @endif
                                                        
                                                        
                                                        @if (!empty($attrVal['images'][$optionKey]))
                                                            <span style="display:none" id="sp_image_{{$attrKey}}_{{ $optionKey }}">
                                                            @if(!empty($attrVal['images'][$optionKey]) && $attrVal['images'][$optionKey]!='')
                                                                <a class="thumbnail fancybox" href="{{asset('public/assets/images/products/'.$attrVal['images'][$optionKey])}}" title="{{ $productt->name }}">
                                                                    <img src="{{asset('public/assets/images/products/'.$attrVal['images'][$optionKey])}}" title="{{ $productt->name }}" alt="{{ $productt->name }}" />
                                                                </a>
                                                            @else
                                                                <a class="thumbnail fancybox" href="{{asset('public/assets/images/products/'.$productt->photo)}}" title="{{ $productt->name }}">
                                                                    <img src="{{asset('public/assets/images/products/'.$productt->photo)}}" title="{{ $productt->name }}" alt="{{ $productt->name }}" />
                                                                </a>
                                                            @endif
                                                            </span>
                                                        @endif
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @php
                                }
                            @endphp
                            @endif
                        @endforeach
                    
                    </div>
                </div>
          	@endif
    
          	@if($productt->emptyStock())
                <li class="addtocart">
                    <a href="javascript:;" class="cart-out-of-stock">
                        <i class="icofont-close-circled"></i>
                        {{ $langg->lang78 }}
                    </a>
                </li>
          	@endif    
        </ul>
  	</div>


                    <div id="product">
                        <div class="form-group">
                            <label class="control-label qty-label" for="input-quantity">Qty</label>
                            <input type="number" name="quantity" value="1" size="2" id="input-quantity" class="form-control productpage-qty quantity qttotal" />
                            <div class="btn-group">
                                <button type="button" data-toggle="tooltip" id="{{$productt->id}}" href="javascript:;" data-href="{{ route('user-wishlist-add',$productt->id) }}" class="add-to-wish btn btn-default wishlist" title="Add to Wish List" ><i class="fa fa-heart-o"></i></button>
                                <button type="button" data-loading-text="Loading..." id="addcrt" class="btn btn-primary btn-lg btn-block addtocart">Add to Cart</button>
                                <button type="button" data-toggle="tooltip" data-href="{{ route('product.compare.add',$productt->id) }}" class="add-to-compare btn btn-default compare" title="Compare this Product" ><i class="fa fa-exchange"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="social-sharing mt-30">
                        <ul>
                            <li><label>share</label></li>

                            @php $url = route('front.product',$productt->slug); @endphp
                            <li><a target="_blank" href="http://www.facebook.com/sharer.php?u={{$url}}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="http://twitter.com/share?url={{$url}}&text=Simple Share Buttons&hashtags=simplesharebuttons"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="https://plus.google.com/share?url={{$url}}"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{$url}}"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="mailto:?Subject=Simple Share Buttons&Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{$url}}"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>

                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="productinfo-tab">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-description" data-toggle="tab">Description</a></li>
                    <li><a href="#tab-review" data-toggle="tab">Reviews ({{count($productt->ratings)}})</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-description">
                        <div class="cpt_product_description ">
                            <div>
                                {!! $productt->details !!}
                            </div>
                        </div>
                        <!-- cpt_container_end --></div>
                    <div class="tab-pane" id="tab-review">
                        @if(Auth::guard('web')->check())

                        <form class="form-horizontal" id="reviewform" action="{{route('front.review.submit')}}"
                              data-href="{{ route('front.reviews',$productt->id) }}" method="POST">
                              @include('includes.admin.form-both')
                              {{ csrf_field() }}

                            <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">
                            <input type="hidden" name="product_id" value="{{$productt->id}}">

                            <div id="review"></div>
                            <h2>Write a review</h2>
                            <div class="form-group required">
                                <div class="col-sm-12">
                                    <label class="control-label" for="input-name">Your Name</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" id="input-name" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group required">
                                <div class="col-sm-12">
                                    <label class="control-label" for="input-review">Your Review</label>
                                    <textarea name="review" rows="5" id="input-review" class="form-control" required></textarea>
                                    <div class="help-block"><span class="text-danger">Note:</span> HTML is not translated!</div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <div class="col-sm-12">
                                    <label class="control-label">Rating</label>
                                    &nbsp;&nbsp;&nbsp; Bad&nbsp;
                                    <input type="radio" name="rating" value="1" />
                                    &nbsp;
                                    <input type="radio" name="rating" value="2" />
                                    &nbsp;
                                    <input type="radio" name="rating" value="3" />
                                    &nbsp;
                                    <input type="radio" name="rating" value="4" />
                                    &nbsp;
                                    <input type="radio" name="rating" checked value="5" />
                                    &nbsp;Good</div>
                            </div>
                            <div class="buttons clearfix">
                                <div class="pull-right">
                                    <button type="submit" id="button-review" data-loading-text="Loading..." class="btn btn-primary customer-btn"> Continue</button>
                                </div>
                            </div>
                        </form>
                        @else
                        <a href="{{ route('user.login') }}"><button class="btn btn-default">Login to Submit Review</button></a>
                        @endif
                    </div>
                </div>
            </div>

            @if(count($productt->category->products) > 0)
            <h3 class="productblock-title">Related Products</h3>
            <div class="box">
                <div id="related-slidertab" class="row owl-carousel product-slider">
                    @foreach($productt->category->products as $prod)
                    @if($productt->id != $prod->id)
                    <div class="item">
                        <div class="product-thumb transition">
                            <div class="image product-imageblock"> 
                            <a href="{{ route('front.product',$productt->slug) }}">
                                <img src="{{ $prod->thumbnail ? asset('public/assets/images/thumbnails/'.$prod->thumbnail):asset('public/assets/images/noimage.png') }}" alt="iPhone" title="iPhone" class="img-responsive" /> 
                            </a>
                                <div class="button-group">
                                    <button type="button" class="wishlist add-to-wish" id="{{$prod->id}}" href="javascript:;" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                                    <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="add-to-cart addtocart-btn">Add to Cart</button>
                                    <button type="button" class="compare add-to-compare" data-href="{{ route('product.compare.add',$productt->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                                </div>
                            </div>
                            <div class="caption product-detail">
                                <h4 class="product-name"><a href="{{ route('front.product',$productt->slug) }}" title="iPhone">{{ $prod->showName() }}</a></h4>
                                <p class="price product-price"> <span class="price-new">{{ $prod->showPrice() }}</span> <span class="price-old">$272.00</span> <span class="price-tax">Ex Tax: $210.00</span> </p>
                            </div>
                            <div class="button-group">
                                <button type="button" class="add-to-wish wishlist" id="{{$prod->id}}" href="javascript:;" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                                <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="add-to-cart addtocart-btn">Add to Cart</button>
                                <button type="button" class="compare add-to-compare" data-href="{{ route('product.compare.add',$productt->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach

                </div>
            </div>
            @endif
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $('.social-click').click(function(e){
        e.preventDefault();
        window.open($(this).attr('href'), '_blank');
    });

    $(document).ready(function(){
        $('.inc').click(function(e){
            var amount = $('#dynamic_price').attr('value');            
        });


    $("label.rating").click(function(){
	  $(this).parent().find("label").css({"background-color": "#78e2fb"});
	  $(this).css({"background-color": "#c7b270"});
	  $(this).nextAll().css({"background-color": "#c7b270"});

      var val = $(this).attr('id');
      $('#rating').val(val);
	});
 
	$(".star label").click(function(){
	  $(this).parent().find("label").css({"color": "#78e2fb"});
	  $(this).css({"color": "#c7b270"});
	  $(this).nextAll().css({"color": "#c7b270"});
	  $(this).css({"background-color": "transparent"});
	  $(this).nextAll().css({"background-color": "transparent"});
	});
    });

    $(document).ready(function(){
        $(function() {
            $('.zoom-image').each(function(){
            var originalImagePath = $(this).find('img').data('original-image');
            $(this).zoom({
            url: originalImagePath,
            magnify: 1
            });
         });

    });
}); 

function radio_changed(attribute,index)
{
	//alert(attribute + ' ' + index);
	$('#pr_stock_availability').html($('#sp_stock_'+attribute+'_'+index).html());
	$('#pr_image_main').html($('#sp_image_'+attribute+'_'+index).html());
	
}
</script>

@endsection