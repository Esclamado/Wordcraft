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
                                {{ translate('Employee Panel') }}
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
                                    <li class="active"><a href="{{ route('dashboard') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('Dashboard') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card --}}
                <div class="row gutters-10 mb-3">
                    <div class="col-12 col-md-4 mb-2">
                        <div class="cart-craft-count cart-craft-count-primary">
                            <div class="d-flex justify-content-between w-100">
                                <div>
                                    <div class="cart-craft-count-title">
                                        @php
                                            $total_referred_resellers = \App\EmployeeReseller::where('employee_id', Auth::user()->id)->count();
                                        @endphp

                                        {{ $total_referred_resellers ?? "N/A" }}
                                    </div>
                                    <div class="cart-craft-count-subtitle">
                                        Total referred resellers
                                    </div>
                                </div>
                                <div>
                                    <div class="float-right d-flex align-items-center h-100">
                                        <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M25.1875 12.2709L17.4375 4.52091L15.6033 6.35508L20.2404 10.9792H5.8125V26.4792H8.39583V13.5626H20.2404L15.6033 18.1867L17.4375 20.0209L25.1875 12.2709Z" fill="white"/>
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
                                            $employee_reseller_ids = \App\EmployeeReseller::where('employee_id', Auth::user()->id)
                                                ->pluck('reseller_id');

                                            $total_unverified_resellers = \App\Reseller::whereIn('user_id', $employee_reseller_ids)
                                                ->where('is_verified', 0)
                                                ->count();
                                        @endphp
                                        {{ $total_unverified_resellers ?? "N/A" }}
                                    </div>
                                    <div class="cart-craft-count-subtitle">
                                        Total unverified resellers
                                    </div>
                                </div>
                                <div>
                                    <div class="float-right d-flex align-items-center h-100">
                                        <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.4872 2.58325C8.35725 2.58325 2.5835 8.36992 2.5835 15.4999C2.5835 22.6299 8.35725 28.4166 15.4872 28.4166C22.6302 28.4166 28.4168 22.6299 28.4168 15.4999C28.4168 8.36992 22.6302 2.58325 15.4872 2.58325ZM15.5002 25.8333C9.791 25.8333 5.16683 21.2091 5.16683 15.4999C5.16683 9.79075 9.791 5.16659 15.5002 5.16659C21.2093 5.16659 25.8335 9.79075 25.8335 15.4999C25.8335 21.2091 21.2093 25.8333 15.5002 25.8333ZM14.2085 9.04158H16.146V15.8228L21.9585 19.2716L20.9897 20.8603L14.2085 16.7916V9.04158Z" fill="#F2F5FA"/>
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
                                        @php
                                            $employee_reseller_ids = \App\EmployeeReseller::where('employee_id', Auth::user()->id)
                                                ->pluck('reseller_id');

                                            $total_verified_resellers = \App\Reseller::whereIn('user_id', $employee_reseller_ids)
                                                ->where('is_verified', 1)
                                                ->count();
                                        @endphp
                                        {{ $total_verified_resellers ?? "N/A" }}
                                    </div>
                                    <div class="cart-craft-count-subtitle">
                                        Total verified resellers
                                    </div>
                                </div>
                                <div>
                                    <div class="float-right d-flex align-items-center h-100">
                                        <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5002 2.58325C8.37016 2.58325 2.5835 8.36992 2.5835 15.4999C2.5835 22.6299 8.37016 28.4166 15.5002 28.4166C22.6302 28.4166 28.4168 22.6299 28.4168 15.4999C28.4168 8.36992 22.6302 2.58325 15.5002 2.58325ZM15.5002 25.8333C9.80391 25.8333 5.16683 21.1962 5.16683 15.4999C5.16683 9.80367 9.80391 5.16659 15.5002 5.16659C21.1964 5.16659 25.8335 9.80367 25.8335 15.4999C25.8335 21.1962 21.1964 25.8333 15.5002 25.8333ZM12.9168 18.3028L21.4289 9.79075L23.2502 11.6249L12.9168 21.9583L7.75016 16.7916L9.57141 14.9703L12.9168 18.3028Z" fill="white"/>
                                        </svg>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-8 order-2 order-md-1">
                        <div class="card card-craft-min-height mt-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between border-bottom">
                                    <div class="card-customer-wallet-title">
                                        My top 5 resellers
                                    </div>
                                    <div class="card-link">
                                        <a href="{{ route('employee.my_resellers') }}">View all</a>
                                    </div>
                                </div>

                                @php
                                    $resellers = \App\EmployeeReseller::where('employee_id', Auth::user()->id)
                                        ->where('total_earnings', '!=', 0.00)
                                        ->orderBy('total_earnings', 'desc')
                                        ->take(5)
                                        ->get();
                                @endphp

                                @if (count($resellers) != 0)
                                    <div>
                                        <table class="table aiz-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="table-header">{{ translate('Resellers') }}</th>
                                                    <th class="table-header text-center">{{ translate('Total Successful Orders') }}</th>
                                                    <th class="table-header">{{ translate('Total Earnings') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($resellers as $key => $value)
                                                    <tr>
                                                        <td class="table-data">
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-2">
                                                                    @if ($value->reseller)
                                                                        @if ($value->reseller->avatar_original != null)
                                                                            <img src="{{ uploaded_asset($value->reseller->avatar_original ?? "N/A" ) }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                        @else
                                                                            <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    {{ $value->reseller->name ?? "N/A" }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="table-data text-center">
                                                            {{ $value->total_successful_orders ?? "N/A" }}
                                                        </td>
                                                        <td class="table-data">
                                                            {{ single_price($value->total_earnings ?? "N/A" ) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div>
                                        <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                                            <div class="text-center">
                                                <svg width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0)">
                                                <path d="M28.3212 57.3052C36.9583 57.262 43.9251 50.2248 43.8819 41.5871C43.8387 32.9494 36.8019 25.9821 28.1648 26.0253C19.5277 26.0685 12.5609 33.1058 12.6041 41.7435C12.6473 50.3812 19.6841 57.3484 28.3212 57.3052Z" fill="#FFCFD1"/>
                                                <path d="M31.6878 40.4853C35.7392 40.4853 39.0353 37.189 39.0353 33.1374C39.0353 29.0858 35.7392 25.7896 31.6878 25.7896C27.6363 25.7896 24.3403 29.0857 24.3403 33.1374C24.3403 37.189 27.6363 40.4853 31.6878 40.4853ZM31.6878 28.4458C34.2746 28.4458 36.379 30.5505 36.379 33.1374C36.379 35.7243 34.2745 37.829 31.6878 37.829C29.101 37.829 26.9966 35.7243 26.9966 33.1374C26.9966 30.5503 29.101 28.4458 31.6878 28.4458Z" fill="#1B1464"/>
                                                <path d="M53.7291 49.3379C51.7225 49.3379 49.8679 50.0016 48.3732 51.1208L43.9179 46.6651C46.3289 43.8088 47.7163 40.1481 47.7163 36.3126C47.7163 32.3705 46.285 28.7568 43.916 25.962L47.7024 22.1752C48.221 21.6566 48.221 20.8156 47.7024 20.297C47.1836 19.7784 46.3426 19.7784 45.824 20.2971L42.0378 24.0837C39.2431 21.7145 35.6297 20.2832 31.6877 20.2832C27.7457 20.2832 24.1323 21.7145 21.3377 24.0836L14.4206 17.1661C15.1204 16.1121 15.5288 14.8485 15.5288 13.4913C15.5288 9.81823 12.5408 6.83008 8.86798 6.83008C5.19519 6.83008 2.20704 9.81836 2.20704 13.4913C2.20704 17.1642 5.19519 20.1525 8.86798 20.1525C10.2251 20.1525 11.4885 19.7441 12.5425 19.0443L19.4598 25.9619C17.0907 28.7566 15.6594 32.3703 15.6594 36.3126C15.6594 40.1481 17.0467 43.8088 19.4578 46.6652L12.8792 53.2442C11.5438 52.2852 9.90777 51.7198 8.1419 51.7198C3.6535 51.7198 0.00195312 55.3715 0.00195312 59.8601C0.00195312 64.3488 3.65337 68.0003 8.14177 68.0003C12.6302 68.0003 16.2817 64.3485 16.2817 59.86C16.2817 58.0941 15.7162 56.4579 14.7573 55.1224L21.3331 48.5462C22.0587 49.1623 22.8437 49.718 23.683 50.2027C26.1066 51.6022 28.8746 52.342 31.6877 52.342C34.5009 52.342 37.2689 51.6022 39.6924 50.2027C40.5317 49.718 41.3167 49.1623 42.0423 48.5462L46.5048 53.009C45.4181 54.4909 44.7753 56.3177 44.7753 58.2921C44.7753 63.2294 48.792 67.2462 53.729 67.2462C58.666 67.2462 62.6825 63.2294 62.6825 58.2921C62.6827 53.3547 58.6662 49.3379 53.7291 49.3379ZM4.86302 13.4913C4.86302 11.283 6.65944 9.48633 8.86772 9.48633C11.0759 9.48633 12.8723 11.283 12.8723 13.4913C12.8723 15.6996 11.0759 17.4963 8.86772 17.4963C6.65958 17.4963 4.86302 15.6996 4.86302 13.4913ZM31.6877 22.9394C39.0613 22.9394 45.0601 28.9386 45.0601 36.3126C45.0601 40.2547 43.3031 43.9757 40.3565 46.4936V44.607C40.3565 42.7682 38.8605 41.2722 37.0218 41.2722H26.3538C24.5149 41.2722 23.019 42.7682 23.019 44.607V46.4936C20.0724 43.9757 18.3155 40.2547 18.3155 36.3126C18.3153 28.9386 24.3141 22.9394 31.6877 22.9394ZM8.14177 65.3441C5.11802 65.3441 2.65807 62.884 2.65807 59.86C2.65807 56.8361 5.11816 54.3759 8.14177 54.3759C11.1654 54.3759 13.6255 56.836 13.6255 59.86C13.6255 62.884 11.1654 65.3441 8.14177 65.3441ZM37.7001 48.2609C35.8449 49.1951 33.7817 49.6859 31.6877 49.6859C29.5936 49.6859 27.5304 49.1951 25.6751 48.2609V44.6071C25.6751 44.233 25.9795 43.9286 26.3537 43.9286H37.0216C37.3956 43.9286 37.7 44.233 37.7 44.6071V48.2609H37.7001ZM53.7291 64.5898C50.2566 64.5898 47.4317 61.7646 47.4317 58.292C47.4317 54.8194 50.2567 51.9942 53.7291 51.9942C57.2015 51.9942 60.0264 54.8194 60.0264 58.292C60.0264 61.7646 57.2014 64.5898 53.7291 64.5898Z" fill="#1B1464"/>
                                                <path d="M49.5733 10.1675L52.8265 13.4211L49.5733 16.6745C49.0895 17.1586 49.0895 17.9427 49.5733 18.4268C49.8151 18.6686 50.1321 18.7896 50.449 18.7896C50.7663 18.7896 51.0833 18.6688 51.3249 18.4268L54.5788 15.173L57.8325 18.4268C58.0742 18.6686 58.3913 18.7895 58.7084 18.7895C59.0254 18.7895 59.3422 18.6687 59.5842 18.4268C60.0681 17.9429 60.0681 17.1587 59.5842 16.6745L56.3311 13.4211L59.5843 10.1675C60.0682 9.68362 60.0682 8.89928 59.5843 8.41538C59.1005 7.93185 58.3167 7.93185 57.8327 8.41538L54.5789 11.6689L51.3253 8.41538C50.8412 7.93185 50.0572 7.93185 49.5735 8.41538C49.0895 8.89928 49.0895 9.68362 49.5733 10.1675Z" fill="#CE141C"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0">
                                                <rect width="68" height="68" fill="white"/>
                                                </clipPath>
                                                </defs>
                                                </svg>
                                                <h3 class="cart-craft-text mb-0 mt-3">
                                                    You have no resellers yet.
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 order-1 order-md-2">
                        <div class="card mt-2">
                            <div class="py-4 border-bottom text-center">
                                <div class="reseller-income-subtitle">
                                    {{ translate("This month's income") }}
                                </div>
                                <div class="reseller-income-amount">
                                    @php
                                        $this_months_earning = \App\EmployeeEarning::where('employee_id', Auth::user()->id)
                                            ->whereMonth('paid_at', '=', \Carbon\Carbon::now()->month)
                                            ->get();

                                        $total_months_earning = 0;

                                        foreach ($this_months_earning as $key => $value) {
                                            $total_months_earning += $value->income;
                                        }
                                    @endphp

                                    {{ single_price($total_months_earning ?? "N/A" ) }}
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="reseller-income-subtitle mb-3">
                                        <div class="row">
                                            <div class="col-md-10 d-flex">
                                                <div class="">
                                                    <svg class="mr-2" width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="3" cy="3" r="3" fill="#D71921"/>
                                                    </svg>
                                                </div>
                                                <div class="">
                                                    Total income
    
                                                    <div class="reseller-earning-subtitle">
                                                        @php
                                                            $total_earnings = \App\EmployeeEarning::where('employee_id', Auth::user()->id)->get();
                                                            $total_revenue = 0;
    
                                                            foreach ($total_earnings as $key => $earning) {
                                                                $total_revenue += $earning->income;
                                                            }
                                                        @endphp
    
                                                        {{ single_price($total_revenue ?? "N/A" ) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="reseller-income-subtitle">
                                        <div class="row">
                                            <div class="col-md-10 d-flex">
                                                <div class="">
                                                    <svg class="mr-2" width="6" height="6" viewBox="0 0 6 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="3" cy="3" r="3" fill="#D71921"/>
                                                    </svg>
                                                </div>
                                                <div class="">
                                                    Last month income
    
                                                    <div class="reseller-earning-subtitle">
                                                        @php
                                                            $last_months_earnings = \App\EmployeeEarning::where('employee_id', Auth::user()->id)
                                                                ->whereMonth('paid_at', '=', \Carbon\Carbon::now()->subMonth()->month)
                                                                ->get();
    
                                                            $total_earnings = 0;
    
                                                            foreach ($last_months_earnings as $key => $earning) {
                                                                $total_earnings += $earning->income;
                                                            }
                                                        @endphp
    
                                                        {{ single_price($total_earnings ?? "N/A" ) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $orders = \App\Order::where('user_id', Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();
                @endphp

                <div class="row mt-3">
                    <div class="col-12">
                        @if (count($orders))
                            <h1 class="customer-craft-dashboard-subtitle mb-3">{{ translate('My recent purchase') }}</h1>

                            @foreach ($orders as $key => $order)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6 class="customer-craft-dashboard-card-title mb-0">
                                                    Order Code: <span style="color: #161DBC;">{{ $order->code ?? "N/A" }}</span>
                                                </h6>
                                            </div>

                                            <div class="col-6">
                                                <a href="{{ route('purchase_history.show', encrypt($order->id ?? "N/A" )) }}" class="customer-craft-dashboard-card-subtitle float-md-right mt-2 mt-md-0 d-flex justify-content-end">View Order Details</a>
                                            </div>
                                        </div>

                                        <hr>
                                        @foreach ($order->orderDetails as $key => $orderDetail)
                                            <div class="row mb-3">
                                                <div class="col-3 col-lg-1">
                                                    @php
                                                        $product_image = null;

                                                        if ($orderDetail->product != null) {
                                                            if ($orderDetail->variation != "") {
                                                                $product_image = \App\ProductStock::where('product_id', $orderDetail->product_id)
                                                                    ->where('variant', $orderDetail->variation)
                                                                    ->first();

                                                                if ($product_image != null) {
                                                                    $product_image = uploaded_asset($product_image->image);
                                                                }

                                                                else {
                                                                    $product_image = uploaded_asset($orderDetail->product->thumbnail_img);    
                                                                }
                                                            }

                                                            else {
                                                                $product_image = uploaded_asset($orderDetail->product->thumbnail_img);
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
                                                        @if ($orderDetail->product != null)
                                                            <a href="{{ route('product', $orderDetail->product->slug ?? "N/A" ) }}" target="_blank">
                                                                {{ $orderDetail->product->getTranslation('name') ?? "N/A" }}

                                                                @if ($orderDetail->variation != null)
                                                                    - {{ $orderDetail->variation }}
                                                                @endif
                                                                
                                                                @if ($orderDetail->order_type == 'same_day_pickup')
                                                                    <div class="d-block craft-purchase-history-pickup-time">
                                                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.49967 1.08337C3.50967 1.08337 1.08301 3.51004 1.08301 6.50004C1.08301 9.49004 3.50967 11.9167 6.49967 11.9167C9.48967 11.9167 11.9163 9.49004 11.9163 6.50004C11.9163 3.51004 9.48967 1.08337 6.49967 1.08337ZM6.49967 10.8334C4.11092 10.8334 2.16634 8.88879 2.16634 6.50004C2.16634 4.11129 4.11092 2.16671 6.49967 2.16671C8.88842 2.16671 10.833 4.11129 10.833 6.50004C10.833 8.88879 8.88842 10.8334 6.49967 10.8334ZM5.41634 7.67546L8.98592 4.10587L9.74967 4.87504L5.41634 9.20837L3.24967 7.04171L4.01342 6.27796L5.41634 7.67546Z" fill="#10865C"/>
                                                                        </svg>

                                                                        {{ translate('Same day pickup') }}
                                                                    </div>

                                                                @else
                                                                    <div class="d-block craft-purchase-history-advance-order">
                                                                        <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49475 0.083313C2.50475 0.083313 0.0834961 2.50998 0.0834961 5.49998C0.0834961 8.48998 2.50475 10.9166 5.49475 10.9166C8.49016 10.9166 10.9168 8.48998 10.9168 5.49998C10.9168 2.50998 8.49016 0.083313 5.49475 0.083313ZM5.50016 9.83331C3.106 9.83331 1.16683 7.89415 1.16683 5.49998C1.16683 3.10581 3.106 1.16665 5.50016 1.16665C7.89433 1.16665 9.8335 3.10581 9.8335 5.49998C9.8335 7.89415 7.89433 9.83331 5.50016 9.83331ZM4.9585 2.79165H5.771V5.6354L8.2085 7.08165L7.80225 7.7479L4.9585 6.04165V2.79165Z" fill="#E49F1A"/>
                                                                        </svg>

                                                                        {{ translate('Advance order') }}
                                                                    </div>
                                                                @endif
                                                            </a>
                                                        @else
                                                            <strong>{{  translate('Product Unavailable') }}</strong>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-2 d-flex align-items-center justify-content-end">
                                                    <div class="craft-purchase-history-quantity">
                                                        <span class="opacity-50">Qty: </span><span style="color: #31303E">{{ $orderDetail->quantity ?? "N/A" }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-5 d-flex align-items-center justify-content-end">
                                                    <div class="craft-purchase-history-price">
                                                        {{ single_price($orderDetail->price ?? "N/A" ) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <div class="align-items-start">
                                                @if ($order->orderDetails->first()->delivery_status == 'pending')
                                                    <div class="delivery-status delivery-status-processing">
                                                        {{ ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status ?? "N/A" )) }}
                                                    </div>
                                                    @elseif ($order->orderDetails->first()->delivery_status == 'confirmed')
                                                    <div class="delivery-status delivery-status-confirmed">
                                                        {{ ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status ?? "N/A" )) }}
                                                    </div>
                                                    @elseif ($order->orderDetails->first()->delivery_status == 'processing')
                                                    <div class="delivery-status delivery-status-confirmed">
                                                        {{ ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status ?? "N/A" )) }}
                                                    </div>
                                                    @elseif ($order->orderDetails->first()->delivery_status == 'partial_release')
                                                    <div class="delivery-status delivery-status-confirmed">
                                                        {{ ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status ?? "N/A" )) }}
                                                    </div>
                                                @elseif ($order->orderDetails->first()->delivery_status == 'ready_for_pickup')
                                                    <div class="delivery-status delivery-status-pickup">
                                                        {{ ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status ?? "N/A" )) }}
                                                    </div>
                                                @elseif ($order->orderDetails->first()->delivery_status == 'picked_up')
                                                    <div class="delivery-status delivery-status-picked-up">
                                                        {{ ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status ?? "N/A" )) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div class="purchase-history-total-label">
                                                        Total:
                                                    </div>
                                                    <div class="purchase-history-total-price">
                                                        {{ single_price($order->grand_total ?? "N/A" ) }}
                                                    </div>
                                                </div>
                                                <div class="float-right">
                                                    <p class="@if ($order->payment_status == 'paid') text-success @else text-danger @endif mb-0">{{ ucfirst($order->payment_status ?? "N/A" ) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div>
                                <h1 class="customer-craft-dashboard-subtitle mb-3">{{ translate('My recent purchase') }}</h1>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center mt-5">
                                        <svg width="74" height="74" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0)">
                                        <path d="M37.4995 65.6581H8.24084C5.89871 65.6581 4 63.7594 4 61.4173V24H37.4995V65.6581Z" fill="#FFCFD1"/>
                                        <path d="M62.234 72.3395L60.1127 69.6329C59.9736 69.4554 59.7048 69.4554 59.5658 69.6329L57.0969 72.7828C56.9579 72.9603 56.6892 72.9603 56.55 72.7828L54.0808 69.6327C53.9418 69.4552 53.6731 69.4552 53.5339 69.6327L51.0646 72.7828C50.9256 72.9603 50.6569 72.9603 50.5177 72.7828L48.0482 69.6327C47.9092 69.4552 47.6405 69.4552 47.5013 69.6327L45.032 72.7829C44.893 72.9604 44.6243 72.9604 44.4851 72.7829L42.0153 69.6327C41.8763 69.4552 41.6076 69.4552 41.4684 69.6327L39.3461 72.3398C39.1425 72.5997 38.7252 72.4556 38.7252 72.1255V46.2016L34.8047 34.4603H41.5127H58.9342C61.0994 34.4603 62.8547 36.2157 62.8547 38.3809V72.1252C62.8549 72.4554 62.4376 72.5994 62.234 72.3395Z" fill="#F9F6F9"/>
                                        <path d="M58.9337 34.4603H56.0918C58.257 34.4603 60.0124 36.2157 60.0124 38.3809V69.5486C60.0492 69.57 60.0838 69.5969 60.1119 69.6329L62.2332 72.3395C62.4369 72.5994 62.8541 72.4553 62.8541 72.1252V38.3809C62.8543 36.2155 61.0989 34.4603 58.9337 34.4603Z" fill="#DDDAEC"/>
                                        <path d="M38.7249 50.1355H31.4635C31.1434 50.1355 30.8838 49.8759 30.8838 49.5557V38.3809C30.8838 36.2157 32.6391 34.4603 34.8043 34.4603C36.9696 34.4603 38.7249 36.2157 38.7249 38.3809V50.1355Z" fill="#D0CEE7"/>
                                        <path d="M34.8044 34.4603C34.3187 34.4603 33.8541 34.5492 33.4248 34.7107C34.9093 35.269 35.9658 36.7013 35.9658 38.3809V50.1355H38.7249V38.3809C38.7249 36.2155 36.9696 34.4603 34.8044 34.4603Z" fill="#BEB9DD"/>
                                        <path d="M58.9338 33.3763H54.5085V26.1C54.5085 25.5012 54.0233 25.016 53.4245 25.016C52.8258 25.016 52.3406 25.5012 52.3406 26.1V33.3763H45.7278V17.4571H52.3406V28C52.3406 28.5988 52.8258 29.084 53.4245 29.084C54.0233 29.084 54.5085 28.5988 54.5085 28V16.3731C54.5085 15.7743 54.0233 15.2891 53.4245 15.2891H50.1181V10.9941C50.1181 5.54697 45.6866 1.11549 40.2395 1.11549C38.2121 1.11549 36.3258 1.73018 34.7559 2.78194C32.9774 1.06173 30.5581 0 27.8941 0C22.447 0 18.0155 4.43147 18.0155 9.87857V15.2892H11.1445C10.5459 15.2892 10.0605 15.7744 10.0605 16.3732V33.5C10.0605 34.0988 10.5459 34.584 11.1445 34.584C11.7432 34.584 12.2285 34.0988 12.2285 33.5V17.4572H18.0157V21.2295C18.0157 21.8283 18.501 22.3135 19.0997 22.3135C19.6983 22.3135 20.1837 21.8283 20.1837 21.2295V17.4572H35.6049V21.2295C35.6049 21.8283 36.0902 22.3135 36.6888 22.3135C37.2875 22.3135 37.7728 21.8283 37.7728 21.2295V17.4572H43.56V33.3765H34.8043C32.0448 33.3765 29.7998 35.6215 29.7998 38.381V49.5559C29.7998 50.4732 30.5461 51.2196 31.4635 51.2196H37.641V56.9473H15.3854C13.6448 56.9473 12.2285 55.5312 12.2285 53.7905V30.6197C12.2285 30.0209 11.7432 29.5357 11.1445 29.5357C10.5459 29.5357 10.0605 30.0209 10.0605 30.6197V53.7902C10.0605 56.7262 12.4492 59.115 15.3854 59.115H37.6409V60.396C37.6409 60.9948 38.1261 61.48 38.7248 61.48C39.3236 61.48 39.8088 60.9948 39.8088 60.396V38.3808C39.8088 37.3282 39.4815 36.3511 38.9242 35.5443H58.9338C60.4979 35.5443 61.7704 36.8167 61.7704 38.3808V69.9914L60.9656 68.9647C60.6924 68.6159 60.2818 68.4159 59.8387 68.4159C59.3956 68.4159 58.985 68.6159 58.7121 68.9642L56.8229 71.3747L54.9335 68.9642C54.6603 68.6158 54.2498 68.4157 53.8068 68.4157C53.3638 68.4157 52.9534 68.6158 52.6804 68.9641L50.7906 71.3749L48.9009 68.9638C48.6276 68.6155 48.2172 68.4157 47.7745 68.4157C47.3318 68.4157 46.9214 68.6155 46.6479 68.9641L44.7582 71.3749L42.868 68.9638C42.5947 68.6155 42.1844 68.4157 41.7417 68.4157C41.2991 68.4159 40.8881 68.6158 40.6152 68.964L39.809 69.9923V59.5C39.809 58.9012 39.3238 58.416 38.725 58.416C38.1262 58.416 37.641 58.9012 37.641 59.5V72.1256C37.641 72.7358 38.0286 73.2794 38.6053 73.4785C39.1829 73.6778 39.8227 73.4888 40.1989 73.0087L41.7417 71.041L43.6318 73.4521C43.9051 73.8004 44.3156 74.0001 44.7582 74.0001C45.2009 74.0001 45.6113 73.8004 45.8848 73.4518L47.7744 71.041L49.6643 73.4521C49.9376 73.8004 50.3479 74.0001 50.7908 74.0001C51.2333 74.0001 51.6438 73.8004 51.9172 73.4518L53.8068 71.0412L55.6963 73.4516C55.9696 73.8001 56.3801 74 56.8229 74C57.2658 74 57.6764 73.8001 57.9497 73.4516L59.8387 71.0413L61.3804 73.0082C61.7568 73.4884 62.3972 73.677 62.974 73.4782C63.5507 73.2791 63.9383 72.7354 63.9383 72.1253V38.3808C63.9383 35.6213 61.6933 33.3763 58.9338 33.3763ZM20.1835 9.87857C20.1835 5.62689 23.6424 2.16797 27.8941 2.16797C29.8944 2.16797 31.7188 2.93384 33.0906 4.18736C31.4013 5.96061 30.361 8.35738 30.361 10.9941V15.2891H20.1835V9.87857ZM32.5289 15.2891V10.9941C32.5289 9.03031 33.2679 7.23682 34.481 5.87404C35.1937 7.042 35.6047 8.41302 35.6047 9.87842V15.2891H32.5289ZM37.7727 15.2891V9.87857C37.7727 7.8797 37.1742 6.01886 36.1495 4.4624C37.3359 3.71677 38.7377 3.28361 40.2395 3.28361C44.4912 3.28361 47.9501 6.74253 47.9501 10.9942V15.2892L37.7727 15.2891ZM37.6409 38.3808V49.0514H31.9676V38.3808C31.9676 36.8167 33.24 35.5443 34.8042 35.5443C36.3683 35.5443 37.6409 36.8166 37.6409 38.3808Z" fill="#1B1464"/>
                                        <path d="M56.1215 38.5495H45.458C44.8592 38.5495 44.374 39.0347 44.374 39.6335C44.374 40.2323 44.8592 40.7175 45.458 40.7175H56.1215C56.7203 40.7175 57.2055 40.2323 57.2055 39.6335C57.2055 39.0347 56.7203 38.5495 56.1215 38.5495Z" fill="#1B1464"/>
                                        <path d="M41.6631 45.8242C41.6631 46.423 42.1483 46.9082 42.7471 46.9082H45.0289C45.6277 46.9082 46.1129 46.423 46.1129 45.8242C46.1129 45.2254 45.6277 44.7402 45.0289 44.7402H42.7471C42.1484 44.7402 41.6631 45.2254 41.6631 45.8242Z" fill="#1B1464"/>
                                        <path d="M58.8322 44.7402H48.1855C47.5868 44.7402 47.1016 45.2254 47.1016 45.8242C47.1016 46.423 47.5868 46.9082 48.1855 46.9082H58.8322C59.4309 46.9082 59.9161 46.423 59.9161 45.8242C59.9161 45.2254 59.4309 44.7402 58.8322 44.7402Z" fill="#1B1464"/>
                                        <path d="M42.7471 51.9117H45.0289C45.6277 51.9117 46.1129 51.4266 46.1129 50.8278C46.1129 50.229 45.6277 49.7438 45.0289 49.7438H42.7471C42.1483 49.7438 41.6631 50.229 41.6631 50.8278C41.6631 51.4266 42.1484 51.9117 42.7471 51.9117Z" fill="#1B1464"/>
                                        <path d="M58.8322 49.7438H48.1855C47.5868 49.7438 47.1016 50.229 47.1016 50.8278C47.1016 51.4266 47.5868 51.9117 48.1855 51.9117H58.8322C59.4309 51.9117 59.9161 51.4266 59.9161 50.8278C59.9161 50.229 59.4309 49.7438 58.8322 49.7438Z" fill="#1B1464"/>
                                        <path d="M58.8322 56.7725H53.4365C52.8377 56.7725 52.3525 57.2577 52.3525 57.8564C52.3525 58.4552 52.8377 58.9404 53.4365 58.9404H58.8322C59.431 58.9404 59.9161 58.4552 59.9161 57.8564C59.9161 57.2577 59.431 56.7725 58.8322 56.7725Z" fill="#1B1464"/>
                                        <g clip-path="url(#clip1)">
                                        <path d="M42.2366 57.3794L44.3576 59.5005L42.2366 61.6216C41.9211 61.9372 41.9211 62.4484 42.2366 62.764C42.3942 62.9217 42.6009 63.0006 42.8075 63.0006C43.0144 63.0006 43.2211 62.9218 43.3786 62.764L45.5 60.6427L47.6212 62.764C47.7789 62.9217 47.9855 63.0005 48.1923 63.0005C48.399 63.0005 48.6055 62.9218 48.7633 62.764C49.0788 62.4486 49.0788 61.9373 48.7633 61.6216L46.6424 59.5005L48.7634 57.3794C49.0789 57.0639 49.0789 56.5525 48.7634 56.237C48.448 55.9218 47.9369 55.9218 47.6214 56.237L45.5 58.3582L43.3788 56.237C43.0632 55.9218 42.5521 55.9218 42.2367 56.237C41.9211 56.5525 41.9211 57.0639 42.2366 57.3794Z" fill="#D71921"/>
                                        </g>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0">
                                        <rect width="74" height="74" fill="white"/>
                                        </clipPath>
                                        <clipPath id="clip1">
                                        <rect width="7" height="7" fill="white" transform="matrix(-1 0 0 1 49 56)"/>
                                        </clipPath>
                                        </defs>
                                        </svg>

                                        <h3 class="cart-craft-text mb-0 mt-3">
                                            You have no recent orders.
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>



            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script>
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