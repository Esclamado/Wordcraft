@extends('frontend.layouts.app')

@section('content')

<section class="py-5 bg-lightblue">
    <div class="container">
        <div class="position-absolute">
            <div class="img-44"></div>
            <div class="img-45"></div>
            <div class="img-46"></div>
        </div>
        @php
            $order_count = 0;
        @endphp
        @foreach ($orders as $key => $order)
            @php
                $status = $order->orderDetails->first()->delivery_status;
                $order_count+=1;

            @endphp

            <div class="row">
                <div class="col-12 col-lg-10 mx-auto">
                    @if ($order_count <= 1)
                    <!-- <div class="steps-container border-0">
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
                                            <svg id="Layer_1" enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25" xmlns="http://www.w3.org/2000/svg"><g><path fill="white" d="m256 0c-108.81 0-197.333 88.523-197.333 197.333 0 61.198 31.665 132.275 94.116 211.257 45.697 57.794 90.736 97.735 92.631 99.407 6.048 5.336 15.123 5.337 21.172 0 1.895-1.672 46.934-41.613 92.631-99.407 62.451-78.982 94.116-150.059 94.116-211.257 0-108.81-88.523-197.333-197.333-197.333zm0 474.171c-38.025-36.238-165.333-165.875-165.333-276.838 0-91.165 74.168-165.333 165.333-165.333s165.333 74.168 165.333 165.333c0 110.963-127.31 240.602-165.333 276.838z"/><path fill="white" d="m378.413 187.852-112-96c-5.992-5.136-14.833-5.136-20.825 0l-112 96c-6.709 5.75-7.486 15.852-1.735 22.561s15.852 7.486 22.561 1.735l13.586-11.646v79.498c0 8.836 7.164 16 16 16h144c8.836 0 16-7.164 16-16v-79.498l13.587 11.646c6.739 5.777 16.836 4.944 22.561-1.735 5.751-6.709 4.974-16.81-1.735-22.561zm-66.413 76.148h-112v-90.927l56-48 56 48z"/></g></svg>
                                        </div>
                                        <div class="title fs-12">{{ translate("Customer Information") }}</div>
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
                                    <div class="col active done">
                                        <div class="icon">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M9.00008 0.666656C4.40008 0.666656 0.666748 4.39999 0.666748 8.99999C0.666748 13.6 4.40008 17.3333 9.00008 17.3333C13.6001 17.3333 17.3334 13.6 17.3334 8.99999C17.3334 4.39999 13.6001 0.666656 9.00008 0.666656ZM9.00008 15.6667C5.32508 15.6667 2.33341 12.675 2.33341 8.99999C2.33341 5.32499 5.32508 2.33332 9.00008 2.33332C12.6751 2.33332 15.6667 5.32499 15.6667 8.99999C15.6667 12.675 12.6751 15.6667 9.00008 15.6667ZM7.33341 10.8083L12.8251 5.31666L14.0001 6.49999L7.33341 13.1667L4.00008 9.83332L5.17508 8.65832L7.33341 10.8083Z"
                                                    fill="white" />
                                            </svg>
                                        </div>
                                        <div class="title fs-12">{{ translate('Confirmation') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                        <div class="order-confirmed-card">
                            <div class="text-center py-4 my-4">
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
                                    Thank you for your order!
                                </div>

                                <div class="order-confirmed-subtitle">
                                    A copy of your order summary has been sent to {{ Auth::user()->email }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card border-0 shadow-0 mt-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-start border-bottom">
                                <div class="card-customer-order-title">
                                  
                                    Order Code: <span class="text-craft-blue">{{ $order->code }}</span>
                                </div>
                            </div>
                            
                            
                    

                            {{-- // Order Details --}}
                            <div class="row mt-4">
                                <div class="col-12 col-lg-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="w-35 table-order-head px-0">{{ translate('Name')}}:</td>
                                            @if(Auth::user()->user_type == 'customer')
                                            <td class="table-order-data px-0" style="text-transform: capitalize;">{{ $order->user->name }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="w-35 table-order-head px-0">{{ translate('Phone Number')}}:</td>
                                            <td class="table-order-data px-0">{{ $order->user->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-35 table-order-head px-0">{{ translate('Email')}}:</td>
                                            @if ($order->user_id != null)
                                                <td class="table-order-data px-0 text-elipsis" style="max-width: 50px;">{{ $order->user->email }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="w-35 table-order-head px-0">{{ translate('Pickup Point')}}:</td>
                                            <td class="table-order-data px-0">
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
                                <div class="col-12 col-lg-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="w-35 table-order-head px-0">{{ translate('Order date') }}:</td>
                                            <td class="table-order-data px-0">
                                                {{ date('m-d-Y', $order->date) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-35 table-order-head px-0">{{ translate('Order status') }}:</td>
                                            <td class="table-order-data px-0">
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-35 table-order-head px-0">{{ translate('Payment Method') }}:</td>
                                            <td class="table-order-data px-0">
                                                {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4 table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th class="table-header-2" style="width: 5%;">#</th>
                                            <th class="table-header-2" style="width: 45%;">Product</th>
                                            <th class="table-header-2" style="width: 25%;">Quantity</th>
                                            <th class="table-header-2" style="width: 25%;">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetails as $key => $orderDetail)
                                            <tr class="table-r">
                                                <td class="table-data">
                                                    <div class="d-block d-flex align-items-center" style="height: 72px;">
                                                        {{ $key + 1 }}
                                                    </div>
                                                </td>
                                                <td class="table-data">
                                                    @if ($orderDetail->product != null)
                                                        <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank" class="d-block">
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-3">
                                                                    @php
                                                                        $product_image = null;

                                                                        if ($orderDetail->variation != "") {
                                                                            $product_image = \App\ProductStock::where('product_id', $orderDetail->product_id)
                                                                                ->where('variant', $orderDetail->variation)
                                                                                ->first();

                                                                            if ($product_image != null) {
                                                                                $product_image = uploaded_asset($product_image->image);
                                                                            }
                                                                            
                                                                            else {
                                                                                $product_image = uploaded_asset($orderDetail->product->thumbnail_img);
                                                                            }
                                                                        }

                                                                        else {
                                                                            $product_image = uploaded_asset($orderDetail->product->thumbnail_img);
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
                                                                    {{ $orderDetail->product->getTranslation('name') }} 

                                                                    @if ($orderDetail->variation != null)
                                                                        - {{ $orderDetail->variation }}
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
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="table-data">
                                                    <div class="d-block d-flex align-items-center" style="height: 72px;">
                                                        {{ $orderDetail->quantity }}
                                                    </div>
                                                </td>
                                                <td class="table-data">
                                                    <div class="d-block d-flex align-items-center" style="height: 72px;">
                                                        {{ single_price($orderDetail->price) }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <div class="row gutters-10 d-flex justify-content-end">
                                    <div class="col-12 col-lg-4">
                                        <div class="order-summary-1">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div class="order-summary-title">
                                                    Summary
                                                </div>
                                                <div class="order-summary-price">
                                                    {{ single_price($order->orderDetails->sum('price')) }}
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div class="order-summary-title">
                                                    Handling Fee
                                                </div>
                                                <div class="order-summary-price">
                                                    {{ single_price($order->orderDetails->sum('shipping_cost')) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <div class="order-summary-title">
                                                Total
                                            </div>
                                            <div class="order-summary-price-total">
                                                {{ single_price($order->grand_total) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
    </div>
</section>
@endsection

@section('script')
    <script>
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
    </script>
@endsection
