@extends('frontend.layouts.app')

@section('content')

<section class="py-5 bg-lightblue">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="page-title">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6 col-12">
                                <span class="heading heading-6 text-capitalize fw-600 mb-0 text-paragraph-title">
                                    {{ translate('Customer Orders') }}
                                </span>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
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
                                        <li class="active"><a href="{{ route('reseller.customer_orders') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('Customer Orders') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="customer-orders-margin mb-3">
                        <div class="">
                            <div class="cart-craft-count cart-craft-count-warning">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $pending_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->where('order_status', 'pending')
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $pending_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle">
                                            Pending Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="cart-craft-count cart-craft-count-primary">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $orders_id = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->pluck('order_id');

                                                $advance_orders = \App\OrderDetail::whereIn('order_id', $orders_id)
                                                    ->where('order_type', 'advance_order')
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $advance_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle">
                                            Advance Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="cart-craft-count" style="background: var(--primary-red);">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $declined_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->where('order_status', 'declined')
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $declined_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle">
                                            Declined Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="cart-craft-count cart-craft-count-success">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $successful_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->where('order_status', 'picked_up')
                                                    ->where('payment_status', 'paid')
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $successful_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle">
                                            Successful Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="cart-craft-count cart-craft-count-info">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <div class="cart-craft-count-title">
                                            @php
                                                $total_orders = \App\ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
                                                    ->distinct()
                                                    ->count();
                                            @endphp

                                            {{ $total_orders }}
                                        </div>
                                        <div class="cart-craft-count-subtitle" style="font-size: 16px;">
                                            Total Orders
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <a href="{{ route('reseller.customer_orders') }}" class="card-tab card-tab-active mr-3">
                            Customer Orders
                        </a>

                        <a href="{{ route('reseller.customer_orders_returns') }}" class="card-tab mr-3">
                            Returns
                        </a>
                    </div>
                    <div class="card card-craft-min-height border-0 shadow-none card-mobile-res">
                        <div class="card-body overflow-auto">
                            <div class="tab-content">
                                <div class="tab-pane fade in active show" id="customer_orders_tab">
                                    @if (count($orders) != 0)
                                        <div class="customer-order-table">
                                            <table class="table aiz-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="table-header">Order Code</th>
                                                        <th class="table-header">Date</th>
                                                        <th class="table-header text-center">No. of Products</th>
                                                        <th class="table-header">Customer</th>
                                                        <th class="table-header" style="width: 145px;">Order Status</th>
                                                        <th class="table-header text-center">Payment Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $key => $order)
                                                        <tr>
                                                            <td class="table-data">
                                                                @if ($order->order_status != 'declined')
                                                                    <a href="{{ route('reseller.show_purchase_history', encrypt($order->order_id ?? "N/A")) }}">
                                                                        {{ $order->order_code ?? "N/A" }}
                                                                    </a>
                                                                @else
                                                                    {{ $order->order_code ?? "N/A" }}
                                                                @endif
                                                            </td>
                                                            <td class="table-data">
                                                                {{ date('m-d-Y', $order->date ?? "N/A") }}
                                                            </td>
                                                            <td class="table-data text-center">
                                                                {{ $order->number_of_products ?? "N/A" }}
                                                            </td>
                                                            <td class="table-data">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-2">
                                                                        @if ($order->customer)
                                                                            @if ($order->customer->avatar_original != null)
                                                                                <img src="{{ uploaded_asset($order->customer->avatar_original ?? "N/A") }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                            @else
                                                                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        {{ $order->customer->name ?? "N/A" }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="table-data delivery-status-mobile">
                                                                @if ($order->order_status == 'pending')
                                                                    <div class="delivery-status delivery-status-processing" style="display: initial">
                                                                        {{ ucfirst($order->order_status ?? "N/A") }}
                                                                    </div>
                                                                    @elseif ($order->order_status == 'confirmed')
                                                                    <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                                        {{ ucfirst($order->order_status ?? "N/A") }}
                                                                    </div>
                                                                    @elseif ($order->order_status == 'processing')
                                                                    <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                                        {{ ucfirst($order->order_status ?? "N/A") }}
                                                                    </div>
                                                                    @elseif ($order->order_status == 'partial_release')
                                                                    <div class="delivery-status delivery-status-confirmed" style="display: initial">
                                                                        {{ ucfirst($order->order_status ?? "N/A") }}
                                                                    </div>
                                                                @elseif ($order->order_status == 'ready_for_pickup')
                                                                    <div class="delivery-status delivery-status-pickup" style="display: initial">
                                                                        {{ ucfirst(str_replace('_', ' ', $order->order_status ?? "N/A")) }}
                                                                    </div>
                                                                @elseif ($order->order_status == 'picked_up')
                                                                    <div class="delivery-status delivery-status-picked-up" style="display: initial">
                                                                        {{ ucfirst(str_replace('_', ' ', $order->order_status ?? "N/A")) }}
                                                                    </div>
                                                                @elseif ($order->order_status == 'declined')
                                                                    <div class="delivery-status delivery-status-rejected" style="display: initial">
                                                                        {{ ucfirst(str_replace('_', ' ', $order->order_status ?? "N/A")) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="table-data text-center">
                                                                <span class="@if ($order->payment_status == 'paid') text-success @else text-danger @endif">
                                                                    {{ ucfirst($order->payment_status ?? "N/A") }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                                            <div class="text-center">
                                                <svg width="69" height="65" viewBox="0 0 69 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.06692 12H48.805C51.0512 12 52.8719 13.8211 52.8719 16.0669V60.805C52.8719 63.0512 51.0512 64.8724 48.805 64.8724H4.06692C1.82073 64.8724 0 63.0512 0 60.805V16.0669C0 13.8211 1.82073 12 4.06692 12Z" fill="#FFCFD1"/>
                                                <path d="M9.96484 5.04956H11.9987V7.08302H9.96484V5.04956Z" fill="#5EB3D1"/>
                                                <path d="M14.0322 5.04956H16.0657V7.08302H14.0322V5.04956Z" fill="#5EB3D1"/>
                                                <path d="M18.0991 5.04956H20.133V7.08302H18.0991V5.04956Z" fill="#5EB3D1"/>
                                                <path d="M9.96484 9.11646H56.7368V11.1503H9.96484V9.11646Z" fill="#5EB3D1"/>
                                                <path d="M23.1831 17.2505H40.4685V19.2839H23.1831V17.2505Z" fill="#5EB3D1"/>
                                                <path d="M23.1831 21.3176H30.3008V23.3515H23.1831V21.3176Z" fill="#5EB3D1"/>
                                                <path d="M32.334 21.3176H46.569V23.3515H32.334V21.3176Z" fill="#5EB3D1"/>
                                                <path d="M42.502 17.2505H52.6697V19.2839H42.502V17.2505Z" fill="#5EB3D1"/>
                                                <path d="M15.0492 25.385C12.2418 25.385 9.96533 23.1085 9.96533 20.3011C9.96533 17.4938 12.2418 15.2173 15.0492 15.2173C17.8561 15.2173 20.133 17.4938 20.133 20.3011C20.1298 23.1073 17.8553 25.3818 15.0492 25.385ZM15.0492 17.2507C13.3641 17.2507 11.9988 18.6165 11.9988 20.3011C11.9988 21.9858 13.3641 23.3515 15.0492 23.3515C16.7338 23.3515 18.0992 21.9858 18.0992 20.3011C18.0992 18.6165 16.7338 17.2507 15.0492 17.2507Z" fill="#5EB3D1"/>
                                                <path d="M23.1831 29.4519H40.4685V31.4858H23.1831V29.4519Z" fill="#5EB3D1"/>
                                                <path d="M23.1831 33.519H30.3008V35.5525H23.1831V33.519Z" fill="#5EB3D1"/>
                                                <path d="M15.0492 37.5859C12.2418 37.5859 9.96533 35.3094 9.96533 32.5021C9.96533 29.6947 12.2418 27.4182 15.0492 27.4182C17.8561 27.4182 20.133 29.6951 20.133 32.5021C20.1298 35.3086 17.8553 37.5831 15.0492 37.5859ZM15.0492 29.4517C13.3641 29.4517 11.9988 30.8174 11.9988 32.5021C11.9988 34.1867 13.3641 35.5524 15.0492 35.5524C16.7338 35.5524 18.0992 34.1867 18.0992 32.5021C18.0992 30.8174 16.7338 29.4517 15.0492 29.4517Z" fill="#5EB3D1"/>
                                                <path d="M23.1831 45.7202H30.3008V47.7541H23.1831V45.7202Z" fill="#5EB3D1"/>
                                                <path d="M42.502 41.6533H52.6697V43.6868H42.502V41.6533Z" fill="#5EB3D1"/>
                                                <path d="M15.0492 49.7876C12.2418 49.7876 9.96533 47.5111 9.96533 44.7037C9.96533 41.8964 12.2418 39.6199 15.0492 39.6199C17.8561 39.6199 20.133 41.8964 20.133 44.7037C20.1298 47.5099 17.8553 49.7844 15.0492 49.7876ZM15.0492 41.6533C13.3641 41.6533 11.9988 43.0187 11.9988 44.7037C11.9988 46.3884 13.3641 47.7541 15.0492 47.7541C16.7338 47.7541 18.0992 46.3884 18.0992 44.7037C18.0992 43.0187 16.7338 41.6533 15.0492 41.6533Z" fill="#5EB3D1"/>
                                                <path d="M14.3306 19.5823L20.4309 13.4819L21.8689 14.9199L15.7686 21.0203L14.3306 19.5823Z" fill="#E34B87"/>
                                                <path d="M14.3291 31.7826L20.4295 25.6826L21.8671 27.1202L15.7667 33.2206L14.3291 31.7826Z" fill="#E34B87"/>
                                                <path d="M14.3286 43.9842L20.429 37.8838L21.867 39.3218L15.7666 45.4222L14.3286 43.9842Z" fill="#E34B87"/>
                                                <path d="M67.9208 46.7372C67.9208 54.5989 61.5478 60.9718 53.6862 60.9718C45.8245 60.9718 39.4512 54.5989 39.4512 46.7372C39.4512 38.8756 45.8245 32.5022 53.6862 32.5022C61.5478 32.5022 67.9208 38.8756 67.9208 46.7372Z" fill="#D71921"/>
                                                <path d="M53.8997 53.2522C53.3846 53.2522 52.8911 53.7051 52.9149 54.237C52.9388 54.7705 53.3476 55.2218 53.8997 55.2218C54.4148 55.2218 54.9083 54.7688 54.8845 54.237C54.8606 53.7034 54.4518 53.2522 53.8997 53.2522Z" fill="white"/>
                                                <path d="M53.8996 38C51.198 38 49 40.198 49 42.8996C49 43.4435 49.4409 43.8844 49.9848 43.8844C50.5286 43.8844 50.9696 43.4435 50.9696 42.8996C50.9696 41.284 52.284 39.9696 53.8996 39.9696C55.5152 39.9696 56.8297 41.284 56.8297 42.8996C56.8297 44.5152 55.5152 45.8297 53.8996 45.8297C53.3558 45.8297 52.9148 46.2706 52.9148 46.8145V50.831C52.9148 51.3749 53.3558 51.8158 53.8996 51.8158C54.4435 51.8158 54.8844 51.375 54.8844 50.831V47.6998C57.1157 47.2427 58.7993 45.2641 58.7993 42.8996C58.7993 40.198 56.6013 38 53.8996 38Z" fill="white"/>
                                                <path d="M10.9818 55.888H37.418V53.8545H10.9818C9.29716 53.8545 7.93141 52.4888 7.93141 50.8041V6.06603C7.93141 4.38139 9.29716 3.01604 10.9818 3.01604H55.7199C57.4045 3.01604 58.7703 4.38139 58.7703 6.06603V29.4522H60.8038V6.06603C60.8006 3.25989 58.5264 0.985371 55.7199 0.982178H10.9818C8.17566 0.985371 5.90114 3.25989 5.89795 6.06603V50.8041C5.90114 53.6107 8.17566 55.8852 10.9818 55.888Z" fill="#1B1464"/>
                                                <path d="M9.96484 5.04956H11.9987V7.08302H9.96484V5.04956Z" fill="#1B1464"/>
                                                <path d="M14.0322 5.04956H16.0657V7.08302H14.0322V5.04956Z" fill="#1B1464"/>
                                                <path d="M18.0991 5.04956H20.133V7.08302H18.0991V5.04956Z" fill="#1B1464"/>
                                                <path d="M9.96484 9.11646H56.7368V11.1503H9.96484V9.11646Z" fill="#1B1464"/>
                                                <path d="M20.4306 13.4814L17.848 16.0641C15.4992 14.5095 12.3363 15.1529 10.7814 17.5017C9.22685 19.8508 9.87022 23.0138 12.2194 24.5683C14.5681 26.1232 17.7311 25.4795 19.286 23.1307C20.4155 21.4245 20.4155 19.2079 19.286 17.5017L21.8682 14.9194L20.4306 13.4814ZM15.0491 23.3514C13.364 23.3514 11.9987 21.9857 11.9987 20.301C11.9987 18.6164 13.364 17.2506 15.0491 17.2506C15.5012 17.2526 15.9486 17.3564 16.3553 17.5555L14.3303 19.581L15.7679 21.019L17.7941 18.9943C17.9937 19.401 18.0975 19.8484 18.0994 20.301C18.099 21.9857 16.7337 23.3514 15.0491 23.3514Z" fill="#1B1464"/>
                                                <path d="M23.1831 17.2505H40.4685V19.2839H23.1831V17.2505Z" fill="#1B1464"/>
                                                <path d="M23.1831 21.3176H30.3008V23.3515H23.1831V21.3176Z" fill="#1B1464"/>
                                                <path d="M32.334 21.3176H46.569V23.3515H32.334V21.3176Z" fill="#1B1464"/>
                                                <path d="M42.502 17.2505H52.6697V19.2839H42.502V17.2505Z" fill="#1B1464"/>
                                                <path d="M20.4306 25.6826L17.848 28.2653C15.4992 26.7107 12.3363 27.3545 10.7814 29.7032C9.22685 32.052 9.87022 35.2149 12.2194 36.7699C14.5681 38.3244 17.7311 37.6806 19.286 35.3319C20.4155 33.6257 20.4155 31.4094 19.286 29.7032L21.8682 27.1206L20.4306 25.6826ZM15.0491 35.5526C13.364 35.5526 11.9987 34.1868 11.9987 32.5022C11.9987 30.8176 13.364 29.4518 15.0491 29.4518C15.5012 29.4538 15.9486 29.5576 16.3553 29.7571L14.3303 31.7826L15.7679 33.2202L17.7941 31.1959C17.9937 31.6026 18.0975 32.05 18.0994 32.5022C18.099 34.1872 16.7337 35.5526 15.0491 35.5526Z" fill="#1B1464"/>
                                                <path d="M23.1831 29.4519H40.4685V31.4858H23.1831V29.4519Z" fill="#1B1464"/>
                                                <path d="M23.1831 33.519H30.3008V35.5525H23.1831V33.519Z" fill="#1B1464"/>
                                                <path d="M32.334 33.519H40.4682V35.5525H32.334V33.519Z" fill="#1B1464"/>
                                                <path d="M42.502 29.4519H46.5693V31.4858H42.502V29.4519Z" fill="#1B1464"/>
                                                <path d="M20.4306 37.884L17.848 40.4667C15.4992 38.9121 12.3363 39.5555 10.7814 41.9043C9.22685 44.253 9.87022 47.4164 12.2194 48.9709C14.5681 50.5254 17.7311 49.8821 19.286 47.5333C20.4155 45.8271 20.4155 43.6105 19.286 41.9043L21.8682 39.3216L20.4306 37.884ZM15.0491 47.754C13.364 47.754 11.9987 46.3883 11.9987 44.7036C11.9987 43.0186 13.364 41.6532 15.0491 41.6532C15.5012 41.6552 15.9486 41.759 16.3553 41.9581L14.3303 43.9836L15.7679 45.4212L17.7941 43.3969C17.9937 43.8036 18.0975 44.251 18.0994 44.7036C18.099 46.3883 16.7337 47.754 15.0491 47.754Z" fill="#1B1464"/>
                                                <path d="M23.1831 41.6533H36.4012V43.6868H23.1831V41.6533Z" fill="#1B1464"/>
                                                <path d="M23.1831 45.7202H30.3008V47.7541H23.1831V45.7202Z" fill="#1B1464"/>
                                                <path d="M32.334 45.7202H36.4009V47.7541H32.334V45.7202Z" fill="#1B1464"/>
                                                <path d="M53.6866 61.9887C62.1094 61.9887 68.9382 55.1599 68.9382 46.7371C68.9382 38.3143 62.1094 31.4856 53.6866 31.4856C45.2638 31.4856 38.4351 38.3143 38.4351 46.7371C38.4442 55.1559 45.2678 61.9795 53.6866 61.9887ZM53.6866 33.5191C60.9871 33.5191 66.9047 39.4366 66.9047 46.7371C66.9047 54.0376 60.9871 59.9552 53.6866 59.9552C46.3861 59.9552 40.4685 54.0376 40.4685 46.7371C40.4765 39.4406 46.3901 33.527 53.6866 33.5191Z" fill="#1B1464"/>
                                                </svg>

                                                <h3 class="cart-craft-text mb-0 mt-3">
                                                    Your customer orders is empty.
                                                </h3>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aiz-pagination">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
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
