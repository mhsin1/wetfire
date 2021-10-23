@extends('layouts.admin')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                      <h3 class="mt-3 text-center">Home Page Data</h3>
                      <h6 class="mb-5 text-center">(Section B)</h6>
                      @include('includes.admin.form-both') 
                      <form id="geniusformdata" action="{{route('admin-cms-update')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <h6 class="mb-5 text-center">Banner 1</h6>
                         <!-- <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('First Panel Heading') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_fp_heading" placeholder="{{ __('Enter First Panel Heading') }}"  value="{{ $gs->home_fp_heading }}">
                          </div>
                        </div> -->

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('First Panel Url') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_fp_shop_now" placeholder="{{ __('Enter First Panel Shop Now') }}"  value="{{ $gs->home_fp_shop_now }}">
                          </div>
                        </div>



                        <!--<div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('First Panel Price') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_fp_price" placeholder="{{ __('Enter First Panel Price') }}"  value="{{ $gs->home_fp_price }}">
                          </div>
                        </div> -->


                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                <h4 class="heading">{{ __('Set First Paragraph Image') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <div class="img-upload">
                                <div id="image-preview" class="img-preview" style="background: url({{ asset('public/assets/images/home/'.$gs->home_fp_image) }});">
                                  <label for="image-upload" class="img-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                  <input type="file" name="home_fp_image" class="img-upload">
                                </div>
                              </div>
                            </div>
                          </div>



                        <h6 class="mb-5 mt-5 text-center">Banner 2</h6>
                         <!-- <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Second Panel Heading') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_sp_heading" placeholder="{{ __('Enter Second Panel Heading') }}"  value="{{ $gs->home_sp_heading }}">
                          </div>
                        </div> -->

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Second Panel Url') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_sp_shop_now" placeholder="{{ __('Enter Second Panel Shop Now') }}"  value="{{ $gs->home_sp_shop_now }}">
                          </div>
                        </div>



                        <!-- <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Second Panel Price') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_sp_price" placeholder="{{ __('Enter Second Panel Price') }}"  value="{{ $gs->home_sp_price }}">
                          </div>
                        </div> -->


                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                <h4 class="heading">{{ __('Set Second Paragraph Image') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <div class="img-upload">
                              <div id="image-preview" class="img-preview" style="background: url({{ asset('public/assets/images/home/'.$gs->home_sp_image) }});">
                                  <label for="image-upload" class="img-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                  <input type="file" name="home_sp_image" class="img-upload">
                                </div>
                              </div>
                            </div>
                          </div>


                        <!-- <h6 class="mb-5 text-center">Paragraph 3</h6> -->
                        <!-- <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Third Panel Heading') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_tp_heading" placeholder="{{ __('Enter Third Panel Heading') }}"  value="{{ $gs->home_tp_heading }}">
                          </div>
                        </div> -->

                        <!-- <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Third Panel Url') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_tp_shop_now" placeholder="{{ __('Enter Third Panel Shop Now') }}"  value="{{ $gs->home_tp_shop_now }}">
                          </div>
                        </div> -->



                        <!-- <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Third Panel Price') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="home_tp_price" placeholder="{{ __('Enter Third Panel Price') }}"  value="{{ $gs->home_tp_price }}">
                          </div>
                        </div> -->


                        <!-- <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                <h4 class="heading">{{ __('Set Third Paragraph Image') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <div class="img-upload">
                              <div id="image-preview" class="img-preview" style="background: url({{ asset('public/assets/images/home/'.$gs->home_tp_image) }});">
                                  <label for="image-upload" class="img-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                  <input type="file" name="home_tp_image" class="img-upload">
                                </div>
                              </div>
                            </div>
                          </div> -->

                      <!-- <h3 class="mt-5 mb-5 text-center">Offers Section</h3> -->
                      <!-- <div class="row">
                        <div class="col-lg-4">
                          <div class="left-area">
                              <h4 class="heading">{{ __('Offers Heading') }} *</h4>
                              <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                          </div>
                        </div>
                        <div class="col-lg-7">
                          <input type="text" class="input-field" name="home_offers_heading" placeholder="{{ __('Enter Offers Heading') }}"  value="{{ $gs->home_offers_heading }}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-4">
                          <div class="left-area">
                              <h4 class="heading">{{ __('Offers text') }} *</h4>
                              <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                          </div>
                        </div>
                        <div class="col-lg-7">
                          <textarea class="nic-edit" name="home_offers_text" id="" cols="30" rows="10">{{$gs->home_offers_text}}</textarea>
                        </div>
                      </div> -->


                      <h3 class="mt-5 mb-5 text-center">Featured Products Section</h3>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="left-area">
                              <h4 class="heading">{{ __('Featured Heading') }} *</h4>
                              <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                          </div>
                        </div>
                        <div class="col-lg-7">
                          <input type="text" class="input-field" name="home_featured_heading" placeholder="{{ __('Enter Featured Heading') }}"  value="{{ $gs->home_featured_heading }}">
                        </div>
                      </div>


                      <!-- <div class="row">
                        <div class="col-lg-4">
                          <div class="left-area">
                              <h4 class="heading">{{ __('Featured text') }} *</h4>
                              <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                          </div>
                        </div>
                        <div class="col-lg-7">
                          <textarea class="nic-edit" name="home_featured_text" id="" cols="30" rows="10">{{$gs->home_featured_text}}</textarea>
                        </div>
                      </div> -->


                      <!-- <h3 class="mt-5 mb-5 text-center">Testimonials Section</h3>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="left-area">
                              <h4 class="heading">{{ __('Testimonials Heading') }} *</h4>
                              <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                          </div>
                        </div>
                        <div class="col-lg-7">
                          <input type="text" class="input-field" name="home_testimonials_heading" placeholder="{{ __('Enter Testimonial Heading') }}"  value="{{ $gs->home_testimonials_heading }}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-4">
                          <div class="left-area">
                              <h4 class="heading">{{ __('Testimonials text') }} *</h4>
                              <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                          </div>
                        </div>
                        <div class="col-lg-7">
                          <textarea class="nic-edit" name="home_testimonials_text" id="" cols="30" rows="10">{{$gs->home_testimonials_text}}</textarea>
                        </div>
                      </div> -->


                      <h3 class="mt-5 mb-5 text-center">Footer</h3>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="left-area">
                              <h4 class="heading">{{ __('Footer Text') }} *</h4>
                              <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                          </div>
                        </div>
                        <div class="col-lg-7">
                          <textarea class="nic-edit" name="footer_text" id="" cols="30" rows="10">{{$gs->footer_text}}</textarea>
                        </div>
                      </div>


                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save Data') }}</button>
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