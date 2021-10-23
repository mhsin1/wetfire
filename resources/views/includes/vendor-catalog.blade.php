<div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <ul class="filter-list">
                        @foreach ($categories as $element)
                        <li>
                          <div class="content">
                              <a href="{{route('front.category', $element->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="category-link">{{$element->name}} @if(count($element->subs) > 0)  <i class="fa fa-angle-down"></i> @endif</a>
                              @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
                                  @foreach ($cat->subs as $key => $subelement)
                                  <div class="sub-content open">
                                    <a href="{{route('front.category', [$cat->slug, $subelement->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="subcategory-link">{{$subelement->name}} @if(count($subelement->childs) > 0)  <i class="fa fa-angle-down"></i> @endif</a>
                                    @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                                      @foreach ($subcat->childs as $key => $childcat)
                                      <div class="child-content open">
                                        <a href="{{route('front.category', [$cat->slug, $subcat->slug, $childcat->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="subcategory-link"> {{$childcat->name}}</a>
                                      </div>
                                      @endforeach
                                    @endif
                                  </div>
                                  @endforeach
      
                                </div>
                              @endif
      
      
                        </li>
                        @endforeach
      
                      </ul>
                    </div>
                    
                    <div class="filter-widget">
                        <h4 class="fw-title">Price</h4>
                        <form class="price-range-block" id="priceForm" action="{{ route('front.vendor', Request::route('category')) }}">
                        @if (!empty(request()->input('sort')))
                          <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                        @endif
                        <div class="filter-range-wrap">

                          <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="33" data-max="500">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>

                            <br>

                            <div class="range-slider">
                                <div class="price-input">

                                    <input type="number"  name="min"  id="minamount" class="price-range-field">
                                    <input type="number" id="maxamount" name="max" class="price-range-field">

                                    <button type="submit" href="#" class="filter-btn">GO</button>
                                </div>
                            </div>
                        </div>

                      </form>
                    </div>
                    
                    @if ((!empty($cat) && !empty(json_decode($cat->attributes, true))) || (!empty($subcat) && !empty(json_decode($subcat->attributes, true))) || (!empty($childcat) && !empty(json_decode($childcat->attributes, true))))
                    <form id="attrForm" action="{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}" method="post">


                    @if (!empty($cat) && !empty(json_decode($cat->attributes, true)))
                            @foreach ($cat->attributes as $key => $attr)

                         <div class="filter-widget">

                          <h4 class="fw-title">{{$attr->name}}</h4>
                          <div class="fw-brand-check">
                                @if (!empty($attr->attribute_options))
                                    @foreach ($attr->attribute_options as $key => $option)
                                    <div class="bc-item">
                                      <label for="{{$attr->input_name}}{{$option->id}}">
                                        {{$option->name}}
                                          <input name="{{$attr->input_name}}[]" type="checkbox" class="attribute-input" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                          <span class="checkmark"></span>
                                      </label>
                                    </div>
                                    @endforeach
                                  @endif  
                          </div>

                        </div>

                        @endforeach
                        @endif


                        @if (!empty($subcat) && !empty(json_decode($subcat->attributes, true)))
                          @foreach ($subcat->attributes as $key => $attr)
                          <div class="filter-widget">

                          <h4 class="fw-title">{{$attr->name}}</h4>
                          <div class="fw-brand-check">
                            @if (!empty($attr->attribute_options))
                              @foreach ($attr->attribute_options as $key => $option)
                                <div class="bc-item">
                                  <label for="{{$attr->input_name}}{{$option->id}}">
                                    {{$option->name}}
                                      <input name="{{$attr->input_name}}[]" class="attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                      <span class="checkmark"></span>
                                  </label>
                                </div>
                              @endforeach
                            @endif
                            </div>
                          </div>
                          @endforeach
                        @endif

                        @if (!empty($childcat) && !empty(json_decode($childcat->attributes, true)))
                          @foreach ($childcat->attributes as $key => $attr)
                          <div class="filter-widget">

                          <h4 class="fw-title">{{$attr->name}}</h4>
                          <div class="fw-brand-check">
                            @if (!empty($attr->attribute_options))
                              @foreach ($attr->attribute_options as $key => $option)
                                <div class="bc-item">
                                  <label for="{{$attr->input_name}}{{$option->id}}">
                                    {{$option->name}}
                                      <input name="{{$attr->input_name}}[]" type="checkbox" class="attribute-input" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                      <span class="checkmark"></span>
                                  </label>
                                </div>
                              @endforeach
                            @endif
                            </div>
                          </div>
                          @endforeach
                        @endif

                    </form>
                    @endif
                </div>













