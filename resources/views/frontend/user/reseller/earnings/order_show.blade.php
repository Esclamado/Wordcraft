@extends('frontend.layouts.app')

@section('content')

<section class="py-5 lightblue-bg">
    <div class="container">
        <div class="d-lg-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <a href="{{ route('reseller.customer_orders') }}" class="back-to-page d-flex align-items-center">
                    <svg class="mr-3" width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.25 4.20833H3.03208L5.86625 1.36625L4.75 0.25L0 5L4.75 9.75L5.86625 8.63375L3.03208 5.79167H14.25V4.20833Z" fill="#1B1464"/>
                    </svg>
                    Back to Customer Orders
                </a>

                <div class="row">
                    <div class="col-md-6">
                        <h1 class="customer-craft-dashboard-title mt-4 mb-3">
                            {{ translate('Order Code') }}: {{ $order->code ?? "N/A" }}
                        </h1>
                    </div>

                    <div class="col-md-6">
                        <a href="{{ route('customer.invoice.download', $order->id ?? "N/A") }}" class="order-details-download-invoice">
                            <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4577 7.229H10.6244V2.979H6.37435V7.229H3.54102L8.49935 12.1873L13.4577 7.229ZM7.79102 8.64567V4.39567H9.20768V8.64567H10.0364L8.49935 10.1828L6.96227 8.64567H7.79102ZM13.4577 15.0207V13.604H3.54102V15.0207H13.4577Z" fill="#62616A"/>
                            </svg>
                            Download Order Details
                        </a>
                    </div>
                </div>

                @php
                    $status = $order->orderDetails->first()->delivery_status;
                    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();

                    if ($order->payment_option != null) {
                        if ($order->payment_option != 'paynamics') {
                            $payment_method = \App\OtherPaymentMethod::where('unique_id', $order->payment_type)
                                ->first()->type;
                        }

                        else {
                            $payment_method = 'paynamics';
                        }
                    }

                    $order_payment = \App\OrderPayment::where('order_id', $order->id)
                        ->select('id','order_id')
                        ->first();
                @endphp

                <div class="card">
                    <div class="card-body">
                        {{-- Steps --}}
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
                                <div class="col @if($status == 'confirmed') done active @elseif ($status == 'processing' || $status == 'partial_release' || $status == 'ready_for_pickup' || $status == 'picked_up') done @endif">
                                    <div class="icon">
                                        @if($status == 'confirmed' || $status == 'processing' || $status == 'partial_release' || $status == 'ready_for_pickup' || $status == 'picked_up')
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
                                            5
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
                                            6
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
                                        <td class="order-details-subtitle px-0 py-2">
                                            <span class="@if ($order->payment_status == 'paid') text-success @else text-danger @endif">{{ translate(ucfirst($order->payment_status)) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        @php
                                            if ($order->payment_channel != null) {
                                                $payment_channel = \App\PaymentChannel::where('value', $order->payment_channel)->first()->name;
                                            }
                                        @endphp
                                        <td class="w-50 order-details-title px-0 py-2">{{ translate('Payment method')}}:</td>
                                        <td class="order-details-subtitle px-0 py-2">
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}

                                            @if ($order->payment_channel != null)
                                                / {{ $payment_channel }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 order-details-title px-0 py-2">{{ translate('Pickup Point') }}:</td>
                                        <td class="order-details-subtitle px-0 py-2">
                                            @php
                                                $pickup_point = ucwords(str_replace('_', ' ', $order->pickup_point_location));
                                                $address = \App\PickupPoint::where('name', $pickup_point)
                                                    ->first(['address' ?? null]);
                                            @endphp
                                            <div>
                                                <strong>{{ $pickup_point }}</strong>
                                            </div>
                                            <div>
                                                {{ $address != null ? $address->address : 'N/A' }}
                                            </div>
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
                                                <td class="order-details-subtitle">{{ single_price($orderDetail->price) }}</td>
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
                                                <td class="w-50 order-details-amount-summary subtitle px-0 py-2">{{ translate('Subtotal')}}</td>
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
                                            @if ($order->convenience_fee != null)
                                            <tr>
                                                <td class="w-50 order-details-amount-summary-subtitle px-0 py-2">{{ translate('Convenience Fee')}}</td>
                                                <td class="text-right order-details-amount px-0 py-2">
                                                    <span class="text-italic">{{ single_price($order->convenience_fee ?? "N/A" ) }}</span>
                                                </td>
                                            </tr>
                                            @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
