<div id="quick-details" class="row">
    <!-- Main Thumbnail Image Start -->
    <div class="col-lg-5 col-md-6 mb-all-40">
        <!-- Thumbnail Large Image start -->
        <div class="tab-content">
            <div id="offer-{{$offer->id}}" class="tab-pane fade show active">
                <a data-fancybox="images" href="{{ asset('public/assets/images/offers/'.$offer->image)}}">
                    <img src="{{ asset('public/assets/images/offers/'.$offer->image)}}" alt="product-view">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="quatity-stock mt-3">
                <ul class="d-flex flex-wrap  align-items-center">
                    <li>
                        <button class="add-offer-to-cart pro-cart" data-href="{{ route('product.offer.cart.add',$offer->id) }}">add to cart</button>
                    </li>
                </ul>
            </div>
            <div class="social-sharing mt-30">
                <ul>
                    <li>
                        <label>share</label>
                    </li>
                    @php $url = route('front.offers'); @endphp
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
        <!-- Thumbnail Large Image End -->
        <!-- Thumbnail Image End -->

        <!-- Thumbnail image end -->
    </div>
    <!-- Main Thumbnail Image End -->
    <!-- Thumbnail Description Start -->
    <div class="col-lg-7 col-md-6">
        <div class="thubnail-desc fix">
            <h3 class="product-header">{{ $offer->name }}</h3>
            <div class="pro-thumb-price mt-10">
                <p class="d-flex align-items-center">
                    @if($offer->type == 1)
                    <span class="prev-price">{{ $offer->product->showPrice() }}</span>
                    @endif
                    @if($offer->type == 2)
                    <span class="prev-price">{{$curr->sign}}{{ $offer->product->showOnlyPrice() * $offer->quantity }}</span>
                    @endif
                    <span class="price">{{ $offer->showPrice() }}</span>
                    @if($offer->type == 1) <span class="saving-price">-{{ $offer->discount }}% </span> @endif
                    @if($offer->type == 2) <span class="saving-price">-{{ $offer->discount_q }}%</span> @endif
                </p>
            </div>
            <p class="pro-desc-details">{!! $offer->description !!}</p>
            @if($offer->type == 0)
            <div class="row">
                <div class="col-md-6">
                <a href="{{route('front.product' , $offer->product->slug)}}">
                    <div class="pro-img prods">
                    <img class="img" src="{{asset('public/assets/images/products/'.$offer->product->photo)}}" alt="">
                        <span class="sticker-new">Item</span>
                    </div>
                </a>
                    <p class="text-center"><b><a href="{{route('front.product' , $offer->product->slug)}}">{{ $offer->product->name }}</a></b> <br>
                        Price: {{ $offer->product->showPrice() }} <br>
                        <!-- Description : {!! str_limit($offer->product->details , 600) !!} -->
                    </p>
                </div>
                <div class="col-md-6">
                    <a href="{{route('front.product' , $offer->free->slug)}}">
                        <div class="pro-img prods">
                            <img class="img" src="{{asset('public/assets/images/products/'.$offer->free->photo)}}" alt="">
                            <span class="sticker-new">Free</span>
                        </div>
                    </a>
                    <p class="text-center"><b><a href="{{route('front.product' , $offer->product->slug)}}">{{ $offer->free->name }}</a></b> <br>
                        Price : {{ $offer->product->showPrice() }} <br>
                        <!-- Description : {!! str_limit($offer->free->details , 600) !!}  -->
                    </p>
                </div>
            </div>
            @endif

            @if($offer->type == 1)
            <div class="row">
                <div class="col-md-12 mt-3"><h6>Product Details</h6></div>
                <div class="col-md-4">
                <a href="{{route('front.product' , $offer->product->slug)}}">
                    <img class="img" src="{{asset('public/assets/images/products/'.$offer->product->photo)}}" alt="">
                </a>
                </div>
                <div class="col-md-8">
                    <p class="text-left"><b><a href="{{route('front.product' , $offer->product->slug)}}">{{ $offer->product->name }}</a></b> <br>
                        Price : {{ $offer->product->showPrice() }} <br>
                        <!-- Description : {!! str_limit($offer->product->details , 600) !!} -->
                    </p>
                </div>
            </div>
            @endif


        @if($offer->type == 2)
            <div class="row">
                <div class="col-md-12 mt-3"><h6>Product Details</h6></div>
                <div class="col-md-4">
                <a href="{{route('front.product' , $offer->product->slug)}}">
                    <img class="img" src="{{asset('public/assets/images/products/'.$offer->product->photo)}}" alt="">
                </a>
                </div>
                <div class="col-md-8">
                    <p class="text-left"><b><a href="{{route('front.product' , $offer->product->slug)}}">{{ $offer->product->name }}</a></b> <br>
                        Price : {{ $offer->product->showPrice() }} <br>
                        <!-- Description : {!! str_limit($offer->product->details , 600) !!} -->
                    </p>
                </div>
            </div>
            @endif

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