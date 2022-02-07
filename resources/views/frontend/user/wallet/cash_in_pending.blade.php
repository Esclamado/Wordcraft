@extends('frontend.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')

            <div class="aiz-user-panel">
                <a href="{{ route('wallet.index') }}" class="back-to-page d-flex align-items-center">
                    <svg class="mr-3" width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.25 4.20833H3.03208L5.86625 1.36625L4.75 0.25L0 5L4.75 9.75L5.86625 8.63375L3.03208 5.79167H14.25V4.20833Z" fill="#1B1464"/>
                    </svg>
                    Back to My Wallet
                </a>

                <h1 class="customer-craft-dashboard-title mt-4 mb-3">
                    {{ translate('Cash in Wallet') }}
                </h1>

                <div class="card mt-4">
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
                                    We will wait for your payment before we process your cash in request. We will notify you immediately once we have received your payment.
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="total-due-card">
                                        <div class="total-due-card-label">
                                            Total Due
                                        </div>
                                        <div class="total-due-card-price">
                                            {{ single_price($wallet->amount) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($paynamics_transaction != null)
                            @php
                                $status = $paynamics_transaction->response_message;
                                $payment_channel = \App\PaymentChannel::where('value', $wallet->payment_channel)
                                    ->first()
                                    ->name;
                                $reference_number = $paynamics_transaction->pay_reference;
                                $deadline = $paynamics_transaction->expiry_limit;

                                if ($wallet->payment_method != 'bank_otc') {
                                    $payment_instruction = json_decode($paynamics_transaction->direct_otc_info) ?? "N/A";
                                }
                            @endphp

                            <div class="row mt-3 mb-5">
                                <div class="col-12 col-lg-8 mx-auto">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <p class="order-payment-label mb-0">Status: </p>
                                        </div>
                                        <div class="col-12 col-lg-8">
                                            <p class="order-payment-text order-text-warning">
                                                {{ $status }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <p class="order-payment-label mb-0">Payment Channel: </p>
                                        </div>
                                        <div class="col-12 col-lg-8">
                                            <p class="order-payment-text">{{ $payment_channel }}</p>
                                        </div>
                                    </div>

                                    @if ($reference_number != null)
                                        <div class="row">
                                            <div class="col-12 col-lg-4">
                                                <p class="order-payment-label mb-0">Reference Number: </p>
                                            </div>
                                            <div class="col-12 col-lg-8">
                                                <p class="order-payment-text">{{ $reference_number }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <p class="order-payment-label mb-0">Deadline: </p>
                                        </div>
                                        <div class="col-12 col-lg-8">
                                            <p class="order-payment-text order-text-danger">
                                                {{ date('l, Y-m-d', strtotime($deadline)) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <p class="order-payment-label mb-0">Payment Instruction: </p>
                                        </div>
                                        <div class="col-12 mt-3">
                                            @if ($wallet->payment_method == 'nonbank_otc')
                                                <div class="order-payment-description">
                                                    @php
                                                        $payment_instruction = nl2br(nl2br(str_replace('PAYMENT INSTRUCTION', '', $payment_instruction[0]->pay_instructions))) ?? "N/A";
                                                    @endphp

                                                    {!! $payment_instruction !!}
                                                </div>

                                            @elseif ($wallet->payment_method == 'bank_otc')
                                                <div class="order-payment-description">
                                                    <ul class="list-unstyled">
                                                        <li class="mb-3">1. Please write down or print the details indicated above, especially the <b>Reference Number</b> and <b>Total Amount Due</b></li>
                                                        <li class="mb-3">2. You can pay in cash at any {{ $payment_channel }} branch without any additional charges.</li>
                                                        <li>3. For Biller name, use Pay Express 2.</li>
                                                    </ul>
                                                </div>
                                            @elseif ($wallet->payment_method == 'wallet')
                                                <div class="order-payment-description">
                                                    <ul class="list-unstyled">
                                                        <li>You will be redirected to {{ $payment_channel }}'s payment page shortly...</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
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
    <script type="text/javascript">
        @if ($wallet->payment_method == 'wallet')
            setTimeout(function () {
                window.location.href = "{{ str_replace('"', '', preg_replace("/\\\\/", "", $paynamics_transaction->direct_otc_info)) }}"
            }, 2000)
        @endif
    </script>
@endsection
