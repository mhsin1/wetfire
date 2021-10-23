<footer>
    <div class="container">
        <div class="footer-top-cms">
            <div class="footer-logo"> 
                <a href="{{ route('front.index') }}">
                    <img style="height:70px;" src="{{asset('assets/images/'.$gs->footer_logo)}}" class="img" alt="footer-logo-image">
                </a> 
            </div>
            <div class="footer-desc"> <span>{!! $gs->footer_text !!}</span> </div>
            <div class="footer-social">
                <h5>Social</h5>
                <ul>
                    @if(App\Models\Socialsetting::find(1)->f_status == 1)
                    <li class="facebook">
                        <a href="{{ App\Models\Socialsetting::find(1)->facebook }}">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    @endif
                    @if(App\Models\Socialsetting::find(1)->g_status == 1)
                    <li class="gplus">
                        <a href="{{ App\Models\Socialsetting::find(1)->gplus }}" class="google-plus" target="_blank">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </li>
                    @endif

                    @if(App\Models\Socialsetting::find(1)->t_status == 1)
                    <li class="twitter">
                        <a href="{{ App\Models\Socialsetting::find(1)->twitter }}" class="twitter" target="_blank">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    @endif

                    @if(App\Models\Socialsetting::find(1)->l_status == 1)
                    <li class="linkedin">
                        <a href="{{ App\Models\Socialsetting::find(1)->linkedin }}" class="linkedin" target="_blank">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                    @endif

                    @if(App\Models\Socialsetting::find(1)->d_status == 1)
                    <li class="dribble">
                        <a href="{{ App\Models\Socialsetting::find(1)->dribble }}" class="dribbble" target="_blank">
                            <i class="fa fa-dribbble"></i>
                        </a>
                    </li>
                    @endif

                    @if(App\Models\Socialsetting::find(1)->i_status == 1)
                    <li class="instagram">
                        <a href="{{ App\Models\Socialsetting::find(1)->instagram }}" class="dribbble" target="_blank">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 footer-block">
                <h5 class="footer-title">Information</h5>
                <ul class="list-unstyled ul-wrapper">
                    @foreach($pages as $page)
                        @if($page->category == 'information' && $page->footer == 1)
                        <li><a href="{{route('front.page',$page->slug)}}">{{ $page->title }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-3 footer-block">
                <h5 class="footer-title">Customer Service</h5>
                <ul class="list-unstyled ul-wrapper">
                    @foreach($pages as $page)
                        @if($page->category == 'customer_service' && $page->footer == 1)
                        <li><a href="{{route('front.page',$page->slug)}}">{{ $page->title }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-3 footer-block">
                <h5 class="footer-title">Extras</h5>
                <ul class="list-unstyled ul-wrapper">
                    @foreach($pages as $page)
                        @if($page->category == 'extras' && $page->footer == 1)
                        <li><a href="{{route('front.page',$page->slug)}}">{{ $page->title }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-3 footer-block">
                <div class="content_footercms_right">
                    <div class="footer-contact">
                        <h5 class="contact-title footer-title">Contact Us</h5>
                        <ul class="ul-wrapper">
                            <li><i class="fa fa-map-marker"></i><span class="location2"> {{ $ps->street }}<br></span></li>
                            <li><i class="fa fa-envelope"></i><span class="mail2"><a href="#">{{ $ps->email }}</a></span></li>
                            <li><i class="fa fa-mobile"></i><span class="phone2">{{$ps->phone}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<a id="scrollup">Scroll</a> </footer>
<div class="footer-bottom">
    <div class="container">
        <div class="copyright">Powered By<a class="yourstore" href="#">bootera &copy; 2020 </a> </div>
        <div class="footer-bottom-cms">
            <div class="footer-payment">
                <ul>
                    <li class="mastero"><a href="#"><img alt="" src="public/assets/front/image/payment/mastero.jpg"></a></li>
                    <li class="visa"><a href="#"><img alt="" src="public/assets/front/image/payment/visa.jpg"></a></li>
                    <li class="currus"><a href="#"><img alt="" src="public/assets/front/image/payment/currus.jpg"></a></li>
                    <li class="discover"><a href="#"><img alt="" src="public/assets/front/image/payment/discover.jpg"></a></li>
                    <li class="bank"><a href="#"><img alt="" src="public/assets/front/image/payment/bank.jpg"></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>