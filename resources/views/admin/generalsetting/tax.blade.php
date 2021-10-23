@extends('layouts.admin')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                      <h3 class="mt-3 mb-5 text-center">Tax Settings</h3>
                      @if(Session::has('message'))
                      <div class="alert alert-success validation">
                        <button type="button" class="close alert-close"><span>×</span></button>
                        <p class="text-left">{{Session::get('message')}}</p> 
                      </div>
                      @endif
                      <form class="mt-2" action="{{route('admin-tax-update')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Tax in Pecentage') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="number" class="input-field" name="tax" placeholder="{{ __('Enter Tax Percentage') }}"  value="{{ $gs->tax }}">
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