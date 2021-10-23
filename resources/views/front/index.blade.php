@extends('layouts.front')
@section('title' , 'Home')
@section('styles')
    <style>
    </style>
@endsection
@section('content')

<div class="row">
        <div class="col-md-12">
            <div id="main-banner" class="owl-carousel home-slider">
                @foreach($sliders as $slider)
                    <div class="item"><a href="{{$slider->link}}"><img src="{{asset('assets/images/sliders/'.$slider->photo)}}" alt="main-banner1" class="img-responsive" /></a> </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div id="column-left" class="col-sm-3 hidden-xs column-left">
            <div class="column-block">
                <div class="columnblock-title">Categories</div>
                <div class="category_block">
                    <ul class="box-category treeview-list treeview">
                        @foreach ($cats as $element)
                        @if($element->subs->count() > 0)
                        <!--<a href="{{route('front.category',$element->slug)}}" class="activSub">{{ $element->name }}</a>-->
                        <li><a href="javascript:;">{{ $element->name }}</a>
                        <ul>
                            @foreach ($element->subs as $sub)
                                <li><a href="{{route('front.category',[$element->slug,$sub->slug])}}">{{ $sub->name}}</a></li>
                            @endforeach
                        </ul>
                        </li>
                        @else
                        <li><a href="{{route('front.category',$element->slug)}}">{{ $element->name }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <h3 class="productblock-title">Latest</h3>
            <div class="row latest-grid product-grid">
                @php $i=0; @endphp
                @foreach($products as $key => $prod)
                @if($prod->latest == 1)
                @if($i < 3)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 product-grid-item">
                    <div class="product-thumb transition">
                        <div class="image product-imageblock">
                            <a href="{{ route('front.product',$prod->slug) }}">
                                <img style="width:50px; height:50px;" src="{{ $prod->photo ? asset('public/assets/images/products/'.$prod->photo):asset('public/assets/images/noimage.png') }}" alt="iPod Classic" title="iPod Classic" class="img-responsive" /> 
                            </a>
                            <div class="button-group">
                                <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                                <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                                <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                            </div>
                        </div>
                        <div class="caption product-detail">
                            <h4 class="product-name"> <a href="product.html" title="iPod Classic"> {{ $prod->showShortName() }} </a> </h4>
                            <p class="price product-price"><span class="price-old">{{ $prod->showPreviousPrice() }}</span> {{ $prod->setCurrency() }} <span class="price-tax">Ex Tax: $100.00</span> </p>
                            <div class="rating">
                                {!! $prod->showRating() !!}
                            </div>

                        <div class="button-group">
                            <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                            <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                            <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                        </div>

                        </div>
                    </div>
                </div>
                @php $i++; @endphp
                @endif
                @endif
                @endforeach
            </div>
            <h3 class="productblock-title">Specials</h3>
            <div class="row special-grid product-grid">
                @php $i=0; @endphp
                @foreach($products as $key => $prod)
                @if($prod->best == 1)
                @if($i < 3)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 product-grid-item">
                    <div class="product-thumb transition">
                        <div class="image product-imageblock">
                            <a href="{{ route('front.product',$prod->slug) }}">
                                <img style="width:50px; height:50px;" src="{{ $prod->photo ? asset('public/assets/images/products/'.$prod->photo):asset('public/assets/images/noimage.png') }}" alt="iPod Classic" title="iPod Classic" class="img-responsive" /> 
                            </a>
                            <div class="button-group">
                                <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                                <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                                <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                            </div>
                        </div>
                        <div class="caption product-detail">
                            <h4 class="product-name"> <a href="product.html" title="iPod Classic"> {{ $prod->showShortName() }} </a> </h4>
                            <p class="price product-price"><span class="price-old">{{ $prod->showPreviousPrice() }}</span> {{ $prod->setCurrency() }} <span class="price-tax">Ex Tax: $100.00</span> </p>
                            <div class="rating">
                                {!! $prod->showRating() !!}
                            </div>

                        <div class="button-group">
                            <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                            <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                            <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                        </div>

                        </div>
                    </div>
                </div>
                @php $i++; @endphp
                @endif
                @endif
                @endforeach

            </div>
        </div>
        <div id="content" class="col-sm-9">
            <div class="customtab">
                <div id="tabs" class="customtab-wrapper">
                    <ul class='customtab-inner'>
                        <li class='tab'><a href="#tab-latest">Latest</a></li>
                        <li class='tab'><a href="#tab-special">New</a></li>
                        <li class='tab'><a href="#tab-bestseller">Bestseller</a></li>
                    </ul>
                </div>
                <div id="tab-latest" class="tab-content">
                    <div class="box filtered-products">
                        <div id="latest-slidertab" class="row owl-carousel product-slider">
                            @foreach($products as $prod)
                            @if($prod->latest == 1)
                            <div class="item">
                                <div class="product-thumb transition">
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
                                        <p class="price product-price"><span class="price-old">{{ $prod->showPreviousPrice() }}</span> {{ $prod->setCurrency() }} <span class="price-tax">Ex Tax: $100.00</span> </p>
                                        <div class="rating">
                                            {!! $prod->showRating() !!}
                                        </div>
                                    </div>
                                    <div class="button-group">
                                        <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                                        <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                                        <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- tab-latest-->
                <div id="tab-special" class="tab-content">
                    <div class="box filtered-products">
                        <div id="special-slidertab" class="row owl-carousel product-slider">
                            @foreach($products as $prod)
                            @if($prod->new == 1)
                            <div class="item">
                                <div class="product-thumb transition">
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
                                        <p class="price product-price"><span class="price-old">{{ $prod->showPreviousPrice() }}</span> {{ $prod->setCurrency() }} <span class="price-tax">Ex Tax: $100.00</span> </p>
                                        <div class="rating">
                                            {!! $prod->showRating() !!}
                                        </div>
                                    </div>
                                    <div class="button-group">
                                        <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                                        <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                                        <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach

                        </div>
                    </div>
                </div>
                <!-- tab-special-->
                <div id="tab-bestseller" class="tab-content">
                    <div class="box filtered-products">
                        <div id="bestseller-slidertab" class="row owl-carousel product-slider">
                            @foreach($products as $prod)
                            @if($prod->best == 1)
                            <div class="item">
                                <div class="product-thumb transition">
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
                                        <p class="price product-price"><span class="price-old">{{ $prod->showPreviousPrice() }}</span> {{ $prod->setCurrency() }} <span class="price-tax">Ex Tax: $100.00</span> </p>
                                        <div class="rating">
                                            {!! $prod->showRating() !!}
                                        </div>
                                    </div>
                                    <div class="button-group">
                                        <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                                        <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                                        <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach




                        </div>
                    </div>
                </div>
                <div id="subbanner4" class="banner" >
                    <div class="item"> 
                        <a href="{{ $gs->home_fp_shop_now }}">
                            <img src="{{ asset('public/assets/images/home') }}/{{ $gs->home_fp_image }}" alt="Sub Banner4" class="img-responsive" />
                        </a> 
                    </div>
                </div>
                <div id="subbanner5" class="banner" >
                    <div class="item"> 
                    <a href="{{ $gs->home_sp_shop_now }}">
                        <img src="{{ asset('public/assets/images/home') }}/{{ $gs->home_sp_image }}" alt="Sub Banner4" class="img-responsive" />
                    </a> 
                    </div>
                </div>
                <h3 class="productblock-title">Featured</h3>
                <div class="box filtered-products">
                    <div id="feature-slider" class="row owl-carousel product-slider">
                    @foreach($products as $key => $prod)
                    @if($prod->featured == 1)

                        <div class="item product-slider-item">
                            <div class="product-thumb transition">
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
                                    <p class="price product-price"><span class="price-old">{{ $prod->showPreviousPrice() }}</span> {{ $prod->setCurrency() }} <span class="price-tax">Ex Tax: $100.00</span> </p>
                                    <div class="rating">
                                        {!! $prod->showRating() !!}
                                    </div>
                                </div>
                                <div class="button-group">
                                    <button type="button" id="{{$prod->id}}" href="javascript:;" class="add-to-wish wishlist" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" title="Add to Wish List"><i class="fa fa-heart-o"></i></button>
                                    <button type="button" data-href="{{ route('product.cart.add',$prod->id) }}" class="addtocart-btn add-to-cart">Add to Cart</button>
                                    <button type="button" class="compare add-to-compare-link add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip" title="Compare this Product"><i class="fa fa-exchange"></i></button>
                                </div>

                            </div>
                        </div>

                    @endif
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')

@endsection