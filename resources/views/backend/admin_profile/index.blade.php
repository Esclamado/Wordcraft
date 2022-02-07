@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-6  mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Profile')}}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                	@csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text"
                            class="form-control {{ $errors->has('name' ? 'is-invalid' : '') }}"
                                placeholder="{{translate('Name')}}"
                                name="name"
                                value="{{ Auth::user()->name }}"
                                maxlength="70"
                                onkeydown="preventNumberInput(event)"
                                onkeyup="preventNumberInput(event)"
                                required >
                        </div>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">{{ translate('Username') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="{{ translate('Username') }}" name="username" value="{{ Auth::user()->username }}" maxlength="70" required>
                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('username') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Email')}}</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="{{translate('Email')}}" name="email" value="{{ Auth::user()->email }}" maxlength="70">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="current_password" class="col-sm-3 col-form-label">{{ translate('Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" name="current_password" id="currentpass" class="form-control {{ $errors->has('current_password') ? 'is-invalid is-invalid-pass' : '' }}" maxlength="70" placeholder="Password">
                            <span id="pass-icon" toggle="#currentpass" class="fa fa-fw fa-eye field-icon toggle-password profilepass"></span>
                            @if ($errors->has('current_password'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('current_password') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="new_password">{{translate('New Password')}}</label>
                        <div class="col-sm-9">
                            <input type="password" id="newpass" class="form-control {{ $errors->has('new_password') ? 'is-invalid is-invalid-pass' : '' }}" placeholder="{{translate('New Password')}}" name="new_password" maxlength="70">
                            <span id="pass-icon" toggle="#newpass" class="fa fa-fw fa-eye field-icon toggle-password profilepass"></span>
                            <div id="message" class="mb-2 text-subprimary">
                                <span>Password must contain the following:</span>
                                <p id="length" class="invalid text-subprimary">Minimum <b>8 characters</b></p>
                            </div>
                            @if ($errors->has('new_password'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('new_password') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="confirm_password">{{translate('Confirm New Password')}}</label>
                        <div class="col-sm-9">
                            <input type="password" id="confirmpass" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid is-invalid-pass' : '' }}" placeholder="{{translate('Confirm New Password')}}" name="confirm_password" maxlength="70">
                            <span id="pass-icon" toggle="#confirmpass" class="fa fa-fw fa-eye field-icon toggle-password profilepass"></span>

                            <div id="msg" class="my-2"></div>

                            @if ($errors->has('confirm_password'))
                                <span class="invalid-feedback" role="alert">
                                    {{ $errors->first('confirm_password') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Avatar')}} <small>(90x90)</small></label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="avatar" class="selected-files" value="{{ Auth::user()->avatar_original }}">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
    $( document ).ready(function() {
        $("#confirmpass").keyup(function(){
            if ($("#newpass").val() != $("#confirmpass").val()) {
                $("#msg").html("Password do not match").css("color","red");
            }else{
                $("#msg").html("Password matched").css("color","green");
            }
        });

    });
    function preventNumberInput(e){
        var keyCode = (e.keyCode ? e.keyCode : e.which);
        if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107 ){
            e.preventDefault();
        }
    }

    $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
        });

        var myInput = document.getElementById("newpass");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function() {

        // Validate length
        if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
        }

    </script>
@endsection
