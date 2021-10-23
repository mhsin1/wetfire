<header>
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="top-left pull-left">
                        <!-- <div class="language">
                            <form action="#" method="post" enctype="multipart/form-data" id="language">
                                <div class="btn-group">
                                    <button class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <img src="{{ asset('public/assets/front/image/flags/gb.png') }}" alt="English" title="English"> <i class="fa fa-caret-down"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><img src="{{ asset('public/assets/front/image/flags/lb.png') }}" alt="Arabic" title="Arabic"> Arabic</a></li>
                                        <li><a href="#"><img src="{{ asset('public/assets/front/image/flags/gb.png') }}" alt="English" title="English"> English</a></li>
                                    </ul>
                                </div>
                            </form>
                        </div> -->
                        <div class="currency">
                            <form action="#" method="post" enctype="multipart/form-data" id="currency">
                                <div class="btn-group">
                                    @if(Session::has('currency'))
                                        <button class="btn btn-link dropdown-toggle" data-toggle="dropdown"> <strong>{{DB::table('currencies')->where('id','=',Session::get('currency'))->first()->sign}}</strong> <i class="fa fa-caret-down"></i> </button>
                                    @else
                                        <button class="btn btn-link dropdown-toggle" data-toggle="dropdown"> <strong>{{ DB::table('currencies')->where('is_default','=',1)->first()->sign }}</strong> <i class="fa fa-caret-down"></i> </button>
                                    @endif
                                    <ul class="dropdown-menu">
                                    @foreach(DB::table('currencies')->get() as $currency)
                                        <li>
                                            <a href="{{route('front.currency',$currency->id)}}">{{$currency->name}} {{$currency->sign}}</a>
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="top-right pull-right">
                        <div id="top-links" class="nav pull-right">
                            <ul class="list-inline">
                                @if(Auth::check())
                                    <li class="dropdown"><a href="#" title="My Account" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span>My Account</span> <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('user-dashboard') }}">Dashboard</a></li>
                                            <li><a href="{{ route('user-profile') }}">Profile</a></li>
                                            <li><a href="{{ route('user-orders') }}">My Orders</a></li>
                                            <li><a href="{{ route('user-reset') }}">Reset Password</a></li>
                                            <li><a href="{{ route('user-logout') }}">Logout</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('user-wishlists') }}" id="wishlist-total" title="Wish List"><i class="fa fa-heart"></i> <span>Wish List</span>(<span id="wishlist-count"> @if(Auth::user()) {{ Auth::user()->wishlistCount() }} @else 0 @endif</span>)</a></li>
                                    <li><a href="{{ route('product.compare') }}" id="wishlist-total" title="Compare"><i class="fa fa-exchange"></i> <span>Compare</span>(<span id="compare-count"> {{ Session::has('compare') ? count(Session::get('compare')->items) : 0 }}</span>)</a></li>

                                @else
                                    <li class="dropdown"><a href="#" title="My Account" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span>Login</span> <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{route('user-register')}}">Register</a></li>
                                            <li><a href="{{route('user.login')}}">Login</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('user-wishlists') }}" id="wishlist-total" title="Wish List (0)"><i class="fa fa-heart"></i> <span>Wish List</span>(<span id="wishlist-count"> @if(Auth::user()) {{ Auth::user()->wishlistCount() }} @else 0 @endif</span>)</a></li>
                                    <li><a href="{{ route('product.compare') }}" id="wishlist-total" title="Compare"><i class="fa fa-exchange"></i> <span>Compare</span>(<span id="compare-count"> {{ Session::has('compare') ? count(Session::get('compare')->items) : 0 }}</span>)</a></li>

                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="header-inner">
            <div class="col-sm-4 col-xs-6 header-left">
            <div class="shippings">
                        <div class="shipping-img"></div>
                        <div class="shipping-text">Free Shipping <span class="shipping-detail">On Order Above {{$curr->sign}}{{$gs->delivery_free}}</span></div>
                    </div>
                
            </div>
            <div class="col-sm-4 col-xs-6 header-middle">
                <div class="header-middle-top">
                    
                    <div id="logo"> 
                    <a href="{{ route('front.index') }}">
                        <img style="height:70px;" src="{{asset('assets/images/'.$gs->logo)}}" class="img-responsive" alt="logo-image">
                    </a> 
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-6 header-right">
                <div id="cart" class="btn-group btn-block">
                    <button type="button" class="btn btn-inverse btn-block btn-lg dropdown-toggle cart-dropdown-button"><span id="cart-total"><span id="cart-count">{{ Session::has('cart') ? Session::get('cart')->totalCount() : '0' }}</span>  item(s) - <span id="cart-paisa">@if(Session::has('cart')) {{ \App\Models\Product::convertPrice(Session::get('cart')->totalPrice) }} @else {{$curr->sign}}0 @endif</span></span><i class="fa fa-caret-down"></i></button>
                    <ul id="cart-items" class="dropdown-menu pull-right cart-dropdown-menu">
                        @include('load.cart')
                    </ul>
                </div>
                <div id="search" class="input-group">
                    <form id="searchForm" action="{{ route('front.category' , [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">
                    @if (!empty(request()->input('sort')))
                    <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                    @endif
                    @if (!empty(request()->input('minprice')))
                    <input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
                    @endif
                    @if (!empty(request()->input('maxprice')))
                    <input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
                    @endif
                    <div class="form-search">
                        <input  id="prod_name" class="form-control input-lg" name="search" placeholder="{{ $langg->lang2 }}" value="{{ request()->input('search') }}" autocomplete="off" type="text">                     
                        <!-- <div class="autocomplete">
                        <div id="myInputautocomplete-list" class="autocomplete-items"></div>
                        </div> -->
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
                </div>

</div>
    </div>
</header>
<nav id="menu" class="navbar">
    <div class="nav-inner container">
        <div class="navbar-header"><span id="category" class="visible-xs">Categories</span>
            <button type="button" class="btn btn-navbar navbar-toggle" ><i class="fa fa-bars"></i></button>
        </div>
        <div class="navbar-collapse">
            <ul class="main-navigation">
            @foreach($categories as $cat)
                <li>                                        
                    <a @if(count($cat->subs) > 0) class="drop-icon" @endif href="javascript:;">{{ $cat->name }}</a>
                    <!-- Home Version Dropdown Start -->
                    @if(count($cat->subs) > 0)
                    <ul>
                        @foreach($cat->subs as $sub)
                        <li>
                            <a href="{{ route('front.category',[$cat->slug , $sub->slug]) }}">{{ $sub->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach

                @foreach($pages as $pg)
                @if($pg->header == 1)
                <li>                                        
                    <a href="{{ route('front.page',$pg->slug) }}">
                        {{ $pg->title }}
                    </a>
                </li>
                @endif
                @endforeach                

            </ul>
        </div>
    </div>
</nav>