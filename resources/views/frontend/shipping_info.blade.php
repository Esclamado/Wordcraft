@extends('frontend.layouts.app')

@section('content')

<section class="pt-5 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-7 mx-auto">
                <div class="row gutters-5 text-center aiz-steps">
                    <div class="col active done">
                        <div class="icon bg-white">
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16.3 9.97C15.96 10.59 15.3 11 14.55 11H7.1L6 13H18V15H6C4.48 15 3.52 13.37 4.25 12.03L5.6 9.59L2 2H0V0H3.27L4.21 2H19.01C19.77 2 20.25 2.82 19.88 3.48L16.3 9.97ZM17.3099 4H5.15989L7.52989 9H14.5499L17.3099 4ZM6.00004 16C4.90003 16 4.01003 16.9 4.01003 18C4.01003 19.1 4.90003 20 6.00004 20C7.10004 20 8.00004 19.1 8.00004 18C8.00004 16.9 7.10004 16 6.00004 16ZM14.01 18C14.01 16.9 14.9 16 16 16C17.1 16 18 16.9 18 18C18 19.1 17.1 20 16 20C14.9 20 14.01 19.1 14.01 18Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div class="title fs-12">{{ translate('My Cart') }}</div>
                    </div>

                    <div class="col active done">
                        <div class="icon bg-white">
                            <svg id="Layer_1" enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25" xmlns="http://www.w3.org/2000/svg"><g><path fill="white" d="m256 0c-108.81 0-197.333 88.523-197.333 197.333 0 61.198 31.665 132.275 94.116 211.257 45.697 57.794 90.736 97.735 92.631 99.407 6.048 5.336 15.123 5.337 21.172 0 1.895-1.672 46.934-41.613 92.631-99.407 62.451-78.982 94.116-150.059 94.116-211.257 0-108.81-88.523-197.333-197.333-197.333zm0 474.171c-38.025-36.238-165.333-165.875-165.333-276.838 0-91.165 74.168-165.333 165.333-165.333s165.333 74.168 165.333 165.333c0 110.963-127.31 240.602-165.333 276.838z"/><path fill="white" d="m378.413 187.852-112-96c-5.992-5.136-14.833-5.136-20.825 0l-112 96c-6.709 5.75-7.486 15.852-1.735 22.561s15.852 7.486 22.561 1.735l13.586-11.646v79.498c0 8.836 7.164 16 16 16h144c8.836 0 16-7.164 16-16v-79.498l13.587 11.646c6.739 5.777 16.836 4.944 22.561-1.735 5.751-6.709 4.974-16.81-1.735-22.561zm-66.413 76.148h-112v-90.927l56-48 56 48z"/></g></svg>
                        </div>
                        <div class="title fs-12">{{ translate("Customer Information") }}</div>
                    </div>

                    <div class="col">
                        <div class="icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" class="filter-black" fill="#none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6667 3.33334H3.33341C2.40841 3.33334 1.67508 4.075 1.67508 5L1.66675 15C1.66675 15.925 2.40841 16.6667 3.33341 16.6667H16.6667C17.5917 16.6667 18.3334 15.925 18.3334 15V5C18.3334 4.075 17.5917 3.33334 16.6667 3.33334ZM16.6667 15H3.33341V10H16.6667V15ZM3.33341 6.66667H16.6667V5H3.33341V6.66667Z" fill="black"/>
                                </svg>

                        </div>
                        <div class="title fs-12">
                            {{ translate('Payment') }}
                        </div>
                    </div>
                    <div class="col">
                        <div class="icon">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.00008 0.666656C4.40008 0.666656 0.666748 4.39999 0.666748 8.99999C0.666748 13.6 4.40008 17.3333 9.00008 17.3333C13.6001 17.3333 17.3334 13.6 17.3334 8.99999C17.3334 4.39999 13.6001 0.666656 9.00008 0.666656ZM9.00008 15.6667C5.32508 15.6667 2.33341 12.675 2.33341 8.99999C2.33341 5.32499 5.32508 2.33332 9.00008 2.33332C12.6751 2.33332 15.6667 5.32499 15.6667 8.99999C15.6667 12.675 12.6751 15.6667 9.00008 15.6667ZM7.33341 10.8083L12.8251 5.31666L14.0001 6.49999L7.33341 13.1667L4.00008 9.83332L5.17508 8.65832L7.33341 10.8083Z"
                                    fill="black" />
                            </svg>
                        </div>
                        <div class="title fs-12">{{ translate('Confirmation') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-4 gry-bg">
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-xxl-8 col-xl-10 mx-auto">
                <form class="form-default" data-toggle="validator" action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST">
                    @csrf
                        @if(Auth::check())
                        <div class="shadow-sm bg-white p-4 rounded mb-4">
                            <div class="row gutters-5">
                                @foreach (Auth::user()->addresses as $key => $address)
                                    <div class="col-md-6 mb-3">
                                        <label class="aiz-megabox d-block bg-white mb-0">
                                            <input type="radio" name="address_id" value="{{ $address->id }}" @if ($address->set_default)
                                                checked
                                            @endif required>
                                            <span class="d-flex p-3 aiz-megabox-elem shipping-address-card">
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <span class="flex-grow-1 pl-3 text-left">
                                                    <div>
                                                        <span class="opacity-60 shipping-address-text">{{ translate('Island') }}:</span>
                                                        <span class="fw-600 ml-2 shipping-address-text">{{ ucfirst(str_replace('_', ' ', $address->island)) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60 shipping-address-text">{{ translate('Address') }}:</span>
                                                        <span class="fw-600 ml-2 shipping-address-text">{{ $address->address }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60 shipping-address-text">{{ translate('Postal Code') }}:</span>
                                                        <span class="fw-600 ml-2 shipping-address-text">{{ $address->postal_code }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60 shipping-address-text">{{ translate('City') }}:</span>
                                                        <span class="fw-600 ml-2 shipping-address-text">{{ $address->city }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60 shipping-address-text">{{ translate('Country') }}:</span>
                                                        <span class="fw-600 ml-2 shipping-address-text">{{ $address->country }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="opacity-60 shipping-address-text">{{ translate('Phone') }}:</span>
                                                        <span class="fw-600 ml-2 shipping-address-text">{{ $address->phone }}</span>
                                                    </div>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                                <input type="hidden" name="checkout_type" value="logged">
                                <div class="col-md-6 mx-auto mb-3" >
                                    <div class="border p-3 rounded mb-3 c-pointer text-center bg-white h-100 d-flex flex-column justify-content-center" onclick="add_new_address()">
                                        <i class="las la-plus la-2x mb-3"></i>
                                        <div class="alpha-7">{{ translate('Add New Address') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="shadow-sm bg-white p-4 rounded mb-4">
                                <div class="form-group">
                                    <label class="control-label">{{ translate('Name')}}</label>
                                    <input type="text" class="form-control" name="name" placeholder="{{ translate('Name')}}" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{ translate('Email')}}</label>
                                    <input type="text" class="form-control" name="email" placeholder="{{ translate('Email')}}" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{ translate('Address')}}</label>
                                    <input type="text" class="form-control" name="address" placeholder="{{ translate('Address')}}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{{ translate('Select your country')}}</label>
                                            <select class="form-control aiz-selectpicker" data-live-search="true" name="country">
                                                @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            @if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'area_wise_shipping')
                                                <label class="control-label">{{ translate('City')}}</label>
                                                <select class="form-control aiz-selectpicker" data-live-search="true" name="city" required>
                                                    @foreach (\App\City::get() as $key => $city)
                                                        <option value="{{ $city->name }}">{{ $city->getTranslation('name') }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <label class="control-label">{{ translate('City')}}</label>
                                                <input type="text" class="form-control" placeholder="{{ translate('City')}}" name="city" required>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{ translate('Postal code')}}</label>
                                            <input type="text" class="form-control" placeholder="{{ translate('Postal code')}}" name="postal_code" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{ translate('Phone')}}</label>
                                            <input type="number" lang="en" min="0" class="form-control" placeholder="{{ translate('Phone')}}" name="phone" required>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="checkout_type" value="guest">
                            </div>
                        @endif
                    <div class="row align-items-center">
                        <div class="col-xxl-12 col-xl-12 d-flex mt-4">
                            <div class="col-xxl-6 col-xl-6 d-flex justify-content-start pl-0">
                                <a href="{{ route('cart') }}" class="link-back-cart d-flex align-items-center">
                                    <svg class="mr-2" width="19" height="20" viewBox="0 0 19 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.625 9.20833H5.40708L8.24125 6.36625L7.125 5.25L2.375 10L7.125 14.75L8.24125 13.6337L5.40708 10.7917H16.625V9.20833Z"
                                            fill="#62616A" />
                                    </svg>
                                    {{ translate('Back to Cart') }}
                                </a>
                            </div>
                            <div class="col-xxl-6 col-xl-6 d-flex justify-content-end pr-0">
                                <button type="submit" class="btn btn-craft-primary-nopadding fw-600 cart-mobile-ui">
                                    {{ translate('Continue to Payment')}}
                                    <i class="las la-arrow-right m-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
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
                                    <input type="text" class="form-control form-craft {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" name="postal_code" placeholder="Zip Code" value="{{ old('postal_code') }}">
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
    function add_new_address(){
        $('#new-address-modal').modal('show');
    }

    @if (count($errors) > 0)
    $('#new-address-modal').modal('show');
    @endif
</script>
@endsection
