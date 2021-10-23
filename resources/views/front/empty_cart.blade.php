@extends('layouts.front')
@section('content')
       <!-- Breadcrumb Area Start Here -->
       <div class="breadcrumb-area">
       <div class="container">
           <ol class="breadcrumb breadcrumb-list">
               <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
               <li class="breadcrumb-item active">
                   Cart
               </li>
           </ol>
       </div>
   </div>
   <!-- Breadcrumb Area End -->

            <!-- cart area start -->
            <div class="cart-main-area mtb-60px">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            @if(Session::has('unsuccess'))
                            <div class="mt-3 alert alert-danger validation">
                            <button type="button" class="close alert-close"><span>×</span></button>
                                    <p class="text-left">
                                        {{Session::get('unsuccess')}}
                                    </p> 
                            </div>
                            @endif
                            <img class="img-responsive" src="{{ asset('assets/images/cart_is_empty.png') }}" alt="">                    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4 mb-5">
                            <div class="cart-shiping-update-wrapper">
                                <div class="col-md-offset-5">
                                    <a href="{{ route('front.index') }}"><button class="btn btn-block btn-default">Continue Shopping</button> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- cart area end -->

@endsection

