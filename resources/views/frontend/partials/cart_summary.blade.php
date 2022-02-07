<div class="position-absolute">
    <div class="img-38"></div>
    <div class="img-39"></div>
    <div class="img-49"></div>
</div>
<div class="card border-0 shadow-sm rounded">
    <div class="shadow-sm bg-white p-3 p-lg-4 rounded text-left">
        <div class="summary_header">
            @php
                $total_price = 0;
                $total_point = 0;
                $handling_fee = 0;
                $pickup_location = [];
                $handlingFee = 0;
                $iterateValue = 0;
                $items = 0;
            @endphp

            @foreach (Session::get('toCheckout') as $key => $all_orders)
                @php
                    $items++;
                    $product = \App\Product::find($all_orders->id);
                    
                    $total_point += $product->earn_point * $all_orders->quantity;
                    
                    $total_price += ($all_orders->price + $all_orders->tax) * $all_orders->quantity;
                    
                    if (in_array($all_orders->pickup_location, $pickup_location)) {
                        // Do nothing
                    } else {
                        array_push($pickup_location, $all_orders->pickup_location);
                    }
                @endphp
            @endforeach

            @foreach ($pickup_location as $location)
                @foreach (Session::get('handlingFee') as $key => $itemStore)
                    @php
                        if (strtolower(str_replace(' ', '_', $itemStore->name)) == $location) {
                            $handlingFee += $itemStore->handling_fee;
                        }
                    @endphp
                @endforeach
            @endforeach

            @php
                $overall_total = $total_price + $handlingFee;
            @endphp

            <div class="fs-14 fw-600 float-right p-1 pl-2 pr-2" style="border: 1px solid #C2CBD7; background:#F2F5FA">
                {{ $items }} {{ translate('Item(s)') }}</div>
            <div class="fw-700 fs-24 " style="color:#0C0736;">{{ translate('Summary') }}</div>
        </div>
        <div class="summary-body">
            {{-- <div class="earning-points p-3 mb-4" style="color:#E4711A; background:#FFF8F3">
                <div class="float-right fw-400 fs-14">{{ $total_point }}</div>
                <div class="fs-14 fw-600 lh-21">
                    {{ translate('Earning Points') }}
                </div>
            </div> --}}
            <div class="fw-400 fs-14 lh-21 float-right">{{ single_price($total_price) }}</div>
            <div class="fw-600 fs-14 lh-21">{{ translate('Subtotal') }}</div>
            <hr>
            <div class="fw-400 fs-14 lh-21 float-right">{{ single_price($handlingFee) }}</div>
            <div class="fw-600 fs-14 lh-21">{{ translate('Handling Fee') }}</div>
            <div id="paynamics_selected" style="display: none;">
                <hr>
                <input type="hidden" id="paynamics_price_val">
                <div class="fw-400 fs-14 lh-21 float-right" id="paynamics_price"></div>
                <div class="fw-600 fs-14 lh-21">{{ translate('Paynamics Convenience Fee') }}</div>
            </div>
            <hr>
            @if (Session::has('coupon_discount'))
                <div class="fw-400 fs-14 lh-21 float-right">{{ single_price(Session::get('coupon_discount')) }}</div>
                <div class="fw-600 fs-14 lh-21">{{ translate('Coupon Discount') }}</div>
                <hr>
                @php
                    $overall_total -= Session::get('coupon_discount');
                @endphp
            @endif
            <input type="hidden" id="overall_total" value="{{ $overall_total }}">
            <div class="fw-600 fs-16 lh-21 float-right" id="overall_total_display" style="color:#D71921">{{ single_price($overall_total) }}</div>
            <div class="fw-600 fs-14 lh-21">{{ translate('Total') }}</div>
        </div>
        <div class="summary-footer">
            @if (Session::has('coupon_discount'))
                <div class="mt-3">
                    <form class="" action="{{ route('checkout.remove_coupon_code') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="form-control">{{ \App\Coupon::find(Session::get('coupon_id'))->code }}</div>
                            <div class="input-group-append">
                                <button type="submit"
                                    class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="my-3 mx-auto coupon-description-bg">
                        <div>
                            <strong>
                                Coupon Description:
                            </strong>
                            {{ \App\Coupon::find(Session::get('coupon_id'))->description }}
                        </div>
                        <div class="my-2">
                            <strong>
                                Discount:
                            </strong>

                            @if (\App\Coupon::find(Session::get('coupon_id'))->discount_type == 'amount')
                                ₱
                            @endif

                            {{ \App\Coupon::find(Session::get('coupon_id'))->discount }}

                            @if (\App\Coupon::find(Session::get('coupon_id'))->discount_type == 'percent')
                                {{ '%' }}
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-3">
                    <form class="" action="{{ route('checkout.apply_coupon_code') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-craft fs-26 lh-24 fw-400" name="code"
                                placeholder="{{ translate('Enter coupon code') }}" required>
                            <div class="input-group-append">
                                <button type="submit" style="position:absolute;height: 50px;top: 0;right: 0px;"
                                    class="btn-craft-primary-blue">
                                    {{ translate('Apply') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function computeTotal () {
        var paynamics_price = parseFloat(document.getElementById('paynamics_price_val').value);
        var overall_total = parseFloat(document.getElementById('overall_total').value);
        var total_price = paynamics_price + overall_total;

        document.getElementById('overall_total_display').innerHTML = '₱' + total_price.toFixed(2);
    }

    function removePaynamics () {
        document.getElementById('overall_total_display').innerHTML = "{{ single_price($overall_total) }}"
    }
</script>