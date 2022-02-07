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
                        <form action="{{ route('proof-of-payment.store') }}" method="post">
                            @csrf

                            <input type="hidden" name="order_id" value="{{ $order->id }}">
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

                                    <hr>

                                    <div class="py-3 px-md-5 py-md-3">
                                        {{-- 1st Step --}}
                                        <div class="d-flex flex-sm-row flex-column justify-content-start mb-4">
                                            <div class="mr-4">
                                                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="34" height="34" rx="17" fill="#1B1464"/>
                                                <path d="M19.1829 12.8182H17.4279L14.8974 14.4439V16.1342L17.2788 14.6129H17.3384V23H19.1829V12.8182Z" fill="white"/>
                                                </svg>
                                            </div>
                                            <div class="mt-2">
                                                <div class="order-upload-receipt-title">
                                                    @php
                                                        $other_payment_method = \App\OtherPaymentMethod::where('unique_id', $order->payment_type)
                                                            ->select('name', 'unique_id', 'id')
                                                            ->first();

                                                        $other_payment_method_steps = \App\OtherPaymentMethodStep::where('other_payment_method_id', $other_payment_method->id)
                                                            ->get();

                                                        $bank_details = \App\OtherPaymentMethodBankDetail::where('other_payment_method_id', $other_payment_method->id)
                                                            ->where('status', 1)
                                                            ->get();
                                                    @endphp
                                                    Steps on how to pay using {{ ucfirst(str_replace('_', ' ', $other_payment_method->name)) }}:
                                                </div>
                                                <div class="mt-3">
                                                    @foreach ($other_payment_method_steps as $key => $value)
                                                        <div class="d-flex align-items-start">
                                                            <div class="mr-3 order-upload-receipt-subtitle">
                                                                {{ $key + 1 }}.
                                                            </div>
                                                            <div class="order-upload-receipt-subtitle">
                                                                {{ $value->step }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="d-flex align-items-start">
                                                        <div class="mr-4 order-upload-receipt-subtitle">
                                                        </div>
                                                        <div class="order-upload-receipt-subtitle">
                                                            <div>
                                                                <div class="row gutters-5 mt-3">
                                                                    @foreach ($bank_details as $key => $bank)
                                                                        @if ($bank->other_payment_method->type == 'e_wallet')
                                                                            @php
                                                                                $pup_location = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $order->pickup_point_location)))
                                                                                    ->pluck('id');
                                                                            @endphp 

                                                                            @if (in_array($bank->pickup_point_location, $pup_location->toArray()))
                                                                                <div class="col-12 mb-2 py-2">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="mr-3">
                                                                                            <img src="{{ uploaded_asset($bank->bank_image) }}" class="img-fluid" alt="">
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="order-upload-receipt-label mb-0">{{ $bank->bank_name }}</p>
                                                                                            <p class="order-upload-receipt-details mb-0">{{ $bank->bank_acc_number }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @else
                                                                            <div class="col-auto mb-2">
                                                                                <div class="order-upload-receipt-payment-gateway">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="mr-3 bank-logo">
                                                                                            <img src="{{ uploaded_asset($bank->bank_image) }}" class="img-fluid" alt="">
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="order-upload-receipt-label mb-0">{{ $bank->bank_name }}</p>
                                                                                            <p class="order-upload-receipt-details mb-0">
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- 2nd Step --}}
                                        <div class="d-flex flex-sm-row flex-column justify-content-start">
                                            <div class="mr-4">
                                                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="34" height="34" rx="17" fill="#1B1464"/>
                                                <path d="M14.0572 23H21.0373V21.4588H16.6026V21.3892L18.3576 19.6044C20.3363 17.7053 20.8832 16.7805 20.8832 15.6321C20.8832 13.9268 19.4961 12.679 17.4478 12.679C15.4293 12.679 13.9975 13.9318 13.9975 15.8658H15.7525C15.7525 14.8267 16.4087 14.1754 17.4229 14.1754C18.3924 14.1754 19.1133 14.767 19.1133 15.7266C19.1133 16.5767 18.5962 17.1832 17.592 18.2024L14.0572 21.6676V23Z" fill="white"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div data-toggle="aizuploader" data-type="image" data-multiple="true">
                                                    <div class="steps-container h-100 mt-4 mt-md-0">
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <div class="order-details-title mb-2">
                                                                    Upload proof of payment
                                                                </div>
                                                                <div class="order-details-subtitle">
                                                                    You can attach screenshots or photos of of your receipts then wait for us to verify your payment, it will take at least 12-24 hours.
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 d-flex align-items-center justify-content-end">
                                                                <button type="button" class="btn btn-primary mt-4 mt-md-0">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z" fill="white"/>
                                                                    </svg>
                                                                    Choose Files
                                                                </button>
                                                                <input type="hidden" name="proof_of_payment" class="selected-files">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>

                                                @if ($errors->has('proof_of_payment'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        {{ $errors->first('proof_of_payment') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-4">
                                    <div class="mr-3">
                                        <a href="{{ route('home') }}" class="btn btn-craft-primary-white h-100">
                                            I will pay later
                                        </a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            Confirm Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
