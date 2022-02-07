@extends('frontend.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">

            @include('frontend.inc.user_side_nav')

            <div class="aiz-user-panel">
                <a href="{{ route('employee.my_resellers') }}" class="back-to-page d-flex align-items-center">
                    <svg class="mr-3" width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.25 4.20833H3.03208L5.86625 1.36625L4.75 0.25L0 5L4.75 9.75L5.86625 8.63375L3.03208 5.79167H14.25V4.20833Z" fill="#1B1464"/>
                    </svg>

                    Back to My Resellers
                </a>

                @if ($reseller != null)
                    @if ($reseller->is_verified != 1 && $reseller->remaining_purchase_to_be_verified != '0.00')
                        <div class="order-details-unpaid-notification mt-4 py-3 px-4">
                            <div class="d-flex justify-content-start">
                                <div class="mr-3">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9905 1.8335C5.93051 1.8335 1.83301 5.94016 1.83301 11.0002C1.83301 16.0602 5.93051 20.1668 10.9905 20.1668C16.0597 20.1668 20.1663 16.0602 20.1663 11.0002C20.1663 5.94016 16.0597 1.8335 10.9905 1.8335ZM10.9997 18.3335C6.94801 18.3335 3.66634 15.0518 3.66634 11.0002C3.66634 6.9485 6.94801 3.66683 10.9997 3.66683C15.0513 3.66683 18.333 6.9485 18.333 11.0002C18.333 15.0518 15.0513 18.3335 10.9997 18.3335ZM10.083 6.41683H11.458V11.2293L15.583 13.6768L14.8955 14.8043L10.083 11.9168V6.41683Z" fill="#E49F1A"/>
                                    </svg>
                                </div>
                                <div class="order-details-unpaid-notification-subtitle">
                                    This reseller account is still pending for approval.
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card {{ $reseller->is_verified == 1 ? 'mt-4' : '' }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="mr-4">
                                            @if ($reseller->reseller != null)
                                                @if ($reseller->reseller->avatar_original != null)
                                                    <img src="{{ uploaded_asset($reseller->reseller->avatar_original ?? "N/A") }}" class="image rounded-circle customer-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                @else
                                                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle customer-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="customer-user-name">
                                            {{ $reseller->reseller->name ?? "N/A" }}
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-5 col-md-4">
                                                <div class="customer-user-label">
                                                    {{ translate('Mobile Number:') }}
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-8">
                                                <div class="customer-user-data">
                                                    {{ $reseller->reseller->phone ?? "N/A" }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-5 col-md-4">
                                                <div class="customer-user-label">
                                                    {{ translate('Phone Number:') }}
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-8">
                                                <div class="customer-user-data">
                                                    @if($reseller->reseller->telephone_number != null)
                                                        {{ $reseller->reseller->telephone_number }}
                                                    @else 
                                                        {{ 'N/A' }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-5 col-md-4">
                                                <div class="customer-user-label">
                                                    {{ translate('Email:') }}
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-8">
                                                <div class="customer-user-data">
                                                    {{ $reseller->reseller->email ?? "N/A" }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-5 col-md-4">
                                                <div class="customer-user-label">
                                                    {{ translate('Address:') }}
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-8">
                                                <div class="customer-user-data">
                                                    {{ $reseller->reseller->address ?? "N/A" }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-5 col-md-4">
                                                <div class="customer-user-label">
                                                    {{ translate('City:') }}
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-8">
                                                <div class="customer-user-data">
                                                    {{ $reseller->reseller->city != null ? ucfirst(str_replace('_', ' ', $reseller->reseller->city)) : 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-5 col-md-4">
                                                <div class="customer-user-label">
                                                    {{ translate('Postal Code:') }}
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-8">
                                                <div class="customer-user-data">
                                                    {{ $reseller->reseller->postal_code ?? "N/A" }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-5 col-md-4">
                                                <div class="customer-user-label">
                                                    {{ translate('Birth Date:') }}
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-8">
                                                <div class="customer-user-data">
                                                    {{ date('m-d-Y', strtotime($reseller->reseller->birthdate ?? "N/A")) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mt-4">
                                        <div class="customer-user-subtitle d-flex align-items-center">
                                            <svg class="mr-3" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0)">
                                            <path d="M20.1784 4.66649H16.2514V2.36594C16.2514 1.91215 15.8835 1.54431 15.4298 1.54431H5.57025C5.11647 1.54431 4.74862 1.91215 4.74862 2.36594V4.66649H0.821625C0.367842 4.66649 0 5.03433 0 5.48811V18.6341C0 19.0879 0.367842 19.4557 0.821625 19.4557H20.1784C20.6322 19.4557 21 19.0879 21 18.6341C21 11.3709 21 5.85776 21 5.48811C21 5.03433 20.6322 4.66649 20.1784 4.66649ZM6.39187 3.18756H14.6081V4.66649H6.39187V3.18756ZM1.64325 6.30974H19.3568V8.18592L10.5 11.1934L1.64325 8.18592V6.30974ZM1.64325 17.8125V9.92131L10.2358 12.8391C10.4071 12.8973 10.5928 12.8973 10.7642 12.8391L19.3567 9.92131V17.8125H1.64325Z" fill="#D71921"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0">
                                            <rect width="21" height="21" fill="white"/>
                                            </clipPath>
                                            </defs>
                                            </svg>

                                            {{ translate('Employment Details') }}
                                        </div>

                                        <div class="mt-4">
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-5 col-md-4">
                                                    <div class="customer-user-label">
                                                        {{ translate('Employment Status:') }}
                                                    </div>
                                                </div>
                                                <div class="col-5 col-md-8">
                                                    <div class="customer-user-data">
                                                        {{ $reseller->reseller->reseller->employment_status ?? "N/A" }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-5 col-md-4">
                                                    <div class="customer-user-label">
                                                        {{ translate('Telephone Number:') }}
                                                    </div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="customer-user-data">
                                                        @if($reseller->reseller->reseller->telephone_number != null)
                                                            {{ $reseller->reseller->reseller->telephone_number }}
                                                        @else 
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @php
                                                $employment_status = $reseller->reseller->reseller->employment_status;
                                            @endphp

                                            @if ($employment_status == 'Employed')
                                                @include('frontend.user.employee.partials.employed')
                                            @elseif ($employment_status == 'Freelancer')
                                                @include('frontend.user.employee.partials.freelancer')
                                            @elseif ($employment_status == 'Business')
                                                @include('frontend.user.employee.partials.business')
                                            @endif

                                            @foreach ($reseller_uploaded_files as $key => $value)
                                                <div class="row d-flex align-items-center mb-2">
                                                    <div class="col-5 col-md-4">
                                                        <div class="customer-user-label">
                                                            <span class="text-capitalize">
                                                                {{ ucfirst(str_replace('_', ' ', $value->img_type ?? "N/A" )) }}:
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-md-8">
                                                        <div class="customer-user-data">
                                                            <a href="{{ uploaded_asset($value->img ?? "N/A") }}" class="text-primary" target="_blank">
                                                                {{ str_replace('uploads/all/', '', uploaded_asset_name($value->img ?? "N/A")) }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mt-4">
                                        <div class="customer-user-subtitle d-flex align-items-center">
                                            <svg class="mr-3" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0)">
                                            <path d="M20.1784 4.66649H16.2514V2.36594C16.2514 1.91215 15.8835 1.54431 15.4298 1.54431H5.57025C5.11647 1.54431 4.74862 1.91215 4.74862 2.36594V4.66649H0.821625C0.367842 4.66649 0 5.03433 0 5.48811V18.6341C0 19.0879 0.367842 19.4557 0.821625 19.4557H20.1784C20.6322 19.4557 21 19.0879 21 18.6341C21 11.3709 21 5.85776 21 5.48811C21 5.03433 20.6322 4.66649 20.1784 4.66649ZM6.39187 3.18756H14.6081V4.66649H6.39187V3.18756ZM1.64325 6.30974H19.3568V8.18592L10.5 11.1934L1.64325 8.18592V6.30974ZM1.64325 17.8125V9.92131L10.2358 12.8391C10.4071 12.8973 10.5928 12.8973 10.7642 12.8391L19.3567 9.92131V17.8125H1.64325Z" fill="#D71921"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0">
                                            <rect width="21" height="21" fill="white"/>
                                            </clipPath>
                                            </defs>
                                            </svg>

                                            {{ translate('Agent Info') }}
                                        </div>

                                        <div class="mt-4">
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-5 col-md-4">
                                                    <div class="customer-user-label">
                                                        {{ translate('Name:') }}
                                                    </div>
                                                </div>
                                                <div class="col-5 col-md-8">
                                                    <div class="customer-user-data">
                                                        {{ $reseller->employee->name ?? "N/A" }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-5 col-md-4">
                                                    <div class="customer-user-label">
                                                        {{ translate('Employee ID:') }}
                                                    </div>
                                                </div>
                                                <div class="col-5 col-md-8">
                                                    <div class="customer-user-data">
                                                        {{ $reseller->employee->employee_id }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-5 col-md-4">
                                                    <div class="customer-user-label">
                                                        {{ translate('Email:') }}
                                                    </div>
                                                </div>
                                                <div class="col-5 col-md-8">
                                                    <div class="customer-user-data">
                                                        {{ $reseller->employee->email ?? "N/A" }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row gutters-10 mb-3">
                                <div class="col-12 col-md-4 mb-2">
                                    <div class="cart-craft-count cart-craft-count-primary">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <div class="cart-craft-count-title">
                                                    @php
                                                        $total_customers = \App\ResellerCustomer::where('reseller_id', $reseller->reseller_id)->count();
                                                    @endphp
                                                    {{ $total_customers }}
                                                </div>
                                                <div class="cart-craft-count-subtitle">
                                                    Total customers
                                                </div>
                                            </div>
                                            <div>
                                                <div class="float-right d-flex align-items-center h-100">
                                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.625 15.5C14.118 15.5 16.1459 13.4721 16.1459 10.9792C16.1459 8.48625 14.118 6.45833 11.625 6.45833C9.13212 6.45833 7.10421 8.48625 7.10421 10.9792C7.10421 13.4721 9.13212 15.5 11.625 15.5ZM2.58337 22.2812C2.58337 19.2717 8.60254 17.7604 11.625 17.7604C14.6475 17.7604 20.6667 19.2717 20.6667 22.2812V24.5417H2.58337V22.2812ZM11.625 20.3437C9.31296 20.3437 6.69087 21.2092 5.60587 21.9583H17.6442C16.5592 21.2092 13.9371 20.3437 11.625 20.3437ZM13.5625 10.9792C13.5625 9.90708 12.6971 9.04166 11.625 9.04166C10.553 9.04166 9.68754 9.90708 9.68754 10.9792C9.68754 12.0512 10.553 12.9167 11.625 12.9167C12.6971 12.9167 13.5625 12.0512 13.5625 10.9792ZM20.7184 17.8379C22.2167 18.9229 23.25 20.3696 23.25 22.2812V24.5417H28.4167V22.2812C28.4167 19.6721 23.8959 18.1867 20.7184 17.8379ZM23.8959 10.9792C23.8959 13.4721 21.868 15.5 19.375 15.5C18.6775 15.5 18.0317 15.3321 17.4375 15.0479C18.2513 13.8983 18.7292 12.4904 18.7292 10.9792C18.7292 9.46791 18.2513 8.05999 17.4375 6.91041C18.0317 6.62624 18.6775 6.45833 19.375 6.45833C21.868 6.45833 23.8959 8.48625 23.8959 10.9792Z" fill="white"/>
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
                                                        $resellers = \App\ResellerCustomer::where('reseller_id', $reseller->reseller_id)->get();

                                                        $total_sales = 0;

                                                        foreach ($resellers as $key => $value) {
                                                            $total_sales += $value->total_orders;
                                                        }
                                                    @endphp
                                                    {{ $total_sales }}
                                                </div>
                                                <div class="cart-craft-count-subtitle">
                                                    Total sales
                                                </div>
                                            </div>
                                            <div>
                                                <div class="float-right d-flex align-items-center h-100">
                                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20.6666 7.75L23.6246 10.7079L17.3212 17.0112L12.1546 11.8446L2.58331 21.4288L4.40456 23.25L12.1546 15.5L17.3212 20.6667L25.4587 12.5421L28.4166 15.5V7.75H20.6666Z" fill="white"/>
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
                                                        $orders = \App\ResellerCustomerOrder::where('reseller_id', $reseller->reseller_id)
                                                            ->where('order_status', 'picked_up')
                                                            ->where('payment_status', 'paid')
                                                            ->get();

                                                        $total = 0;

                                                        foreach ($orders as $key => $order) {
                                                            if ($order->orderDetails != null) {
                                                                $total += count($order->orderDetails);
                                                            }
                                                        }
                                                    @endphp
                                                    {{ $total }}
                                                </div>
                                                <div class="cart-craft-count-subtitle">
                                                    Total successful orders
                                                </div>
                                            </div>
                                            <div>
                                                <div class="float-right d-flex align-items-center h-100">
                                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25.1875 4.52087L23.25 2.58337L21.3125 4.52087L19.375 2.58337L17.4375 4.52087L15.5 2.58337L13.5625 4.52087L11.625 2.58337L9.6875 4.52087L7.75 2.58337L5.8125 4.52087L3.875 2.58337V28.4167L5.8125 26.4792L7.75 28.4167L9.6875 26.4792L11.625 28.4167L13.5625 26.4792L15.5 28.4167L17.4375 26.4792L19.375 28.4167L21.3125 26.4792L23.25 28.4167L25.1875 26.4792L27.125 28.4167V2.58337L25.1875 4.52087ZM24.5417 24.658H6.45833V6.34212H24.5417V24.658ZM23.25 19.375H7.75V21.9584H23.25V19.375ZM7.75 14.2084H23.25V16.7917H7.75V14.2084ZM23.25 9.04171H7.75V11.625H23.25V9.04171Z" fill="white"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start border-bottom">
                                <div class="card-customer-wallet-title">
                                    Transaction History (Customers)
                                </div>
                            </div>

                            @if (count($reseller_customer_transaction_histories) != 0)
                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="table-header">Order Code</th>
                                            <th class="table-header">Date</th>
                                            <th class="table-header">No. of products</th>
                                            <th class="table-header">Customer</th>
                                            <th class="table-header text-center">Order Status</th>
                                            <th class="table-header text-center">Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reseller_customer_transaction_histories as $key => $order)
                                            <tr>
                                                <td class="table-date">
                                                    <a href="{{ route('employee.my_earnings_reseller.order_show', encrypt($order->order_id)) }}">
                                                        {{ $order->order_code ?? "N/A" }}
                                                    </a>
                                                </td>
                                                <td class="table-date">{{ date('d-m-Y h:i A', $order->date ?? "N/A") }}</td>
                                                <td class="table-date">{{ $order->number_of_products ?? "N/A" }}</td>
                                                <td class="table-data">
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-2">
                                                            @if ($order->customer != null)
                                                                @if ($order->customer->avatar_original != null)
                                                                    <img src="{{ uploaded_asset($order->customer->avatar_original ?? "N/A") }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                @else
                                                                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div>
                                                            {{ $order->customer->name ?? "N/A" }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="table-data text-center">
                                                    @if ($order->order_status == 'pending')
                                                        <div class="delivery-status delivery-status-processing" style="display: initial">
                                                            {{ ucfirst($order->order_status ?? "N/A") }}
                                                        </div>
                                                        @elseif ($order->order_status == 'confirmed')
                                                        <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                            {{ ucfirst($order->order_status ?? "N/A") }}
                                                        </div>
                                                        @elseif ($order->order_status == 'processing')
                                                        <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                            {{ ucfirst($order->order_status ?? "N/A" ) }}
                                                        </div>
                                                        @elseif ($order->order_status == 'partial_release')
                                                        <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                            {{ ucfirst($order->order_status ?? "N/A") }}
                                                        </div>
                                                    @elseif ($order->order_status == 'ready_for_pickup')
                                                        <div class="delivery-status delivery-status-pickup" style="display: initial">
                                                            {{ ucfirst(str_replace('_', ' ', $order->order_status ?? "N/A")) }}
                                                        </div>
                                                    @elseif ($order->order_status == 'picked_up')
                                                        <div class="delivery-status delivery-status-picked-up" style="display: initial">
                                                            {{ ucfirst(str_replace('_', ' ', $order->order_status ?? "N/A")) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="table-data text-center">
                                                    <span class="@if ($order->payment_status == 'paid') text-success @else text-danger @endif">
                                                        {{ ucfirst($order->payment_status ?? "N/A") }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $reseller_customer_transaction_histories->links() }}
                            @else
                                <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                                    <div class="text-center">
                                        <svg width="69" height="65" viewBox="0 0 69 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.06692 12H48.805C51.0512 12 52.8719 13.8211 52.8719 16.0669V60.805C52.8719 63.0512 51.0512 64.8724 48.805 64.8724H4.06692C1.82073 64.8724 0 63.0512 0 60.805V16.0669C0 13.8211 1.82073 12 4.06692 12Z" fill="#FFCFD1"/>
                                        <path d="M9.96484 5.04956H11.9987V7.08302H9.96484V5.04956Z" fill="#5EB3D1"/>
                                        <path d="M14.0322 5.04956H16.0657V7.08302H14.0322V5.04956Z" fill="#5EB3D1"/>
                                        <path d="M18.0991 5.04956H20.133V7.08302H18.0991V5.04956Z" fill="#5EB3D1"/>
                                        <path d="M9.96484 9.11646H56.7368V11.1503H9.96484V9.11646Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 17.2505H40.4685V19.2839H23.1831V17.2505Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 21.3176H30.3008V23.3515H23.1831V21.3176Z" fill="#5EB3D1"/>
                                        <path d="M32.334 21.3176H46.569V23.3515H32.334V21.3176Z" fill="#5EB3D1"/>
                                        <path d="M42.502 17.2505H52.6697V19.2839H42.502V17.2505Z" fill="#5EB3D1"/>
                                        <path d="M15.0492 25.385C12.2418 25.385 9.96533 23.1085 9.96533 20.3011C9.96533 17.4938 12.2418 15.2173 15.0492 15.2173C17.8561 15.2173 20.133 17.4938 20.133 20.3011C20.1298 23.1073 17.8553 25.3818 15.0492 25.385ZM15.0492 17.2507C13.3641 17.2507 11.9988 18.6165 11.9988 20.3011C11.9988 21.9858 13.3641 23.3515 15.0492 23.3515C16.7338 23.3515 18.0992 21.9858 18.0992 20.3011C18.0992 18.6165 16.7338 17.2507 15.0492 17.2507Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 29.4519H40.4685V31.4858H23.1831V29.4519Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 33.519H30.3008V35.5525H23.1831V33.519Z" fill="#5EB3D1"/>
                                        <path d="M15.0492 37.5859C12.2418 37.5859 9.96533 35.3094 9.96533 32.5021C9.96533 29.6947 12.2418 27.4182 15.0492 27.4182C17.8561 27.4182 20.133 29.6951 20.133 32.5021C20.1298 35.3086 17.8553 37.5831 15.0492 37.5859ZM15.0492 29.4517C13.3641 29.4517 11.9988 30.8174 11.9988 32.5021C11.9988 34.1867 13.3641 35.5524 15.0492 35.5524C16.7338 35.5524 18.0992 34.1867 18.0992 32.5021C18.0992 30.8174 16.7338 29.4517 15.0492 29.4517Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 45.7202H30.3008V47.7541H23.1831V45.7202Z" fill="#5EB3D1"/>
                                        <path d="M42.502 41.6533H52.6697V43.6868H42.502V41.6533Z" fill="#5EB3D1"/>
                                        <path d="M15.0492 49.7876C12.2418 49.7876 9.96533 47.5111 9.96533 44.7037C9.96533 41.8964 12.2418 39.6199 15.0492 39.6199C17.8561 39.6199 20.133 41.8964 20.133 44.7037C20.1298 47.5099 17.8553 49.7844 15.0492 49.7876ZM15.0492 41.6533C13.3641 41.6533 11.9988 43.0187 11.9988 44.7037C11.9988 46.3884 13.3641 47.7541 15.0492 47.7541C16.7338 47.7541 18.0992 46.3884 18.0992 44.7037C18.0992 43.0187 16.7338 41.6533 15.0492 41.6533Z" fill="#5EB3D1"/>
                                        <path d="M14.3306 19.5823L20.4309 13.4819L21.8689 14.9199L15.7686 21.0203L14.3306 19.5823Z" fill="#E34B87"/>
                                        <path d="M14.3291 31.7826L20.4295 25.6826L21.8671 27.1202L15.7667 33.2206L14.3291 31.7826Z" fill="#E34B87"/>
                                        <path d="M14.3286 43.9842L20.429 37.8838L21.867 39.3218L15.7666 45.4222L14.3286 43.9842Z" fill="#E34B87"/>
                                        <path d="M67.9208 46.7372C67.9208 54.5989 61.5478 60.9718 53.6862 60.9718C45.8245 60.9718 39.4512 54.5989 39.4512 46.7372C39.4512 38.8756 45.8245 32.5022 53.6862 32.5022C61.5478 32.5022 67.9208 38.8756 67.9208 46.7372Z" fill="#D71921"/>
                                        <path d="M53.8997 53.2522C53.3846 53.2522 52.8911 53.7051 52.9149 54.237C52.9388 54.7705 53.3476 55.2218 53.8997 55.2218C54.4148 55.2218 54.9083 54.7688 54.8845 54.237C54.8606 53.7034 54.4518 53.2522 53.8997 53.2522Z" fill="white"/>
                                        <path d="M53.8996 38C51.198 38 49 40.198 49 42.8996C49 43.4435 49.4409 43.8844 49.9848 43.8844C50.5286 43.8844 50.9696 43.4435 50.9696 42.8996C50.9696 41.284 52.284 39.9696 53.8996 39.9696C55.5152 39.9696 56.8297 41.284 56.8297 42.8996C56.8297 44.5152 55.5152 45.8297 53.8996 45.8297C53.3558 45.8297 52.9148 46.2706 52.9148 46.8145V50.831C52.9148 51.3749 53.3558 51.8158 53.8996 51.8158C54.4435 51.8158 54.8844 51.375 54.8844 50.831V47.6998C57.1157 47.2427 58.7993 45.2641 58.7993 42.8996C58.7993 40.198 56.6013 38 53.8996 38Z" fill="white"/>
                                        <path d="M10.9818 55.888H37.418V53.8545H10.9818C9.29716 53.8545 7.93141 52.4888 7.93141 50.8041V6.06603C7.93141 4.38139 9.29716 3.01604 10.9818 3.01604H55.7199C57.4045 3.01604 58.7703 4.38139 58.7703 6.06603V29.4522H60.8038V6.06603C60.8006 3.25989 58.5264 0.985371 55.7199 0.982178H10.9818C8.17566 0.985371 5.90114 3.25989 5.89795 6.06603V50.8041C5.90114 53.6107 8.17566 55.8852 10.9818 55.888Z" fill="#1B1464"/>
                                        <path d="M9.96484 5.04956H11.9987V7.08302H9.96484V5.04956Z" fill="#1B1464"/>
                                        <path d="M14.0322 5.04956H16.0657V7.08302H14.0322V5.04956Z" fill="#1B1464"/>
                                        <path d="M18.0991 5.04956H20.133V7.08302H18.0991V5.04956Z" fill="#1B1464"/>
                                        <path d="M9.96484 9.11646H56.7368V11.1503H9.96484V9.11646Z" fill="#1B1464"/>
                                        <path d="M20.4306 13.4814L17.848 16.0641C15.4992 14.5095 12.3363 15.1529 10.7814 17.5017C9.22685 19.8508 9.87022 23.0138 12.2194 24.5683C14.5681 26.1232 17.7311 25.4795 19.286 23.1307C20.4155 21.4245 20.4155 19.2079 19.286 17.5017L21.8682 14.9194L20.4306 13.4814ZM15.0491 23.3514C13.364 23.3514 11.9987 21.9857 11.9987 20.301C11.9987 18.6164 13.364 17.2506 15.0491 17.2506C15.5012 17.2526 15.9486 17.3564 16.3553 17.5555L14.3303 19.581L15.7679 21.019L17.7941 18.9943C17.9937 19.401 18.0975 19.8484 18.0994 20.301C18.099 21.9857 16.7337 23.3514 15.0491 23.3514Z" fill="#1B1464"/>
                                        <path d="M23.1831 17.2505H40.4685V19.2839H23.1831V17.2505Z" fill="#1B1464"/>
                                        <path d="M23.1831 21.3176H30.3008V23.3515H23.1831V21.3176Z" fill="#1B1464"/>
                                        <path d="M32.334 21.3176H46.569V23.3515H32.334V21.3176Z" fill="#1B1464"/>
                                        <path d="M42.502 17.2505H52.6697V19.2839H42.502V17.2505Z" fill="#1B1464"/>
                                        <path d="M20.4306 25.6826L17.848 28.2653C15.4992 26.7107 12.3363 27.3545 10.7814 29.7032C9.22685 32.052 9.87022 35.2149 12.2194 36.7699C14.5681 38.3244 17.7311 37.6806 19.286 35.3319C20.4155 33.6257 20.4155 31.4094 19.286 29.7032L21.8682 27.1206L20.4306 25.6826ZM15.0491 35.5526C13.364 35.5526 11.9987 34.1868 11.9987 32.5022C11.9987 30.8176 13.364 29.4518 15.0491 29.4518C15.5012 29.4538 15.9486 29.5576 16.3553 29.7571L14.3303 31.7826L15.7679 33.2202L17.7941 31.1959C17.9937 31.6026 18.0975 32.05 18.0994 32.5022C18.099 34.1872 16.7337 35.5526 15.0491 35.5526Z" fill="#1B1464"/>
                                        <path d="M23.1831 29.4519H40.4685V31.4858H23.1831V29.4519Z" fill="#1B1464"/>
                                        <path d="M23.1831 33.519H30.3008V35.5525H23.1831V33.519Z" fill="#1B1464"/>
                                        <path d="M32.334 33.519H40.4682V35.5525H32.334V33.519Z" fill="#1B1464"/>
                                        <path d="M42.502 29.4519H46.5693V31.4858H42.502V29.4519Z" fill="#1B1464"/>
                                        <path d="M20.4306 37.884L17.848 40.4667C15.4992 38.9121 12.3363 39.5555 10.7814 41.9043C9.22685 44.253 9.87022 47.4164 12.2194 48.9709C14.5681 50.5254 17.7311 49.8821 19.286 47.5333C20.4155 45.8271 20.4155 43.6105 19.286 41.9043L21.8682 39.3216L20.4306 37.884ZM15.0491 47.754C13.364 47.754 11.9987 46.3883 11.9987 44.7036C11.9987 43.0186 13.364 41.6532 15.0491 41.6532C15.5012 41.6552 15.9486 41.759 16.3553 41.9581L14.3303 43.9836L15.7679 45.4212L17.7941 43.3969C17.9937 43.8036 18.0975 44.251 18.0994 44.7036C18.099 46.3883 16.7337 47.754 15.0491 47.754Z" fill="#1B1464"/>
                                        <path d="M23.1831 41.6533H36.4012V43.6868H23.1831V41.6533Z" fill="#1B1464"/>
                                        <path d="M23.1831 45.7202H30.3008V47.7541H23.1831V45.7202Z" fill="#1B1464"/>
                                        <path d="M32.334 45.7202H36.4009V47.7541H32.334V45.7202Z" fill="#1B1464"/>
                                        <path d="M53.6866 61.9887C62.1094 61.9887 68.9382 55.1599 68.9382 46.7371C68.9382 38.3143 62.1094 31.4856 53.6866 31.4856C45.2638 31.4856 38.4351 38.3143 38.4351 46.7371C38.4442 55.1559 45.2678 61.9795 53.6866 61.9887ZM53.6866 33.5191C60.9871 33.5191 66.9047 39.4366 66.9047 46.7371C66.9047 54.0376 60.9871 59.9552 53.6866 59.9552C46.3861 59.9552 40.4685 54.0376 40.4685 46.7371C40.4765 39.4406 46.3901 33.527 53.6866 33.5191Z" fill="#1B1464"/>
                                        </svg>

                                        <h3 class="cart-craft-text mb-0 mt-3">
                                            Reseller's transaction history is empty.
                                        </h3>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Reseller's Orders --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row gutters-10 mb-3">
                                <div class="col-12 col-md-4 mb-2">
                                    <div class="cart-craft-count cart-craft-count-primary">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <div class="cart-craft-count-title">
                                                    @php
                                                        $total_customers = \App\ResellerCustomer::where('reseller_id', $reseller->reseller_id)->count();
                                                    @endphp
                                                    {{ $total_customers }}
                                                </div>
                                                <div class="cart-craft-count-subtitle">
                                                    Total customers
                                                </div>
                                            </div>
                                            <div>
                                                <div class="float-right d-flex align-items-center h-100">
                                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.625 15.5C14.118 15.5 16.1459 13.4721 16.1459 10.9792C16.1459 8.48625 14.118 6.45833 11.625 6.45833C9.13212 6.45833 7.10421 8.48625 7.10421 10.9792C7.10421 13.4721 9.13212 15.5 11.625 15.5ZM2.58337 22.2812C2.58337 19.2717 8.60254 17.7604 11.625 17.7604C14.6475 17.7604 20.6667 19.2717 20.6667 22.2812V24.5417H2.58337V22.2812ZM11.625 20.3437C9.31296 20.3437 6.69087 21.2092 5.60587 21.9583H17.6442C16.5592 21.2092 13.9371 20.3437 11.625 20.3437ZM13.5625 10.9792C13.5625 9.90708 12.6971 9.04166 11.625 9.04166C10.553 9.04166 9.68754 9.90708 9.68754 10.9792C9.68754 12.0512 10.553 12.9167 11.625 12.9167C12.6971 12.9167 13.5625 12.0512 13.5625 10.9792ZM20.7184 17.8379C22.2167 18.9229 23.25 20.3696 23.25 22.2812V24.5417H28.4167V22.2812C28.4167 19.6721 23.8959 18.1867 20.7184 17.8379ZM23.8959 10.9792C23.8959 13.4721 21.868 15.5 19.375 15.5C18.6775 15.5 18.0317 15.3321 17.4375 15.0479C18.2513 13.8983 18.7292 12.4904 18.7292 10.9792C18.7292 9.46791 18.2513 8.05999 17.4375 6.91041C18.0317 6.62624 18.6775 6.45833 19.375 6.45833C21.868 6.45833 23.8959 8.48625 23.8959 10.9792Z" fill="white"/>
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
                                                        $resellers = \App\ResellerCustomer::where('reseller_id', $reseller->reseller_id)->get();

                                                        $total_sales = 0;

                                                        foreach ($resellers as $key => $value) {
                                                            $total_sales += $value->total_orders;
                                                        }
                                                    @endphp
                                                    {{ $total_sales }}
                                                </div>
                                                <div class="cart-craft-count-subtitle">
                                                    Total sales
                                                </div>
                                            </div>
                                            <div>
                                                <div class="float-right d-flex align-items-center h-100">
                                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20.6666 7.75L23.6246 10.7079L17.3212 17.0112L12.1546 11.8446L2.58331 21.4288L4.40456 23.25L12.1546 15.5L17.3212 20.6667L25.4587 12.5421L28.4166 15.5V7.75H20.6666Z" fill="white"/>
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
                                                        $orders = \App\ResellerCustomerOrder::where('reseller_id', $reseller->reseller_id)
                                                            ->where('order_status', 'picked_up')
                                                            ->where('payment_status', 'paid')
                                                            ->get();

                                                        $total = 0;

                                                        foreach ($orders as $key => $order) {
                                                            if ($order->orderDetails != null) {
                                                                $total += count($order->orderDetails);
                                                            }
                                                        }
                                                    @endphp
                                                    {{ $total }}
                                                </div>
                                                <div class="cart-craft-count-subtitle">
                                                    Total successful orders
                                                </div>
                                            </div>
                                            <div>
                                                <div class="float-right d-flex align-items-center h-100">
                                                    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25.1875 4.52087L23.25 2.58337L21.3125 4.52087L19.375 2.58337L17.4375 4.52087L15.5 2.58337L13.5625 4.52087L11.625 2.58337L9.6875 4.52087L7.75 2.58337L5.8125 4.52087L3.875 2.58337V28.4167L5.8125 26.4792L7.75 28.4167L9.6875 26.4792L11.625 28.4167L13.5625 26.4792L15.5 28.4167L17.4375 26.4792L19.375 28.4167L21.3125 26.4792L23.25 28.4167L25.1875 26.4792L27.125 28.4167V2.58337L25.1875 4.52087ZM24.5417 24.658H6.45833V6.34212H24.5417V24.658ZM23.25 19.375H7.75V21.9584H23.25V19.375ZM7.75 14.2084H23.25V16.7917H7.75V14.2084ZM23.25 9.04171H7.75V11.625H23.25V9.04171Z" fill="white"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start border-bottom">
                                <div class="card-customer-wallet-title">
                                    Transaction History (Reseller)
                                </div>
                            </div>

                            @if (count($reseller_transaction_histories) != 0)
                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="table-header">Order Code</th>
                                            <th class="table-header">Date</th>
                                            <th class="table-header text-center">No. of products</th>
                                            <th class="table-header text-center">Order Status</th>
                                            <th class="table-header text-center">Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reseller_transaction_histories as $key => $order_reseller)
                                            <tr>
                                                <td class="table-date">
                                                    <a href="{{ route('employee.my_earnings_reseller.order_show', encrypt($order_reseller->order_id)) }}">
                                                        {{ $order_reseller->order_code ?? "N/A" }}
                                                    </a>
                                                </td>
                                                <td class="table-date">{{ date('d-m-Y h:i A', $order_reseller->date ?? "N/A") }}</td>
                                                <td class="table-date text-center">{{ $order_reseller->number_of_products ?? "N/A" }}</td>
                                                <td class="table-data text-center">
                                                    @if ($order_reseller->order_status == 'pending')
                                                        <div class="delivery-status delivery-status-processing" style="display: initial">
                                                            {{ ucfirst($order_reseller->order_status ?? "N/A") }}
                                                        </div>
                                                        @elseif ($order_reseller->order_status == 'confirmed')
                                                        <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                            {{ ucfirst($order_reseller->order_status ?? "N/A") }}
                                                        </div>
                                                        @elseif ($order_reseller->order_status == 'processing')
                                                        <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                            {{ ucfirst($order_reseller->order_status ?? "N/A" ) }}
                                                        </div>
                                                        @elseif ($order_reseller->order_status == 'partial_release')
                                                        <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                            {{ ucfirst($order_reseller->order_status ?? "N/A") }}
                                                        </div>
                                                    @elseif ($order_reseller->order_status == 'ready_for_pickup')
                                                        <div class="delivery-status delivery-status-pickup" style="display: initial">
                                                            {{ ucfirst(str_replace('_', ' ', $order_reseller->order_status ?? "N/A")) }}
                                                        </div>
                                                    @elseif ($order_reseller->order_status == 'picked_up')
                                                        <div class="delivery-status delivery-status-picked-up" style="display: initial">
                                                            {{ ucfirst(str_replace('_', ' ', $order_reseller->order_status ?? "N/A")) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="table-data text-center">
                                                    <span class="@if ($order_reseller->payment_status == 'paid') text-success @else text-danger @endif">
                                                        {{ ucfirst($order_reseller->payment_status ?? "N/A") }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $reseller_transaction_histories->links() }}
                            @else
                                <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                                    <div class="text-center">
                                        <svg width="69" height="65" viewBox="0 0 69 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.06692 12H48.805C51.0512 12 52.8719 13.8211 52.8719 16.0669V60.805C52.8719 63.0512 51.0512 64.8724 48.805 64.8724H4.06692C1.82073 64.8724 0 63.0512 0 60.805V16.0669C0 13.8211 1.82073 12 4.06692 12Z" fill="#FFCFD1"/>
                                        <path d="M9.96484 5.04956H11.9987V7.08302H9.96484V5.04956Z" fill="#5EB3D1"/>
                                        <path d="M14.0322 5.04956H16.0657V7.08302H14.0322V5.04956Z" fill="#5EB3D1"/>
                                        <path d="M18.0991 5.04956H20.133V7.08302H18.0991V5.04956Z" fill="#5EB3D1"/>
                                        <path d="M9.96484 9.11646H56.7368V11.1503H9.96484V9.11646Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 17.2505H40.4685V19.2839H23.1831V17.2505Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 21.3176H30.3008V23.3515H23.1831V21.3176Z" fill="#5EB3D1"/>
                                        <path d="M32.334 21.3176H46.569V23.3515H32.334V21.3176Z" fill="#5EB3D1"/>
                                        <path d="M42.502 17.2505H52.6697V19.2839H42.502V17.2505Z" fill="#5EB3D1"/>
                                        <path d="M15.0492 25.385C12.2418 25.385 9.96533 23.1085 9.96533 20.3011C9.96533 17.4938 12.2418 15.2173 15.0492 15.2173C17.8561 15.2173 20.133 17.4938 20.133 20.3011C20.1298 23.1073 17.8553 25.3818 15.0492 25.385ZM15.0492 17.2507C13.3641 17.2507 11.9988 18.6165 11.9988 20.3011C11.9988 21.9858 13.3641 23.3515 15.0492 23.3515C16.7338 23.3515 18.0992 21.9858 18.0992 20.3011C18.0992 18.6165 16.7338 17.2507 15.0492 17.2507Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 29.4519H40.4685V31.4858H23.1831V29.4519Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 33.519H30.3008V35.5525H23.1831V33.519Z" fill="#5EB3D1"/>
                                        <path d="M15.0492 37.5859C12.2418 37.5859 9.96533 35.3094 9.96533 32.5021C9.96533 29.6947 12.2418 27.4182 15.0492 27.4182C17.8561 27.4182 20.133 29.6951 20.133 32.5021C20.1298 35.3086 17.8553 37.5831 15.0492 37.5859ZM15.0492 29.4517C13.3641 29.4517 11.9988 30.8174 11.9988 32.5021C11.9988 34.1867 13.3641 35.5524 15.0492 35.5524C16.7338 35.5524 18.0992 34.1867 18.0992 32.5021C18.0992 30.8174 16.7338 29.4517 15.0492 29.4517Z" fill="#5EB3D1"/>
                                        <path d="M23.1831 45.7202H30.3008V47.7541H23.1831V45.7202Z" fill="#5EB3D1"/>
                                        <path d="M42.502 41.6533H52.6697V43.6868H42.502V41.6533Z" fill="#5EB3D1"/>
                                        <path d="M15.0492 49.7876C12.2418 49.7876 9.96533 47.5111 9.96533 44.7037C9.96533 41.8964 12.2418 39.6199 15.0492 39.6199C17.8561 39.6199 20.133 41.8964 20.133 44.7037C20.1298 47.5099 17.8553 49.7844 15.0492 49.7876ZM15.0492 41.6533C13.3641 41.6533 11.9988 43.0187 11.9988 44.7037C11.9988 46.3884 13.3641 47.7541 15.0492 47.7541C16.7338 47.7541 18.0992 46.3884 18.0992 44.7037C18.0992 43.0187 16.7338 41.6533 15.0492 41.6533Z" fill="#5EB3D1"/>
                                        <path d="M14.3306 19.5823L20.4309 13.4819L21.8689 14.9199L15.7686 21.0203L14.3306 19.5823Z" fill="#E34B87"/>
                                        <path d="M14.3291 31.7826L20.4295 25.6826L21.8671 27.1202L15.7667 33.2206L14.3291 31.7826Z" fill="#E34B87"/>
                                        <path d="M14.3286 43.9842L20.429 37.8838L21.867 39.3218L15.7666 45.4222L14.3286 43.9842Z" fill="#E34B87"/>
                                        <path d="M67.9208 46.7372C67.9208 54.5989 61.5478 60.9718 53.6862 60.9718C45.8245 60.9718 39.4512 54.5989 39.4512 46.7372C39.4512 38.8756 45.8245 32.5022 53.6862 32.5022C61.5478 32.5022 67.9208 38.8756 67.9208 46.7372Z" fill="#D71921"/>
                                        <path d="M53.8997 53.2522C53.3846 53.2522 52.8911 53.7051 52.9149 54.237C52.9388 54.7705 53.3476 55.2218 53.8997 55.2218C54.4148 55.2218 54.9083 54.7688 54.8845 54.237C54.8606 53.7034 54.4518 53.2522 53.8997 53.2522Z" fill="white"/>
                                        <path d="M53.8996 38C51.198 38 49 40.198 49 42.8996C49 43.4435 49.4409 43.8844 49.9848 43.8844C50.5286 43.8844 50.9696 43.4435 50.9696 42.8996C50.9696 41.284 52.284 39.9696 53.8996 39.9696C55.5152 39.9696 56.8297 41.284 56.8297 42.8996C56.8297 44.5152 55.5152 45.8297 53.8996 45.8297C53.3558 45.8297 52.9148 46.2706 52.9148 46.8145V50.831C52.9148 51.3749 53.3558 51.8158 53.8996 51.8158C54.4435 51.8158 54.8844 51.375 54.8844 50.831V47.6998C57.1157 47.2427 58.7993 45.2641 58.7993 42.8996C58.7993 40.198 56.6013 38 53.8996 38Z" fill="white"/>
                                        <path d="M10.9818 55.888H37.418V53.8545H10.9818C9.29716 53.8545 7.93141 52.4888 7.93141 50.8041V6.06603C7.93141 4.38139 9.29716 3.01604 10.9818 3.01604H55.7199C57.4045 3.01604 58.7703 4.38139 58.7703 6.06603V29.4522H60.8038V6.06603C60.8006 3.25989 58.5264 0.985371 55.7199 0.982178H10.9818C8.17566 0.985371 5.90114 3.25989 5.89795 6.06603V50.8041C5.90114 53.6107 8.17566 55.8852 10.9818 55.888Z" fill="#1B1464"/>
                                        <path d="M9.96484 5.04956H11.9987V7.08302H9.96484V5.04956Z" fill="#1B1464"/>
                                        <path d="M14.0322 5.04956H16.0657V7.08302H14.0322V5.04956Z" fill="#1B1464"/>
                                        <path d="M18.0991 5.04956H20.133V7.08302H18.0991V5.04956Z" fill="#1B1464"/>
                                        <path d="M9.96484 9.11646H56.7368V11.1503H9.96484V9.11646Z" fill="#1B1464"/>
                                        <path d="M20.4306 13.4814L17.848 16.0641C15.4992 14.5095 12.3363 15.1529 10.7814 17.5017C9.22685 19.8508 9.87022 23.0138 12.2194 24.5683C14.5681 26.1232 17.7311 25.4795 19.286 23.1307C20.4155 21.4245 20.4155 19.2079 19.286 17.5017L21.8682 14.9194L20.4306 13.4814ZM15.0491 23.3514C13.364 23.3514 11.9987 21.9857 11.9987 20.301C11.9987 18.6164 13.364 17.2506 15.0491 17.2506C15.5012 17.2526 15.9486 17.3564 16.3553 17.5555L14.3303 19.581L15.7679 21.019L17.7941 18.9943C17.9937 19.401 18.0975 19.8484 18.0994 20.301C18.099 21.9857 16.7337 23.3514 15.0491 23.3514Z" fill="#1B1464"/>
                                        <path d="M23.1831 17.2505H40.4685V19.2839H23.1831V17.2505Z" fill="#1B1464"/>
                                        <path d="M23.1831 21.3176H30.3008V23.3515H23.1831V21.3176Z" fill="#1B1464"/>
                                        <path d="M32.334 21.3176H46.569V23.3515H32.334V21.3176Z" fill="#1B1464"/>
                                        <path d="M42.502 17.2505H52.6697V19.2839H42.502V17.2505Z" fill="#1B1464"/>
                                        <path d="M20.4306 25.6826L17.848 28.2653C15.4992 26.7107 12.3363 27.3545 10.7814 29.7032C9.22685 32.052 9.87022 35.2149 12.2194 36.7699C14.5681 38.3244 17.7311 37.6806 19.286 35.3319C20.4155 33.6257 20.4155 31.4094 19.286 29.7032L21.8682 27.1206L20.4306 25.6826ZM15.0491 35.5526C13.364 35.5526 11.9987 34.1868 11.9987 32.5022C11.9987 30.8176 13.364 29.4518 15.0491 29.4518C15.5012 29.4538 15.9486 29.5576 16.3553 29.7571L14.3303 31.7826L15.7679 33.2202L17.7941 31.1959C17.9937 31.6026 18.0975 32.05 18.0994 32.5022C18.099 34.1872 16.7337 35.5526 15.0491 35.5526Z" fill="#1B1464"/>
                                        <path d="M23.1831 29.4519H40.4685V31.4858H23.1831V29.4519Z" fill="#1B1464"/>
                                        <path d="M23.1831 33.519H30.3008V35.5525H23.1831V33.519Z" fill="#1B1464"/>
                                        <path d="M32.334 33.519H40.4682V35.5525H32.334V33.519Z" fill="#1B1464"/>
                                        <path d="M42.502 29.4519H46.5693V31.4858H42.502V29.4519Z" fill="#1B1464"/>
                                        <path d="M20.4306 37.884L17.848 40.4667C15.4992 38.9121 12.3363 39.5555 10.7814 41.9043C9.22685 44.253 9.87022 47.4164 12.2194 48.9709C14.5681 50.5254 17.7311 49.8821 19.286 47.5333C20.4155 45.8271 20.4155 43.6105 19.286 41.9043L21.8682 39.3216L20.4306 37.884ZM15.0491 47.754C13.364 47.754 11.9987 46.3883 11.9987 44.7036C11.9987 43.0186 13.364 41.6532 15.0491 41.6532C15.5012 41.6552 15.9486 41.759 16.3553 41.9581L14.3303 43.9836L15.7679 45.4212L17.7941 43.3969C17.9937 43.8036 18.0975 44.251 18.0994 44.7036C18.099 46.3883 16.7337 47.754 15.0491 47.754Z" fill="#1B1464"/>
                                        <path d="M23.1831 41.6533H36.4012V43.6868H23.1831V41.6533Z" fill="#1B1464"/>
                                        <path d="M23.1831 45.7202H30.3008V47.7541H23.1831V45.7202Z" fill="#1B1464"/>
                                        <path d="M32.334 45.7202H36.4009V47.7541H32.334V45.7202Z" fill="#1B1464"/>
                                        <path d="M53.6866 61.9887C62.1094 61.9887 68.9382 55.1599 68.9382 46.7371C68.9382 38.3143 62.1094 31.4856 53.6866 31.4856C45.2638 31.4856 38.4351 38.3143 38.4351 46.7371C38.4442 55.1559 45.2678 61.9795 53.6866 61.9887ZM53.6866 33.5191C60.9871 33.5191 66.9047 39.4366 66.9047 46.7371C66.9047 54.0376 60.9871 59.9552 53.6866 59.9552C46.3861 59.9552 40.4685 54.0376 40.4685 46.7371C40.4765 39.4406 46.3901 33.527 53.6866 33.5191Z" fill="#1B1464"/>
                                        </svg>

                                        <h3 class="cart-craft-text mb-0 mt-3">
                                            Reseller's transaction history is empty.
                                        </h3>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                @else
                    <div class="card mt-4">
                        <div class="card-body">
                            <p class="text-center mb-0">Reseller Information not Available</p>
                        </div>
                    </div>
                @endif
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
