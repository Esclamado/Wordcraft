<div class="aiz-user-sidenav-wrap pt-4 position-relative z-1 shadow-none border-0">
    <div class="absolute-top-right d-xl-none">
        <button class="btn btn-sm p-2" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb">
            <i class="las la-times la-2x"></i>
        </button>
    </div>

    <div class="absolute-top-left d-xl-none">
        <a class="btn btn-sm p-2" href="{{ route('logout') }}">
            <i class="las la-sign-out-alt la-2x"></i>
        </a>
    </div>

    <div class="aiz-user-sidenav rounded overflow-hidden  c-scrollbar-light">
        <div class="px-4 text-center mb-4">
            <span class="avatar avatar-md mb-3">
                @if (Auth::user()->avatar_original != null)
                    <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                @else
                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                @endif
            </span>

            @if(Auth::user()->user_type == 'customer' || Auth::user()->user_type == 'employee' || Auth::user()->user_type == 'reseller' || Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
                <h4 class="customer-craft-side-nav-title mb-0">
                    {{ Auth::user()->name }}

                    @if (Auth::user()->user_type == 'reseller')
                        <span>
                            @if(Auth::user()->reseller->is_verified == 1)
                                <i class="las la-check-circle" style="color:green"></i>
                            @else
                                <i class="las la-times-circle" style="color:red"></i>
                            @endif
                        </span>
                    @endif
                </h4>
                <p class="customer-craft-side-nav-subtitle">{{ Auth::user()->email }}</p>
            @else
                <h4 class="customer-craft-side-nav-title">{{ Auth::user()->name }}
                    <span class="ml-2">
                        @if(Auth::user()->seller->is_verifed == 1)
                            <i class="las la-check-circle" style="color:green"></i>
                        @else
                            <i class="las la-times-circle" style="color:red"></i>
                        @endif
                    </span>
                </h4>
            @endif
        </div>

        <ul class="aiz-side-nav-list d-xl-none" data-toggle="aiz-side-menu">
            <li class="aiz-side-nav-item">
                <a class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['orders.track']) }}" href="{{ route('orders.track') }}">
                    <svg class="mr-3" id="Layer_1" enable-background="new 0 0 510.222 510.222" height="20" viewBox="0 0 510.222 510.222" width="20" xmlns="http://www.w3.org/2000/svg">
                        <path d="m406.478 62.747c-83.658-83.658-219.067-83.667-302.734 0-83.656 83.655-83.669 219.067 0 302.734l140.054 140.054c6.249 6.249 16.379 6.248 22.627 0l140.054-140.054c83.655-83.655 83.668-219.066-.001-302.734zm-22.627 280.108-128.74 128.74-128.74-128.74c-70.987-70.987-70.987-186.493 0-257.48 70.988-70.986 186.49-70.988 257.48 0 70.987 70.986 70.987 186.492 0 257.48z"/>
                        <path d="m255.111 118.42c-52.888 0-95.695 42.798-95.695 95.694 0 52.887 42.8 95.694 95.695 95.694 52.889 0 95.695-42.8 95.695-95.694 0-52.887-42.799-95.694-95.695-95.694zm45.039 140.733c-.613 0-15.694 18.655-45.039 18.655-35.203 0-63.695-28.487-63.695-63.694 0-35.202 28.488-63.694 63.695-63.694 57.185 0 84.671 69.102 45.039 108.733z"/>
                    </svg>
                    <span class="aiz-side-nav-text">{{ translate('Track your Order') }}</span>
                </a>
            </li>

            <li class="aiz-side-nav-item">
                <a href="{{ route('home.store_locations') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['home.store_locations']) }}">
                    <svg class="mr-3" height="20" viewBox="0 0 128 128" width="20" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path fill-rule="evenodd" d="m78.777 37.021a14.777 14.777 0 1 0 -14.777 14.779 14.795 14.795 0 0 0 14.777-14.779zm-26.054 0a11.277 11.277 0 1 1 11.277 11.279 11.29 11.29 0 0 1 -11.277-11.279z"/>
                            <path fill-rule="evenodd" d="m123.328 121.069-14.266-37.4a1.751 1.751 0 0 0 -1.635-1.126h-27c.165-.269.329-.53.494-.8 10.389-17.2 15.617-32.246 15.542-44.714a32.464 32.464 0 0 0 -64.928-.011c-.075 12.479 5.153 27.527 15.542 44.725.165.273.329.534.494.8h-27a1.751 1.751 0 0 0 -1.635 1.126l-14.264 37.4a1.748 1.748 0 0 0 1.635 2.374h115.386a1.748 1.748 0 0 0 1.635-2.374zm-88.292-84.048a28.964 28.964 0 1 1 57.928.01c.15 24.858-23.09 55.517-28.964 62.869-5.874-7.349-29.115-38-28.964-62.879zm27.631 66.779a1.75 1.75 0 0 0 2.666 0 185.716 185.716 0 0 0 12.9-17.759h27.987l2.24 5.875-54.691 19.451-19.494-25.329h15.49a185.716 185.716 0 0 0 12.902 17.762zm-8.959 11.3h.01l32.627-11.6 12.655 16.443h-58.9zm-31.93-29.062h8.08l20.442 26.562-20.643 7.342h-20.81zm81.643 33.905-13.609-17.682 19.9-7.077 9.443 24.759z"/>
                        </g>
                    </svg>
                    <span class="aiz-side-nav-text">{{ translate('Store Locations') }}</span>
                </a>
            </li>
        </ul>

        <div class="sidemenu mb-3">

            @if (Auth::user()->user_type == 'employee')
                <div class="side-nav-text">
                    Employee Panel
                </div>
            @elseif (Auth::user()->user_type == 'reseller')
                <div class="side-nav-text">
                    Reseller Panel
                </div>
            @endif

            <ul class="aiz-side-nav-list" data-toggle="aiz-side-menu">
                {{-- // Customer Dashboard --}}
                <li class="aiz-side-nav-item">
                    <a href="{{ route('dashboard') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['dashboard']) }}">
                        <svg class="mr-3" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.58301 11.4584H1.83301L10.9997 3.20837L20.1663 11.4584H17.4163V18.7917H11.9163V13.2917H10.083V18.7917H4.58301V11.4584ZM15.583 9.79921L10.9997 5.67421L6.41634 9.79921V16.9584H8.24967V11.4584H13.7497V16.9584H15.583V9.79921Z" @if (Route::currentRouteName() != 'dashboard') fill="#9199A4" @else fill="#D71921" @endif />
                        </svg>
                        <span class="aiz-side-nav-text">{{ translate('My Dashboard') }}</span>
                    </a>
                </li>

                @if (Auth::user()->user_type == 'employee')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('employee.my_resellers') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['employee.my_resellers', 'employee.my_reseller_show']) }}">
                            <svg class="mr-3" width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25016 11.4999C10.0193 11.4999 11.4585 10.0608 11.4585 8.29159C11.4585 6.52242 10.0193 5.08325 8.25016 5.08325C6.481 5.08325 5.04183 6.52242 5.04183 8.29159C5.04183 10.0608 6.481 11.4999 8.25016 11.4999ZM1.8335 16.3124C1.8335 14.1766 6.10516 13.1041 8.25016 13.1041C10.3952 13.1041 14.6668 14.1766 14.6668 16.3124V17.9166H1.8335V16.3124ZM8.25016 14.9374C6.60933 14.9374 4.7485 15.5516 3.9785 16.0833H12.5218C11.7518 15.5516 9.891 14.9374 8.25016 14.9374ZM9.62516 8.29159C9.62516 7.53075 9.011 6.91659 8.25016 6.91659C7.48933 6.91659 6.87516 7.53075 6.87516 8.29159C6.87516 9.05242 7.48933 9.66658 8.25016 9.66658C9.011 9.66658 9.62516 9.05242 9.62516 8.29159ZM14.7035 13.1591C15.7668 13.9291 16.5002 14.9558 16.5002 16.3124V17.9166H20.1668V16.3124C20.1668 14.4608 16.9585 13.4066 14.7035 13.1591ZM16.9585 8.29159C16.9585 10.0608 15.5193 11.4999 13.7502 11.4999C13.2552 11.4999 12.7968 11.3808 12.3752 11.1791C12.9527 10.3633 13.2918 9.36409 13.2918 8.29159C13.2918 7.21909 12.9527 6.21992 12.3752 5.40409C12.7968 5.20242 13.2552 5.08325 13.7502 5.08325C15.5193 5.08325 16.9585 6.52242 16.9585 8.29159Z" @if (Route::currentRouteName() == 'employee.my_resellers' || Route::currentRouteName() == 'employee.my_reseller_show') fill="#D71921" @else fill="#9199A4" @endif />
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('My Resellers') }}</span>
                        </a>
                    </li>

                    <li class="aiz-side-nav-item">
                        <a href="{{ route('employee.my_earnings') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['employee.my_earnings', 'employee.my_earnings_reseller', 'employee.my_earnings_customer.order_show', 'employee.my_earnings_reseller.order_show']) }}">
                            <svg class="mr-3" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 2.25C6.17 2.25 2.25 6.17 2.25 11C2.25 15.83 6.17 19.75 11 19.75C15.83 19.75 19.75 15.83 19.75 11C19.75 6.17 15.83 2.25 11 2.25ZM11 18C7.14125 18 4 14.8587 4 11C4 7.14125 7.14125 4 11 4C14.8587 4 18 7.14125 18 11C18 14.8587 14.8587 18 11 18ZM9.22375 8.78625C9.22375 9.425 9.7225 9.85375 11.2713 10.2475C12.8113 10.65 14.465 11.315 14.4738 13.24C14.465 14.6488 13.415 15.41 12.085 15.6637V17.125H10.0375V15.6375C8.725 15.3663 7.6225 14.5262 7.535 13.0387H9.04C9.11875 13.8438 9.67 14.4738 11.07 14.4738C12.5663 14.4738 12.9075 13.7212 12.9075 13.2575C12.9075 12.6275 12.5663 12.0238 10.86 11.6213C8.96125 11.1663 7.6575 10.3787 7.6575 8.8125C7.6575 7.49125 8.71625 6.63375 10.0375 6.35375V4.875H12.0763V6.37125C13.4938 6.72125 14.2113 7.7975 14.255 8.97H12.7588C12.7238 8.1125 12.2688 7.535 11.0613 7.535C9.915 7.535 9.22375 8.05125 9.22375 8.78625Z" @if (Route::currentRouteName() == 'employee.my_earnings' || Route::currentRouteName() == 'employee.my_earnings_reseller' || Route::currentRouteName() == 'employee.my_earnings_customer.order_show' || Route::currentRouteName() == 'employee.my_earnings_reseller.order_show') fill="#D71921" @else fill="#9199A4" @endif/>
                            </svg>

                            <span class="aiz-side-nav-text">{{ translate('My Earnings') }}</span>
                        </a>
                    </li>

                    <li class="aiz-side-nav-item">
                        <a href="{{ route('employee.my_customer_orders') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['employee.my_customer_orders', 'employee.my_customer_orders_returns']) }}">
                            <svg class="mr-3" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.425 19.25H3.575C3.11667 19.25 2.75 18.8833 2.75 18.425V3.575C2.75 3.20833 3.11667 2.75 3.575 2.75H18.425C18.7917 2.75 19.25 3.20833 19.25 3.575V18.425C19.25 18.8833 18.7917 19.25 18.425 19.25ZM8.25 15.5833H6.41667V13.75H8.25V15.5833ZM15.5833 15.5833H10.0833V13.75H15.5833V15.5833ZM15.5833 11.9167H10.0833V10.0833H15.5833V11.9167ZM10.0833 8.25H15.5833V6.41667H10.0833V8.25ZM6.41667 11.9167H8.25V10.0833H6.41667V11.9167ZM8.25 8.25H6.41667V6.41667H8.25V8.25ZM4.58333 4.58333H17.4167V17.4167H4.58333V4.58333Z" @if (Route::currentRouteName() == 'employee.my_customer_orders' || Route::currentRouteName() == 'employee.my_customer_orders_returns') fill="#D71921" @else fill="#9199A4" @endif/>
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Customer Orders') }}</span>
                        </a>
                    </li>

                    <li class="aiz-side-nav-item">
                        <a href="{{ route('employee.my_customers') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['employee.my_customers', 'employee.my_customer.show']) }}">
                            <svg class="mr-3" width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0002 2.33325C5.94016 2.33325 1.8335 6.43992 1.8335 11.4999C1.8335 16.5599 5.94016 20.6666 11.0002 20.6666C16.0602 20.6666 20.1668 16.5599 20.1668 11.4999C20.1668 6.43992 16.0602 2.33325 11.0002 2.33325ZM11.4677 9.65742C11.4677 8.14492 10.2302 6.90742 8.71766 6.90742C7.20516 6.90742 5.96766 8.14492 5.96766 9.65742C5.96766 11.1699 7.20516 12.4074 8.71766 12.4074C10.2302 12.4074 11.4677 11.1699 11.4677 9.65742ZM8.71766 10.5741C8.2135 10.5741 7.801 10.1616 7.801 9.65742C7.801 9.15325 8.2135 8.74075 8.71766 8.74075C9.22183 8.74075 9.63433 9.15325 9.63433 9.65742C9.63433 10.1616 9.22183 10.5741 8.71766 10.5741ZM16.5093 10.5741C16.5093 11.5916 15.6935 12.4074 14.676 12.4074C13.6585 12.4074 12.8427 11.5916 12.8427 10.5741C12.8335 9.55658 13.6585 8.74075 14.676 8.74075C15.6935 8.74075 16.5093 9.55658 16.5093 10.5741ZM8.71766 15.1666C7.4435 15.1666 5.986 15.6891 5.36266 16.1841C6.6185 17.6966 8.47016 18.6866 10.551 18.8057V16.2574C10.551 14.5249 13.2827 13.7824 14.676 13.7824C15.4827 13.7824 16.7293 14.0391 17.646 14.5799C18.086 13.6358 18.3335 12.5908 18.3335 11.4908C18.3335 7.44825 15.0427 4.15742 11.0002 4.15742C6.95766 4.15742 3.66683 7.44825 3.66683 11.4908C3.66683 12.6183 3.9235 13.6816 4.38183 14.6349C5.61016 13.7366 7.526 13.3241 8.71766 13.3241C9.121 13.3241 9.60683 13.3791 10.1202 13.4708C9.54266 13.9933 9.1485 14.5891 8.9285 15.1758C8.89061 15.1758 8.85272 15.1733 8.81609 15.1709C8.78183 15.1687 8.74868 15.1666 8.71766 15.1666Z" @if (Route::currentRouteName() == 'employee.my_customers' || Route::currentRouteName() == 'employee.my_customer.show') fill="#D71921" @else fill="#9199A4" @endif/>
                            </svg>

                            <span class="aiz-side-nav-text">{{ translate('My Customers') }}</span>
                        </a>
                    </li>

                    <div class="container">
                        <hr>
                    </div>
                @endif

                @if (Auth::user()->user_type == 'reseller')
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('reseller.earnings') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['reseller.earnings']) }}">
                            <svg class="mr-3" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 2.25C6.17 2.25 2.25 6.17 2.25 11C2.25 15.83 6.17 19.75 11 19.75C15.83 19.75 19.75 15.83 19.75 11C19.75 6.17 15.83 2.25 11 2.25ZM11 18C7.14125 18 4 14.8587 4 11C4 7.14125 7.14125 4 11 4C14.8587 4 18 7.14125 18 11C18 14.8587 14.8587 18 11 18ZM9.22375 8.78625C9.22375 9.425 9.7225 9.85375 11.2713 10.2475C12.8113 10.65 14.465 11.315 14.4738 13.24C14.465 14.6488 13.415 15.41 12.085 15.6637V17.125H10.0375V15.6375C8.725 15.3663 7.6225 14.5262 7.535 13.0387H9.04C9.11875 13.8438 9.67 14.4738 11.07 14.4738C12.5663 14.4738 12.9075 13.7212 12.9075 13.2575C12.9075 12.6275 12.5663 12.0238 10.86 11.6213C8.96125 11.1663 7.6575 10.3787 7.6575 8.8125C7.6575 7.49125 8.71625 6.63375 10.0375 6.35375V4.875H12.0763V6.37125C13.4938 6.72125 14.2113 7.7975 14.255 8.97H12.7588C12.7238 8.1125 12.2688 7.535 11.0613 7.535C9.915 7.535 9.22375 8.05125 9.22375 8.78625Z" @if (Route::currentRouteName() != 'reseller.earnings') fill="#9199A4" @else fill="#D71921" @endif/>
                            </svg>

                            <span class="aiz-side-nav-text">{{ translate('My Earnings') }}</span>
                        </a>
                    </li>

                    <li class="aiz-side-nav-item">
                        <a href="{{ route('reseller.customer_orders') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['reseller.customer_orders', 'reseller.customer_orders_returns', 'reseller.show_purchase_history']) }}">
                            <svg class="mr-3" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.425 19.25H3.575C3.11667 19.25 2.75 18.8833 2.75 18.425V3.575C2.75 3.20833 3.11667 2.75 3.575 2.75H18.425C18.7917 2.75 19.25 3.20833 19.25 3.575V18.425C19.25 18.8833 18.7917 19.25 18.425 19.25ZM8.25 15.5833H6.41667V13.75H8.25V15.5833ZM15.5833 15.5833H10.0833V13.75H15.5833V15.5833ZM15.5833 11.9167H10.0833V10.0833H15.5833V11.9167ZM10.0833 8.25H15.5833V6.41667H10.0833V8.25ZM6.41667 11.9167H8.25V10.0833H6.41667V11.9167ZM8.25 8.25H6.41667V6.41667H8.25V8.25ZM4.58333 4.58333H17.4167V17.4167H4.58333V4.58333Z" @if (Route::currentRouteName() == 'reseller.customer_orders' || Route::currentRouteName() == 'reseller.customer_orders_returns' || Route::currentRouteName() == 'reseller.show_purchase_history') fill="#D71921" @else fill="#9199A4" @endif/>
                            </svg>
                            <span class="aiz-side-nav-text">{{ translate('Customer Orders') }}</span>
                        </a>
                    </li>

                    <li class="aiz-side-nav-item">
                        <a href="{{ route('reseller.my_customers') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['reseller.my_customers', 'reseller.my_customer.show']) }}">
                            <svg class="mr-3" width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0002 2.33325C5.94016 2.33325 1.8335 6.43992 1.8335 11.4999C1.8335 16.5599 5.94016 20.6666 11.0002 20.6666C16.0602 20.6666 20.1668 16.5599 20.1668 11.4999C20.1668 6.43992 16.0602 2.33325 11.0002 2.33325ZM11.4677 9.65742C11.4677 8.14492 10.2302 6.90742 8.71766 6.90742C7.20516 6.90742 5.96766 8.14492 5.96766 9.65742C5.96766 11.1699 7.20516 12.4074 8.71766 12.4074C10.2302 12.4074 11.4677 11.1699 11.4677 9.65742ZM8.71766 10.5741C8.2135 10.5741 7.801 10.1616 7.801 9.65742C7.801 9.15325 8.2135 8.74075 8.71766 8.74075C9.22183 8.74075 9.63433 9.15325 9.63433 9.65742C9.63433 10.1616 9.22183 10.5741 8.71766 10.5741ZM16.5093 10.5741C16.5093 11.5916 15.6935 12.4074 14.676 12.4074C13.6585 12.4074 12.8427 11.5916 12.8427 10.5741C12.8335 9.55658 13.6585 8.74075 14.676 8.74075C15.6935 8.74075 16.5093 9.55658 16.5093 10.5741ZM8.71766 15.1666C7.4435 15.1666 5.986 15.6891 5.36266 16.1841C6.6185 17.6966 8.47016 18.6866 10.551 18.8057V16.2574C10.551 14.5249 13.2827 13.7824 14.676 13.7824C15.4827 13.7824 16.7293 14.0391 17.646 14.5799C18.086 13.6358 18.3335 12.5908 18.3335 11.4908C18.3335 7.44825 15.0427 4.15742 11.0002 4.15742C6.95766 4.15742 3.66683 7.44825 3.66683 11.4908C3.66683 12.6183 3.9235 13.6816 4.38183 14.6349C5.61016 13.7366 7.526 13.3241 8.71766 13.3241C9.121 13.3241 9.60683 13.3791 10.1202 13.4708C9.54266 13.9933 9.1485 14.5891 8.9285 15.1758C8.89061 15.1758 8.85272 15.1733 8.81609 15.1709C8.78183 15.1687 8.74868 15.1666 8.71766 15.1666Z" @if (Route::currentRouteName() == 'reseller.my_customers' || Route::currentRouteName() == 'reseller.my_customer.show') fill="#D71921" @else fill="#9199A4" @endif/>
                            </svg>

                            <span class="aiz-side-nav-text">{{ translate('My Customers') }}</span>
                        </a>
                    </li>

                    <div class="container">
                        <hr>
                    </div>
                @endif

                @php
                    $delivery_viewed = App\Order::where('user_id', Auth::user()->id)->where('delivery_viewed', 0)->get()->count();
                    $payment_status_viewed = App\Order::where('user_id', Auth::user()->id)->where('payment_status_viewed', 0)->get()->count();
                @endphp

                <li class="aiz-side-nav-item">
                    <a href="{{ route('purchase_history.index') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['purchase_history.index', 'purchase_history.show', 'purchase_history.upload_receipt', 'refund_request_send_page', 'vendor_refund_request'])}}">
                        <svg class="mr-3" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5625 3.5625L16.25 2.25L14.9375 3.5625L13.625 2.25L12.3125 3.5625L11 2.25L9.6875 3.5625L8.375 2.25L7.0625 3.5625L5.75 2.25L4.4375 3.5625L3.125 2.25V19.75L4.4375 18.4375L5.75 19.75L7.0625 18.4375L8.375 19.75L9.6875 18.4375L11 19.75L12.3125 18.4375L13.625 19.75L14.9375 18.4375L16.25 19.75L17.5625 18.4375L18.875 19.75V2.25L17.5625 3.5625ZM4.875 17.2038V4.79625H17.125V17.2038H4.875ZM16.25 15.375V13.625H5.75V15.375H16.25ZM16.25 10.125V11.875H5.75V10.125H16.25ZM16.25 8.375V6.625H5.75V8.375H16.25Z" @if (Route::currentRouteName() == 'purchase_history.index' || Route::currentRouteName() == 'purchase_history.show' || Route::currentRouteName() == 'purchase_history.upload_receipt') fill="#D71921" @else fill="#9199A4" @endif />
                        </svg>
                        <span class="aiz-side-nav-text">{{ translate('My Purchase History') }}</span>
                    </a>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="{{ route('refund_request_lists') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['refund_request_lists']) }}">
                        <div class="mr-3" style="width: 21px; height: 21px;">
                        </div>
                        <span class="aiz-side-nav-text customer-craft-side-nav-link-subtitle">{{ translate('Returns') }}</span>
                    </a>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="{{ route('declined_orders.index') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['declined_orders.index']) }}">
                        <div class="mr-3" style="width: 21px; height: 21px;">
                        </div>
                        <span class="aiz-side-nav-text customer-craft-side-nav-link-subtitle">{{ translate('Declined Orders') }}</span>
                    </a>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="{{ route('wishlists.index') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['wishlists.index'])}}">
                        <svg class="mr-3" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5116 18.5927L5.20549 13.3621C4.97689 13.1487 3 11.2446 3 8.875C3 5.94289 4.82879 4 7.89394 4C9.22689 4 10.489 4.73707 11.5 5.60991C12.5078 4.73707 13.7731 4 15.1061 4C18.0585 4 20 5.82651 20 8.875C20 10.556 18.9761 12.2209 17.8074 13.3588L17.7945 13.3718L12.4884 18.5927C12.2251 18.8537 11.87 19 11.5 19C11.13 19 10.7749 18.8537 10.5116 18.5927ZM6.28087 12.2468L11.5 17.3933L16.7095 12.2629C17.5884 11.3901 18.4545 10.1196 18.4545 8.875C18.4545 6.71228 17.2246 5.55172 15.1061 5.55172C13.5864 5.55172 12.1182 7.14547 11.5 7.76293C10.9527 7.21336 9.43939 5.55172 7.89394 5.55172C5.77216 5.55172 4.54545 6.71228 4.54545 8.875C4.54545 10.0808 5.40511 11.4256 6.28087 12.2468Z" @if(Route::currentRouteName() == 'wishlists.index') fill="#D71921" @else fill="#9199A4" @endif/>
                        </svg>

                        <span class="aiz-side-nav-text">{{ translate('My Wishlist') }}</span>
                    </a>
                </li>

                @if (\App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('wallet.index') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['wallet.index', 'wallet.request_cash_out', 'wallet.request_cash_in', 'wallet.request_cash_in_pending', 'wallet.query_cash_in'])}}">
                            <svg class="mr-3" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19.292 5.08333V7.17333C19.8328 7.49417 20.2087 8.07167 20.2087 8.75V14.25C20.2087 14.9283 19.8328 15.5058 19.292 15.8267V17.9167C19.292 18.925 18.467 19.75 17.4587 19.75H4.62533C3.60783 19.75 2.79199 18.925 2.79199 17.9167V5.08333C2.79199 4.075 3.60783 3.25 4.62533 3.25H17.4587C18.467 3.25 19.292 4.075 19.292 5.08333ZM11.9587 14.25H18.3753V8.75H11.9587V14.25ZM4.62533 17.9167V5.08333H17.4587V6.91667H11.9587C10.9503 6.91667 10.1253 7.74167 10.1253 8.75V14.25C10.1253 15.2583 10.9503 16.0833 11.9587 16.0833H17.4587V17.9167H4.62533ZM13.3337 11.5C13.3337 10.7406 13.9493 10.125 14.7087 10.125C15.4681 10.125 16.0837 10.7406 16.0837 11.5C16.0837 12.2594 15.4681 12.875 14.7087 12.875C13.9493 12.875 13.3337 12.2594 13.3337 11.5Z" @if(Route::currentRouteName() == 'wallet.index' || Route::currentRouteName() == 'wallet.request_cash_out' || Route::currentRouteName() == 'wallet.request_cash_in' || Route::currentRouteName() == 'wallet.request_cash_in_pending' || Route::currentRouteName() == 'wallet.query_cash_in') fill="#D71921" @else fill="#9199A4" @endif/>
                            </svg>

                            <span class="aiz-side-nav-text">{{translate('My Wallet')}}</span>
                        </a>
                    </li>
                @endif

                <li class="aiz-side-nav-item">
                    <a href="{{ route('profile') }}" class="aiz-side-nav-link customer-craft-side-nav-link {{ areActiveRoutes(['profile'])}}">
                        <svg class="mr-3" width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.5003 3.66663C9.47449 3.66663 7.83366 5.30746 7.83366 7.33329C7.83366 9.35913 9.47449 11 11.5003 11C13.5262 11 15.167 9.35913 15.167 7.33329C15.167 5.30746 13.5262 3.66663 11.5003 3.66663ZM13.3337 7.33329C13.3337 6.32496 12.5087 5.49996 11.5003 5.49996C10.492 5.49996 9.66699 6.32496 9.66699 7.33329C9.66699 8.34163 10.492 9.16663 11.5003 9.16663C12.5087 9.16663 13.3337 8.34163 13.3337 7.33329ZM17.0003 15.5833C16.817 14.9325 13.9753 13.75 11.5003 13.75C9.02533 13.75 6.18366 14.9325 6.00033 15.5925V16.5H17.0003V15.5833ZM4.16699 15.5833C4.16699 13.145 9.05282 11.9166 11.5003 11.9166C13.9478 11.9166 18.8337 13.145 18.8337 15.5833V18.3333H4.16699V15.5833Z" @if(Route::currentRouteName() == 'profile') fill="#D71921" @else fill="#9199A4" @endif/>
                        </svg>

                        <span class="aiz-side-nav-text">{{translate('Manage My Profile')}}</span>
                    </a>
                </li>
            </ul>

            @if (Auth::user()->user_type == 'customer')
                {{-- // Apply as a reseller if not yet a reseller --}}
                <div class="container">
                    <hr>
                    <div class="px-3">
                        <p class="reseller-registration-subtitle">Enjoy exclusive discounts and commisions for every item purchased using your reseller product link with your own <b>reseller panel</b>.</p>
                        <a href="{{ route('reseller.index', ['step' => 1])  }}" class="btn btn-block btn-craft-red">
                            Be a Reseller
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>
    <div class="position-absolute">
        <div class="img-32"></div>
    </div>
</div>
