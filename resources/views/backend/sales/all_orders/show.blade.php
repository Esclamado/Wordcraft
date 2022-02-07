@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="card border-0 rounded-0 shadow-none">
                <div class="card-body">
                    <div class="d-flex justify-content-start border-bottom">
                        <div id="order-details" class="order-tab opacity-50 order-tab-active mr-2 d-flex align-items-center"
                            onclick="toggleOrder('order-details')">
                            Order Details
                        </div>

                        @if (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Treasurer' || Auth::user()->staff->role->name == 'CMG')
                            <div id="treasury-accounting" class="order-tab opacity-50 d-flex align-items-center mr-2"
                                onclick="toggleOrder('treasury-accounting')">
                                Treasury and CMG
                            </div>
                        @endif

                        <div id="notes" class="order-tab opacity-50 d-flex align-items-center"
                            onclick="toggleOrder('notes')">
                            Notes
                        </div>
                    </div>

                    <div id="order-details-content" class="order-details-content py-4">
                        <div class="card">
                            <div class="card-header row gutters-5">
                                <div class="col text-center text-md-left">
                                </div>
                                @php
                                    $delivery_status = $order->orderDetails->first()->delivery_status;
                                    $payment_status = $order->orderDetails->first()->payment_status;
                                @endphp

                                @if (Auth::user()->user_type == 'staff' && Auth::user()->staff->role->name == 'CMG')
                                    {{-- Show nothing --}}
                                @else
                                    {{-- Check Permission --}}
                                    @php
                                        if (Auth::user()->user_type == 'staff') {
                                            $permissions = json_decode(Auth::user()->permissions);
                                        }
                                    @endphp

                                    @if (Auth::user()->user_type == 'admin' || (Auth::user()->user_type == 'staff' && $permissions != null && in_array('manage_order_payment_status', $permissions)))
                                        <div class="col-md-3 ml-auto">
                                            <label for="update_payment_status">{{ translate('Payment Status') }}</label>
                                            <select class="form-control aiz-selectpicker"
                                                data-minimum-results-for-search="Infinity" id="update_payment_status"
                                                @if ($order->cr_number == null) disabled @endif>
                                                <option value="paid" @if ($payment_status == 'paid') selected @endif>{{ translate('Paid') }}
                                                </option>
                                                <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{ translate('Unpaid') }}
                                                </option>
                                            </select>
                                        </div>
                                    @endif

                                    @if (Auth::user()->user_type == 'admin' || (Auth::user()->user_type == 'staff' && $permissions != null && in_array('manage_order_delivery_status', $permissions)))
                                        <div class="col-md-3 ml-auto">
                                            <label for="update_delivery_status">{{ translate('Delivery Status') }}</label>
                                            <select class="form-control aiz-selectpicker"
                                                data-minimum-results-for-search="Infinity" id="update_delivery_status">
                                                <option value="order_placed" @if ($delivery_status == 'order_placed') selected @endif>
                                                    {{ translate('Order Placed') }}</option>
                                                <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>
                                                    {{ translate('Confirmed') }}</option>
                                                <option value="processing" @if ($delivery_status == 'processing') selected @endif>
                                                    {{ translate('Processing') }}</option>
                                                <option value="partial_release" @if ($delivery_status == 'partial_release') selected @endif>
                                                    {{ translate('Partial Release') }}</option>
                                                <option value="ready_for_pickup" @if ($delivery_status == 'ready_for_pickup') selected @endif>
                                                    {{ translate('Ready for Pickup') }}</option>
                                                <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>
                                                    {{ translate('Picked Up') }}</option>
                                            </select>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between text-center text-md-left">
                                    <div>
                                        {{-- Customer Information --}}
                                        <address>
                                            <p class="font-weight-bold">Customer Information</p>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <span class="text-muted">Display Name:</span>
                                                    <strong>{{ $order->user->display_name ?? "N/A" }}</strong>
                                                </li>
                                                <li>
                                                    <span class="text-muted">Name:</span>
                                                    <span>{{ $order->user->name }}</span>
                                                </li>
                                                <li>
                                                    <span class="text-muted">Email:</span>
                                                    <span>{{ $order->user->email }}</span>
                                                </li>
                                                <li>
                                                    <span class="text-muted">Phone:</span>
                                                    <span>{{ $order->user->phone }}</span>
                                                </li>
                                                <li>
                                                    <span class="text-muted">Address:</span>
                                                    <span>{{ $order->user->address ?? 'N/A' }}</span>
                                                </li>
                                                <li>
                                                    <span class="text-muted">Tin No.:</span>
                                                    @if ($order->user->user_type == 'reseller')
                                                        <span>{{ $order->user->reseller['tin'] ?? 'N/A' }}</span>
                                                    @else
                                                        <span>{{ $order->user->tin_no ?? "N/A" }}</span>
                                                    @endif
                                                </li>
                                            </ul>
                                        </address>

                                        {{-- Pickup Point Location --}}
                                        <address>
                                            <p class="font-weight-bold">Delivery Type Information</p>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <span class="text-muted">Pickup Point:</span>
                                                    <strong>{{ ucfirst(str_replace('_', ' ', $order->pickup_point_location)) }}</strong>
                                                </li>
                                                <li>
                                                    <span class="text-muted">Address:</span>
                                                    <span>
                                                        @php
                                                            $pickup_point = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $order->pickup_point_location)))->first()->address;
                                                            
                                                            echo $pickup_point;
                                                        @endphp
                                                    </span>
                                                </li>
                                            </ul>
                                        </address>
                                    </div>
                                    <div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="text-bold">{{ translate('Order #') }}</td>
                                                    <td class="text-right text-info text-bold"> {{ $order->code }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold">{{ translate('Order Status') }}</td>
                                                    @php
                                                        $status = $order->orderDetails->first()->delivery_status;
                                                    @endphp
                                                    <td class="text-right">
                                                        @if ($status == 'picked_up')
                                                            <span class="badge badge-inline badge-success"
                                                                id="delivery_status">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                                        @else
                                                            <span class="badge badge-inline badge-info"
                                                                id="delivery_status">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold">{{ translate('Order Date') }} </td>
                                                    <td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-main text-bold">{{ translate('Total amount') }} </td>
                                                    <td class="text-right">
                                                        {{ single_price($order->grand_total) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-main text-bold">{{ translate('Payment method') }}</td>

                                                    @php
                                                        $payment_type = null;
                                                        
                                                        if (\App\OtherPaymentMethod::where('unique_id', $order->payment_type)->exists()) {
                                                            $payment_type = \App\OtherPaymentMethod::where('unique_id', $order->payment_type)->first()->name;
                                                        } else {
                                                            $payment_type = $order->payment_type;
                                                        }
                                                    @endphp

                                                    <td class="text-right">
                                                        {{ ucfirst(str_replace('_', ' ', $payment_type)) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr class="new-section-sm bord-no">
                                <div class="row">
                                    <div class="col-lg-12 table-responsive">
                                        <table class="table table-bordered invoice-summary">
                                            <thead>
                                                <tr class="bg-trans-dark">
                                                    <th class="min-col">#</th>
                                                    <th width="10%">{{ translate('Photo') }}</th>
                                                    <th class="text-uppercase">{{ translate('Description') }}</th>
                                                    <th class="text-uppercase">{{ translate('SKU') }}</th>
                                                    <th class="text-uppercase">{{ translate('Order Type') }}</th>
                                                    <th class="text-uppercase">{{ translate('Delivery Type') }}</th>
                                                    <th class="min-col text-center text-uppercase">{{ translate('Qty') }}
                                                    </th>
                                                    <th class="min-col text-center text-uppercase"
                                                        id="partial_release_header" style="display: none;">
                                                        {{ translate('Partial Release') }}</th>
                                                    <th class="min-col text-center text-uppercase">{{ translate('Price') }}
                                                    </th>
                                                    <th class="min-col text-right text-uppercase">{{ translate('Total') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderDetails as $key => $orderDetail)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            @if ($orderDetail->product != null)
                                                                @php
                                                                    $product_image = null;
                                                                    
                                                                    if ($orderDetail->product != null) {
                                                                        if ($orderDetail->variation != '') {
                                                                            $product_image = \App\ProductStock::where('product_id', $orderDetail->product_id)
                                                                                ->where('variant', $orderDetail->variation)
                                                                                ->exists();
                                                                    
                                                                            if ($product_image) {
                                                                                $product_image = \App\ProductStock::where('product_id', $orderDetail->product_id)
                                                                                    ->where('variant', $orderDetail->variation)
                                                                                    ->first()->image;
                                                                    
                                                                                if ($product_image != null) {
                                                                                    $product_image = uploaded_asset($product_image);
                                                                                } else {
                                                                                    $product_image = uploaded_asset($orderDetail->product->thumbnail_img);
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $product_image = uploaded_asset($orderDetail->product->thumbnail_img);
                                                                        }
                                                                    }
                                                                @endphp
                                                                <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                                    target="_blank">
                                                                    <img height="50" src="{{ $product_image }}">
                                                                </a>
                                                            @else
                                                                <strong>{{ translate('N/A') }}</strong>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($orderDetail->product != null)
                                                                <strong><a
                                                                        href="{{ route('product', $orderDetail->product->slug) }}"
                                                                        target="_blank"
                                                                        class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                                                <small>{{ $orderDetail->variation }}</small>
                                                            @else
                                                                <strong>{{ translate('Product Unavailable') }}</strong>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $sku = \App\ProductStock::where('product_id', $orderDetail->product_id)
                                                                    ->where('variant', $orderDetail->variation)
                                                                    ->first();
                                                                
                                                                if ($sku != null) {
                                                                    echo $sku->sku;
                                                                } else {
                                                                    echo $orderDetail->product->sku ?? "NO SKU";
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td class="text-capitalize">
                                                            {{ str_replace('_', ' ', $orderDetail->order_type) }}
                                                        </td>
                                                        <td>
                                                            @if ($orderDetail->shipping_type != null && $orderDetail->shipping_type == 'home_delivery')
                                                                {{ translate('Home Delivery') }}
                                                            @elseif ($orderDetail->shipping_type == 'pickup_point')

                                                                @if ($orderDetail->pickup_point != null)
                                                                    {{ $orderDetail->pickup_point->getTranslation('name') }}
                                                                    ({{ translate('Pickup Point') }})
                                                                @else
                                                                    {{ translate('Pickup Point') }}
                                                                @endif
                                                            @else
                                                                {{ translate('Pickup Point') }}:
                                                                <br>
                                                                <b>{{ ucfirst(str_replace('_', ' ', $order->pickup_point_location)) }}</b>
                                                                <br>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{ $orderDetail->quantity }}</td>
                                                        <td class="text-center partial_released_body"
                                                            @if ($orderDetail->partial_released != 1) style="display: none;" @endif>
                                                            @if ($orderDetail->partial_released != 1)
                                                                <form
                                                                    action="{{ route('order.partial_release', $orderDetail->id) }}"
                                                                    method="POST"
                                                                    class="d-flex justify-space-between row gutters-5">
                                                                    @csrf
                                                                    <div class="col-lg-8">
                                                                        <input type="number" class="form-control"
                                                                            name="partial_released_qty"
                                                                            id="partial_release_input">
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="las la-check"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                            <div id="partial_release_value">
                                                                {{ $orderDetail->partial_released_qty }}
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ single_price($orderDetail->price / $orderDetail->quantity) }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ single_price($orderDetail->price) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <strong class="text-muted">{{ translate('Sub Total') }}
                                                            :</strong>
                                                    </td>
                                                    <td>
                                                        {{ single_price($order->orderDetails->sum('price')) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong class="text-muted">Tax :</strong>
                                                    </td>
                                                    <td>
                                                        {{ single_price($order->orderDetails->sum('tax')) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong class="text-muted">{{ translate('Shipping') }}
                                                            :</strong>
                                                    </td>
                                                    <td>
                                                        {{ single_price($order->orderDetails->sum('shipping_cost')) }}
                                                    </td>
                                                </tr>
                                                @if ($order->convenience_fee != null)
                                                    <tr>
                                                        <td>
                                                            <strong
                                                                class="text-muted">{{ translate('Convenience Fee') }}
                                                                :</strong>
                                                        </td>
                                                        <td>
                                                            {{ single_price($order->convenience_fee) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>
                                                        <strong class="text-muted">{{ translate('Coupon') }} :</strong>
                                                    </td>
                                                    <td>
                                                        {{ single_price($order->coupon_discount) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong class="text-muted">{{ translate('TOTAL') }} :</strong>
                                                    </td>
                                                    <td class="text-muted h5">
                                                        {{ single_price($order->grand_total) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right no-print">
                                            @if ($order->payment_status == 'paid')
                                                @php
                                                    $full_name = $order->user->first_name . ' ' . $order->user->last_name;
                                                @endphp
                                                <a href="https://beta.worldcraft.com.ph/packingslip.php?order_id={{ $order->code }}&fullname={{ base64_encode($full_name) }}"
                                                    type="button" target="_blank" class="btn btn-icon btn-light"
                                                    title="Print Packing Slip"><i class="las la-print"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    {{-- image receipt --}}
                                    @if ($proof_of_payments != null)
                                        <div>
                                            <h6 class="mb-3">
                                                {{ translate('Proof of payment') }}
                                            </h6>
                                            <div class="table-responsive">
                                                <table class="table invoice-summary">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                {{ translate('Receipt') }}
                                                            </th>
                                                            <th>
                                                                {{ translate('Date Paid') }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($proof_of_payments as $key => $proof_of_payment)
                                                            @php
                                                                $photos = explode(',', $proof_of_payment->proof_of_payment);
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    @foreach ($photos as $key => $value)
                                                                        <a href="{{ uploaded_asset($value) }}"
                                                                            target="_blank">
                                                                            <img src="{{ uploaded_asset($value) }}"
                                                                                class="proof-of-payment mr-2" height="150"
                                                                                width="150"
                                                                                style="border: 1px solid #dee2e6; object-fit: cover;"
                                                                                alt="">
                                                                        </a>
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    {{ date('m-d-Y h:i:s a', strtotime($proof_of_payment->paid_at)) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>

                                            @if (Auth::user()->user_type == 'admin' || (Auth::user()->user_type == 'staff' && Auth::user()->staff->role->name != 'CMG'))
                                                <h6 class="mb-3">
                                                    {{ translate('Upload payment receipt') }}
                                                </h6>
                                                <form action="{{ route('proof-of-payment.store.admin') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <div class="d-flex justify-content-start mt-3">
                                                        <div>
                                                            <div data-toggle="aizuploader" data-type="image"
                                                                data-multiple="true">
                                                                <div class=" d-flex align-items-center justify-content-end">
                                                                    <button type="button" class="btn btn-primary">
                                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                d="M11.25 12.375V7.875H14.25L9 2.625L3.75 7.875H6.75V12.375H11.25ZM9 4.7475L10.6275 6.375H9.75V10.875H8.25V6.375H7.3725L9 4.7475ZM14.25 15.375V13.875H3.75V15.375H14.25Z"
                                                                                fill="white" />
                                                                        </svg>
                                                                        Choose Files
                                                                    </button>
                                                                    <input type="hidden" name="proof_of_payment"
                                                                        class="selected-files">
                                                                </div>
                                                            </div>
                                                            <div class="file-preview box sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <button type="submit" class="btn btn-primary float-right">
                                                        Upload Payment Receipt
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="treasury-accounting-content" class="order-details-content py-4" style="display: none;">
                        <div class="row" style="margin-top: 10px;">
                            @if (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Treasurer')
                                <div class="col-lg-offset-6 col-lg-3">
                                    <form action="{{ route('cr_number.upload') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <label for="" class="control-label">
                                            {{ translate('CR Number') }}
                                        </label>
                                        <input name="cr_number"
                                            class="form-control {{ $errors->has('cr_number') ? 'is-invalid' : '' }}"
                                            value="{{ $order->cr_number }}" id=""
                                            {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Treasurer' ? '' : 'disabled' }} />
                                        @if ($errors->has('cr_number'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('cr_number') }}
                                            </span>
                                        @endif
                                        <button type="submit"
                                            class="btn btn-primary btn-sm save-btn col-lg-offset-8 col-lg-4"
                                            style="margin-top: 10px;"
                                            {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Treasurer' ? '' : 'disabled' }}>
                                            {{ translate('Save') }}
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <form class="col-9 row" action="{{ route('cmg.upload') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                @if (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'CMG')
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="" class="control-label">
                                                {{ translate('SOM Number') }}
                                            </label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('som_number') ? 'is-invalid' : '' }}"
                                                name="som_number" value="{{ $order->som_number }}"
                                                {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name != 'CMG' ? 'disabled' : '' }} />
                                            @if ($errors->has('som_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('som_number') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for=""
                                                class="control-label">{{ translate('SOM Number Date') }}</label>
                                            <input type="date" name="som_number_date" id=""
                                                class="form-control {{ $errors->has('som_number_date') ? 'is-invalid' : '' }}"
                                                value="{{ $order->som_number_date }}"
                                                {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name != 'CMG' ? 'disabled' : '' }}>
                                            @if ($errors->has('som_number_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('som_number_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="" class="control-label">
                                                {{ translate('S.I. Number') }}
                                            </label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('si_number') ? 'is-invalid' : '' }}"
                                                name="si_number" value="{{ $order->si_number }}"
                                                {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name != 'CMG' ? 'disabled' : '' }} />
                                            @if ($errors->has('si_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('si_number') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for=""
                                                class="control-label">{{ translate('SI Number Date') }}</label>
                                            <input type="date" name="si_number_date" id="si_number_date"
                                                class="form-control {{ $errors->has('si_number_date') ? 'is-invalid' : '' }}"
                                                value="{{ $order->si_number_date }}"
                                                {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name != 'CMG' ? 'disabled' : '' }}>
                                            @if ($errors->has('si_number_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('si_number_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="" class="control-label">
                                                {{ translate('D.R. Number') }}
                                            </label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('dr_number') ? 'is-invalid' : '' }}"
                                                name="dr_number" value="{{ $order->dr_number }}"
                                                {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name != 'CMG' ? 'disabled' : '' }} />
                                            @if ($errors->has('dr_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('dr_number') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for=""
                                                class="control-label">{{ translate('DR Number Date') }}</label>
                                            <input type="date" name="dr_number_date" id=""
                                                class="form-control {{ $errors->has('dr_number_date') ? 'is-invalid' : '' }}"
                                                value="{{ $order->dr_number_date }}"
                                                {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name != 'CMG' ? 'disabled' : '' }}>
                                            @if ($errors->has('dr_number_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('dr_number_date') }}
                                                </span>
                                            @endif
                                        </div>

                                        <button type="submit"
                                            class="btn btn-primary btn-sm save-btn col-lg-offset-8 col-lg-4"
                                            style="margin-top: 10px;"
                                            {{ Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'CMG' ? '' : 'disabled' }}>
                                            {{ translate('Save') }}
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <div style="margin-top: 10px;">
                            <hr>
                            <h4>Logs</h4>

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <th style="width: 20%">
                                            User
                                        </th>
                                        <th style="width: 50%">Activity</th>
                                        <th style="width: 30%">Date</th>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($cmg_logs as $key => $log)
                                            <tr>
                                                <td>
                                                    {{ $log->user->name }}
                                                </td>
                                                <td>
                                                    {!! $log->activity !!}
                                                </td>
                                                <td>
                                                    {{ $log->created_at }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $cmg_logs->links() }}
                        </div>
                    </div>

                    <div id="order-notes-content" class="order-details-content py-4" style="display: none;">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="border p-3">
                                    <h6>Notes for Customer: </h6>
                                    <hr>
                                    @if (count($notes_for_customer) != 0)
                                        @foreach ($notes_for_customer as $key => $note)
                                            <div class="row">
                                                <div class="col-12 col-lg-3">
                                                    {{ date('Y-m-d h:i:s a', strtotime($note->created_at)) }}
                                                </div>
                                                <div class="col-12 col-lg-9">
                                                    <div class="alert alert-primary w-100">
                                                        {{ $note->message }}
                                                        <div class="mt-2">
                                                            <small>From:
                                                                <strong>{{ $note->user->name }}</strong></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No notes yet.</p>
                                    @endif
                                </div>
                                {{ $notes_for_customer->links() }}
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="border p-3">
                                    <h6 class="___class_+?138___">Notes for Admin: </h6>
                                    <hr>
                                    @if (count($notes_for_admin) != 0)
                                        @foreach ($notes_for_admin as $key => $note)
                                            <div class="row">
                                                <div class="col-12 col-lg-3">
                                                    {{ date('Y-m-d h:i:s a', strtotime($note->created_at)) }}
                                                </div>
                                                <div class="col-12 col-lg-9">
                                                    <div class="alert alert-success w-100">
                                                        {{ $note->message }}
                                                        <div class="mt-2">
                                                            <small>From:
                                                                <strong>{{ $note->user->name }}</strong></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No notes yet.</p>
                                    @endif
                                </div>
                                {{ $notes_for_admin->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    {{ translate('Latest Admin Note') }}:
                </div>
                <div class="card-body">
                    @php
                        $latest_note = \App\OrderNote::where('order_id', $order->id)
                            ->where('type', 'admin')
                            ->latest()
                            ->first();
                    @endphp

                    @if ($latest_note != null)
                        <div class="alert alert-success" role="alert">
                            <div class="d-flex justify-content-start">
                                <div class="mr-3">
                                    <i class="las la-thumbtack"></i>
                                </div>
                                <div>
                                    {{ $latest_note->message }}
                                    <div class="mt-2">
                                        <small>From: <strong>{{ $latest_note->user->name }}</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    {{ translate('Latest Customer Note') }}:
                </div>
                <div class="card-body">
                    @php
                        $latest_note = \App\OrderNote::where('order_id', $order->id)
                            ->where('type', 'customer')
                            ->latest()
                            ->first();
                    @endphp

                    @if ($latest_note != null)
                        <div class="alert alert-primary" role="alert">
                            <div class="d-flex justify-content-start">
                                <div class="mr-3">
                                    <i class="las la-thumbtack"></i>
                                </div>
                                <div>
                                    {{ $latest_note->message }}
                                    <div class="mt-2">
                                        <small>From: <strong>{{ $latest_note->user->name }}</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    {{ translate('Customer Order Note') }}:
                </div>
                <div class="card-body">
                    <p>
                        {{ $order->note }}
                    </p>
                </div>
            </div>

            @if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')
                <div class="card">
                    <div class="card-header">
                        {{ translate('Notes') }}:
                    </div>
                    <div class="card-body">
                        <form class="___class_+?167___" action="{{ route('order_note.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            <div class="form-group">
                                <label for="" class="control-from-label">Type</label>
                                <div>
                                    <select
                                        class="form-control aiz-selectpicker {{ $errors->has('type') ? 'is-invalid' : '' }}"
                                        name="type">
                                        <option value="">Select Type</option>
                                        <option value="customer">Customer</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                                            {{ $errors->first('type') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-from-label">Message</label>
                                <div>
                                    <textarea name="message" rows="4" cols="2"
                                        class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}"></textarea>
                                    @if ($errors->has('message'))
                                        <span class="invalid-feedback" role="alert">
                                            {{ $errors->first('message') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    Save Note
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

<div id="myModal" class="modal">
    <div class="container">
        <div class="close-modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>
    </div>
</div>


@section('script')

    <script type="text/javascript">
        //  for zoom Image
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");

        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        $(document).ready(function() {
            @if ($order->orderDetails->first()->delivery_status == 'partial_release')
                $('#partial_release_header').show();
                $('.partial_released_body').show();
            @else
                $('#partial_release_header').hide();
                $('.partial_released_body').hide();
            @endif

            @if (Auth::user()->user_type == 'staff' && Auth::user()->staff->role->name == 'CMG')
                $('#order-details').removeClass('order-tab-active');
                $('#notes').removeClass('order-tab-active');
                $('#treasury-accounting').addClass('order-tab-active');
            
                $('#order-details-content').toggle(false)
                $('#treasury-accounting-content').toggle(true)
                $('#order-notes-content').toggle(false);
            @endif
        });

        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                if (data.success != 0) {
                    AIZ.plugins.notify('success',
                    '{{ translate('Delivery status has been updated') }}');
                    $('#delivery_status').text(data.status)

                    if (data.bare_status == 'partial_release' || date.bare_status == 'ready_for_pickup') {
                        $('#partial_release_header').show();
                        $('.partial_released_body').show();
                    } else {
                        $('#partial_release_header').hide();
                        $('.partial_released_body').hide();
                    }
                } else {
                    AIZ.plugins.notify('danger', data.status + ' ' +
                        '{{ translate('is for quantities higher than one') }}');
                }
            });
        });

        $('#update_payment_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
                location.reload();
            });
        });

        function toggleOrder(id) {
            if (id == 'treasury-accounting') {
                $('#order-details').removeClass('order-tab-active');
                $('#notes').removeClass('order-tab-active');
                $('#treasury-accounting').addClass('order-tab-active');

                $('#order-details-content').toggle(false)
                $('#treasury-accounting-content').toggle(true)
                $('#order-notes-content').toggle(false);
            } else if (id == 'order-details') {
                $('#treasury-accounting').removeClass('order-tab-active');
                $('#notes').removeClass('order-tab-active');
                $('#order-details').addClass('order-tab-active');

                $('#order-details-content').toggle(true)
                $('#treasury-accounting-content').toggle(false)
                $('#order-notes-content').toggle(false);
            } else if (id == 'notes') {
                $('#treasury-accounting').removeClass('order-tab-active');
                $('#order-details').removeClass('order-tab-active');
                $('#notes').addClass('order-tab-active');

                $('#order-notes-content').toggle(true);
                $('#treasury-accounting-content').toggle(false);
                $('#order-details-content').toggle(false);
            }
        }
    </script>
@endsection
