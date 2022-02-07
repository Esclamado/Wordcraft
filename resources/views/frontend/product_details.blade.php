@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency"
        content="{{ \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')
    <div class="breadcrumb-area breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col breadcrumb-subcategory">
                    <ul class="breadcrumb">
                        <li>
                            <a href="{{ route('home') }}">{{ translate('Home') }}</a>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z"
                                    fill="#8D8A8A" />
                            </svg>
                        </li>
                        @if (isset($category_id))
                            <li>
                                <a
                                    href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">{{ translate(\App\Category::find($category_id)->name) }}</a>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z"
                                        fill="#8D8A8A" />
                                </svg>
                            </li>

                            @if ($subcategory_id != 0)
                                <li>
                                    <a class="breadcrumb-subcategory"
                                        href="{{ route('products.subcategory', \App\SubCategory::find($subcategory_id)->slug) }}">{{ translate(\App\SubCategory::find($subcategory_id)->name) }}</a>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z"
                                            fill="#8D8A8A" />
                                    </svg>
                                </li>
                            @endif

                            @if ($subsubcategory_id != 0)
                                <li class="breadcrumb-subcategory">
                                    <a class="breadcrumb-subcategory"
                                        href="{{ route('products.subsubcategory', \App\SubSubCategory::find($subsubcategory_id)->slug) }}">{{ translate(\App\SubSubCategory::find($subsubcategory_id)->name) }}</a>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z"
                                            fill="#8D8A8A" />
                                    </svg>
                                </li>
                            @endif

                        @endif
                        <li class="active">{{ $detailedProduct->getTranslation('name') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="pt-5 pb-3 bg-lightblue">
        <div class="container">
            <div class="position-absolute">
                <div class="img-43"></div>
            </div>

            {{-- // Check if user isn't banned --}}

            @php
                $code = app('request')->input('product_referral_code');
                $user_banned = \App\User::where('referral_code', $code)
                    ->select('name', 'banned')
                    ->first();
            @endphp

            @if ($code != null)
                @if ($user_banned != null && $user_banned->banned == 1)
                    <div class="alert alert-danger">
                        <p class="mb-0"><strong>{{ $user_banned->name }}</strong> is banned! You will not be
                            able to use their referral code anymore.</p>
                    </div>
                @else
                    <div class="alert alert-info">
                        <p class="mb-0">You're using <strong>{{ $user_banned->name }}'s</strong> referral code
                            to order this product.</p>
                    </div>
                @endif
            @endif

            {{-- // Product Basic Details --}}
            <div class="card rounded-0 shadow-none border-0">
                <div class="card-body p-md-4">
                    {{-- // Images --}}
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-4">
                            <div class="sticky-top z-3 row gutters-10">
                                @php
                                    $photos = explode(',', $detailedProduct->photos);
                                @endphp

                                <div class="col order-1 order-md-2">
                                    <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb'
                                        data-fade='true'>
                                        @foreach ($detailedProduct->stocks as $key => $stock)
                                            @if ($stock->image != null)
                                                <div class="carousel-box img-zoom rounded">
                                                    <img class="img-fluid lazyload"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($stock->image) }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </div>
                                            @endif
                                        @endforeach
                                        @foreach ($photos as $key => $photo)
                                            <div class="carousel-box img-zoom rounded">
                                                <img class="img-fluid lazyload"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($photo) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-12 col-md-auto w-md-80px order-2 order-md-1 mt-3 mt-md-0">
                                    <div class="aiz-carousel product-gallery-thumb" data-items='5'
                                        data-nav-for='.product-gallery' data-vertical='true' data-vertical-sm='false'
                                        data-focus-select='true' data-arrows='true'>
                                        @foreach ($detailedProduct->stocks as $key => $stock)
                                            @if ($stock->image != null)
                                                <div class="carousel-box c-pointer border p-1 rounded"
                                                    data-variation="{{ $stock->variant }}">
                                                    <img class="lazyload mw-100 size-50px mx-auto"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($stock->image) }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </div>
                                            @endif
                                        @endforeach
                                        @foreach ($photos as $key => $photo)
                                            <div class="carousel-box c-pointer border p-1 rounded">
                                                <img class="lazyload mw-100 size-50px mx-auto"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($photo) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mb-4">
                            <div class="text-left">
                                <h1 class="product-details-title">
                                    {{ $detailedProduct->getTranslation('name') }}
                                </h1>

                                <div class="row align-items-center mb-md-3">
                                    <div class="col-12 col-lg-6">
                                        @php
                                            $total = 0;
                                            $total += $detailedProduct->reviews->count();
                                        @endphp
                                        <span class="rating">
                                            {{ renderStarRating($detailedProduct->rating) }}
                                        </span>
                                        <span class="product-details-rating">({{ $total }}
                                            {{ translate('reviews') }})</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center">
                                    <div class="product-details-label mr-4">
                                        Price:
                                    </div>
                                    <div class="product-details-price mr-3" id="chosen_price">
                                        <span
                                            id="current-price">{{ home_discounted_base_price($detailedProduct->id) }}</span>
                                    </div>
                                    <div class="product-details-discounted-price" id="discounted_price_val">
                                    </div>
                                </div>

                                <form id="option-choice-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $detailedProduct->id }}">
                                    <input id="pup_loc_id" type="hidden" name="pup_location_id" value="">
                                    @php
                                        $qty = 0;
                                        
                                        if ($detailedProduct->variant_product) {
                                            foreach ($detailedProduct->stocks as $key => $stock) {
                                                $qty += $stock->qty;
                                            }
                                        } else {
                                            $qty = $detailedProduct->current_stock;
                                        }
                                    @endphp

                                    @if ($detailedProduct->choice_options != null)
                                        <hr>
                                        @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                                            <div class="d-flex align-items-center">
                                                <div class="product-details-label mr-4" style="height: 41px;">
                                                    {{ \App\Attribute::find($choice->attribute_id) != null ? \App\Attribute::find($choice->attribute_id)->getTranslation('name') : 'N\A' }}:
                                                </div>
                                                <div>
                                                    <div class="aiz-radio-inline" id="radioButtonContainerId">
                                                        @foreach ($choice->values as $key => $value)
                                                            <label class="aiz-megabox pl-0 mr-2">
                                                                <input type="radio"
                                                                    name="attribute_id_{{ $choice->attribute_id }}"
                                                                    value="{{ $value }}" @if ($key == 0) checked @endif>
                                                                <span
                                                                    class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                                    {{ $value }}
                                                                </span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (count(json_decode($detailedProduct->colors)) > 0)
                                        <hr>
                                        <div class="d-flex align-items-center">
                                            <div class="product-details-label mr-4" style="height: 41px;">
                                                {{ translate('Color') }}:
                                            </div>
                                            <div>
                                                <div class="aiz-radio-inline mt-2" id="radioButtonColorId">
                                                    @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                                        <label class="aiz-megabox mr-2 rounded-0" data-toggle="tooltip"
                                                            data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                                            <input type="radio" name="color" value="{{ $color }}"
                                                                @if ($key == 0) checked @endif>
                                                            <span
                                                                class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1">
                                                                <span class="size-30px d-inline-block rounded"
                                                                    style="background: {{ $color }};"></span>
                                                            </span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <hr>

                                    <div class="d-flex align-items-center">
                                        <div class="mr-2 w-100 w-md-50">
                                            <div class="product-details-label mb-3">
                                                {{ translate('Check stocks per store') }}:
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" id="product_sku"
                                                    value="{{ $detailedProduct->sku != null ? $detailedProduct->sku : '' }}"
                                                    readonly>
                                                <select class="form-control aiz-selectpicker" data-live-search="true"
                                                    id="check-stock">
                                                    <option value="">Select your preferred store</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <div id="available-quantity-stock"
                                                class="product-details-stocks product-details-stocks-success"
                                                style="height: 4px; display: none;">
                                                <span id="available-quantity"></span> {{ translate('in stock') }}
                                            </div>
                                            <div id="out-of-stock"
                                                class="product-details-stocks product-details-stocks-failed"
                                                style="height: 4px; display: none;">
                                                {{ translate('Out of stock!') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="___class_+?63___" id="pickup-address" style="display: none;">
                                        <div class="d-flex align-items-start mb-3 w-100 w-md-50">
                                            <div class="mr-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M12 2C15.31 2 18 4.69 18 8C18 12.5 12 19 12 19C12 19 6 12.5 6 8C6 4.69 8.69 2 12 2ZM19 22V20H5V22H19ZM8 8C8 5.79 9.79 4 12 4C14.21 4 16 5.79 16 8C16 10.13 13.92 13.46 12 15.91C10.08 13.47 8 10.13 8 8ZM10 8C10 6.9 10.9 6 12 6C13.1 6 14 6.9 14 8C14 9.1 13.11 10 12 10C10.9 10 10 9.1 10 8Z"
                                                        fill="#62616A" />
                                                </svg>
                                            </div>
                                            <div class="product-detail-location" id="pickup-point-address">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="notif-success-bg" id="sameDayPickup" style="display: none;">
                                        <span class="___class_+?68___">
                                            <div class="d-flex align-items-start">
                                                <div class="mr-2">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M9 1.5C4.86 1.5 1.5 4.86 1.5 9C1.5 13.14 4.86 16.5 9 16.5C13.14 16.5 16.5 13.14 16.5 9C16.5 4.86 13.14 1.5 9 1.5ZM9 15C5.6925 15 3 12.3075 3 9C3 5.6925 5.6925 3 9 3C12.3075 3 15 5.6925 15 9C15 12.3075 12.3075 15 9 15ZM7.5 10.6275L12.4425 5.685L13.5 6.75L7.5 12.75L4.5 9.75L5.5575 8.6925L7.5 10.6275Z"
                                                            fill="#10865C" />
                                                    </svg>
                                                </div>
                                                <div class="notif-text">
                                                    This item is available for <c class="fw-600">same day pickup</c>
                                                    .
                                                </div>
                                            </div>
                                        </span>
                                    </div>

                                    @if ($detailedProduct->advance_order != 0)
                                    <input id="advance_order_input" type="hidden" name="advance_order" value="1">
                                    <div class="notif-warning-bg" id="advanceOrder" style="display: none;">
                                        <span class="">
                                            <div class="d-flex align-items-start">
                                                <div class="mr-2">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 0.5C3.86 0.5 0.5 3.86 0.5 8C0.5 12.14 3.86 15.5 8 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 8 0.5ZM7.25 4.25V5.75H8.75V4.25H7.25ZM7.25 7.25V11.75H8.75V7.25H7.25ZM2 8C2 11.3075 4.6925 14 8 14C11.3075 14 14 11.3075 14 8C14 4.6925 11.3075 2 8 2C4.6925 2 2 4.6925 2 8Z" fill="#E49F1A"/>
                                                    </svg>
                                                </div>
                                                <div class="notif-text">
                                                    This item is currently <strong class="text-danger">out of stock</strong> in your selected pickup point, however we can transfer some stocks from our other store but this will take at least 3-7 days. Once you add this to cart, this will be marked as an <strong>advanced order</strong>.
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                    @endif

                                    <hr>

                                    <div class="product-details-label mb-3">
                                        {{ translate('Quantity') }}:
                                    </div>

                                    {{-- Quantity + Add to cart --}}
                                    <div class="grid-qnty-cart">
                                        <div>
                                            <div class="product-quantity d-flex align-items-center">
                                                <div
                                                    class="row no-gutters align-items-center aiz-plus-minus mr-3 quantity-style">
                                                    <button class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                        type="button" data-type="minus" data-field="quantity" disabled="">
                                                        <i class="las la-minus"></i>
                                                    </button>
                                                    <input id="product_quantity" type="text" name="quantity"
                                                        class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                                        placeholder="1" value="{{ $detailedProduct->min_qty }}"
                                                        min="{{ $detailedProduct->min_qty }}" max="" readonly>
                                                    <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light"
                                                        type="button" data-type="plus" data-field="quantity">
                                                        <i class="las la-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="no-gutters align-items-center aiz-plus-minus">
                                                {{-- @if ($qty > 0) --}}
                                                <button type="button"
                                                    class="d-md-inline-block btn btn-craft-primary-nopadding add-to-cart fw-600 d-block fs-11"
                                                    id="btnAddToCart" disabled>
                                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17.4167 11.9167H11.9167V17.4167H10.0834V11.9167H4.58337V10.0834H10.0834V4.58337H11.9167V10.0834H17.4167V11.9167Z"
                                                            fill="white" />
                                                    </svg>
                                                    <span class="___class_+?90___"> {{ translate('Add to cart') }}</span>
                                                </button>
                                                {{-- @else
                                                    <button type="button" class="btn btn-secondary fw-600" disabled>
                                                        <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock')}}
                                                    </button>
                                                @endif --}}
                                            </div>
                                        </div>

                                        <div style="align-self: center;">
                                            <button type="button"
                                                class="btn btn-styled btn-icon-left add-to-wishlist fw-600 opacity-80 px-0 ml-lg-2"
                                                onclick="addToWishList({{ $detailedProduct->id }})">
                                                <i class="la la-heart-o" style="font-size: 19px;"></i>
                                                {{ translate('Add to Wishlist') }}
                                            </button>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="d-flex align-items-center">
                                        <div class="product-details-label mr-4">
                                            Share:
                                        </div>
                                        <div>
                                            <div class="aiz-share"></div>
                                        </div>
                                    </div>

                                    @if (Auth::check() && \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && (\App\AffiliateOption::where('type', 'product_sharing')->first()->status || \App\AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)

                                        @php
                                            if (Auth::check()) {
                                                if (Auth::user()->referral_code == null) {
                                                    Auth::user()->referral_code = substr(Auth::user()->id . Str::random(10), 0, 10);
                                                    Auth::user()->save();
                                                }
                                                $referral_code = Auth::user()->referral_code;
                                                $referral_code_url = URL::to('/product') . '/' . $detailedProduct->slug . "?product_referral_code=$referral_code";
                                            }
                                        @endphp

                                        <div class="promotion-link mt-5">
                                            <div class="promotion-logo">
                                                <svg width="69" height="69" viewBox="0 0 69 69" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0)">
                                                        <path
                                                            d="M38.8078 42.2782L35.8555 34.8772C37.8992 34.062 40.2168 35.0578 41.0321 37.1015C41.8474 39.1452 40.8515 41.4629 38.8078 42.2782Z"
                                                            fill="#D71921" />
                                                        <path
                                                            d="M32.9033 27.4763L22.1659 38.1935L14.7649 41.1459C11.6993 42.3688 10.2056 45.8452 11.4285 48.9108C12.6514 51.9764 16.1278 53.4702 19.1934 52.2473L26.5944 49.295L41.7603 49.6791L32.9033 27.4763Z"
                                                            fill="#1B1464" />
                                                        <path
                                                            d="M19.1914 52.2473L24.7421 50.033L27.6944 57.434L22.1437 59.6482L19.1914 52.2473Z"
                                                            fill="#D71921" />
                                                        <path
                                                            d="M17.7168 48.5468L23.2675 46.3325L24.7437 50.033L19.193 52.2473L17.7168 48.5468Z"
                                                            fill="#C1161D" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0">
                                                            <rect width="53" height="53" fill="white"
                                                                transform="translate(0.0664062 19.7048) rotate(-21.7476)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="promotion-header">
                                                        {{ translate('Promote Link') }}
                                                    </div>
                                                    <div class="promotion-body">
                                                        Copy the link of this product then share it to your friends/buyers
                                                        to get commision for every successful purchase.
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="d-flex justify-content-end my-1"
                                                        style="height: 100%;align-items: center;">
                                                        <div class="form-group">
                                                            <textarea id="referral_code_url"
                                                                class="form-control referral-product-details" readonly
                                                                type="text"
                                                                style="opacity: 1; height: 0; position: absolute; z-index: -1;">{{ $referral_code_url }}</textarea>
                                                        </div>
                                                        <button type="button" class="btn btn-craft-primary-nopadding "
                                                            data-attrcpy="{{ translate('Copied') }}"
                                                            onclick="CopyToClipboard('referral_code_url')">
                                                            <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M11.375 0.75H2.375C1.55 0.75 0.875 1.425 0.875 2.25V12.75H2.375V2.25H11.375V0.75ZM13.625 3.75H5.375C4.55 3.75 3.875 4.425 3.875 5.25V15.75C3.875 16.575 4.55 17.25 5.375 17.25H13.625C14.45 17.25 15.125 16.575 15.125 15.75V5.25C15.125 4.425 14.45 3.75 13.625 3.75ZM5.375 15.75H13.625V5.25H5.375V15.75Z"
                                                                    fill="white" />
                                                            </svg>
                                                            {{ translate('Copy Link') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- // Product Details Description --}}
            <div class="card border-0 rounded-0 shadow-none">
                <div class="card-body">
                    <div class="d-flex justify-content-start border-bottom">
                        <div id="description" class="product-details opacity-50 product-details-active"
                            onclick="toggleProduct('description')">
                            Description
                        </div>

                        <div id="reviews" class="product-details opacity-50" onclick="toggleProduct('reviews')">
                            Reviews
                        </div>

                        <div id="document" class="product-details opacity-50" onclick="toggleProduct('document')">
                            Documents
                        </div>

                        <div id="videos" class="product-details opacity-50" onclick="toggleProduct('videos')">
                            Videos
                        </div>
                    </div>

                    <div id="product-description" class="product-details-description py-4">
                        <?php echo $detailedProduct->getTranslation('description'); ?>

                        @if ($detailedProduct->weight != null || $detailedProduct->height != null || $detailedProduct->width != null || $detailedProduct->length != null)
                            <div class="fw-600 product-dimension-label mt-3 key-li">
                                Product Specification
                            </div>
                        @endif

                        @if ($detailedProduct->weight != null)
                            <div>
                                <div>
                                    <span class="fw-600 product-details-label">
                                        Weight:
                                    </span>
                                    <span class="fs-15 product-dimension-label">
                                        {{ $detailedProduct->weight }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if ($detailedProduct->height || $detailedProduct->width || $detailedProduct->length != null)

                            <div class="fw-600 product-dimension-label mt-3 key-li">
                                Dimension
                            </div>

                            <ul">
                                <li class="key-li">
                                    @if ($detailedProduct->height != null)
                                        <div>
                                            <span class="fw-600 product-details-label">
                                                Height:
                                            </span>
                                            <span class="fs-15 product-dimension-label">
                                                {{ $detailedProduct->height }}
                                            </span>
                                        </div>
                                    @endif
                                </li>
                                <li class="key-li">
                                    @if ($detailedProduct->width != null)
                                        <div>
                                            <span class="fw-600 product-details-label">
                                                Width:
                                            </span>
                                            <span class="fs-15 product-dimension-label">
                                                {{ $detailedProduct->width }}
                                            </span>
                                        </div>
                                    @endif
                                </li>
                                <li class="key-li">
                                    @if ($detailedProduct->length != null)
                                        <div>
                                            <span class="fw-600 product-details-label">
                                                Length:
                                            </span>
                                            <span class="fs-15 product-dimension-label">
                                                {{ $detailedProduct->length }}
                                            </span>
                                        </div>
                                    @endif
                                </li>
                                </ul>
                        @endif
                    </div>

                    <div id="product-reviews" class="product-details-description py-4" style="display: none;">
                        <ul class="list-group list-group-flush">
                            @foreach ($detailedProduct->reviews as $key => $review)
                                @if ($review->user != null)
                                    <li class="media list-group-item d-flex">
                                        <span class="avatar avatar-md mr-3">
                                            <img class="lazyload"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                @if ($review->user->avatar_original != null)
                                            data-src="{{ uploaded_asset($review->user->avatar_original) }}"
                                        @else
                                            data-src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                @endif
                                >
                                </span>
                                <div class="media-body text-left d-xl-none">
                                    <div class="d-flex justify-content-between">
                                        <div class="rating-grid">
                                            <div class="rating-name">
                                                <h3 class="fs-15 fw-600 mb-0">{{ $review->user->name }}</h3>
                                            </div>
                                            <div class="rating-star">
                                                <span class="rating rating-sm">
                                                    @for ($i = 0; $i < $review->rating; $i++)
                                                        <i class="las la-star active"></i>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                        <i class="las la-star"></i>
                                                    @endfor
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="opacity-60 mb-2">{{ date('d-m-Y', strtotime($review->created_at)) }}
                                    </div>
                                    <p class="comment-text">
                                        {{ $review->comment }}
                                    </p>
                                </div>

                                <div class="media-body text-left d-none d-lg-block">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="fs-15 fw-600 mb-0">{{ $review->user->name }}</h3>
                                        <span class="rating rating-sm">
                                            @for ($i = 0; $i < $review->rating; $i++)
                                                <i class="las la-star active"></i>
                                            @endfor
                                            @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                <i class="las la-star"></i>
                                            @endfor
                                        </span>
                                    </div>
                                    <div class="opacity-60 mb-2">{{ date('d-m-Y', strtotime($review->created_at)) }}
                                    </div>
                                    <p class="comment-text">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                                </li>
                            @endif
                            @endforeach
                        </ul>

                        @if (count($detailedProduct->reviews) <= 0)
                            <div class="text-center fs-18 opacity-70">
                                {{ translate('There have been no reviews for this product yet.') }}
                            </div>
                        @endif

                        @if (Auth::check())
                            @php
                                $commentable = false;
                            @endphp
                            @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                @if ($orderDetail->order != null &&
        $orderDetail->order->user_id == Auth::user()->id &&
        $orderDetail->delivery_status == 'picked_up' &&
        \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                    @php
                                        $commentable = true;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($commentable)
                                <div class="pt-4">
                                    <div class="border-bottom mb-4">
                                        <h3 class="fs-17 fw-600">
                                            {{ translate('Write a review') }}
                                        </h3>
                                    </div>
                                    <form class="form-default" role="form" action="{{ route('reviews.store') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""
                                                        class="text-uppercase c-gray-light">{{ translate('Your name') }}</label>
                                                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                                                        class="form-control" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""
                                                        class="text-uppercase c-gray-light">{{ translate('Email') }}</label>
                                                    <input type="text" name="email" value="{{ Auth::user()->email }}"
                                                        class="form-control" required disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="opacity-60">{{ translate('Rating') }}</label>
                                            <div class="rating rating-input">
                                                <label>
                                                    <input type="radio" name="rating" value="1">
                                                    <i class="las la-star"></i>
                                                </label>
                                                <label>
                                                    <input type="radio" name="rating" value="2">
                                                    <i class="las la-star"></i>
                                                </label>
                                                <label>
                                                    <input type="radio" name="rating" value="3">
                                                    <i class="las la-star"></i>
                                                </label>
                                                <label>
                                                    <input type="radio" name="rating" value="4">
                                                    <i class="las la-star"></i>
                                                </label>
                                                <label>
                                                    <input type="radio" name="rating" value="5">
                                                    <i class="las la-star"></i>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="opacity-60">{{ translate('Comment') }}</label>
                                            <textarea class="form-control" rows="4" name="comment"
                                                placeholder="{{ translate('Your review') }}" required></textarea>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary mt-3">
                                                {{ translate('Submit review') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div id="document-product-description" class="product-details-description py-4">
                        @if ($detailedProduct->pdf != null)
                            <ul class="dimension-section">
                                <li class="key-li">
                                    <span class="fw-600 product-dimension-label mt-3 key-li">Product Documents</span>
                                    <div>
                                        <a class="fs-15 fw-600 product-dimension-label"
                                            href="{{ uploaded_asset($detailedProduct->pdf) }}"
                                            target="_blank">{{ $detailedProduct->getTranslation('name') }}.pdf</a>
                                    </div>
                                </li>
                            </ul>

                        @else
                            <div class="text-center fs-18 opacity-70">
                                {{ translate('There have been no product document for this product.') }}
                            </div>
                        @endif
                    </div>

                    <div id="video-product-description" class="product-details-description py-4">
                        @if ($detailedProduct->video_link != null)
                            <div class="embed-responsive embed-responsive-16by9">
                                @if ($detailedProduct->video_provider == 'youtube' && isset(explode('=', $detailedProduct->video_link)[1]))
                                    <iframe class="embed-responsive-item"
                                        src="https://www.youtube.com/embed/{{ explode('=', $detailedProduct->video_link)[1] }}"></iframe>
                                @elseif ($detailedProduct->video_provider == 'dailymotion' && isset(explode('video/',
                                    $detailedProduct->video_link)[1]))
                                    <iframe class="embed-responsive-item"
                                        src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                                @elseif ($detailedProduct->video_provider == 'vimeo' && isset(explode('vimeo.com/',
                                    $detailedProduct->video_link)[1]))
                                    <iframe
                                        src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}"
                                        width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen
                                        allowfullscreen></iframe>
                                @endif
                            @else
                                <div class="text-center fs-18 opacity-70">
                                    {{ translate('There have been no video for this product.') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="might-like">
        <div class="position-absolute">
            <div class="might-like-img-1"></div>
        </div>
        <div class="container">
            <div class="might-like-title">
                You might also like
            </div>
            <div class="pt-5">
                <div class="row gutters-6 row-cols-xxl-5 row-cols-xl-4 row-cols-lg-4 row-cols-md-4 row-cols-2">
                    @foreach (filter_products(\App\Product::where('category_id', $detailedProduct->category_id)->where('id', '!=', $detailedProduct->id))->limit(4)->get()
        as $key => $product)
                        <div class="col col-sm-6 mb-4">
                            <div class="aiz-card-box border-product shadow-sm hov-shadowmd has-transition bg-white mx-1">
                                <div class="position-relative">
                                    <div class="d-block">
                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                            <img class="img-fit lazyload mx-auto h-160px h-md-180px h-xl-220px h-xxl-200px p-3"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </a>
                                    </div>
                                    <div class="absolute-top-right aiz-p-hov-icon">
                                        <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})"
                                            data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}"
                                            data-placement="left">
                                            <i class="la la-heart-o"></i>
                                        </a>
                                        <a href="{{ route('product', $product->slug) }}" data-toggle="tooltip"
                                            data-title="{{ translate('Add to cart') }}" data-placement="left">
                                            <i class="las la-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="p-md-3 p-2 text-left">
                                    <div class="fs-15">
                                        @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                                            <del
                                                class="fw-600 opacity-50 mr-1 text-title-thin">{{ home_base_price($product->id) }}</del>
                                        @endif
                                        <span
                                            class="fw-700 text-title-thin text-primary-blue">{{ home_discounted_base_price($product->id) }}</span>
                                    </div>
                                    <div class="rating rating-sm mt-1">
                                        {{ renderStarRating($product->rating) }}
                                    </div>
                                    <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                        <a href="{{ route('product', $product->slug) }}"
                                            class="d-block product-card-title">{{ $product->getTranslation('name') }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="___class_+?219___" action="{{ route('conversations.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title"
                                value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required
                                placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <input type="text"
                                        class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone') }}"
                                        name="email" id="email">
                                @else
                                    <input type="email"
                                        class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" placeholder="{{ translate('Email') }}"
                                        name="email">
                                @endif
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <span
                                        class="opacity-60">{{ translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg"
                                    placeholder="{{ translate('Password') }}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}"
                                        class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit"
                                    class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                        </div>
                        @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                            class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                            class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                            class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var productStock = 0;
        var locationProductStock = 0;
        var handlingFee = [];
        var hasColorVariant = false;


        $(document).ready(function() {
            getVariantPrice();

            $('#pickup-address').hide();
            $('#sameDayPickup').hide();
            $('#advanceOrder').hide();
            $('#available-quantity-stock').hide();
            $('#product-reviews').toggle(false);
            $('#document-product-description').toggle(false);
            $('#video-product-description').toggle(false);

            var variantSelected = "";

            @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                if ({{ $key }} > 0) {
                variantSelected += '-';
                }
                @foreach ($choice->values as $key => $value)
                    if ({{ $key }} == 0) {
                    variantSelected += '{{ $value }}';
                    }
                @endforeach
            @endforeach

            @foreach (json_decode($detailedProduct->colors) as $key => $color)
                hasColorVariant = true;
                if ({{ $key }} == 0) {
                variantSelected = "{{ \App\Color::where('code', $color)->first()->name }}-"+variantSelected;
                }
            @endforeach

            var detailedId = {{ $detailedProduct->id }};

            if (($('#product_sku').val()) == "") {
                getSku(variantSelected, detailedId)
            } else {
                getStock();
            }

            $('#option-choice-form #radioButtonContainerId input:radio').click(function() {
                // getSku(variantSelected,detailedId);
                $('#btnAddToCart').prop('disabled', true);
                $('#sameDayPickup').hide();
                $('#advanceOrder').hide();
                $('#out-of-stock').hide();
                $('#pickup-address').hide();
                $('#available-quantity-stock').hide();
                $('#check-stock').val('Select your preferred store');

                var key = null;

                @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                    @foreach ($choice->values as $keyChoice => $value)
                        if($(this).val() == '{{ $value }}'){
                        key = {{ $key }};
                        }
                    @endforeach
                @endforeach

                if (hasColorVariant) {
                    key += 1;
                }

                var arraySelected = variantSelected.split('-');

                arraySelected[key] = $(this).val();
                variantSelected = "";

                var sum = 0;

                arraySelected.forEach(element => {
                    if (sum > 0) {
                        variantSelected += '-';
                    }
                    variantSelected += element;
                    sum++;
                });

                getSku(variantSelected, detailedId);
            });

            $('#option-choice-form #radioButtonColorId input:radio').click(function() {
                // getSku(variantSelected,detailedId);
                $('#btnAddToCart').prop('disabled', true);
                $('#sameDayPickup').hide();
                $('#advanceOrder').hide();
                $('#pickup-address').hide();
                $('#out-of-stock').hide();
                $('#available-quantity-stock').hide();
                $('#check-stock').val('Select your preferred store');

                var key = 0;
                var colorName = null;

                @foreach (json_decode($detailedProduct->colors) as $key => $color)
                    if($(this).val() == '{{ $color }}'){
                    colorName = '{{ \App\Color::where('code', $color)->first()->name }}';
                    }
                @endforeach

                var arraySelected = variantSelected.split('-');
                arraySelected[key] = colorName;
                variantSelected = "";

                var sum = 0;
                arraySelected.forEach(element => {
                    if (sum > 0) {
                        variantSelected += '-';
                    }
                    variantSelected += element;
                    sum++;
                });
                getSku(variantSelected, detailedId);
            });

            $('#check-stock').on('change', function() {
                if ($('#check-stock').val() != "") {
                    $('#btnAddToCart').prop('disabled', true);
                    $('#available-quantity-stock').hide();
                    $('#available-quantity').html('');
                    $('#sameDayPickup').hide();
                    $('#out-of-stock').hide();
                    $('#pickup-address').hide();
                    $('#advanceOrder').hide();

                    var check_stocks = productStock.find(x => x.name.toLowerCase().replace(' ', '_') == ($('#check-stock').val().toLowerCase().replace(' ', '_')) ?? null)
                    var stock_data = check_stocks != null ? productStock.find(x => x.name.toLowerCase().replace(' ', '_') == ($('#check-stock').val().toLowerCase().replace(' ', '_'))).stock : null;
                    var stock = productStock.find(x => x.name.toLowerCase().replace(' ', '_') == ($('#check-stock').val().toLowerCase().replace(' ', '_'))) ? stock_data : null;

                    if (check_stocks != null) {
                        $('#pickup-address').show();
                        $('#pickup-point-address').text(productStock.find(x => x.name.toLowerCase().replace(' ', '_') == ($('#check-stock').val().toLowerCase().replace(' ', '_'))).address);
                    }

                    console.log(check_stocks);

                    if (stock != null) {
                        $('#btnAddToCart').prop('disabled', false);
                        $('#available-quantity-stock').show();
                        $('#available-quantity').html(stock);

                        locationProductStock = stock;

                        $('#available-quantity').text(stock.quantity)

                        @if ($detailedProduct->advance_order == 0) 
                            $('#product_quantity').attr('max', stock.quantity);
                        @else
                            if (stock.quantity == 0) {
                                $('#product_quantity').attr('max', 10);
                            }

                            else {
                                $('#product_quantity').attr('max', stock.quantity);
                            }
                        @endif

                        if (stock.quantity == 0) {
                            // Advance Order
                            @if ($detailedProduct->advance_order != 0)
                                $('#sameDayPickup').hide();
                                $('#advanceOrder').show();
                                $('#out-of-stock').show();
                                $('#available-quantity-stock').hide();
                            @else
                                $('#btnAddToCart').prop('disabled', true);
                                $('#sameDayPickup').hide();
                                $('#advanceOrder').hide();
                                $('#out-of-stock').hide();
                                $('#available-quantity-stock').hide();
                            @endif

                        } else {
                            $('#sameDayPickup').show();
                            $('#advanceOrder').hide();
                            $('#out-of-stock').hide();
                        }
                    } else {
                        $('#btnAddToCart').prop('disabled', true);
                        $('#available-quantity-stock').hide();
                        $('#available-quantity').html('');
                        $('#sameDayPickup').hide();
                        $('#out-of-stock').show();
                        $('#pickup-address').hide();
                        $('#advanceOrder').hide();
                    }
                } else {
                    $('#btnAddToCart').prop('disabled', true);
                    $('#available-quantity-stock').hide();
                    $('#available-quantity').html('');
                    $('#sameDayPickup').hide();
                    $('#out-of-stock').hide();
                    $('#pickup-address').hide();

                    AIZ.plugins.notify('warning', 'Please select your preferred store');
                }
            });
        });

        function getStock() {
            var data = {
                "_token": "{{ csrf_token() }}",
                'sku': $('#product_sku').val(),
                'product_id': {{ $detailedProduct->id }}
            };

            $.ajax({
                type: "POST",
                url: '{{ route('products.get.stock') }}',
                data: data,
                success: function(data) {
                    productStock = data.list;
                    handlingFee = productStock;
                    // $("#check-stock").append(new Option('Select your preferred store'));
                    var output = [];
                    output.push('<option value="">' + 'Select your preferred store' + '</option>');
                    productStock.forEach(function(item) {
                        $('#check-stock option').each(function() {
                            if ($(this).val() == item.name) {
                                $(this).remove();
                            }
                            if ($(this).val() == 'Loading...') {
                                $(this).remove();
                            }
                        });

                        if (item.stock != null) {
                            var item_stock_quantity = Math.max(0, item.stock.quantity) != 0 ? Math.max(0, item.stock.quantity) :
                                'No Stock';

                            @if ($detailedProduct->advance_order != 0)
                                output.push('<option value="'+ item.name.toLowerCase().replace(' ', '_') +'">' + item.name + ' - ' +
                                    item_stock_quantity + '</option>');
                            @else
                                if (Math.max(0, item.stock.quantity) != 0) {
                                output.push('<option value="'+ item.name.toLowerCase().replace(' ', '_') +'">' + item.name + ' - ' +
                                    item_stock_quantity + '</option>');
                                }
                            @endif
                        } else {
                            @if ($detailedProduct->advance_order != 0)
                                output.push('<option value="'+ item.name +'">' + item.name + ' - ' + 'No Stock' + '</option>');
                            @else
                                // Do Nothing
                            @endif
                        }
                    });
                    $('#check-stock').html(output.join(''));
                }
            });
        }

        function CopyToClipboard(containerid) {
            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select().createTextRange();
                document.execCommand("Copy");
            } else if (window.getSelection) {
                var range = document.createRange();
                range.selectNode(document.getElementById(containerid));
                window.getSelection().addRange(range);
                document.execCommand("Copy");
            }
            AIZ.plugins.notify('success', 'Referral Link Copied');
        }

        function show_chat_modal() {
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        function toggleProduct(id) {
            if (id == 'reviews') {
                $('#description').removeClass('product-details-active');
                $('#videos').removeClass('product-details-active');
                $('#document').removeClass('product-details-active');
                $('#reviews').addClass('product-details-active');

                $('#product-description').toggle(false)
                $('#document-product-description').toggle(false)
                $('#video-product-description').toggle(false)
                $('#product-reviews').toggle(true)
            } else if (id == 'description') {
                $('#videos').removeClass('product-details-active');
                $('#document').removeClass('product-details-active');
                $('#reviews').removeClass('product-details-active');
                $('#description').addClass('product-details-active');

                $('#product-description').toggle(true)
                $('#product-reviews').toggle(false)
                $('#document-product-description').toggle(false)
                $('#video-product-description').toggle(false)
            } else if (id == 'document') {
                $('#videos').removeClass('product-details-active');
                $('#document').addClass('product-details-active');
                $('#reviews').removeClass('product-details-active');
                $('#description').removeClass('product-details-active');

                $('#product-description').toggle(false)
                $('#product-reviews').toggle(false)
                $('#document-product-description').toggle(true)
                $('#video-product-description').toggle(false)
            } else if (id == 'videos') {
                $('#videos').addClass('product-details-active');
                $('#document').removeClass('product-details-active');
                $('#reviews').removeClass('product-details-active');
                $('#description').removeClass('product-details-active');

                $('#product-description').toggle(false)
                $('#product-reviews').toggle(false)
                $('#document-product-description').toggle(false)
                $('#video-product-description').toggle(true)
            }
        }

        $('#btnAddToCart').click(function() {
            addToCart(locationProductStock, handlingFee);
        });
    </script>
@endsection
