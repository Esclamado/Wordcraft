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
                                    {{ translate('Customer Orders') }}
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
                                        <li class="active"><a href="{{ route('reseller.customer_orders') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('Customer Orders') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="customer-orders-margin mb-3">
                        <div class="">
                            <div class="cart-craft-count cart-craft-count-warning">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $pending_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->where('order_status', 'pending')
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $pending_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle">
                                            Pending Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="cart-craft-count cart-craft-count-primary">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $declined_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->where('order_status', 'declined')
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $declined_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle">
                                            Advance Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="cart-craft-count" style="background: var(--primary-red);">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $declined_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->where('order_status', 'declined')
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $declined_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle">
                                            Declined Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="cart-craft-count cart-craft-count-success">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $successful_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->where('order_status', 'picked_up')
                                                    ->where('payment_status', 'paid')
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $successful_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle">
                                            Successful Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="cart-craft-count cart-craft-count-info">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $total_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $total_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle" style="font-size: 16px;">
                                            Total Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <a href="{{ route('reseller.customer_orders') }}" class="card-tab card-tab-active mr-3">
                            Customer Orders
                        </a>

                        <a href="{{ route('reseller.customer_orders_returns') }}" class="card-tab mr-3">
                            Returns
                        </a>
                    </div>
                    <div class="card card-craft-min-height border-0 shadow-none">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active show" id="customer_orders_tab">
                                    @php
                                    $status = $order->orderDetails->first()->delivery_status;
                                    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                
                                    $payment_method = \App\OtherPaymentMethod::where('unique_id', $order->payment_type)
                                        ->first()->type ?? null;
                
                                    $order_payment = \App\OrderPayment::where('order_id', $order->id)
                                        ->select('id','order_id')
                                        ->first();
                                    @endphp
                    
                                    @if ($order->payment_status != 'paid')
                                        @if ($payment_method == 'multiple_payment_option' && $order_payment == null && $order->user_id == Auth::user()->id)
                                            <div class="order-details-unpaid-notification mt-4">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="d-flex justify-content-start">
                                                            <div class="mr-3">
                                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9905 1.8335C5.93051 1.8335 1.83301 5.94016 1.83301 11.0002C1.83301 16.0602 5.93051 20.1668 10.9905 20.1668C16.0597 20.1668 20.1663 16.0602 20.1663 11.0002C20.1663 5.94016 16.0597 1.8335 10.9905 1.8335ZM10.9997 18.3335C6.94801 18.3335 3.66634 15.0518 3.66634 11.0002C3.66634 6.9485 6.94801 3.66683 10.9997 3.66683C15.0513 3.66683 18.333 6.9485 18.333 11.0002C18.333 15.0518 15.0513 18.3335 10.9997 18.3335ZM10.083 6.41683H11.458V11.2293L15.583 13.6768L14.8955 14.8043L10.083 11.9168V6.41683Z" fill="#E49F1A"/>
                                                                </svg>
                                                            </div>
                                                            <div class="order-details-unpaid-notification-subtitle">
                                                                For bank transfer and over-the-counter deposit transactions, you will be required to upload the proof of payment. Your order will not be processed until the funds have cleared in our account.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="d-flex justify-content-end align-items-center h-100">
                                                            <div>
                                                                <a href="{{ route('purchase_history.upload_receipt', encrypt($order->id ?? "N/A" )) }}" class="btn btn-primary">
                                                                    Pay Now
                                                                    <svg class="ml-3" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M13.0998 8.25H3.27344V9.75H13.0998V12L16.3643 9L13.0998 6V8.25Z" fill="white"/>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                    
                                    <div class="card @if ($order->payment_status != 'unpaid') mt-4 @endif">
                                        <div class="card-body">
                                            {{-- Steps Delivery --}}
                                            <div class="steps-container">
                                                <div class="row gutters-5 text-center aiz-steps">
                                                    <div class="col @if($status == 'order_placed') active @else done @endif">
                                                        <div class="icon">
                                                            <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.07573 8.82324L0.175729 4.90081C-0.0585762 4.66516 -0.0585762 4.28308 0.175729 4.0474L1.02424 3.19399C1.25854 2.95832 1.63846 2.95832 1.87277 3.19399L4.5 5.8363L10.1272 0.176739C10.3615 -0.058913 10.7415 -0.058913 10.9758 0.176739L11.8243 1.03015C12.0586 1.2658 12.0586 1.64789 11.8243 1.88356L4.92426 8.82326C4.68994 9.05892 4.31004 9.05892 4.07573 8.82324Z" fill="white"/>
                                                            </svg>
                                                        </div>
                                                        <div class="title fs-12">{{ translate('Order placed') }}</div>
                                                    </div>
                                                    <div class="col @if($status == 'confirmed') done active @elseif ($status == 'processing' || $status == 'ready_for_pickup' || $status == 'picked_up') done @endif">
                                                        <div class="icon">
                                                            @if($status == 'confirmed' || $status == 'processing' || $status == 'partial_release' || $status == 'ready_for_pickup' || $status == 'pciked_up')
                                                                <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4.07573 8.82324L0.175729 4.90081C-0.0585762 4.66516 -0.0585762 4.28308 0.175729 4.0474L1.02424 3.19399C1.25854 2.95832 1.63846 2.95832 1.87277 3.19399L4.5 5.8363L10.1272 0.176739C10.3615 -0.058913 10.7415 -0.058913 10.9758 0.176739L11.8243 1.03015C12.0586 1.2658 12.0586 1.64789 11.8243 1.88356L4.92426 8.82326C4.68994 9.05892 4.31004 9.05892 4.07573 8.82324Z" fill="white"/>
                                                                </svg>
                                                            @else
                                                                2
                                                            @endif
                                                        </div>
                                                        <div class="title fs-12">
                                                            {{ translate('Confirmed') }}
                                                        </div>
                                                    </div>
                    
                                                    <div class="col @if($status == 'processing') done active @elseif ($status == 'ready_for_pickup' || $status == 'picked_up') done @endif">
                                                        <div class="icon">
                                                            @if($status == 'processing' || $status == 'partial_release' || $status == 'ready_for_pickup' || $status == 'picked_up')
                                                                <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4.07573 8.82324L0.175729 4.90081C-0.0585762 4.66516 -0.0585762 4.28308 0.175729 4.0474L1.02424 3.19399C1.25854 2.95832 1.63846 2.95832 1.87277 3.19399L4.5 5.8363L10.1272 0.176739C10.3615 -0.058913 10.7415 -0.058913 10.9758 0.176739L11.8243 1.03015C12.0586 1.2658 12.0586 1.64789 11.8243 1.88356L4.92426 8.82326C4.68994 9.05892 4.31004 9.05892 4.07573 8.82324Z" fill="white"/>
                                                                </svg>
                                                            @else
                                                                3
                                                            @endif
                                                        </div>
                                                        <div class="title fs-12">
                                                            {{ translate('Processing') }}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col @if($status == 'partial_release') done active @elseif ($status == 'ready_for_pickup' || $status == 'picked_up') done @endif">
                                                        <div class="icon">
                                                            @if($status == 'partial_release' || $status == 'ready_for_pickup' || $status == 'picked_up')
                                                                <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4.07573 8.82324L0.175729 4.90081C-0.0585762 4.66516 -0.0585762 4.28308 0.175729 4.0474L1.02424 3.19399C1.25854 2.95832 1.63846 2.95832 1.87277 3.19399L4.5 5.8363L10.1272 0.176739C10.3615 -0.058913 10.7415 -0.058913 10.9758 0.176739L11.8243 1.03015C12.0586 1.2658 12.0586 1.64789 11.8243 1.88356L4.92426 8.82326C4.68994 9.05892 4.31004 9.05892 4.07573 8.82324Z" fill="white"/>
                                                                </svg>
                                                            @else
                                                                4
                                                            @endif
                                                        </div>
                                                        <div class="title fs-12">
                                                            {{ translate('Partial Release') }}
                                                        </div>
                                                    </div>

                                                    <div class="col @if($status == 'ready_for_pickup') done active @elseif($status == 'picked_up') done @endif">
                                                        <div class="icon">
                                                            @if($status == 'ready_for_pickup' || $status == 'picked_up')
                                                                <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4.07573 8.82324L0.175729 4.90081C-0.0585762 4.66516 -0.0585762 4.28308 0.175729 4.0474L1.02424 3.19399C1.25854 2.95832 1.63846 2.95832 1.87277 3.19399L4.5 5.8363L10.1272 0.176739C10.3615 -0.058913 10.7415 -0.058913 10.9758 0.176739L11.8243 1.03015C12.0586 1.2658 12.0586 1.64789 11.8243 1.88356L4.92426 8.82326C4.68994 9.05892 4.31004 9.05892 4.07573 8.82324Z" fill="white"/>
                                                                </svg>
                                                            @else
                                                                4
                                                            @endif
                    
                                                        </div>
                                                        <div class="title fs-12">{{ translate('Ready for Pickup')}}</div>
                                                    </div>
                                                    <div class="col @if($status == 'picked_up') done @endif">
                                                        <div class="icon">
                                                            @if($status == 'picked_up')
                                                            <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.07573 8.82324L0.175729 4.90081C-0.0585762 4.66516 -0.0585762 4.28308 0.175729 4.0474L1.02424 3.19399C1.25854 2.95832 1.63846 2.95832 1.87277 3.19399L4.5 5.8363L10.1272 0.176739C10.3615 -0.058913 10.7415 -0.058913 10.9758 0.176739L11.8243 1.03015C12.0586 1.2658 12.0586 1.64789 11.8243 1.88356L4.92426 8.82326C4.68994 9.05892 4.31004 9.05892 4.07573 8.82324Z" fill="white"/>
                                                            </svg>
                                                            @else
                                                                5
                                                            @endif
                                                        </div>
                                                        <div class="title fs-12">{{ translate('Picked Up')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="d-flex justify-content-start border-bottom mt-4">
                                                <div class="card-customer-wallet-title">
                                                    Order Summary
                                                </div>
                                            </div>
                    
                                            <div class="row mt-4">
                                                <div class="col-lg-6">
                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td class="w-50 order-details-title px-0 py-2">{{ translate('Name')}}:</td>
                                                            <td class="order-details-subtitle px-0 py-2">{{ $order->user->name ?? "N/A" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 order-details-title px-0 py-2">{{ translate('Phone Number')}}:</td>
                                                            <td class="order-details-subtitle px-0 py-2">{{ $order->user->phone ?? "N/A" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 order-details-title px-0 py-2">{{ translate('Email')}}:</td>
                                                            @if ($order->user_id != null)
                                                                <td class="order-details-subtitle px-0 py-2">{{ $order->user->email ?? "N/A" }}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 order-details-title px-0 py-2">{{ translate('Order date') }}:</td>
                                                            <td class="order-details-subtitle px-0 py-2">{{ date('d-m-Y h:i A', $order->date ?? "N/A") }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td class="w-50 order-details-title px-0 py-2">{{ translate('Payment Status')}}:</td>
                                                            <td class="order-details-subtitle px-0 py-2 @if ($order->payment_status == 'paid') text-success @else text-danger @endif">{{ translate(ucfirst($order->payment_status)) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 order-details-title px-0 py-2">{{ translate('Payment method')}}:</td>
                                                            <td class="order-details-subtitle px-0 py-2"> {{ ucfirst(str_replace('_', '  ', $order->payment_type ?? "N/A")) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 order-details-title px-0 py-2">{{ translate('Pickup Point') }}:</td>
                                                            <td class="order-details-subtitle px-0 py-2"> {{ $order->pickup_point_location ?? "N/A" }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                    
                                            <div class="d-flex justify-content-start border-bottom mt-4">
                                                <div class="card-customer-wallet-title">
                                                    Order Details
                                                </div>
                                            </div>
                    
                                                <div class="row mt-4">
                                                    <div class="col-lg-8 table-responsive">
                                                        <table class="table table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <th class="order-details-title">#</th>
                                                                    <th class="order-details-title" width="30%">{{ translate('Product')}}</th>
                                                                    <th class="order-details-title text-center">{{ translate('Quantity')}}</th>
                                                                    <th class="order-details-title">{{ translate('Price')}}</th>
                                                                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                                                        <th class="order-details-title text-center">{{ translate('Request Return')}}</th>
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($order->orderDetails as $key => $orderDetail)
                                                                    <tr>
                                                                        <td class="order-details-subtitle">{{ $key+1 }}</td>
                                                                        <td class="order-details-subtitle">
                                                                            @if ($orderDetail->product != null)
                                                                                <a href="{{ route('product', $orderDetail->product->slug ?? "N/A") }}" target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a>
                                                                            @else
                                                                                <strong>{{  translate('Product Unavailable') }}</strong>
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
                                                                        </td>
                                                                        <td class="order-details-subtitle text-center">
                                                                            {{ $orderDetail->quantity ?? "N/A" }}
                                                                        </td>
                                                                        <td class="order-details-subtitle">{{ single_price($orderDetail->price ?? "N/A") }}</td>
                                                                        @if ($order->user_id == Auth::user()->id)
                                                                            @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                                                                @php
                                                                                    $no_of_max_day = \App\BusinessSetting::where('type', 'refund_request_time')->first()->value;
                                                                                    $last_refund_date = $orderDetail->created_at->addDays($no_of_max_day);
                                                                                    $today_date = Carbon\Carbon::now();
                                                                                @endphp
                                                                                <td class="order-details-subtitle text-center">
                                                                                    @if ($orderDetail->product != null && $orderDetail->product->refundable != 0 && $orderDetail->refund_request == null && $today_date <= $last_refund_date && $orderDetail->delivery_status == 'picked_up')
                                                                                        <a href="{{route('refund_request_send_page', encrypt($orderDetail->id))}}" class="btn btn-block btn-craft-red text-elipsis">{{  translate('Send Request') }}</a>
                                                                                    @elseif ($orderDetail->refund_request != null && $orderDetail->refund_request->refund_status == 0)
                                                                                        <b class="text-info">{{  translate('Pending') }}</b>
                                                                                    @elseif ($orderDetail->refund_request != null && $orderDetail->refund_request->refund_status == 1)
                                                                                        <b class="text-success">{{  translate('Accepted') }}</b>
                                                                                    @elseif ($orderDetail->product->refundable != 0)
                                                                                        <b>{{  translate('N/A') }}</b>
                                                                                    @else
                                                                                        <b>{{  translate('Non-refundable') }}</b>
                                                                                    @endif
                                                                                </td>
                                                                            @endif
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="order-details-amount-summary mt-4 mt-md-0">
                                                            <h1 class="order-details-amount-summary-title">
                                                                Order Amount
                                                            </h1>
                                                            <hr>
                                                            <table class="table table-borderless">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="w-50 order-details-amount-summary-subtitle px-0 py-2">{{ translate('Subtotal')}}</td>
                                                                        <td class="text-right order-details-amount px-0 py-2">
                                                                            <span class="strong-600">{{ single_price($order->orderDetails->sum('price') ?? "N/A" ) }}</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 order-details-amount-summary-subtitle px-0 py-2">{{ translate('Handling Fee')}}</td>
                                                                        <td class="text-right order-details-amount px-0 py-2">
                                                                            <span class="text-italic">{{ single_price($order->orderDetails->sum('shipping_cost') ?? "N/A" ) }}</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 order-details-amount-summary-subtitle px-0 py-2">{{ translate('Tax')}}</td>
                                                                        <td class="text-right order-details-amount px-0 py-2">
                                                                            <span class="text-italic">{{ single_price($order->orderDetails->sum('tax') ?? "N/A" ) }}</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="border-bottom">
                                                                        <td class="w-50 order-details-amount-summary-subtitle px-0 py-2">{{ translate('Coupon')}}</td>
                                                                        <td class="text-right order-details-amount px-0 py-2">
                                                                            <span class="text-italic">{{ single_price($order->coupon_discount ?? "N/A" ) }}</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 order-details-amount-summary-subtitle px-0 py-2">{{ translate('Total')}}</td>
                                                                        <td class="text-right order-details-amount px-0 py-2">
                                                                            <strong><span>{{ single_price($order->grand_total ?? "N/A" ) }}</span></strong>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @if ($order->manual_payment && $order->manual_payment_data == null)
                                                            <button onclick="show_make_payment_modal({{ $order->id ?? 'N/A' }})" class="btn btn-block btn-primary">{{ translate('Make Payment')}}</button>
                                                        @endif
                                                    </div>
                                                </div>
                    
                    
                                            @if ($order->payment_status != 'paid')
                                                @if ($payment_method == 'single_payment_option' || $payment_method == 'e_wallet' && $payment_method == null)
                                                    <div class="steps-container h-100 mt-4">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    <div class="order-details-title mb-2">
                                                                        Attach proof of payment (optional)
                                                                    </div>
                                                                    <div class="order-details-subtitle">
                                                                        For other payment options except Bank Transfer and Over-the-counter Deposit, users have the choice to attach their proof of payment.
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 d-flex align-items-center justify-content-end">
                                                                    <a href="{{ route('purchase_history.upload_receipt', encrypt($order->id)) }}" class="btn btn-primary">
                                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z" fill="white"/>
                                                                        </svg>
                    
                                                                        Upload Receipt
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                    
                                            @php
                                                $order_payment = \App\OrderPayment::where('order_id', $order->id)
                                                    ->first();
                    
                                                if ($order_payment != null) {
                                                    $photos = explode(',', $order_payment->proof_of_payment);
                                                }
                                            @endphp
                    
                                            @if ($order->payment_status != 'paid')
                                                @if ($order_payment != null)
                                                    <div class="steps-container h-100 mt-4">
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <div class="order-details-title mb-2">
                                                                    Verifying payment...
                                                                </div>
                                                                <div class="order-details-subtitle">
                                                                    We are currently verifying your payment, this might take at least 12-24 hours. Kindly wait.
                                                                </div>
                                                                <div class="order-details-uploaded-images-label mt-3">
                                                                    Uploaded Receipts
                                                                </div>
                                                                <ul class="list-unstyled mt-2 mb-0">
                                                                    @foreach ($photos as $key => $value)
                                                                        <li class="mb-3" style="color: #1B1464;">
                                                                            <a href="{{ uploaded_asset($value) }}" target="_blank">
                                                                                {{ str_replace('uploads/all/', '', uploaded_asset_name($value)) }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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