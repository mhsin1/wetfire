@extends('layouts.front')
@section('styles')
  <style>
        h3{
			font-size: 20px;
			font-weight:bold;
			text-transform: uppercase;
		}
		p{
			font-size:15px;
		}
		.list{
			list-style-type:none;
		}
		.mt-20 {
			margin-top: 5%;
			margin-bottom: 10%;
		}
		.box-shadow{
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.10);
			padding:20px;
		}
        #contactform .form-control{
            margin-bottom:10px;
            border:1px solid orange;
            height:45px;
        }
        #contactform textarea{
            margin-bottom:10px;
            border:1px solid orange;
            height:auto !important;
        }
        .mb-3{
            margin-bottom:3%;
        }
        .mt-5{
            margin-top:5%;
        }
  </style>
@endsection
@section('content')

  <!-- Breadcrumb Area Start Here -->
  <div class="breadcrumb-area">
  <div class="container">
      <ol class="breadcrumb breadcrumb-list">
          <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
          <li class="breadcrumb-item active">Contact</li>
      </ol>
  </div>
</div>
<!-- Breadcrumb Area End Here -->


        <!-- Google Map Start -->
        <div class="goole-map">
            <div id="map"></div>
        </div>
        <!-- Google Map End -->
        <!-- Regester Page Start Here -->
        <div class="register-area white-bg ptb-90">
            <div class="container">
                <h3 class="login-header">Contact us</h3>
                <div class="row mt-5">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="row mb-3">
                            <div class="col-md-4"><b>Phone</b><p>{{$ps->phone}}</p></div>
                            <div class="col-md-4"><b>Email</b><p>{{ $ps->email}}</p></div>
                            <div class="col-md-4"><b>Address</b><p>{{ $ps->street }}</p></div>
                        </div>
                        <div class="mt-5 register-contact  clearfix">
                            <h3>Send Us Message</h3>
                            <form id="contactform" class="contact-form" action="{{route('front.contact.submit')}}" method="POST">
                                {{csrf_field()}}
                                    @include('includes.admin.form-both')  
                                <div class="address-wrapper row">
                                    <div class="col-md-12">
                                        <div class="address-fname">
                                            <input class="form-control" type="text" name="name" placeholder="Name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="address-email">
                                            <input class="form-control" type="email" name="email" placeholder="Email" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="address-web">
                                            <input class="form-control" type="text" name="phone" placeholder="Phone Number" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="address-textarea">
                                            <textarea name="text" class="form-control" rows="5" placeholder="Write your message"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-content mail-content clearfix">
                                    <div class="send-email float-md-right">
                                        <input value="Submit" class="return-customer-btn btn pull-right" type="submit">
                                    </div>
                                </div>
                                <p class="form-message"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Page End Here -->



@endsection 
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAq7MrCR1A2qIShmjbtLHSKjcEIEBEEwM"></script>
    <script>
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 11,
                scrollwheel: false,
                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng(23.761226, 90.420766), // New York
                // How you would like to style the map. 
                // This is where you would paste any style found on Snazzy Maps.
                styles: [{
                        "featureType": "landscape",
                        "stylers": [{
                                "hue": "#FFA800"
                            },
                            {
                                "saturation": 0
                            },
                            {
                                "lightness": 0
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "stylers": [{
                                "hue": "#53FF00"
                            },
                            {
                                "saturation": -73
                            },
                            {
                                "lightness": 40
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "stylers": [{
                                "hue": "#FBFF00"
                            },
                            {
                                "saturation": 0
                            },
                            {
                                "lightness": 0
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "stylers": [{
                                "hue": "#00FFFD"
                            },
                            {
                                "saturation": 0
                            },
                            {
                                "lightness": 30
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "stylers": [{
                                "hue": "#c1b17e"
                            },
                            {
                                "saturation": 6
                            },
                            {
                                "lightness": 8
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "stylers": [{
                                "hue": "#679714"
                            },
                            {
                                "saturation": 33.4
                            },
                            {
                                "lightness": -25.4
                            },
                            {
                                "gamma": 1
                            }
                        ]
                    }
                ]
            };
            // Get the HTML DOM element that will contain your map 
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('map');
            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);
            // Let's also add a marker while we're at it
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(23.761226, 90.420766),
                map: map,
                title: 'Snazzy!'
            });
        }
    </script>
@endsection