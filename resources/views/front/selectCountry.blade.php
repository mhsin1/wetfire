
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="img/logo.png"/>
    <title>Manara Store | Select Country</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

  <!-- Css Styles -->
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/allcss.css') }}" type="text/css">

  <link rel="stylesheet" href="{{ asset('public/assets/front/css/bootstrap.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/font-awesome.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/themify-icons.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/elegant-icons.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/owl.carousel.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/nice-select.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/jquery-ui.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/slicknav.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/style.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/responsive.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('public/assets/front/css/toastr.css') }}" type="text/css">

  <style>
    .explore-btn{
        background:transparent;
        border:0px;
        font-weight:bold;
        color:#ff4c50;
        font-size:17px;
    }
    button.close{
        padding:0px !important;
    }
    button.close:hover{
        color:black !important;
    }
    .normal{
        font-size:18px;
    }
    .normal a{
        text-decoration:none;
        color:black;
    }
    .pr-0{
        padding-right:0px !important;
    }
  </style>
</head>

<body class="select-country">
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    
    <div class="select-country-page d-flex align-items-center justify-content-center flex-column">
        <div class="select-country-inner border rounded-circle">
            <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="mb-4 mt-5">
                    <div class="col-5 col-md-4 m-auto">
                        <a href="#"><img class="img-fluid" src=""></a>
                    </div>
                </div>
                <h5 class="text-capitalize">Kindly select your country</h5>
                <div class="w-75 w-sm-100 mt-3">
                    <div class="col-md-12 d-flex flex-column justify-content-center">
                        <div class="d-flex flex-row flex-wrap">
                            @php
                                $i = 0;
                            @endphp
                            @foreach($countries as $country)
                            @if($i < 6)
                            <div class="col-4 col-md-4 pl-4 pr-4 @if($i == 2 || $i == 5) @else border-right @endif d-flex flex-column border-secondary">
                                <img class="img-fluid" src="{{ url(asset('assets/images/flags/'))}}/{{$country->country_code}}.png">
                                <a href="{{ route('front.country' , $country->id) }}" class="btn mt-4">{{ str_limit($country->country_name , 8)}}</a>
                            </div>
                            @endif
                            @php 
                            $i++;
                            if($i == 3){
                            @endphp
                                <hr class="solid w-75 pl-4 pr-4 border-secondary">
                            @php
                            }
                             @endphp
                            @endforeach
                        </div>
                            @if(count($countries) > 5)
                            <div class="row text-center">
                                <div class="col-md-4 mt-5 mx-auto">
                                    <button data-toggle="modal" data-target="#myModal" class="explore-btn">Explore More</button>
                                </div>
                            </div>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


     <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Select Country</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                @foreach($countries as $country)
                    <div class="col-md-4 mt-3">
                        <div class="row">
                            <div class="col-md-3 pr-0">
                                <img height="30px;" class="img-fluid" src="{{ url(asset('assets/images/flags/'))}}/{{$country->image}}">
                            </div>
                            <div class="col-md-9 normal">
                                <p class="mt-2"><a href="{{ route('front.country' , $country->id) }}">{{ $country->country_name }}</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Modal footer -->
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> -->
        
      </div>
    </div>
  </div>
    <!-- Copyright Section Begin -->
    <div class="copyright-reserved">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text text-center">
                        Designed by <a href="">Softgates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright Section End -->
    
    <!-- Js Plugins -->
    <script src="{{ asset('public/assets/front/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('public/assets/front/js/main.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/custom.js') }}"></script>

</body>

</html>