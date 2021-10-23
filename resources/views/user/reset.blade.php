@extends('layouts.front')

@section('styles')
    <style>
            #pswd-div i ,#confirm-pswd-div i ,
            #pswd-div1 i ,#confirm-pswd-div i ,
            #pswd-div2 i ,#confirm-pswd-div i {
            position:absolute;
            bottom:40px;
            right:25px;
            font-size:20px;
            cursor: pointer;
        }
        .box-shadow{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.10);
            padding:20px 30px 20px 5%;
        }
        h3{
            font-size: 20px;
            font-weight:bold;
            text-transform: uppercase;
            margin-bottom:5%;
        }
        .pl-0{
            padding-left:0px !important;
        }
        .pr-0{
            padding-right:0px !important;
        }
        label{
            font-weight:bold;
        }
    </style>
@endsection
@section('content')

<!-- Breadcrumb Area Start Here -->
<div class="breadcrumb-area">
	<div class="container">
		<ol class="breadcrumb breadcrumb-list">
			<li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
			<li class="breadcrumb-item active">Reset Password</li>
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
                            <!-- Nav tabs -->
                            @include('includes.user-dashboard-sidebar')

                        </div>
                        <div class="col-lg-9 box-shadow">
                            <!-- Tab panes -->
                            <div class="tab-content dashboard-content mt-all-40">
                            <h3>Your Personal Details</h3>
        <div class="register-form login-form clearfix">
        <form id="userform" action="{{route('user-reset-submit')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @include('includes.admin.form-both') 



                <div class="form-group row">
                    <label for="inputpassword" class="col-lg-3 col-md-4 col-form-label">Current password</label>
                    <div class="col-lg-6 col-md-8">
                    <div class="col-md-8 pl-0 pr-0">
                        <input type="password" name="cpass"  class="form-control" placeholder="{{ $langg->lang273 }}" id="password" value="" required="">                        
                    </div>
                    <div class="col-md-4 pl-0 pr-0">
                        <button class="btn show-btn" id="togglePassword" type="button">Show</button>
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="newpassword" class="col-lg-3 col-md-4 col-form-label">New
                        password</label>
                    <div class="col-lg-6 col-md-8">
                    <div class="col-md-8 pl-0 pr-0">
                        <input type="password" name="newpass"  class="form-control" placeholder="{{ $langg->lang274 }}" id="password1" value="" required="">
                    </div>
                    <div class="col-md-4 pl-0 pr-0">
                        <button class="btn show-btn" id="togglePassword1" type="button">Show</button>
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c-password" class="col-lg-3 col-md-4 col-form-label">Confirm
                        password</label>
                    <div class="col-lg-6 col-md-8">
                    <div class="col-md-8 pl-0 pr-0">
                        <input type="password" name="renewpass"  class="form-control" placeholder="{{ $langg->lang275 }}" id="password2" value="" required="">
                    </div>
                    <div class="col-md-4 pl-0 pr-0">
                        <button class="btn show-btn" id="togglePassword2" type="button">Show</button>
                    </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6 col-md-offset-2">
                        <button type="submit" style="width:30%; margin-top:5%;" class="return-customer-btn btn btn-default btn-block pull-right">Save</button>
                    </div>
                </div>
            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
        <!-- My Account Page End Here -->


  

@endsection
@section('scripts')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');    

        const togglePassword1 = document.querySelector('#togglePassword1');
        const password1 = document.querySelector('#password1');    

        const togglePassword2 = document.querySelector('#togglePassword2');
        const password2 = document.querySelector('#password2');    
        
        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
        });


        togglePassword1.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
            password1.setAttribute('type', type);
        });

        togglePassword2.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
            password2.setAttribute('type', type);
        });

    </script>
@endsection