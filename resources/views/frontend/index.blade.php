@extends('frontend.layouts.app')

@section('content')
    {{-- Categories , Sliders . Today's deal --}}
  <div class="bg-light">
    <div class="home-banner-area my-lg-4 pt-3 pb-lg-5">
        <div class="container">
            <div class="row gutters-10 position-relative">
                @php
                    $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 ))->get());
                    $featured_categories = \App\Category::where('featured', 1)->get();
                @endphp

                <div class="col-12">
                    @if (get_setting('home_slider_images') != null)
                        @php $slider_images = json_decode(get_setting('home_slider_images'), true); @endphp
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($slider_images as $key => $value)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" @if ($key == 0) class="active" @endif></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($slider_images as $key => $value)
                                    <div class="carousel-item @if ($key == 0) active @endif">
                                        <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                            <img
                                                class="d-block mw-100 lazyload img-fit"
                                                src="{{ static_asset('uploads/sliders/Frame1304.png') }}"
                                                data-src="{{ uploaded_asset($slider_images[$key]) }}"
                                                alt="{{ env('APP_NAME')}} promo"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                            >
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- about worldcraft section --}}
    <section class="my-lg-5 my-4 mx-2">
       <div class="container">
            <div class="grid-about-worldcraft">
                <div class="about-worldcraft-title">
                    <p class="text-paragraph-bold text-primary-red mb-3" style="letter-spacing: 5.5px;">ABOUT WORLDCRAFT</p>
                    <p class="text-header-title text-header-blue">Furniture that save space and time</p>
                </div>
                <div class="about-worldcraft-subtitle">
                    <p class="text-paragraph-title">Competitive not just in quality but also in price.</p>
                </div>
            </div>
       </div>
    </section>

    <section class="my-lg-5">
        <div class="container">
            <div class="position-absolute">
                <div class="img-33"></div>
                <div class="img-34"></div>
            </div>
            <div>
                <div class="d-flex flex-wrap mb-3 mx-3">
                    <h3 class="h5 fw-700 mb-0">
                        <span class="d-inline-block primary-title-bold text-header-blue">{{ translate('Categories') }}</span>
                    </h3>
                </div>
                <div class="desktop-content categories aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="6" data-lg-items="5"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                    @foreach ($featured_categories as $key => $category)
                        @if ($category != null)
                            <div class="carousel-box">
                                <div class="aiz-card-box hov-shadow-md my-2 has-transition">
                                    <div class="position-relative">
                                        <a href="{{ route('products.category', $category->slug) }}" class="d-block">
                                            <img class="img-fit lazyload mx-auto h-140px h-md-210px" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($category->banner) }}" alt="{{ $category->getTranslation('name') }}" class="lazyload img-fit" height="160" width="160" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                        </a>
                                    </div>
                                    <div class="p-md-3 p-2 text-center">
                                        <div class="text-truncate fs-12 fw-600 mt-2 text-title-thin text-elipsis">{{ $category->getTranslation('name') }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mobile-content container sm-px-0 my-5">
                    @if ($category != null)
                            <div class="row gutters-5 row-cols-xxl-5 row-cols-xl-5 row-cols-lg-5 row-cols-md-4 row-cols-2">
                                @foreach ($featured_categories as $key => $category)
                                    <div class="col col-sm-6 mb-3">
                                        <div class="aiz-card-box h-100 has-transition bg-white mx-1">
                                            <div class="d-block">
                                                <a href="{{ route('products.category', $category->slug) }}" class="d-block">
                                                    <img class="img-fit lazyload mx-auto h-140px h-md-210px" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($category->banner) }}"
                                                    alt="{{ $category->getTranslation('name') }}" class="lazyload img-fit" height="160" width="160" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                </a>
                                            </div>

                                            <div class="p-md-3 p-2 text-left">
                                                <div class="text-truncate fs-12 fw-600 mt-2 text-title-thin text-elipsis">{{ $category->getTranslation('name') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Flash Deal --}}
    @php
        $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
    @endphp

    @if($flash_deal != null && strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)

    <section class="mb-lg-4">
        <div class="flash-deal py-lg-5 py-3">
            <div class="container">
                <div class="position-absolute">
                    <div class="img-25"></div>
                    <div class="img-26"></div>
                </div>
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                        <div class="d-flex flex-wrap mb-3 align-items-baseline border-bottom">
                            <h3 class="h5 fw-700 mb-0">
                                <span class="pb-3 d-inline-block primary-title-bold text-header-blue">{{ translate('Flash Sale') }}</span>
                            </h3>
                            <div class="aiz-count-down ml-auto ml-lg-3 align-items-center primary-blue-bg" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                            {{-- <a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md w-100 w-md-auto">{{ translate('View More') }}</a> --}}
                        </div>
                        <div class="desktop-content">
                            <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                                @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                                    @php
                                        $product = \App\Product::find($flash_deal_product->product_id);
                                    @endphp
                                    @if ($product != null && $product->published != 0)
                                        <div class="carousel-box">
                                            <div class="aiz-card-box border-product hov-shadow-md my-2 has-transition">
                                                    <div class="position-relative">
                                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                            <img class="img-fit lazyload mx-auto h-140px h-md-210px" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{  $product->getTranslation('name')  }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                        </a>

                                                        <div class="absolute-top-right aiz-p-hov-icon">
                                                            <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                                                <i class="la la-heart-o"></i>
                                                            </a>
                                                            <a href="{{ route('product', $product->slug) }}" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                                <i class="las la-shopping-cart"></i>
                                                            </a>
                                                        </div>

                                                    </div>
                                                    <div class="p-md-3 p-2 text-left">
                                                        <div class="fs-15">
                                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                                <del class="fw-600  mr-1" style="color:#CE141C; font-size:12px">{{ home_base_price($product->id) }}</del>
                                                            @endif
                                                            <span class="fw-700 text-title-thin text-primary-blue">{{ home_discounted_base_price($product->id) }}</span>
                                                        </div>
                                                       @if($product->rating != null)
                                                            <div class="rating rating-sm mt-1">
                                                                {{ renderStarRating($product->rating) }}
                                                            </div>
                                                       @endif
                                                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                            <a href="{{ route('product', $product->slug) }}" class="d-block text-reset text-paragraph-thin text-elipsis">{{  $product->getTranslation('name')  }}</a>
                                                        </h3>
                                                    </div>
                                            
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="container mobile-content">
                            <div class="row gutters-5 row-cols-xxl-5 row-cols-xl-5 row-cols-lg-5 row-cols-md-4 row-cols-2">
                                @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                                    @php
                                        $product = \App\Product::find($flash_deal_product->product_id);
                                    @endphp
                                    @if ($product != null && $product->published != 0)
                                        <div class="col col-sm-6 mb-3">
                                            <a class="" href="{{ route('product', $product->slug) }}">
                                                <div class="aiz-card-box h-100 border-product shadow-sm hov-shadowmd has-transition bg-white mx-1">
                                                    <div class="position-relative">
                                                        <div class="d-block">
                                                            <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                                <img class="img-fit lazyload mx-auto h-140px h-md-210px" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{  $product->getTranslation('name')  }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                            </a>
                                                        </div>
                                                        <div class="absolute-top-right aiz-p-hov-icon">
                                                            <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                                                <i class="la la-heart-o"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                                <i class="las la-shopping-cart"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="p-md-3 p-2 text-left">
                                                        <div class="fs-15">
                                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                                <del class="fw-600  mr-1" style="color:#CE141C; font-size:12px">{{ home_base_price($product->id) }}</del>
                                                            @endif
                                                            <span class="fw-700 text-title-thin text-primary-blue">{{ home_discounted_base_price($product->id) }}</span>
                                                        </div>
                                                        
                                                        @if($product->rating != null)
                                                            <div class="rating rating-sm mt-1">
                                                                {{ renderStarRating($product->rating) }}
                                                            </div>
                                                        @endif
                                                        
                                                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                            <a href="{{ route('product', $product->slug) }}" class="d-block text-reset text-paragraph-thin text-elipsis">{{  $product->getTranslation('name')  }}</a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
    @endif

    <section>
        <div class="container">
            <div class="row">

        </div>
    </section>

    {{-- Banner Section 2 --}}
    <section class="my-lg-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md mx-auto">
                    @if (get_setting('home_banner1_images') != null)
                        <div class="mb-4">
                            <div class="container">
                                <div class="row">
                                    @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                                    @foreach ($banner_1_imags as $key => $value)
                                        <div class="col-xl col-lg-6 p-0">
                                            <div class="mb-3 mb-lg-0">
                                                <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}" class="d-block text-reset box-hover">
                                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_1_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-xl-6 col-lg-6 col-md mx-auto">
                    @if (get_setting('home_banner2_images') != null)
                        <div class="mb-4">
                            <div class="container">
                                <div class="row">
                                    @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                                    @foreach ($banner_2_imags as $key => $value)
                                        <div class="col-xl col-lg-6 p-0">
                                            <div class="mb-3 mb-lg-0">
                                                <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}" class="d-block text-reset box-hover">
                                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_2_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </section>

    @php
        $products = \App\Product::where('featured', 1)
            ->where('published', 1)
            ->get();
    @endphp

    <section>
        <div class="container sm-px-0">
            <div class="position-absolute">
                <div class="img-21"></div>
            </div>
            <form class="" id="search-form" action="" method="GET">
                <h1 class="text-header-title text-header-blue text-center">Featured Products</h1>
                <p class="text-center text-title-thin px-5 mb-lg-5">Our most popular furniture chosen by our<br class="desktop-content"> 10,000+ happy customers.</p>

                @if (count($products) != null)
                    <div class="row gutters-6 row-cols-xxl-5 row-cols-xl-4 row-cols-lg-4 row-cols-md-4 row-cols-2">
                        @foreach ($products as $product)
                            <div class="col col-sm-6 mb-4">
                                    <div class="aiz-card-box h-100 border-product shadow-sm hov-shadowmd has-transition bg-white mx-1 box-hover">
                                        <div class="position-relative">
                                            <div class="d-block">
                                                <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                    <img class="img-fit lazyload mx-auto h-160px h-md-180px h-xl-220px h-xxl-200px p-3" src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                    alt="{{  $product->getTranslation('name')  }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </a>
                                            </div>
                                            <div class="absolute-top-right aiz-p-hov-icon">
                                                <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                                    <i class="la la-heart-o"></i>
                                                </a>
                                                <a href="{{ route('product', $product->slug) }}" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                    <i class="las la-shopping-cart"></i>
                                                </a>

                                            </div>
                                        </div>
                                       
                                            <div class="p-md-3 p-2 text-left">
                                                <a class="" href="{{ route('product', $product->slug) }}">
                                                    <div class="fs-15">
                                                        {{-- @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                            <del class="fw-600 opacity-50 mr-1 text-title-thin">{{ home_base_price($product->id) }}</del>
                                                        @endif --}}
                                                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                            <del class="fw-600  mr-1" style="color:#CE141C; font-size:12px">{{ home_base_price($product->id) }}</del>
                                                        @endif
                                                        <span class="fw-700 text-title-thin text-primary-blue">{{ home_discounted_base_price($product->id) }}</span>
                                                    </div>
                                                    @if($product->rating != null)
                                                        <div class="rating rating-sm mt-1">
                                                            {{ renderStarRating($product->rating) }}
                                                        </div>
                                                    @endif
                                                    <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                                        <a href="{{ route('product', $product->slug) }}" class="d-block text-reset text-paragraph-thin">{{ $product->getTranslation('name') }}</a>
                                                    </h3>
                                                </a>
                                            </div>
                                    </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </form>
        </div>
    </section>

    <section class="reseller-bg mt-lg-5 pb-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 p-lg-0">
                    <div class="reseller-title pt-5">
                        <h1 class="text-header-title text-header-blue pt-5">How to become a reseller</h1>
                        <p class="text-title-thin">Anyone can be our reseller. Get started with just 3 steps.</p>
                    </div>

                    <div class="position-absolute">
                        <div class="img-19">
                        </div>
                    </div>

                    <div class="row pt-5">
                        <div class="col-2">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                <path d="M31.6231 44C30.2028 44 28.7945 43.7489 27.4174 43.2486C21.3507 41.0447 15.7194 37.4553 11.1323 32.8682C6.5451 28.2811 2.95563 22.6498 0.751858 16.583C0.0436756 14.6334 -0.165316 12.6208 0.130899 10.601C0.408379 8.70906 1.14122 6.8724 2.25029 5.28949C3.36425 3.69963 4.84936 2.37728 6.54501 1.46543C8.35323 0.493089 10.3269 0 12.4113 0C13.0596 0 13.6199 0.452958 13.7557 1.08681L15.9139 11.1582C16.0116 11.6142 15.8714 12.0888 15.5417 12.4186L11.854 16.1062C15.3328 23.0227 20.9776 28.6675 27.8941 32.1463L31.5817 28.4586C31.9114 28.1289 32.3861 27.9889 32.8421 28.0864L42.9135 30.2445C43.5474 30.3804 44.0003 30.9407 44.0003 31.589C44.0003 33.6734 43.5072 35.6471 42.5348 37.4554C41.6229 39.151 40.3006 40.6361 38.7107 41.7501C37.1279 42.8591 35.2912 43.592 33.3992 43.8695C32.8064 43.9565 32.2136 43.9999 31.6231 44ZM11.3127 2.81004C8.56326 3.11356 6.1229 4.55467 4.50236 6.86759C2.68004 9.46838 2.2551 12.6673 3.33649 15.6442C7.57338 27.3077 16.6928 36.4271 28.3563 40.664C31.3331 41.7453 34.5321 41.3205 37.1329 39.4981C39.4458 37.8775 40.8869 35.4372 41.1904 32.6877L32.9974 30.9321L29.1462 34.7833C28.7363 35.1931 28.1137 35.302 27.5893 35.0556C19.4092 31.2126 12.7879 24.5912 8.94489 16.4112C8.69852 15.8867 8.80731 15.264 9.21713 14.8543L13.0683 11.0031L11.3127 2.81004Z" fill="#0C0736"/>
                                <path d="M42.6248 23.374C41.8655 23.374 41.2499 22.7584 41.2499 21.9991C41.2499 11.385 32.6147 2.74989 22.0007 2.74989C21.2414 2.74989 20.6257 2.13426 20.6257 1.37494C20.6257 0.615631 21.2414 0 22.0007 0C27.8769 0 33.4014 2.28825 37.5564 6.44333C41.7115 10.5984 43.9998 16.1228 43.9998 21.9991C43.9998 22.7584 43.3842 23.374 42.6248 23.374Z" fill="#D71921"/>
                                <path d="M37.1251 23.374C36.3657 23.374 35.7501 22.7584 35.7501 21.9991C35.7501 14.4176 29.5821 8.24965 22.0007 8.24965C21.2414 8.24965 20.6257 7.63401 20.6257 6.8747C20.6257 6.11539 21.2414 5.49976 22.0007 5.49976C31.0984 5.49976 38.5 12.9013 38.5 21.9991C38.5 22.7584 37.8845 23.374 37.1251 23.374Z" fill="#D71921"/>
                                <path d="M31.6253 23.3743C30.866 23.3743 30.2503 22.7586 30.2503 21.9993C30.2503 17.4504 26.5496 13.7496 22.0007 13.7496C21.2414 13.7496 20.6257 13.134 20.6257 12.3747C20.6257 11.6154 21.2414 10.9998 22.0007 10.9998C28.0659 10.9998 33.0002 15.9341 33.0002 21.9993C33.0002 22.7586 32.3847 23.3743 31.6253 23.3743Z" fill="#D71921"/>
                                </g>
                                <defs>
                                <clipPath id="clip0">
                                <rect width="44" height="44" fill="white"/>
                                </clipPath>
                                </defs>
                                </svg>
                        </div>

                        <div class="col-8">
                            <p class="opacity-60 fw-600 text-breadcrumb" style="letter-spacing: 3px;">STEP 1</p>
                            <p class="text-paragraph-title">Fill out and submit the reseller’s <a href="{{ route('reseller.index', '1') }}" class="text-header-blue fw-600 text-link-hover">application form</a></p>
                        </div>
                    </div>

                    <div class="row pt-5">
                        <div class="col-2">
                            <svg width="47" height="43" viewBox="0 0 47 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.5438 32.0562C16.7692 30.8704 17.5332 29.2108 17.5332 27.375C17.5332 23.7812 14.6094 20.8574 11.0156 20.8574C7.42187 20.8574 4.49805 23.7812 4.49805 27.375C4.49805 29.2049 5.25712 30.8599 6.47563 32.0449C2.66009 33.6478 0 37.206 0 41.3281C0 42.0886 0.616508 42.7051 1.37695 42.7051C2.1374 42.7051 2.75391 42.0886 2.75391 41.3281C2.75391 37.2282 6.46011 33.8926 11.0156 33.8926C15.5206 33.8926 19.1855 37.2282 19.1855 41.3281C19.1855 42.0886 19.8021 42.7051 20.5625 42.7051C21.3229 42.7051 21.9395 42.0886 21.9395 41.3281C21.9395 37.2154 19.3136 33.6644 15.5438 32.0562ZM7.25195 27.375C7.25195 25.2997 8.94037 23.6113 11.0156 23.6113C13.0909 23.6113 14.7793 25.2997 14.7793 27.375C14.7793 29.4503 13.0909 31.1387 11.0156 31.1387C8.94037 31.1387 7.25195 29.4503 7.25195 27.375Z" fill="#0C0736"/>
                                <path d="M25.0605 20.7656C25.0605 21.5261 25.6771 22.1426 26.4375 22.1426C27.1979 22.1426 27.8145 21.5261 27.8145 20.7656C27.8145 16.6657 31.4794 13.3301 35.9844 13.3301C40.5399 13.3301 44.2461 16.6657 44.2461 20.7656C44.2461 21.5261 44.8626 22.1426 45.623 22.1426C46.3835 22.1426 47 21.5261 47 20.7656C47 16.6435 44.3399 13.0853 40.5244 11.4824C41.7429 10.2974 42.502 8.64238 42.502 6.8125C42.502 3.21874 39.5781 0.294922 35.9844 0.294922C32.3906 0.294922 29.4668 3.21874 29.4668 6.8125C29.4668 8.64825 30.2308 10.3079 31.4562 11.4937C27.6864 13.1019 25.0605 16.6529 25.0605 20.7656ZM32.2207 6.8125C32.2207 4.73725 33.9091 3.04883 35.9844 3.04883C38.0596 3.04883 39.748 4.73725 39.748 6.8125C39.748 8.88775 38.0596 10.5762 35.9844 10.5762C33.9091 10.5762 32.2207 8.88775 32.2207 6.8125Z" fill="#0C0736"/>
                                <path d="M5.7832 17.7362H19.1855C20.7041 17.7362 21.9395 16.5008 21.9395 14.9823V11.953C22.057 11.8346 22.9369 10.849 25.4339 8.01025C27.238 6.20617 26.3461 3.66596 24.0833 3.25453C23.7991 3.20266 25.0236 3.23231 5.7832 3.23231C4.2647 3.23231 3.0293 4.46772 3.0293 5.98622V14.9823C3.0293 16.5008 4.2647 17.7362 5.7832 17.7362ZM5.7832 5.98622C16.4964 5.98622 22.0301 5.98815 23.562 5.98815C23.3899 6.16265 22.4196 7.18389 20.0593 9.84389C19.4952 10.4279 19.1855 11.1676 19.1855 11.953V14.9823H5.7832V5.98622Z" fill="#D71921"/>
                                <path d="M33.0166 31.3708C32.3839 31.7982 32.2151 32.6412 32.6366 33.2803C33.033 33.8834 33.8818 34.0983 34.5459 33.6603C35.1759 33.2352 35.3495 32.3932 34.926 31.7509C34.5059 31.1269 33.6661 30.944 33.0166 31.3708Z" fill="#D71921"/>
                                <path d="M38.3061 32.7846C38.5572 33.9956 40.1361 34.2922 40.8011 33.2803C41.4647 32.2742 40.6188 30.9351 39.3875 31.1653C38.6418 31.3202 38.1636 32.0241 38.3061 32.7846Z" fill="#D71921"/>
                                <path d="M47.0001 37.0136V28.0176C47.0001 26.4991 45.7647 25.2637 44.2462 25.2637C21.5891 25.2637 23.1816 25.2375 22.9168 25.2859C20.654 25.6973 19.7621 28.2374 21.5662 30.0416C24.0632 32.8803 24.943 33.8659 25.0606 33.9843V37.0136C25.0606 38.5321 26.296 39.7675 27.8145 39.7675H44.2462C45.7647 39.7675 47.0001 38.5321 47.0001 37.0136ZM44.2462 37.0136H27.8145V33.9843C27.8145 33.1989 27.5048 32.4592 26.9408 31.8752C24.5804 29.2152 23.6102 28.194 23.4381 28.0195C24.9698 28.0195 33.533 28.0176 44.2462 28.0176V37.0136Z" fill="#D71921"/>
                                </svg>
                        </div>

                        <div class="col-8">
                            <p class="opacity-60 fw-600 text-breadcrumb" style="letter-spacing: 3px;">STEP 2</p>
                            <p class="text-paragraph-title">Wait for our notification once your application has been approved.</p>
                        </div>
                    </div>

                    <div class="row pt-5">
                        <div class="col-2">
                            <svg width="47" height="47" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                <path d="M18.6853 31.6705L25.1763 12.1973C25.4167 11.4759 25.0269 10.696 24.3054 10.4555C23.5841 10.2151 22.8042 10.605 22.5637 11.3264L16.0727 30.7996C15.8323 31.521 16.2222 32.3008 16.9436 32.5413C17.088 32.5894 17.2349 32.6123 17.3792 32.6123C17.9557 32.6124 18.4929 32.2475 18.6853 31.6705Z" fill="#D71921"/>
                                <path d="M28.4141 25.6296C30.6918 25.6296 32.5449 23.7765 32.5449 21.4988C32.5449 19.221 30.6918 17.3679 28.4141 17.3679C26.1363 17.3679 24.2832 19.221 24.2832 21.4988C24.2832 23.7765 26.1363 25.6296 28.4141 25.6296ZM28.4141 20.1218C29.1733 20.1218 29.791 20.7395 29.791 21.4988C29.791 22.258 29.1733 22.8757 28.4141 22.8757C27.6548 22.8757 27.0371 22.258 27.0371 21.4988C27.0371 20.7395 27.6548 20.1218 28.4141 20.1218Z" fill="#D71921"/>
                                <path d="M12.8354 17.3679C10.5577 17.3679 8.70459 19.221 8.70459 21.4988C8.70459 23.7765 10.5577 25.6296 12.8354 25.6296C15.1132 25.6296 16.9663 23.7765 16.9663 21.4988C16.9663 19.221 15.1133 17.3679 12.8354 17.3679ZM12.8354 22.8757C12.0762 22.8757 11.4585 22.258 11.4585 21.4988C11.4585 20.7395 12.0762 20.1218 12.8354 20.1218C13.5947 20.1218 14.2124 20.7395 14.2124 21.4988C14.2124 22.258 13.5948 22.8757 12.8354 22.8757Z" fill="#D71921"/>
                                <path d="M46.7246 17.0744L41.923 10.6723L42.1103 9.36112C42.1716 8.93206 42.0273 8.49914 41.7208 8.19273L38.7999 5.27175L41.7207 2.35077C42.2585 1.81312 42.2585 0.941231 41.7207 0.403485C41.1831 -0.134169 40.3112 -0.134169 39.7735 0.403485L36.8526 3.32446L33.9316 0.403485C33.6252 0.0969751 33.1923 -0.0467788 32.7632 0.0139907L19.132 1.96128C18.8371 2.00341 18.5638 2.1401 18.3531 2.35077L1.47644 19.2274C-0.492146 21.1959 -0.492146 24.3991 1.47644 26.3676L15.7566 40.6479C16.0487 40.94 16.3686 41.1877 16.707 41.3931V41.9514C16.707 44.7353 18.9719 47.0002 21.7558 47.0002H41.9512C44.7351 47.0002 47 44.7353 47 41.9514V17.9006C47 17.6027 46.9033 17.3127 46.7246 17.0744ZM3.42373 24.4203C2.52889 23.5255 2.52889 22.0696 3.42373 21.1747L19.9758 4.62265L32.471 2.83766L34.9052 5.27184L32.9579 7.21913L31.9842 6.24544C31.4466 5.70778 30.5747 5.70778 30.0369 6.24544C29.4992 6.78309 29.4992 7.65498 30.0369 8.19273L33.9316 12.0874C34.2005 12.3563 34.5529 12.4907 34.9052 12.4907C35.2575 12.4907 35.61 12.3563 35.8788 12.0874C36.4165 11.5497 36.4165 10.6779 35.8788 10.1401L34.9051 9.16642L36.8524 7.21913L39.2866 9.65331L37.5015 22.1485L20.9495 38.7006C20.516 39.1341 19.9397 39.3727 19.3267 39.3727C18.7137 39.3727 18.1374 39.134 17.7039 38.7006L3.42373 24.4203ZM44.2461 41.9514C44.2461 43.2168 43.2166 44.2463 41.9512 44.2463H21.7558C20.5474 44.2463 19.5549 43.3074 19.4678 42.1209C20.7132 42.0863 21.9483 41.5963 22.8967 40.6479L39.7734 23.7712C39.984 23.5605 40.1207 23.2873 40.1629 22.9923L41.3721 14.5277L44.2461 18.3596V41.9514Z" fill="#0C0736"/>
                                </g>
                                <defs>
                                <clipPath id="clip0">
                                <rect width="47" height="47" fill="white"/>
                                </clipPath>
                                </defs>
                                </svg>
                        </div>
                        <div class="col-8">
                            <p class="opacity-60 fw-600 text-breadcrumb" style="letter-spacing: 3px;">STEP 3</p>
                            <p class="text-paragraph-title">Start selling and enjoy our exclusive discounts for you!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pl-lg-5">
                    <div class="position-absolute">
                        <div class="img-20">
                        </div>
                </div>
                    <div class="img-reseller position-relative">
                </div>
            </div>
        </div>
    </section>
  </div>
@endsection

@section('script')
    <script> 
        $(document).ready(function(){
            $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });

            @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
            $.post('{{ route('home.section.best_sellers') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_sellers').html(data);
                AIZ.plugins.slickCarousel();
            });
            @endif
        });
    </script>
@endsection
