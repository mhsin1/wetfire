@extends('layouts.front')

@section('title' , 'Login')

@section('styles')
    <style>
        .or-login{
            border:1px solid grey;
            padding:5px 10px;
        }
    </style>
@endsection

@section('content')
      <!-- Breadcrumb Area Start Here -->
    <div class="breadcrumb-area">
      <div class="container">
          <ol class="breadcrumb breadcrumb-list">
              <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Verify</li>
          </ol>
      </div>
  </div>
  <!-- Breadcrumb Area End Here -->



        <div class="col-md-6 col-md-offset-3">
        @if(!session()->has('error'))
            <div class="alert alert-info">
                <p class="text-left">     
                    Please Enter Verification Code Sent to you.         
                </p> 
            </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger">
        <button type="button" class="close alert-close"><span>×</span></button>
            <p class="text-left">
                {{ session()->get('error') }}
            </p> 
        </div>
        @endif

        <div class="well login-form signin-form">
            <h2>Login</h2>
            @include('includes.admin.form-login')
            <form action="{{ route('verify-account') }}" method="post">
            @csrf
              <div class="form-group">
                <label for="input-email" class="control-label">Verification Code</label>
                <input type="number" class="form-control" name="code" id="code" required>
              </div>
              <div class="form-group">
                <input class="mauthdata" type="hidden" value="Authenticating" id="authdata">
                <input type="submit" class="btn btn-primary" value="Verify">
                <a href="{{ route('user.login') }}" class="or-login text-right pull-right">Back</a>

            </div>
            </form>

          </div>
        </div>

@endsection
@section('scripts')
<script>

</script>
@endsection