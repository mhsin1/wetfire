<div id="quick-details" class="row">
    <!-- Main Thumbnail Image Start -->
    <div class="col-lg-5 col-md-6 mb-all-40">
        <!-- Thumbnail Large Image start -->
        <div class="tab-content">
            <div id="product-{{$product->id}}" class="tab-pane fade show active">
                <a data-fancybox="images" href="{{ asset('public/assets/images/products/'.$product->photo)}}">
                    <img src="{{ asset('public/assets/images/products/'.$product->photo)}}" alt="product-view">
                </a>
            </div>
           @foreach($product->galleries as $gal)
            <div id="pro-{{ $gal->id}}" class="tab-pane fade">
                <a data-fancybox="images" href="{{asset('public/assets/images/galleries/'.$gal->photo)}}">
                    <img src="{{asset('public/assets/images/galleries/'.$gal->photo)}}" alt="product-view" />
                </a>
            </div>
            @endforeach
        </div>
        <!-- Thumbnail Large Image End -->
        <!-- Thumbnail Image End -->
        <div class="product-thumbnail">
            <div class="thumb-menu owl-carousel nav tabs-area" role="tablist">
                <a class="active" data-toggle="tab" href="#product-{{$product->id}}">
                    <img src="{{ asset('public/assets/images/products/'.$product->photo)}}" alt="product-thumbnail">
                </a>
                @foreach($product->galleries as $gal)
                <a data-toggle="tab" href="#pro-{{ $gal->id}}">
                    <img src="{{asset('public/assets/images/galleries/'.$gal->photo)}}" alt="product-thumbnail">
                </a>
                @endforeach
            </div>
        </div>
        <!-- Thumbnail image end -->
    </div>
    <!-- Main Thumbnail Image End -->
    <!-- Thumbnail Description Start -->
    <div class="col-lg-7 col-md-6">
        <div class="thubnail-desc fix">
            <h3 class="product-header"><a href="{{route('front.product' , $product->slug )}}">{{ $product->name }}</a></h3>
            <ul class="rating-summary">
                {!! $product->showRating() !!}
                <!-- <li class="read-review">
                    <a href="#">read reviews (1)</a>
                </li>
                <li class="write-review">
                    <a href="#">write review</a>
                </li> -->
            </ul>
            <div class="pro-thumb-price mt-10">
                <p class="d-flex align-items-center">
                    @if($product->previous_price)<span class="prev-price">{{ $product->showPreviousPrice() }}</span>@endif
                    <span id="msizeprice" class="price">{{ $product->showPrice() }}</span>
                    @if($product->dsc)<span class="saving-price">-{{$product->dsc}}%</span>@endif
                </p>
            </div>
            <div class="pro-desc-details">{!! $product->details !!}</div>


            <input type="hidden" id="mproduct_price" value="{{ round($product->vendorPrice() * $curr->value,2) }}">
            <input type="hidden" id="mproduct_id" value="{{ $product->id }}">
            <input type="hidden" id="mcurr_pos" value="{{ $gs->currency_format }}">
            <input type="hidden" id="mcurr_sign" value="{{ $curr->sign }}">

            <div class="info-meta-3">
                    <ul class="meta-list">
                      @if (!empty($product->attributes))
                        @php
                          $attrArr = json_decode($product->attributes, true);
                        @endphp
                      @endif
                      @if (!empty($attrArr))
                        <div class="product-attributes my-4">
                          <div class="row">
                          @foreach ($attrArr as $attrKey => $attrVal)
                            @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)

                          <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <strong for="" class="text-capitalize">{{ str_replace("_", " ", $attrKey) }} :</strong>
                                <div class="mt-3">
                                @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                  <div class="custom-control custom-radio">
                                    <input type="hidden" class="keys" value="">
                                    <input type="hidden" class="values" value="">
                                    <input type="radio" id="{{$attrKey}}{{ $optionKey }}" name="{{ $attrKey }}" class="custom-control-input mproduct-attr"  data-key="{{ $attrKey }}" data-price = "{{ $attrVal['prices'][$optionKey] * $curr->value }}" value="{{ $optionVal }}" {{ $loop->first ? 'checked' : '' }}>
                                    <label class="custom-control-label radio-inline" for="{{$attrKey}}{{ $optionKey }}">{{ $optionVal }}

                                    @if (!empty($attrVal['prices'][$optionKey]))
                                      +
                                      {{$curr->sign}} {{$attrVal['prices'][$optionKey] * $curr->value}}
                                    @endif
                                    </label>
                                  </div>
                                @endforeach
                                </div>
                              </div>
                          </div>
                            @endif
                          @endforeach
                          </div>
                        </div>
                      @endif

                      @if($product->emptyStock())
                      <li class="addtocart">
                        <a href="javascript:;" class="cart-out-of-stock">
                          <i class="icofont-close-circled"></i>
                          {{ $langg->lang78 }}</a>
                      </li>
                      @endif



                    </ul>
                  </div>

            <!-- <div class="product-size mtb-30 clearfix">
                <label>Size</label>
                <select class="">
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                </select>
            </div>
            <div class="color clearfix mb-30">
                <label>color</label>
                <ul class="color-list">
                    <li>
                        <a class="white" href="#"></a>
                    </li>
                    <li>
                        <a class="orange active" href="#"></a>
                    </li>
                    <li>
                        <a class="paste" href="#"></a>
                    </li>
                </ul>
            </div> -->
            <div class="quatity-stock mt-3">
                <label>Quantity</label>
                <ul class="d-flex flex-wrap  align-items-center">
                    <li class="box-quantity">
                        <form action="#">
                            <input class="quantity qttotal" type="number" min="1" value="1">
                        </form>
                    </li>
                    <li>
                        <button class="pro-cart" id="maddcrt">add to cart</button>
                    </li>
                    <li class="pro-ref">
                        <p>
                            <span class="in-stock">
                                <i class="ion-checkmark-round"></i>                                 
                                @if($product->stock != null)
                                    {{ $product->stock}} items(s) In Stock
                                @endif
                                </span>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="social-sharing mt-30">
                <ul>
                    <li><label>share</label></li>
                    @php $url = route('front.product',$product->slug); @endphp
                    <li><a target="_blank" href="http://www.facebook.com/sharer.php?u={{$url}}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" href="http://twitter.com/share?url={{$url}}&text=Simple Share Buttons&hashtags=simplesharebuttons"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" href="https://plus.google.com/share?url={{$url}}"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{$url}}"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" href="mailto:?Subject=Simple Share Buttons&Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{$url}}"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Thumbnail Description End -->
