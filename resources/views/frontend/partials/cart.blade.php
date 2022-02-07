
@php
  $walkin = strpos(Route::currentRouteName(), "walkin");
@endphp
<div class="nav-icons">
    <a href="javascript:void(0)" class="d-flex align-items-center text-reset h-100" data-toggle="dropdown" data-display="static">
        <i class="la la-shopping-cart la-2x icon-style"></i>
            @if (Auth::check())
                @if(Session::has('cart'))
                    <span class="badge badge-primary badge-inline badge-pill ml--1">{{ count(Session::get('cart'))}}</span>
                @else
                    <span class="badge badge-primary badge-inline badge-pill ml--1">0</span>
                @endif
            @endif
        <span class="nav-box-text d-none d-xl-block opacity-70 d-lg-inline-block ml-2 order-details-title fw-500">
            {{translate('Cart')}}
        </span>   
    </a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg p-0 stop-propagation">
    <div class="p-3 fs-15 fw-600 p-3 text-title-thin">
        {{translate('Cart Items')}}
    </div>
    <div class="container border-bottom container-cart"></div>
    @if(Session::has('cart'))
        @if(count($cart = Session::get('cart')) > 0)
            <ul class="h-250px overflow-auto c-scrollbar-light list-group list-group-flush">
                @php
                    $total = 0;
                @endphp
                @foreach($cart as $key => $cartItem)
                    @php
                        $product = \App\Product::find($cartItem['id']);
                        $total = $total + ($cartItem['price']+$cartItem['tax'])*$cartItem['quantity'];
                    @endphp
                    @if ($product != null)
                        <li class="list-group-item">
                            <span class="d-flex align-items-center">
                                <a href="@if($walkin) {{ route('product', $product->slug) }} @else {{ route('walkin.product.details', $product->slug) }} @endif" class="text-reset d-flex align-items-center flex-grow-1">
                                    @php
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
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ $product_image }}"
                                        class="img-fit lazyload size-60px rounded"
                                        alt="{{  $product->getTranslation('name')  }}"
                                    >
                                    <span class="minw-0 pl-2 flex-grow-1">
                                        <span class="fw-600 mb-1 text-truncate-2 text-paragraph-bold">
                                                {{  $product->getTranslation('name')  }}
                                        </span>
                                        <span class="mr-2 opacity-60 text-paragraph-thin">{{ $cartItem['quantity'] }}x</span>
                                        <span class="opacity-60 text-paragraph-thin">{{ single_price($cartItem['price']+$cartItem['tax']) }}</span>
                                    </span>
                                </a>
                                <span class="">
                                    <button onclick="removeFromCart({{ $key }})" class="btn btn-sm btn-icon stop-propagation">
                                        <i class="la la-close"></i>
                                    </button>
                                </span>
                            </span>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="px-3 py-3 fs-15 border-top d-flex justify-content-between">
                <span class="opacity-60 text-paragraph-thin">{{translate('Subtotal')}}</span>
                <span class="fw-600 header-subtitle-red">{{ single_price($total) }}</span>
            </div>
            <div class="px-3 py-2 text-center border-top">
                <ul class="list-inline mb-2 mt-2">
                    <li class="list-inline-item">
                       @if($walkin === false)                 
                          <a href="{{ route('cart') }}" class="btn btn-soft-primary btn-craft-primary-nopadding text-subprimary fw-500">
                              <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M4.12492 15.5833V11.9167H16.1974L12.9158 15.2075L14.2083 16.5L19.7083 11L14.2083 5.5L12.9158 6.7925L16.1974 10.0833H2.29159V15.5833H4.12492Z" fill="white"/>
                                  </svg>
                                  {{translate('Proceed to Checkout')}}
                          </a>
                        @else
                          <!-- // walkin -->
                          <a href="{{ route('walkin.cart') }}" class="btn btn-soft-primary btn-craft-primary-nopadding text-subprimary fw-500">
                              <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M4.12492 15.5833V11.9167H16.1974L12.9158 15.2075L14.2083 16.5L19.7083 11L14.2083 5.5L12.9158 6.7925L16.1974 10.0833H2.29159V15.5833H4.12492Z" fill="white"/>
                                  </svg>
                                  {{translate('Proceed to Checkout')}}
                          </a>
                        @endif
                    </li>
                    {{-- @if (Auth::check())
                    <li class="list-inline-item">
                        <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary btn-sm">
                            {{translate('Checkout')}}
                        </a>
                    </li>
                    @endif --}}
                </ul>
            </div>
        @else
            <div class="d-flex justify-content-center align-items-center cart-craft-height">
                <div class="text-center">
                    <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M33.5425 29.6028L35.7565 45.0589H40.0771L42.2912 29.6028H33.5425Z" fill="#FFCFD1"/>
                    <path d="M48.2033 29.6028L45.9893 45.0589H51.7081L55.184 29.6028H48.2033Z" fill="#FFCFD1"/>
                    <path d="M27.6291 29.6028H20.6484L23.7701 45.0589H29.8431L27.6291 29.6028Z" fill="#FFCFD1"/>
                    <path d="M62.2664 23.6309C62.0252 23.3464 61.6711 23.1824 61.298 23.1824H14.8028L13.2309 15.3995C13.1113 14.8073 12.5908 14.3813 11.9865 14.3813H3.70117C3.00014 14.3813 2.43164 14.9497 2.43164 15.6509C2.43164 16.352 3.00014 16.9204 3.70117 16.9204H10.9477L18.6636 55.1229C17.4738 56.1551 16.72 57.6785 16.72 59.3747C16.72 62.4765 19.2405 65 22.3387 65C25.4368 65 27.9573 62.4765 27.9573 59.3747C27.9573 58.2359 27.6176 57.1751 27.0343 56.2884H44.638C44.0546 57.1751 43.7149 58.2359 43.7149 59.3747C43.7149 62.4765 46.2354 65 49.3336 65C52.4317 65 54.9523 62.4765 54.9523 59.3747C54.9523 58.2185 54.602 57.1427 54.0022 56.2479C54.5487 56.1063 54.9523 55.6098 54.9523 55.0189C54.9523 54.3178 54.3839 53.7494 53.6827 53.7494H20.9766L20.518 51.4793H52.7128C55.8364 51.4793 58.4745 49.2427 58.9853 46.1611L62.5503 24.6595C62.6115 24.2916 62.5075 23.9154 62.2664 23.6309ZM25.4184 59.3747C25.4184 61.0765 24.0369 62.4609 22.3388 62.4609C20.6407 62.4609 19.2591 61.0765 19.2591 59.3747C19.2591 57.6729 20.6407 56.2884 22.3388 56.2884C24.0369 56.2884 25.4184 57.6729 25.4184 59.3747ZM49.3337 62.4609C47.6356 62.4609 46.2541 61.0765 46.2541 59.3747C46.2541 57.6729 47.6356 56.2884 49.3337 56.2884C51.0318 56.2884 52.4133 57.6729 52.4133 59.3747C52.4132 61.0765 51.0318 62.4609 49.3337 62.4609ZM56.4807 45.7459C56.1738 47.5969 54.5893 48.9403 52.7129 48.9403H20.0053L15.3156 25.7214H59.8006L56.4807 45.7459Z" fill="#1B1464"/>
                    <path d="M37.9169 19.411C43.2685 19.411 47.6224 15.0571 47.6224 9.70544C47.6224 4.35373 43.2685 0 37.9169 0C32.5653 0 28.2114 4.35386 28.2114 9.70544C28.2114 15.057 32.5653 19.411 37.9169 19.411ZM37.9169 2.53906C41.8685 2.53906 45.0834 5.7539 45.0834 9.70544C45.0834 13.657 41.8685 16.8719 37.9169 16.8719C33.9653 16.8719 30.7505 13.6571 30.7505 9.70544C30.7505 5.7539 33.9653 2.53906 37.9169 2.53906Z" fill="#1B1464"/>
                    <path d="M36.6982 12.7246C36.938 12.974 37.2685 13.1143 37.6133 13.1143C37.6271 13.1143 37.6412 13.114 37.6551 13.1136C38.0148 13.1017 38.3525 12.9378 38.5843 12.6624L42.1869 8.38411C42.6386 7.84773 42.5699 7.04691 42.0335 6.59534C41.4973 6.14377 40.6963 6.21232 40.2446 6.7487L37.5505 9.94804L36.0972 8.43654C35.6113 7.93114 34.8075 7.91553 34.3022 8.40138C33.7968 8.88735 33.7811 9.69109 34.267 10.1965L36.6982 12.7246Z" fill="#1B1464"/>
                    </svg>

                    <h3 class="cart-craft-text mb-0 mt-3">{{translate('Your Cart is empty')}}</h3>
                </div>
            </div>
        @endif
    @else
        <div class="d-flex justify-content-center align-items-center cart-craft-height">
            <div class="text-center">
                <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M33.5425 29.6028L35.7565 45.0589H40.0771L42.2912 29.6028H33.5425Z" fill="#FFCFD1"/>
                <path d="M48.2033 29.6028L45.9893 45.0589H51.7081L55.184 29.6028H48.2033Z" fill="#FFCFD1"/>
                <path d="M27.6291 29.6028H20.6484L23.7701 45.0589H29.8431L27.6291 29.6028Z" fill="#FFCFD1"/>
                <path d="M62.2664 23.6309C62.0252 23.3464 61.6711 23.1824 61.298 23.1824H14.8028L13.2309 15.3995C13.1113 14.8073 12.5908 14.3813 11.9865 14.3813H3.70117C3.00014 14.3813 2.43164 14.9497 2.43164 15.6509C2.43164 16.352 3.00014 16.9204 3.70117 16.9204H10.9477L18.6636 55.1229C17.4738 56.1551 16.72 57.6785 16.72 59.3747C16.72 62.4765 19.2405 65 22.3387 65C25.4368 65 27.9573 62.4765 27.9573 59.3747C27.9573 58.2359 27.6176 57.1751 27.0343 56.2884H44.638C44.0546 57.1751 43.7149 58.2359 43.7149 59.3747C43.7149 62.4765 46.2354 65 49.3336 65C52.4317 65 54.9523 62.4765 54.9523 59.3747C54.9523 58.2185 54.602 57.1427 54.0022 56.2479C54.5487 56.1063 54.9523 55.6098 54.9523 55.0189C54.9523 54.3178 54.3839 53.7494 53.6827 53.7494H20.9766L20.518 51.4793H52.7128C55.8364 51.4793 58.4745 49.2427 58.9853 46.1611L62.5503 24.6595C62.6115 24.2916 62.5075 23.9154 62.2664 23.6309ZM25.4184 59.3747C25.4184 61.0765 24.0369 62.4609 22.3388 62.4609C20.6407 62.4609 19.2591 61.0765 19.2591 59.3747C19.2591 57.6729 20.6407 56.2884 22.3388 56.2884C24.0369 56.2884 25.4184 57.6729 25.4184 59.3747ZM49.3337 62.4609C47.6356 62.4609 46.2541 61.0765 46.2541 59.3747C46.2541 57.6729 47.6356 56.2884 49.3337 56.2884C51.0318 56.2884 52.4133 57.6729 52.4133 59.3747C52.4132 61.0765 51.0318 62.4609 49.3337 62.4609ZM56.4807 45.7459C56.1738 47.5969 54.5893 48.9403 52.7129 48.9403H20.0053L15.3156 25.7214H59.8006L56.4807 45.7459Z" fill="#1B1464"/>
                <path d="M37.9169 19.411C43.2685 19.411 47.6224 15.0571 47.6224 9.70544C47.6224 4.35373 43.2685 0 37.9169 0C32.5653 0 28.2114 4.35386 28.2114 9.70544C28.2114 15.057 32.5653 19.411 37.9169 19.411ZM37.9169 2.53906C41.8685 2.53906 45.0834 5.7539 45.0834 9.70544C45.0834 13.657 41.8685 16.8719 37.9169 16.8719C33.9653 16.8719 30.7505 13.6571 30.7505 9.70544C30.7505 5.7539 33.9653 2.53906 37.9169 2.53906Z" fill="#1B1464"/>
                <path d="M36.6982 12.7246C36.938 12.974 37.2685 13.1143 37.6133 13.1143C37.6271 13.1143 37.6412 13.114 37.6551 13.1136C38.0148 13.1017 38.3525 12.9378 38.5843 12.6624L42.1869 8.38411C42.6386 7.84773 42.5699 7.04691 42.0335 6.59534C41.4973 6.14377 40.6963 6.21232 40.2446 6.7487L37.5505 9.94804L36.0972 8.43654C35.6113 7.93114 34.8075 7.91553 34.3022 8.40138C33.7968 8.88735 33.7811 9.69109 34.267 10.1965L36.6982 12.7246Z" fill="#1B1464"/>
                </svg>

                <h3 class="cart-craft-text mb-0 mt-3">{{translate('Your Cart is empty')}}</h3>
            </div>
        </div>
    @endif
</div>
</div>
