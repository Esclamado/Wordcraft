@extends('frontend.layouts.app')

@section('content')
    {{-- <section class="bg-lightblue py-5">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 mx-auto">
                        <div class="position-absolute">
                            <div class="img-1"></div>
                            <div class="img-2"></div>
                            <div class="img-3"></div>
                            <div class="img-4"></div>
                        </div>
                        <div class="card">
                            <div class="text-center pt-4">
                                <h1 class="h4 header-title">
                                    {{ translate('Login to your account.')}}
                                </h1>
                            </div>

                            <div class="px-4 py-3 py-lg-4">
                                <div class="">
                                    <form class="form-default" role="form" action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-craft {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <input type="text" hidden value="walkin" name="loginpage">
                                        <div class="form-group position-relative">
                                            <input type="password" class="form-control form-craft {{ $errors->has('password') ? ' is-invalid is-invalid-pass' : '' }}" placeholder="Password" name="password" id="password">
                                            <span id="pass-icon" toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <div class="form-craft-check mb-4 d-flex justify-content-left">
                                                    <input type="checkbox" name="remember" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                                                    <label for="remember-me" class="text-subprimary ml-3 remember-me">{{  translate('Remember me') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-right">
                                                <a href="{{ route('password.request') }}" class="text-reset text-subprimary forget-color text-link-hover">{{ translate('Forgot Password?')}}</a>
                                            </div>
                                        </div>

                                        <div class="mb-5">
                                            <button type="submit" class="btn btn-primary btn-block fw-600 btn-login">{{  translate('Login') }}</button>
                                        </div>
                                    </form>
                                    @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                        <div class="separator mb-3">
                                            <span class="bg-white px-3 opacity-60">{{ translate('OR')}}</span>
                                        </div>
                                            @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                                <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-styled btn-block btn-facebook btn-icon--2 btn-icon-left px-4 mb-3">
                                                    <svg class="left" width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.76858 18V9.94922H0V6.75H2.76858V4.2293C2.76858 1.49063 4.48676 0 6.99545 0C8.19746 0 9.22981 0.0878906 9.52941 0.126562V2.98828H7.78957C6.42513 2.98828 6.16163 3.62109 6.16163 4.5457V6.75H9.24064L8.81832 9.94922H6.16163V18" fill="white"/>
                                                    </svg>
                                                        {{ translate('Login with Facebook')}}
                                                </a>

                                            @endif
                                            @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                                <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-styled btn-block btn-google btn-icon--2 btn-icon-left mb-3">
                                                    <svg class="left" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M17.2633 7.94956H16.6257V7.91671H9.50065V11.0834H13.9748C13.322 12.9268 11.5681 14.25 9.50065 14.25C6.87746 14.25 4.75065 12.1232 4.75065 9.50004C4.75065 6.87685 6.87746 4.75004 9.50065 4.75004C10.7115 4.75004 11.8131 5.20683 12.6519 5.95298L14.8911 3.71375C13.4772 2.39602 11.5859 1.58337 9.50065 1.58337C5.12867 1.58337 1.58398 5.12806 1.58398 9.50004C1.58398 13.872 5.12867 17.4167 9.50065 17.4167C13.8726 17.4167 17.4173 13.872 17.4173 9.50004C17.4173 8.96923 17.3627 8.45108 17.2633 7.94956Z" fill="#FFC107"/>
                                                        <path d="M2.49609 5.81523L5.09711 7.72275C5.80091 5.98029 7.50536 4.75004 9.49997 4.75004C10.7108 4.75004 11.8124 5.20683 12.6512 5.95298L14.8904 3.71375C13.4765 2.39602 11.5852 1.58337 9.49997 1.58337C6.45918 1.58337 3.82214 3.3001 2.49609 5.81523Z" fill="#FF3D00"/>
                                                        <path d="M9.50094 17.4167C11.5458 17.4167 13.4039 16.6341 14.8087 15.3615L12.3585 13.2882C11.5636 13.8902 10.5756 14.25 9.50094 14.25C7.44181 14.25 5.69342 12.937 5.03475 11.1047L2.45312 13.0938C3.76333 15.6576 6.42413 17.4167 9.50094 17.4167Z" fill="#4CAF50"/>
                                                        <path d="M17.2627 7.94948H16.625V7.91663H9.5V11.0833H13.9741C13.6606 11.9688 13.091 12.7323 12.3563 13.2885C12.3567 13.2881 12.3571 13.2881 12.3575 13.2877L14.8077 15.3611C14.6344 15.5186 17.4167 13.4583 17.4167 9.49996C17.4167 8.96915 17.362 8.451 17.2627 7.94948Z" fill="#1976D2"/>
                                                    </svg>
                                                        {{ translate('Login with Google')}}
                                                </a>
                                            @endif
                                    @endif

                                </div>
                                <div class="text-center">
                                    <p class="text-muted mb-0 text-subprimary">{{ translate("Don't have an account yet?")}} <a href="{{ route('walkin.register') }}">{{ translate('Register Now')}}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <div class="login-cont py-5">
        <img class="box" src="{{ static_asset('assets/img/box.png') }}">
        <img class="box1" src="{{ static_asset('assets/img/box.png') }}">
        <div class="login-form px-8 py-5">
            @php
                $header_logo = get_setting('header_logo');
            @endphp
            @if($header_logo != null)
                <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="h-85px">
            @else
                <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="h-85px">
            @endif
            <span class="login-title">
                {{ translate('Login to your account.')}}
            </span>
            <div class="d-flex justify-content-around align-items-center" style="width: 80%;">
                <a id="employee" class="form-label link active">{{ translate('Employee/Reseller')}}</a>
                <a id="customer" class="form-label link">{{ translate('Customer')}}</a>
            </div>
            <form id="employee_form" class="form-default d-block" role="form" action="{{ route('auth.login') }}" method="POST" style="width: 100%;">
                @csrf
                <input type="text" hidden value="walkin" name="page_type">
                <input type="text" hidden value="employee" name="login_type">
                <div class="form-group">
                    <span class="form-control-label">Employee or Reseller ID</span>
                    <input type="text" class="form-control form-craft {{ $errors->has('unique_id') ? ' is-invalid' : '' }}" value="{{ old('unique_id') }}" placeholder="{{  translate('Employee ID') }}" name="unique_id">
                    @if ($errors->has('unique_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('unique_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="mt-5 mb-3">
                    <button type="submit" class="btn btn-primary btn-block fw-600 btn-login">{{  translate('Login') }}</button>
                </div>
                <div class="text-center">
                    <p class="form-label">{{ translate("Don't have an account yet?")}} <a class="red" href="{{ route('walkin.register') }}">{{ translate('Register Now')}}</a></p>
                </div>
            </form>
            <form id="customer_form" class="form-default d-none" role="form" action="{{ route('auth.login') }}" method="POST" style="width: 100%;">
                @csrf
                <input type="text" hidden value="walkin" name="loginpage">
                <input type="text" hidden value="customer" name="login_type">
                <div class="form-group">
                    <span class="form-control-label">Email Address:</span>
                    <input type="text" class="form-control form-craft {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-around mt-4 mb-4 form-label">
                    <svg width="181" height="2" viewBox="0 0 181 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="1.20935" x2="180.5" y2="1.20935" stroke="#AAAAAA"/>
                    </svg>
                    <span>OR</span>
                    <svg width="181" height="2" viewBox="0 0 181 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="1.20935" x2="180.5" y2="1.20935" stroke="#AAAAAA"/>
                    </svg>
                </div>
                <div class="form-group phone-form-group">
                    <span class="form-control-label">Phone number:</span>
                    <input type="tel" id="phone-code" class="form-craft form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                    <input type="hidden" id="phone" class="form-control" value="" placeholder="" name="phone">
                    <input type="hidden" name="country_code">

                    @if ($errors->has('phone'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="mt-5 mb-3">
                    <button type="submit" class="btn btn-primary btn-block fw-600 btn-login">{{  translate('Login') }}</button>
                </div>
                <div class="text-center">
                    <p class="form-label">{{ translate("Don't have an account yet?")}} <a class="red" href="{{ route('walkin.register') }}">{{ translate('Register Now')}}</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var isPhoneShown = true,
            countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone-code");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            if(country.iso2 == 'bd'){
                country.dialCode = '88';
            }
        }

        var iti = intlTelInput(input, {
            preferredCountries: ['ph'],
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php echo json_encode(\App\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if(selectedCountryData.iso2 == 'bd'){
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

        $('#phone-code').on('change', function(){
            $('#phone').val($('#phone-code').val().replace(/ /g,''));
        });

        input.addEventListener("countrychange", function(e) {
            var country = iti.getSelectedCountryData();
            $('input[name=country_code]').val(country.dialCode);
        });
        
        /* Form Switching  */

        $("#employee").on("click", function(){
            $("#employee").addClass('active');
            $("#customer").removeClass('active');
            $("#employee_form").removeClass('d-none');
            $("#employee_form").addClass('d-block');
            $("#customer_form").removeClass('d-block');
            $("#customer_form").addClass('d-none');
        });
         $("#customer").on("click", function(){
            $("#customer").addClass('active');
            $("#employee").removeClass('active');
            $("#customer_form").removeClass('d-none');
            $("#customer_form").addClass('d-block');
            $("#employee_form").removeClass('d-block');
            $("#employee_form").addClass('d-none');
        });

        $('#phone-code').on('keyup', function(){
            if($('input[name=country_code]').val() == "63") {
                let trimmedNum = $(this).val().replace(/\s+/g, '');
                if (trimmedNum.length > 10) {
                    trimmedNum = trimmedNum.substr(0, 10);
                }
                const partitions = [3,3,4];
                const numbers = [];
                let position = 0;
                partitions.forEach(partition => {
                const part = trimmedNum.substr(position, partition);
                if (part) numbers.push(part);
                    position += partition;
                })
                $(this).val(numbers.join(' '));
            }
         })

        function toggleEmailPhone(el){
            if(isPhoneShown){
                $('.phone-form-group').addClass('d-none');
                $('.email-form-group').removeClass('d-none');
                isPhoneShown = false;
                $(el).html('{{ translate('Use Phone Instead') }}');
            }
            else{
                $('.phone-form-group').removeClass('d-none');
                $('.email-form-group').addClass('d-none');
                isPhoneShown = true;
                $(el).html('{{ translate('Use Email Instead') }}');
            }
        }

        function checkEmployeeId(search){
            if(search != ""){
                var data = {
                    "_token": "{{ csrf_token() }}",
                    'employee_id' : search
                } ;
                $.ajax({
                    type:"GET",
                    url: '{{ route('get.employee') }}',
                    data: data,
                    success: function(data){
                        if (data != "no_data") {
                            $('#employeefninput').val(data['first_name']);
                            $('#employeelninput').val(data['last_name']);
                            $('#employeeeinput').val(data['email']);
                            $('#no-employee').html('');
                        }
                        else {
                            $('#no-employee').html("No employee with that ID");
                            $('#employeefninput').val("");
                            $('#employeelninput').val("");
                            $('#employeeeinput').val("");
                        }
                    }
                });
            } else {
                $('#employeefninput').val('');
                $('#employeelninput').val('');
                $('#employeeeinput').val('');
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

        var myInput = document.getElementById("registerpassword");
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
