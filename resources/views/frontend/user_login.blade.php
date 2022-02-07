@extends('frontend.layouts.app')

@section('content')
    <section class="bg-lightblue py-5">
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

                                        <div class="form-group position-relative">
                                            <input type="password" class="form-control form-craft {{ $errors->has('password') ? ' is-invalid is-invalid-pass' : '' }}" placeholder="Password" name="password" id="password">
                                            {{-- <div id="unmask" onclick="unmask_pass()" class="mask_pass c-pointer">
                                                <svg width="22" height="16" viewBox="0 0 22 16">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C1.73 3.61 6 0.5 11 0.5C16 0.5 20.27 3.61 22 8C20.27 12.39 16 15.5 11 15.5C6 15.5 1.73 12.39 0 8ZM19.82 8C18.17 4.63 14.79 2.5 11 2.5C7.21 2.5 3.83 4.63 2.18 8C3.83 11.37 7.21 13.5 11 13.5C14.79 13.5 18.17 11.37 19.82 8ZM11 5.5C12.38 5.5 13.5 6.62 13.5 8C13.5 9.38 12.38 10.5 11 10.5C9.62 10.5 8.5 9.38 8.5 8C8.5 6.62 9.62 5.5 11 5.5ZM6.5 8C6.5 5.52 8.52 3.5 11 3.5C13.48 3.5 15.5 5.52 15.5 8C15.5 10.48 13.48 12.5 11 12.5C8.52 12.5 6.5 10.48 6.5 8Z"/>
                                                </svg>
                                            </div>
                                           <div id="mask" onclick="mask_pass()" class="unmask_pass c-pointer">
                                            <svg width="22" height="20" viewBox="0 0 22 20">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.69 4.5248L1.01 1.8448L2.42 0.424805L20.15 18.1648L18.74 19.5748L15.32 16.1548C13.98 16.6848 12.52 16.9748 11 16.9748C6 16.9748 1.73 13.8648 0 9.4748C0.77 7.5048 2.06 5.8048 3.69 4.5248ZM11 3.9748C14.79 3.9748 18.17 6.1048 19.82 9.4748C19.23 10.6948 18.4 11.7448 17.41 12.5948L18.82 14.0048C20.21 12.7748 21.31 11.2348 22 9.4748C20.27 5.0848 16 1.9748 11 1.9748C9.73 1.9748 8.51 2.1748 7.36 2.5448L9.01 4.1948C9.66 4.0648 10.32 3.9748 11 3.9748ZM9.93 5.1148L12 7.1848C12.57 7.4348 13.03 7.8948 13.28 8.4648L15.35 10.5348C15.43 10.1948 15.49 9.8348 15.49 9.4648C15.5 6.9848 13.48 4.9748 11 4.9748C10.63 4.9748 10.28 5.02481 9.93 5.1148ZM8.51 9.3448L11.12 11.9548C11.08 11.9648 11.04 11.9748 11 11.9748C9.62 11.9748 8.5 10.8548 8.5 9.4748C8.5 9.44981 8.5025 9.42982 8.505 9.40982L8.505 9.40981L8.505 9.40979C8.5075 9.38979 8.51 9.3698 8.51 9.3448ZM6.86 7.6948L5.11 5.9448C3.9 6.8648 2.88 8.0448 2.18 9.4748C3.83 12.8448 7.21 14.9748 11 14.9748C11.95 14.9748 12.87 14.8348 13.75 14.5948L12.77 13.6148C12.23 13.8448 11.63 13.9748 11 13.9748C8.52 13.9748 6.5 11.9548 6.5 9.4748C6.5 8.8448 6.63 8.2448 6.86 7.6948Z"/>
                                            </svg>
                                           </div> --}}

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
                                    <p class="text-muted mb-0 text-subprimary">{{ translate("Don't have an account yet?")}} <a href="{{ route('user.registration') }}">{{ translate('Register Now')}}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function autoFillSeller(){
            $('#email').val('seller@example.com');
            $('#password').val('123456');
        }
        function autoFillCustomer(){
            $('#email').val('customer@example.com');
            $('#password').val('123456');
        }

        // function mask_pass(){
        //     console.log("maskk")
        //     $("#password").prop('type','password');
        //     $("#mask").toggle(false);
        //     $("#unmask").toggle(true);
        // }
        // function unmask_pass(){
        //     console.log("unmaskk")
        //     $("#password").prop('type','text');
        //     $("#mask").toggle(true);
        //     $("#unmask").toggle(false);
        // }

        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
        });
    </script>
@endsection
