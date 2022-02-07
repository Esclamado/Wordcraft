  @php
      $walkin = strpos(Route::currentRouteName(), "walkin");
  @endphp
@if (Route::currentRouteName() != "walkin.login" && Route::currentRouteName() != "walkin.register" && Route::currentRouteName() != "walkin.store_selection" && Route::currentRouteName() != "walkin.verification")
    <!-- Top Bar -->
    @if (Auth::user() && Auth::user()->user_type != 'customer')
        @if(Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
            <header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm">
                <div class="position-relative logo-bar-area">
                    <div class="container">
                        <div class="d-flex align-items-center justify-content-center p-25px">
                            @php
                                $header_logo = get_setting('header_logo');
                            @endphp
                            @if($header_logo != null)
                                <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="h-30px h-md-40px logo-size">
                            @else
                                <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="h-30px h-md-40px logo-size">
                            @endif
                        </div>
                    </div>
                </div>
            </header>
        @endif
    @else
        <div class="top-navbar bg-white border-bottom z-1035 nav-bar-background">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col">
                        <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                            @if(get_setting('show_language_switcher') == 'on')
                            <li class="list-inline-item dropdown mr-3" id="lang-change">
                                @php
                                    if(Session::has('locale')){
                                        $locale = Session::get('locale', Config::get('app.locale'));
                                    }
                                    else{
                                        $locale = 'en';
                                    }
                                @endphp
                                <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown" data-display="static">
                                    <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" class="mr-2 lazyload" alt="{{ \App\Language::where('code', $locale)->first()->name }}" height="11">
                                    <span class="opacity-60">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    @foreach (\App\Language::all() as $key => $language)
                                        <li>
                                            <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">
                                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                                <span class="language">{{ $language->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif

                            @if(get_setting('show_currency_switcher') == 'on')
                            <li class="list-inline-item dropdown" id="currency-change">
                                @php
                                    if(Session::has('currency_code')){
                                        $currency_code = Session::get('currency_code');
                                    }
                                    else{
                                        $currency_code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
                                    }
                                @endphp
                                <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60" data-toggle="dropdown" data-display="static">
                                    {{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                    @foreach (\App\Currency::where('status', 1)->get() as $key => $currency)
                                        <li>
                                            <a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-7 text-right d-none d-lg-block">
                        <ul class="list-inline mb-0">
                            @if ($walkin === false)
                                <li class="list-inline-item mr-4">
                                    <a href="{{ route('home.store_locations') }}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate("Store Locations") }}</a>
                                </li>
                                {{-- @if(Auth::user()->user_type == 'reseller' || Auth::user()->user_type == 'employee' || Auth::user()->user_type == 'admin' )
                                    <li class="list-inline-item mr-4">
                                        <a href="{{ route('reseller.index', ['step' => 1])  }}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Apply as a Reseller')}}</a>
                                    </li>
                                @endif --}}
                                <li class="list-inline-item mr-4">
                                    <a href="{{ route('reseller.index', ['step' => 1])  }}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Apply as a Reseller')}}</a>
                                </li>
                                <li class="list-inline-item mr-4">
                                    <a href="{{ route('orders.track') }}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Track Order')}}</a>
                                </li>
                            @endif
                            @auth
                                @if ($walkin === false)
                                    @if(isAdmin())
                                        <li class="list-inline-item mr-4">
                                            <a href="{{ route('admin.dashboard') }}" class="text-reset py-2 d-inline-block text-link">{{ translate('My Account')}}</a>
                                        </li>
                                    @else
                                        <li class="list-inline-item mr-4">
                                            <a href="{{ route('dashboard') }}" class="text-reset py-2 d-inline-block text-link">{{ translate('My Account')}}</a>
                                        </li>
                                    @endif
                                    <li class="list-inline-item">
                                        <a href="{{ route('logout')}}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Logout')}}</a>
                                    </li>
                                @else
                                    <li class="list-inline-item">
                                        <a href="{{ route('logout', ['page' => 'walkin'])}}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Logout')}}</a>
                                    </li>
                                @endif
                            @else
                                @if ($walkin === false)
                                    <li class="list-inline-item mr-3">
                                        <a href="{{ route('user.login') }}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Login')}}</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{ route('user.registration') }}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Register')}}</a>
                                    </li>
                                @else
                                    <li class="list-inline-item mr-3">
                                        <a href="{{ route('walkin.login') }}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Login')}}</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{ route('walkin.register') }}" class="text-reset py-2 d-inline-block text-link text-white">{{ translate('Register')}}</a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Top Bar -->
        <header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm">
            <div class="position-relative logo-bar-area py-2">
                <div class="container">
                    <div class="d-flex align-items-center">
                            <div class="col-auto col-xl-5 pl-0 pr-3 d-flex align-items-center">
                                <a class="d-block py-20px mr-3 ml-0" @if($walkin !== false) href="{{ route('walkin.product') }}" @else href="{{ route('home') }}" @endif>
                                    @php
                                        $header_logo = get_setting('header_logo');
                                    @endphp
                                    @if($header_logo != null)
                                        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="h-30px h-md-40px logo-size">
                                    @else
                                        <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="h-30px h-md-40px logo-size">
                                    @endif
                                </a>
                                <div class="d-flex justify-content-center" style="width: 60%;">
                                    @if ($walkin === false)
                                        <div class="d-none d-xl-block align-self-stretch mx-auto c-pointer mr-0 home-nav">
                                            <div class="h-100 d-flex align-items-center home-div">
                                                <a href="{{ route('home') }}">
                                                    <div class="home-btn navbar-light d-flex justify-content-center align-items-center ml-3">
                                                        <span class="home-icon mr-2">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5 12.5H2L12 3.5L22 12.5H19V20.5H13V14.5H11V20.5H5V12.5ZM17 10.69L12 6.19L7 10.69V18.5H9V12.5H15V18.5H17V10.69Z" fill="#1B1464"/>
                                                            </svg>
                                                        </span>
                                                        <div class="nav-text">
                                                                Home
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>                                    
                                    @endif
                                    <div class="d-none d-xl-block c-pointer">
                                        <div class="dropdown" id="category-menu-icon">
                                            <div class="h-100 d-flex align-items-center">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <span class="navbar-toggler-icon"></span>
                                                    <span class="dropbtn pl-4 mr-2"> Categories</span>
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5.25 7.125L9 10.875L12.75 7.125H5.25Z" fill="#9199A4"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="dropdown-content dropdown-content-category mt-2">
                                                @include('frontend.partials.category_menu')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-col d-flex align-items-end">
                                <div class="d-lg-none ml-auto mr-0">
                                    <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">
                                        <i class="las la-search la-flip-horizontal la-2x"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">
                                <div class="position-relative flex-grow-1">
                                    <form @if($walkin !== false) action="{{ route('walkin.product') }}" @else action="{{ route('search') }}" @endif  method="GET" class="stop-propagation" style="margin: 0px">
                                        <div class="d-flex position-relative align-items-center">
                                            <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                                <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="border-0 border-lg form-control form-craft search-border text-subprimary" id="search" name="q" value="{{ request()->query('q') }}" placeholder="{{translate('Enter product name or SKU')}}" autocomplete="off">
                                                <div class="input-group-append d-none d-lg-block">
                                                    <button class="btn btn-primary search-btn" type="submit">
                                                        <i class="la la-search la-flip-horizontal fs-18"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg left-0 top-100 w-100" style="min-height: 200px; position: absolute;">
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

                            <div class="d-none d-lg-none ml-3 mr-0">
                                <div class="nav-search-box">
                                    <a href="#" class="nav-box-link">
                                        <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="grid-cartwishlist ml-5">
                                    <div class="d-none d-lg-block ml-5 mr-0">
                                        <div class="" id="wishlist">
                                            @if($walkin === false)
                                                @include('frontend.partials.wishlist')
                                            @endif 
                                        </div>
                                    </div>
                                

                            <div class="d-none d-lg-block m-auto align-self-stretch mr-0" data-hover="dropdown" style="align-self: end; justify-self: end;">
                                <div class="nav-cart-box dropdown h-100" id="cart_items">
                                    @include('frontend.partials.cart')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </header>
    @endif
@endif

<!-- <script>
  function eraseCookie(name) {   
    document.cookie = 'store_data=;expires=-Thu, 01 Jan 1970 00:00:00 UTC;path=/';
  }
</script> -->

