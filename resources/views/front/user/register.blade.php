@extends('layouts.front')
@section('title' , 'Register')
@section('styles')
    <style>
    
        #pswd-div i ,#confirm-pswd-div i {
            position:absolute;
            bottom:12px;
            right:15px;
            font-size:20px;
            cursor: pointer;
        }
        .create-one{
            color:#e6bb34 !important;
        }
        .pr-0{
            padding-right: 0px !important;
        }
        .pl-0{
            padding-left: 0px !important;
        }
        </style>

@endsection
@section('content')

     <!-- Breadcrumb Area Start Here -->
     <div class="breadcrumb-area">
            <div class="container">
                <ol class="breadcrumb breadcrumb-list">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Register</li>
                </ol>
            </div>
        </div>
        <!-- Breadcrumb Area End Here -->



        <div class="col-md-6 col-md-offset-3">
        <div class="well login-form signin-form register-form signup-form">
            <h2>Login</h2>
            @include('includes.admin.form-login')
            <form id="registerform" action="{{route('user-register-submit')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="input-email" class="control-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Your Name" value="{{ old('name') }}" required>
              </div>

              <div class="form-group">
                <label for="input-email" class="control-label">E-Mail Address</label>
                <input type="email" name="email" class="form-control" id="input-email" placeholder="E-Mail Address" value="">
              </div>

              <div class="form-group">
                <label for="input-email" class="control-label">Phone Number</label>
                <div class="form-group row">
                <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-3 pl-0 pr-0">
                        <select name="country_code" class="form-control" id="">
                            @foreach($countries as $country)
                            <option value="{{$country->country_phone}}">{{ $country->country_code }} (+{{ $country->country_phone}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-9 pl-0 pr-0">
                        <input type="number" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone') }}" id="phone" required>
                    </div>
                </div>
                </div>
            </div>

              </div>

            <div class="form-group">
                <label for="input-password" class="control-label">Password</label>
                <input type="password" class="form-control" id="input-password" placeholder="Password" value="" name="password">
            </div>

            <div class="form-group">
                <label for="input-password" class="control-label">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" id="confirmPassword" required>
            </div>


            <div class="form-group">
                  <input class="mauthdata" type="hidden" value="Working" id="authdata">
                  <input type="submit" class="btn btn-primary" value="Register">
            </div>            
            </form>

            <div class="row">
                <p>Already have an account? <a class="create-one" href="{{ route('user.login') }}">Log in instead!</a></p>
            </div>
          </div>
        </div>


@endsection
@section('scripts')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');    

        const ctogglePassword = document.querySelector('#confirmTogglePassword');
        const cpassword = document.querySelector('#confirmPassword');    
        
        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            // this.classList.toggle('fa-eye-slash');
        });


        ctogglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
            cpassword.setAttribute('type', type);
            // toggle the eye slash icon
            // this.classList.toggle('fa-eye-slash');
        });

        $('#submit').click(function(){
            if(isEmail($('#email').val())){                
                $('#submit').submit();
            }else{
                alert("Please provide valid Email");
            }
        });

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z]{2,4})+$/;
            return regex.test(email);
        }
    </script>
@endsection