</div>




<script type="text/javascript">
//   magnific popup activation

$('.thumb-menu').owlCarousel({
        loop: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        margin: 15,
        smartSpeed: 500,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 3,
                autoplay: true,
            },
            768: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    })
    $('.thumb-menu a').on('click', function () {
        $('.thumb-menu a').removeClass('active');
    })

var sizes = "";
var size_qty = "";
var size_price = "";
var size_key = "";
var colors = "";
var mtotal = "";
var mstock = $('.product-stock').val();
var keys = "";
var values = "";
var prices = "";

$('.mproduct-attr').on('change',function(){

var total;
total = mgetAmount()+mgetSizePrice();
total = total.toFixed(2);
var pos = $('#mcurr_pos').val();
var sign = $('#mcurr_sign').val();
if(pos == '0')
{
$('#msizeprice').html(sign+total);
}
else {
$('#msizeprice').html(total+sign);
}
});



function mgetSizePrice()
{

var total = 0;
if($('.mproduct-size .siz-list li').length > 0)
{
total = parseFloat($('.mproduct-size .siz-list li.active').find('.msize_price').val());
}
return total;
}


function mgetAmount()
{
var total = 0;
var value = parseFloat($('#mproduct_price').val());
var datas = $(".mproduct-attr:checked").map(function() {
return $(this).data('price');
}).get();

var data;
for (data in datas) {
total += parseFloat(datas[data]);
}
total += value;
return total;
}


