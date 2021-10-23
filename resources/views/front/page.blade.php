@extends('layouts.front')
@section('styles')
    <style>
    .disabled{
        pointer-events: none;
        }
    .main-shop-page{
        margin-top:3%;
        margin-bottom:3%;
    }    
    .page-content{
        margin-top:5%;
    }    
    </style>
@endsection

@section('content')

                    <!-- Breadcrumb Area Start Here -->
        <div class="breadcrumb-area">
            <div class="container">
                <ol class="breadcrumb breadcrumb-list">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="breadcrumb-item active"> {{ $page->title }} </li>
                </ol>
            </div>
        </div>
        <!-- Breadcrumb Area End Here -->
        <!-- Shop Page Start -->
        <div class="main-shop-page pb-90">
            <div class="container">
                <!-- Row End -->
                <div class="row">
                    <h1>{{ $page->title }}</h1>
                    <div class="page-content">
                        {!! $page->details !!}
                    </div>
                </div>
                <!-- Row End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Shop Page End -->



@endsection

@section('scripts')
@endsection