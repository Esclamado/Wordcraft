@extends('backend.layouts.app')
@php 
  $status_order = (app('request')->input('edit'));
  $total_price = 0;
  $total_product = 0;
@endphp;
@section('content')

    <div class="pb-7 d-flex justify-content-start">
        <a class="d-flex align-items-center back-arrow text-gray c-pointer" href="{{ route('cashier.orders')}}">
            <svg width="15" height="10" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="icon" d="M14.625 4.20833H3.40708L6.24125 1.36625L5.125 0.25L0.375 5L5.125 9.75L6.24125 8.63375L3.40708 5.79167H14.625V4.20833Z" fill="#62616A"/>
            </svg>
            Back to orders
        </a>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card border-0 rounded-0 shadow-none">
                <div class="card-body">
                    <!-- start tooggle order-details, treasury-accounting, notes -->
                    <div class="d-flex justify-content-start border-bottom navs">
                        <div id="order-details" class="order-tab opacity-50 order-tab-active mr-2 d-flex align-items-center"
                            onclick="toggleOrder('order-details')">
                            Order Details
                        </div>
                        <div id="treasury-accounting" class="order-tab opacity-50 d-flex align-items-center mr-2"
                            onclick="toggleOrder('treasury-accounting')">
                            Treasury @if (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'CMG') and CMG @endif
                        </div>

                        <div id="notes" class="order-tab opacity-50 d-flex align-items-center"
                            onclick="toggleOrder('notes')">
                            Notes
                        </div>
                    </div>
                    <!-- End tooggle order-details, treasury-accounting, notes -->

                    <!-- Start Order Details -->
                    <div id="order-details-content" class="order-details-content p-20px" style="margin: 0px;">
                        @php
                            $delivery_status = $order->orderDetails->first()->delivery_status;
                            $payment_status = $order->orderDetails->first()->payment_status;
                        @endphp
                        <div class="row">
                            <div class="col-6 d-flex flex-column" style="row-gap: 15px;">
                                <span class="text-label">
                                    Display Name: <strong class="pl-10px">{{ $order->user->username ?? "N/A" }}</strong> 
                                </span>
                                <span class="text-label">
                                    Name: <strong class="pl-10px">{{ $order->user->name ?? "N/A"}}</strong> 
                                </span>
                                <span class="text-label">
                                    Email: <strong class="pl-10px">{{ $order->user->email ?? "N/A"}}</strong> 
                                </span>
                                <span class="text-label">
                                    Phone: <strong class="pl-10px">{{ $order->user->phone ?? "N/A" }}</strong> 
                                </span>
                                <span class="text-label">
                                    Address: <strong class="pl-10px">{{ $order->user->address ?? "N/A" }}</strong> 
                                </span>
                                <span class="text-label">
                                    Tin No.: 
                                    @if ($order->user->user_type == 'reseller')
                                        <strong>{{ $order->user->reseller['tin'] ?? 'N/A' }}</strong>
                                    @else
                                        <strong>{{ $order->user->tin_no ?? "N/A" }}</strong>
                                    @endif
                                </span>

                                <span class="text-label" style="margin-top: 25px;">
                                    @php
                                        $pickup_location = ucwords(str_replace("_"," ",$order->pickup_point_location));
                                        $address = \App\PickupPoint::where(['name' => $pickup_location])->first()->address;
                                    @endphp
                                    {{ translate('Pickup Point') }}:<strong class="pl-10px">{{$pickup_location}}</strong> 
                                </span>
                                <span class="text-label">
                                    {{ translate('Address') }}:<strong class="pl-10px">{{$address}}</strong> 
                                </span>
                            </div>
                            <div class="col-6 d-flex flex-column" style="row-gap: 15px;">
                                <span class="text-label">
                                    {{ translate('Order Number') }}:<strong class="pl-10px text-orange">#{{ $order->code }}</strong> 
                                </span>
                                <span class="text-label">
                                    {{ translate('Order Status') }}: 
                                    <strong class="pl-10px @if($order->order_status == 'released') text-success @else text-orange @endif">{{ $order->order_status ? ucfirst(str_replace('_', ' ', $order->order_status)) : 'Pending'}}</strong>
                                </span>
                                <span class="text-label">
                                    {{ translate('Order Date') }}:<strong class="pl-10px">{{ date('F d,Y', $order->date) }}</strong> 
                                </span>
                                <span class="text-label">
                                    {{ translate('Total Amount') }}:<strong class="pl-10px">{{ single_price($order->grand_total) }}</strong> 
                                </span>
                                <span class="text-label">
                                    {{ translate('Payment Method') }}:<strong class="pl-10px">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</strong> 
                                </span>
                                <span class="text-label">
                                    {{ translate('Payment Status') }}:<strong class="pl-10px @if($order->payment_status == 'unpaid') text-orange @else text-success @endif">{{ ucfirst($order->payment_status) }}</strong> 
                                </span>

                                @if ($order->order_status)
                                    <span class="text-label" style="margin-top: 25px;">
                                        {{ $order->order_status == 'cancel' ? 'Reason for cancellation' : 'Reason for revision' }}:<strong class="pl-10px">{{ ucfirst(str_replace('_', ' ', $order->reason_type )) }}</strong> 
                                    </span>
                                    @if ($order->reason_type == 'others')
                                        <span class="text-label">
                                            {{ translate('Other reason') }}:<span class="pl-10px">{{ $order->reason_field }}</span> 
                                        </span>
                                    @endif                                    
                                @endif
                            </div>
                        </div>
                        <hr class="custom-hr">
                        @if ($order->payment_status == 'paid' && ($order->order_status != 'for_revision' && $order->order_status != 'released') && (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Cashier'))
                            <div class="d-flex justify-content-end">
                                <button type="button" id="edit_order" class="d-flex align-items-end back-arrow text-orange c-pointer" style="background-color: #9acd3200; border-color: #9acd3200;">
                                    <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.8578 16.1672L20.3578 14.6672C20.5922 14.4328 21 14.5969 21 14.9344V21.75C21 22.9922 19.9922 24 18.75 24H2.25C1.00781 24 0 22.9922 0 21.75V5.24998C0 4.00779 1.00781 2.99998 2.25 2.99998H15.0703C15.4031 2.99998 15.5719 3.4031 15.3375 3.64216L13.8375 5.14216C13.7672 5.21248 13.6734 5.24998 13.5703 5.24998H2.25V21.75H18.75V16.4297C18.75 16.3312 18.7875 16.2375 18.8578 16.1672ZM26.1984 6.70779L13.8891 19.0172L9.65156 19.4859C8.42344 19.6219 7.37813 18.5859 7.51406 17.3484L7.98281 13.1109L20.2922 0.801538C21.3656 -0.271899 23.1 -0.271899 24.1687 0.801538L26.1937 2.82654C27.2672 3.89998 27.2672 5.63904 26.1984 6.70779ZM21.5672 8.15623L18.8438 5.43279L10.1344 14.1469L9.79219 17.2078L12.8531 16.8656L21.5672 8.15623ZM24.6047 4.42029L22.5797 2.39529C22.3875 2.2031 22.0734 2.2031 21.8859 2.39529L20.4375 3.84373L23.1609 6.56716L24.6094 5.11873C24.7969 4.92185 24.7969 4.61248 24.6047 4.42029Z" fill="#D75219"/>
                                    </svg>
                                    Edit Order
                                </button>
                                <input type="hidden" id="order_id" value="{{ $order->id}}">
                            </div>                    
                        @endif
                        <div class="d-none" id="edit_order_form">
                            <div class="d-flex flex-column" style="row-gap: 15px;" >
                                <span class="text-label"><strong>Add product
                                </strong></span>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="position-relative flex-grow-1">
                                            <form action="{{ route('cashier.order.view', encrypt($order->id)) }}" method="GET" class="stop-propagation">
                                                <div class="d-flex position-relative align-items-center">
                                                    <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                                        <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                                    </div>
                                                    <input type="text" hidden value="edit_order" name="page">
                                                    <div class="input-group">
                                                        <input type="text" class="border-0 border-lg form-control form-craft search-border text-subprimary" id="search" name="q" value="{{ request()->query('q') }}" placeholder="{{translate('I am shopping for...')}}" autocomplete="off" style="height: 50px">
                                                        <input type="text" hidden value="{{ $order->id }}" id="search_order_id">
                                                        <input type="text" hidden value="{{ $order->pickup_point_location }}" id="location">
                                                        <div class="input-group-append d-none d-lg-block">
                                                            <button class="btn btn-orange" type="submit" style="height: 50px;">
                                                                <i class="la la-search la-flip-horizontal fs-18"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg left-0 top-100 w-100" style="min-height: 200px; position: absolute; z-index: 999;">
                                                <div class="search-preloader absolute-top-center">
                                                    <div class="dot-loader"><div></div><div></div><div></div></div>
                                                </div>
                                                <div class="search-nothing d-none p-3 text-center fs-16">
            
                                                </div>
                                                <div id="search-content" class="text-left" style="width: 500px">
                                                
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <form action="{{ route('walkin.product') }}" method="GET">
                                            <input type="text" hidden value={{ encrypt($order->id) }} name="order_id">
                                            <div>
                                                <button class="btn btn-outline-blue d-flex align-items-center justify-content-center" type="submit" style="height: 50px; width: 250px;">Browse Products</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="z-index: -1; margin-top: 50px;">
                            @php
                                $added_items = \App\OrderEditDetail::where([["order_id", "=", $order->id], ["is_edit", "=", 1], ["is_deleted", "=", null]])
                                ->orWhere([["order_id", "=", $order->id], ["edit_qty", ">", 0], ["is_edit", "=", null], ["is_deleted", "=", null]])
                                ->get(); 
                            @endphp
                           

                            @if ($order->order_status == 'for_revision')
                                {{-- Additional items --}}
                                @if(count($added_items))
                                <span class="text-green text-label"><strong>Additional Items</strong></span>
                                <div class="row" style="border-bottom: 1px solid #E9F1FC; height: 50px;" id="table_head"> 
                                    <div class="col-2 order-items back-arrow">{{ translate('Product') }}</div>
                                    <div class="col-3 order-items back-arrow"></div>
                                    <div class="col-2 order-items back-arrow">{{ translate('SKU') }}</div>
                                    <div class="col-2 order-items back-arrow">{{ translate('Price') }}</div>
                                    <div class="col-2 order-items back-arrow">{{ translate('Quantity') }}</div>
                                    <div class="col-1 order-items back-arrow">{{ translate('Subtotal') }}</div>
                                </div>
                                @endif
                                @foreach ($order->orderEditDetails as $key => $orderDetail)
                                    @if (($orderDetail->is_edit == 1 || $orderDetail->edit_qty > 0) && $orderDetail->is_deleted != 1)
                                        <div class="row" style="min-height: 100px; border-bottom: 1px solid #E9F1FC; margin-bottom: 50px;">
                                            <div class="col-2 order-items">
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
                                                        <img height="150" style="max-width: 100%" src="{{ $product_image }}">
                                                    </a>
                                                @else
                                                    <strong>{{ translate('N/A') }}</strong>
                                                @endif
                                            </div>
                                            <div class="col-3 order-items">
                                                @if ($orderDetail->product != null)
                                                    <strong><a
                                                            href="{{ route('product', $orderDetail->product->slug) }}"
                                                            target="_blank"
                                                            class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                                    <small style="margin-left: 10px;">{{ $orderDetail->variation }}</small>
                                                @else
                                                    <strong>{{ translate('Product Unavailable') }}</strong>
                                                @endif
                                            </div>
                                            <div class="col-2 order-items">
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
                                            </div>
                                            <div class="col-2 order-items">{{ single_price($orderDetail->price / $orderDetail->quantity) }}</div>
                                            <div class="col-2 order-items">{{ $orderDetail->edit_qty > 0 ? $orderDetail->edit_qty : $orderDetail->quantity }}</div>
                                            <div class="col-1 order-items">{{ single_price($orderDetail->price) }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            
                                {{-- Deleted Items --}}
                                @php
                                    $remove_items = \App\OrderEditDetail::where([["order_id", "=", $order->id], ["is_deleted", "=", 1]])
                                    ->orWhere([["order_id", "=", $order->id], ["edit_qty", "<", 0]])
                                    ->get(); 
                                @endphp
                                @if (count($remove_items))
                                    <span class="text-label red"><strong>Removed Items</strong></span>
                                    <div class="row" style="border-bottom: 1px solid #E9F1FC; height: 50px;" id="table_head"> 
                                        <div class="col-2 order-items back-arrow">{{ translate('Product') }}</div>
                                        <div class="col-3 order-items back-arrow"></div>
                                        <div class="col-2 order-items back-arrow">{{ translate('SKU') }}</div>
                                        <div class="col-2 order-items back-arrow">{{ translate('Price') }}</div>
                                        <div class="col-2 order-items back-arrow">{{ translate('Quantity') }}</div>
                                        <div class="col-1 order-items back-arrow">{{ translate('Subtotal') }}</div>
                                    </div>
                                    @foreach ($order->orderEditDetails as $key => $orderDetail)
                                        @if (($orderDetail->is_deleted == 1 || $orderDetail->edit_qty < 0) && $orderDetail->is_edit == null)
                                            <div class="row" style="min-height: 100px; border-bottom: 1px solid #E9F1FC; margin-bottom: 50px;">
                                                <div class="col-2 order-items">
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
                                                            <img height="150" style="max-width: 100%" src="{{ $product_image }}">
                                                        </a>
                                                    @else
                                                        <strong>{{ translate('N/A') }}</strong>
                                                    @endif
                                                </div>
                                                <div class="col-3 order-items">
                                                    @if ($orderDetail->product != null)
                                                        <strong><a
                                                                href="{{ route('product', $orderDetail->product->slug) }}"
                                                                target="_blank"
                                                                class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                                        <small style="margin-left: 10px;">{{ $orderDetail->variation }}</small>
                                                    @else
                                                        <strong>{{ translate('Product Unavailable') }}</strong>
                                                    @endif
                                                </div>
                                                <div class="col-2 order-items">
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

                                                </div>
                                                <div class="col-2 order-items">{{ single_price($orderDetail->price / $orderDetail->quantity) }}</div>
                                                <div class="col-2 order-items">{{ $orderDetail->edit_qty < 0 ? ($orderDetail->edit_qty * -1) : $orderDetail->quantity }}</div>
                                                <div class="col-1 order-items">{{ single_price($orderDetail->price) }}</div>
                                            </div>
                                        @endif
                                    @endforeach                                    
                                @endif
                                <span class="text-label"><strong>Original Order</strong></span>
                                <div class="row" style="border-bottom: 1px solid #E9F1FC; height: 50px;" id="table_head"> 
                                    <div class="col-2 order-items back-arrow">{{ translate('Product') }}</div>
                                    <div class="col-3 order-items back-arrow"></div>
                                    <div class="col-2 order-items back-arrow">{{ translate('SKU') }}</div>
                                    <div class="col-2 order-items back-arrow">{{ translate('Price') }}</div>
                                    <div class="col-2 order-items back-arrow">{{ translate('Quantity') }}</div>
                                    <div class="col-1 order-items back-arrow">{{ translate('Subtotal') }}</div>
                                </div>
                                @foreach ($order->orderDetails as $key => $orderDetail)
                                    <div class="row" style="min-height: 100px; border-bottom: 1px solid #E9F1FC;" >
                                        <div class="col-2 order-items">
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
                                                    <img height="150" style="max-width: 100%" src="{{ $product_image }}">
                                                </a>
                                            @else
                                                <strong>{{ translate('N/A') }}</strong>
                                            @endif
                                        </div>
                                        <div class="col-3 order-items">
                                            @if ($orderDetail->product != null)
                                                <strong><a
                                                        href="{{ route('product', $orderDetail->product->slug) }}"
                                                        target="_blank"
                                                        class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                                <small style="margin-left: 10px;">{{ $orderDetail->variation }}</small>
                                            @else
                                                <strong>{{ translate('Product Unavailable') }}</strong>
                                            @endif
                                        </div>
                                        <div class="col-2 order-items">
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
                                        </div>
                                        <div class="col-2 order-items">{{ single_price($orderDetail->price / $orderDetail->quantity) }}</div>
                                        <div class="col-2 order-items">{{ $orderDetail->quantity }}</div>
                                        <div class="col-1 order-items">{{ single_price($orderDetail->price) }}</div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Start Original Table -->     
                                <div class="row" style="border-bottom: 1px solid #E9F1FC; height: 50px;" id="table_head"> 
                                    <div class="col-2 order-items back-arrow">{{ translate('Product') }}</div>
                                    <div class="col-3 order-items back-arrow"></div>
                                    <div class="col-2 order-items back-arrow">{{ translate('SKU') }}</div>
                                    <div class="col-2 order-items back-arrow">{{ translate('Price') }}</div>
                                    <div class="col-2 order-items back-arrow">{{ translate('Quantity') }}</div>
                                    <div class="col-1 order-items back-arrow">{{ translate('Subtotal') }}</div>
                                </div>
                                <!-- End Original Table -->

                                <!-- Start Content Original Body Table -->
                                <div class="" id="table_content">
                                    @foreach ($order->orderDetails as $key => $orderDetail)
                                        <div class="row" style="min-height: 100px; border-bottom: 1px solid #E9F1FC;" >
                                            <div class="col-2 order-items">
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
                                                        <img height="150" style="max-width: 100%" src="{{ $product_image }}">
                                                    </a>
                                                @else
                                                    <strong>{{ translate('N/A') }}</strong>
                                                @endif
                                            </div>
                                            <div class="col-3 order-items">
                                                @if ($orderDetail->product != null)
                                                    <strong><a
                                                            href="{{ route('product', $orderDetail->product->slug) }}"
                                                            target="_blank"
                                                            class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                                    <small style="margin-left: 10px;">{{ $orderDetail->variation }}</small>
                                                @else
                                                    <strong>{{ translate('Product Unavailable') }}</strong>
                                                @endif
                                            </div>
                                            <div class="col-2 order-items">
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
                                            </div>
                                            <div class="col-2 order-items">{{ single_price($orderDetail->price / $orderDetail->quantity) }}</div>
                                            <div class="col-2 order-items">{{ $orderDetail->quantity }}</div>
                                            <div class="col-1 order-items">{{ single_price($orderDetail->price) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- End Content Original Body Table -->

                                <!-- Start Edit Order Table -->
                                <div class="row d-none" style="border-bottom: 1px solid #E9F1FC; height: 50px;" id="edit_table_head">
                                    <div class="col-2 order-items back-arrow">{{ translate('Product') }}</div>
                                    <div class="col-3 order-items back-arrow"></div>
                                    <div class="col-2 order-items back-arrow">{{ translate('SKU') }}</div>
                                    <div class="col-1 order-items back-arrow">{{ translate('Price') }}</div>
                                    <div class="col-2 order-items back-arrow">{{ translate('Quantity') }}</div>
                                    <div class="col-1 order-items back-arrow">{{ translate('Subtotal') }}</div>
                                    <div class="col-1 order-items back-arrow"></div>
                                </div>
                                <!-- End Edit Order Table -->
                                <!-- Start Edit Order Content Body Table -->
                                <div class="d-none" id="edit_table_content">
                                    @foreach ($order->orderEditDetails as $key => $orderDetail)
                                        @if ($orderDetail->is_deleted != 1)
                                            @php 
                                                $total_price += $orderDetail->price; 
                                                $total_product += 1;
                                            @endphp
                                            <form action="{{ route('cashier.order.destroy', [$orderDetail->id]) }}" method="POST">
                                                @csrf
                                                <div class="row" style="min-height: 100px; border-bottom: 1px solid #E9F1FC;">
                                                    <div class="col-2 order-items">
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
                                                                <img height="150" style="max-width: 100%" src="{{ $product_image }}">
                                                            </a>
                                                        @else
                                                            <strong>{{ translate('N/A') }}</strong>
                                                        @endif
                                                    </div>
                                                    <div class="col-3 order-items">
                                                        @if ($orderDetail->product != null)
                                                            <strong><a
                                                                    href="{{ route('product', $orderDetail->product->slug) }}"
                                                                    target="_blank"
                                                                    class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                                            <small style="margin-left: 10px;">{{ $orderDetail->variation }}</small>
                                                        @else
                                                            <strong>{{ translate('Product Unavailable') }}</strong>
                                                        @endif
                                                    </div>
                                                    <div class="col-2 order-items">
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
                                                    </div>
                                                    <div class="col-1 order-items">{{ single_price($orderDetail->price / $orderDetail->quantity) }}</div>
                                                    <div class="col-2 d-flex align-items-center">
                                                        @if ($orderDetail['digital'] != 1)
                                                            <div class="row no-gutters align-items-center aiz-plus-minus"
                                                                style="border:1px solid #9199A4; width: 100px;">
                                                                <button class="btn col-auto btn-icon btn-sm"
                                                                    type="button" data-type="minus"
                                                                    data-field="quantity[{{ $key }}]" >
                                                                    <i class="las la-minus"></i>
                                                                </button>
                                                                @php
                                                                    $cart_sku = null;
                                                                    $pickup_location = "cebu_warehouse";
                                                                    $pickup_location_id = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $pickup_location)))
                                                                        ->first()->id;
                                                                    if ($orderDetail['variation'] != '') {
                                                                        $cart_sku = \App\ProductStock::where('product_id', $orderDetail['product_id'])
                                                                            ->where('variant', $orderDetail['variation'])
                                                                            ->first()->sku;
                                                                    } else {
                                                                        $cart_sku = \App\Product::where('id', $orderDetail['product_id'])
                                                                            ->first()->sku;
                                                                    }
                                                                    $product_advance_order = \App\Product::where('id', $orderDetail['product_id'])
                                                                        ->first()->advance_order;
                                                                    if ($product_advance_order != 1) {
                                                                        $worldcraft_stock_qty = \App\WorldcraftStock::where('sku_id', $cart_sku)
                                                                            ->where('pup_location_id', $pickup_location_id)
                                                                            ->first()->quantity;
                                                                    }else {
                                                                        $worldcraft_stock_qty = \App\WorldcraftStock::where('sku_id', $cart_sku)
                                                                            ->where('pup_location_id', $pickup_location_id)
                                                                            ->first()->quantity;
                                                                        // if ($worldcraft_stock_qty == 0) {
                                                                        //     $worldcraft_stock_qty = 10;
                                                                        // }
                                                                    }
                                                                @endphp
                                                                <input type="text" name="quantity[{{ $key }}]"
                                                                    class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                                                    placeholder="1"
                                                                    value="{{ $orderDetail['quantity'] }}" min="1"
                                                                    max="{{ $worldcraft_stock_qty ?? 10 }}" readonly
                                                                    onchange="updateQuantity({{ $key }}, this, {{ $loop->index }} , {{ $orderDetail->id}} , {{ $orderDetail->price }})">
                                                                <button class="btn col-auto btn-icon btn-sm"
                                                                    type="button" data-type="plus"
                                                                    data-field="quantity[{{ $key }}]">
                                                                    <i class="las la-plus"></i>
                                                                </button>
                                                            
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="col-1 order-items" id="add_price_{{ $orderDetail->id }}">{{ single_price($orderDetail->price) }}</div>
                                                    <button type="submit" class="col-1 order-items c-pointer justify-content-end" style="background-color: #faebd700; border-color: #faebd700;">
                                                        <svg width="14" height="19" viewBox="0 0 14 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.60921 0.833008H8.94254L10.0259 1.91634H13.2759V4.08301H0.275879V1.91634H3.52588L4.60921 0.833008ZM1.35938 15.9996C1.35938 17.1913 2.33438 18.1663 3.52604 18.1663H10.026C11.2177 18.1663 12.1927 17.1913 12.1927 15.9996V5.16626H1.35938V15.9996ZM3.52588 7.33301H10.0259V15.9997H3.52588V7.33301Z" fill="#9199A4"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    @endforeach
                                </div>
                                <!-- End Edit Order Content Body Table -->
                            @endif

                        </div>
                        @php
                            $items = \App\OrderEditDetail::where('order_id', $order->id)
                            ->whereNull('is_deleted')
                            ->get();
                        @endphp
                        @if (count($items))
                            <div class="row" style="margin-top: 50px;">
                                <div class="col-3 offset-lg-7 order-items" style="padding-left: 0px;">
                                    <span class="text-header">{{ translate('Summary') }}</span>
                                </div>
                                <div class="col-2  order-items justify-content-end">
                                    <span class="item-cont">
                                        @if (count($order->orderEditDetails))
                                            {{ count($items) }}
                                            {{ count($items) > 1 ? 'items' : 'item' }}
                                        @else
                                            {{ count($order->orderDetails) }}
                                            {{ count($order->orderDetails) > 1 ? 'items' : 'item'}}
                                        @endif
                                    </span>
                                </div>
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Updated Total') }}</span>
                                </div>
                                <div id="updated_total" class="col-2 order-items summary-items justify-content-end">
                                    {{ single_price($items->sum('price')) }}
                                </div>
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Paid by Customer') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    {{ single_price($total_payment) }}
                                </div>
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Amount to refund') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    {{ $total_payment > $items->sum('price') ?  single_price($total_payment - $items->sum('price')) : single_price(0) }}
                                </div>
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Amount to collect') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    <span class="text-orange">
                                        <strong id="amount_collect">
                                            {{-- {{ $total_payment < $order->orderEditDetails->sum('price') ? single_price($order->orderEditDetails->sum('price') - $total_payment) : single_price(0) }} --}}
                                            {{ $total_payment < $items->sum('price') ? single_price($items->sum('price') - $total_payment) : single_price(0) }}
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="row" style="margin-top: 50px;">
                                <div class="col-3 offset-lg-7 order-items" style="padding-left: 0px;">
                                    <span class="text-header">{{ translate('Summary') }}</span>
                                </div>
                                <div class="col-2  order-items justify-content-end">
                                    <span class="item-cont">
                                        @if (count($order->orderEditDetails))
                                            {{ count($items) }}
                                            {{ count($items) > 1 ? 'items' : 'item' }}
                                        @else
                                            {{ count($order->orderDetails) }}
                                            {{ count($order->orderDetails) > 1 ? 'items' : 'item'}}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Subtotal') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    {{ count($items) ? single_price($items->sum('price')) :  single_price($order->grand_total) }}
                                    {{-- {{ $status_order ? single_price($total_price) : single_price($order->orderDetails->sum('price')) }} --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Paid by Customer') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    {{ single_price($total_payment) }}
                                </div>
                            </div>
                            @if($order->order_status == 'for_collection')
                         
                            <div class="row">
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Amount to collect') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    <span class="text-orange">
                                        <strong id="amount_collect">           
                                          {{ single_price(($order->grand_total) -  $total_payment) }}
                                            <!-- {{ $total_payment < $items->sum('price') ? single_price($items->sum('price') - $total_payment) : single_price(0) }} -->
                                        </strong>
                                    </span>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Tax') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    {{ single_price($order->orderDetails->sum('tax')) }}
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Shipping') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    {{ single_price($order->orderDetails->sum('shipping_cost')) }}
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Coupon') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items justify-content-end">
                                    {{ single_price($order->coupon_discount) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 offset-lg-7 order-items summary-items">
                                    <span class="text-label">{{ translate('Total') }}</span>
                                </div>
                                <div class="col-2 order-items summary-items text-orange justify-content-end" style="font-size: 16px; line-height: 21px;">
                                    {{ count($order->orderEditDetails) ? single_price($order->orderEditDetails->sum('price')) :  single_price($order->grand_total) }}
                                    {{-- <strong>{{ $status_order ? single_price($total_price) : single_price($order->grand_total) }}</strong> --}}
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('walkin.order.update_status') }}" method="POST" id="update_form">
                            @csrf
                            <input type="text" hidden name="order_id" value="{{ $order->id }}">
                            <input type="text" hidden name="order_status">
                            <div style="margin-top: 50px;">
                                <div class="row">
                                    <div class="col-3 offset-6 order-items justify-content-center" style="font-size: 16px;" id="cancel_order">
                                        @if ($order->order_status == 'for_release' && $order->payment_status == 'paid' &&(Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Cashier'))
                                            <span id="cancel_order_btn" class="text-orange c-pointer">{{ translate('Cancel Order') }}</span>
                                        @elseif(($order->order_status == 'for_revision' || $order->order_status == 'refund') && (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Inventory Assistant'))
                                            <span id="decline_request" class="text-orange c-pointer">{{ translate('Decline Request') }}</span>
                                        @elseif($order->order_status == 'for_partial_refund' &&(Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Cashier'))
                                            <span id="for_partial_refund" class="text-primary c-pointer text-center">Partial Refund Done</span>
                                        @endif
                                    </div>
                                    <div class="col-3" style="padding: 0px;" id="paid">
                                        {{-- <button id="btn_paid" class="btn btn-paid" type="submit" @if($order->order_status) disabled @endif href="">{{ $order->order_status == "cancel" ? 'Cancelled' : translate('Mark as Paid') }}</button>                    --}}
                                        @if (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'CMG')
                                            <input type="text" hidden name="order_status" value="released">
                                            <button class="btn btn-paid" type="submit" @if ($order->order_status != "for_release" && $order->order_status != "partial_refund_done") disabled @endif>{{ 'Mark as released' }}</button> 
                                        @elseif(Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Inventory Assistant')
                                            {{-- <input type="text" hidden name="order_status" value="pending"> --}}
                                            <input type="text" hidden name="order_status" value="{{ $order->order_status }}">
                                            <input type="text" hidden name="request_status">
                                            <button id="approve_request" class="btn btn-paid" type="button" @if((!$order->order_status || $order->order_status == 'released' || $order->order_status == 'for_release') || $order->request_status == 'approved') disabled @endif>{{ !$order->order_status ? 'Pending' : 'Approve Request'}} </button>
                                        @elseif(Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Cashier')
                                            <button id="btn_paid" class="btn btn-paid" type="submit" @if($order->payment_status == 'paid') disabled @endif>{{ $order->payment_status == 'paid' ? 'Paid' : translate('Mark as Paid') }}</button>                           
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="d-none col-3 offset-6 order-items justify-content-center" style="font-size: 16px;" id="cancel_edit">
                                        <span class="text-orange c-pointer" href="">{{ translate('Cancel Edit') }}</span>
                                    </div>
                                    
                                    <div class="col-3 d-none" style="padding: 0px;" id="edit_request">
                                        <button class="btn btn-paid" type="button" href="">{{ translate('Send Edit Order Request') }}</button>
                                    </div>
                                </div>
                            </div>  
                        </form>
                    </div>
                    <!-- End Order Details -->

                    <!-- Start treasury & CMS CMG -->
                    <div id="treasury-accounting-content" class="order-details-content py-4 fw-600" style="display: none;">
                        <div class="container">
                            <div class="ml-3">
                                <button type="submit" onclick="add_payment()" class="btn btn-outline-orange d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="icon" d="M9.41406 2.96875H10.5859C10.6901 2.96875 10.7422 3.02083 10.7422 3.125V16.875C10.7422 16.9792 10.6901 17.0312 10.5859 17.0312H9.41406C9.3099 17.0312 9.25781 16.9792 9.25781 16.875V3.125C9.25781 3.02083 9.3099 2.96875 9.41406 2.96875Z" fill="#D73019"/>
                                    <path class="icon" d="M3.4375 9.25781H16.5625C16.6667 9.25781 16.7188 9.3099 16.7188 9.41406V10.5859C16.7188 10.6901 16.6667 10.7422 16.5625 10.7422H3.4375C3.33333 10.7422 3.28125 10.6901 3.28125 10.5859V9.41406C3.28125 9.3099 3.33333 9.25781 3.4375 9.25781Z" fill="#D73019"/>
                                    </svg>
                                    {{ translate('Add Payment') }}
                                </button>
                            </div>
                            
                            <form class="col-9 mt-5" action="{{ route('cashier.cmg.upload') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            @if (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'CMG')
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="" class="control-label">
                                                {{ translate('SOM Number') }}
                                            </label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('som_number') ? 'is-invalid' : '' }}"
                                                name="som_number" value="{{ $order->som_number }}"
                                                />
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
                                                >
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
                                                />
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
                                                >
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
                                                />
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
                                                >
                                            @if ($errors->has('dr_number_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('dr_number_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit m-auto" class="btn btn-orange">
                                    {{ translate('Save') }}
                                    </button>
                                </div>
                            @endif
                            </form>

                            <div class="mt-5 mb-5" style="padding-left: 10px; padding-right: 10px">
                            <h5 class="mb-3">Payment History</h5>     
                                <table class="table table-hover aiz-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>CR Number</th>
                                            <th>Payment Method</th>
                                            <th>Reference Number</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>       
                                        @foreach ($proof_of_payments as $key => $payment_history)
                                        <tr>
                                            <td>{{ $payment_history->created_at }}</td>
                                            <td>{{ $payment_history->cr_number }}</td>
                                            <td>{{ $payment_history->payment_method }}</td>
                                            <td>{{ $payment_history->payment_reference }}</td>
                                            <td>{{ single_price($payment_history->amount) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        
                            <div style="padding-left: 10px; padding-right: 10px">
                                <h5>Logs</h5>
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered aiz-table">
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
                    </div>
                    <!-- End treasury & CMS CMG -->
                    
                    <!-- Start Notes -->
                    <div id="order-notes-content" class="order-details-content py-4" style="display: none;">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="border p-3">
                                    <h6>Latest Customer Note: </h6>
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
                            <div class="col-12 col-lg-12 mt-5">
                                <div class="border p-3">
                                    <h6 class="___class_+?138___">Latest Admin Note: </h6>
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
                            <div class="col-12 col-lg-12 mt-5">
                                <div class="border p-3">
                                    @if (Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
                                        <form class="___class_+?167___" action="{{ route('cashier.order_note.store') }}" method="post">
                                        @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <label for="" class="control-label">{{ translate('Type') }}</label>
                                            <div>
                                                <select class="form-control aiz-selectpicker {{ $errors->has('type') ? 'is-invalid' : '' }} mb-2 mb-md-0" name="type">
                                                    <option selected>{{ translate('Select Note Type') }}</option>
                                                    <option value="admin">{{ translate('Admin') }}</option>
                                                    <option value="customer">{{ translate('Customer') }}</option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('type') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <label for="" class="control-label mt-2">{{ translate('Message') }}</label>
                                            
                                            <div>
                                                <textarea name="message" class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" id="" cols="85" rows="10"></textarea>
                                                @if ($errors->has('message'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('message') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-orange" style="margin-top: 10px;">
                                                    {{ translate('Save') }}
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Notes -->
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <!-- Start Admin Note -->
            <div class="card">
                <div class="card-body">
                    <div class="fw-500 fs-16">Latest Admin Note</div>
                    <hr>
                    @if (count($notes_for_admin) != 0)
                        @foreach ($notes_for_admin as $key => $note)
                            <div class="row">
                                <div class="col-12">
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
            </div>
            <!-- End Admin Note -->   

            <!-- Start Customer Note -->                                 
            <div class="card">
                <div class="card-body">
                    <div class="fw-500 fs-16">Latest Customer Note</div>
                    <hr>
                    @if (count($notes_for_customer) != 0)
                        @foreach ($notes_for_customer as $key => $note)
                            <div class="row">
                                <div class="col-12">
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
            </div>
            <!-- End Customer Note --> 

            <!-- Start Type Note Into Customer & Admin -->     
            <div class="card">
                <div class="card-body">
                    <div class="fw-500 fs-16">Notes:</div>
                    <hr>
                    @if (Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
                        <form class="___class_+?167___" action="{{ route('cashier.order_note.store') }}" method="post">
                        @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <label for="" class="control-label">{{ translate('Type') }}</label>
                            <div>
                                <select class="form-control aiz-selectpicker {{ $errors->has('type') ? 'is-invalid' : '' }} mb-2 mb-md-0" name="type">
                                    <option selected>{{ translate('Select Note Type') }}</option>
                                    <option value="admin">{{ translate('Admin') }}</option>
                                    <option value="customer">{{ translate('Customer') }}</option>
                                </select>
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('type') }}
                                    </span>
                                @endif
                            </div>

                            <label for="" class="control-label mt-2">{{ translate('Message') }}</label>
                            
                            <div>
                                <textarea name="message" class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" id="" cols="85" rows="5"></textarea>
                                @if ($errors->has('message'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('message') }}
                                    </span>
                                @endif
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-orange" style="margin-top: 10px;">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            <!-- End Type Note Into Customer & Admin -->   
        </div>
    </div>
@endsection

<!-- start add payment modal -->
<div class="modal fade" id="add-payment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
  
            <div class="p-4">
            @if (Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
              <form action="{{ route('cashier.order_cr_number.upload') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                <div class="row">
                  <div class="col-6">
                    <label for="" class="control-label">
                        {{ translate('CR Number') }}
                    </label>
                    <input name="cr_number"
                        class="form-control {{ $errors->has('cr_number') ? 'is-invalid' : '' }}"
                        value="{{ $order->cr_number }}" id=""/>
                    @if ($errors->has('cr_number'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('cr_number') }}
                        </span>
                    @endif
                  </div>
                  <div class="col-6">
                    <label for="" class="control-label">
                          {{ translate('Amount') }}
                    </label>
                    <input name="amount" value="{{ $order->amount }}" class="form-control"/>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-6">
                    <label for="" class="control-label fw-500 fs-14">{{ translate('Payment Method') }}</label>
                    <select class="form-control" name="payment_method" id="payment_method" style="height: 42px; border-color: #e1e5e9; border-radius: 4px;">
                    @php
                        $other_payment_methods = \App\OtherPaymentMethod::where('is_walkin', 1)->get();
                    @endphp
                    @foreach($other_payment_methods as $payment_method)
                        <option value="{{$payment_method->name}}">{{$payment_method->name}}</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="col-6">
                    <label for="" class="control-label fw-500 fs-14">{{ translate('Reference Number') }}</label>
                    <input name="payment_reference"value="{{ $order->payment_reference }}"  class="form-control" />
                  </div>
                </div>
    
                <div class="d-flex justify-content-end mt-3">
                  <a href="" class="text-orange mr-3 fs-14 fw-500 d-flex align-items-center" style="margin-top: 10px;">
                    {{ translate('Cancel') }}
                  </a>
                  <button type="submit" class="btn btn-orange" style="margin-top: 10px;">
                    {{ translate('Confirm') }}
                  </button>
                </div>
              </form>
              @endif
            </div>
        </div>
    </div>
</div>
<!-- end add payment modal -->

<div id="myModal" class="modal">
    <div class="container">
        <div class="close-modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>
    </div>
</div>

<!-- start cancel order modal -->
<div class="modal fade" id="cancel_order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border: none; min-height: 20px; ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cancel">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if($status_order)
                <span class="text-header pl-20px">Edit Order</span>
            @else
                <span class="text-header pl-20px">Cancel Order</span>
            @endif
            <form action="{{ route('walkin.order.update_status') }}" method="POST">
                @csrf
                <input type="text" hidden name="order_id" value="{{ $order->id }}">
                <input type="text" hidden name="order_status">
                <div class="p-20px d-flex flex-column" style="row-gap: 10px;">
                    <span class="text-gray text-label">Reason for cancellation</span>
                    <div class="radio mar-btm d-flex align-items-center" style="column-gap: 10px;">
                        <input class="magic-radio" type="radio" name="reason_type" value="item_is_defective">
                        <label for="product-shipping" style="margin-bottom: 0px;">
                            <span>{{translate('Item is defective')}}</span>
                        </label>
                    </div>
                    <div class="radio mar-btm d-flex align-items-center" style="column-gap: 10px;">
                        <input class="magic-radio" type="radio" name="reason_type" value="item_has_no_stock">
                        <label for="product-shipping" style="margin-bottom: 0px;">
                            <span>{{translate('Item has no stock')}}</span>
                        </label>
                    </div>
                    <div class="radio mar-btm d-flex align-items-center" style="column-gap: 10px;">
                        <input id="others" class="magic-radio" type="radio" name="reason_type" value="others">
                        <label for="product-shipping" style="margin-bottom: 0px;">
                            <span>{{translate('Others')}}</span>
                        </label>
                    </div>
                    <textarea id="reason_field" class="d-none" type="textarea" name="reason_field" style="height: 150px;"></textarea>
                    <div class="d-flex align-items-center justify-content-center" style="column-gap: 15px; margin-top: 15px;">
                        <button data-dismiss="modal" type="button" class="btn btn-gray">Cancel</button>
                        <button type="submit" class="btn btn-orange">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end cancel order modal -->


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

        $("#cancel_order_btn").on("click", function(){
            $('input[name=order_status]').val('cancel');
            $('#cancel_order_modal').modal('show');
        });

        $("#edit_request").on("click", function(){
            $('input[name=order_status]').val('for_revision');
            $('#cancel_order_modal').modal('show');
        });

        $("#decline_request").on("click", function(){
            $('input[name=request_status]').val('declined');
            $('#update_form').submit();
        });

        $("#for_partial_refund").on("click", function(){
            $('input[name=order_status]').val('for_partial_refund');
            $('input[name=request_status]').val('for_release');
            $('#update_form').submit();
        });


        $("#approve_request").on("click", function(){
            $('input[name=request_status]').val('approved');
            $('#update_form').submit();
        });

        $("#btn_paid").on("click", function(){
            $('input[name=order_status]').val('for_release');
            $('update_form').submit();
        });



        $('input[type=radio][name=reason_type]').change(function() {
            if(this.value == "others"){
                $('#reason_field').removeClass('d-none');
                $('#reason_field').addClass('d-flex');
            }else{
                $('#reason_field').removeClass('d-flex');
                $('#reason_field').addClass('d-none');
            }
        });
        

        $(document).ready(function() {
            @if ($order->orderDetails->first()->delivery_status == 'partial_release')
                $('#partial_release_header').show();
                $('.partial_released_body').show();
            @else
                $('#partial_release_header').hide();
                $('.partial_released_body').hide();
            @endif

            @if (Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
                $('#order-details').removeClass('order-tab-active');
                $('#notes').removeClass('order-tab-active');
                $('#treasury-accounting').addClass('order-tab-active');
            
                $('#order-details-content').toggle(false)
                $('#treasury-accounting-content').toggle(true)
                $('#order-notes-content').toggle(false);
            @endif
            var status_order = '{{ $status_order }}';
            if(status_order){
                toggleOrder('order-details');
                editDetailsView();
            }   
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
                console.log('asasasa');
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

        function add_payment(){
          $('#add-payment-modal').modal('show');
        }

        /* Edit Order */
        $("#edit_order").on("click", function(){
            var data = {
                "_token": "{{ csrf_token() }}",
                'order_id': $('#order_id').val(),
            };
            $.ajax({
                type:"POST",
                url: '{{ route('cashier.order.copy') }}',
                data: data,
                success: function(data){
                    console.log('dataaa', data);
                    if(data.success){ 
                        window.location.href = data.url;
                    }
                }
            });
            // $("#edit_order_form").removeClass('d-none');
            // $("#cancel_edit").removeClass('d-none');
            // $("#cancel_order").addClass('d-none');
            // $("#cancel_order").removeClass('d-flex');
            // $("#edit_order").addClass('d-none');
            // $("#edit_order").removeClass('d-flex');
            // $("#table_head").addClass('d-none');
            // $("#edit_table_head").removeClass('d-none');
            // $("#table_content").addClass('d-none');
            // $("#edit_table_content").removeClass('d-none');
            // $("#paid").addClass('d-none');
            // $("#edit_request").removeClass('d-none');
        });

        $("#cancel_edit").on("click", function(){
            var data = {
                "_token": "{{ csrf_token() }}",
                'order_id': $('#order_id').val(),
            };
            console.log('wqwqwqw', order_id);
            $.ajax({
                type:"POST",
                url: '{{ route('cashier.cart.canceleditOrder') }}',
                data: data,
                success: function(data){
                    console.log('dataaa', data);
                    if(data.success){ 
                        window.location.href = data.url;
                    }
                }
            });

            // $("#edit_order_form").addClass('d-none');
            // $("#cancel_edit").addClass('d-none');
            // $("#cancel_order").removeClass('d-none');
            // $("#cancel_order").addClass('d-flex');
            // $("#edit_order").removeClass('d-none');
            // $("#edit_order").addClass('d-flex');
            // $("#table_head").removeClass('d-none');
            // $("#edit_table_head").addClass('d-none');
            // $("#table_content").removeClass('d-none');
            // $("#edit_table_content").addClass('d-none');
            // $("#paid").removeClass('d-none');
            // $("#edit_request").addClass('d-none');
        });

        function editDetailsView(){
            $("#edit_order_form").removeClass('d-none');
            $("#cancel_edit").removeClass('d-none');
            $("#cancel_order").addClass('d-none');
            $("#cancel_order").removeClass('d-flex');
            $("#edit_order").addClass('d-none');
            $("#edit_order").removeClass('d-flex');
            $("#table_head").addClass('d-none');
            $("#edit_table_head").removeClass('d-none');
            $("#table_content").addClass('d-none');
            $("#edit_table_content").removeClass('d-none');
            $("#paid").addClass('d-none');
            $("#edit_request").removeClass('d-none'); 
        }

        function updateQuantity(key, element, index, id, price) {
            var data = [];
            data.push(
                {
                    'name': '_token',
                    'value': "{{ csrf_token() }}",
                },
                {
                    'name': 'key',
                    'value': key,
                },
                {
                    'name': 'quantity',
                    'value': element.value,
                },
                
                {
                    'name': 'id',
                    'value': id,
                },
                {
                    'name': 'price',
                    'value': price,
                },
            )
          
            $.ajax({
                type:"POST",
                url: '{{ route('cashier.cart.updateQuantity') }}',
                data: data,
                success: function(data){  
                    document.getElementById('add_price_'+id).innerHTML  = '₱' + data.new_price.toFixed(2) ;

                    // Start Updated Total
                    updated_total_str = document.getElementById('updated_total').innerHTML;
                    let updated_total_value = updated_total_str.replace("₱", "");
                    updated_total_value = parseFloat(updated_total_value.replace(",", ""));
                    var new_updated_total = 0;
                    if(data.is_add){
                        new_updated_total = updated_total_value + price;
                    }else{
                        new_updated_total = updated_total_value - price;
                    }
                    document.getElementById('updated_total').innerHTML  = '₱' + new_updated_total.toFixed(2) ;
                    // End Updated Total

                    // Start Amount Collect
                    updated_amount_collect_str = document.getElementById('amount_collect').innerHTML;
                    let updated_amount_collect_value = updated_amount_collect_str.replace("₱", "");
                    updated_amount_collect_value = parseFloat(updated_amount_collect_value.replace(",", ""));
                    var new_updated_amount_collect = 0;
                    if(data.is_add){
                        new_updated_amount_collect = updated_amount_collect_value + price;
                    }else{
                        new_updated_amount_collect = updated_amount_collect_value - price;
                    }
                    document.getElementById('amount_collect').innerHTML  = '₱' + new_updated_amount_collect.toFixed(2) ;
                    // End Amount Collect
                  
                }
            });
        }

        /* Search item */
        $('#search').on('keyup', function(){
            search();
        });

        $('#search').on('focus', function(){
            search();
        });

        function search(){
            var searchKey = $('#search').val();
            var searchOrderId = $('#search_order_id').val();
            var pickupLocation = $('#location').val();
            
            
            if(searchKey.length > 0){
                $('body').addClass("typed-search-box-shown");

                $('.typed-search-box').removeClass('d-none');
                $('.search-preloader').removeClass('d-none');
                $.post('{{ route('search.ajax') }}', { _token: AIZ.data.csrf, search:searchKey, searchOrderId:searchOrderId, pickupLocation:pickupLocation }, function(data){
                    if(data == '0'){
                        // $('.typed-search-box').addClass('d-none');
                        $('#search-content').html(null);
                        $('.typed-search-box .search-nothing').removeClass('d-none').html('Sorry, nothing found for <strong>"'+searchKey+'"</strong>');
                        $('.search-preloader').addClass('d-none');

                    }
                    else{
                        $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                        $('#search-content').html(data);
                        $('.search-preloader').addClass('d-none');
                    }
                });
            }
            else {
                $('.typed-search-box').addClass('d-none');
                $('body').removeClass("typed-search-box-shown");
            }
        }

    </script>
@endsection



