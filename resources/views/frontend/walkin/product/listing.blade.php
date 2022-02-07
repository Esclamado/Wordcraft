@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
        $category_name = \App\Category::find($category_id)->name;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@elseif (isset($query))
    @php
        $meta_title = $query;
        $meta_description = get_setting('meta_description');
    @endphp
@else
    @php
        $meta_title         = get_setting('meta_title');
        $meta_description   = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@endsection
@section('meta_description'){{ $meta_description }}@endsection

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')
    <section class="py-5 bg-lightblue">
        <div class="container sm-px-0">
            <div class="position-absolute">
                <div class="img-36"></div>
            </div>
            @if (Auth::user() && Auth::user()->user_type != 'customer')
                @if ((Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions))))
                    <div class="row" style="margin-bottom: 25px;">
                        <div class="col-3 d-flex align-items-center">
                            <a class="d-flex align-items-center back-arrow text-gray c-pointer" href="{{ route('cashier.order.view', $order_id)}} ">
                                <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="icon" d="M14.625 4.20833H3.40708L6.24125 1.36625L5.125 0.25L0.375 5L5.125 9.75L6.24125 8.63375L3.40708 5.79167H14.625V4.20833Z" fill="#62616A"/>
                                </svg>
                                Back to Order
                            </a>
                        </div>
                        <div class="col-9">
                            <div class="position-relative flex-grow-1">
                                <form action="{{ route('walkin.product') }}" method="GET" class="stop-propagation">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <input type="text" hidden value="edit_order" name="page">
                                        <div class="input-group" style="width: 85%;">
                                            <input type="text" class="form-control" id="search" name="q" value="{{ request()->query('q') }}" placeholder="{{translate('Enter product name or SKU')}}" autocomplete="off" style="height: 50px">
                                        </div>
                                        <button class="btn btn-orange" type="submit" style="height: 50px;">
                                            <i class="la la-search la-flip-horizontal fs-18"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg left-0 top-100" style="min-height: 200px; position: absolute; z-index: 999; width: 85%;">
                                    <div class="search-preloader absolute-top-center">
                                        <div class="dot-loader"><div></div><div></div><div></div></div>
                                    </div>
                                    <div class="search-nothing d-none p-3 text-center fs-16">

                                    </div>
                                    <div id="search-content" class="text-left">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-xl-3">
                    <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                        <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                        <div class="collapse-sidebar c-scrollbar-light text-left">
                            <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" type="button">
                                    <i class="las la-times la-2x"></i>
                                </button>
                            </div>
                            <div class="bg-white shadow-sm rounded mb-3">
                                <div class="fs-15 fw-600 p-3">
                                    {{ translate('Categories')}}
                                </div>
                                <div class="container border-bottom container-cart mb-3"></div>
                                <div>
                                    <ul class="list-unstyled pb-3">
                                        @if (Route::currentRouteName() == 'walkin.product')
                                            <li class="px-4 py-2 {{ areActiveRoutes(['walkin.product']) ? 'active-category' : '' }}">
                                                <a href="@if($order_id) {{ route('walkin.product', ['order_id' => $order_id]) }} @else {{ route('walkin.product') }} @endif" class="text-reset fs-14 promotion-body">{{ translate('All Categories') }}</a>
                                            </li>
                                        @endif

                                        @if (!isset($category_id))
                                            @foreach (\App\Category::where('level', 0)->get() as $category)
                                                <li class="px-4 py-2 {{ areActiveRoutes(['walkin.products.category', $category->slug]) ? 'active-category' : '' }}">
                                                    <a class="text-reset fs-14 promotion-body" href="@if($order_id) {{ route('walkin.products.category', ['category_slug' => $category->slug ,'order_id' => $order_id]) }} @else {{ route('walkin.products.category', ['category_slug' => $category->slug]) }} @endif">
                                                        <div class="d-inline-flex">
                                                            <div>
                                                                <img
                                                                    class="cat-image lazyload mr-2 opacity-60"
                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset($category->icon) }}"
                                                                    width="16"
                                                                    alt="{{ $category->getTranslation('name') }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                >
                                                            </div>
                                                            <div>
                                                                {{ $category->getTranslation('name') }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="px-4 py-2">
                                                <a href="@if($order_id) {{ route('walkin.product', ['order_id' => $order_id]) }} @else {{ route('walkin.product') }} @endif" class="text-reset fs-14">{{ translate('All Categories') }}</a>
                                            </li>
                                            @if (\App\Category::find($category_id)->parent_id != 0)
                                                <li class="px-4 py-2 {{ areActiveRoutes(['walkin.products.category', \App\Category::find(\App\Category::find($category_id)->parent_id)->slug]) ? 'active-category' : '' }}">
                                                    <a class="text-reset fs-14 promotion-body" href="@if($order_id) {{ route('walkin.products.category', ['category_slug' => \App\Category::find(\App\Category::find($category_id)->parent_id)->slug ,'order_id' => $order_id]) }} @else {{ route('walkin.products.category', ['category_slug' => \App\Category::find(\App\Category::find($category_id)->parent_id)->slug]) }} @endif">
                                                        <div class="d-inline-flex">
                                                            <div>
                                                                <img
                                                                    class="cat-image lazyload mr-2 opacity-60"
                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset(\App\Category::find(\App\Category::find($category_id)->parent_id)->icon) }}"
                                                                    width="16"
                                                                    alt="{{ \App\Category::find(\App\Category::find($category_id)->parent_id)->getTranslation('name') }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                >
                                                            </div>
                                                            <div>
                                                                {{ \App\Category::find(\App\Category::find($category_id)->parent_id)->getTranslation('name') }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif

                                            @php
                                                $slug = \App\Category::find($category_id)->slug;
                                                $icon = \App\Category::find($category_id)->icon;
                                                $name = \App\Category::find($category_id)->getTranslation('name');
                                            @endphp

                                            <li class="px-4 py-2 {{ areActiveRoutes(['walkin.products.category', $slug]) ? 'active-category' : '' }}">
                                                <a class="text-reset fs-14" href="@if($order_id) {{ route('walkin.products.category', ['category_slug' => $slug ,'order_id' => $order_id]) }} @else {{ route('walkin.products.category', $slug) }} @endif">
                                                    <div class="d-inline-flex">
                                                        <div>
                                                            <img
                                                                class="cat-image lazyload mr-2 opacity-60"
                                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                data-src="{{ uploaded_asset($icon) }}"
                                                                width="16"
                                                                alt="{{ $name }}"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                            >
                                                        </div>
                                                        <div>
                                                            {{ $name }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
                                                <li class="ml-4 mb-2">
                                                    <a class="text-reset fs-14" href="@if($order_id) {{ route('walkin.products.category', ['category_slug' => \App\Category::find($id)->slug ,'order_id' => $order_id]) }} @else {{ route('walkin.products.category', \App\Category::find($id)->slug) }} @endif">
                                                        {{ \App\Category::find($id)->getTranslation('name') }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!-- @if (Auth::user() && Auth::user()->user_type != 'customer')
                                {{-- display nothing --}}
                            @else -->
                                <!-- Start Price range -->
                                <!-- <div class="bg-white shadow-sm rounded mb-3">
                                    <div class="fs-15 fw-600 p-3 border-bottom">
                                        {{ translate('Price range')}}
                                    </div>
                                    <div class="p-3">
                                        <div class="aiz-range-slider">
                                            <div
                                                id="input-slider-range"
                                                data-range-value-min="@if(count(\App\Product::query()->get()) < 1) 0 @else {{ filter_products(\App\Product::query())->get()->min('unit_price') }} @endif"
                                                data-range-value-max="@if(count(\App\Product::query()->get()) < 1) 0 @else {{ filter_products(\App\Product::query())->get()->max('unit_price') }} @endif"
                                            ></div>

                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                                        @if (isset($min_price))
                                                            data-range-value-low="{{ $min_price }}"
                                                        @elseif($products->min('unit_price') > 0)
                                                            data-range-value-low="{{ $products->min('unit_price') }}"
                                                        @else
                                                            data-range-value-low="0"
                                                        @endif
                                                        id="input-slider-range-value-low"
                                                    ></span>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <span class="range-slider-value value-high fs-14 fw-600 opacity-70"
                                                        @if (isset($max_price))
                                                            data-range-value-high="{{ $max_price }}"
                                                        @elseif($products->max('unit_price') > 0)
                                                            data-range-value-high="{{ $products->max('unit_price') }}"
                                                        @else
                                                            data-range-value-high="0"
                                                        @endif
                                                        id="input-slider-range-value-high"
                                                    ></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- End Price range -->
                                
                                <!-- Start Filter by color -->
                                <!-- <div class="bg-white shadow-sm rounded mb-3">
                                    <div class="fs-15 fw-600 p-3 border-bottom">
                                        {{ translate('Filter by color')}}
                                    </div>
                                    <div class="p-3">
                                        <div class="aiz-radio-inline">
                                            @foreach ($all_colors as $key => $color)
                                            <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                                <input
                                                    type="radio"
                                                    name="color"
                                                    value="{{ $color }}"
                                                    onchange="filter()"
                                                    @if(isset($selected_color) && $selected_color == $color) checked @endif
                                                >
                                                <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                    <span class="size-30px d-inline-block rounded" style="background: {{ $color }};"></span>
                                                </span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>     -->
                                <!-- End Filter by color -->

                                <!-- @foreach ($attributes as $key => $attribute)
                                    @if (\App\Attribute::find($attribute['id']) != null)
                                        <div class="bg-white shadow-sm rounded mb-3">
                                            <div class="fs-15 fw-600 p-3 border-bottom">
                                                {{ translate('Filter by') }} {{ \App\Attribute::find($attribute['id'])->getTranslation('name') }}
                                            </div>
                                            <div class="p-3">
                                                <div class="aiz-checkbox-list">
                                                    @if(array_key_exists('values', $attribute))
                                                        @foreach ($attribute['values'] as $key => $value)
                                                            @php
                                                                $flag = false;
                                                                if(isset($selected_attributes)){
                                                                    foreach ($selected_attributes as $key => $selected_attribute) {
                                                                        if($selected_attribute['id'] == $attribute['id']){
                                                                            if(in_array($value, $selected_attribute['values'])){
                                                                                $flag = true;
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            
                                                            <div class="form-craft-check d-flex justify-content-start align-items-start mb-4">
                                                                <input type="checkbox" id="filter-{{ $value }}" name="attribute_{{ $attribute['id'] }}[]" value="{{ $value }}" @if ($flag) checked @endif onchange="filter()" class="mr-3">
                                                                <label for="filter-{{ $value }}" class="ml-3 mb-0">{{ $value }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="text-left">
                        <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h1 class="fw-600 text-body desktop-content my-0">
                                        <ul class="breadcrumb bg-transparent p-0  fs-14" style="margin-bottom: 41px;">
                                            <li class="breadcrumb-item1 opacity-50">
                                                <a class="text-reset fw-400" href="@if($order_id) {{ route('walkin.product', ['order_id' => $order_id]) }} @else {{ route('walkin.product') }} @endif">{{ translate('Products')}}</a>
                                            </li>
                                            <li class="breadcrumb-item1 @if(!isset($category_id)) fw-600  text-dark @else opacity-50 @endif">
                                                <a class="text-reset" href="@if($order_id) {{ route('walkin.product', ['order_id' => $order_id]) }} @else {{ route('walkin.product') }} @endif">{{ translate('All Categories')}}</a>
                                            </li>
                                            @if(isset($category_id))
                                                <li class="text-dark fw-600 breadcrumb-item1">
                                                    <a class="text-reset" href="@if($order_id) {{ route('walkin.products.category', ['category_slug' => \App\Category::find($category_id)->slug , 'order_id' => $order_id]) }} @else {{ route('walkin.products.category', \App\Category::find($category_id)->slug) }} @endif">{{ \App\Category::find($category_id)->getTranslation('name') }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                            @if(isset($category_id))
                                                <!-- {{ \App\Category::find($category_id)->getTranslation('name') }} -->
                                            @elseif(isset($query))
                                                {{ translate('Search result for ') }}"{{ $query }}"
                                            @else
                                                <!-- {{ translate('All Products') }} -->
                                            @endif
                                    </h1>
                                </div>

                                    <div class="col-lg-4 col-10">
                                        <div class="d-flex sort-by" style="margin-bottom:27px">
                                            <label class="d-flex align-items-center" style="width:100px;font-size: 16px;">{{ translate('Sort by')}}</label>
                                            <select class="form-control form-control-sm aiz-selectpicker" name="sort_by" onchange="filter()">
                                                <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>
                                                <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>
                                                <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                                                <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="d-xl-none d-lg-none ml-auto ml-xl-3 mr-0 form-group align-self-end">
                                            <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                                <i class="la la-filter la-2x"></i>
                                            </button>
                                        </div>
                                    </div>      
                        </div>
                    </div>

                    @if (count($products) != 0) 
                        <input type="hidden" name="q" value="{{ request()->get('q') }}">
                        <input type="hidden" name="min_price" value="">
                        <input type="hidden" name="max_price" value="">
                        <div class="row gutters-6 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-2">
                            @foreach ($products as $key => $product)
                                <div class="col mb-4">
                                    <a href="@if($order_id) {{ route('walkin.product.details',['slug' => $product->slug, 'order_id' => $order_id]) }} @else {{ route('walkin.product.details', $product->slug) }} @endif" class="card-block stretched-link text-decoration-none">
                                        <div class="aiz-card-box border-product shadow-sm hov-shadow-md has-transition bg-white">
                                            <div class="position-relative">
                                                <a href="@if($order_id) {{ route('walkin.product.details',['slug' => $product->slug, 'order_id' => $order_id]) }} @else {{ route('walkin.product.details', $product->slug) }} @endif" class="d-block">
                                                    <img
                                                        class="img-fit lazyload mx-auto h-160px h-md-180px h-xl-220px h-xxl-200px p-3 mx-auto"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                        alt="{{  $product->getTranslation('name')  }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </a>
                                            </div>
                                            <div class="p-md-3 p-2 text-left">
                                                <div class="fs-15">
                                                    {{-- @if(home_base_price($product->id) != home_discounted_base_price($product->id) && Auth::user()->user_type != 'customer') --}}
                                                    @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                        <del class="fw-600  mr-1" style="color:#CE141C; font-size:12px">{{ home_base_price($product->id) }}</del>
                                                    @endif
                                                    {{-- @if (Auth::user()->user_type != 'customer') --}}
                                                    <span class="fw-700 text-craft-blue">{{ home_discounted_base_price($product->id) }}</span>
                                                    {{--  @else
                                                    <span class="fw-700 text-craft-blue">{{ home_base_price($product->id) }}</span>
                                                    @endif --}}
                                                </div>
                                                <div class="rating rating-sm mt-2 mb-2">
                                                    {{ renderStarRating($product->rating) }}
                                                </div>
                                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                                    <a href="@if($order_id) {{ route('walkin.product.details',['slug' => $product->slug, 'order_id' => $order_id]) }} @else {{ route('walkin.product.details', $product->slug) }} @endif" class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
                                                </h3>

                                                @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                    <!-- <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                        {{ translate('Club Point') }}:
                                                        <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                                                    </div> -->
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>                              
                            @endforeach
                        </div>
                        <div class="aiz-pagination aiz-pagination-center mt-4">
                            {{ $products->appends(['q' => request()->query('q')])->links() }}
                        </div>
                    @else
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 flex-column empty-container">
                                    <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0)">
                                        <path d="M22.0599 41.1446L16.8186 46.386L14.4713 44.0388C13.9754 43.5431 13.1718 43.5431 12.6758 44.0388L1.71318 55.0014C-0.571059 57.2856 -0.571059 61.0026 1.71318 63.2868C2.85529 64.4289 4.35569 65 5.85583 65C7.35609 65 8.85649 64.4289 9.9986 63.2868L20.9612 52.3242C21.457 51.8284 21.457 51.0245 20.9612 50.5286L18.614 48.1814L23.8553 42.9401C24.3511 42.4443 24.3511 41.6404 23.8553 41.1445C23.3594 40.649 22.5558 40.649 22.0599 41.1446ZM8.20316 61.4912C6.90907 62.7854 4.80296 62.7857 3.50875 61.4912C2.21453 60.197 2.21453 58.0912 3.50875 56.7968L13.5735 46.7321L18.2679 51.4265L8.20316 61.4912Z" fill="#1B1464"/>
                                        <path d="M57.4166 7.58322C47.3057 -2.52774 30.9126 -2.52774 20.8015 7.58322C10.6905 17.6942 10.6905 34.0873 20.8015 44.1984C30.9124 54.3095 47.3056 54.3093 57.4166 44.1984C67.5277 34.0874 67.5277 17.6942 57.4166 7.58322ZM52.0269 38.8085C44.8926 45.9428 33.3257 45.9428 26.1915 38.8085C19.0572 31.6742 19.0572 20.1073 26.1915 12.9731C33.3258 5.83881 44.8927 5.83881 52.0269 12.9731C59.1611 20.1073 59.1611 31.6743 52.0269 38.8085Z" fill="#FFCFD1"/>
                                        <g clip-path="url(#clip1)">
                                        <path d="M32 20.6497L33.6497 19L39 24.3503L44.3503 19L46 20.6497L40.6497 26L46 31.3503L44.3503 33L39 27.6497L33.6498 33L32 31.3503L37.3503 26L32 20.6497Z" fill="#D71921"/>
                                        </g>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0">
                                        <rect width="65" height="65" fill="white"/>
                                        </clipPath>
                                        <clipPath id="clip1">
                                        <rect width="14" height="14" fill="white" transform="matrix(-1 0 0 1 46 19)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                    <span class="fs-16 lh-24" style="line-height:24px; margin-top:17px;">Sorry, there are no products</span>
                                    <span class="fs-16 lh-24">in this category yet.</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>
@endsection
