@extends('frontend.layouts.app')

@section('content')

    @php
    $to_checkout = Session::get('toCheckout');
    @endphp

    <section class="py-5 bg-lightblue">
        <div class="container">
            <div class="position-absolute">
                <div class="img-44"></div>
            </div>
            <div class="steps-container border-0">
                <div class="row">
                    <div class="col-12 col-lg-7 mx-auto">
                        <div class="row gutters-5 text-center aiz-steps">
                            <div class="col active done">
                                <div class="icon">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.3 9.97C15.96 10.59 15.3 11 14.55 11H7.1L6 13H18V15H6C4.48 15 3.52 13.37 4.25 12.03L5.6 9.59L2 2H0V0H3.27L4.21 2H19.01C19.77 2 20.25 2.82 19.88 3.48L16.3 9.97ZM17.3099 4H5.15989L7.52989 9H14.5499L17.3099 4ZM6.00004 16C4.90003 16 4.01003 16.9 4.01003 18C4.01003 19.1 4.90003 20 6.00004 20C7.10004 20 8.00004 19.1 8.00004 18C8.00004 16.9 7.10004 16 6.00004 16ZM14.01 18C14.01 16.9 14.9 16 16 16C17.1 16 18 16.9 18 18C18 19.1 17.1 20 16 20C14.9 20 14.01 19.1 14.01 18Z"
                                            fill="white" />
                                    </svg>
                                </div>
                                <div class="title fs-12">{{ translate('My Cart') }}</div>
                            </div>

                            <div class="col active done">
                                <div class="icon bg-white">
                                    <svg id="Layer_1" enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512"
                                        width="25" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path fill="white"
                                                d="m256 0c-108.81 0-197.333 88.523-197.333 197.333 0 61.198 31.665 132.275 94.116 211.257 45.697 57.794 90.736 97.735 92.631 99.407 6.048 5.336 15.123 5.337 21.172 0 1.895-1.672 46.934-41.613 92.631-99.407 62.451-78.982 94.116-150.059 94.116-211.257 0-108.81-88.523-197.333-197.333-197.333zm0 474.171c-38.025-36.238-165.333-165.875-165.333-276.838 0-91.165 74.168-165.333 165.333-165.333s165.333 74.168 165.333 165.333c0 110.963-127.31 240.602-165.333 276.838z" />
                                            <path fill="white"
                                                d="m378.413 187.852-112-96c-5.992-5.136-14.833-5.136-20.825 0l-112 96c-6.709 5.75-7.486 15.852-1.735 22.561s15.852 7.486 22.561 1.735l13.586-11.646v79.498c0 8.836 7.164 16 16 16h144c8.836 0 16-7.164 16-16v-79.498l13.587 11.646c6.739 5.777 16.836 4.944 22.561-1.735 5.751-6.709 4.974-16.81-1.735-22.561zm-66.413 76.148h-112v-90.927l56-48 56 48z" />
                                        </g>
                                    </svg>
                                </div>
                                <div class="title fs-12">{{ translate('Customer Information') }}</div>
                            </div>

                            <div class="col active done">
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.6667 3.33334H3.33341C2.40841 3.33334 1.67508 4.075 1.67508 5L1.66675 15C1.66675 15.925 2.40841 16.6667 3.33341 16.6667H16.6667C17.5917 16.6667 18.3334 15.925 18.3334 15V5C18.3334 4.075 17.5917 3.33334 16.6667 3.33334ZM16.6667 15H3.33341V10H16.6667V15ZM3.33341 6.66667H16.6667V5H3.33341V6.66667Z"
                                            fill="white" />
                                    </svg>
                                </div>
                                <div class="title fs-12">
                                    {{ translate('Payment') }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="icon">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.00008 0.666656C4.40008 0.666656 0.666748 4.39999 0.666748 8.99999C0.666748 13.6 4.40008 17.3333 9.00008 17.3333C13.6001 17.3333 17.3334 13.6 17.3334 8.99999C17.3334 4.39999 13.6001 0.666656 9.00008 0.666656ZM9.00008 15.6667C5.32508 15.6667 2.33341 12.675 2.33341 8.99999C2.33341 5.32499 5.32508 2.33332 9.00008 2.33332C12.6751 2.33332 15.6667 5.32499 15.6667 8.99999C15.6667 12.675 12.6751 15.6667 9.00008 15.6667ZM7.33341 10.8083L12.8251 5.31666L14.0001 6.49999L7.33341 13.1667L4.00008 9.83332L5.17508 8.65832L7.33341 10.8083Z"
                                            fill="black" />
                                    </svg>
                                </div>
                                <div class="title fs-12">{{ translate('Confirmation') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <div class="text-left">
                    <div class="row">
                        <div class="col-xxl-8 col-xl-8 mx-auto">
                            <form class="form-default" action="{{ route('payment.checkout') }}" method="post"
                                id="checkout-form">
                                @csrf

                                <input type="hidden" name="payment_option" id="payment_option">
                                <input type="hidden" name="payment_type" id="payment_type">

                                <div class="card shadow-none border-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-start border-bottom">
                                            <div class="card-customer-wallet-title">
                                                Payment Method
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-2">
                                                        <div class="payment-method-subtitle">
                                                            {{ translate('Online payments powered by') }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <img src="{{ static_asset('assets/img/image36.svg') }}"
                                                            alt="Paynamics Payment" class="paynamics-img">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @php
                                            $payment_methods = \App\PaymentMethodList::where('status', 1)
                                                ->orderBy('id', 'asc')
                                                ->get();
                                        @endphp

                                        <div class="mt-2">
                                            <div class="row">
                                                @foreach ($payment_methods as $key => $value)
                                                    <div class="payment-item c-pointer col-auto mt-2"
                                                        onclick="togglePaynamics('{{ $value->value }}')"
                                                        id="{{ $value->value }}">
                                                        {{ translate($value->name) }}
                                                    </div>
                                                @endforeach
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
                                                                            class="pl-3 px-2" alt="">
                                                                        {{ $channel->name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="other-method">
                                            <div class="payment-method-subtitle-2">
                                                Other payment methods
                                            </div>

                                            <div class="row">
                                                @php
                                                    $other_payment_methods = \App\OtherPaymentMethod::where('status', 1)->get();
                                                @endphp

                                                @foreach ($other_payment_methods as $key => $value)
                                                    <div class="payment-item c-pointer col-auto mt-2"
                                                        onclick="togglePaymentMethod('{{ $value->unique_id }}')"
                                                        id="{{ $value->unique_id }}">
                                                        {{ $value->name }}
                                                    </div>
                                                @endforeach

                                                <div class="payment-item c-pointer col-auto mt-2"
                                                    onclick="togglePaymentMethod('user-wallet')" id="user-wallet">
                                                    {{ translate('My Wallet') }}
                                                    ({{ single_price(Auth::user()->balance) }})
                                                </div>
                                            </div>

                                            <div id="other-payment-methods">
                                                @foreach ($other_payment_methods as $key => $value)
                                                    <div class="{{ $value->unique_id }}" style="display: none">
                                                        <div class="header-details">
                                                            {{ $value->title }}
                                                        </div>

                                                        <div class="payment-details-body">
                                                            {{ $value->description }}
                                                        </div>

                                                        @php
                                                            $bank_details = \App\OtherPaymentMethodBankDetail::where('other_payment_method_id', $value->id)
                                                                ->where('status', 1)
                                                                ->get();
                                                        @endphp

                                                        <div>
                                                            <div class="row gutters-5 mt-3">
                                                                @foreach ($bank_details as $key => $bank)
                                                                    @if ($bank->other_payment_method->type == 'e_wallet')
                                                                        @php
                                                                            $pup_location_ids = null;
                                                                            
                                                                            foreach ($to_checkout as $key => $checkout) {
                                                                                $pup_location_ids = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $checkout->pickup_location)))->pluck('id');
                                                                            }
                                                                        @endphp

                                                                        @if (in_array($bank->pickup_point_location, $pup_location_ids->toArray()))
                                                                            <div class="col-12 mb-2 py-2 border-bottom">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="mr-3">
                                                                                        <img src="{{ uploaded_asset($bank->bank_image) }}"
                                                                                            class="img-fluid" alt="">
                                                                                    </div>
                                                                                    <div>
                                                                                        <p
                                                                                            class="order-upload-receipt-label mb-0">
                                                                                            {{ $bank->bank_name }}</p>
                                                                                        <p
                                                                                            class="order-upload-receipt-details mb-0">
                                                                                            {{ $bank->bank_acc_number }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                        <div class="col-auto mb-2">
                                                                            <div
                                                                                class="order-upload-receipt-payment-gateway">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="mr-3 bank-logo">
                                                                                        <img src="{{ uploaded_asset($bank->bank_image) }}"
                                                                                            class="img-fluid" alt="">
                                                                                    </div>
                                                                                    <div>
                                                                                        <p
                                                                                            class="order-upload-receipt-label mb-0">
                                                                                            {{ $bank->bank_name }}</p>
                                                                                        <p
                                                                                            class="order-upload-receipt-details mb-0">
                                                                                            {{ $bank->bank_acc_number }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        @if ($value->follow_up_instruction == 1)
                                                            <div class="footer-instruction">
                                                                Instructions will be on the next page.
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                <hr>

                                                <div class="form-group">
                                                    <label for="" class="col-form-label">Note:</label>
                                                    <textarea name="note" id="note" cols="15" rows="4"
                                                        class="form-control form-craft"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xxl-4 col-xl-4 mx-auto">
                            @include('frontend.partials.cart_summary')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8 col-xl-8">
                            <label for="agree_checkbox" class="form-craft-check d-flex align-items-center">
                                <input type="checkbox" required id="agree_checkbox" style="height: 20px;">
                                <span class="d-flex text-craft-sub ml-2" style="font-size:14px;">
                                    <span class="mr-1 ml-2">
                                        {{ translate('I agree to the') }}
                                        <a class="link-blue" href="{{ route('terms') }}" target="_blank">
                                            {{ translate('terms and conditions') }},
                                        </a>
                                        <a class="link-blue" href="{{ route('returnpolicy') }}" target="_blank">
                                            {{ translate('return policy') }} &
                                        </a>
                                        <a class="link-blue" href="{{ route('privacypolicy') }}" target="_blank">
                                            {{ translate('privacy policy') }}
                                        </a>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-xxl-8 col-xl-8 d-flex mt-4">
                            <div class="col-xxl-6 col-xl-6 d-flex justify-content-start pl-0">
                                <a href="{{ route('checkout.shipping_info') }}"
                                    class="link-back-cart d-flex align-items-center">
                                    <svg class="mr-2" width="19" height="20" viewBox="0 0 19 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.625 9.20833H5.40708L8.24125 6.36625L7.125 5.25L2.375 10L7.125 14.75L8.24125 13.6337L5.40708 10.7917H16.625V9.20833Z"
                                            fill="#62616A" />
                                    </svg>
                                    {{ translate('Back to Customer Information') }}
                                </a>
                            </div>
                            <div class="col-xxl-6 col-xl-6 d-flex justify-content-end pr-0">
                                <button type="submit" onclick="submitOrder(this)"
                                    class="btn fw-600 d-flex align-items-center" id="submit-btn">
                                    <svg class="mr-2" width="22" height="22" viewBox="0 0 22 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.5832 7.79167H16.4998C17.5082 7.79167 18.3332 8.61667 18.3332 9.625V18.7917C18.3332 19.8 17.5082 20.625 16.4998 20.625H5.49984C4.4915 20.625 3.6665 19.8 3.6665 18.7917V9.625C3.6665 8.61667 4.4915 7.79167 5.49984 7.79167H6.4165V5.95833C6.4165 3.42833 8.46984 1.375 10.9998 1.375C13.5298 1.375 15.5832 3.42833 15.5832 5.95833V7.79167ZM10.9998 3.20833C9.47817 3.20833 8.24984 4.43667 8.24984 5.95833V7.79167H13.7498V5.95833C13.7498 4.43667 12.5215 3.20833 10.9998 3.20833ZM16.4998 18.7917H5.49984V9.625H16.4998V18.7917ZM12.8332 14.2083C12.8332 15.2167 12.0082 16.0417 10.9998 16.0417C9.9915 16.0417 9.1665 15.2167 9.1665 14.2083C9.1665 13.2 9.9915 12.375 10.9998 12.375C12.0082 12.375 12.8332 13.2 12.8332 14.2083Z"
                                            fill="white" />
                                    </svg>
                                    {{ translate('Place Order') }}
                                </button>
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

        window.onload = function() {
            $.get("{{ route('check_auth') }}", function(data, status) {
                if (data == 1) {
                    // Do nothing
                } else {
                    window.location = '{{ route('user.login') }}';
                }
            });
        }

        setTimeout(function() {
            count = 1;
        }, 200);

        $(document).ready(function() {
            $('#submit-btn').addClass('btn-place-order-disabled');
            $("input[type=radio]").prop('checked', false);
            $(".online_payment").click(function() {
                $('#manual_payment_description').parent().addClass('d-none');
            });

            $('#agree_checkbox').prop('checked', false);

            $('#payment_option').on('input', function() {
                console.log('changed');
            });
        });

        function use_wallet() {
            $('input[name=payment_option]').val('wallet');
            if ($('#agree_checkbox').is(":checked") && $('#payment_option').val() && $('#payment_type').val()) {
                $('#checkout-form').submit();
            } else {
                if ($('#payment_option').val()) {
                    AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Please select your payment option') }}');
                }
            }
        }

        function submitOrder(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked") && $('#payment_option').val() && $('#payment_type').val()) {
                $('#checkout-form').submit();
            } else {
                if ($('#payment_option').val()) {
                    AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Please select your payment option') }}');
                }
                $(el).prop('disabled', false);
            }
        }

        function toggleManualPaymentData(id) {
            $('#manual_payment_description').parent().removeClass('d-none');
            $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
        }

        $('.form-craft-check input[type=checkbox]').click(function() {
            if ($('#payment_option').val()) {
                $('#submit-btn').toggleClass('btn-place-order');
                $('#submit-btn').toggleClass('btn-place-order-disabled');
            }
        });

        $("input[type='radio'][name='payment_channel']").click(function() {
            var data = {
                "_token": "{{ csrf_token() }}",
                "payment_channel": $(this).val()
            }
            $.ajax({
                type: "POST",
                url: '{{ route('checkout.paynamics.additional_fee') }}',
                data: data,
                success: function(data) {
                    if (data.status == 1) {
                        var price = 0;
                        var overall_total = $('#overall_total').val();

                        if (data.rate == 'fixed') {
                            price = data.price;
                        } else {
                            price = (data.price / 100) * overall_total;
                        }

                        $('#paynamics_selected').show();
                        $("#paynamics_price_val").val(price.toFixed(2));
                        $('#paynamics_price').text('₱' + price.toFixed(2));

                        computeTotal();
                    }
                }
            });
        });

        function togglePaynamics(id) {
            $('.payment-item').removeClass("active-payment");
            $('#payment_option').val(id);
            $('#paynamics').toggle(true);
            $('#other-payment-methods').toggle(false);
            $('#payment_type').val('paynamics');

            if ($('#payment_option').val() && $('#agree_checkbox').is(':checked')) {
                $('#submit-btn').addClass('btn-place-order');
                $('#submit-btn').removeClass('btn-place-order-disabled');
            }

            @foreach ($payment_methods as $key => $value)
                var unique_id = "{{ $value->value }}"
            
                if (id == unique_id) {
                $('#' + unique_id).addClass("active-payment");
                $('.' + unique_id).toggle(true);
                }
            
                else {
                $('.' + unique_id).toggle(false);
                }
            @endforeach
        }

        function togglePaymentMethod(id) {
            $('#paynamics_selected').hide();
            $('#paynamics_price').text('0');
            removePaynamics();

            $('.payment-item').removeClass("active-payment");
            $('#payment_option').val(id);
            $('#paynamics').toggle(false);
            $('#other-payment-methods').toggle(true);
            $('#payment_type').val('other-payment-method');

            if ($('#payment_option').val() && $('#agree_checkbox').is(':checked')) {
                $('#submit-btn').addClass('btn-place-order');
                $('#submit-btn').removeClass('btn-place-order-disabled');
            }

            @foreach ($other_payment_methods as $key => $value)
                var unique_id = "{{ $value->unique_id }}"
            
                if (id == unique_id) {
                $('#' + unique_id).addClass("active-payment");
                $('.' + unique_id).toggle(true);
                }
            
                else {
                $('.' + unique_id).toggle(false);
                $('.' + unique_id).removeClass('d-none')
                }
            @endforeach

            if (id == "user-wallet") {
                $('#payment_option').val('user-wallet')
                $('#user-wallet').addClass("active-payment");
                $('.pickup').toggle(false);
                $('.bank-transfer').toggle(false);
                $('.otc-deposit').toggle(false);
                $('.gcash-qr').toggle(false);
                $('.user-wallet').toggle(true);
            }
        }
    </script>
@endsection
