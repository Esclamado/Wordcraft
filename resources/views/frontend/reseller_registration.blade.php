@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg reseller-card container">
        <div class="row">
            <div class="col-xxl-4 col-xl-4 mx-auto">
                <div class="container">
                    <div class="details-header">
                        {{ translate('Apply as a Reseller') }}
                    </div>
                    <p style=" font-size: 16px;line-height: 24px;color:#62616A;">
                        {{ translate('As our reseller, you can enjoy the') }}
                        <br>
                        {{ translate('following perks') }}:
                    </p>
                    <div class="details-body d-flex">
                        <svg width="36" height="22" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.52751 12.1979L2.01001 7.68042L0.47168 9.20792L6.52751 15.2638L19.5275 2.26375L18 0.736252L6.52751 12.1979Z"
                                fill="#10865C" />
                        </svg>
                        <span
                            class="ml-2">{{ translate('Promote our products using a special link and get commission for every successful purchase') }}.</span>
                    </div>
                    <div class="details-body d-flex">
                        <svg width="17" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.52751 12.1979L2.01001 7.68042L0.47168 9.20792L6.52751 15.2638L19.5275 2.26375L18 0.736252L6.52751 12.1979Z"
                                fill="#10865C" />
                        </svg>
                        <span class="ml-2">{{ translate('Track your earnings') }}.</span>
                    </div>
                    <div class="details-body d-flex">
                        <svg width="17" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.52751 12.1979L2.01001 7.68042L0.47168 9.20792L6.52751 15.2638L19.5275 2.26375L18 0.736252L6.52751 12.1979Z"
                                fill="#10865C" />
                        </svg>
                        <span class="ml-2">{{ translate('Monitor your frequent customers') }}.</span>
                    </div>
                    <div class="details-body d-flex">
                        <svg width="17" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.52751 12.1979L2.01001 7.68042L0.47168 9.20792L6.52751 15.2638L19.5275 2.26375L18 0.736252L6.52751 12.1979Z"
                                fill="#10865C" />
                        </svg>
                        <span class="ml-2">{{ translate('Purchase our products with lower prices') }}.</span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-xl-8 mx-auto mt-sm-4 container">
                <div class="stepper-reseller mx-auto">
                    <div class="col pl-0">
                        <div class="step">
                            <img src="{{ static_asset('assets/img/headset-active.png') }}" style="height: 30px" width="30"
                                alt="">
                            <div class="step-label pl-1 pl-lg-3 pl-md-3">
                                Step 1
                                <p style="color:#0C0736;" class="fw-600">{{ translate('Agent Info') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="step step-mobile">
                            @if ($id == 1)
                                <img src="{{ static_asset('assets/img/shopping-list-inactive.png') }}"
                                    style="height: 30px" width="30" alt="">
                                <div class="step-label pl-1 pl-lg-3 pl-md-3" style="color:#62616A">
                                    Step 2
                                    <p>{{ translate('General Information') }}</p>
                                </div>
                            @elseif($id == 2 || $id == 3)
                                <img src="{{ static_asset('assets/img/shopping-list-active.png') }}" style="height: 30px"
                                    width="30" alt="">
                                <div class="step-label pl-1 pl-lg-3 pl-md-3">
                                    Step 2
                                    <p style="color:#0C0736;" class="fw-600">{{ translate('General Information') }}</p>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="col">
                        <div class="step-3 d-flex">
                            @if ($id == 1 || $id == 2)
                                <img src="{{ static_asset('assets/img/suitcase-inactive.png') }}" style="height: 30px"
                                    width="30" alt="">
                                <div class="step-label pl-1 pl-lg-3 pl-md-3" style="color:#62616A">
                                    Step 3
                                    <p>{{ translate('Employment Details') }}</p>
                                </div>
                            @elseif ($id == 3)
                                <img src="{{ static_asset('assets/img/suitcase-active.png') }}" style="height: 30px"
                                    width="30" alt="">
                                <div class="step-label pl-1 pl-lg-3 pl-md-3">
                                    Step 3
                                    <p style="color:#0C0736;" class="fw-600">{{ translate('Employment Details') }}</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="card-white container">
                    @if ($id == 1)
                        <div class="item-header d-flex fw-600" style="font-size:16px;">
                            <div class="pb-4 pr-2 border-primary">
                                {{ translate('Agent Information') }}
                            </div>
                        </div>
                        <form id="reg-pt1-form" class="form-default" role="form"
                            action="{{ route('reseller.register', ['id' => 1]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Employee ID Number') }} <span
                                            style="color:#CE141C">*</span></div>
                                    <input id="employeeidinput" type="text"
                                        class="form-craft{{ $errors->has('e_idnumber') ? ' is-invalid' : '' }}"
                                        value="{{ \App\User::find(Auth::user()->referred_by)->employee_id ?? old('e_idnumber') }}"
                                        placeholder="{{ translate('Employee ID Number') }}" name="e_idnumber">
                                    @if ($errors->has('e_idnumber'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('e_idnumber') }}</strong>
                                        </span>
                                    @endif
                                    <span class="invalid-feedback d-block" id="no-employee" role="alert"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('First Name') }}</div>
                                    <input id="employeefninput" type="text" readonly
                                        class="form-craft{{ $errors->has('e_fname') ? ' is-invalid' : '' }}"
                                        value="{{ \App\User::find(Auth::user()->referred_by)->first_name ?? old('e_fname') }}"
                                        placeholder="{{ translate('First Name') }}" name="e_fname">
                                    @if ($errors->has('e_fname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('e_fname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Last Name') }}</div>
                                    <input id="employeelninput" type="text" readonly
                                        class="form-craft{{ $errors->has('e_lname') ? ' is-invalid' : '' }}"
                                        value="{{ \App\User::find(Auth::user()->referred_by)->last_name ?? old('e_lname') }}"
                                        placeholder="{{ translate('Last Name') }}" name="e_lname">
                                    @if ($errors->has('e_lname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('e_lname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Position') }}</div>
                                    <input id="employeepinput" type="text" readonly
                                        class="form-craft{{ $errors->has('e_position') ? ' is-invalid' : '' }}"
                                        value="{{ \App\User::find(Auth::user()->referred_by)->user_type ?? old('e_position') }}"
                                        placeholder="{{ translate('Position') }}" name="e_position">
                                    @if ($errors->has('e_position'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('e_position') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Email Address') }}</div>
                                    <input id="employeeeinput" type="text" readonly
                                        class="form-craft{{ $errors->has('e_emailaddress') ? ' is-invalid' : '' }}"
                                        value="{{ \App\User::find(Auth::user()->referred_by)->email ?? old('e_emailaddress') }}"
                                        placeholder="{{ translate('Email Address') }}" name="e_emailaddress">
                                    @if ($errors->has('e_emailaddress'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('e_emailaddress') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row" style="font-size: 16px; line-height: 20px;">
                                <div
                                    class="col-lg-6 col-12 d-flex justify-content-center justify-content-md-center justify-content-lg-start mt-3 align-self-center">
                                    <a href="{{ route('reseller.index', 2) }}">
                                        {{ translate(' Skip this step, I don’t have an agent') }}
                                    </a>
                                </div>
                                <div
                                    class="col-lg-6 col-12 d-flex justify-content-center justify-content-md-center justify-content-lg-end mt-3">
                                    <button type="submit"
                                        class="btn-craft-primary fw-500 mr-2">{{ translate('Proceed to next step') }}
                                        <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.01 10.0833H4V11.9167H16.01V14.6667L20 11L16.01 7.33334V10.0833Z"
                                                fill="white" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @elseif($id == 2)
                        <div class="item-header d-flex fw-600" style="font-size:16px;">
                            <div class="pb-4 pr-2 border-primary">
                                {{ translate('General Information') }}
                            </div>
                        </div>
                        <form id="reg-pt2-form" class="form-default" role="form"
                            action="{{ route('reseller.register', ['id' => 2]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('First Name') }} <span
                                            style="color:#CE141C">*</span></div>
                                    <input type="text"
                                        class="form-craft{{ $errors->has('firstName') ? ' is-invalid' : '' }}"
                                        value="{{ Auth::user()->first_name ?? old('firstName') }}"
                                        placeholder="{{ translate('First Name') }}" name="firstName">
                                    @if ($errors->has('firstName'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstName') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Last Name') }} <span
                                            style="color:#CE141C">*</span></div>
                                    <input type="text"
                                        class="form-craft{{ $errors->has('lastName') ? ' is-invalid' : '' }}"
                                        value="{{ Auth::user()->last_name ?? old('lastName') }}" name="lastName">
                                    @if ($errors->has('lastName'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastName') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" class="form-control" value="63" placeholder="" name="countryCode">
                            <input type="hidden" class="form-control" value="" placeholder="" name="country">
                            <div class="form-group phone-form-group row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">
                                        {{ translate('Mobile Number') }}
                                        <span style="color:#CE141C">*</span>
                                    </div>
                                    <input type="tel" id="phone-code"
                                        class="form-craft form-control {{ $errors->has('mobileNumber') ? ' is-invalid' : '' }}"
                                        value="{{ Auth::user()->phone ?? old('mobileNumber') }}" name="mobileNumber"
                                        autocomplete="off"
                                    >
                                    @if ($errors->has('mobileNumber'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $errors->first('mobileNumber') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Phone Number') }}</div>
                                    <input type="text"
                                        class="form-craft{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}"
                                        value="{{ old('phoneNumber') }}" name="phoneNumber">
                                    @if ($errors->has('phoneNumber'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('phoneNumber') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Email Address') }} <span
                                            style="color:#CE141C">*</span></div>
                                    <input type="text"
                                        class="form-craft{{ $errors->has('emailAddress') ? ' is-invalid' : '' }}"
                                        value="{{ Auth::user()->email ?? old('emailAddress') }}" name="emailAddress">
                                    @if ($errors->has('emailAddress'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('emailAddress') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Address') }} <span
                                            style="color:#CE141C">*</span></div>
                                    <input type="text"
                                        class="form-craft{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                        value="{{ Auth::user()->address ?? old('address') }}" name="address">
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @php
                                $provinces = \DB::table('refprovince')->orderBy('provDesc', 'asc')->get(['provDesc', 'provCode']);
                            @endphp
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">
                                        {{ translate('Province') }} <span style="color:#CE141C">*</span>
                                    </div>
                                    <select name="province" id="province" class="form-control aiz-selectpicker{{ $errors->has('city') ? ' is-invalid' : '' }}" data-selected-text-format="count" data-live-search="true" data-placeholder="{{ translate('Choose Your Province') }}">
            							<option value="{{ old('city') }}" disabled selected>{{ translate('Choose Your Province')}}</option>
                                        @foreach ($provinces as $key => $province)
            							    <option value="{{ $province->provCode }}">{{ ucfirst(mb_strtolower($province->provDesc)) }}</option>
            							@endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">
                                        {{ translate('City') }} <span style="color:#CE141C">*</span>
                                    </div>
                                    <select name="city" id="city" class="form-control aiz-selectpicker{{ $errors->has('city') ? ' is-invalid' : '' }}" data-selected-text-format="count" data-live-search="true" data-placeholder="{{ translate('Choose Your City') }}">
            							<option value="{{ old('city') }}" disabled selected>{{ translate('Choose Your City')}}</option>
                                    </select>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Postal Code') }}</div>
                                    <input type="text"
                                        class="form-craft{{ $errors->has('postalCode') ? ' is-invalid' : '' }}"
                                        value="{{ Auth::user()->postal_code ?? old('postalCode') }}"
                                        placeholder="{{ translate('Postal Code') }}" name="postalCode">
                                    @if ($errors->has('postalCode'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('postalCode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="mb-2 text-craft-sub">{{ translate('Birthdate') }} <span
                                            style="color:#CE141C">*</span></div>
                                    <input type="text" id="datepicker"
                                        class="form-craft{{ $errors->has('birthdate') ? ' is-invalid' : '' }}"
                                        value="{{ Auth::user()->birthdate ?? old('birthdate') }}"
                                        name="birthdate"
                                        placeholder="mm/dd/yyyy">
                                        <span class="calendar-icon" toggle="#datepicker"><svg id="Capa_1" enable-background="new 0 0 512.001 512.001" height="20" viewBox="0 0 512.001 512.001" width="20" xmlns="http://www.w3.org/2000/svg"><g><path d="m15.001 421h75v45c0 8.284 6.716 15 15 15h392c8.284 0 15-6.716 15-15v-390c0-8.284-6.716-15-15-15h-75v-15c0-8.284-6.716-15-15-15s-15 6.716-15 15v15h-76v-15c0-8.284-6.716-15-15-15s-15 6.716-15 15v15h-75v-15c0-8.284-6.716-15-15-15s-15 6.716-15 15v15h-76c-8.284 0-15 6.716-15 15v90c0 110.55-45.945 195.596-84.603 228.477-4.852 4.043-6.651 10.691-4.502 16.63 2.151 5.938 7.789 9.893 14.105 9.893zm467 30h-362v-30h287c3.509 0 6.907-1.23 9.603-3.477 18.032-15.019 45.963-50.777 65.397-96.575zm-362-360h61v15c0 8.284 6.716 15 15 15s15-6.716 15-15v-15h75v15c0 8.284 6.716 15 15 15s15-6.716 15-15v-15h76v15c0 8.284 6.716 15 15 15s15-6.716 15-15v-15h60v60h-362zm-.257 89.99h361.991c-3.38 95.155-39.901 170.023-80.616 210.01h-351.999c46.133-58.781 68.149-135.318 70.624-210.01z"/></g></svg></span>
                                    @if ($errors->has('birthdate'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('birthdate') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row" style="font-size: 16px; line-height: 20px;">
                                <div
                                    class="col-lg-6 col-12 d-flex justify-content-center justify-content-md-center justify-content-lg-start mt-3 align-self-center">
                                    <svg width="19" class="mr-2" height="20" viewBox="0 0 19 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.625 9.20833H5.40708L8.24125 6.36625L7.125 5.25L2.375 10L7.125 14.75L8.24125 13.6337L5.40708 10.7917H16.625V9.20833Z"
                                            fill="#62616A" />
                                    </svg>
                                    <a href="{{ route('reseller.index', '1') }}">
                                        Back to agent information
                                    </a>
                                </div>
                                <div
                                    class="col-lg-6 col-12 d-flex justify-content-center justify-content-md-center justify-content-lg-end mt-3">
                                    <button type="submit"
                                        class="btn-craft-primary fw-500 mr-2">{{ translate('Proceed to next step') }}
                                        <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.01 10.0833H4V11.9167H16.01V14.6667L20 11L16.01 7.33334V10.0833Z"
                                                fill="white" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @elseif($id == 3)
                        <div class="item-header d-flex fw-600" style="font-size:16px;">
                            <div class="pb-4 pr-2" style="border-bottom: #D71921 3px solid;">
                                {{ translate('Employment Details') }}
                            </div>
                        </div>
                        <form id="reg-pt3-form" class="form-default" role="form"
                            action="{{ route('reseller.register', ['id' => 3]) }}" method="POST">
                            @csrf
                            <div class="form-group row col-md-7 col-sm-12">
                                <select id="employmentStatus" name="employmentStatus" class="form-craft form-control custom-select custom-select-lg text-paragraph-thin {{ $errors->has('employmentStatus') ? 'is-invalid' : '' }}">
                                    <option value="">Select employment status</option>
                                    <option value="Employed" @if (old('employmentStatus') == 'Employed') selected @endif> Employed</option>
                                    <option value="Business" @if (old('employmentStatus') == 'Business') selected @endif> Business</option>
                                    <option value="Freelancer" @if (old('employmentStatus') == 'Freelancer') selected @endif> Freelancer</option>
                                    <option value="Student" @if (old('employmentStatus') == 'Student') selected @endif> Student</option>
                                    <option value="Housewife" @if (old('employmentStatus') == 'Housewife') selected @endif> Housewife</option>
                                    <option value="Others" @if (old('employmentStatus') == 'Others') selected @endif> Others</option>
                                </select>
                                @if ($errors->has('employmentStatus'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $errors->first('employmentStatus') }}
                                    </span>
                                @endif
                            </div>

                            <div id="Employed" style="display: none">
                                <div class="employement-details">
                                    @php
                                        $employed = ['companyId', 'emp_governmentId'];
                                    @endphp

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12  mb-2">
                                            <div class="mb-2 text-craft-sub">{{ translate('Company Name') }} <span
                                                    style="color:#CE141C">*</span></div>
                                            <input type="text"
                                                class="form-craft{{ $errors->has('companyName') ? ' is-invalid' : '' }}"
                                                value="{{ old('companyName') }}" name="companyName">
                                            @if ($errors->has('companyName'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('companyName') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-sm-12  mb-2">
                                            <div class="mb-2 text-craft-sub">{{ translate('Company Contact No') }} <span
                                                    style="color:#CE141C">*</span></div>
                                            <input type="text"
                                                class="form-craft{{ $errors->has('companyContactNo') ? ' is-invalid' : '' }}"
                                                value="{{ old('companyContactNo') }}" name="companyContactNo">
                                            @if ($errors->has('companyContactNo'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('companyContactNo') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="mb-2 text-craft-sub">{{ translate('Company Address') }} <span
                                                style="color:#CE141C">*</span></div>
                                        <input type="text"
                                            class="form-craft{{ $errors->has('companyAddress') ? ' is-invalid' : '' }}"
                                            value="{{ old('companyAddress') }}"
                                            placeholder="{{ translate('House No., Street, Barangay, City/Town, Province') }}"
                                            name="companyAddress">
                                        @if ($errors->has('companyAddress'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('companyAddress') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                   <div class="row">
                                        <div class="col-md-6 col-sm-12 mb-2">
                                            <div class="mb-2 text-craft-sub">
                                                {{ translate('TIN Number') }}
                                            </div>
                                            <input type="text" class="form-craft{{ $errors->has('employee_tin') ? ' is-invalid' : '' }}" value="{{ old('employee_tin') }}" placeholder="Tin Number" name="employee_tin">
                                            @if ($errors->has('employee_tin'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('employee_tin') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                   </div>
                                    @foreach ($employed as $item)

                                        <div class="form-group mb-5">
                                            @if ($item == 'companyId')
                                                <div class="mb-2 text-craft-sub">{{ translate('Company Id') }}<span
                                                        style="color:#CE141C">*</span></div>
                                            @elseif ($item == 'emp_governmentId')
                                                <div class="mb-2 text-craft-sub">
                                                    {{ translate('Government-issue Id') }}<span
                                                        style="color:#CE141C">*</span></div>
                                            @endif
                                            <div class="d-lg-flex d-md-flex d-block">
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
                                                    @if ($errors->has($item))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            {{ $errors->first($item) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="image-body d-flex justify-content-center" style="align-self:center; position:relative">
                                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                        <label for="upload" class="craft-file-upload c-pointer">
                                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z"
                                                                    fill="white" />
                                                            </svg>
                                                            {{ translate('Choose file') }}</label>
                                                        <input type="hidden" name="{{ $item }}" value=""
                                                            class="selected-files" id="upload">
                                                    </div>
                                                    <div class="file-preview box xxl"
                                                        style="position:absolute;left: -301px;top: -48px;">
                                                    </div>
                                                    <p> {{ translate('Maximum image file size is 1MB') }}.</p>
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
                                <div class="row">
                                    <div class="col-md-6 col-sm-12  mb-2">
                                        <div class="mb-2 text-craft-sub">{{ translate('Registered business name') }}
                                            <span style="color:#CE141C">*</span>
                                        </div>
                                        <input type="text"
                                            class="form-craft{{ $errors->has('businessName') ? ' is-invalid' : '' }}"
                                            value="{{ old('businessName') }}" name="businessName">
                                        @if ($errors->has('businessName'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('businessName') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="mb-2 text-craft-sub">{{ translate('Business Address') }} <span
                                            style="color:#CE141C">*</span></div>
                                    <input type="text"
                                        class="form-craft{{ $errors->has('businessAddress') ? ' is-invalid' : '' }}"
                                        value="{{ old('businessAddress') }}" name="businessAddress">
                                    @if ($errors->has('businessAddress'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('businessAddress') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12  mb-2">
                                        <div class="mb-2 text-craft-sub">{{ translate('Nature of business') }} <span
                                                style="color:#CE141C">*</span></div>
                                        <input type="text"
                                            class="form-craft{{ $errors->has('natureOfBusiness') ? ' is-invalid' : '' }}"
                                            value="{{ old('natureOfBusiness') }}" name="natureOfBusiness">
                                        @if ($errors->has('natureOfBusiness'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('natureOfBusiness') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2 text-craft-sub">{{ translate('Office or shop') }} <span
                                                style="color:#CE141C">*</span></div>
                                        <input type="text"
                                            class="form-craft{{ $errors->has('office') ? ' is-invalid' : '' }}"
                                            value="{{ old('office') }}" name="office">
                                        @if ($errors->has('office'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('office') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 col-sm-12  mb-2">
                                        <div class="mb-2 text-craft-sub">{{ translate('Years in business') }} <span
                                                style="color:#CE141C">*</span></div>
                                        <input type="text"
                                            class="form-craft{{ $errors->has('yearsInBusiness') ? ' is-invalid' : '' }}"
                                            value="{{ old('yearsInBusiness') }}" name="yearsInBusiness">
                                        @if ($errors->has('yearsInBusiness'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('yearsInBusiness') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <div class="mb-2 text-craft-sub">
                                            {{ translate('TIN Number') }}
                                        </div>
                                        <input type="text" class="form-craft{{ $errors->has('business_tin') ? ' is-invalid' : '' }}" value="{{ old('business_tin') }}" placeholder="" name="business_tin">
                                        @if ($errors->has('business_tin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('business_tin') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>
                                @foreach ($business as $item)
                                    <div class="form-group mb-5">
                                        @if ($item == 'mayorsBusinessPermit')
                                            <div class="mb-2 text-craft-sub">{{ translate('Business Permit') }}<span
                                                    style="color:#CE141C">*</span></div>
                                        @elseif($item == 'dti')
                                            <div class="mb-2 text-craft-sub">{{ translate('DTI') }}<span
                                                    style="color:#CE141C">*</span></div>
                                        @elseif($item == 'bir')
                                            <div class="mb-2 text-craft-sub">{{ translate('BIR') }}<span
                                                    style="color:#CE141C">*</span></div>
                                        @elseif($item == 'bus_governmentId')
                                            <div class="mb-2 text-craft-sub">{{ translate('Government-issue Id') }}<span
                                                    style="color:#CE141C">*</span></div>
                                        @elseif($item == 'businessStructure')
                                            <div class="mb-2 text-craft-sub">{{ translate('Business Structure') }}<span
                                                    style="color:#CE141C">*</span></div>
                                        @endif
                                        <div class="d-flex">
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
                                                @if ($errors->has($item))
                                                    <div>
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            {{ $errors->first($item) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="image-body" style="align-self:center; position:relative">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <label for="upload" class="craft-file-upload c-pointer">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z"
                                                                fill="white" />
                                                        </svg>
                                                        {{ translate('Choose file') }}</label>

                                                    <input type="hidden" name="{{ $item }}" value=""
                                                        class="selected-files" id="upload">
                                                </div>
                                                <div class="file-preview box xxl"
                                                    style="position:absolute;left: -301px;top:-48px;"></div>
                                                <p> {{ translate('Maximum image file size is 1MB') }}.</p>
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

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <div class="mb-2 text-craft-sub">
                                            {{ translate('TIN Number') }}
                                        </div>
                                        <input type="text" class="form-craft{{ $errors->has('freelance_tin') ? ' is-invalid' : '' }}" value="{{ old('freelance_tin') }}" placeholder="" name="freelance_tin">
                                        @if ($errors->has('freelance_tin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('freelance_tin') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                    <div class="form-group">
                                        <div class="mb-2 text-craft-sub">{{ translate('Government-issue Id') }}<span
                                                style="color:#CE141C">*</span></div>
                                        <div class="d-flex">
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
                                                <div>
                                                    @if ($errors->has($item))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            {{ $errors->first($item) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="image-body" style="align-self:center; position:relative">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <label for="upload" class="craft-file-upload c-pointer">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z"
                                                                fill="white" />
                                                        </svg>
                                                        {{ translate('Choose file') }}</label>

                                                    <input type="hidden" name="{{ $item }}" value=""
                                                        class="selected-files" id="upload">
                                                </div>
                                                <div class="file-preview box xxl"
                                                    style="position:absolute;left: -301px;top:-48px;"></div>
                                                <p> {{ translate('Maximum image file size is 1MB') }}.</p>
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

                                    <div class="form-group mb-5">

                                        @if ($item == 'schoolId')
                                            <div class="mb-2 text-craft-sub">{{ translate('School Id') }}<span
                                                    style="color:#CE141C">*</span></div>
                                        @elseif($item == 'parentConsent')
                                            <div class="mb-2 text-craft-sub">{{ translate('Parent Consent') }}<span
                                                    style="color:#CE141C">*</span></div>
                                        @endif
                                        <div class="d-flex">
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
                                                @if ($errors->has($item))
                                                    <div>
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            {{ $errors->first($item) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="image-body" style="align-self:center; position:relative">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <label for="upload" class="craft-file-upload c-pointer">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z"
                                                                fill="white" />
                                                        </svg>
                                                        {{ translate('Choose file') }}</label>

                                                    <input type="hidden" name="{{ $item }}" value=""
                                                        class="selected-files" id="upload">
                                                </div>
                                                <div class="file-preview box xxl"
                                                    style="position:absolute;left: -301px;top:-48px;"></div>
                                                <p> {{ translate('Maximum image file size is 1MB') }}.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="Housewife" style="display: none">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <div class="mb-2 text-craft-sub">
                                            {{ translate('TIN Number') }}
                                        </div>
                                        <input type="text" class="form-craft{{ $errors->has('housewife_tin') ? ' is-invalid' : '' }}" value="{{ old('housewife_tin') }}" placeholder="" name="housewife_tin">
                                        @if ($errors->has('housewife_tin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('housewife_tin') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @php
                                    $housewife = ['hou_governmentId'];
                                @endphp
                                @foreach ($housewife as $item)
                                    <div class="form-group">
                                        <div class="mb-2 text-craft-sub">{{ translate('Government-issue Id') }}<span
                                                style="color:#CE141C">*</span></div>
                                        <div class="d-flex">
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
                                                <div>
                                                    @if ($errors->has($item))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            {{ $errors->first($item) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="image-body" style="align-self:center; position:relative">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <label for="upload" class="craft-file-upload c-pointer">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z"
                                                                fill="white" />
                                                        </svg>
                                                        {{ translate('Choose file') }}</label>

                                                    <input type="hidden" name="{{ $item }}" value=""
                                                        class="selected-files" id="upload">
                                                </div>
                                                <div class="file-preview box xxl"
                                                    style="position:absolute;left: -301px;top:-48px;"></div>
                                                <p> {{ translate('Maximum image file size is 1MB') }}.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="Others" style="display: none">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-2">
                                        <div class="mb-2 text-craft-sub">
                                            {{ translate('TIN Number') }}
                                        </div>
                                        <input type="text" class="form-craft{{ $errors->has('other_tin') ? ' is-invalid' : '' }}" value="{{ old('other_tin') }}" placeholder="" name="other_tin">
                                        @if ($errors->has('other_tin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('other_tin') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @php
                                    $others = ['oth_governmentId'];
                                @endphp
                                @foreach ($others as $item)
                                    <div class="form-group">
                                        <div class="mb-2 text-craft-sub">{{ translate('Government-issue Id') }}<span
                                                style="color:#CE141C">*</span></div>
                                        <div class="d-flex">
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
                                                <div>
                                                    @if ($errors->has($item))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            {{ $errors->first($item) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="image-body" style="align-self:center; position:relative">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <label for="upload" class="craft-file-upload c-pointer">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z"
                                                                fill="white" />
                                                        </svg>
                                                        {{ translate('Choose file') }}</label>

                                                    <input type="hidden" name="{{ $item }}" value=""
                                                        class="selected-files" id="upload">
                                                </div>
                                                <div class="file-preview box xxl"
                                                    style="position:absolute;left: -301px;top:-48px;"></div>
                                                <p> {{ translate('Maximum image file size is 1MB') }}.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row mt-4">
                                <div
                                    class="d-flex col-md-12 col-lg-6 col-sm-12 align-self-center justify-content-lg-start justify-content-md-center justify-content-sm-center ">
                                    <svg width="19" class="mr-2" height="20" viewBox="0 0 19 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.625 9.20833H5.40708L8.24125 6.36625L7.125 5.25L2.375 10L7.125 14.75L8.24125 13.6337L5.40708 10.7917H16.625V9.20833Z"
                                            fill="#62616A" />
                                    </svg>
                                    <a href="{{ route('reseller.index', '2') }}" class="back-to-text">
                                        Back to general infomration
                                    </a>
                                </div>
                                <div class="d-flex col-md-12 col-lg-6 col-sm-12 justify-content-lg-end justify-content-md-center justify-content-sm-center mt-md-4 mt-sm-4"
                                    style="font-size: 16px; line-height: 20px;">
                                    <button type="submit"
                                        class="btn-craft-primary fw-500 pl-4 pr-4 pt-2 pb-2">{{ translate('Submit Application') }}
                                        <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.01 10.0833H4V11.9167H16.01V14.6667L20 11L16.01 7.33334V10.0833Z"
                                                fill="white" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">

<script type="text/javascript">

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

    $('#datepicker').datepicker({
      endDate: '-18y'
    });

    $("#Capa_1").click(function() {
        $("#datepicker").datepicker("show");
    });

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
    $( document ).ready(function() {
        if($("#employeeidinput").val() != ""){
            $("#employeeidinput").prop('readonly',true)
        }
        var employmentStatus = $('#employmentStatus').val()  ?? "";
        if(employmentStatus){
            $("#"+employmentStatus).css("display", "block");
        }
        $('#employmentStatus').on('change', function() {
            if(employmentStatus != ""){
                $("#"+employmentStatus?? '').css("display", "none");
            }
            if($(this).val()){
                employmentStatus = $(this).val();
                $("#"+$(this).val()).css("display", "block");
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
        
        input.addEventListener("countrychange", function(e) {
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
                            $('#employeefninput').val(data['first_name'] ?? "");
                            $('#employeelninput').val(data['last_name'] ?? "");
                            $('#employeeeinput').val(data['email'] ?? "");
                            $('#employeepinput').val(data['user_type'] ?? "");
                            $("#no-employee").html("");
                        }
                        
                        else {
                            $("#no-employee").html("No employee with that ID");
                            $('#employeefninput').val(data['first_name'] ?? "");
                            $('#employeelninput').val(data['last_name'] ?? "");
                            $('#employeeeinput').val(data['email'] ?? "");
                            $('#employeepinput').val(data['user_type'] ?? "");
                        }
                    }
                });
            }else{
                $('#employeefninput').val("");
                $('#employeelninput').val("");
                $('#employeeeinput').val("");
                $('#employeepinput').val("");
            }
        }

        $('#province').on('change', function () {
            var data = {
                "_token": "{{ csrf_token() }}",
                'province_code': $('#province').val()
            }

            $.ajax({
                type: "POST",
                url: '{{ route('get.cities') }}',
                data: data,
                success: function (data) {
                    $('#city').empty();
                    $('#city').append("<option disabled='disabled' selected>Choose Your City</option>")
                    data.forEach(element => {
                        $('#city').append(new Option(ucfirst(element.citymunDesc.toLowerCase()), ucfirst(element.citymunDesc.toLowerCase())));
                    });
                }
            })
        });

        function ucfirst (str) {
            var firstLetter = str.substr(0, 1);
            return firstLetter.toUpperCase() + str.substr(1);
        }

</script>
@endsection
