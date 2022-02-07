@extends('frontend.layouts.app')

@section('content')
    <div class="login-cont py-5">
        @php
            $referral_code = request()->get('referral_code');
            $referrer = null;
            
            if ($referral_code != null) {
                $referrer = \App\User::where('referral_code', $referral_code)->first();
            }
        @endphp
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
                {{ translate('Create an account.')}}
            </span>
            <div class="d-flex justify-content-around align-items-center" style="width: 80%;">
                <a id="individual" class="form-label link active">{{ translate('Individual')}}</a>
                <a id="corporate" class="form-label link">{{ translate('Corporate')}}</a>
            </div>
            <form class="form-default" role="form" action="{{ route('register') }}" method="POST" style="width: 100%;">
                @csrf
                <div style="margin-bottom: 15px;">
                    <span class="form-label" style="font-weight: 600;" id="personal_title">Personal Information</span>
                    <span class="form-label d-none" style="font-weight: 600;" id="corporate_title">Corporate Information</span>
                </div>
                <input type="text" hidden value="walkin" name="login_type">
                <input type="hidden" id="isIndividual" class="form-control" value="0" placeholder="" name="isIndividual">
                <input type="hidden" id="isCorporate" class="form-control" value="0" placeholder="" name="isCorporate">
                <div class="form-group">
                    <input id="company_name" type="text" class="form-craft d-none cart-craft-text form-control{{ $errors->has('c_name') ? ' is-invalid' : '' }}"  @if ($referral_code != null) value="{{ $referrer->c_name }}" @else value="{{ old('c_name') }}" @endif placeholder="{{  translate('Company Name') }}" name="c_name">
                    @if ($errors->has('c_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('c_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="employeefninput" type="text" class="form-craft cart-craft-text form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}"  @if ($referral_code != null) value="{{ $referrer->first_name }}" @else value="{{ old('fname') }}" @endif placeholder="{{  translate('First Name') }}" name="fname">
                    @if ($errors->has('fname'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('fname') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="employeelninput" type="text" class="form-craft cart-craft-text form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" @if ($referral_code != null) value="{{ $referrer->last_name }}" @else value="{{ old('lname') }}" @endif placeholder="{{  translate('Last Name') }}" name="lname">
                    @if ($errors->has('lname'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('lname') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="text" class="form-craft form-control{{ $errors->has('tin') ? ' is-invalid' : '' }}" id="individual_tin" value="{{ old('tin') }}" placeholder="{{  translate('TIN ID') }}" name="tin">
                    @if ($errors->has('tin'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('tin') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group phone-form-group">
                    <input type="tel" id="phone-code" class="form-craft form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                    <input type="hidden" id="phone" class="form-control" value="" placeholder="" name="phone">
                    <input type="hidden" name="country_code">

                    @if ($errors->has('phone'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-craft" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group position-relative">
                    <input type="password" class="form-craft form-control{{ $errors->has('password') ? ' is-invalid is-invalid-pass' : '' }}" placeholder="Password" name="password" id="registerpassword" title="Must contain at least 8 or more characters">
                    <span id="pass-icon" toggle="#registerpassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div id="message" class="mb-2 text-subprimary">
                    <span>Password must contain the following:</span>
                    <p id="length" class="invalid text-subprimary">Minimum <b>8 characters</b></p>
                </div>

                <div class="form-group position-relative">
                    <input type="password" class="form-craft form-control" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation" id="confirmpassword">
                    <span id="pass-icon" toggle="#confirmpassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    <div id="msg" class="my-2"></div>
                </div>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <p class="form-label" style="max-width: 250px;">{{ translate("By signing up you agree to our")}} <a class="blue" href="{{ route('terms') }}">{{ translate('Terms and Conditions')}}</a> & <a class="blue" href="{{ route('privacypolicy')}}" target="_blank">{{ translate('Privacy Policy')}}</a>.</p>
                </div>
                <div class="mt-3 mb-3">
                    <button type="submit" class="btn btn-primary btn-block fw-600 btn-login">{{  translate('Create Account') }}</button>
                </div>
                <div class="text-center">
                    <p class="form-label">{{ translate("Already have an account?")}} <a class="red" href="{{ route('walkin.login') }}">{{ translate('Log In')}}</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    @if(\App\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <script type="text/javascript">
        var typingTimer;                //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example
        var $input = $('#employeeidinput');

        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });
        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });
        function doneTyping () {
            checkEmployeeId($("#employeeidinput").val());
        }

        @if ($referral_code != null)
            $('#contact-person-form').show();
            $('#contact-person-form').removeClass('d-none');
            $('#isContact').val('0');
        @endif

        $('#contact-person-checkbox').on('click', function() {
            if($('#contact-person-checkbox').prop('checked') == true) {
                $('#contact-person-form').show();
                $('#contact-person-form').removeClass('d-none');
                $('#isContact').val('1');

            } else if($('#contact-person-checkbox').prop('checked') == false) {
                $('#contact-person-form').hide();
                $('#contact-person-form').addClass('d-none');
                $('#isContact').val('0');
            }
        });

        $('#individual-checkbox').on('click', function() {
            if($('#individual-checkbox').prop('checked') == true) {
                $('#corporate-title').addClass('d-none');
                $('#corporate_tin').addClass('d-none');
                $('#individual-title').removeClass('d-none');
                $('#individual_tin').removeClass('d-none');
                $('#company_name').addClass('d-none');
                $('#corporate-checkbox').prop('checked', false);
                $('#isIndividual').val('1');
                $('#isCorporate').val('0');
                $('#registrationform').removeClass('d-none');
                $('#tin-corporate').addClass('d-none');

            } else if($('#individual-checkbox').prop('checked') == false) {
                $('#registrationform').addClass('d-none');
            }
        });

        /* Form Switching  */
        $("#individual").on("click", function(){
            $("#individual").addClass('active');
            $("#corporate").removeClass('active');
            $('#personal_title').removeClass('d-none');
            $('#corporate_title').addClass('d-none');
            $('#company_name').addClass('d-none');
            $('#isIndividual').val('1');
            $('#isCorporate').val('0');
        });
         $("#corporate").on("click", function(){
            $("#corporate").addClass('active');
            $("#individual").removeClass('active');
            $('#personal_title').addClass('d-none');
            $('#corporate_title').removeClass('d-none');
            $('#company_name').removeClass('d-none');
            $('#isCorporate').val('1');
            $('#isIndividual').val('0');
        });

        // $('#corporate-checkbox').on('click', function() {
        //     if($('#corporate-checkbox').prop('checked') == true) {
        //         $('#corporate-title').removeClass('d-none');
        //         $('#corporate_tin').removeClass('d-none');
        //         $('#individual-title').addClass('d-none');
        //         $('#individual_tin').addClass('d-none');
        //         $('#company_name').removeClass('d-none');
        //         $('#individual-checkbox').prop('checked', false);
        //         $('#isCorporate').val('1');
        //         $('#isIndividual').val('0');
        //         $('#registrationform').removeClass('d-none');
        //         $('#tin-corporate').removeClass('d-none');

        //     } else if($('#corporate-checkbox').prop('checked') == false) {
        //         $('#registrationform').addClass('d-none');
        //     }
        // });

        $(document).ready(function(){
            $('#individual-checkbox').prop('checked', true);
            $('#corporate-title').addClass('d-none');
            $('#corporate_tin').addClass('d-none');
            $('#company_name').addClass('d-none');
            $('#tin-corporate').addClass('d-none');

            $("#confirmpassword").keyup(function() {
                if ($("#registerpassword").val() != $("#confirmpassword").val()) {
                    $("#msg").html("Password do not match").css("color","red");
                }else{
                    $("#msg").html("Password matched").css("color","green");
                }
            });
        })

        @if(\App\BusinessSetting::where('type', 'google_recaptcha')->first()->value == 1)
        // making the CAPTCHA  a required field for form submission
        $(document).ready(function(){
            // alert('helloman');
            $("#reg-form").on("submit", function(evt)
            {
                var response = grecaptcha.getResponse();
                if(response.length == 0)
                {
                //reCaptcha not verified
                    alert("please verify you are humann!");
                    evt.preventDefault();
                    return false;
                }
                //captcha verified
                //do the rest of your validations here
                $("#reg-form").submit();
            });
        });
        @endif

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
