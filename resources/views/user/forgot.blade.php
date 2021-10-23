@extends('layouts.front')

@section('title' , 'Login')

@section('styles')
    <style>
  
    </style>
@endsection

@section('content')
      <!-- Breadcrumb Area Start Here -->
      <div class="breadcrumb-area">
      <div class="container">
          <ol class="breadcrumb breadcrumb-list">
              <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Forgot Password</li>
          </ol>
      </div>
  </div>
  <!-- Breadcrumb Area End Here -->


        <div class="col-md-6 col-md-offset-3">
        <div class="well login-form signin-form">
            <h2>Forgot Password</h2>
            @include('includes.admin.form-login')
            <form id="forgotform" action="{{route('user-forgot-submit')}}" method="POST">
            @csrf
              <div class="form-group">
                <label for="input-email" class="control-label">E-Mail Address</label>
                <input type="email" name="email" class="form-control" id="input-email" placeholder="E-Mail Address" value="">
              </div>
              <div class="form-group">
                <a href="{{route('user.login')}}">Or Login</a>
                </div>
                <input class="authdata" type="hidden" value="Authenticating" id="authdata">
                <input type="submit" class="btn btn-primary" value="Login">
            </form>
          </div>
        </div>


@endsection

@section('scripts')
<script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');    

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
</script>
@endsection