@extends('frontend.layouts.app')

@section('content')

<section class="py-5 mb-4">
    <div class="container">
        @php
            $order_count = 0;
        @endphp

        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="steps-container border-0">
                    <div class="row">
                        <div class="col-7 mx-auto">
                            <div class="row gutters-5 text-center aiz-steps">
                                <div class="col active done">
                                    <div class="icon">
                                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3 9.97C15.96 10.59 15.3 11 14.55 11H7.1L6 13H18V15H6C4.48 15 3.52 13.37 4.25 12.03L5.6 9.59L2 2H0V0H3.27L4.21 2H19.01C19.77 2 20.25 2.82 19.88 3.48L16.3 9.97ZM17.3099 4H5.15989L7.52989 9H14.5499L17.3099 4ZM6.00004 16C4.90003 16 4.01003 16.9 4.01003 18C4.01003 19.1 4.90003 20 6.00004 20C7.10004 20 8.00004 19.1 8.00004 18C8.00004 16.9 7.10004 16 6.00004 16ZM14.01 18C14.01 16.9 14.9 16 16 16C17.1 16 18 16.9 18 18C18 19.1 17.1 20 16 20C14.9 20 14.01 19.1 14.01 18Z" fill="white"/>
                                        </svg>
                                    </div>
                                    <div class="title fs-12">{{ translate('My Cart') }}</div>
                                </div>
                                <div class="col active done">
                                    <div class="icon bg-white">
                                        <svg id="Layer_1" enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25" xmlns="http://www.w3.org/2000/svg"><g><path fill="white" d="m256 0c-108.81 0-197.333 88.523-197.333 197.333 0 61.198 31.665 132.275 94.116 211.257 45.697 57.794 90.736 97.735 92.631 99.407 6.048 5.336 15.123 5.337 21.172 0 1.895-1.672 46.934-41.613 92.631-99.407 62.451-78.982 94.116-150.059 94.116-211.257 0-108.81-88.523-197.333-197.333-197.333zm0 474.171c-38.025-36.238-165.333-165.875-165.333-276.838 0-91.165 74.168-165.333 165.333-165.333s165.333 74.168 165.333 165.333c0 110.963-127.31 240.602-165.333 276.838z"/><path fill="white" d="m378.413 187.852-112-96c-5.992-5.136-14.833-5.136-20.825 0l-112 96c-6.709 5.75-7.486 15.852-1.735 22.561s15.852 7.486 22.561 1.735l13.586-11.646v79.498c0 8.836 7.164 16 16 16h144c8.836 0 16-7.164 16-16v-79.498l13.587 11.646c6.739 5.777 16.836 4.944 22.561-1.735 5.751-6.709 4.974-16.81-1.735-22.561zm-66.413 76.148h-112v-90.927l56-48 56 48z"/></g></svg>
                                    </div>
                                    <div class="title fs-12">{{ translate("Customer Information") }}</div>
                                </div>
                                <div class="col active done">
                                    <div class="icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6667 3.33334H3.33341C2.40841 3.33334 1.67508 4.075 1.67508 5L1.66675 15C1.66675 15.925 2.40841 16.6667 3.33341 16.6667H16.6667C17.5917 16.6667 18.3334 15.925 18.3334 15V5C18.3334 4.075 17.5917 3.33334 16.6667 3.33334ZM16.6667 15H3.33341V10H16.6667V15ZM3.33341 6.66667H16.6667V5H3.33341V6.66667Z" fill="white"/>
                                        </svg>
                                    </div>
                                    <div class="title fs-12">
                                        {{ translate('Payment') }}
                                    </div>
                                </div>
                                <div class="col active done">
                                    <div class="icon">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.00008 0.666656C4.40008 0.666656 0.666748 4.39999 0.666748 8.99999C0.666748 13.6 4.40008 17.3333 9.00008 17.3333C13.6001 17.3333 17.3334 13.6 17.3334 8.99999C17.3334 4.39999 13.6001 0.666656 9.00008 0.666656ZM9.00008 15.6667C5.32508 15.6667 2.33341 12.675 2.33341 8.99999C2.33341 5.32499 5.32508 2.33332 9.00008 2.33332C12.6751 2.33332 15.6667 5.32499 15.6667 8.99999C15.6667 12.675 12.6751 15.6667 9.00008 15.6667ZM7.33341 10.8083L12.8251 5.31666L14.0001 6.49999L7.33341 13.1667L4.00008 9.83332L5.17508 8.65832L7.33341 10.8083Z" fill="white"/>
                                        </svg>
                                    </div>
                                    <div class="title fs-12">{{ translate('Confirmation')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($orders as $key => $order)
            @php
                $status = $order->orderDetails->first()->delivery_status;
                $order_count += 1;
            @endphp

            <div class="row">
                <div class="col-12 col-lg-10 mx-auto">
                    @if ($order_count != 0)
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center pt-4">
                                    <div class="text-center mb-4 w-100 w-md-50">
                                        <svg class="mb-3" width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0)">
                                                <path
                                                    d="M13.0368 10.0252C13.9395 9.613 14.8063 9.16819 15.5615 8.61872C18.3061 6.62127 20.1935 2.72625 23.4909 1.65563C26.6724 0.622632 30.4741 2.63062 34 2.63062C37.5259 2.63062 41.3276 0.622632 44.5091 1.65563C47.8065 2.72625 49.6939 6.62127 52.4385 8.61872C55.2107 10.6361 59.4907 11.2414 61.5081 14.0136C63.5056 16.7582 62.7717 21.0059 63.8424 24.3033C64.8754 27.4848 68 30.4741 68 34C68 37.5258 64.8754 40.5151 63.8424 43.6966C62.7718 46.994 63.5057 51.2417 61.5081 53.9863C59.4907 56.7585 55.2105 57.3638 52.4385 59.3812C49.6939 61.3786 47.8065 65.2737 44.5091 66.3443C41.3276 67.3773 37.5259 65.3693 34 65.3693C30.4741 65.3693 26.6724 67.3773 23.4909 66.3443C20.1935 65.2737 18.3061 61.3786 15.5615 59.3812C12.7893 57.3638 8.5093 56.7585 6.49188 53.9863C4.49443 51.2417 5.22834 46.994 4.15771 43.6966C3.12458 40.5151 0 37.5258 0 34C0 30.4741 3.12458 27.4848 4.15758 24.3033C5.2282 21.0059 4.49443 16.7582 6.49188 14.0136C7.12837 13.139 7.99007 12.4802 8.95849 11.9246"
                                                    fill="#10865C" />
                                                <path
                                                    d="M61.1239 34.4594C61.1239 37.3176 58.591 39.7409 57.7536 42.32C56.8856 44.9931 57.4807 48.4365 55.8614 50.6614C54.226 52.9086 50.7563 53.3992 48.5092 55.0348C46.2842 56.6541 44.7543 59.8115 42.0812 60.6795C39.5021 61.517 36.4202 59.8892 33.562 59.8892C30.7038 59.8892 27.6219 61.517 25.0429 60.6795C22.3698 59.8116 20.8399 56.6541 18.6149 55.0348C16.3677 53.3994 12.8981 52.9087 11.2625 50.6614C9.64327 48.4365 10.2382 44.9931 9.37031 42.3202C8.53283 39.7411 6 37.3179 6 34.4595C6 31.6013 8.53297 29.178 9.37031 26.5989C10.2382 23.9258 9.64327 20.4824 11.2625 18.2576C12.898 16.0105 16.3676 15.5198 18.6149 13.8843C20.8399 12.265 22.3698 9.10757 25.0429 8.23958C27.6219 7.4021 30.7038 9.02985 33.562 9.02985C36.4202 9.02985 39.5021 7.4021 42.0812 8.23944C44.7543 9.1073 46.2842 12.2648 48.5092 13.8841C50.7563 15.5195 54.2261 16.0102 55.8615 18.2575C57.4808 20.4824 56.8859 23.9258 57.7537 26.5988C58.591 29.1778 61.1239 31.6012 61.1239 34.4594Z"
                                                    fill="#F2F5FA" />
                                                <path
                                                    d="M25.5972 43.4086L20.503 37.2792C19.7342 36.3541 19.8609 34.9809 20.7859 34.2121L22.2141 33.0251C23.1391 32.2563 24.5122 32.383 25.2812 33.3081L27.8477 36.3961C28.4609 37.134 29.5806 37.172 30.2424 36.4773L43.363 23.6758C44.1927 22.8048 45.5713 22.7714 46.4422 23.601L47.7868 24.882C48.6578 25.7116 48.6912 27.0903 47.8615 27.9611L32.0133 43.6259C30.2402 45.4872 27.2403 45.3857 25.5972 43.4086Z"
                                                    fill="#10865C" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0">
                                                    <rect width="68" height="68" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>

                                        <div class="order-confirmed-title mb-3">
                                            Pending payment...
                                        </div>

                                        <div class="order-confirmed-subtitle">
                                            We will wait for your payment before we process your order. We will notify you immediately once we have received your payment.
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <div class="total-due-card">
                                                <div class="total-due-card-label">
                                                    Total Due
                                                </div>
                                                <div class="total-due-card-price">
                                                    {{ single_price($order->grand_total) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $paynamics_transaction = \App\PaynamicsTransactionRequest::where('type', 'order')
                                        ->where('notifiable_id', $order->id)
                                        ->first();

                                    $status = $paynamics_transaction->response_message;
                                    $payment_channel = \App\PaymentChannel::where('value', $order->payment_channel)->first()->name;
                                    $reference_number = $paynamics_transaction->pay_reference ?? null;
                                    $deadline = $paynamics_transaction->expiry_limit;

                                    if ($order->payment_type != 'bank_otc') {
                                        if ($paynamics_transaction->direct_otc_info != null) {
                                            $payment_instruction = json_decode($paynamics_transaction->direct_otc_info);
                                        }

                                        else {
                                            $payment_instruction = json_decode($paynamics_transaction->pay_instructions);
                                        }
                                    }
                                @endphp

                                <div class="row mt-3 mb-5">
                                    <div class="col-12 col-lg-8 mx-auto">
                                        {{-- Order Status --}}
                                        <div class="row">
                                            <div class="col-12 col-lg-4">
                                                <p class="order-payment-label mb-0">Status:</p>
                                            </div>
                                            <div class="col-12 col-lg-8">
                                                <p class="order-payment-text order-text-warning">{{ $status }}</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-lg-4">
                                                <p class="order-payment-label mb-0">Payment Channel:</p>
                                            </div>
                                            <div class="col-12 col-lg-8">
                                                <p class="order-payment-text">{{ $payment_channel }}</p>
                                            </div>
                                        </div>

                                        @if ($reference_number != null)
                                            <div class="row">
                                                <div class="col-12 col-lg-4">
                                                    <p class="order-payment-label mb-0">Reference number:</p>
                                                </div>
                                                <div class="col-12 col-lg-8">
                                                    <p class="order-payment-text">{{ $reference_number }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-12 col-lg-4">
                                                <p class="order-payment-label mb-0">Deadline:</p>
                                            </div>
                                            <div class="col-12 col-lg-8">
                                                <p class="order-payment-text order-text-danger">{{ date('l, Y-m-d', strtotime($deadline)) }}</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <p class="order-payment-label mb-0">Payment instructions:</p>
                                            </div>
                                            <div class="col-12 mt-3">
                                                @if ($order->payment_type == 'nonbank_otc')
                                                    <div class="order-payment-description">
                                                        @php
                                                            if ($payment_instruction != null) {
                                                                $payment_instruction = nl2br(nl2br(str_replace('PAYMENT INSTRUCTION', '', $payment_instruction[0]->pay_instructions)));
                                                            }
                                                        @endphp

                                                        {!! $payment_instruction !!}
                                                    </div>

                                                @elseif ($order->payment_type == 'bank_otc')
                                                    <div class="order-payment-description">
                                                        <ul class="list-unstyled">
                                                            <li class="mb-3">1. Please write down or print the details indicated above, especially the <b>Reference Number</b> and <b>Total Amount Due</b></li>
                                                            <li class="mb-3">2. You can pay in cash at any {{ $payment_channel }} branch without any additional charges.</li>
                                                            <li>3. For Biller name, use Pay Express 2.</li>
                                                        </ul>
                                                    </div>

                                                @elseif ($order->payment_type == 'wallet')
                                                    <div class="order-payment-description">
                                                        <ul class="list-unstyled">
                                                            <li class="mb-3">
                                                                1.
                                                                <a href="{{ str_replace('"', '', preg_replace("/\\\\/", "", $paynamics_transaction->direct_otc_info)) }}">
                                                                    Click here to pay for your order on {{ $payment_channel }}!
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="d-flex" style="justify-content:center;">
            <a href="{{ route('purchase_history.index') }}">
                <button class="btn-craft-primary-nopadding pl-4 pr-4 pt-2 pb-2 fw-600">
                    Go to your purchase history
                </button>
            </a>
        </div>

    </div>
</section>

@endsection
