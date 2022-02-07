@extends('frontend.layouts.app')

@section('content')

<section class="py-5 bg-lightblue">
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
                    {{ translate('Request Cash out') }}
                </h1>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="wallet-subtitle">
                            Wallet Balance
                        </div>
                        <div class="wallet-title-amount">
                            {{ single_price(Auth::user()->balance) }}
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <form action="{{ route('wallet.request_cash_out_store') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="" class="col-form-label col-form-craft-label">Cash Out Amount: </label>
                                        <input type="number" id="amount" name="amount" class="form-control form-control-lg {{ $errors->has('amount') ? 'is-invalid' : '' }}" value="0" min="100" max="{{ Auth::user()->balance }}" placeholder="Amount">
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('amount') }}
                                            </span>
                                        @endif
                                        <div class="mt-2">
                                            <label for="withdraw_full_amount" class="form-craft-check d-flex align-items-center" style="cursor: pointer;">
                                                <input type="checkbox" name="withdraw_full_amount" id="withdraw_full_amount">
                                                <span class="ml-3 mt-2">Withdraw current balance</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <div class="form-group">
                                            <label for="" class="col-form-label col-form-craft-label">Cash out Destination</label>
                                            <select name="destination" id="destination" class="custom-select custom-select-lg form-control form-control-lg {{ $errors->has('destination') ? 'is-invalid' : '' }}">
                                                <option value="">Select Destination</option>
                                                <option value="gcash">GCash</option>
                                                <option value="bank">Bank</option>
                                            </select>
                                            @if ($errors->has('destination'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('destination') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="bank_acc_number" class="form-control form-control-lg {{ $errors->has('bank_acc_number') ? 'is-invalid' : '' }}" placeholder="Account number">
                                            @if ($errors->has('bank_acc_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('bank_acc_number') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="acc_holder_name" class="form-control form-control-lg {{ $errors->has('acc_holder_name') ? 'is-invalid' : '' }}" placeholder="Account holder name">
                                            @if ($errors->has('acc_holder_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('acc_holder_name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-primary btn-craft-primary">
                                            Submit cash out request
                                            <svg class="ml-2" width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.01 10.0833H4V11.9167H16.01V14.6667L20 11L16.01 7.33334V10.0833Z" fill="white"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="worldcraft-note mt-3">
                                        Worldcraft will review your request first, we will notify you once we have processed the cash out.
                                    </div>
                                </form>
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
    <script type="text/javascript">

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

        var current_balance = {{ Auth::user()->balance }}

        $(document).ready(function () {
            $('#withdraw_full_amount').change(function () {
                if (this.checked) {
                    $('#amount').val(current_balance)
                }

                else {
                    $('#amount').val('0')
                }
            });
        });
    </script>
@endsection
