@extends('layouts.front')
@section('styles')
    <style>
        .login-form input, .nice-select.bootstrap-select , .nice-select , .login-form select,.login-form textarea {
            background: #ebebeb none repeat scroll 0 0;
            border: 1px solid #ebebeb;
            border-radius: 0;
            font-size: 14px;
            height: auto;
        }
        .nice-select .list {
            background: #ebebeb none repeat scroll 0 0;
			height: 300px;
			overflow-y: scroll !important;
            width:100%;
		}
        .upload-img {
            padding: 18px 0px 20px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .upload-img .img {
    width: 100px;
    height: 100px;
    border: 1px solid rgba(0, 0, 0, 0.4);
    border-radius: 50%;
    margin-right: 30px;
    overflow: hidden;
}
.edit-info-area .upload-img .img img {
    /* border-radius: 50%; */
    width: 100%;
    height: 100%;
}
.upload-img .file-upload-area {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
}
.upload-img .file-upload-area .upload-file {
    width: 150px !important;
    height: 40px;
    cursor: pointer;
    position: relative;
}
.upload-img .file-upload-area .upload-file .upload {
    width: 150px !important;
    height: 40px;
    display: inline-block;
    opacity: 0;
    cursor: pointer;
}
.upload-img .file-upload-area .upload-file span {
    background: #0f78f2;
}

h3{
    margin:2% auto;
    font-size: 20px;
    font-weight:bold;
    text-transform: uppercase;
}
.register-form{
    padding:2% 0 5% 3%;
}
.pl-0{
    padding-left:0px !important;
}
.pr-0{
    padding-right:0px !important;
}
.register-form label{
    font-weight:bold;
}
.register-form .form-control{
    border-radius:5px;
}
.register-form{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.10);
}

@media only screen and (max-width:600px){
    h3{
        text-align:center !important;
        margin-top:5%;
    }
}
    </style>
@endsection
@section('content')      

<!-- Breadcrumb Area Start Here -->
<div class="breadcrumb-area">
	<div class="container">
		<ol class="breadcrumb breadcrumb-list">
			<li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
			<li class="breadcrumb-item active">Profile</li>
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
                        <div class="col-lg-9">
                            <!-- Tab panes -->
                            <div class="register-form row">
                            <h3>Your Personal Details</h3>

        <div class="col-md-8 col-md-offset-2 login-form clearfix">

        <form id="userform" action="{{route('user-profile-update')}}" method="POST"
                                            enctype="multipart/form-data">

            {{ csrf_field() }}
            @include('includes.admin.form-both')
                <!-- <div class="form-group row align-items-center">
                    <label class="col-lg-3 col-md-4 col-form-label">Social title</label>
                    <div class="col-lg-6 col-md-8">
                        <span class="custom-radio"><input name="id_gender" value="1"
                                type="radio"> Mr.</span>
                        <span class="custom-radio"><input name="id_gender" value="1"
                                type="radio"> Mrs.</span>
                    </div>
                </div> -->


                <div class="form-group row">
                    <!-- <div class="col-lg-3 col-md-4 justify-content-center align-self-center col-form-label">Image
                    </div> -->
                    <div class="col-lg-12 justify-content-center align-self-center">
                        <div class="upload-img col-md-12 col-md-offset-5">
                            @if($user->is_provider == 1)
                            <div>
                                <img class="img"
                                    src="{{ $user->photo ? asset($user->photo):asset('public/assets/images/'.$gs->user_image) }}">
                            </div>
                            @else
                            <div><img class="img" id="uploadPreview"
                                    src="{{ $user->photo ? asset('public/assets/images/users/'.$user->photo):asset('public/assets/images/'.$gs->user_image) }}">
                            </div>
                            @endif
                        </div>

                        <input type="file" name="photo" id="uploadImage" onchange="PreviewImage();" class="form-control upload">
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-md-12">
                    <label class="col-md-12 col-form-label">Name</label>
                    <input name="name" type="text" class="form-control"
                                placeholder="{{ $langg->lang264 }}" required=""
                                value="{{ $user->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                    <label for="email" class="col-md-12 col-form-label">Email
                        address</label>

                    <input name="email" type="email" class="form-control"
                                    placeholder="{{ $langg->lang265 }}" required=""
                                    value="{{ $user->email }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                    <label for="phone" class="col-md-12 col-form-label">Phone</label>
                    <div class="">
                        <div class="col-md-3 pl-0 pr-0">
                            <select class="form-control" name="country_code" id="">
                            @foreach($countries as $country)
                                <option {{$country->country_phone == $user->country_code?'selected':'' }} value="{{$country->country_phone}}">{{$country->country_code}} ({{$country->country_phone}})</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-9 pr-0 pl-0">
                        <input name="phone" type="text" class="form-control"
                                placeholder="{{ $langg->lang266 }}" required=""
                                value="{{ $user->phone }}">
                        </div>
                        </div>
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                    <label for="fax" class="col-md-12 col-form-label">Fax</label>
                        <input name="fax" type="text" class="form-control"
                        placeholder="{{ $langg->lang267 }}" value="{{ $user->fax }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                    <label for="fax" class="col-md-12 col-form-label">City</label>
                        <input name="city" type="text" class="form-control"
                    placeholder="{{ $langg->lang268 }}" value="{{ $user->city }}">

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                    <label for="fax" class="col-md-12 col-form-label">Country</label>
                        <select class="form-control" name="country">
                                <option value="">{{ $langg->lang157 }}</option>
                                @foreach (DB::table('countries')->get() as $data)
                                    <option value="{{ $data->country_name }}" {{ $user->country_code == $data->country_phone ? 'selected' : '' }}>
                                        {{ $data->country_name }}
                                </option>		
                                @endforeach
                        </select>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                    <label for="fax" class="col-md-12 col-form-label">Zip</label>
                        <input name="zip" type="text" class="form-control"
                        placeholder="{{ $langg->lang269 }}" value="{{ $user->zip }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                    <label for="fax" class="col-md-12 col-form-label">Address</label>
                        <textarea style="width:100%" name="address" rows="5" required=""
                        placeholder="{{ $langg->lang270 }}">{{ $user->address }}</textarea>

                    </div>
                </div>

                <div class="form-group row">
                <div class="col-md-3 col-xs-12">
                    <button style="width:100%;" type="submit" class="return-customer-btn btn-default float-right">Save</button>
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
          function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            };
        };
    </script>
@endsection