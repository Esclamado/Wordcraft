@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <a href="{{ route('purchase_history.show', encrypt($order_detail->order->id)) }}" class="back-to-page d-flex align-items-center">
                        <svg class="mr-3" width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.25 4.20833H3.03208L5.86625 1.36625L4.75 0.25L0 5L4.75 9.75L5.86625 8.63375L3.03208 5.79167H14.25V4.20833Z" fill="#1B1464"/>
                        </svg>

                        Back to Order Details
                    </a>

                    <h1 class="customer-craft-dashboard-title mt-4 mb-3">
                        {{ translate('Send Return Request') }}
                    </h1>

                    <form action="{{ route('refund_request_send', $order_detail->id) }}" method="post" enctype="multipart/form-data" id="chouse_form">
                        @csrf
                        <div class="card card-mobile-res1">
                            <div class="card-body overflow-auto">
                                <div class="refund-request-subtitle">
                                    Are you sure you want to return this product?
                                </div>

                                {{-- // Product Detail --}}
                                <div class="row mt-3 mb-3">
                                    <div class="col-3 col-lg-1">
                                        @php
                                            $product_image = null;

                                            if ($order_detail->product != null) {
                                                if ($order_detail->variation != "") {
                                                    $product_image = \App\ProductStock::where('product_id', $order_detail->product_id)
                                                        ->where('variant', $order_detail->variation)
                                                        ->first()->image;

                                                    if ($product_image != null) {
                                                        $product_image = uploaded_asset($product_image);
                                                    }

                                                    else {
                                                        $product_image = uploaded_asset($order_detail->product->thumbnail_img);
                                                    }
                                                }
                                                
                                                else {
                                                    $product_image = uploaded_asset($order_detail->product->thumbnail_img);
                                                }
                                            }
                                        @endphp
                                        <img
                                            class="img-fluid lazyload craft-purchase-history-image"
                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ $product_image }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                        >
                                    </div>
                                    <div class="col-9 col-lg-4">
                                        <div class="d-flex align-items-center h-100 craft-purchase-history-name">
                                            @if ($order_detail->product != null)
                                                <a href="{{ route('product', $order_detail->product->slug) }}" target="_blank">
                                                    {{ $order_detail->product->getTranslation('name') }}

                                                    @if ($order_detail->variation != null)
                                                        - {{ $order_detail->variation }}
                                                    @endif

                                                    <div class="d-block craft-purchase-history-pickup-time">
                                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.49967 1.08337C3.50967 1.08337 1.08301 3.51004 1.08301 6.50004C1.08301 9.49004 3.50967 11.9167 6.49967 11.9167C9.48967 11.9167 11.9163 9.49004 11.9163 6.50004C11.9163 3.51004 9.48967 1.08337 6.49967 1.08337ZM6.49967 10.8334C4.11092 10.8334 2.16634 8.88879 2.16634 6.50004C2.16634 4.11129 4.11092 2.16671 6.49967 2.16671C8.88842 2.16671 10.833 4.11129 10.833 6.50004C10.833 8.88879 8.88842 10.8334 6.49967 10.8334ZM5.41634 7.67546L8.98592 4.10587L9.74967 4.87504L5.41634 9.20837L3.24967 7.04171L4.01342 6.27796L5.41634 7.67546Z" fill="#10865C"/>
                                                        </svg>
                                                        {{ translate('Same day pickup') }}
                                                    </div>
                                                </a>
                                            @else
                                                <strong>{{  translate('Product Unavailable') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-2 d-flex align-items-center justify-content-end">
                                        <div class="craft-purchase-history-quantity">
                                            <span class="opacity-50">Qty: </span><span style="color: #31303E">{{ $order_detail->quantity }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5 d-flex align-items-center justify-content-end">
                                        <div class="craft-purchase-history-price">
                                            {{ single_price($order_detail->price) }}
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                {{-- // Return details --}}
                                <div>
                                    <div class="refund-request-title mb-4">
                                        Return Details
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="" class="col-form-label">First Name</label>
                                            <input type="text" class="form-craft{{ $errors->has('fname') ? ' is-invalid' : '' }} form-control text-title-thin" placeholder="{{ translate('First Name') }}" name="fname" value="{{  Auth::user()->fname ?? Auth::user()->first_name  }}">
                                                @if ($errors->has('fname'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('fname') }}</strong>
                                                    </span>
                                                @endif
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="" class="col-form-label">Last Name</label>
                                            <input type="text" class="form-craft{{ $errors->has('lname') ? ' is-invalid' : '' }} form-control text-title-thin" placeholder="{{ translate('Last Name') }}" name="lname" value="{{  Auth::user()->lname ?? Auth::user()->last_name  }}">
                                                @if ($errors->has('lname'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('lname') }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="" class="col-form-label">Mobile Number</label>
                                                <input type="tel" id="phone-code" class="form-craft form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" value="{{ Auth::user()->mobile ?? Auth::user()->phone }}" name="mobile" autocomplete="off">
                                                {{-- <input type="text" class="form-craft form-control text-title-thin" placeholder="{{ translate('Mobile Number')}}" name="mobile" value="{{ Auth::user()->mobile ?? Auth::user()->phone }}"> --}}
                                                <input type="hidden" class="form-control" value="63" placeholder="" name="countryCode">
                                                <input type="hidden" class="form-control" value="" placeholder="" name="country">
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="" class="col-form-label">Email Address</label>
                                            <input type="text" class="form-craft{{ $errors->has('email') ? ' is-invalid' : '' }} form-control text-title-thin" placeholder="{{ translate('Email Address') }}" name="email" value="{{ Auth::user()->email }}">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="" class="col-form-label">Select reason for return/refund</label>
                                            <select name="reason" class="form-control aiz-selectpicker {{ $errors->has('reason') ? 'is-invalid' : '' }}">
                                                <option value="">Select reason</option>
                                                <option value="Wrong product and Size" {{ old('reason') == 'Wrong product and Size' ? 'selected' : '' }}>Wrong product and Size</option>
                                                <option value="Defected Product" {{ old('reason') == 'Defected Product' ? 'selected' : '' }}>Defected Product</option>
                                                <option value="Other" {{ old('reason') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @if ($errors->has('reason'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('reason') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-form-label">Additional Information (optional)</label>
                                        <textarea name="additional_information" rows="4" class="form-control form-craft {{ $errors->has('additional_information') ? 'is-invalid' : '' }}" placeholder="Type here...">{{ old('additional_information') }}</textarea>
                                        @if ($errors->has('additional_information'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('additional_information') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group img-return">
                                        <label for="" class="col-form-label">Upload photo of damage</label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="form-control form-craft file-amount d-flex align-items-center {{ $errors->has('image') ? 'is-invalid' : '' }}" style="height: 50px;">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="image" value="" class="selected-files">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15 16.5V10.5H19L12 3.5L5 10.5H9V16.5H15ZM12 6.33L14.17 8.5H13V14.5H11V8.5H9.83L12 6.33ZM19 20.5V18.5H5V20.5H19Z" fill="#8D8A8A"/>
                                                    </svg>
                                                    {{ translate('Choose Image')}}
                                                </div>
                                            </div>
                                            @if ($errors->has('image'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                    {{ $errors->first('image') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>

                                    @php
                                        $return_policy =  \App\Page::where('type', 'return_policy_page')->first();
                                    @endphp

                                    <div class="refund-request-policies">
                                        <div class="refund-request-content mt-3">
                                            @php
                                                echo $return_policy->getTranslation('content');
                                            @endphp
                                        </div>
                                    </div>
                                    <div class="form-check mt-2">
                                        <label class="form-craft-check d-flex align-items-center" style="margin-top: 1.5px;" for="agreed_policies">
                                        <input class="form-check-input mr-4" name="agreed" type="checkbox" value="1" id="agreed_policies" style="height: 20px;">
                                            I have read and accepted the Return and Refund Policies of WorldCraft.
                                        </label>
                                        @if ($errors->has('agreed'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $errors->first('agreed') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end py-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Return Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
<script type="text/javascript">
        $( document ).ready(function() {
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
            console.log(country);
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
        }); 
    </script>
@endsection
