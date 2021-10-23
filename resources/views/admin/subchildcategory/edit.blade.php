@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')  
                      <form id="geniusformdata" action="{{route('admin-subchildcat-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <!-- <input type="hidden" id="catos" value="Category"> -->

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Category') }}*</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="cat" required="">
                                  <option value="">{{ __('Select Category') }}</option>
                                    @foreach($cats as $cat)
                                      <option data-href="{{ route('admin-subcat-load',$cat->id) }}" value="{{ $cat->id }}" {{ $cat->id == $data->childcategory->subcategory->category->id ? "selected":"" }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Sub Category') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="subcat"  name="subcategory_id" required="">
                                <option value="">{{ __('Select Sub Category') }}</option>
                                @foreach($data->childcategory->subcategory->category->subs as $sub)
                                  <option value="{{$sub->id}}" {{$sub->id == $data->childcategory->subcategory->id ? "selected":""}}>{{$sub->name}}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Child Category') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="childcat"  name="childcategory_id" required="">
                                <option value="">{{ __('Select Child Category') }}</option>
                                @foreach($data->childcategory->subcategory->childs as $child)
                                  <option value="{{$child->id}}" {{$child->id == $data->childcategory->id ? "selected":""}}>{{$child->name}}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Name') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="name" placeholder="{{ __('Enter Name') }}" required="" value="{{$data->name}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Slug') }} *</h4>
                                <p class="sub-heading">{{ __('(In English)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="slug" placeholder="{{ __('Enter Slug') }}" required="" value="{{$data->slug}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Sequence') }} *</h4>
                                <p class="sub-heading">{{ __('(In English)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="sequence" placeholder="{{ __('Enter Sequence') }}" required="" value="{{$data->sequence}}">
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection