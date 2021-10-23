<div id="column-left" class="col-md-3 col-sm-12 col-xs-12 column-left">
      <div class="">
      @if(isset($_GET['search']) && !empty($_GET['search']))
      <div class="columnblock-title">Filter by Search</div>
      <div class="category_block">
        <div class="search-filter mb-30" style="padding:10px 20px;">
            <div class="row">
              <h3 class="sidebar-title">Search</h3>
              <a href="{{ route('front.category') }}"><span id="search-tag">{{ $_GET['search'] }} <i class="fa fa-times"></i></span></a>
            </div>
        </div>
      </div>
      @endif

        <div class="columnblock-title">Filter by prices</div>
        <div class="category_block">
        <form id="catalogForm" action="{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}" method="GET">
            @if (!empty(request()->input('search')))
            <input type="hidden" name="search" value="{{ request()->input('search') }}">
            @endif
            @if (!empty(request()->input('sort')))
            <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
            @endif

            <div id="slider-range"></div>
            <input type="hidden" name="min" value="0" id="minamount" />
            <input type="hidden" name="max" value="500" id="maxamount" />
            <input type="text" id="amount" class="amount-range" readonly>
            <div style="margin-top:5%;" class="text-center">
                <button class="btn btn-block filter-btn btn-default" type="submit">{{$langg->lang58}}</button>
            </div>
        </form>
        </div>


        <div class="columnblock-title">Categories</div>
        <div class="category_block">
          <ul class="box-category treeview-list treeview">

            @foreach ($categories as $element)
            @if($element->subs->count() > 0)
            <li>
                <!--<a href="{{route('front.category',$element->slug)}}" class="activSub">{{ $element->name }}</a>-->
                <a href="javascript:;">{{ $element->name }}</a>
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

@if ((!empty($cat) && !empty(json_decode($cat->attributes, true))) || (!empty($subcat) && !empty(json_decode($subcat->attributes, true))) || (!empty($childcat) && !empty(json_decode($childcat->attributes, true))))

        <div class="columnblock-title">Refine Search</div>
        <div class="category_block">
          <ul class="box-category treeview-list treeview">

<form id="attrForm" action="{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}" method="post">
@if (!empty($cat) && !empty(json_decode($cat->attributes, true)))
      @foreach ($cat->attributes as $key => $attr)

            <li><a href="javascript:;" class="activSub">{{$attr->name}}</a>
              <ul>
              @if(!empty($attr->attribute_options))
                  @foreach ($attr->attribute_options as $key => $option)
                    <li>
                        <label class="checkbox">
                            <input class="form-check-input attribute-input" name="{{$attr->input_name}}[]" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}" type="checkbox">
                            <!-- <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}"></label> -->
                            {{$option->name}}
                        </label>
                    </li>
                  @endforeach
                @endif
              </ul>
            </li>

    @endforeach
@endif


@if (!empty($subcat) && !empty(json_decode($subcat->attributes, true)))
    @foreach ($subcat->attributes as $key => $attr)

            <li><a href="javascript:;" class="activSub">{{$attr->name}}</a>
              <ul>
              @if(!empty($attr->attribute_options))
                  @foreach ($attr->attribute_options as $key => $option)
                    <li>
                        <label class="checkbox">
                            <input class="form-check-input attribute-input" name="{{$attr->input_name}}[]" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}" type="checkbox">
                            <!-- <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}"></label> -->
                            {{$option->name}}
                        </label>
                    </li>
                  @endforeach
                @endif
              </ul>
            </li>

    @endforeach
@endif

            </form>
          </ul>
        </div>

@endif

      @php 
        $check = 0;
        foreach($prods as $key => $prod){
          if($prod->best == 1){
            $check = 1;
            break;
          }
        }
      @endphp

      @if($check == 1)
      <h3 class="productblock-title">Specials</h3>
      <div class="row special-grid product-grid">
          @php $i=0; @endphp
          @foreach($prods as $key => $prod)
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
      @endif

    </div>



