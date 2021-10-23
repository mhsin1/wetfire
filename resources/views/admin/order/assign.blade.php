@extends('layouts.load')




@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')  

                      <form id="geniusformdata" action="{{route('admin-order-assign-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <input type="hidden" value="{{ $data->id }}" name="order_id" />

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Drivers') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="driver_id" required="">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                            <button class="addProductSubmit-btn" type="submit">{{ __('Assign') }}</button>
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

@section('scripts')





@endsection

