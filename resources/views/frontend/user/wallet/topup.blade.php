@extends('frontend.layouts.app')

@section('content')

    <section class="py-5 bg-lightblue">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <a href="{{ route('wallet.index') }}" class="back-to-page d-flex align-items-center">
                        <svg class="mr-3" width="15" height="10" viewBox="0 0 15 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.25 4.20833H3.03208L5.86625 1.36625L4.75 0.25L0 5L4.75 9.75L5.86625 8.63375L3.03208 5.79167H14.25V4.20833Z"
                                fill="#1B1464" />
                        </svg>
                        Back to My Wallet
                    </a>

                    <h1 class="customer-craft-dashboard-title mt-4 mb-3">
                        {{ translate('Cash in Wallet') }}
                    </h1>

                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="wallet-subtitle">
                                {{ translate('Wallet Balance') }}
                            </div>
                            <div class="wallet-title-amount">
                                {{ single_price(Auth::user()->balance) }}
                            </div>
                            <hr>
                            <div>
                                <form action="{{ route('wallet.request_cash_in_store') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="payment_method" name="payment_method">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="form-group">
                                                <div class="d-flex">
                                                    <div class="w-50">
                                                        <label for="" class="col-form-label col-form-craft-label">Top up
                                                            Amount: </label>
                                                    </div>
                                                    <div class="w-50">
                                                        <label for=""
                                                            class="col-form-label float-right cash-in-amount-subtitle">
                                                            Minimum Amount: ₱500
                                                        </label>
                                                    </div>
                                                </div>
                                                <input type="number" id="amount" name="amount"
                                                    class="form-control form-control-lg {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                                    placeholder="Amount">
                                                @if ($errors->has('amount'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('amount') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $payment_methods = \App\PaymentMethodList::where('status', 1)
                                            ->orderBy('id', 'asc')
                                            ->get();
                                    @endphp

                                    <div class="mt-4">
                                        <div class="form-group">
                                            <label for=""
                                                class="col-form-label cash-in-preferred-label">{{ translate('Choose your preferred top up method:') }}</label>
                                            <div class="row">
                                                @foreach ($payment_methods as $key => $value)
                                                    <div class="payment-item c-pointer col-auto mt-2"
                                                        onclick="togglePaynamics('{{ $value->value }}')"
                                                        id="{{ $value->value }}">
                                                        {{ translate($value->name) }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div id="paynamics" class="payment-details">
                                            @foreach ($payment_methods as $key => $value)
                                                <div class="{{ $value->value }}" style="display: none;">
                                                    <div class="header-details mb-0">
                                                        {{ $value->name }}
                                                    </div>

                                                    @php
                                                        $payment_channels = \App\PaymentChannel::where('status', 1)
                                                            ->where('payment_method_id', $value->id)
                                                            ->orderBy('id', 'asc')
                                                            ->get();
                                                    @endphp

                                                    <div class="payment-details-body">
                                                        @foreach ($payment_channels as $key => $channel)
                                                            <div class="form-craft-radio">
                                                                <label for="{{ $channel->value }}"
                                                                    class="pt-3 text-paragraph-thin c-pointer">
                                                                    <input type="radio" id="{{ $channel->value }}"
                                                                        name="payment_channel"
                                                                        value="{{ $channel->value }}"
                                                                        style="height: 11px;">
                                                                    <img src="{{ uploaded_asset($channel->image) }}"
                                                                        class="px-3" alt="">
                                                                    {{ $channel->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <button id="cash_in_submit" type="submit" class="btn btn-craft-primary-nopadding"
                                            disabled>Confirm Top up</button>
                                    </div>

                                    <div class="footer-instruction mt-3">
                                        An additional fee will be added on top of your top-up amount for Paynamics
                                        convenience fee.
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        function togglePaynamics(id) {
            $('.payment-item').removeClass('active-payment');
            $('#payment_method').val(id);
            $('#paynamics').toggle(true);
            $('#payment_type').val('paynamics');
            $('#cash_in_submit').attr('disabled', false);

            @foreach ($payment_methods as $key => $value)
                var unique_id = "{{ $value->value }}"
            
                if (id == unique_id) {
                $('#' + unique_id).addClass('active-payment');
                $('.' + unique_id).toggle(true);
                }
            
                else {
                $('.' + unique_id).toggle(false);
                }
            @endforeach
        }
    </script>
@endsection
