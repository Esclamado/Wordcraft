@extends('frontend.layouts.app')

@section('content')
    <section class="py-5 lightblue-bg">
        <div class="container">
            <div class="position-absolute">
                <div class="img-44"></div>
                <div class="img-46"></div>
            </div>
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="page-title">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-6">
                                <span class="heading heading-6 text-capitalize fw-600 mb-0 text-paragraph-title">
                                    {{ translate('Declined Orders') }}
                                </span>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="float-lg-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}" class="text-breadcrumb text-secondary-color opacity-50">{{ translate('Home') }}</a>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z" fill="#8D8A8A"/>
                                            </svg>
                                        </li>
                                        <li><a href="{{ route('dashboard') }}" class="text-breadcrumb text-secondary-color opacity-50">{{ translate('Dashboard') }}</a>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.66137 3.5L4.83887 4.3225L7.51053 7L4.83887 9.6775L5.66137 10.5L9.16137 7L5.66137 3.5Z" fill="#8D8A8A"/>
                                            </svg>
                                        </li>
                                        <li class="active"><a href="{{ route('declined_orders.index') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('My Purchase History') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (count($declined_orders) != 0)
                        @foreach ($declined_orders as $key => $order)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="customer-craft-dashboard-card-title mb-0 col-6"> 
                                        Order Code: <span style="color: #161DBC;">{{ $order->order_code ?? "N/A" }}</span>
                                    </div>
                                </div>
                                <hr>
                                @foreach ($order->order_declined_details as $key => $orderDetail)
                                    @php
                                        $status = $orderDetail->delivery_status ?? "N/A";
                                    @endphp

                                    <div class="row mb-3">
                                        <div class="col-3 col-lg-1">
                                            @php
                                                $product_image = null;

                                                if ($orderDetail->product != null) {
                                                    if ($orderDetail->variation != "") {
                                                        $product_image = \App\ProductStock::where('product_id', $orderDetail->product_id)
                                                            ->where('variant', $orderDetail->variation)
                                                            ->first()->image;

                                                        if ($product_image != null) {
                                                            $product_image = uploaded_asset($product_image);
                                                        }

                                                        else {
                                                            $product_image = uploaded_asset($orderDetail->product->thumbnail_img);
                                                        }
                                                    }

                                                    else {
                                                        $product_image = uploaded_asset($orderDetail->product->thumbnail_img);
                                                    }
                                                }
                                            @endphp
                                            <img
                                                class="img-fluid lazyload craft-purchase-history-image"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ $product_image }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                            >
                                        </div>
                                        <div class="col-9 col-lg-4">
                                            <div class="d-flex align-items-center h-100 craft-purchase-history-name">
                                                @if ($orderDetail->product != null)
                                                    <a href="{{ route('product', $orderDetail->product->slug ?? "N/A") }}" target="_blank">
                                                        {{ $orderDetail->product->getTranslation('name') ?? "N/A"}} - {{ $orderDetail->variation }}

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
                                                    </a>
                                                @else
                                                    <strong>{{  translate('Product Unavailable') }}</strong>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-2 d-flex align-items-center justify-content-end">
                                            <div class="craft-purchase-history-quantity">
                                                <span class="opacity-50">Qty: </span><span style="color: #31303E">{{ $orderDetail->quantity ?? "N/A" }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-5 d-flex align-items-center justify-content-end">
                                            <div class="craft-purchase-history-price">
                                                {{ single_price($orderDetail->price ?? "N/A") }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div class="align-items-start">
                                        <span class="purchase-history-total-label mr-2">Reason: </span>
                                        <span>{{ $order->reason ?? "N/A" }}</span>
                                    </div>
                                    <div class="align-items-end">
                                        <div class="d-flex align-items-center">
                                            <div class="purchase-history-total-label">
                                                Total:
                                            </div>
                                            <div class="purchase-history-total-price">
                                                {{ single_price($order->grand_total ?? "N/A") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                            <div class="text-center">
                                <svg width="74" height="74" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                <path d="M37.4995 65.6581H8.24084C5.89871 65.6581 4 63.7594 4 61.4173V24H37.4995V65.6581Z" fill="#FFCFD1"/>
                                <path d="M62.234 72.3395L60.1127 69.6329C59.9736 69.4554 59.7048 69.4554 59.5658 69.6329L57.0969 72.7828C56.9579 72.9603 56.6892 72.9603 56.55 72.7828L54.0808 69.6327C53.9418 69.4552 53.6731 69.4552 53.5339 69.6327L51.0646 72.7828C50.9256 72.9603 50.6569 72.9603 50.5177 72.7828L48.0482 69.6327C47.9092 69.4552 47.6405 69.4552 47.5013 69.6327L45.032 72.7829C44.893 72.9604 44.6243 72.9604 44.4851 72.7829L42.0153 69.6327C41.8763 69.4552 41.6076 69.4552 41.4684 69.6327L39.3461 72.3398C39.1425 72.5997 38.7252 72.4556 38.7252 72.1255V46.2016L34.8047 34.4603H41.5127H58.9342C61.0994 34.4603 62.8547 36.2157 62.8547 38.3809V72.1252C62.8549 72.4554 62.4376 72.5994 62.234 72.3395Z" fill="#F9F6F9"/>
                                <path d="M58.9337 34.4603H56.0918C58.257 34.4603 60.0124 36.2157 60.0124 38.3809V69.5486C60.0492 69.57 60.0838 69.5969 60.1119 69.6329L62.2332 72.3395C62.4369 72.5994 62.8541 72.4553 62.8541 72.1252V38.3809C62.8543 36.2155 61.0989 34.4603 58.9337 34.4603Z" fill="#DDDAEC"/>
                                <path d="M38.7249 50.1355H31.4635C31.1434 50.1355 30.8838 49.8759 30.8838 49.5557V38.3809C30.8838 36.2157 32.6391 34.4603 34.8043 34.4603C36.9696 34.4603 38.7249 36.2157 38.7249 38.3809V50.1355Z" fill="#D0CEE7"/>
                                <path d="M34.8044 34.4603C34.3187 34.4603 33.8541 34.5492 33.4248 34.7107C34.9093 35.269 35.9658 36.7013 35.9658 38.3809V50.1355H38.7249V38.3809C38.7249 36.2155 36.9696 34.4603 34.8044 34.4603Z" fill="#BEB9DD"/>
                                <path d="M58.9338 33.3763H54.5085V26.1C54.5085 25.5012 54.0233 25.016 53.4245 25.016C52.8258 25.016 52.3406 25.5012 52.3406 26.1V33.3763H45.7278V17.4571H52.3406V28C52.3406 28.5988 52.8258 29.084 53.4245 29.084C54.0233 29.084 54.5085 28.5988 54.5085 28V16.3731C54.5085 15.7743 54.0233 15.2891 53.4245 15.2891H50.1181V10.9941C50.1181 5.54697 45.6866 1.11549 40.2395 1.11549C38.2121 1.11549 36.3258 1.73018 34.7559 2.78194C32.9774 1.06173 30.5581 0 27.8941 0C22.447 0 18.0155 4.43147 18.0155 9.87857V15.2892H11.1445C10.5459 15.2892 10.0605 15.7744 10.0605 16.3732V33.5C10.0605 34.0988 10.5459 34.584 11.1445 34.584C11.7432 34.584 12.2285 34.0988 12.2285 33.5V17.4572H18.0157V21.2295C18.0157 21.8283 18.501 22.3135 19.0997 22.3135C19.6983 22.3135 20.1837 21.8283 20.1837 21.2295V17.4572H35.6049V21.2295C35.6049 21.8283 36.0902 22.3135 36.6888 22.3135C37.2875 22.3135 37.7728 21.8283 37.7728 21.2295V17.4572H43.56V33.3765H34.8043C32.0448 33.3765 29.7998 35.6215 29.7998 38.381V49.5559C29.7998 50.4732 30.5461 51.2196 31.4635 51.2196H37.641V56.9473H15.3854C13.6448 56.9473 12.2285 55.5312 12.2285 53.7905V30.6197C12.2285 30.0209 11.7432 29.5357 11.1445 29.5357C10.5459 29.5357 10.0605 30.0209 10.0605 30.6197V53.7902C10.0605 56.7262 12.4492 59.115 15.3854 59.115H37.6409V60.396C37.6409 60.9948 38.1261 61.48 38.7248 61.48C39.3236 61.48 39.8088 60.9948 39.8088 60.396V38.3808C39.8088 37.3282 39.4815 36.3511 38.9242 35.5443H58.9338C60.4979 35.5443 61.7704 36.8167 61.7704 38.3808V69.9914L60.9656 68.9647C60.6924 68.6159 60.2818 68.4159 59.8387 68.4159C59.3956 68.4159 58.985 68.6159 58.7121 68.9642L56.8229 71.3747L54.9335 68.9642C54.6603 68.6158 54.2498 68.4157 53.8068 68.4157C53.3638 68.4157 52.9534 68.6158 52.6804 68.9641L50.7906 71.3749L48.9009 68.9638C48.6276 68.6155 48.2172 68.4157 47.7745 68.4157C47.3318 68.4157 46.9214 68.6155 46.6479 68.9641L44.7582 71.3749L42.868 68.9638C42.5947 68.6155 42.1844 68.4157 41.7417 68.4157C41.2991 68.4159 40.8881 68.6158 40.6152 68.964L39.809 69.9923V59.5C39.809 58.9012 39.3238 58.416 38.725 58.416C38.1262 58.416 37.641 58.9012 37.641 59.5V72.1256C37.641 72.7358 38.0286 73.2794 38.6053 73.4785C39.1829 73.6778 39.8227 73.4888 40.1989 73.0087L41.7417 71.041L43.6318 73.4521C43.9051 73.8004 44.3156 74.0001 44.7582 74.0001C45.2009 74.0001 45.6113 73.8004 45.8848 73.4518L47.7744 71.041L49.6643 73.4521C49.9376 73.8004 50.3479 74.0001 50.7908 74.0001C51.2333 74.0001 51.6438 73.8004 51.9172 73.4518L53.8068 71.0412L55.6963 73.4516C55.9696 73.8001 56.3801 74 56.8229 74C57.2658 74 57.6764 73.8001 57.9497 73.4516L59.8387 71.0413L61.3804 73.0082C61.7568 73.4884 62.3972 73.677 62.974 73.4782C63.5507 73.2791 63.9383 72.7354 63.9383 72.1253V38.3808C63.9383 35.6213 61.6933 33.3763 58.9338 33.3763ZM20.1835 9.87857C20.1835 5.62689 23.6424 2.16797 27.8941 2.16797C29.8944 2.16797 31.7188 2.93384 33.0906 4.18736C31.4013 5.96061 30.361 8.35738 30.361 10.9941V15.2891H20.1835V9.87857ZM32.5289 15.2891V10.9941C32.5289 9.03031 33.2679 7.23682 34.481 5.87404C35.1937 7.042 35.6047 8.41302 35.6047 9.87842V15.2891H32.5289ZM37.7727 15.2891V9.87857C37.7727 7.8797 37.1742 6.01886 36.1495 4.4624C37.3359 3.71677 38.7377 3.28361 40.2395 3.28361C44.4912 3.28361 47.9501 6.74253 47.9501 10.9942V15.2892L37.7727 15.2891ZM37.6409 38.3808V49.0514H31.9676V38.3808C31.9676 36.8167 33.24 35.5443 34.8042 35.5443C36.3683 35.5443 37.6409 36.8166 37.6409 38.3808Z" fill="#1B1464"/>
                                <path d="M56.1215 38.5495H45.458C44.8592 38.5495 44.374 39.0347 44.374 39.6335C44.374 40.2323 44.8592 40.7175 45.458 40.7175H56.1215C56.7203 40.7175 57.2055 40.2323 57.2055 39.6335C57.2055 39.0347 56.7203 38.5495 56.1215 38.5495Z" fill="#1B1464"/>
                                <path d="M41.6631 45.8242C41.6631 46.423 42.1483 46.9082 42.7471 46.9082H45.0289C45.6277 46.9082 46.1129 46.423 46.1129 45.8242C46.1129 45.2254 45.6277 44.7402 45.0289 44.7402H42.7471C42.1484 44.7402 41.6631 45.2254 41.6631 45.8242Z" fill="#1B1464"/>
                                <path d="M58.8322 44.7402H48.1855C47.5868 44.7402 47.1016 45.2254 47.1016 45.8242C47.1016 46.423 47.5868 46.9082 48.1855 46.9082H58.8322C59.4309 46.9082 59.9161 46.423 59.9161 45.8242C59.9161 45.2254 59.4309 44.7402 58.8322 44.7402Z" fill="#1B1464"/>
                                <path d="M42.7471 51.9117H45.0289C45.6277 51.9117 46.1129 51.4266 46.1129 50.8278C46.1129 50.229 45.6277 49.7438 45.0289 49.7438H42.7471C42.1483 49.7438 41.6631 50.229 41.6631 50.8278C41.6631 51.4266 42.1484 51.9117 42.7471 51.9117Z" fill="#1B1464"/>
                                <path d="M58.8322 49.7438H48.1855C47.5868 49.7438 47.1016 50.229 47.1016 50.8278C47.1016 51.4266 47.5868 51.9117 48.1855 51.9117H58.8322C59.4309 51.9117 59.9161 51.4266 59.9161 50.8278C59.9161 50.229 59.4309 49.7438 58.8322 49.7438Z" fill="#1B1464"/>
                                <path d="M58.8322 56.7725H53.4365C52.8377 56.7725 52.3525 57.2577 52.3525 57.8564C52.3525 58.4552 52.8377 58.9404 53.4365 58.9404H58.8322C59.431 58.9404 59.9161 58.4552 59.9161 57.8564C59.9161 57.2577 59.431 56.7725 58.8322 56.7725Z" fill="#1B1464"/>
                                <g clip-path="url(#clip1)">
                                <path d="M42.2366 57.3794L44.3576 59.5005L42.2366 61.6216C41.9211 61.9372 41.9211 62.4484 42.2366 62.764C42.3942 62.9217 42.6009 63.0006 42.8075 63.0006C43.0144 63.0006 43.2211 62.9218 43.3786 62.764L45.5 60.6427L47.6212 62.764C47.7789 62.9217 47.9855 63.0005 48.1923 63.0005C48.399 63.0005 48.6055 62.9218 48.7633 62.764C49.0788 62.4486 49.0788 61.9373 48.7633 61.6216L46.6424 59.5005L48.7634 57.3794C49.0789 57.0639 49.0789 56.5525 48.7634 56.237C48.448 55.9218 47.9369 55.9218 47.6214 56.237L45.5 58.3582L43.3788 56.237C43.0632 55.9218 42.5521 55.9218 42.2367 56.237C41.9211 56.5525 41.9211 57.0639 42.2366 57.3794Z" fill="#D71921"/>
                                </g>
                                </g>
                                <defs>
                                <clipPath id="clip0">
                                <rect width="74" height="74" fill="white"/>
                                </clipPath>
                                <clipPath id="clip1">
                                <rect width="7" height="7" fill="white" transform="matrix(-1 0 0 1 49 56)"/>
                                </clipPath>
                                </defs>
                                </svg>

                                <h3 class="cart-craft-text mb-0 mt-3">
                                    You have no orders yet.
                                </h3>
                            </div>
                        </div>
                    @endif
                    <div class="aiz-pagination float-md-right">
                        {{ $declined_orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection