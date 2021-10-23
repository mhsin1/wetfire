<!doctype html>
<html class="no-js" lang="zxx">


<head>

    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="e-commerce site well design with responsive view." />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @if(isset($page->meta_tag) && isset($page->meta_description))
        <meta name="keywords" content="{{ $page->meta_tag }}">
        <meta name="description" content="{{ $page->meta_description }}">
    		<title>{{$gs->title}}</title>
        @elseif(isset($blog->meta_tag) && isset($blog->meta_description))
        <meta name="keywords" content="{{ $blog->meta_tag }}">
        <meta name="description" content="{{ $blog->meta_description }}">
    		<title>{{$gs->title}}</title>
        @elseif(isset($productt))
      <meta name="keywords" content="{{ !empty($productt->meta_tag) ? implode(',', $productt->meta_tag ): '' }}">
      <meta name="description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}">
	    <meta property="og:title" content="{{$productt->name}}" />
	    <meta property="og:description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}" />
	    <meta property="og:image" content="{{asset('assets/images/thumbnails/'.$productt->thumbnail)}}" />
	    <meta name="author" content="WetFire">
    	<title>{{substr($productt->name, 0,11)."-"}}{{$gs->title}}</title>
        @else
        <meta name="keywords" content="{{ $seo->meta_keys }}">
	    <meta name="author" content="WetFire">
		<title>{{$gs->title}}</title>
        @endif
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>WetFire | @yield('title')</title>
        <!-- Favicon -->

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon/favicon.ico')}}" />

    <link href="image/catalog/cart.html" rel="icon" />
    <link href="{{ asset('public/assets/front/css/bootstrap.min.css') }}" rel="stylesheet" media="screen" />
    <link href="{{ asset('public/assets/front/javascript/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
    <link href="{{ asset('public/assets/front/css/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/front/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/front/javascript/owl-carousel/owl.carousel.css') }}" type="text/css" rel="stylesheet" media="screen" />
    <link href="{{ asset('public/assets/front/javascript/owl-carousel/owl.transitions.css') }}" type="text/css" rel="stylesheet" media="screen" />
    <!-- Toastr css -->
    <link rel="stylesheet" href="{{ asset('public/assets/front/css/toastr.css') }}">
    <!-- Jquery ui price slider css -->
    <link rel="stylesheet" href="{{ asset('public/assets/front/css/jquery-ui.min.css') }}">

    <script src="{{ asset('public/assets/front/javascript/jquery-2.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/front/javascript/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('public/assets/front/javascript/template_js/jstree.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/front/javascript/template_js/template.js') }}"></script>
    <script src="{{ asset('public/assets/front/javascript/common.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/front/javascript/global.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/front/javascript/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
    <!-- Jquery ui price slider js -->
    <script src="{{ asset('public/assets/front/js/jquery-ui.min.js') }}"></script>

    <style>
        @media (min-width: 1200px){
          .filtered-products .product-imageblock{
            height:220px;
            width:auto;
          }
        }
    </style>
    @yield('styles')
</head>

<body class="@yield('class')">
<div class="preloader loader" style="display: block;"> <img src="{{ asset('public/assets/front/image/loader.gif') }}"  alt="#"/></div>
        @include('front.chunks.header')
        <input type="hidden" value="{{route('user.login')}}" id="user_login_url" />
        <div class="container col-2">
            @yield('content')
        </div>
        <!-- Footer Area Start Here -->
        @include('front.chunks.footer')
        <!-- Footer Area End Here -->


    <script type="text/javascript">
      var mainurl = "{{url('/')}}";
      var gs      = {!! json_encode($gs) !!};
      var langg    = {!! json_encode($langg) !!};
    </script>


    <!-- Main Activation JS -->
    <script src="{{ asset('public/assets/front/js/main_a.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/custom2.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/toastr.js') }}"></script>

    @yield('scripts')
</body>



</html>