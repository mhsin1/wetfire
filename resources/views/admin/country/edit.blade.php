@extends('layouts.load')
@section('title' , 'Edit Country')
@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')
                      <form id="geniusformdata" action="{{route('admin-country-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}


                        <div class="row">
                          <div class="col-md-4">
                              <div class="row">
                              <div class="col-lg-12">
                                <div class="left-area">
                                    <h4 class="heading text-left">Current Icon *</h4>
                                </div>
                              </div>
                              <div class="col-lg-12">
                                <div class="img-upload">
                                    <div id="image-preview" class="img-preview" style="background: url({{ $data->image ? asset('assets/images/flags/'.$data->image):asset('public/assets/images/noimage.png') }});">
                                        <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>Upload Icon</label>
                                        <input type="file" name="photo" class="img-upload" id="image-upload">
                                      </div>
                                </div>

                              </div>
                            </div>
                          </div>
                          <div class="col-md-8 mt-5">
                          <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Country Name') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="country_name" placeholder="{{ __('Enter Country Name') }}" required="" value="{{$data->country_name}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Country Code') }} *</h4>
                                <p class="sub-heading">{{ __('(In English)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="country_code" placeholder="{{ __('Enter Country Code') }}" required="" value="{{$data->country_code}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Country Phone') }} *</h4>
                                <p class="sub-heading">{{ __('In English') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="number" class="input-field" name="country_phone" placeholder="{{ __('Enter Country Phone') }}" required="" value="{{$data->country_phone}}">
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
