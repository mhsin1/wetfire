@extends('layouts.front')
@section('styles')
<style>
      .vendor-banner{
        margin-top:150px !important;
      }
      .modal-header .close span{
         position:absolute;
         top:5px;
         right:10px;
         z-index:999;
      }
      .modal-header .close span:hover{
        color:#252525;
      }

      .product-details-page .right-area .product-info .info-meta-3 .meta-list li.addtocart a {
          font-size: 14px;
          color: #fff;
          display: inline-block;
          border: 1px solid #fe4c50;
          background: #fe4c50;
          padding: 0px 18px;
          line-height: 30px;
          margin-bottom:10px;
          margin-top:10px;
          font-weight: 600;
          border-radius: 0px;
          -webkit-transition: all 0.3s ease-in;
          -o-transition: all 0.3s ease-in;
          transition: all 0.3s ease-in;
      }
      .custom-control-label{
        color:#636363;
      }
      .product-details-page .right-area .product-info .mproduct-color .color-list li .box {
          width: 30px;
          height: 30px;
          border-radius: 50%;
          display: inline-block;
          position: relative;
          cursor: pointer;
          border:1px solid #f3f3f3;
          /* font-size: 10px; */
      }
      .product-details-page .right-area .product-info .product-name a{
         color:#252525;
      }
      .product-details-page .right-area .product-info .product-name a:hover{
         color:#252525;
      }


      .custom-control-input:checked~.custom-control-label::before {
          color: #fff;
          border-color: #fe4c50;
          background-color: #fe4c50;
      }
      @media  screen and (max-width: 600px) {
        .vendor-banner{
          margin-top:80px !important;
        }
        .product-shop{
          padding-top:20px;
        }
        .sub-categori {
            padding: 0px 0px 0px;
        }
        .mt-xs-0{
          margin-top:0px !important;
        }
      }
      .produts-sidebar-filter .sub-content.open {
          display: block;
      }
      .produts-sidebar-filter .sub-content {
          padding-left: 10px !important;
          margin-top: 8px;
          display: none;
      }
      .produts-sidebar-filter li {
          margin-bottom: 6px;
      }
      .produts-sidebar-filter .child-content.open {
          display: block;
      }
      .produts-sidebar-filter .child-content {
          padding-left: 10px !important;
          margin-top: 8px;
      }
      .filter-widget .filter-list li a {
          display: inline-block;
          color: #636363;
          font-size: 16px;
          line-height: 39px;
          cursor: pointer;
      }
      .page-center ul.pagination li , ul.pagination .disabled{
        background:black;
      }
      .pagination>.disabled>span, .pagination>.disabled>span:hover, .pagination>.disabled>span:focus, .pagination>.disabled>a, .pagination>.disabled>a:hover, .pagination>.disabled>a:focus {
          color: #fff !important; 
          background-color: #282828 !important; 
          border:0;
          cursor: not-allowed
      }
      .page-center ul.pagination li, ul.pagination .disabled {
        background:none;
      }
    .filter-widget{
      color:#636363;
    }
    .fw-title{
      color:#252525;
    }


    .page-center ul.pagination li {
      width: 35px;
      height: 35px;
      text-align: center;
      font-size: 14px;
      line-height: 35px;
      margin: 0px;
      transition: all .3s;
      display: inline-block;
      cursor: pointer;
  }

  .page-center ul.pagination li a{
    background:black;
    color:white;
  }
  .page-center ul.pagination li a:hover {
    color: #fff !important;
  }
  </style>

@endsection
@section('content')


<!-- Vendor Area Start -->
  <div class="vendor-banner" style="background: url({{  $vendor->shop_image != null ? asset('assets/images/vendorbanner/'.$vendor->shop_image) : '' }}); background-repeat: no-repeat; background-size: cover;background-position: center;{!! $vendor->shop_image != null ? '' : 'background-color:'.$gs->vendor_color !!} ">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <p class="sub-title">
                {{ $langg->lang226 }}
            </p>
            <h2 class="title">
              {{ $vendor->shop_name }}
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>



<!-- SubCategori Area Start -->
  <section class="sub-categori">
    <div class="container">
      <div class="row">

        @include('includes.vendor-catalog')

        <div class="col-lg-9 order-first order-lg-last">
          <div class="right-area">

            @if(count($vprods) > 0)

              @include('includes.vendor-filter')

            <div class="categori-item-area mt-5 mt-xs-0">
              {{-- <div id="ajaxContent"> --}}
                <div class="row">

                  @foreach($vprods as $prod)
                    @include('includes.product.product')
                  @endforeach

                </div>
                  <div class="page-center category">
                    {!! $vprods->appends(['sort' => request()->input('sort'), 'min' => request()->input('min'), 'max' => request()->input('max')])->links() !!}
                  </div>
              {{-- </div> --}}
            </div>

            @else
              <div class="page-center">
                <h4 class="text-center">{{ $langg->lang60 }}</h4>
              </div>
            @endif


          </div>
        </div>
      </div>
    </div>
  </section>
<!-- SubCategori Area End -->


@if(Auth::guard('web')->check())

{{-- MESSAGE VENDOR MODAL --}}

<div class="message-modal">
  <div class="modal" id="vendorform1" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel1">{{ $langg->lang118 }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <div class="container-fluid p-0">
          <div class="row">
            <div class="col-md-12">
              <div class="contact-form">

                <form id="emailreply">
                  {{csrf_field()}}
                  <ul>

                    <li>
                      <input type="text" class="input-field" readonly="" placeholder="Send To {{ $vendor->shop_name }}" readonly="">
                    </li>

                    <li>
                      <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ $langg->lang119}}" required="">
                    </li>

                    <li>
                      <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ $langg->lang120 }}" required=""></textarea>
                    </li>

                    <input type="hidden" name="email" value="{{ Auth::guard('web')->user()->email }}">
                    <input type="hidden" name="name" value="{{ Auth::guard('web')->user()->name }}">
                    <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
                    <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">

                  </ul>
                  <button class="submit-btn" id="emlsub1" type="submit">{{ $langg->lang118 }}</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>

{{-- MESSAGE VENDOR MODAL ENDS --}}


@endif

@endsection

@section('scripts')

<script type="text/javascript">

  $(function () {
    $("#slider-range").slider({
    range: true,
    orientation: "horizontal",
    min: 0,
    max: 10000000,
    values: [{{ isset($_GET['min']) ? $_GET['min'] : '0' }}, {{ isset($_GET['max']) ? $_GET['max'] : '10000000' }}],
    step: 5,

    slide: function (event, ui) {
      if (ui.values[0] == ui.values[1]) {
        return false;
      }

      $("#min_price").val(ui.values[0]);
      $("#max_price").val(ui.values[1]);
    }
    });

    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));

  });
</script>

<script type="text/javascript">
          $(document).on("submit", "#emailreply" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          var email = $(this).find('input[name=email]').val();
          var name = $(this).find('input[name=name]').val();
          var user_id = $(this).find('input[name=user_id]').val();
          var vendor_id = $(this).find('input[name=vendor_id]').val();
          $('#subj').prop('disabled', true);
          $('#msg').prop('disabled', true);
          $('#emlsub').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('/vendor/contact')}}",
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                'email'   : email,
                'name'  : name,
                'user_id'   : user_id,
                'vendor_id'  : vendor_id
                  },
            success: function() {
          $('#subj').prop('disabled', false);
          $('#msg').prop('disabled', false);
          $('#subj').val('');
          $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        toastr.success("{{ $langg->message_sent }}");
        $('.ti-close').click();
            }
        });
          return false;
        });
</script>


@endsection
