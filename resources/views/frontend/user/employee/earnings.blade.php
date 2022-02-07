@extends('frontend.layouts.app')

@section('content')

<section class="py-5 bg-lightblue">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <div class="page-title">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6 col-12">
                            <span class="heading heading-6 text-capitalize fw-600 mb-0 text-paragraph-title">
                                {{ translate('My Earnings') }}
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
                                    <li class="active"><a href="{{ route('employee.my_earnings') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('My Earnings') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="reseller-dashboard-subtitle">
                            Convert your earnings to your wallet so you can use it to purchase products.
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 mt-3 mt-md-0">
                        <button type="button" class="btn btn-request-cash-out m-0" style="line-height: 1.7rem !important;" onclick="show_affiliate_withdraw_modal()">
                            <svg class="mr-2" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.375 3.75V5.46C15.8175 5.7225 16.125 6.195 16.125 6.75V11.25C16.125 11.805 15.8175 12.2775 15.375 12.54V14.25C15.375 15.075 14.7 15.75 13.875 15.75H3.375C2.5425 15.75 1.875 15.075 1.875 14.25V3.75C1.875 2.925 2.5425 2.25 3.375 2.25H13.875C14.7 2.25 15.375 2.925 15.375 3.75ZM9.375 11.25H14.625V6.75H9.375V11.25ZM3.375 14.25V3.75H13.875V5.25H9.375C8.55 5.25 7.875 5.925 7.875 6.75V11.25C7.875 12.075 8.55 12.75 9.375 12.75H13.875V14.25H3.375ZM10.5 9C10.5 8.37868 11.0037 7.875 11.625 7.875C12.2463 7.875 12.75 8.37868 12.75 9C12.75 9.62132 12.2463 10.125 11.625 10.125C11.0037 10.125 10.5 9.62132 10.5 9Z" fill="#D73019"/>
                            </svg>

                            Convert to wallet
                        </button>
                    </div>
                </div>
                <hr style="border-color: #C2CBD7 !important">
                <div class="row gutters-10 mb-3">
                    <div class="col-12 col-md-4 mb-2">
                        <div class="cart-craft-count cart-craft-count-primary">
                            <div class="d-flex justify-content-between w-100">
                                <div>
                                    <div class="cart-craft-count-title">
                                        @php
                                            $this_months_earnings = \App\EmployeeEarning::where('employee_id', Auth::user()->id)
                                                ->whereMonth('paid_at', '=', \Carbon\Carbon::now()->month)
                                                ->get();

                                            $total_earnings = 0;

                                            foreach ($this_months_earnings as $key => $earning) {
                                                $total_earnings += $earning->income;
                                            }
                                        @endphp

                                        {{ single_price($total_earnings ?? "N/A") }}
                                    </div>
                                    <div class="cart-craft-count-subtitle">
                                        This month's income
                                    </div>
                                </div>
                                <div>
                                    <div class="float-right d-flex align-items-center h-100">
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.0001 5.7141C12.8442 5.7141 10.2859 8.27239 10.2859 11.4282C10.2859 12.0594 10.7976 12.571 11.4288 12.571C12.06 12.571 12.5716 12.0594 12.5716 11.4282C12.5716 9.5347 14.1066 7.99972 16.0001 7.99972C17.8936 7.99972 19.4286 9.5347 19.4286 11.4282C19.4286 12.0594 19.9403 12.571 20.5714 12.571C21.2026 12.571 21.7143 12.0594 21.7143 11.4282C21.7142 8.27239 19.1559 5.7141 16.0001 5.7141Z" fill="white"/>
                                        <path d="M21.3533 25.477C20.9104 25.0493 20.2083 25.0493 19.7655 25.477L17.1427 28.0975V12.571C17.1427 11.9399 16.6311 11.4282 15.9999 11.4282C15.3687 11.4282 14.857 11.9399 14.857 12.571V28.0975L12.2365 25.477C11.7902 25.0308 11.0668 25.0308 10.6206 25.477C10.1744 25.9232 10.1744 26.6467 10.6206 27.0929L15.1919 31.6642C15.6376 32.1111 16.3613 32.112 16.8081 31.6663C16.8088 31.6656 16.8095 31.665 16.8102 31.6642L21.3815 27.0929C21.8199 26.639 21.8073 25.9154 21.3533 25.477Z" fill="white"/>
                                        <path d="M30.8569 0H1.14338C0.512255 0 0.000595093 0.51166 0.000595093 1.14285V21.7137C0.000595093 22.3449 0.512255 22.8566 1.14344 22.8566H11.4289C12.0601 22.8566 12.5717 22.3449 12.5717 21.7137C12.5717 21.0825 12.0601 20.5709 11.4289 20.5709H7.89754C7.40684 17.6995 5.15764 15.4503 2.28629 14.9596V7.89694C5.15764 7.40624 7.40684 5.15704 7.89754 2.28569H24.1028C24.5935 5.15704 26.8427 7.40624 29.714 7.89694V14.9596C26.8427 15.4503 24.5935 17.6995 24.1028 20.5709H20.5715C19.9403 20.5709 19.4286 21.0825 19.4286 21.7137C19.4286 22.3449 19.9403 22.8566 20.5715 22.8566H30.8569C31.4881 22.8566 31.9997 22.3449 31.9997 21.7137V1.14285C31.9997 0.51166 31.488 0 30.8569 0ZM5.55245 20.5709H2.28622V17.3047C3.88656 17.7209 5.13621 18.9706 5.55245 20.5709ZM2.28622 5.55185V2.28563H5.55245C5.13427 3.88482 3.88542 5.13367 2.28622 5.55185ZM29.714 20.5709H26.4478C26.864 18.9706 28.1137 17.7209 29.714 17.3047V20.5709ZM29.714 5.55185C28.1148 5.13367 26.866 3.88482 26.4478 2.28563H29.714V5.55185Z" fill="white"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-2">
                        <div class="cart-craft-count cart-craft-count-warning">
                            <div class="d-flex justify-content-between w-100">
                                <div>
                                    <div class="cart-craft-count-title">
                                        @php
                                            $last_months_earnings = \App\EmployeeEarning::where('employee_id', Auth::user()->id)
                                                ->whereMonth('paid_at', '=', \Carbon\Carbon::now()->subMonth()->month)
                                                ->get();

                                            $total_earnings = 0;

                                            foreach ($last_months_earnings as $key => $earning) {
                                                $total_earnings += $earning->income;
                                            }
                                        @endphp

                                        {{ single_price($total_earnings ?? "N/A") }}
                                    </div>
                                    <div class="cart-craft-count-subtitle">
                                        Last month's income
                                    </div>
                                </div>
                                <div>
                                    <div class="float-right d-flex align-items-center h-100">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M30 12.8906C30 11.7975 29.2825 10.8366 27.9792 10.1852C26.9344 9.6627 25.5711 9.375 24.1406 9.375C22.7101 9.375 21.3469 9.6627 20.302 10.1852C18.9988 10.8366 18.2812 11.7975 18.2812 12.8906C18.2812 12.9497 18.2838 13.0083 18.2879 13.0664H18.2812V19.026C17.2792 18.5825 16.0471 18.3398 14.7656 18.3398C13.3351 18.3398 11.9719 18.6275 10.927 19.1501C9.62379 19.8015 8.90625 20.7623 8.90625 21.8555C8.90625 21.8752 8.90694 21.8946 8.90739 21.9141H8.90625V26.4844C8.90625 27.5775 9.62379 28.5384 10.927 29.1898C11.9719 29.7123 13.3351 30 14.7656 30C16.1961 30 17.5594 29.7123 18.6042 29.1898C18.923 29.0305 19.2064 28.8524 19.4531 28.6588C19.6999 28.8526 19.9832 29.0305 20.302 29.1898C21.3469 29.7123 22.7101 30 24.1406 30C25.5711 30 26.9344 29.7123 27.9792 29.1898C29.2825 28.5384 30 27.5775 30 26.4844V13.0664H29.9934C29.9975 13.0083 30 12.9497 30 12.8906ZM21.3501 12.2816C22.0654 11.9238 23.0825 11.7188 24.1406 11.7188C25.1987 11.7188 26.2159 11.9238 26.9312 12.2816C27.5301 12.5809 27.6562 12.8501 27.6562 12.8906C27.6562 12.9311 27.5301 13.2003 26.9312 13.4997C26.2159 13.8574 25.1987 14.0625 24.1406 14.0625C23.0825 14.0625 22.0654 13.8574 21.3501 13.4997C20.7511 13.2003 20.625 12.9311 20.625 12.8906C20.625 12.8501 20.7511 12.5809 21.3501 12.2816ZM11.9751 21.2464C12.6904 20.8887 13.7075 20.6836 14.7656 20.6836C15.8114 20.6836 16.8233 20.8967 17.5417 21.2684C18.1059 21.5602 18.2812 21.8438 18.2812 21.9141C18.2812 21.9498 18.1503 22.207 17.5708 22.4867C16.859 22.8303 15.8366 23.0273 14.7656 23.0273C13.7075 23.0273 12.6904 22.8223 11.9751 22.4645C11.3761 22.1651 11.25 21.896 11.25 21.8555C11.25 21.815 11.3761 21.5458 11.9751 21.2464ZM17.5562 27.0934C16.8409 27.4512 15.8237 27.6562 14.7656 27.6562C13.7075 27.6562 12.6904 27.4512 11.9751 27.0934C11.3761 26.7941 11.25 26.5249 11.25 26.4844V24.7096C12.2456 25.1374 13.4779 25.3711 14.7656 25.3711C16.1174 25.3711 17.3213 25.1404 18.2812 24.7366V26.4844C18.2812 26.5249 18.1551 26.7941 17.5562 27.0934ZM26.9312 27.0934C26.2159 27.4512 25.1987 27.6562 24.1406 27.6562C23.0825 27.6562 22.0654 27.4512 21.3501 27.0934C20.7511 26.7938 20.625 26.5249 20.625 26.4844V24.7096C21.6206 25.1374 22.8529 25.3711 24.1406 25.3711C25.4283 25.3711 26.6606 25.1374 27.6562 24.7096V26.4844C27.6562 26.5249 27.5301 26.7938 26.9312 27.0934ZM26.9312 22.4645C26.2159 22.8223 25.1987 23.0273 24.1406 23.0273C23.0825 23.0273 22.0654 22.8223 21.3501 22.4645C20.7511 22.1651 20.625 21.896 20.625 21.8555V20.1979C21.6206 20.6257 22.8529 20.8594 24.1406 20.8594C25.4283 20.8594 26.6606 20.6257 27.6562 20.1979V21.8555C27.6562 21.896 27.5301 22.1651 26.9312 22.4645ZM26.9312 17.9528C26.2159 18.3105 25.1987 18.5156 24.1406 18.5156C23.0825 18.5156 22.0654 18.3105 21.3501 17.9528C20.7511 17.6534 20.625 17.3843 20.625 17.3438V15.7448C21.6206 16.1726 22.8529 16.4062 24.1406 16.4062C25.4283 16.4062 26.6606 16.1726 27.6562 15.7448V17.3438C27.6562 17.3843 27.5301 17.6534 26.9312 17.9528ZM2.34375 22.0312C2.34375 14.7041 12.3841 9.08638 14.0545 8.20312H15.9476C16.2611 8.36769 16.8704 8.69797 17.6521 9.17358C18.105 8.76068 18.6413 8.39516 19.2538 8.08891C19.262 8.08479 19.2705 8.0809 19.2785 8.07678C21.5907 7.817 24.0823 7.0974 25.8051 5.38765C27.1889 4.01436 27.8906 2.20161 27.8906 0H25.5469C25.5469 1.57585 25.0914 2.79419 24.1541 3.72414C22.9456 4.92325 20.8525 5.64972 18.1771 5.82047L20.5078 1.5905V0H9.49219V1.5905L12.2166 6.53503C10.9966 7.22328 8.86574 8.52928 6.71585 10.3388C4.79897 11.9527 3.26523 13.6359 2.15744 15.3413C0.726013 17.5452 0 19.7962 0 22.0312C0 25.1292 0.947113 27.2495 2.89581 28.5136C4.3293 29.4436 6.1805 29.7874 7.99004 29.9217C7.29378 29.1962 6.83601 28.3438 6.65291 27.4157C3.74428 26.9355 2.34375 25.6 2.34375 22.0312ZM17.4168 2.34375L15.4797 5.85938H14.5205L12.5832 2.34375H17.4168Z" fill="white"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-2">
                        <div class="cart-craft-count cart-craft-count-success">
                            <div class="d-flex justify-content-between w-100">
                                <div>
                                    <div class="cart-craft-count-title">
                                        {{ single_price(Auth::user()->affiliate_user->balance ?? "N/A") }}
                                    </div>
                                    <div class="cart-craft-count-subtitle">
                                        Current Balance
                                    </div>
                                </div>
                                <div>
                                    <div class="float-right d-flex align-items-center h-100">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M29 0C28.699 0 1.66318 0 1.00002 0C0.447715 0 0 0.447715 0 1.00002V29C0 29.5523 0.447715 30 1.00002 30C1.29562 30 28.3242 30 29 30C29.5523 30 30.0001 29.5523 30.0001 29V1.00002C30 0.447715 29.5523 0 29 0ZM19 6H22.1713C22.4732 6.85119 23.1488 7.52689 24 7.82865V10.1714C23.1488 10.4732 22.4731 11.1489 22.1713 12.0001H19V6ZM11 28H1.99998V26H11V28ZM11 24H1.99998V22H11V24ZM11 20H1.99998V18H11V20ZM11 12H7.82865C7.52684 11.1488 6.85119 10.4731 6 10.1713V7.82865C6.85119 7.52684 7.52689 6.85119 7.82865 6H11V12ZM11 4.00002H6.99996C6.44771 4.00002 5.99994 4.44773 5.99994 5.00004C5.99994 5.55147 5.55135 6.00006 4.99992 6.00006C4.44768 6.00006 3.9999 6.44777 3.9999 7.00008V11.0001C3.9999 11.5523 4.44762 12.0001 4.99992 12.0001C5.55135 12.0001 5.99994 12.4487 5.99994 13.0001C5.99994 13.5524 6.44766 14.0002 6.99996 14.0002H11C11 14.7239 11 15.2764 11 16.0001H1.99998V1.99998H11V4.00002ZM17 28H13C13 27.2796 13 18.3255 13 18H17C17 18.3254 17 27.2796 17 28ZM17 16H13C13 15.4724 13 2.52721 13 2.00004H17C17 2.52732 17 15.4728 17 16ZM28 28H19V26H28V28ZM28 24H19V22H28V24ZM28 20H19V18H28V20ZM28 16H19C19 15.2763 19 14.7237 19 14H23C23.5523 14 24.0001 13.5523 24.0001 13C24.0001 12.4486 24.4487 12 25.0001 12C25.5523 12 26.0001 11.5523 26.0001 11V6.99996C26.0001 6.44771 25.5524 5.99994 25.0001 5.99994C24.4487 5.99994 24.0001 5.55135 24.0001 4.99992C24.0001 4.44768 23.5523 3.9999 23 3.9999H19V1.99998H28V16Z" fill="white"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="d-flex align-items-start">
                    <a href="{{ route('employee.my_earnings') }}" class="card-tab card-tab-active mr-3 mobile-card-text">
                        Earned from my customers
                    </a>

                    <a href="{{ route('employee.my_earnings_reseller') }}" class="card-tab mr-3 mobile-card-text">
                        Earned from my resellers
                    </a>
                </div>
                <div class="card card-craft-min-height border-0 shadow-none card-mobile-res1">
                    <div class="card-body overflow-auto">

                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <form class="" action="" method="GET">
                                    <div class="form-group position-relative">
                                        <input type="text" name="search" id="search" class="form-control form-control-lg" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="Search order code or customers">
                                        <button type="submit" class="p-0 border-0">
                                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg" style="top: 7px; right: 2px; position: absolute; background: #fff; width: 25px; margin: 10px 5px;">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7179 10.8121H12.4421L17.0163 15.3954L15.6504 16.7613L11.0671 12.1871V11.4629L10.8196 11.2063C9.7746 12.1046 8.41793 12.6454 6.9421 12.6454C3.65126 12.6454 0.983765 9.97793 0.983765 6.68709C0.983765 3.39626 3.65126 0.72876 6.9421 0.72876C10.2329 0.72876 12.9004 3.39626 12.9004 6.68709C12.9004 8.16293 12.3596 9.51959 11.4613 10.5646L11.7179 10.8121ZM2.8171 6.68709C2.8171 8.96959 4.6596 10.8121 6.9421 10.8121C9.2246 10.8121 11.0671 8.96959 11.0671 6.68709C11.0671 4.40459 9.2246 2.56209 6.9421 2.56209C4.6596 2.56209 2.8171 4.40459 2.8171 6.68709Z" fill="#62616A"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="earning-label">
                                    Total revenue from customers
                                </div>
                                <div class="earning-price">
                                    @php
                                        $total_revenue = \App\EmployeeEarning::where('employee_id', Auth::user()->id)
                                            ->where('type', 'customer_earning')
                                            ->get();

                                        $total = 0;

                                        foreach ($total_revenue as $key => $value) {
                                            $total += $value->income;
                                        }
                                    @endphp

                                    {{ single_price($total) ?? "N/A" }}
                                </div>
                            </div>
                        </div>

                        @if (count($earnings) != 0)
                            {{-- // Table --}}
                            <div class="table-responsive">
                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="table-header">Customer</th>
                                            <th class="table-header">Order Code</th>
                                            <th class="table-header">Date Paid</th>
                                            <th class="table-header">Amount</th>
                                            <th class="table-header">Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($earnings as $key => $earning)
                                            <tr>
                                                <td class="table-data">
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-2">
                                                            @if ($earning->avatar_original != null)
                                                                <img src="{{ uploaded_asset($earning->avatar_original ?? "N/A") }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                            @else
                                                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                            @endif
                                                        </div>
                                                        <div>
                                                            {{ $earning->name ?? "N/A" }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="table-data">
                                                    <a href="{{ route('employee.my_earnings_customer.order_show', encrypt($earning->id ?? "N/A")) }}">
                                                        {{ $earning->code ?? "N/A" }}
                                                    </a>
                                                </td>
                                                <td class="table-data">{{ date('d-m-Y', strtotime($earning->paid_at ?? "N/A")) }}</td>
                                                <td class="table-data">{{ single_price($earning->amount ?? "N/A") }}</td>
                                                <td class="table-data">
                                                    <span class="text-success">
                                                        + {{ single_price($earning->income ?? "N/A") }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                                <div class="text-center">
                                    <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0)">
                                    <path d="M16.947 39.7451C18.8439 38.2577 22.8532 31.5 31.7766 31.5H45.7734V36.2112C45.7735 36.3886 45.8214 36.5627 45.9122 36.7151C46.0031 36.8674 46.1334 36.9924 46.2894 37.0769C46.4454 37.1613 46.6213 37.202 46.7986 37.1946C46.9758 37.1873 47.1478 37.1322 47.2963 37.0351L62.5541 27.0703C62.6912 26.9809 62.8038 26.8586 62.8818 26.7147C62.9597 26.5707 63.0006 26.4096 63.0006 26.2459C63.0006 26.0822 62.9597 25.9211 62.8818 25.7771C62.8038 25.6332 62.6912 25.5109 62.5541 25.4215L47.2963 15.4547C47.1477 15.3576 46.9756 15.3025 46.7983 15.2952C46.621 15.2879 46.445 15.3287 46.289 15.4132C46.1329 15.4977 46.0026 15.6229 45.9119 15.7754C45.8211 15.9279 45.7733 16.1021 45.7734 16.2796V20.9898H33.328C28.5375 20.9953 23.9448 22.9006 20.5572 26.2878C17.1696 29.675 15.2638 34.2675 15.2578 39.058C15.2578 39.2538 15.3162 39.4451 15.4255 39.6075C15.5348 39.7699 15.69 39.896 15.8713 39.9697C16.0526 40.0435 16.2518 40.0615 16.4434 40.0215C16.635 39.9815 16.8104 39.8853 16.947 39.7451Z" fill="#FFCFD1"/>
                                    <path d="M61.3108 38.5471C59.412 40.0355 55.4046 46.7932 46.4812 46.7932H32.4844V42.081C32.4842 41.9037 32.4361 41.7298 32.3452 41.5775C32.2543 41.4253 32.124 41.3004 31.968 41.2161C31.812 41.1318 31.6362 41.0912 31.459 41.0986C31.2819 41.106 31.11 41.1611 30.9616 41.2581L15.7038 51.2249C15.5671 51.3144 15.4548 51.4366 15.3771 51.5803C15.2995 51.7241 15.2588 51.8849 15.2588 52.0483C15.2588 52.2117 15.2995 52.3725 15.3771 52.5163C15.4548 52.6601 15.5671 52.7822 15.7038 52.8717L30.9616 62.8385C31.11 62.9355 31.2819 62.9906 31.459 62.998C31.6362 63.0054 31.812 62.9648 31.968 62.8805C32.124 62.7962 32.2543 62.6714 32.3452 62.5191C32.4361 62.3669 32.4842 62.1929 32.4844 62.0156V57.3044H44.9299C49.7207 57.2989 54.3137 55.3933 57.7014 52.0057C61.089 48.6181 62.9946 44.025 63 39.2342C63 39.0385 62.9416 38.8472 62.8324 38.6848C62.7231 38.5224 62.5679 38.3962 62.3865 38.3225C62.2052 38.2487 62.006 38.2307 61.8144 38.2707C61.6228 38.3107 61.4475 38.407 61.3108 38.5471Z" fill="#FFCFD1"/>
                                    <path d="M44.7891 0H2.95312C2.16991 0 1.41877 0.311132 0.86495 0.86495C0.311132 1.41877 0 2.16991 0 2.95312L0 28.5469C0 29.3301 0.311132 30.0812 0.86495 30.635C1.41877 31.1889 2.16991 31.5 2.95312 31.5H44.7891C45.5723 31.5 46.3234 31.1889 46.8772 30.635C47.4311 30.0812 47.7422 29.3301 47.7422 28.5469V2.95312C47.7422 2.16991 47.4311 1.41877 46.8772 0.86495C46.3234 0.311132 45.5723 0 44.7891 0V0ZM1.96875 2.95312C1.96875 2.69205 2.07246 2.44167 2.25707 2.25707C2.44167 2.07246 2.69205 1.96875 2.95312 1.96875H8.79145C8.57061 3.70108 7.78076 5.31104 6.5459 6.5459C5.31104 7.78076 3.70108 8.57061 1.96875 8.79145V2.95312ZM2.95312 29.5312C2.69205 29.5312 2.44167 29.4275 2.25707 29.2429C2.07246 29.0583 1.96875 28.8079 1.96875 28.5469V22.7085C3.70108 22.9294 5.31104 23.7192 6.5459 24.9541C7.78076 26.189 8.57061 27.7989 8.79145 29.5312H2.95312ZM45.7734 28.5469C45.7734 28.8079 45.6697 29.0583 45.4851 29.2429C45.3005 29.4275 45.0501 29.5312 44.7891 29.5312H38.9507C39.1716 27.7989 39.9614 26.189 41.1963 24.9541C42.4311 23.7192 44.0411 22.9294 45.7734 22.7085V28.5469ZM45.7734 20.7221C43.5154 20.952 41.4059 21.954 39.801 23.5589C38.1962 25.1638 37.1942 27.2733 36.9643 29.5312H10.7799C10.5499 27.273 9.54764 25.1632 7.94235 23.5583C6.33706 21.9534 4.22709 20.9516 1.96875 20.7221V10.7799C4.22704 10.5499 6.33678 9.54764 7.94172 7.94235C9.54665 6.33706 10.5484 4.22709 10.7779 1.96875H36.9623C37.1923 4.22704 38.1945 6.33678 39.7998 7.94172C41.4051 9.54665 43.5151 10.5484 45.7734 10.7779V20.7221ZM45.7734 8.79145C44.0411 8.57061 42.4311 7.78076 41.1963 6.5459C39.9614 5.31104 39.1716 3.70108 38.9507 1.96875H44.7891C45.0501 1.96875 45.3005 2.07246 45.4851 2.25707C45.6697 2.44167 45.7734 2.69205 45.7734 2.95312V8.79145Z" fill="#1B1464"/>
                                    <path d="M23.8711 7.13672C22.1676 7.13672 20.5023 7.64188 19.0858 8.58832C17.6694 9.53476 16.5654 10.88 15.9135 12.4538C15.2615 14.0277 15.091 15.7596 15.4233 17.4304C15.7557 19.1012 16.576 20.6359 17.7806 21.8405C18.9852 23.0451 20.5199 23.8654 22.1907 24.1978C23.8615 24.5301 25.5934 24.3596 27.1673 23.7076C28.7411 23.0557 30.0863 21.9517 31.0328 20.5353C31.9792 19.1188 32.4844 17.4535 32.4844 15.75C32.4818 13.4664 31.5735 11.2771 29.9587 9.66237C28.344 8.04763 26.1547 7.13932 23.8711 7.13672ZM23.8711 22.3945C22.5569 22.3945 21.2723 22.0048 20.1796 21.2747C19.0869 20.5446 18.2353 19.5069 17.7324 18.2928C17.2294 17.0786 17.0979 15.7426 17.3542 14.4537C17.6106 13.1648 18.2435 11.9809 19.1727 11.0516C20.102 10.1224 21.2859 9.48952 22.5748 9.23314C23.8637 8.97676 25.1997 9.10834 26.4138 9.61125C27.628 10.1142 28.6657 10.9658 29.3958 12.0585C30.1259 13.1512 30.5156 14.4358 30.5156 15.75C30.5135 17.5116 29.8128 19.2005 28.5672 20.4461C27.3215 21.6917 25.6327 22.3924 23.8711 22.3945Z" fill="#D71921"/>
                                    <path d="M37.2832 15.75C37.2832 16.0111 37.3869 16.2615 37.5715 16.4461C37.7561 16.6307 38.0065 16.7344 38.2676 16.7344H41.2207C41.4818 16.7344 41.7322 16.6307 41.9168 16.4461C42.1014 16.2615 42.2051 16.0111 42.2051 15.75C42.2051 15.4889 42.1014 15.2385 41.9168 15.0539C41.7322 14.8693 41.4818 14.7656 41.2207 14.7656H38.2676C38.0065 14.7656 37.7561 14.8693 37.5715 15.0539C37.3869 15.2385 37.2832 15.4889 37.2832 15.75Z" fill="#1B1464"/>
                                    <path d="M9.47461 14.7656H6.52148C6.26041 14.7656 6.01003 14.8693 5.82543 15.0539C5.64082 15.2385 5.53711 15.4889 5.53711 15.75C5.53711 16.0111 5.64082 16.2615 5.82543 16.4461C6.01003 16.6307 6.26041 16.7344 6.52148 16.7344H9.47461C9.73568 16.7344 9.98606 16.6307 10.1707 16.4461C10.3553 16.2615 10.459 16.0111 10.459 15.75C10.459 15.4889 10.3553 15.2385 10.1707 15.0539C9.98606 14.8693 9.73568 14.7656 9.47461 14.7656Z" fill="#1B1464"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0">
                                    <rect width="63" height="63" fill="white"/>
                                    </clipPath>
                                    </defs>
                                    </svg>

                                    <h3 class="cart-craft-text mb-0 mt-3">
                                        Your wallet history is empty.
                                    </h3>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="aiz-paginate">
                    {{ $earnings->appends(request()->input())->links() ?? "N/A" }}
                </div>
            </div>
        </div>
    </div>
</section>

@section('modal')
    <div class="modal fade" id="affiliate_withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="" action="{{ route('reseller.convert_earnings') }}" method="post">
                    @csrf
                    <div class="modal-body gry-bg px-4 pt-4">
                        <div class="modal-header-title mb-3">
                            Convert to wallet
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label modal-label mb-2">Enter amount:</label>
                            <input type="number" class="form-control form-control-lg mb-3" name="amount" placeholder="{{ translate('Amount')}}">
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-craft-primary transition-3d-hover mr-1">{{translate('Confirm Amount')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function show_affiliate_withdraw_modal(){
            $('#affiliate_withdraw_modal').modal('show');
        }

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

    </script>
@endsection

@endsection
