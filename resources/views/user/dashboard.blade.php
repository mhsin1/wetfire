@extends('layouts.front')
@section('title' , 'Dashboard')
@section('styles')
  <style>
.c-info-box-area .c-info-box {
    width: 200px;
    height: 200px;
    margin: 0 auto;
    border-width: 20px;
    border-style: solid;
    text-align: center;
    border-radius: 50%;
}
.c-info-box-area .c-info-box.box2 , .c-info-box.box1 {
    border-color: #fe5723;
}
.c-info-box-area .c-info-box-content {
    text-align: center;
    margin-top: 20px;
}
.c-info-box-area .c-info-box p {
    font-size: 30px;
    font-weight: 600;
    line-height: 160px;
}
.c-info-box-area {
    padding: 40px 30px 38px;
    -webkit-transition: all 0.3s ease-in;
    -o-transition: all 0.3s ease-in;
    transition: all 0.3s ease-in;
}

h3 , .title{
    font-size: 20px;
    font-weight:bold;
    text-transform: uppercase;
}
p{
    font-size:15px;
}
.list{
    list-style-type:none;
}
.mt-20 {
    margin-top: 5%;
    margin-bottom: 10%;
}
.box-shadow{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.10);
    margin-bottom:10px;
    margin-top:10px;
}
.padding{
    padding:20% 5%;
}
  </style>
@endsection
@section('content')

        <!-- Breadcrumb Area Start Here -->
        <div class="breadcrumb-area">
            <div class="container">
                <ol class="breadcrumb breadcrumb-list">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">My Dashboard</li>
                </ol>
            </div>
        </div>
        <!-- Breadcrumb Area End Here -->

        <!-- My Account Page Start Here -->
        <div class="my-account white-bg ptb-90">
            <div class="container">
                <div class="account-dashboard">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs column-left" id="column-left">
                            @include('includes.user-dashboard-sidebar')
                        </div>
                        <div class="col-lg-9">
                            <!-- Tab panes -->
                            <div class="tab-content dashboard-content mt-all-40">
                                <div id="dashboard" class="">
                                    <h3>Dashboard </h3>
                                    <p>From your account dashboard. you can easily check & view your <a href="{{ route('user-orders') }}">recent
                                            orders</a>, manage your <a href="{{ route('user-profile') }}">shipping and billing addresses</a> and
                                        <a href="{{ route('user-reset') }}">change your password</a></p>

        <div class="row">
          <div class="col-md-4">
          <div class="col-md-12 padding box-shadow">
          <h3 class="mt-20">Account Information </h3>
              <h2 class="title mt-3">{{ $user->name }}</h2>
                <div class="main-info">
                    <ul class="list">
                      <li>
                        <p><span class="user-title">{{ $langg->lang209 }}:</span> {{ $user->email }}</p>
                      </li>
                      @if($user->phone != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang210 }}:</span> {{ $user->phone }}</p>
                      </li>
                      @endif
                      @if($user->fax != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang211 }}:</span> {{ $user->fax }}</p>
                      </li>
                      @endif
                      @if($user->city != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang212 }}:</span> {{ $user->city }}</p>
                      </li>
                      @endif
                      @if($user->zip != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang213 }}:</span> {{ $user->zip }}</p>
                      </li>
                      @endif
                      @if($user->address != null)
                      <li>
                        <p><span class="user-title">{{ $langg->lang214 }}:</span> {{ $user->address }}</p>
                      </li>
                      @endif
                    </ul>
                  </div>
              </div>  
              </div>  
          <div class="col-md-4">
          <div class="col-md-12 box-shadow">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                  <p>{{ Auth::user()->orders()->count() }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ isset($langg->lang809) ? $langg->lang809 : 'Total Orders' }}</h6>
                    <p class="text">{{ isset($langg->lang811) ? $langg->lang811 : 'All Time' }}</p>
                </div>
            </div>
          </div>
          </div>
          <div class="col-md-4">
              <div class="col-md-12 box-shadow">
              <div class="card c-info-box-area">
                  <div class="c-info-box box1">
                      <p>{{ Auth::user()->orders()->where('status','pending')->count() }}</p>
                  </div>
                  <div class="c-info-box-content">
                      <h6 class="title">{{ isset($langg->lang810) ? $langg->lang810 : 'Pending Orders' }}</h6>
                      <p class="text">{{ isset($langg->lang811) ? $langg->lang811 : 'All Time' }}</p>
                  </div>
              </div>
          </div>
          </div>
          </div>

        <div class="row row-cards-one mt-5 mb-3">

      </div>


                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- My Account Page End Here -->



@endsection