// Product Details Product Size Active Js Code
$('.mproduct-size .siz-list .box').on('click', function () {

$('.modal-total').html('1');
var parent = $(this).parent();
size_qty = $(this).find('.msize_qty').val();
size_price = $(this).find('.msize_price').val();
size_key = $(this).find('.msize_key').val();
sizes = $(this).find('.msize').val();
      $('.mproduct-size .siz-list li').removeClass('active');
      parent.addClass('active');
total = mgetAmount()+parseFloat(size_price);
stock = size_qty;
total = total.toFixed(2);
var pos = $('#mcurr_pos').val();
var sign = $('#mcurr_sign').val();
if(pos == '0')
{
$('#msizeprice').html(sign+total);
}
else {
$('#msizeprice').html(total+sign);
}

});

// Product Details Product Color Active Js Code
$('.mproduct-color .color-list .box').on('click', function () {
colors = $(this).data('color');
var parent = $(this).parent();
$('.mproduct-color .color-list li').removeClass('active');
parent.addClass('active');

});

$('.modal-minus').on('click', function () {
var el = $(this);
var $tselector = el.parent().parent().find('.modal-total');
total = $($tselector).text();
if (total > 1) {
  total--;
}
$($tselector).text(total);
});

$('.modal-plus').on('click', function () {
var el = $(this);
var $tselector = el.parent().parent().find('.modal-total');
total = $($tselector).text();
if(mstock != "")
{
  var stk = parseInt(mstock);
  if(total < stk)
  {
      total++;
      $($tselector).text(total);
  }
}
else {
  total++;
}
$($tselector).text(total);
});

$("#maddcrt").on("click", function(){
var qty = $('.qttotal').val();
var pid = $(this).parent().parent().parent().parent().find("#mproduct_id").val();

if($('.mproduct-attr').length > 0)
{
values = $(".mproduct-attr:checked").map(function() {
return $(this).val();
}).get();

keys = $(".mproduct-attr:checked").map(function() {
return $(this).data('key');
}).get();


prices = $(".mproduct-attr:checked").map(function() {
return $(this).data('price');
}).get();

}



$.ajax({
  type: "GET",
  url:mainurl+"/addnumcart",
  data:{id:pid,qty:qty,size:sizes,color:colors,size_qty:size_qty,size_price:size_price,size_key:size_key,keys:keys,values:values,prices:prices},
  success:function(data){
      if(data == 'digital') {
          toastr.error(langg.already_cart);
      }
      else if(data == 0) {
          toastr.error(langg.out_stock);
      }
      else {
          $("#cart-count").html(data[0]);
          $("#cart-paisa").html(data[9]);
          $("#cart-items").load(mainurl+'/carts/view');
          toastr.success(langg.add_cart);
      }
  }
});
});


$(document).on("click", "#mqaddcrt" , function(){
      var qty = $('.modal-total').html();
      var pid = $(this).parent().parent().parent().parent().find("#mproduct_id").val();
 
if($('.mproduct-attr').length > 0)
{
values = $(".mproduct-attr:checked").map(function() {
return $(this).val();
}).get();

keys = $(".mproduct-attr:checked").map(function() {
return $(this).data('key');
}).get();


prices = $(".mproduct-attr:checked").map(function() {
return $(this).data('price');
}).get();

}

 
  window.location = mainurl+"/addtonumcart?id="+pid+"&qty="+qty+"&size="+sizes+"&color="+colors.substring(1, colors.length)+"&size_qty="+size_qty+"&size_price="+size_price+"&size_key="+size_key+"&keys="+keys+"&values="+values+"&prices="+prices;
 

 

     });


</script>