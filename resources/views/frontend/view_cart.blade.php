@extends('frontend.layouts.app')

@section('content')
    <section class="pt-5 pb-4 bg-lightblue">
        <div class="steps-container border-none">
            <div class="container">
                <div class="position-absolute">
                    <div class="img-44"></div>
                    <div class="img-47"></div>
                    <div class="img-48"></div>
                </div>
               <div class="row">
                    <div class="col-12 col-lg-7 mx-auto">
                        <div class="row gutters-5 text-center aiz-steps">
                            <div class="col active done">
                                <div class="icon bg-white">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.3 9.97C15.96 10.59 15.3 11 14.55 11H7.1L6 13H18V15H6C4.48 15 3.52 13.37 4.25 12.03L5.6 9.59L2 2H0V0H3.27L4.21 2H19.01C19.77 2 20.25 2.82 19.88 3.48L16.3 9.97ZM17.3099 4H5.15989L7.52989 9H14.5499L17.3099 4ZM6.00004 16C4.90003 16 4.01003 16.9 4.01003 18C4.01003 19.1 4.90003 20 6.00004 20C7.10004 20 8.00004 19.1 8.00004 18C8.00004 16.9 7.10004 16 6.00004 16ZM14.01 18C14.01 16.9 14.9 16 16 16C17.1 16 18 16.9 18 18C18 19.1 17.1 20 16 20C14.9 20 14.01 19.1 14.01 18Z"
                                            fill="white" />
                                    </svg>
                                </div>
                                <div class="title fs-12">{{ translate('My Cart') }}</div>
                            </div>

                            <div class="col">
                                <div class="icon">
                                    <svg id="Layer_1" enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25" xmlns="http://www.w3.org/2000/svg"><g><path d="m256 0c-108.81 0-197.333 88.523-197.333 197.333 0 61.198 31.665 132.275 94.116 211.257 45.697 57.794 90.736 97.735 92.631 99.407 6.048 5.336 15.123 5.337 21.172 0 1.895-1.672 46.934-41.613 92.631-99.407 62.451-78.982 94.116-150.059 94.116-211.257 0-108.81-88.523-197.333-197.333-197.333zm0 474.171c-38.025-36.238-165.333-165.875-165.333-276.838 0-91.165 74.168-165.333 165.333-165.333s165.333 74.168 165.333 165.333c0 110.963-127.31 240.602-165.333 276.838z"/><path d="m378.413 187.852-112-96c-5.992-5.136-14.833-5.136-20.825 0l-112 96c-6.709 5.75-7.486 15.852-1.735 22.561s15.852 7.486 22.561 1.735l13.586-11.646v79.498c0 8.836 7.164 16 16 16h144c8.836 0 16-7.164 16-16v-79.498l13.587 11.646c6.739 5.777 16.836 4.944 22.561-1.735 5.751-6.709 4.974-16.81-1.735-22.561zm-66.413 76.148h-112v-90.927l56-48 56 48z"/></g></svg>
                                </div>
                                <div class="title fs-12">{{ translate('Customer Information') }}</div>
                            </div>

                            <div class="col">
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" class="filter-black" fill="#none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6667 3.33334H3.33341C2.40841 3.33334 1.67508 4.075 1.67508 5L1.66675 15C1.66675 15.925 2.40841 16.6667 3.33341 16.6667H16.6667C17.5917 16.6667 18.3334 15.925 18.3334 15V5C18.3334 4.075 17.5917 3.33334 16.6667 3.33334ZM16.6667 15H3.33341V10H16.6667V15ZM3.33341 6.66667H16.6667V5H3.33341V6.66667Z" fill="black"/>
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
        </div>
    </section>

    <section class="mb-4" id="cart-summary">
        <div class="container">
            @php
                $pickup_location = [];
                $handlingFee = 0;
                $iterateValue = 0;
            @endphp

            @if (Session::get('cart') != null)
                @foreach (Session::get('cart') as $key => $cartItem)
                    @php
                        if (!in_array($cartItem['pickup_location'], $pickup_location)) {
                            array_push($pickup_location, $cartItem['pickup_location']);
                        }
                    @endphp
                @endforeach
            @endif

            @if (Session::has('cart') && count(Session::get('cart')) > 0)
                @auth
                    @if (Auth::user()->user_type == 'reseller')
                        @if (Auth::user()->reseller->is_verified != 1)
                            <div class="alert alert-danger">
                                <strong>Notice!</strong> As our first-time reseller, your first purchase should amount to <span class="text-danger fw-900">{{ single_price(\App\AffiliateOption::where('type', 'minimum_first_purchase')->first()->percentage ?? null) }}</span> before we process your next transactions and mark you as verified.
                            </div>
                        @endif
                    @endif
                @endauth
                <div class="row" id="cart">
                    <div class="col-xxl-8 col-xl-8 mx-auto" style="margin-bottom: 30px;">
                        <div class="shadow-sm bg-white p-3 p-lg-4 rounded text-left" style="margin-bottom:10px;">
                            <div class="float-right fs-14 fw-400 c-pointer">
                                <button class="btn-none d-flex" onclick="delete_select()">
                                    <svg width="14" height="18" viewBox="0 0 14 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.60921 0.333374H8.94254L10.0259 1.41671H13.2759V3.58337H0.275879V1.41671H3.52588L4.60921 0.333374ZM1.35922 15.5C1.35922 16.6917 2.33422 17.6667 3.52589 17.6667H10.0259C11.2176 17.6667 12.1926 16.6917 12.1926 15.5V4.6667H1.35922V15.5ZM3.52588 6.83337H10.0259V15.5H3.52588V6.83337Z"
                                        fill="#9199A4" />
                                    </svg>
                                    <span class="ml-2 t-subs">
                                        Delete
                                    </span>
                                </button>
                            </div>
                            <label for="checkbox_all" class="form-craft-check d-flex c-pointer mb-0">
                                <input type="checkbox" id="checkbox_all" onchange="change_box()">
                                <span class="t-black ml-3">{{ translate('Select All') }} &nbsp;</span>
                                <span class="fs-16 lh-24 fw-400 text-craft-sub">({{ count(Session::get('cart')) }}
                                    {{ translate('Item(s)') }})
                                </span>
                            </label>
                        </div>
                        @foreach ($pickup_location as $location)
                            @foreach (Session::get('handlingFee') as $key => $itemStore)
                                @php
                                    if (strtolower(str_replace(' ', '_', $itemStore->name)) == $location) {
                                        $handlingFee = $itemStore->handling_fee;
                                    }
                                @endphp
                            @endforeach
                            <div class="shadow-sm bg-white p-3 p-lg-4 rounded text-left mb-3">
                                <div class="mb-2">
                                    <div class="item-header d-lg-flex justify-content-lg-between">
                                        <label for="checkbox_locataion" class="form-craft-check border-primary pb-4 pr-0 mb-0">
                                            <div id="checkbox_location" class="d-flex pl-0">
                                                <div class="d-flex justify-content-start pl-0">
                                                    <input type="checkbox" id="{{ $location }}" class="mr-3 pickup-point-{{ $location }}"
                                                        onchange="change_box({{ $location }})">
                                                </div>

                                                <div class="d-flex mx-auto align-items-center pr-0">
                                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" class="ml-3"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M10.9999 1.83337C7.45242 1.83337 4.58325 4.70254 4.58325 8.25004C4.58325 13.0625 10.9999 20.1667 10.9999 20.1667C10.9999 20.1667 17.4166 13.0625 17.4166 8.25004C17.4166 4.70254 14.5474 1.83337 10.9999 1.83337ZM6.41659 8.25004C6.41659 5.72004 8.46992 3.66671 10.9999 3.66671C13.5299 3.66671 15.5833 5.72004 15.5833 8.25004C15.5833 10.89 12.9433 14.8409 10.9999 17.3067C9.09325 14.8592 6.41659 10.8625 6.41659 8.25004ZM8.70825 8.25004C8.70825 6.98439 9.73427 5.95837 10.9999 5.95837C11.8187 5.95837 12.5752 6.39516 12.9846 7.10421C13.3939 7.81325 13.3939 8.68683 12.9846 9.39587C12.5752 10.1049 11.8187 10.5417 10.9999 10.5417C9.73427 10.5417 8.70825 9.51569 8.70825 8.25004Z"
                                                            fill="black" fill-opacity="0.54" />
                                                    </svg>
                                                    <span class="t-black">
                                                        {{ translate('To be picked up in') }}
                                                    </span>
                                                    <span class="t-black fw-700 ml-1">{{ ucfirst(str_replace('_', ' ', $location)) }}</span>
                                                </div>

                                            </div>
                                        </label>
                                        <div
                                            class="text-craft-sub mt-lg-0  mb-lg-0  mb-4 mt-4 d-flex d-lg-block justify-content-center">
                                            <span class="fs-14 lh-21 fw-400">
                                                {{ translate('Handling fee in ') }}{{ ucfirst(str_replace('_', ' ', $location)) }}{{ translate(' :') }}
                                            </span>
                                            <span class="fs-14 lh-21 fw-600">
                                                ₱{{ $handlingFee }}
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="row gutters-5 d-none d-lg-flex mb-3 text-craft-secondary">
                                        <div class="col-md-5 text-subheader">{{ translate('Product') }}</div>
                                        <div class="col text-subheader">{{ translate('Price') }}</div>
                                        <div class="col text-subheader text-center pr-5">{{ translate('Quantity') }}</div>
                                        <div class="col text-subheader">{{ translate('Subtotal') }}</div>
                                        <div class="col-1"></div>
                                    </div>
                                    <div class="separator d-none d-lg-flex pt-0 mb-4">
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach (Session::get('cart') as $key => $cartItem)
                                            @if ($cartItem['pickup_location'] == $location)
                                                @php
                                                    $product = \App\Product::find($cartItem['id']);

                                                    $total = $total + $cartItem['price'] * $cartItem['quantity'];

                                                    $product_name_with_choice = $product->getTranslation('name');

                                                    if ($cartItem['variant'] != null) {
                                                        $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem['variant'];
                                                    }

                                                    $product_image = null;

                                                    if ($cartItem['variant'] != "") {
                                                        $product_image = \App\ProductStock::where('product_id', $cartItem['id'])
                                                            ->where('variant', $cartItem['variant'])
                                                            ->first()->image;

                                                        if ($product_image != null) {
                                                            $product_image = uploaded_asset($product_image);
                                                        }

                                                        else {
                                                            $product_image = uploaded_asset($product->thumbnail_img);
                                                        }
                                                    }

                                                    else {
                                                        $product_image = uploaded_asset($product->thumbnail_img);
                                                    }
                                                @endphp
                                                <li class="list-group-item px-0 pl-0">
                                                    <div class="row gutters-5">
                                                        <div class="col-lg-5 d-flex align-items-start align-items-lg-center">
                                                            <div class="d-flex mr-lg-3">
                                                                <div class="form-craft-check"
                                                                style="align-self:flex-end;">
                                                                    <div id="checkbox_item">
                                                                        <input name="chk_item" type="checkbox"
                                                                            id="{{ $location }}_{{ $cartItem['id'] }}_{{ $cartItem['variant'] }}"
                                                                            class="mr-3 pickup-point-item-{{ $location }}"
                                                                            onchange="change_box({{ $location }},{{ $loop->index }})"
                                                                            value="{{ $key }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-block d-lg-flex mr-auto ml-auto pr-4 ml-lg-0 mr-lg-0">
                                                                <div class="d-flex justify-content-center mr-lg-3">
                                                                    <img src="{{ $product_image }}"
                                                                        class="img-fluid craft-purchase-history-image mr-2 ls-is-cached lazyloaded "
                                                                        alt="{{ $product->getTranslation('name') }}">
                                                                </div>
                                                                <div class="d-flex align-items-center mt-lg-0 mt-3">
                                                                    <div>
                                                                        <div>
                                                                            <span class="fs-14 fw-400"
                                                                                style="color:#31303E;">{{ $product_name_with_choice }}
                                                                            </span>
                                                                        </div>
                                                                        @if ($cartItem['pickup_order'] == 'same_day_pickup')
                                                                            <div  class="d-flex justify-content-center justify-content-lg-start">
                                                                                <span class="notif-msg text-breadcrumb">
                                                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                                                        fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path fill-rule="evenodd"
                                                                                            clip-rule="evenodd"
                                                                                            d="M9 1.5C4.86 1.5 1.5 4.86 1.5 9C1.5 13.14 4.86 16.5 9 16.5C13.14 16.5 16.5 13.14 16.5 9C16.5 4.86 13.14 1.5 9 1.5ZM9 15C5.6925 15 3 12.3075 3 9C3 5.6925 5.6925 3 9 3C12.3075 3 15 5.6925 15 9C15 12.3075 12.3075 15 9 15ZM7.5 10.6275L12.4425 5.685L13.5 6.75L7.5 12.75L4.5 9.75L5.5575 8.6925L7.5 10.6275Z"
                                                                                            fill="#10865C" />
                                                                                    </svg>
                                                                                    <span class="order-status" style="color: green">Same
                                                                                        day pickup</span></span>
                                                                            </div>
                                                                        @endif
                                                                        @if ($cartItem['pickup_order'] == 'advance_order')
                                                                            <div class="d-flex justify-content-center justify-content-lg-start">
                                                                                <span class="notif-msg text-breadcrumb">
                                                                                    <svg width="16" height="16" viewBox="0 0 16 16"
                                                                                        fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path fill-rule="evenodd"
                                                                                            clip-rule="evenodd"
                                                                                            d="M8 0.5C3.86 0.5 0.5 3.86 0.5 8C0.5 12.14 3.86 15.5 8 15.5C12.14 15.5 15.5 12.14 15.5 8C15.5 3.86 12.14 0.5 8 0.5ZM7.25 4.25V5.75H8.75V4.25H7.25ZM7.25 7.25V11.75H8.75V7.25H7.25ZM2 8C2 11.3075 4.6925 14 8 14C11.3075 14 14 11.3075 14 8C14 4.6925 11.3075 2 8 2C4.6925 2 2 4.6925 2 8Z"
                                                                                            fill="#E49F1A" />
                                                                                    </svg>
                                                                                    <span class="order-status"
                                                                                        style="color: #f1cd87">Advanced
                                                                                        order</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                        <div
                                                            class="col-lg col-12 order-1 order-lg-0 my-3 my-lg-0 align-self-center d-flex justify-content-center justify-content-lg-start">
                                                            <div>
                                                                <span
                                                                    class="opacity-60 fs-12 d-block d-lg-none text-center">{{ translate('Price') }}
                                                                </span>
                                                                <span
                                                                    class="fw-400 fs-16">{{ single_price($cartItem['price'] + $cartItem['tax']) }}
                                                                </span>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg col-7 order-4 order-lg-0 align-self-center mx-auto pr-lg-5 mb-4 mb-lg-0">
                                                            @if ($cartItem['digital'] != 1)
                                                                <div class="row no-gutters align-items-center aiz-plus-minus mr-2 ml-0 pt-2 pb-2"
                                                                    style="border:1px solid #9199A4; width: 100%;">
                                                                    <button class="btn col-auto btn-icon btn-sm"
                                                                        type="button" data-type="minus"
                                                                        data-field="quantity[{{ $key }}]">
                                                                        <i class="las la-minus"></i>
                                                                    </button>
                                                                    @php
                                                                        $cart_sku = null;

                                                                        $pickup_location_id = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $cartItem['pickup_location'])))
                                                                            ->first()->id;
                                                                        
                                                                        if ($cartItem['variant'] != '') {
                                                                            $cart_sku = \App\ProductStock::where('product_id', $cartItem['id'])
                                                                                ->where('variant', $cartItem['variant'])
                                                                                ->first()->sku;
                                                                        }

                                                                        else {
                                                                            $cart_sku = \App\Product::where('id', $cartItem['id'])
                                                                                ->first()->sku;
                                                                        }

                                                                        $product_advance_order = \App\Product::where('id', $cartItem['id'])
                                                                            ->first()->advance_order;

                                                                        if ($product_advance_order != 1) {
                                                                            $worldcraft_stock_qty = \App\WorldcraftStock::where('sku_id', $cart_sku)
                                                                                ->where('pup_location_id', $pickup_location_id)
                                                                                ->first()->quantity;
                                                                        }

                                                                        else {
                                                                            $worldcraft_stock_qty = \App\WorldcraftStock::where('sku_id', $cart_sku)
                                                                                ->where('pup_location_id', $pickup_location_id)
                                                                                ->first()->quantity;

                                                                            if ($worldcraft_stock_qty == 0) {
                                                                                $worldcraft_stock_qty = 10;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    <input type="text" name="quantity[{{ $key }}]"
                                                                        class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                                                        placeholder="1"
                                                                        value="{{ $cartItem['quantity'] }}" min="1"
                                                                        max="{{ $worldcraft_stock_qty ?? 10 }}" readonly
                                                                        onchange="updateQuantity({{ $key }}, this, {{ $loop->index }})">
                                                                    <button class="btn col-auto btn-icon btn-sm"
                                                                        type="button" data-type="plus"
                                                                        data-field="quantity[{{ $key }}]">
                                                                        <i class="las la-plus"></i>
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="col-lg col-12 order-1 order-lg-0 my-3 my-lg-0 align-self-center d-flex justify-content-center justify-content-lg-start">
                                                            <div>
                                                                <span
                                                                    class="opacity-60 fs-12 d-block d-lg-none text-center">{{ translate('Subtotal') }}
                                                                </span>
                                                                <span
                                                                    class="fw-400 fs-16" id="sub_total_cart_{{ $cartItem['id'] }}_{{ $cartItem['pickup_location'] }}_{{ $cartItem['variant'] }}">{{ single_price(($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity']) }}
                                                                </span>
                                                            </div>

                                                        </div>
                                                        <div
                                                            class="col-lg-1 col-12 order-5 order-lg-0 text-center align-self-center">
                                                            <a href="javascript:void(0)"
                                                                onclick="removeFromCartView(event, {{ $key }})"
                                                                class="">
                                                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M10.6092 4.33337H14.9425L16.0259 5.41671H19.2759V7.58337H6.27588V5.41671H9.52588L10.6092 4.33337ZM7.35922 19.5C7.35922 20.6917 8.33422 21.6667 9.52589 21.6667H16.0259C17.2176 21.6667 18.1926 20.6917 18.1926 19.5V8.6667H7.35922V19.5ZM9.52588 10.8334H16.0259V19.5H9.52588V10.8334Z"
                                                                        fill="#9199A4" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="separator mt-4 mb-0 @if ($loop->last) d-none @endif"></div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                        <div class="row mt-3">
                            <div class="col-xxl-12 col-xl-12 d-flex mt-4">
                                <div class="col-xxl-6 col-xl-6 d-flex justify-content-start pl-0">
                                    <a href="{{ route('home') }}" class="link-back-cart d-flex align-items-center">
                                        <svg class="mr-2" width="19" height="20" viewBox="0 0 19 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.625 9.20833H5.40708L8.24125 6.36625L7.125 5.25L2.375 10L7.125 14.75L8.24125 13.6337L5.40708 10.7917H16.625V9.20833Z"
                                                fill="#62616A" />
                                        </svg>
                                        {{ translate('Return to shop') }}
                                    </a>
                                </div>
                                <div class="col-xxl-6 col-xl-6 d-flex justify-content-end pr-0">
                                    @if (Auth::check())
                                        <button onclick="checkout()"
                                            class="btn btn-primary fw-600 cart-mobile-ui">{{ translate('Proceed to Customer Information') }}
                                            <i class="las la-arrow-right m-2"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-primary fw-600 cart-mobile-ui"
                                            onclick="showCheckoutModal()">{{ translate('Continue to Customer Information') }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-xl-4">
                        <div class="shadow-sm bg-white p-3 p-lg-4 rounded text-left">
                            <div class="summary_header">
                                <div class="fs-14 fw-400 float-right p-1 pl-2 pr-2"
                                    style="border: 1px solid #C2CBD7; background:#F2F5FA">
                                    <span id="no_items">0</span> <span> <span>{{ translate('item(s)') }}</span></span>
                                </div>

                                <div class="text-header">{{ translate('Summary') }}</div>
                            </div>
                            <div class="summary-body">
                                <div id="sum_sub_total" class="fw-400 fs-14 lh-21 float-right">₱0.00</div>
                                <div class="text-subheader">{{ translate('Subtotal') }}</div>
                                <hr>
                                <div id="sum_handling_fee" class="fw-400 fs-14 lh-21 float-right">₱0.00</div>
                                <div class="text-subheader">{{ translate('Handling Fee') }}</div>
                                <hr>
                                <div id="sum_total" class="fw-600 fs-16 lh-21 float-right" style="color:#D71921">₱0.00</div>
                                <div class="text-subheader">{{ translate('Total') }}</div>
                            </div>
                            {{-- <div class="summary-footer">
                                @if (Session::has('coupon_discount'))
                                    <div class="mt-3">
                                        <form class="" action="{{ route('checkout.remove_coupon_code') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <div class="form-control">
                                                    {{ \App\Coupon::find(Session::get('coupon_id'))->code }}</div>
                                                <div class="input-group-append">
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                                                </div>
                                            </div>
                                        </form>
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
                                                    <button type="submit"
                                                        style="position:absolute;height: 50px;top: 0;right: 0px;"
                                                        class="btn-craft-primary-blue">
                                                        {{ translate('Apply') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div> --}}
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-xl-8 mx-auto">
                            <div class="shadow-sm bg-white p-4 rounded">
                                <div class="text-center p-3">
                                    <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                    <h3 class="h4 fw-700">{{ translate('Your Cart is empty') }}</h3>
                                </div>
                            </div>
                        </div>
                @endif
            </div>
        </section>
        </div>
    </section>
@endsection
@section('modal')
    <div class="modal fade" id="GuestCheckout">
        <div class="modal-dialog modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text"
                                    class="form-control form-craft h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                            </div>

                            <div class="form-group">
                                <input type="password" name="password"
                                    class="form-control form-craft h-auto form-control-lg"
                                    placeholder="{{ translate('Password') }}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="text-subprimary">{{ translate('Remember me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}"
                                        class="text-reset text-subprimary forget-color">{{ translate('Forgot password?') }}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit"
                                    class="btn btn-primary btn-login btn-block fw-600">{{ translate('Login') }}</button>
                            </div>
                        </form>
                        <div class="separator mb-3">
                            <span class="bg-white px-3 opacity-60">{{ translate('OR') }}</span>
                        </div>
                        <div>
                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                class="btn btn-styled btn-block btn-facebook btn-icon--2 btn-icon-left px-4 mb-3">
                                <svg class="left" width="10" height="18" viewBox="0 0 10 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.76858 18V9.94922H0V6.75H2.76858V4.2293C2.76858 1.49063 4.48676 0 6.99545 0C8.19746 0 9.22981 0.0878906 9.52941 0.126562V2.98828H7.78957C6.42513 2.98828 6.16163 3.62109 6.16163 4.5457V6.75H9.24064L8.81832 9.94922H6.16163V18"
                                        fill="white" />
                                </svg>
                                {{ translate('Login with Facebook') }}
                            </a>

                            <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                class="btn btn-styled btn-block btn-google btn-icon--2 btn-icon-left mb-3">
                                <svg class="left" width="19" height="19" viewBox="0 0 19 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.2633 7.94956H16.6257V7.91671H9.50065V11.0834H13.9748C13.322 12.9268 11.5681 14.25 9.50065 14.25C6.87746 14.25 4.75065 12.1232 4.75065 9.50004C4.75065 6.87685 6.87746 4.75004 9.50065 4.75004C10.7115 4.75004 11.8131 5.20683 12.6519 5.95298L14.8911 3.71375C13.4772 2.39602 11.5859 1.58337 9.50065 1.58337C5.12867 1.58337 1.58398 5.12806 1.58398 9.50004C1.58398 13.872 5.12867 17.4167 9.50065 17.4167C13.8726 17.4167 17.4173 13.872 17.4173 9.50004C17.4173 8.96923 17.3627 8.45108 17.2633 7.94956Z"
                                        fill="#FFC107" />
                                    <path
                                        d="M2.49609 5.81523L5.09711 7.72275C5.80091 5.98029 7.50536 4.75004 9.49997 4.75004C10.7108 4.75004 11.8124 5.20683 12.6512 5.95298L14.8904 3.71375C13.4765 2.39602 11.5852 1.58337 9.49997 1.58337C6.45918 1.58337 3.82214 3.3001 2.49609 5.81523Z"
                                        fill="#FF3D00" />
                                    <path
                                        d="M9.50094 17.4167C11.5458 17.4167 13.4039 16.6341 14.8087 15.3615L12.3585 13.2882C11.5636 13.8902 10.5756 14.25 9.50094 14.25C7.44181 14.25 5.69342 12.937 5.03475 11.1047L2.45312 13.0938C3.76333 15.6576 6.42413 17.4167 9.50094 17.4167Z"
                                        fill="#4CAF50" />
                                    <path
                                        d="M17.2627 7.94948H16.625V7.91663H9.5V11.0833H13.9741C13.6606 11.9688 13.091 12.7323 12.3563 13.2885C12.3567 13.2881 12.3571 13.2881 12.3575 13.2877L14.8077 15.3611C14.6344 15.5186 17.4167 13.4583 17.4167 9.49996C17.4167 8.96915 17.362 8.451 17.2627 7.94948Z"
                                        fill="#1976D2" />
                                </svg>
                                {{ translate('Login with Google') }}
                            </a>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <p class="text-muted mb-0 text-subprimary">{{ translate("Don't have an account yet?") }}
                            <a href="{{ route('user.registration') }}">
                                {{ translate('Register Now') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (Session::has('cart'))
@section('script')
<script type="text/javascript">

var session_cart = [];
@foreach (Session::get('cart') as $key => $cartItem)
            var cart_session =
            {
                id: '{{$cartItem['id']}}',
                owner_id: '{{$cartItem['owner_id']}}',
                pickup_location: '{{$cartItem['pickup_location']}}',
                pickup_order: '{{$cartItem['pickup_order']}}',
                variant: '{{$cartItem['variant']}}',
                quantity: '{{$cartItem['quantity']}}',
                price: '{{$cartItem['price']}}',
                tax: '{{$cartItem['tax']}}',
                shipping: '{{$cartItem['shipping']}}',
                product_referral_code: '{{$cartItem['product_referral_code']}}',
                digital: '{{$cartItem['digital']}}'
            };
            session_cart.push(cart_session);
                @endforeach
    $(document).ready(function() {

       @foreach (Session::get('cart') as $key => $cartItem)

       $('.pickup-point-item-{{$cartItem['pickup_location']}}').click(function() {
            if ($('.pickup-point-item-{{$cartItem['pickup_location']}}:checked').length == $('.pickup-point-item-{{$cartItem['pickup_location']}}').length) {
                $('.pickup-point-{{$cartItem['pickup_location']}}').prop('checked', true);
            } else {
            $('.pickup-point-{{$cartItem['pickup_location']}}').prop('checked', false);
            }
        });

       @endforeach

        $('#cart #checkbox_all').click(function(event){
            var sub_total=0;
            var handling_fee=0;
            if($('#cart #checkbox_all').is(':checked')){
                @foreach (Session::get('cart') as $key => $cartItem)
                    $('#cart #checkbox_item #'+'{{$cartItem['pickup_location']}}_{{$cartItem['id']}}_{{ $cartItem['variant'] }}').prop( "checked", true );
                    $('#cart #checkbox_location #'+'{{$cartItem['pickup_location']}}').prop( "checked", true );
                @endforeach
            }else{
                $('#cart #checkbox_location #'+event.target.id).prop( "checked", false );
                @foreach (Session::get('cart') as $key => $cartItem)
                    $('#cart #checkbox_item #'+'{{$cartItem['pickup_location']}}_{{$cartItem['id']}}_{{ $cartItem['variant'] }}').prop( "checked", false );
                    $('#cart #checkbox_location #'+'{{$cartItem['pickup_location']}}').prop( "checked", false );
                    this.sub_total = '{{$cartItem['price']}}';
                @endforeach
            }
        });

        $('#cart #checkbox_location input:checkbox').click(function(event){
            var allcheck = true;
            if($('#cart #checkbox_location #'+event.target.id).is(':checked')){
                allcheck = true;
                @foreach (Session::get('cart') as $key => $cartItem)
                    if('{{$cartItem['pickup_location']}}' == event.target.id){
                        $('#cart #checkbox_item #'+'{{$cartItem['pickup_location']}}_{{$cartItem['id']}}_{{ $cartItem['variant'] }}').prop( "checked", true );
                    }
                    if( $('#cart #checkbox_item #'+'{{$cartItem['pickup_location']}}_{{$cartItem['id']}}_{{ $cartItem['variant'] }}').is(':checked')){

                    }else{
                        allcheck = false;
                    }
                @endforeach

                if(allcheck){
                    $('#cart #checkbox_all').prop("checked", true)
                }
            }else{
                $('#cart #checkbox_all').prop( "checked", false );
                @foreach (Session::get('cart') as $key => $cartItem)
                    if( '{{$cartItem['pickup_location']}}' == event.target.id){
                        $('#cart #checkbox_item #'+'{{$cartItem['pickup_location']}}_{{$cartItem['id']}}_{{ $cartItem['variant'] }}').prop( "checked", false );
                    }
                @endforeach
            }

        });

        $('#cart #checkbox_item input:checkbox').click(function(event){
            var target = event.target.id;
            var target = target.split("_",2);
            var loc = target[0];
            var prodId = target[1];
            var loccheck = true;
            var allcheck = true;
            var subtotal =0;
            if($('#cart #checkbox_item #'+event.target.id).is(':checked')){
                loccheck = true;
                allcheck = true;
                @foreach (Session::get('cart') as $key => $cartItem)
                    if('{{$cartItem['pickup_location']}}' == loc){
                        if($('#cart #checkbox_item #'+loc+'_{{$cartItem['id']}}_{{ $cartItem['variant'] }}').is(':checked')){
                        }else{
                            loccheck = false;
                        }

                    }
                    if($('#cart #checkbox_item #'+'{{$cartItem['pickup_location']}}_{{$cartItem['id']}}_{{ $cartItem['variant'] }}').is(':checked')){

                    }else{
                        allcheck = false;
                    }
                @endforeach
                if(loccheck){
                    $('#cart #checkbox_location #'+loc).prop( "checked", true );
                }
                if(allcheck){
                    $('#cart #checkbox_all').prop( "checked", true );
                }
            }else{
                $('#cart #checkbox_all').prop( "checked", false );
                $('#cart #checkbox_location #'+loc).prop( "checked", false );
            }

        });
    });

function removeFromCartView(e, key){
    e.preventDefault();
    removeFromCart(key);
}


function delete_select(){
    var array_data=[];
    session_cart.forEach((data)=>{
        if($('#cart #checkbox_item #'+data.pickup_location+"_"+data.id+"_"+data.variant).is(':checked')){
            array_data.push($('#cart #checkbox_item #'+data.pickup_location+"_"+data.id+"_"+data.variant).val());
        }
    })
    if(array_data.length > 0){
        $.post('{{ route('cart.removeItemsFromCart') }}', {_token: AIZ.data.csrf, key:array_data}, function(data){
                updateNavCart();
                $('#cart-summary').html(data);
                AIZ.plugins.notify('success', 'Item has been removed from cart');
                $('#cart_items_sidenav').html(parseFloat($('#cart_items_sidenav').html())-1);
            });
    }
    else{
        AIZ.plugins.notify('danger', 'No item selected.');
    }
}

function updateQuantity(key, element,index) {
    $.post('{{ route('cart.updateQuantity') }}', {
        _token: '{{ csrf_token() }}',
        key: key,
        quantity: element.value
    }, function(data) {
        var total = (data[index].price + data[index].tax) * data[index].quantity;
        document.getElementById("sub_total_cart_" + data[index].id +"_" + data[index].pickup_location + "_" + data[index].variant).innerHTML = '₱' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        updateNavCart(data);
        session_cart = data ;
        change_box();
    });
}

function change_box(location, index){
    var total= 0;
    var item_count= 0 ;
    var pickup_loc = [];
    var fee = 0;
    session_cart.forEach((data)=>{
        if($('#cart #checkbox_item #'+data.pickup_location+"_"+data.id+"_"+data.variant).is(':checked')){
            total += (parseFloat(data.price)+parseFloat(data.tax))*parseFloat(data.quantity);
            pickup_loc.push(data.pickup_location);
            item_count += 1;
        }
    })
    @foreach (Session::get('cart') as $key => $cartItem)
        if($('#cart #checkbox_item #'+'{{$cartItem['pickup_location']}}_{{$cartItem['id']}}').is(':checked')){
            total += (parseFloat('{{$cartItem['price']}}')+parseFloat('{{$cartItem['tax']}}'))*parseFloat('{{$cartItem['quantity']}}');
            pickup_loc.push('{{$cartItem['pickup_location']}}');
            item_count += 1;
        }
        @endforeach

       pickup_loc.forEach((data)=>{
        @foreach (Session::get('handlingFee') as $key => $itemStore)
                  if ('{{ strtolower(str_replace(' ', '_', $itemStore->name)) }}' == data) {
                    fee += parseFloat({{$itemStore->handling_fee}});
                  }
        @endforeach
        })
        var grand_total = total +fee;

        document.getElementById("sum_sub_total").innerHTML = '₱' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById("sum_handling_fee").innerHTML ='₱' + fee.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById("sum_total").innerHTML = '₱' + grand_total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById("no_items").innerHTML = item_count;
    }


function showCheckoutModal() {
    $('#GuestCheckout').modal();
}

function checkout(){
    var dataToSave = [];

    session_cart.forEach((data)=>{
        if($('#cart #checkbox_item #'+data.pickup_location+"_"+data.id+"_"+data.variant).is(':checked')){
            var dataChecked =
            {
                id: data.id,
                owner_id: data.owner_id,
                pickup_location: data.pickup_location,
                pickup_order:data.pickup_order,
                variant:data.variant,
                quantity:data.quantity,
                price:data.price,
                tax:data.tax,
                shipping:data.shipping,
                product_referral_code:data.product_referral_code,
                digital:data.digital
            };
            dataToSave.push(dataChecked);
        }
    })

    // @foreach (Session::get('cart') as $key => $cartItem)
    //     if($('#cart #checkbox_item #'+'{{$cartItem['pickup_location']}}_{{$cartItem['id']}}').is(':checked')){
    //         console.log('{{$cartItem['id']}}');
    //         var dataChecked =
    //         {
    //             id: '{{$cartItem['id']}}',
    //             owner_id: '{{$cartItem['owner_id']}}',
    //             pickup_location: '{{$cartItem['pickup_location']}}',
    //             pickup_order: '{{$cartItem['pickup_order']}}',
    //             variant: '{{$cartItem['variant']}}',
    //             quantity: '{{$cartItem['quantity']}}',
    //             price: '{{$cartItem['price']}}',
    //             tax: '{{$cartItem['tax']}}',
    //             shipping: '{{$cartItem['shipping']}}',
    //             product_referral_code: '{{$cartItem['product_referral_code']}}',
    //             digital: '{{$cartItem['digital']}}'
    //         };
    //         dataToSave.push(dataChecked);
    //     }
    // @endforeach

    data = {
        "_token": "{{ csrf_token() }}",
        "dataToSave" : JSON.stringify({dataToSave})
    }

    $.ajax({
        type:"POST",
        // contentType: 'application/json; charset=utf-8',
        url: '{{ route('save.checkout.item') }}',
        data: data,
        success: function(data){
            if(data == 'success'){
                window.location.href = "{{ route('checkout.shipping_info')}}";
            }else{
                window.location.href = "{{ route('checkout.shipping_info')}}";
            }
        }
    });
}
</script>

@endsection

@endif