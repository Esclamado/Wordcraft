@extends('frontend.layouts.app')

@section('content')
    <div style="background-color: #F2F5FA;">
        <section class="mb-5">
            <div class="container"></div>
        </section>

        <section class="mb-5">
            <div class="container text-left">
                <div class="position-absolute">
                    <div class="img-28"></div>
                    <div class="img-29"></div>
                    <div class="img-30"></div>
                </div>
                <div class="row">
                    <div class="col-xxl-10 col-xl-10 col-lg-10 mx-auto">
                        <form class="" action="{{ route('orders.track') }}" method="GET" enctype="multipart/form-data">
                            <div class="bg-white rounded shadow-sm py-3 px-lg-5">
                                <div class="pt-3 text-center">
                                   <p class="fw-600 text-subheader-title text-header-blue m-0">{{ translate('Track Order')}}</p>
                                    <span class="text-title-thin">{{ translate('Check the status of your order')}}.</span>
                                </div>
                                <div class="form-box-content p-lg-4 py-4">
                                    <div class="form-group col-xxl-8 col-xl-8 col-lg-8 mx-lg-auto">
                                        <input type="text" class="form-craft form-control mb-3" placeholder="{{ translate('Enter Order Code')}}" name="order_code" @isset($order) value="{{ $order->code }}" @endisset required>
                                    </div>
                                    <div class="text-center col-xxl-8 col-xl-8 col-lg-8 mx-lg-auto">
                                        <button type="submit" class="btn btn-primary btn-craft-primary-nopadding w-100">{{ translate('Track Order')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @isset($order)
                    <div class="row mt-4">
                        <div class="col-xxl-10 col-xl-10 col-lg-10 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-start border-bottom">
                                        <div class="card-customer-wallet-title">
                                            {{ translate('Order Summary') }}
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 col-lg-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="w-50 order-details-title px-0 py-2">{{ translate('Order Code')}}:</td>
                                                    <td class="order-details-subtitle px-0 py-2">{{ $order->code }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 order-details-title px-0 py-2">{{ translate('Name')}}:</td>
                                                    <td class="order-details-subtitle px-0 py-2">{{ $order->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 order-details-title px-0 py-2">{{ translate('Phone Number')}}:</td>
                                                    <td class="order-details-subtitle px-0 py-2">{{ $order->user->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 order-details-title px-0 py-2">{{ translate('Email')}}:</td>
                                                    <td class="order-details-subtitle px-0 py-2">{{ $order->user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-50 order-details-title px-0 py-2">{{ translate('Order Date')}}:</td>
                                                    <td class="order-details-subtitle px-0 py-2">{{ date('Y-m-d h:i A', $order->date) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="w-50 order-details-title px-0 py-2">{{ translate('Total Order Amount')}}:</td>
                                                    <td class="order-details-subtitle px-0 py-2">{{ single_price($order->grand_total) }}</td>
                                                </tr>
                                                <tr>
                                                    @php
                                                        if ($order->payment_channel != null) {
                                                            $payment_channel = \App\PaymentChannel::where('value', $order->payment_channel)->first()->name;
                                                        }
                                                    @endphp
                                                    <td class="w-50 order-details-title px-0 py-2">{{ translate('Payment Method')}}:</td>
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

                                    @php
                                        $status = $order->orderDetails->first()->delivery_status;
                                    @endphp

                                    <div class="my-4">
                                        <div class="steps-container">
                                            <div class="row gutters-6 text-center aiz-steps">
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
                                                        @if($status == 'confirmed' || $status == 'processing' || $status == 'partial_release' || $status == 'confirmed' || $status == 'ready_for_pickup' || $status == 'picked_up')
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
        
                                                <div class="col @if($status == 'processing') done active @elseif ($status == 'partial_release' || $status == 'ready_for_pickup' || $status == 'picked_up') done @endif">
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
        
                                                <div class="col @if($status == 'partial_release') done active @elseif ($status == 'partial_release' || $status == 'ready_for_pickup' || $status == 'picked_up') done @endif">
                                                    <div class="icon">
                                                        @if($status == 'partial_release'|| $status == 'ready_for_pickup' || $status == 'picked_up')
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
                                                    <div class="title fs-12">{{ translate('Picked up')}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th class="order-details-title px-0">{{ translate('Product') }}</th>
                                                    <th class="order-details-title px-0 text-center">{{ translate('Quantity') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderDetails as $key => $orderDetail)
                                                    <tr>
                                                        <td class="order-details-subtitle px-0">
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-3">
                                                                    @php
                                                                        $product_image = null;

                                                                        if ($orderDetail->product != null) {
                                                                            if ($orderDetail->variation != "") {
                                                                                $product_image = \App\ProductStock::where('product_id', $orderDetail->product_id)
                                                                                    ->where('variant', $orderDetail->variation)
                                                                                    ->first()->image;

                                                                                if ($product_image != null) {
                                                                                    $product_image = uploaded_asset($product_image);
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
                                                                <div>
                                                                    @if ($orderDetail->product != null)
                                                                        {{ $orderDetail->product->getTranslation('name') }} 
                                                                        @if ($orderDetail->variation != null)
                                                                            - {{ $orderDetail->variation }}
                                                                        @endif
                                                                    @else
                                                                        Product Unavailable
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

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="order-details-subtitle px-0 text-center">
                                                            {{ $orderDetail->quantity }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </section>
    </div>
@endsection

@isset($order)
    @section('script')
        <script type="text/javascript">
            var processing = false;

            function check_payment () {
                var data = {
                    '_token': "{{ csrf_token() }}",
                    'order_id': "{{ $order->id }}",
                    'type': 'order'
                };

                if (processing == false) {
                    processing = true;
                    
                    $('#check_payment_id').addClass('spinner-border spinner-border-sm')
                    $('#icon-check').hide();
                    
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('paynamics.query_check') }}',
                        data: data,
                        success: function (data) {
                            if (data.success) {
                                $('#check_payment_id').removeClass('spinner-border spinner-border-sm')
                                $('#check-text').show();
                                $('#check-text').text('Redirecting...')
                                
                                AIZ.plugins.notify('success', '{{ translate('Query is processing. Redirecting you now...') }}');

                                setTimeout(function () {
                                    window.location = data.url;
                                }, 1000);
                            }
                        }
                    })
                }
            }
        </script>
    @endsection
@endisset