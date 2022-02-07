@extends('frontend.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <a href="{{ route('purchase_history.show', encrypt($order->id)) }}" class="back-to-page d-flex align-items-center">
                    <svg class="mr-3" width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.25 4.20833H3.03208L5.86625 1.36625L4.75 0.25L0 5L4.75 9.75L5.86625 8.63375L3.03208 5.79167H14.25V4.20833Z" fill="#1B1464"/>
                    </svg>

                    Back to Order Details
                </a>

                <h1 class="customer-craft-dashboard-title mt-4 mb-3">
                    {{ translate('Upload Proof of Payment') }}
                </h1>

                <form action="{{ route('proof-of-payment.store') }}" method="post">
                    @csrf

                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="card">
                        <div class="card-body">
                            {{-- 1st Step --}}
                            <div class="d-flex justify-content-start mb-4">
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
                            <div class="d-flex justify-content-start">
                                <div class="mr-4">
                                    <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="34" height="34" rx="17" fill="#1B1464"/>
                                    <path d="M14.0572 23H21.0373V21.4588H16.6026V21.3892L18.3576 19.6044C20.3363 17.7053 20.8832 16.7805 20.8832 15.6321C20.8832 13.9268 19.4961 12.679 17.4478 12.679C15.4293 12.679 13.9975 13.9318 13.9975 15.8658H15.7525C15.7525 14.8267 16.4087 14.1754 17.4229 14.1754C18.3924 14.1754 19.1133 14.767 19.1133 15.7266C19.1133 16.5767 18.5962 17.1832 17.592 18.2024L14.0572 21.6676V23Z" fill="white"/>
                                    </svg>
                                </div>
                                <div>
                                    <div data-toggle="aizuploader" data-type="image" data-multiple="true">
                                        <div class="steps-container h-100">
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
                                                    <button type="button" class="btn btn-primary">
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
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-4">
                            <div>
                                <button type="submit" class="btn btn-primary float-right">
                                    Confirm Payment
                                </button>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>

@endsection
