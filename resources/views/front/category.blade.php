@extends('layouts.front')
@section('styles')
    <style>
    .disabled{
        pointer-events: none;
        }
        span#show-total-pp{
            padding:0;
        }
        #search-tag{
            border:1px solid #fe5723;
            padding:10px 20px;
            border-radius:5px;
            margin-top:10px;
        }
        #search-tag i{
            color:#fe5723;
        }

        .filtered-products .product-detail a{
          height:25px;
          display:block;
        }        
        #amount{
          background:#F5F5F5;
          border:0;
        }
        .category_block {
            margin: 0 0 20px;
        }
        #content{
          float:right;
        }
        @media only screen and (max-width:600px){
            #column-left{
                width:100% !important;
                z-index:999;
            }
        }
    </style>
@endsection

@section('content')

<ul class="breadcrumb">
    <li><a href="index-2.html"><i class="fa fa-home"></i></a></li>

                            @if(!empty($childcat)) 
                            <li><a href="category.html">

                                {{ $childcat->name }} 
                                </a></li>
                            @endif

                            @if(!empty($subcat))
                            <li><a href="category.html">

                                {{ $subcat->name }}
                                </a></li>
                            @endif

                            @if(!empty($cat))
                            <li><a href="category.html">

                                {{ $cat->name }}
                                </a></li>
                            @endif

                            @if(empty($cat) && empty($subcat))
                            <li><a href="category.html">                          
                                Category
                                </a></li>
                            @endif

  </ul>
  <div class="row">
    <div id="content" class="col-sm-9">
        @include('includes.filter')
      <br />
      <div id="ajaxContent">
        @include('includes.product.filtered-products')
      </div>
    </div>
    @include('includes.catalog')                        
  </div>

@endsection

@section('scripts')
<script>

  $(document).ready(function() {
    var categories = [];
    @php
    $caties = [];
    if(isset($_GET['categories'])){
     $caties = [];
     $caties = explode(',', $_GET['categories']);     
    }
    @endphp
    categories = @php echo json_encode($caties); @endphp;
    addToPagination();
    // when dynamic attribute changes
    $(".attribute-input, #sortby").on('change', function() {
      $("#ajaxLoader").show();
      filter();
    });

    $('input[name="cat[]"]').on('change', function (e) {
        e.preventDefault();
        categories = [];
        $('input[name="cat[]"]:checked').each(function(){
            categories.push($(this).val());
        });
        $("#ajaxLoader").show();
        filter();
    });

    // when price changed & clicked in search button
    $(".filter-btn").on('click', function(e) {
      e.preventDefault();
      $("#ajaxLoader").show();
      filter();
    });

  function filter() {
    let filterlink = '';

    if ($("#prod_name").val() != '' && $("#prod_name").val() != undefined) {
      if (filterlink == '') {
        filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?search='+$("#prod_name").val();
      } else {
        filterlink += '&search='+$("#prod_name").val();
      }
    }

    if (categories.length > 0) {
      if (filterlink == '') {
        filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?'+'categories='+categories;
      } else {
        filterlink += '&categories='+categories;
      }
    }

    $(".attribute-input").each(function() {
      if ($(this).is(':checked')) {
        if (filterlink == '') {
          filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?'+$(this).attr('name')+'='+$(this).val();
        } else {
          filterlink += '&'+$(this).attr('name')+'='+$(this).val();
        }
      }
    });

    if ($("#sortby").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?'+$("#sortby").attr('name')+'='+$("#sortby").val();
      } else {
        filterlink += '&'+$("#sortby").attr('name')+'='+$("#sortby").val();
      }
    }

    if ($("#minamount").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?'+$("#minamount").attr('name')+'='+$("#minamount").val();
      } else {
        filterlink += '&'+$("#minamount").attr('name')+'='+$("#minamount").val();
      }
    }

    if ($("#maxamount").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}' + '?'+$("#maxamount").attr('name')+'='+$("#maxamount").val();
      } else {
        filterlink += '&'+$("#maxamount").attr('name')+'='+$("#maxamount").val();
      }
    }

    // console.log(filterlink);
    console.log(encodeURI(filterlink));
    $("#ajaxContent").load(encodeURI(filterlink), function(data) {
      // add query string to pagination
      addToPagination();
      $("#ajaxLoader").fadeOut(1000);
      $('#show-total-pp').html($('#total-pp').val());  
    });
  }

  // append parameters to pagination links
  function addToPagination() {
    // add to attributes in pagination links
    $('.pagination-url').each(function() {
      let url = $(this).attr('href');
      let queryString = '?' + url.split('?')[1]; // "?page=1234...."

      let urlParams = new URLSearchParams(queryString);
      let page = urlParams.get('page'); // value of 'page' parameter
      let fullUrl = '{{route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')])}}?page='+page+'&search='+'{{request()->input('search')}}';

      $(".attribute-input").each(function() {
        if ($(this).is(':checked')) {
          fullUrl += '&'+encodeURI($(this).attr('name'))+'='+encodeURI($(this).val());
        }
      });

      if ($("#sortby").val() != '') {
        fullUrl += '&sort='+encodeURI($("#sortby").val());
      }

      if ($("#minamount").val() != '') {
        fullUrl += '&min='+encodeURI($("#minamount").val());
      }

      if ($("#maxamount").val() != '') {
        fullUrl += '&max='+encodeURI($("#maxamount").val());
      }

    if (categories.length > 0) {
        fullUrl += '&categories='+categories;
    }

      $(this).attr('href', fullUrl);
    });
  }

  $(document).on('click', '.categori-item-area .pagination li a', function (event) {
    event.preventDefault();
    if ($(this).attr('href') != '#' && $(this).attr('href')) {
      $('#preloader').show();
      $('#ajaxContent').load($(this).attr('href'), function (response, status, xhr) {
        if (status == "success") {
          $('#preloader').fadeOut();
          $("html,body").animate({
            scrollTop: 0
          }, 1);

          addToPagination();
        }
      });
    }
  });
});

</script>
@endsection