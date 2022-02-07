
@php
    $route = Route::currentRouteName();
@endphp
@if (strpos($route, 'walkin') === false)
    <section class="bg-white py-5 text-dark border-top" style="z-index: 1;">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-xl-5 text-md-left">
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="d-block">
                            @if(get_setting('footer_logo') != null)
                                <img class="lazyload img-footer-size" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset(get_setting('footer_logo')) }}" alt="{{ env('APP_NAME') }}" height="44">
                            @else
                                <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="44">
                            @endif
                        </a>
                        <div class="my-3 text-paragraph-thin pr-lg-5">
                            @php
                                echo get_setting('about_us_description');
                            @endphp
                        </div>
                        <div class="d-inline-block d-md-block">
                            <form class="form-inline subscribe-email" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="form-group mb-0">
                                    <input type="email" class="form-craft form-control" placeholder="{{ translate('Your Email Address') }}" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-craft-primary-nopadding">
                                    {{ translate('Subscribe') }}<i class="ml-1 las la-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 ml-xl-auto col-md-4 mr-0">
                    <div class="text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-gray-900 pb-2 mb-4 footer-useful-title">
                            {{ translate('Contact Info') }}
                        </h4>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                            <span class="d-block opacity-30 text-paragraph-thin">{{ translate('Address') }}:</span>
                            <span class="d-block text-paragraph-thin pr-lg-2">{{ get_setting('contact_address') }}</span>
                            </li>
                            <li class="mb-2">
                            <span class="d-block opacity-30 text-paragraph-thin">{{translate('Phone')}}:</span>
                            <span class="d-block text-paragraph-thin">
                                <a href="tel:{{ get_setting('contact_phone') }}" class="text-reset text-link-hover">{{ get_setting('contact_phone') }}</a>
                            </span>
                            </li>
                            <li class="mb-2">
                            <span class="d-block opacity-30 text-paragraph-thin">{{translate('Email')}}:</span>
                            <span class="d-block text-paragraph-thin">
                                <a href="mailto:{{ get_setting('contact_email') }}" class="text-reset text-link-hover">{{ get_setting('contact_email')  }}</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-gray-900 pb-2 mb-4 footer-useful-title">
                            {{ get_setting('widget_one') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if ( get_setting('widget_one_labels') !=  null )
                                @foreach (json_decode( get_setting('widget_one_labels'), true) as $key => $value)
                                    <li class="mb-2">
                                        <a href="{{ url('/') . '/' . json_decode( get_setting('widget_one_links'), true)[$key] }}" class="hov-opacity-100 text-reset text-paragraph-thin text-link-hover">
                                            {{ $value }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-gray-900 pb-2 mb-4 footer-useful-title">
                            {{ translate('My Account') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if (Auth::check())
                                <li class="mb-2">
                                    <a class="hov-opacity-100 text-reset text-paragraph-thin text-link-hover" href="{{ route('logout') }}">
                                        {{ translate('Logout') }}
                                    </a>
                                </li>
                            @else
                                <li class="mb-2">
                                    <a class="hov-opacity-100 text-reset text-paragraph-thin text-link-hover" href="{{ route('user.login') }}">
                                        {{ translate('Login') }}
                                    </a>
                                </li>
                            @endif
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-reset text-paragraph-thin text-link-hover" href="{{ route('purchase_history.index') }}">
                                    {{ translate('Purchase History') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-reset text-paragraph-thin text-link-hover" href="{{ route('wishlists.index') }}">
                                    {{ translate('My Wishlist') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-reset text-paragraph-thin text-link-hover" href="{{ route('wallet.index') }}">
                                    {{ translate('My Wallet') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    @if (get_setting('vendor_system_activation') == 1)
                        @auth
                            @if(Auth::user()->user_type == 'customer')
                                <div class="text-md-left mt-4">
                                    <h4 class="fs-13 text-uppercase fw-600 border-gray-900 pb-2 mb-4 footer-useful-title">
                                        {{ translate('Be a Reseller') }}
                                    </h4>
                                    <a href="{{ route('reseller.index', ['step' => 1])  }}" class="btn btn-sm shadow-md btn-craft-red">
                                        {{ translate('Apply Now') }}
                                    </a>
                                </div>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-black text-light footer-bottom-background">
        <div class="container mt-lg-4 pt-2">

            <div class="grid-footer-bottom">
                <div class="d-flex justify-content-left align-items-center copyright-footer">
                    <div class="text-center text-md-left text-paragraph-thin">
                        Copyright &copy; {{ \Carbon\Carbon::now()->year }} WorldCraft
                    </div>
                </div>

                <div class="d-flex justify-content-left align-items-center terms-privacy">
                    <ul class="list-inline my-3 my-md-0 text-center-bottom">
                        <li class="list-inline-item ml-lg-2 mr-lg-3">
                            <a href="{{route('terms')}}" class="mr-1 text-paragraph-thin text-lightgray text-link-hover">Terms and Conditions</a>
                        </li>
                        <li class="list-inline-item mr-lg-3">
                            <a class="text-paragraph-thin text-lightgray text-link-hover" href="{{route('privacypolicy')}}">Privacy Policy</a>
                        </li>
                        <li class="list-inline-item ml-lg-3">
                            <a class="text-paragraph-thin text-lightgray text-link-hover" href="{{route('home.section.faq')}}">FAQs</a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex justify-content-left align-items-center social-footer">
                    <ul class="list-inline social colored mb-2 text-center-bottom">
                        <li class="list-inline-item">
                            <a href="{{ get_setting('facebook_link') != null ? get_setting('facebook_link') : '#' }}" target="_blank" class="facebook">
                                <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.72372 18V9.94922H0V6.75H2.72372V4.2293C2.72372 1.49063 4.41406 0 6.8821 0C8.06463 0 9.08025 0.0878906 9.375 0.126562V2.98828H7.66335C6.32102 2.98828 6.06179 3.62109 6.06179 4.5457V6.75H9.09091L8.67543 9.94922H6.06179V18" fill="white"/>
                                </svg>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ get_setting('instagram_link') != null ? get_setting('instagram_link') : '#' }}" target="_blank" class="instagram">
                                <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.37701 4.38503C6.82308 4.38503 4.76306 6.4455 4.76306 9C4.76306 11.5545 6.82308 13.615 9.37701 13.615C11.9309 13.615 13.991 11.5545 13.991 9C13.991 6.4455 11.9309 4.38503 9.37701 4.38503ZM9.37701 12.0003C7.72659 12.0003 6.37734 10.6548 6.37734 9C6.37734 7.3452 7.72257 5.99967 9.37701 5.99967C11.0314 5.99967 12.3767 7.3452 12.3767 9C12.3767 10.6548 11.0274 12.0003 9.37701 12.0003ZM15.2559 4.19625C15.2559 4.79471 14.774 5.27268 14.1797 5.27268C13.5814 5.27268 13.1035 4.7907 13.1035 4.19625C13.1035 3.60181 13.5854 3.11983 14.1797 3.11983C14.774 3.11983 15.2559 3.60181 15.2559 4.19625ZM18.3118 5.28874C18.2435 3.84681 17.9142 2.56956 16.8581 1.51724C15.806 0.464911 14.529 0.135557 13.0874 0.0632601C11.6017 -0.0210866 7.14834 -0.0210866 5.66256 0.0632601C4.22497 0.131541 2.94801 0.460895 1.8919 1.51322C0.835792 2.56555 0.510527 3.8428 0.438246 5.28473C0.353918 6.77084 0.353918 11.2251 0.438246 12.7113C0.506511 14.1532 0.835792 15.4304 1.8919 16.4828C2.94801 17.5351 4.22096 17.8644 5.66256 17.9367C7.14834 18.0211 11.6017 18.0211 13.0874 17.9367C14.529 17.8685 15.806 17.5391 16.8581 16.4828C17.9102 15.4304 18.2395 14.1532 18.3118 12.7113C18.3961 11.2251 18.3961 6.77485 18.3118 5.28874ZM16.3923 14.3058C16.0791 15.093 15.4727 15.6995 14.6816 16.0168C13.497 16.4868 10.6861 16.3783 9.37701 16.3783C8.06792 16.3783 5.25297 16.4828 4.07238 16.0168C3.28532 15.7036 2.67896 15.0971 2.36173 14.3058C1.8919 13.1209 2.00032 10.3094 2.00032 9C2.00032 7.69062 1.89591 4.87504 2.36173 3.69419C2.67494 2.90695 3.2813 2.30046 4.07238 1.98315C5.25699 1.51322 8.06792 1.62167 9.37701 1.62167C10.6861 1.62167 13.501 1.51724 14.6816 1.98315C15.4687 2.29644 16.0751 2.90293 16.3923 3.69419C16.8621 4.87906 16.7537 7.69062 16.7537 9C16.7537 10.3094 16.8621 13.125 16.3923 14.3058Z" fill="white"/>
                                </svg>

                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ get_setting('youtube_link') != null ? get_setting('youtube_link') : '#' }}" target="_blank" class="youtube">
                                <svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.1187 2.81639C21.8633 1.7078 21.1108 0.834703 20.1553 0.538406C18.4235 0 11.4789 0 11.4789 0C11.4789 0 4.53436 0 2.80246 0.538406C1.84698 0.83475 1.09446 1.7078 0.839053 2.81639C0.375 4.82578 0.375 9.01819 0.375 9.01819C0.375 9.01819 0.375 13.2106 0.839053 15.22C1.09446 16.3286 1.84698 17.1653 2.80246 17.4616C4.53436 18 11.4789 18 11.4789 18C11.4789 18 18.4234 18 20.1553 17.4616C21.1108 17.1653 21.8633 16.3286 22.1187 15.22C22.5828 13.2106 22.5828 9.01819 22.5828 9.01819C22.5828 9.01819 22.5828 4.82578 22.1187 2.81639ZM9.20763 12.8246V5.2118L15.0119 9.01828L9.20763 12.8246Z" fill="white"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex justify-content-end align-items-center payment-footer">
                    <ul class="list-inline mb-0 mt-1">
                        {{-- @if ( get_setting('payment_method_images') !=  null )
                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                <li class="list-inline-item">
                                    <img src="{{ uploaded_asset($value) }}" height="30">
                                </li>
                            @endforeach
                        @endif --}}
                        <li class="list-inline-item">
                            <img src="https://res.cloudinary.com/http-book-keeping-com/image/upload/v1612330830/Worldcraft/Rectangle_52.png" height="30">
                        </li>
                        <li class="list-inline-item">
                            <img src="https://res.cloudinary.com/http-book-keeping-com/image/upload/v1612330841/Worldcraft/Rectangle_50.png" height="30">
                        </li>
                        <li class="list-inline-item">
                            <img src="https://res.cloudinary.com/http-book-keeping-com/image/upload/v1612330848/Worldcraft/Rectangle_51.png" height="30">
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </footer>


    <div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top mt-5">
        <div class="d-flex justify-content-around align-items-center">
            <a href="{{ route('home') }}" class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['home'],'bg-soft-primary')}}">
                <i class="las la-home la-2x"></i>
            </a>
            <a href="{{ route('categories.all') }}" class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['categories.all'],'bg-soft-primary')}}">
                <span class="d-inline-block position-relative px-2">
                    <i class="las la-list-ul la-2x"></i>
                </span>
            </a>
            <a href="{{ route('cart') }}" class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['cart'],'bg-soft-primary')}}">
                <span class="d-inline-block position-relative px-2">
                    <i class="las la-shopping-cart la-2x"></i>
                    @if(Session::has('cart'))
                        <span class="badge badge-circle badge-primary position-absolute absolute-top-right" id="cart_items_sidenav">{{ count(Session::get('cart'))}}</span>
                    @else
                        <span class="badge badge-circle badge-primary position-absolute absolute-top-right" id="cart_items_sidenav">0</span>
                    @endif
                </span>
            </a>
            @if (Auth::check())
                @if(isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-reset flex-grow-1 text-center py-2">
                        <span class="avatar avatar-sm d-block mx-auto">
                        
                            @if (Auth::user()->avatar_original != null)
                            <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            @else
                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            @endif
                        </span>
                    </a>
                @else
                    <a href="javascript:void(0)" class="text-reset flex-grow-1 text-center py-2 mobile-side-nav-thumb" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                        <span class="avatar avatar-sm d-block mx-auto">
                            
                            @if (Auth::user()->avatar_original != null)
                            <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            @else
                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            @endif
                        </span>
                    </a>
                @endif
            @else
                <a href="{{ route('user.login') }}" class="text-reset flex-grow-1 text-center py-2">
                    <span class="avatar avatar-sm d-block mx-auto">
                        <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                    </span>
                </a>
            @endif
        </div>
    </div>
@endif
@if (Auth::check() && !isAdmin())
    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">
        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb"></div>
        <div class="collapse-sidebar bg-white">
            @include('frontend.inc.user_side_nav')
        </div>
    </div>
@endif