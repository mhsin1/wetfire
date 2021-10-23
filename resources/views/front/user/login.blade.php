@extends('layouts.front')
@section('title' , 'Login')
@section('styles')
  <style>
    .create-one{
        color:#e6bb34 !important;
    }
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
                 <li class="breadcrumb-item active">Login</li>
             </ol>
         </div>
     </div>
     <!-- Breadcrumb Area End Here -->


        <div class="col-md-6 col-md-offset-3">
        <div class="well login-form signin-form">
            <h2>Login</h2>
            @include('includes.admin.form-login')
            <form class="mloginform" action="{{ route('user.login.submit') }}" method="post">
            @csrf
              <div class="form-group">
                <label for="input-email" class="control-label">E-Mail Address</label>
                <input type="email" name="email" class="form-control" id="input-email" placeholder="E-Mail Address" value="">
              </div>
              <div class="form-group">
                <label for="input-password" class="control-label">Password</label>
                <input type="password" class="form-control" id="input-password" placeholder="Password" value="" name="password">
                <a href="{{route('user-forgot')}}">Forgotten Password</a></div>
                <input class="mauthdata" type="hidden" value="Authenticating" id="authdata">
              <input type="submit" class="btn btn-primary" value="Login">
              <a href="{{ route('user-register') }}" class="or-login text-right pull-right">Register</a>

            </form>
          </div>
        </div>


@endsection
@section('scripts')
<script>
    $('#log').click(function(){
        $('#rg').css('display','none');
        $('#lg').css('display','block');
    });

    $('#reg').click(function(){
        $('#rg').css('display','block');
        $('#lg').css('display','none');
    });

// const togglePassword = document.querySelector('#togglePassword');
        // const password = document.querySelector('#password');    

        // const ctogglePassword = document.querySelector('#confirmTogglePassword');
        // const cpassword = document.querySelector('#confirmPassword');    
        
        // togglePassword.addEventListener('click', function (e) {
        //     // toggle the type attribute
        //     const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        //     password.setAttribute('type', type);
        //     // toggle the eye slash icon
        //     this.classList.toggle('fa-eye-slash');
        // });
</script>
@endsection