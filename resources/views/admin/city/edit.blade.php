@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')
                      <form id="geniusformdata" action="{{route('admin-city-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('City Name') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="city_name" placeholder="{{ __('Enter City Name') }}" required="" value="{{$data->city_name}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('City Code') }} *</h4>
                                <p class="sub-heading">{{ __('(In English)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="city_code" placeholder="{{ __('Enter City Code') }}" required="" value="{{$data->city_code}}">
                          </div>
                        </div>


                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('State') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <select name="state_id" class="input-field" id="" required>
                                @foreach($states as $state)
                                  <option @if($state->id == $data->state_id) selected @endif value="{{ $state->id}}">{{ $state->state_name}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">

                            </div>
                          </div>
                          <div class="col-lg-7">
                            <div class="row">
                              <div class="col-md-6 mx-auto">
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
