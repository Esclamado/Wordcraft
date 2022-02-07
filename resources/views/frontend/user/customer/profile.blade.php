@extends('frontend.layouts.app')

@section('content')

    <section class="py-5 lightblue-bg">
        <div class="container">
            <div class="position-absolute">
                <div class="img-44"></div>
                <div class="img-46"></div>
            </div>
            <div class="d-lg-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="page-title">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6 col-12">
                                <span class="heading heading-6 text-capitalize fw-600 mb-0 text-paragraph-title">
                                    {{ translate('Manage My Profile') }}
                                </span>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}" class="text-breadcrumb text-secondary-color opacity-50">{{ translate('Home') }}</a>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z" fill="#8D8A8A"/>
                                            </svg>
                                        </li>
                                        <li><a href="{{ route('dashboard') }}" class="text-breadcrumb text-secondary-color opacity-50">{{ translate('Dashboard') }}</a>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z" fill="#8D8A8A"/>
                                            </svg>
                                        </li>
                                        <li class="active"><a href="{{ route('profile') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('Manage My Profile') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Info-->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start border-bottom mb-4">
                                <div class="card-customer-wallet-title text-title-thin fw-600">
                                    {{ translate('My Profile') }}
                                </div>
                            </div>

                            @if (Auth::user()->user_type == 'reseller' && Auth::user()->referred_by != null)
                                <div class="mt-5 mb-3">
                                    <span class="order-details-uploaded-images-label">agent information</span>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('First Name') }}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('First Name') }}" name="agentfname" value="{{ Auth::user()->agentfname ?? \App\User::find(Auth::user()->referred_by)->first_name ?? "N/A" }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Last Name') }}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('Last Name') }}" name="agentlname" value="{{ Auth::user()->agentlname ?? \App\User::find(Auth::user()->referred_by)->last_name ?? "N/A" }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-form-label text-title-thin">Employee ID No.</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('Employee ID No.') }}" name="employeeid" value="{{ Auth::user()->employeeid ?? \App\User::find(Auth::user()->referred_by)->employee_id ?? "N/A" }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-form-label text-title-thin">Position</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('Position') }}" name="position" value="{{ Auth::user()->position ?? \App\User::find(Auth::user()->referred_by)->user_type ?? "N/A" }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-form-label text-title-thin">Email</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('Email') }}" name="agentemail" value="{{ Auth::user()->agentemail ?? \App\User::find(Auth::user()->referred_by)->email ?? "N/A" }}" readonly>
                                    </div>
                                </div>
                            @endif

                            @if (Auth::user()->user_type == 'reseller')
                                <div class="mt-5 mb-3">
                                    <span class="order-details-uploaded-images-label">general information</span>
                                </div>
                            @endif

                            <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row mt-5">
                                    <label class="col-md-2 col-form-label text-title-thin">{{ translate('Profile Photo') }}</label>
                                    <div class="col-md-5">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="form-craft form-control file-amount text-title-thin text-elipsis">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original ?? "N/A" }}" class="selected-files">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary upload-button font-weight-medium text-title-thin text-dark" style="border-left: none !important;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15 16.5V10.5H19L12 3.5L5 10.5H9V16.5H15ZM12 6.33L14.17 8.5H13V14.5H11V8.5H9.83L12 6.33ZM19 20.5V18.5H5V20.5H19Z" fill="#8D8A8A"/>
                                                    </svg>
                                                     {{ translate('Choose image')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Display Name') }}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-craft form-control text-title-thin {{ $errors->has('display_name') ? 'is-invalid' : '' }}" placeholder="{{ translate("Display Name") }}" name="display_name" value="{{ Auth::user()->display_name }}">
                                        @if ($errors->has('display_name'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('display_name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-title-thin">{{ translate('First Name') }}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-craft{{ $errors->has('fname') ? ' is-invalid' : '' }} form-control text-title-thin" placeholder="{{ translate('First Name') }}" name="fname" value="{{  Auth::user()->fname ?? Auth::user()->first_name  ?? "N/A" }}">
                                        @if ($errors->has('fname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-title-thin">{{ translate('Last Name') }}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-craft{{ $errors->has('lname') ? ' is-invalid' : '' }} form-control text-title-thin" placeholder="{{ translate('Last Name') }}" name="lname" value="{{ Auth::user()->lname ?? Auth::user()->last_name ?? "N/A" }}">
                                        @if ($errors->has('lname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('lname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Username') }}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-craft form-control text-title-thin {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="{{ translate('Username') }}" name="username" value="{{ Auth::user()->username  ?? "N/A" }}">
                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('username') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if (Auth::user()->user_type == 'reseller')
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-title-thin">{{ translate('Mobile Number') }}</label>
                                    <div class="col-md-4">
                                        <input type="tel" id="phone-code" class="form-craft form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" value="{{ Auth::user()->mobile ?? Auth::user()->phone }}" name="mobile" autocomplete="off">
                                        {{-- <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('Mobile Number')}}" name="mobile" value="{{ Auth::user()->mobile ?? Auth::user()->phone }}"> --}}
                                        <input type="hidden" class="form-control" value="63" placeholder="" name="countryCode">
                                        <input type="hidden" class="form-control" value="" placeholder="" name="country">
                                        @if ($errors->has('mobile'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-title-thin">{{ translate('Mobile Number') }}</label>
                                    <div class="col-md-10">
                                        <input type="tel" id="phone-code" class="form-craft form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" value="{{ Auth::user()->mobile ?? Auth::user()->phone ?? "N/A" }}" name="mobile" autocomplete="off">
                                        @if ($errors->has('mobile'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                        {{-- <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('Mobile Number')}}" name="mobile" value="{{ Auth::user()->mobile ?? Auth::user()->phone  }}"> --}}
                                        <input type="hidden" class="form-control" value="63" placeholder="" name="countryCode">
                                        <input type="hidden" class="form-control" value="" placeholder="" name="country">
                                    </div>
                                </div>
                                @endif

                                @if (Auth::user()->user_type == 'reseller')

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label text-title-thin">{{ translate('Phone Number') }}</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('Phone Number')}}" name="phone" value="{{ \App\Reseller::where('user_id','=',Auth::user()->id)->first()->telephone_number ?? "N/A" }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label text-title-thin">{{ translate('Address') }}</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-craft{{ $errors->has('reselleraddress') ? ' is-invalid' : '' }} form-control text-title-thin" placeholder="{{ translate('Address') }}" name="reselleraddress" value="{{ Auth::user()->address ?? "N/A" }}">
                                            @if ($errors->has('reselleraddress'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('reselleraddress') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label text-title-thin">{{ translate('City') }}</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-craft{{ $errors->has('city') ? ' is-invalid' : '' }} form-control text-title-thin" placeholder="{{ translate('City')}}" name="city" value="{{ Auth::user()->city ?? "N/A" }}">
                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label text-title-thin">{{ translate('Postal Code') }}</label>
                                        <div class="col-md-4">
                                            <input type="number" class="form-craft{{ $errors->has('postal') ? ' is-invalid' : '' }} form-control text-title-thin" placeholder="{{ translate('Postal Code')}}" name="postal" value="{{ Auth::user()->postal_code ?? "N/A" }}">
                                            @if ($errors->has('postal'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('postal') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label text-title-thin">{{ translate('Birth Date') }}</label>
                                        <div class="col-md-4">
                                            <input type="date" class="form-craft{{ $errors->has('birthday') ? ' is-invalid is-invalid-pass' : '' }} form-control text-title-thin" placeholder="{{ translate('Birth Date')}}" name="birthday" value="{{ Auth::user()->birthdate ?? "N/A" }}" id="datepicker">
                                            @if ($errors->has('birthday'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('birthday') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                {{-- Password Controller --}}
                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-form-label text-title-thin">Password</label>
                                    <div class="col-md-10">
                                        <input type="password" id="current_password" name="current_password" class="form-craft form-control text-title-thin {{ $errors->has('current_password') ? 'is-invalid is-invalid-pass' : '' }}" placeholder="{{ translate('Password') }}">
                                        <span id="pass-icon" toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password password-profile"></span>
                                        @if ($errors->has('current_password'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $errors->first('current_password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label text-title-thin">New Password</label>
                                    <div class="col-md-10">
                                        <input type="password" id="new_password" class="form-craft form-control text-title-thin {{ $errors->has('new_password') ? 'is-invalid is-invalid-pass' : '' }}" placeholder="{{ translate('New Password') }}" name="new_password">
                                        <span id="pass-icon" toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password password-profile"></span>
                                        <div id="message" class="mb-2 text-subprimary">
                                            <span>Password must contain the following:</span>
                                            <p id="length" class="invalid text-subprimary">Minimum <b>8 characters</b></p>
                                        </div>
                                        @if ($errors->has('new_password'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $errors->first('new_password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-bottom: 60px;">
                                    <label class="col-md-2 col-form-label text-title-thin">{{ translate('Confirm New Password') }}</label>
                                    <div class="col-md-10">
                                        <input type="password" id="confirm_password" class="form-craft form-control text-title-thin {{ $errors->has('confirm_password') ? 'is-invalid is-invalid-pass' : '' }}" placeholder="{{ translate('Confirm Password') }}" name="confirm_password">
                                        <span id="pass-icon" toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password password-profile"></span>
                                       
                                        <div id="msg" class="my-2"></div>

                                        @if ($errors->has('confirm_password'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $errors->first('confirm_password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if (Auth::user()->user_type == 'reseller')
                                    <div class="mt-2 mb-3">
                                        <span class="order-details-uploaded-images-label">employment details</span>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label text-title-thin">Employment Status</label>
                                        <div class="col-md-4">
                                            <select id="employmentStatus" name="employmentStatus" class="custom-select custom-select-lg form-craft form-control form-control-lg {{ $errors->has('employmentStatus') ? 'is-invalid' : '' }}" value={{ Auth::user()->reseller->employment_status }}>
                                                <option value="">Select employment status</option>
                                                    <option value="Employed" {{ Auth::user()->reseller->employment_status == 'Employed' ? 'selected' : '' }}> Employed</option>
                                                    <option value="Business" {{ Auth::user()->reseller->employment_status == 'Business' ? 'selected' : '' }}> Business</option>
                                                    <option value="Freelancer" {{ Auth::user()->reseller->employment_status == 'Freelancer' ? 'selected' : '' }}> Freelancer</option>
                                                    <option value="Student" {{ Auth::user()->reseller->employment_status == 'Student' ? 'selected' : '' }}> Student</option>
                                                    <option value="Housewife" {{ Auth::user()->reseller->employment_status == 'Housewife' ? 'selected' : '' }}> Housewife</option>
                                                    <option value="Others" {{ Auth::user()->reseller->employment_status == 'Others' ? 'selected' : '' }}> Others</option>
                                            </select>
                                            @if ($errors->has('employmentStatus'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('employmentStatus') }}</strong>
                                            </span>
                                        @endif
                                        </div>
                                    </div>

                                    <div id="documents-images-container" >

                                        <div id="Employed" style="display: none">
                                            <div>
                                                @php
                                                    $employed = ['companyId', 'emp_governmentId'];
                                                @endphp

                                                <div class="row" id="input-w-label">
                                                    <div class="col-md-2 text-craft-sub label-space-after">{{ translate('Business info') }} </div>
                                                    <div class="col-md-10 tab-10">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12  mb-2">
                                                                <div class="mb-2 text-craft-sub">{{ translate('Company Name') }} </div>
                                                                <input type="text"
                                                                    class="form-craft{{ $errors->has('companyName') ? ' is-invalid' : '' }}"
                                                                    value="{{ \App\Reseller::where('user_id','=',Auth::user()->id)->first()->company_name ?? old('companyName') }}" name="companyName">
                                                                @if ($errors->has('companyName'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('companyName') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6 col-sm-12  mb-2">
                                                                <div class="mb-2 text-craft-sub">{{ translate('Company Contact No') }}</div>
                                                                <input type="text"
                                                                    class="form-craft{{ $errors->has('companyContactNo') ? ' is-invalid' : '' }}"
                                                                    value="{{\App\Reseller::where('user_id','=',Auth::user()->id)->first()->company_contact ?? old('companyContactNo') }}" name="companyContactNo">
                                                                @if ($errors->has('companyContactNo'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('companyContactNo') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="mb-2 text-craft-sub">{{ translate('Company Address') }} </div>
                                                            <input type="text"
                                                                class="form-craft{{ $errors->has('companyAddress') ? ' is-invalid' : '' }}"
                                                                value="{{\App\Reseller::where('user_id','=',Auth::user()->id)->first()->company_address ?? old('companyAddress') }}"
                                                                placeholder="{{ translate('House No., Street, Barangay, City/Town, Province') }}"
                                                                name="companyAddress">
                                                            @if ($errors->has('companyAddress'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('companyAddress') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach ($employed as $item)
                                                    <div class="form-group row">
                                                        @if ($item == 'companyId')
                                                            <label for="" class="col-md-2 col-form-label text-title-thin">Company ID</label>
                                                        @elseif ($item == 'emp_governmentId')
                                                            <label for="" class="col-md-2 col-form-label text-title-thin">Government-issue Id</label>
                                                        @endif

                                                        <div class="d-flex col-md-10">
                                                            <div class="image-preview mr-5">
                                                                <div class="d-flex"
                                                                    style="align-items:center; justify-content:center; height:100%">
                                                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M30.4782 21.3877C30.131 21.0399 29.7084 20.8661 29.2116 20.8661H21.2566C20.996 21.5615 20.5581 22.1327 19.9434 22.5798C19.3284 23.0269 18.6424 23.2505 17.8849 23.2505H13.1152C12.3577 23.2505 11.6714 23.0268 11.0568 22.5798C10.442 22.1327 10.0043 21.5616 9.7435 20.8661H1.78844C1.29174 20.8661 0.869489 21.0399 0.521628 21.3877C0.173833 21.7352 0 22.1574 0 22.6543V28.6159C0 29.1124 0.173833 29.5352 0.521628 29.8824C0.869424 30.2302 1.29167 30.4039 1.78844 30.4039H29.2118C29.7084 30.4039 30.131 30.2302 30.4784 29.8824C30.8263 29.5348 31 29.1124 31 28.6159V22.6543C31 22.1574 30.8263 21.7356 30.4782 21.3877ZM23.4925 27.6657C23.2562 27.9018 22.9767 28.0199 22.6538 28.0199C22.3308 28.0199 22.0517 27.9018 21.8155 27.6657C21.5796 27.43 21.4617 27.1504 21.4617 26.8274C21.4617 26.5045 21.5796 26.2248 21.8155 25.9891C22.0517 25.7534 22.3308 25.6349 22.6538 25.6349C22.9767 25.6349 23.2562 25.7533 23.4925 25.9891C23.7283 26.2247 23.8462 26.5045 23.8462 26.8274C23.8462 27.1504 23.7283 27.4299 23.4925 27.6657ZM28.2614 27.6657C28.0256 27.9018 27.7461 28.0199 27.4231 28.0199C27.1002 28.0199 26.8208 27.9018 26.5848 27.6657C26.349 27.43 26.2311 27.1504 26.2311 26.8274C26.2311 26.5045 26.349 26.2248 26.5848 25.9891C26.8208 25.7534 27.1001 25.6349 27.4231 25.6349C27.746 25.6349 28.0255 25.7533 28.2614 25.9891C28.4974 26.2247 28.6155 26.5045 28.6155 26.8274C28.6155 27.1504 28.4976 27.4299 28.2614 27.6657Z"
                                                                            fill="#E4711A" />
                                                                        <path
                                                                            d="M7.15367 11.3272H11.9229V19.6736C11.9229 19.9965 12.0409 20.276 12.2768 20.5119C12.5128 20.7477 12.7923 20.8661 13.1151 20.8661H17.8848C18.2077 20.8661 18.4869 20.7478 18.7231 20.5119C18.9589 20.2761 19.0769 19.9966 19.0769 19.6736V11.3272H23.8462C24.368 11.3272 24.7345 11.0787 24.9453 10.5821C25.1566 10.0977 25.0694 9.66917 24.6845 9.29651L16.3381 0.950252C16.1144 0.714233 15.8353 0.596191 15.4998 0.596191C15.1647 0.596191 14.8852 0.714233 14.6615 0.950252L6.31543 9.29651C5.93031 9.66917 5.84346 10.0975 6.05449 10.5821C6.26584 11.079 6.63217 11.3272 7.15367 11.3272Z"
                                                                            fill="#E4711A" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            @if ($errors->has( $item ))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first($item)  }}</strong>
                                                                </span>
                                                            @endif

                                                            <div class="image-body" style="align-self:center; position:relative">
                                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                    <label for="upload" class="craft-file-upload-disabled c-pointer">
                                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z" fill="white"/>
                                                                        </svg>
                                                                        {{  translate('Choose file') }}
                                                                    </label>
                                                                    @php
                                                                        $typeID = explode("_", $item);
                                                                        if(count($typeID) > 1){
                                                                            $typeID = $typeID[1];
                                                                        }else{
                                                                            $typeID = $item;
                                                                        }
                                                                        // $typeID = $typeID[1];
                                                                        $img = \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first() ? \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first()->img : "";
                                                                    @endphp
                                                                    {{-- {{$typeID}} --}}
                                                                    <input type="hidden" name="{{ $item }}" value="{{$img}}" class="selected-files " id="upload">
                                                                    <div class="file-amount text-title-thin text-elipsis ml-2 mt-2">{{ translate('Choose File') }}</div>
                                                                        {{-- <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files"> --}}
                                                                </div>

                                                                <div  class="file-preview box xxl docs-image-size file-preview-style" style="position:absolute; left: -304px; top: -44px; z-index:1; background-color:white;"></div>
                                                                <p class="opacity-60 delivery-status"> {{  translate('Maximum image file size is 1MB') }}.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div id="Business" style="display: none">
                                            @php
                                                $business = ['mayorsBusinessPermit', 'dti', 'bir', 'bus_governmentId', 'businessStructure'];
                                            @endphp
                                            <div class="row" id="input-w-label">
                                                <div class="col-md-2 text-craft-sub label-space-after">{{ translate('Company') }} </div>
                                                <div class="col-md-10 tab-10">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12  mb-2">
                                                            <div class="mb-2 text-craft-sub">{{ translate('Registered business name') }}
                                                                </div>
                                                            <input type="text"
                                                                class="form-craft{{ $errors->has('businessName') ? ' is-invalid' : '' }}"
                                                                value="{{ \App\Reseller::where('user_id','=',Auth::user()->id)->first()->business_name ?? old('businessName') }}" name="businessName">
                                                            @if ($errors->has('businessName'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('businessName') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="mb-2 text-craft-sub">{{ translate('Business Address') }} </div>
                                                        <input type="text"
                                                            class="form-craft{{ $errors->has('businessAddress') ? ' is-invalid' : '' }}"
                                                            value="{{\App\Reseller::where('user_id','=',Auth::user()->id)->first()->business_address ?? old('businessAddress') }}" name="businessAddress">
                                                        @if ($errors->has('businessAddress'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('businessAddress') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12  mb-2">
                                                            <div class="mb-2 text-craft-sub">{{ translate('Nature of business') }} </div>
                                                            <input type="text"
                                                                class="form-craft{{ $errors->has('natureOfBusiness') ? ' is-invalid' : '' }}"
                                                                value="{{ \App\Reseller::where('user_id','=',Auth::user()->id)->first()->nature_of_business ?? old('natureOfBusiness') }}" name="natureOfBusiness">
                                                            @if ($errors->has('natureOfBusiness'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('natureOfBusiness') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="mb-2 text-craft-sub">{{ translate('Office or shop') }} </div>
                                                            <input type="text"
                                                                class="form-craft{{ $errors->has('office') ? ' is-invalid' : '' }}"
                                                                value="{{\App\Reseller::where('user_id','=',Auth::user()->id)->first()->office ?? old('office') }}" name="office">
                                                            @if ($errors->has('office'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('office') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 col-sm-12  mb-2">
                                                            <div class="mb-2 text-craft-sub">{{ translate('Years in business') }} </div>
                                                            <input type="text"
                                                                class="form-craft{{ $errors->has('yearsInBusiness') ? ' is-invalid' : '' }}"
                                                                value="{{ \App\Reseller::where('user_id','=',Auth::user()->id)->first()->years_in_business ?? old('yearsInBusiness') }}" name="yearsInBusiness">
                                                            @if ($errors->has('yearsInBusiness'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('yearsInBusiness') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @foreach ($business as $item)
                                                <div class="form-group row">
                                                    @if ($item == 'mayorsBusinessPermit')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Business Permit') }}</label>
                                                        {{-- <div class="mb-2 text-craft-sub">{{ translate('Business Permit') }}</div> --}}
                                                    @elseif($item == 'dti')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('DTI') }}</label>
                                                        {{-- <div class="mb-2 text-craft-sub">{{ translate('DTI') }}</div> --}}
                                                    @elseif($item == 'bir')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('BIR') }}</label>
                                                        {{-- <div class="mb-2 text-craft-sub">{{ translate('BIR') }}</div> --}}
                                                    @elseif($item == 'bus_governmentId')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Government-issue Id') }}</label>
                                                        {{-- <div class="mb-2 text-craft-sub">{{ translate('Government-issue Id') }}</div> --}}
                                                    @elseif($item == 'businessStructure')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Business Structure') }}</label>
                                                        {{-- <div class="mb-2 text-craft-sub">{{ translate('Business Structure') }}</div> --}}
                                                    @endif

                                                    <div class="d-flex col-md-10">
                                                        <div class="image-preview mr-5">
                                                            <div class="d-flex"
                                                                style="align-items:center; justify-content:center; height:100%">
                                                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M30.4782 21.3877C30.131 21.0399 29.7084 20.8661 29.2116 20.8661H21.2566C20.996 21.5615 20.5581 22.1327 19.9434 22.5798C19.3284 23.0269 18.6424 23.2505 17.8849 23.2505H13.1152C12.3577 23.2505 11.6714 23.0268 11.0568 22.5798C10.442 22.1327 10.0043 21.5616 9.7435 20.8661H1.78844C1.29174 20.8661 0.869489 21.0399 0.521628 21.3877C0.173833 21.7352 0 22.1574 0 22.6543V28.6159C0 29.1124 0.173833 29.5352 0.521628 29.8824C0.869424 30.2302 1.29167 30.4039 1.78844 30.4039H29.2118C29.7084 30.4039 30.131 30.2302 30.4784 29.8824C30.8263 29.5348 31 29.1124 31 28.6159V22.6543C31 22.1574 30.8263 21.7356 30.4782 21.3877ZM23.4925 27.6657C23.2562 27.9018 22.9767 28.0199 22.6538 28.0199C22.3308 28.0199 22.0517 27.9018 21.8155 27.6657C21.5796 27.43 21.4617 27.1504 21.4617 26.8274C21.4617 26.5045 21.5796 26.2248 21.8155 25.9891C22.0517 25.7534 22.3308 25.6349 22.6538 25.6349C22.9767 25.6349 23.2562 25.7533 23.4925 25.9891C23.7283 26.2247 23.8462 26.5045 23.8462 26.8274C23.8462 27.1504 23.7283 27.4299 23.4925 27.6657ZM28.2614 27.6657C28.0256 27.9018 27.7461 28.0199 27.4231 28.0199C27.1002 28.0199 26.8208 27.9018 26.5848 27.6657C26.349 27.43 26.2311 27.1504 26.2311 26.8274C26.2311 26.5045 26.349 26.2248 26.5848 25.9891C26.8208 25.7534 27.1001 25.6349 27.4231 25.6349C27.746 25.6349 28.0255 25.7533 28.2614 25.9891C28.4974 26.2247 28.6155 26.5045 28.6155 26.8274C28.6155 27.1504 28.4976 27.4299 28.2614 27.6657Z"
                                                                        fill="#E4711A" />
                                                                    <path
                                                                        d="M7.15367 11.3272H11.9229V19.6736C11.9229 19.9965 12.0409 20.276 12.2768 20.5119C12.5128 20.7477 12.7923 20.8661 13.1151 20.8661H17.8848C18.2077 20.8661 18.4869 20.7478 18.7231 20.5119C18.9589 20.2761 19.0769 19.9966 19.0769 19.6736V11.3272H23.8462C24.368 11.3272 24.7345 11.0787 24.9453 10.5821C25.1566 10.0977 25.0694 9.66917 24.6845 9.29651L16.3381 0.950252C16.1144 0.714233 15.8353 0.596191 15.4998 0.596191C15.1647 0.596191 14.8852 0.714233 14.6615 0.950252L6.31543 9.29651C5.93031 9.66917 5.84346 10.0975 6.05449 10.5821C6.26584 11.079 6.63217 11.3272 7.15367 11.3272Z"
                                                                        fill="#E4711A" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has( $item ))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first($item) }}</strong>
                                                            </span>
                                                        @endif

                                                        <div class="image-body" style="align-self:center; position:relative">
                                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                <label for="upload" class="craft-file-upload-disabled c-pointer">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z" fill="white"/>
                                                                    </svg>
                                                                    {{  translate('Choose file') }}
                                                                </label>
                                                                @php
                                                                    $typeID = explode("_", $item);
                                                                    if(count($typeID) > 1){
                                                                        $typeID = $typeID[1];
                                                                    }else{
                                                                        $typeID = $item;
                                                                    }
                                                                    // $typeID = $typeID[1];
                                                                    $img = \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first() ? \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first()->img : "";
                                                                @endphp
                                                                <input type="hidden" name="{{ $item }}" value="{{$img}}"  class="selected-files" id="upload">
                                                                <div class="file-amount text-title-thin text-elipsis ml-2 mt-2">{{ translate('Choose File') }}</div>
                                                                    {{-- <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files"> --}}
                                                            </div>

                                                            <div class="file-preview box xxl docs-image-size file-preview-style" style="position:absolute; left: -304px; top: -44px; z-index:1; background-color:white;"></div>

                                                            <p class="opacity-60 delivery-status"> {{  translate('Maximum image file size is 1MB') }}.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div id="Freelancer" style="display: none">
                                            @php
                                                $freelancer = ['fre_governmentId'];
                                            @endphp

                                            @foreach ($freelancer as $item)
                                                <div class="form-group row">
                                                    @if ($item == 'fre_governmentId')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Government-issue Id') }}</label>
                                                    @endif

                                                    <div class="d-flex col-md-10">
                                                        <div class="image-preview mr-5">
                                                            <div class="d-flex"
                                                                style="align-items:center; justify-content:center; height:100%">
                                                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M30.4782 21.3877C30.131 21.0399 29.7084 20.8661 29.2116 20.8661H21.2566C20.996 21.5615 20.5581 22.1327 19.9434 22.5798C19.3284 23.0269 18.6424 23.2505 17.8849 23.2505H13.1152C12.3577 23.2505 11.6714 23.0268 11.0568 22.5798C10.442 22.1327 10.0043 21.5616 9.7435 20.8661H1.78844C1.29174 20.8661 0.869489 21.0399 0.521628 21.3877C0.173833 21.7352 0 22.1574 0 22.6543V28.6159C0 29.1124 0.173833 29.5352 0.521628 29.8824C0.869424 30.2302 1.29167 30.4039 1.78844 30.4039H29.2118C29.7084 30.4039 30.131 30.2302 30.4784 29.8824C30.8263 29.5348 31 29.1124 31 28.6159V22.6543C31 22.1574 30.8263 21.7356 30.4782 21.3877ZM23.4925 27.6657C23.2562 27.9018 22.9767 28.0199 22.6538 28.0199C22.3308 28.0199 22.0517 27.9018 21.8155 27.6657C21.5796 27.43 21.4617 27.1504 21.4617 26.8274C21.4617 26.5045 21.5796 26.2248 21.8155 25.9891C22.0517 25.7534 22.3308 25.6349 22.6538 25.6349C22.9767 25.6349 23.2562 25.7533 23.4925 25.9891C23.7283 26.2247 23.8462 26.5045 23.8462 26.8274C23.8462 27.1504 23.7283 27.4299 23.4925 27.6657ZM28.2614 27.6657C28.0256 27.9018 27.7461 28.0199 27.4231 28.0199C27.1002 28.0199 26.8208 27.9018 26.5848 27.6657C26.349 27.43 26.2311 27.1504 26.2311 26.8274C26.2311 26.5045 26.349 26.2248 26.5848 25.9891C26.8208 25.7534 27.1001 25.6349 27.4231 25.6349C27.746 25.6349 28.0255 25.7533 28.2614 25.9891C28.4974 26.2247 28.6155 26.5045 28.6155 26.8274C28.6155 27.1504 28.4976 27.4299 28.2614 27.6657Z"
                                                                        fill="#E4711A" />
                                                                    <path
                                                                        d="M7.15367 11.3272H11.9229V19.6736C11.9229 19.9965 12.0409 20.276 12.2768 20.5119C12.5128 20.7477 12.7923 20.8661 13.1151 20.8661H17.8848C18.2077 20.8661 18.4869 20.7478 18.7231 20.5119C18.9589 20.2761 19.0769 19.9966 19.0769 19.6736V11.3272H23.8462C24.368 11.3272 24.7345 11.0787 24.9453 10.5821C25.1566 10.0977 25.0694 9.66917 24.6845 9.29651L16.3381 0.950252C16.1144 0.714233 15.8353 0.596191 15.4998 0.596191C15.1647 0.596191 14.8852 0.714233 14.6615 0.950252L6.31543 9.29651C5.93031 9.66917 5.84346 10.0975 6.05449 10.5821C6.26584 11.079 6.63217 11.3272 7.15367 11.3272Z"
                                                                        fill="#E4711A" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has( $item ))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first($item) }}</strong>
                                                            </span>
                                                        @endif

                                                        <div class="image-body" style="align-self:center; position:relative">
                                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                <label for="upload" class="craft-file-upload-disabled c-pointer">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z" fill="white"/>
                                                                    </svg>
                                                                    {{  translate('Choose file') }}
                                                                </label>
                                                                @php
                                                                    $typeID = explode("_", $item);
                                                                    if(count($typeID) > 1){
                                                                        $typeID = $typeID[1];
                                                                    }else{
                                                                        $typeID = $item;
                                                                    }
                                                                    // $typeID = $typeID[1];
                                                                    $img = \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first() ? \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first()->img : "";
                                                                @endphp
                                                                <input type="hidden" name="{{ $item }}" value="{{$img}}"  class="selected-files" id="upload">
                                                                <div class="file-amount text-title-thin text-elipsis ml-2 mt-2">{{ translate('Choose File') }}</div>
                                                                    {{-- <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files"> --}}
                                                            </div>

                                                            <div class="file-preview box xxl docs-image-size file-preview-style" style="position:absolute; left: -304px; top: -44px; z-index:1; background-color:white;"></div>

                                                            <p class="opacity-60 delivery-status"> {{  translate('Maximum image file size is 1MB') }}.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div id="Student" style="display: none">
                                            @php
                                                $student = ['schoolId', 'parentConsent'];
                                            @endphp
                                            @foreach ($student as $item)
                                                <div class="form-group row">
                                                    @if ($item == 'schoolId')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('School Id') }} </label>
                                                    @elseif ($item == 'parentConsent')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Parent Consent') }}</label>
                                                    @endif

                                                    <div class="d-flex col-md-10">
                                                        <div class="image-preview mr-5">
                                                            <div class="d-flex"
                                                                style="align-items:center; justify-content:center; height:100%">
                                                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M30.4782 21.3877C30.131 21.0399 29.7084 20.8661 29.2116 20.8661H21.2566C20.996 21.5615 20.5581 22.1327 19.9434 22.5798C19.3284 23.0269 18.6424 23.2505 17.8849 23.2505H13.1152C12.3577 23.2505 11.6714 23.0268 11.0568 22.5798C10.442 22.1327 10.0043 21.5616 9.7435 20.8661H1.78844C1.29174 20.8661 0.869489 21.0399 0.521628 21.3877C0.173833 21.7352 0 22.1574 0 22.6543V28.6159C0 29.1124 0.173833 29.5352 0.521628 29.8824C0.869424 30.2302 1.29167 30.4039 1.78844 30.4039H29.2118C29.7084 30.4039 30.131 30.2302 30.4784 29.8824C30.8263 29.5348 31 29.1124 31 28.6159V22.6543C31 22.1574 30.8263 21.7356 30.4782 21.3877ZM23.4925 27.6657C23.2562 27.9018 22.9767 28.0199 22.6538 28.0199C22.3308 28.0199 22.0517 27.9018 21.8155 27.6657C21.5796 27.43 21.4617 27.1504 21.4617 26.8274C21.4617 26.5045 21.5796 26.2248 21.8155 25.9891C22.0517 25.7534 22.3308 25.6349 22.6538 25.6349C22.9767 25.6349 23.2562 25.7533 23.4925 25.9891C23.7283 26.2247 23.8462 26.5045 23.8462 26.8274C23.8462 27.1504 23.7283 27.4299 23.4925 27.6657ZM28.2614 27.6657C28.0256 27.9018 27.7461 28.0199 27.4231 28.0199C27.1002 28.0199 26.8208 27.9018 26.5848 27.6657C26.349 27.43 26.2311 27.1504 26.2311 26.8274C26.2311 26.5045 26.349 26.2248 26.5848 25.9891C26.8208 25.7534 27.1001 25.6349 27.4231 25.6349C27.746 25.6349 28.0255 25.7533 28.2614 25.9891C28.4974 26.2247 28.6155 26.5045 28.6155 26.8274C28.6155 27.1504 28.4976 27.4299 28.2614 27.6657Z"
                                                                        fill="#E4711A" />
                                                                    <path
                                                                        d="M7.15367 11.3272H11.9229V19.6736C11.9229 19.9965 12.0409 20.276 12.2768 20.5119C12.5128 20.7477 12.7923 20.8661 13.1151 20.8661H17.8848C18.2077 20.8661 18.4869 20.7478 18.7231 20.5119C18.9589 20.2761 19.0769 19.9966 19.0769 19.6736V11.3272H23.8462C24.368 11.3272 24.7345 11.0787 24.9453 10.5821C25.1566 10.0977 25.0694 9.66917 24.6845 9.29651L16.3381 0.950252C16.1144 0.714233 15.8353 0.596191 15.4998 0.596191C15.1647 0.596191 14.8852 0.714233 14.6615 0.950252L6.31543 9.29651C5.93031 9.66917 5.84346 10.0975 6.05449 10.5821C6.26584 11.079 6.63217 11.3272 7.15367 11.3272Z"
                                                                        fill="#E4711A" />
                                                                </svg>
                                                            </div>
                                                        </div>

                                                        <div class="image-body" style="align-self:center; position:relative">
                                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                <label for="upload" class="craft-file-upload-disabled c-pointer">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z" fill="white"/>
                                                                    </svg>
                                                                    {{  translate('Choose file') }}
                                                                </label>
                                                                @php
                                                                    $typeID = explode("_", $item);
                                                                    if(count($typeID) > 1){
                                                                        $typeID = $typeID[1];
                                                                    }else{
                                                                        $typeID = $item;
                                                                    }
                                                                    // $typeID = $typeID[1];
                                                                    $img = \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first() ? \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first()->img : "";
                                                                @endphp
                                                                <input type="hidden" name="{{ $item }}" value="{{$img}}"  class="selected-files" id="upload">
                                                                <div class="file-amount text-title-thin text-elipsis ml-2 mt-2">{{ translate('Choose File') }}</div>
                                                                    {{-- <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files"> --}}
                                                            </div>

                                                            <div class="file-preview box xxl docs-image-size file-preview-style" style="position:absolute; left: -304px; top: -44px; z-index:1; background-color:white;"></div>

                                                            <p class="opacity-60 delivery-status"> {{  translate('Maximum image file size is 1MB') }}.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div id="Housewife" style="display: none">
                                            @php
                                                $housewife = ['hou_governmentId'];
                                            @endphp
                                            @foreach ($housewife as $item)
                                                <div class="form-group row">
                                                    @if ($item == 'hou_governmentId')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Government-issue Id') }}</label>
                                                    @endif

                                                    <div class="d-flex col-md-10">
                                                        <div class="image-preview mr-5">
                                                            <div class="d-flex"
                                                                style="align-items:center; justify-content:center; height:100%">
                                                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M30.4782 21.3877C30.131 21.0399 29.7084 20.8661 29.2116 20.8661H21.2566C20.996 21.5615 20.5581 22.1327 19.9434 22.5798C19.3284 23.0269 18.6424 23.2505 17.8849 23.2505H13.1152C12.3577 23.2505 11.6714 23.0268 11.0568 22.5798C10.442 22.1327 10.0043 21.5616 9.7435 20.8661H1.78844C1.29174 20.8661 0.869489 21.0399 0.521628 21.3877C0.173833 21.7352 0 22.1574 0 22.6543V28.6159C0 29.1124 0.173833 29.5352 0.521628 29.8824C0.869424 30.2302 1.29167 30.4039 1.78844 30.4039H29.2118C29.7084 30.4039 30.131 30.2302 30.4784 29.8824C30.8263 29.5348 31 29.1124 31 28.6159V22.6543C31 22.1574 30.8263 21.7356 30.4782 21.3877ZM23.4925 27.6657C23.2562 27.9018 22.9767 28.0199 22.6538 28.0199C22.3308 28.0199 22.0517 27.9018 21.8155 27.6657C21.5796 27.43 21.4617 27.1504 21.4617 26.8274C21.4617 26.5045 21.5796 26.2248 21.8155 25.9891C22.0517 25.7534 22.3308 25.6349 22.6538 25.6349C22.9767 25.6349 23.2562 25.7533 23.4925 25.9891C23.7283 26.2247 23.8462 26.5045 23.8462 26.8274C23.8462 27.1504 23.7283 27.4299 23.4925 27.6657ZM28.2614 27.6657C28.0256 27.9018 27.7461 28.0199 27.4231 28.0199C27.1002 28.0199 26.8208 27.9018 26.5848 27.6657C26.349 27.43 26.2311 27.1504 26.2311 26.8274C26.2311 26.5045 26.349 26.2248 26.5848 25.9891C26.8208 25.7534 27.1001 25.6349 27.4231 25.6349C27.746 25.6349 28.0255 25.7533 28.2614 25.9891C28.4974 26.2247 28.6155 26.5045 28.6155 26.8274C28.6155 27.1504 28.4976 27.4299 28.2614 27.6657Z"
                                                                        fill="#E4711A" />
                                                                    <path
                                                                        d="M7.15367 11.3272H11.9229V19.6736C11.9229 19.9965 12.0409 20.276 12.2768 20.5119C12.5128 20.7477 12.7923 20.8661 13.1151 20.8661H17.8848C18.2077 20.8661 18.4869 20.7478 18.7231 20.5119C18.9589 20.2761 19.0769 19.9966 19.0769 19.6736V11.3272H23.8462C24.368 11.3272 24.7345 11.0787 24.9453 10.5821C25.1566 10.0977 25.0694 9.66917 24.6845 9.29651L16.3381 0.950252C16.1144 0.714233 15.8353 0.596191 15.4998 0.596191C15.1647 0.596191 14.8852 0.714233 14.6615 0.950252L6.31543 9.29651C5.93031 9.66917 5.84346 10.0975 6.05449 10.5821C6.26584 11.079 6.63217 11.3272 7.15367 11.3272Z"
                                                                        fill="#E4711A" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has( $item ))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first($item) }}</strong>
                                                            </span>
                                                        @endif

                                                        <div class="image-body" style="align-self:center; position:relative">
                                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                <label for="upload" class="craft-file-upload-disabled c-pointer">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z" fill="white"/>
                                                                    </svg>
                                                                    {{  translate('Choose file') }}
                                                                </label>
                                                                @php
                                                                    $typeID = explode("_", $item);
                                                                    if(count($typeID) > 1){
                                                                        $typeID = $typeID[1];
                                                                    }else{
                                                                        $typeID = $item;
                                                                    }
                                                                    // $typeID = $typeID[1];
                                                                    $img = \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first() ? \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first()->img : "";
                                                                @endphp
                                                                <input type="hidden" name="{{ $item }}" value="{{$img}}" class="selected-files" id="upload">
                                                                <div class="file-amount text-title-thin text-elipsis ml-2 mt-2">{{ translate('Choose File') }}</div>
                                                                    {{-- <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files"> --}}
                                                            </div>

                                                            <div class="file-preview box xxl docs-image-size file-preview-style" style="position:absolute; left: -304px; top: -44px; z-index:1; background-color:white;"></div>

                                                            <p class="opacity-60 delivery-status"> {{  translate('Maximum image file size is 1MB') }}.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div id="Others" style="display: none">
                                            @php
                                                $others = ['oth_governmentId'];
                                            @endphp
                                            @foreach ($others as $item)
                                                <div class="form-group row">
                                                    @if ($item == 'oth_governmentId')
                                                        <label for="" class="col-md-2 col-form-label text-title-thin">{{ translate('Government-issue Id') }}</label>
                                                    @endif

                                                    <div class="d-flex col-md-10">
                                                        <div class="image-preview mr-5">
                                                            <div class="d-flex"
                                                                style="align-items:center; justify-content:center; height:100%">
                                                                <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M30.4782 21.3877C30.131 21.0399 29.7084 20.8661 29.2116 20.8661H21.2566C20.996 21.5615 20.5581 22.1327 19.9434 22.5798C19.3284 23.0269 18.6424 23.2505 17.8849 23.2505H13.1152C12.3577 23.2505 11.6714 23.0268 11.0568 22.5798C10.442 22.1327 10.0043 21.5616 9.7435 20.8661H1.78844C1.29174 20.8661 0.869489 21.0399 0.521628 21.3877C0.173833 21.7352 0 22.1574 0 22.6543V28.6159C0 29.1124 0.173833 29.5352 0.521628 29.8824C0.869424 30.2302 1.29167 30.4039 1.78844 30.4039H29.2118C29.7084 30.4039 30.131 30.2302 30.4784 29.8824C30.8263 29.5348 31 29.1124 31 28.6159V22.6543C31 22.1574 30.8263 21.7356 30.4782 21.3877ZM23.4925 27.6657C23.2562 27.9018 22.9767 28.0199 22.6538 28.0199C22.3308 28.0199 22.0517 27.9018 21.8155 27.6657C21.5796 27.43 21.4617 27.1504 21.4617 26.8274C21.4617 26.5045 21.5796 26.2248 21.8155 25.9891C22.0517 25.7534 22.3308 25.6349 22.6538 25.6349C22.9767 25.6349 23.2562 25.7533 23.4925 25.9891C23.7283 26.2247 23.8462 26.5045 23.8462 26.8274C23.8462 27.1504 23.7283 27.4299 23.4925 27.6657ZM28.2614 27.6657C28.0256 27.9018 27.7461 28.0199 27.4231 28.0199C27.1002 28.0199 26.8208 27.9018 26.5848 27.6657C26.349 27.43 26.2311 27.1504 26.2311 26.8274C26.2311 26.5045 26.349 26.2248 26.5848 25.9891C26.8208 25.7534 27.1001 25.6349 27.4231 25.6349C27.746 25.6349 28.0255 25.7533 28.2614 25.9891C28.4974 26.2247 28.6155 26.5045 28.6155 26.8274C28.6155 27.1504 28.4976 27.4299 28.2614 27.6657Z"
                                                                        fill="#E4711A" />
                                                                    <path
                                                                        d="M7.15367 11.3272H11.9229V19.6736C11.9229 19.9965 12.0409 20.276 12.2768 20.5119C12.5128 20.7477 12.7923 20.8661 13.1151 20.8661H17.8848C18.2077 20.8661 18.4869 20.7478 18.7231 20.5119C18.9589 20.2761 19.0769 19.9966 19.0769 19.6736V11.3272H23.8462C24.368 11.3272 24.7345 11.0787 24.9453 10.5821C25.1566 10.0977 25.0694 9.66917 24.6845 9.29651L16.3381 0.950252C16.1144 0.714233 15.8353 0.596191 15.4998 0.596191C15.1647 0.596191 14.8852 0.714233 14.6615 0.950252L6.31543 9.29651C5.93031 9.66917 5.84346 10.0975 6.05449 10.5821C6.26584 11.079 6.63217 11.3272 7.15367 11.3272Z"
                                                                        fill="#E4711A" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has( $item ))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first($item) }}</strong>
                                                            </span>
                                                        @endif

                                                        <div class="image-body" style="align-self:center; position:relative">
                                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                <label for="upload" class="craft-file-upload-disabled c-pointer">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z" fill="white"/>
                                                                    </svg>
                                                                    {{  translate('Choose file') }}
                                                                </label>
                                                                @php
                                                                    $typeID = explode("_", $item);
                                                                    if(count($typeID) > 1){
                                                                        $typeID = $typeID[1];
                                                                    }else{
                                                                        $typeID = $item;
                                                                    }
                                                                    // $typeID = $typeID[1];
                                                                    $img = \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first() ? \App\EmploymentStatusFile::where('reseller_id','=',\App\Reseller::where('user_id','=',Auth::user()->id)->first()->id)->where('img_type','=',$typeID)->first()->img : "";
                                                                @endphp
                                                                <input type="hidden" name="{{ $item }}" value="{{$img}}" class="selected-files" id="upload">
                                                                <div class="file-amount text-title-thin text-elipsis ml-2 mt-2">{{ translate('Choose File') }}</div>
                                                                    {{-- <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files"> --}}
                                                            </div>

                                                            <div class="file-preview box xxl docs-image-size file-preview-style" style="position:absolute; left: -304px; top: -44px; z-index:1; background-color:white;"></div>
                                                            <p class="opacity-60 delivery-status"> {{  translate('Maximum image file size is 1MB') }}.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group mb-0 text-right">
                                    <button type="submit" class="btn btn-primary btn-craft-primary-nopadding">{{translate('Update profile')}}</button>
                                </div>
                            </form>


                        </div>
                    </div>

                    <!-- Address -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start border-bottom mb-4">
                                <div class="card-customer-wallet-title text-title-thin fw-600">
                                    {{ translate('My Addresses') }}
                                </div>
                            </div>
                            <div class="row gutters-10">
                                @foreach (Auth::user()->addresses as $key => $address)
                                    <div class="col-lg-6">
                                        <div class="border p-3 pr-5 rounded mb-3 position-relative shipping-address-card">
                                            <div>
                                                <span class="w-50 fw-600 shipping-address-text">{{ translate('Island') }}:</span>
                                                <span class="ml-2 shipping-address-text">{{ ucfirst(str_replace('_', ' ', $address->island)) }}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600 shipping-address-text">{{ translate('Address') }}:</span>
                                                <span class="ml-2 shipping-address-text">{{ $address->address }}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600 shipping-address-text">{{ translate('Postal Code') }}:</span>
                                                <span class="ml-2 shipping-address-text">{{ $address->postal_code }}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600 shipping-address-text">{{ translate('City') }}:</span>
                                                <span class="ml-2 shipping-address-text">{{ $address->city }}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600 shipping-address-text">{{ translate('Country') }}:</span>
                                                <span class="ml-2 shipping-address-text">{{ $address->country }}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600 shipping-address-text">{{ translate('Phone') }}:</span>
                                                <span class="ml-2 shipping-address-text">{{ $address->phone }}</span>
                                            </div>
                                            @if ($address->set_default)
                                                <div class="position-absolute right-0 bottom-0 pr-2 pb-3">
                                                    <span class="badge badge-inline badge-primary p-3">{{ translate('Default') }}</span>
                                                </div>
                                            @endif
                                            <div class="dropdown position-absolute right-0 top-0">
                                                <button class="btn px-2 shipping-address-text" type="button" data-toggle="dropdown">
                                                    <i class="la la-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    @if (!$address->set_default)
                                                        <a class="dropdown-item shipping-address-text" href="{{ route('addresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                                                    @endif
                                                    <a class="dropdown-item shipping-address-text" href="{{ route('addresses.destroy', $address->id) }}">{{ translate('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-lg-6 mx-auto" onclick="add_new_address()">
                                    <div class="border p-3 rounded mb-3 c-pointer text-center bg-light shipping-address-card d-flex align-items-center justify-content-center">
                                        <i class="la la-plus la-2x"></i>
                                        <div class="alpha-7 shipping-address-text">{{ translate('Add New Address') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Change -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start border-bottom mb-4">
                                <div class="card-customer-wallet-title text-title-thin fw-600">
                                    {{ translate('Change your email') }}
                                </div>
                            </div>

                            <form action="{{ route('user.change.email') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2 text-title-thin">
                                        <label>{{ translate('Your Email') }}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group mb-3">
                                          <input type="email" class="form-craft form-control text-title-thin" placeholder="{{ translate('Your Email')}}" name="email" value="{{ Auth::user()->email }}" />
                                          <div class="input-group-append">
                                             <button type="button" class="btn btn-outline-secondary new-email-verification upload-button text-title-thin">
                                                 <span class="d-none loading">
                                                     <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                     {{ translate('Sending Email...') }}
                                                 </span>
                                                 <span class="default text-title-thin text-dark">{{ translate('Verify') }}</span>
                                             </button>
                                          </div>
                                        </div>
                                        <div class="form-group mb-0 text-right">
                                            <button type="submit" class="btn btn-primary btn-craft-primary-nopadding">{{translate('Update Email')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('modal')
    <div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body my-3">
                        <div class="p-3">
                            <div class="form-group">
                                <div class="row d-flex align-items-center">
                                    <div class="col-12 col-lg-2">
                                        <label for="" class="form-control-label">{{ translate('Country') }}</label>
                                    </div>
                                    <div class="col-12 col-lg-10">
                                        <select class="form-control aiz-selectpicker {{ $errors->has('country') ? 'is-invalid' : '' }}" data-live-search="true" data-placeholder="{{translate('Select your country')}}" name="country" required>
                                            @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                                <option value="{{ $country->name }}" @if ($country->name == 'Philippines') selected @endif>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('country') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row d-flex align-items-center">
                                    <div class="col-12 col-lg-2">
                                        <label for="" class="form-control-label">{{ translate('Island') }}</label>
                                    </div>
                                    <div class="col-12 col-lg-10">
                                        <select class="form-control aiz-selectpicker {{ $errors->has('island') ? 'is-invalid' : '' }}" data-live-search="false" name="island" required>
                                            <option value="north_luzon">North Luzon</option>
                                            <option value="south_luzon">South Luzon</option>
                                            <option value="visayas">Visayas</option>
                                            <option value="mindanao">Mindanao</option>
                                        </select>
                                        @if ($errors->has('island'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->has('island') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row d-flex align-items-center">
                                    <div class="col-12 col-lg-2">
                                        <label for="" class="form-control-label">{{ translate('City') }}</label>
                                    </div>
                                    <div class="col-12 col-lg-10">
                                        <input type="text" class="form-control form-craft {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city" placeholder="City" value="{{ old('city') }}">
                                        @if ($errors->has('city'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('city') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row d-flex align-items-center">
                                    <div class="col-12 col-lg-2">
                                        <label for="" class="form-control-label">{{ translate('Address') }}</label>
                                    </div>
                                    <div class="col-12 col-lg-10">
                                        <input type="text" class="form-control form-craft {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" placeholder="Full address" value="{{ old('address') }}">
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('address') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row d-flex align-items-center">
                                    <div class="col-12 col-lg-2">
                                        <label for="" class="form-control-label">{{ translate('Zip Code') }}</label>
                                    </div>
                                    <div class="col-12 col-lg-10">
                                        <input type="number" class="form-control form-craft {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" name="postal_code" placeholder="Zip Code" value="{{ old('postal_code') }}">
                                        @if ($errors->has('postal_code'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('postal_code') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row d-flex align-items-center">
                                    <div class="col-12 col-lg-2">
                                        <label for="" class="form-control-label">{{ translate('Phone') }}</label>
                                    </div>
                                    <div class="col-12 col-lg-10">
                                        <input type="number" class="form-control form-craft {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('phone') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group float-right my-3">
                                <button type="submit" class="btn btn-sm btn-craft-primary-nopadding">{{translate('Save')}}</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')


<script type="text/javascript">
var user_type = '{{Auth::user()->user_type}}';

    var count = 0; // needed for safari

        window.onload = function () {
            $.get("{{ route('check_auth') }}", function (data, status) {
                if (data == 1) {
                    // Do nothing
                }

                else {
                    window.location = '{{ route('user.login') }}';
                }
            });
        }

        setTimeout(function(){count = 1;},200);

    @if('{{Auth::user()->user_type}}' == 'reseller')
        $('#Employed').hide();
        $('#Business').hide();
        $('#Freelancer').hide();
        $('#Student').hide();
        $('#Housewife').hide();
        $('#Others').hide();
        $('#'+'{{ \App\Reseller::where('user_id','=',Auth::user()->id)->first()->employment_status }}').show();
        $('#employmentStatus').val('{{ \App\Reseller::where('user_id','=',Auth::user()->id)->first()->employment_status }}');
    @endif


    function add_new_address(){
        $('#new-address-modal').modal('show');
    }

    $('.new-email-verification').on('click', function() {
        $(this).find('.loading').removeClass('d-none');
        $(this).find('.default').addClass('d-none');
        var email = $("input[name=email]").val();

        $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
            data = JSON.parse(data);
            $('.default').removeClass('d-none');
            $('.loading').addClass('d-none');
            if(data.status == 2)
                AIZ.plugins.notify('warning', data.message);
            else if(data.status == 1)
                AIZ.plugins.notify('success', data.message);
            else
                AIZ.plugins.notify('danger', data.message);
        });
    });
    
    var employmentStatus = $('#employmentStatus').val() ?? "";
    $( document ).ready(function() {
        $("#"+employmentStatus).show();
        $("#"+$(employmentStatus).val()).show();

        
        $('#employmentStatus').on('change', function() {
            if(employmentStatus != ""){
                $("#"+employmentStatus ?? '').hide();
            }
            if($(this).val()){
                employmentStatus = $(this).val();
                $("#"+$(this).val()).show();
            }

            if(employmentStatus == 'Employed') {
                $('#Employed').show();
                $('#Business').hide();
                $('#Freelancer').hide();
                $('#Student').hide();
                $('#Housewife').hide();
                $('#Others').hide();
            }

            if(employmentStatus == 'Business') {
                $('#Employed').hide();
                $('#Business').show();
                $('#Freelancer').hide();
                $('#Student').hide();
                $('#Housewife').hide();
                $('#Others').hide();
            }

            if(employmentStatus == 'Freelancer') {
                $('#Employed').hide();
                $('#Business').hide();
                $('#Freelancer').show();
                $('#Student').hide();
                $('#Housewife').hide();
                $('#Others').hide();
            }

            if(employmentStatus == 'Student') {
                $('#Employed').hide();
                $('#Business').hide();
                $('#Freelancer').hide();
                $('#Student').show();
                $('#Housewife').hide();
                $('#Others').hide();
            }

            if(employmentStatus == 'Housewife') {
                $('#Employed').hide();
                $('#Business').hide();
                $('#Freelancer').hide();
                $('#Student').hide();
                $('#Housewife').show();
                $('#Others').hide();
            }

            if(employmentStatus == 'Others') {
                $('#Employed').hide();
                $('#Business').hide();
                $('#Freelancer').hide();
                $('#Student').hide();
                $('#Housewife').hide();
                $('#Others').show();
            }
        });

        employmentStatus = $(employmentStatus).val();
        $("#"+$(employmentStatus).val()).show();

        $("#confirm_password").keyup(function(){
            if ($("#new_password").val() != $("#confirm_password").val()) {
                $("#msg").html("Password do not match").css("color","red");
            }else{
                $("#msg").html("Password matched").css("color","green");
            }
        });

    });

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
        $('input[name=country]').val(country.name);
        $('input[name=countryCode]').val(country.dialCode);
        // $('#phone-code').on('change', function(){
        //     console.log($('#phone-code').val());
        //     $('#mobileNumber').val($('#phone-code').val());
        // });
        input.addEventListener("countrychange", function(e) {
            // var currentMask = e.currentTarget.placeholder;
            var country = iti.getSelectedCountryData();
            $('input[name=countryCode]').val(country.dialCode);
            $('input[name=country]').val(country.name);
        });

        $('#phone-code').on('keyup', function(){
            if($('input[name=countryCode]').val()=="63"){
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

         $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
        });

        var myInput = document.getElementById("new_password");
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

        @if ($errors->has('address'))
            $('#new-address-modal').modal('show');
        @endif
</script>
@endsection
