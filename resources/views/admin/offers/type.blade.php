@extends('layouts.admin')
@section('title','Offers')
@section('content')

<div class="content-area">
            <div class="mr-breadcrumb">
              <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __("Add Offer") }}</h4>
                    <ul class="links">
                      <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }}</a>
                      </li>
                      <li>
                        <a href="javascript:;">{{ __("Products") }} </a>
                      </li>
                      <li>
                        <a href="{{ route('admin-offer-index') }}">{{ __("Offers") }}</a>
                      </li>
                      <li>
                        <a href="{{ route('admin-offer-type') }}">{{ __("Add Offer") }}</a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="add-product-content">
              <div class="row">
                <div class="col-lg-12">
                  <div class="product-description">
                    <div class="heading-area">
                      <h2 class="title">
                          {{ __("Offer Types") }}
                      </h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ap-product-categories">
                <div class="row">
                  <div class="col-lg-4">
                    <a href="{{ route('admin-offer-create-1') }}">
                    <div class="cat-box box1">
                      <div class="icon">
                        <i class="fas fa-gift"></i>
                      </div>
                      <h5 class="title">{{ __("Buy One/Get One") }} </h5>
                    </div>
                    </a>
                  </div>
                  <div class="col-lg-4">
                    <a href="{{ route('admin-offer-create-2') }}">
                    <div class="cat-box box2">
                      <div class="icon">
                        <i class="fas fa-percentage"></i>
                      </div>
                      <h5 class="title">{{ __("Discount") }} </h5>
                    </div>
                    </a>
                  </div>
                  <div class="col-lg-4">
                    <a href="{{ route('admin-offer-create-3') }}">
                    <div class="cat-box box3">
                      <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                      </div>
                      <h5 class="title">{{ __("Bulk Purchase") }} </h5>
                    </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection