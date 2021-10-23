@extends('layouts.front')
@section('styles')
    <style>
    .disabled{
        pointer-events: none;
        }
    .main-shop-page{
        background:#C7B8B5;
    }    
    </style>
@endsection

@section('content')

                    <!-- Breadcrumb Area Start Here -->
        <div class="breadcrumb-area">
            <div class="container">
                <ol class="breadcrumb breadcrumb-list">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="breadcrumb-item active"> Offers </li>
                </ol>
            </div>
        </div>
        <!-- Breadcrumb Area End Here -->
        <!-- Shop Page Start -->
        <div class="main-shop-page pb-90">
            <div class="container">
                <!-- Row End -->
                <div class="row">


                    <!-- Product Categorie List Start -->
                    <div class="col-lg-12 order-1 order-lg-2">

                        <!-- Grid & List View End -->
                        <div class="shop-area mb-all-40">
                            <!-- Grid & List Main Area End -->
                            <div class="tab-content">
                                    <div class="row border-hover-effect">
                                        <!-- Single Product Start Here -->
                                        @foreach($offers as $offer)
                                        <div class="col-md-3">
                                        <div class="single-makal-product">
                                            <div class="countdown" data-countdown="{{Carbon\Carbon::parse($offer->end_date)->format('Y/m/d')}}"></div>
                                            <div class="pro-img">
                                                <a data-toggle="modal" data-target="#offerquickview" data-href="{{ route('offer.quick',$offer->id) }}" class="quick-view offer-quick-a" href="#">
                                                    <img src="{{ asset('public/assets/images/offers/'.$offer->image)}}" alt="product-img">
                                                </a>
                                                <span class="sticker-new">new</span>
                                                <div class="quick-view-pro">
                                                    <a data-toggle="modal" data-target="#offerquickview" data-href="{{ route('offer.quick',$offer->id) }}" class="quick-view offer-quick-a" href="#"></a>
                                                </div>
                                            </div>
                                            <div class="pro-content">
                                                <h4 class="pro-title">
                                                    <a data-toggle="modal" data-target="#offerquickview" data-href="{{ route('offer.quick',$offer->id) }}" class="quick-view offer-quick-a" href="#">{{ $offer->name }}</a>
                                                </h4>
                                                <p>
                                                    <span class="price">{{ $offer->showPrice() }}</span>
                                                </p>
                                                <div class="pro-actions">
                                                    <div class="actions-primary">
                                                        <a href="javascript:;" data-href="{{ route('product.offer.cart.add',$offer->id) }}" class="add-offer-to-cart" data-toggle="tooltip" data-original-title="Add to Cart">Add To Cart</a>
                                                    </div>
                                                    <!-- <div class="actions-secondary">
                                                        <div class="rating">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- Row End -->

                            </div>
                            <!-- Grid & List Main Area End -->
                        </div>

                    </div>
                    <!-- product Categorie List End -->
                </div>
                <!-- Row End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Shop Page End -->



@endsection

@section('scripts')
@endsection