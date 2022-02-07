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
                                    {{ translate('My Wallet') }}
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
                                        <li class="active"><a href="{{ route('wallet.index') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('My Wallet') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- // Buttons --}}
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-3 p-0">
                                <div class="wallet-craft-card">
                                    <div class="d-flex justify-content-between w-100">
                                        <div>
                                            <div class="cart-craft-wallet-title">
                                                {{ single_price(Auth::user()->balance) }}
                                            </div>
                                            <div class="cart-craft-wallet-subtitle">
                                                Wallet Balance
                                            </div>
                                        </div>
                                        <div>
                                            <div class="float-right d-flex align-items-center h-100">
                                                <svg class="" width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M24.7705 6.04167V8.79667C25.4834 9.21958 25.9788 9.98083 25.9788 10.875V18.125C25.9788 19.0192 25.4834 19.7804 24.7705 20.2033V22.9583C24.7705 24.2875 23.683 25.375 22.3538 25.375H5.43717C4.09592 25.375 3.02051 24.2875 3.02051 22.9583V6.04167C3.02051 4.7125 4.09592 3.625 5.43717 3.625H22.3538C23.683 3.625 24.7705 4.7125 24.7705 6.04167ZM15.1038 18.125H23.5622V10.875H15.1038V18.125ZM5.43717 22.9583V6.04167H22.3538V8.45833H15.1038C13.7747 8.45833 12.6872 9.54583 12.6872 10.875V18.125C12.6872 19.4542 13.7747 20.5417 15.1038 20.5417H22.3538V22.9583H5.43717ZM16.9163 14.5C16.9163 13.499 17.7278 12.6875 18.7288 12.6875C19.7299 12.6875 20.5413 13.499 20.5413 14.5C20.5413 15.501 19.7299 16.3125 18.7288 16.3125C17.7278 16.3125 16.9163 15.501 16.9163 14.5Z" fill="#1B1464"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 p-0">
                                <div class="wallet-btn">
                                    <div class="cash-in-btn">
                                        <a href="{{route('wallet.request_cash_in')}}" class="btn btn-primary wallet-btn-cash">
                                            <svg class="mr-2" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0007 1.83337C5.94065 1.83337 1.83398 5.94004 1.83398 11C1.83398 16.06 5.94065 20.1667 11.0007 20.1667C16.0607 20.1667 20.1673 16.06 20.1673 11C20.1673 5.94004 16.0607 1.83337 11.0007 1.83337ZM10.084 6.41671V10.0834H6.41732V11.9167H10.084V15.5834H11.9173V11.9167H15.584V10.0834H11.9173V6.41671H10.084ZM3.66732 11C3.66732 15.0425 6.95815 18.3334 11.0007 18.3334C15.0431 18.3334 18.334 15.0425 18.334 11C18.334 6.95754 15.0431 3.66671 11.0007 3.66671C6.95815 3.66671 3.66732 6.95754 3.66732 11Z" fill="white"/>
                                            </svg>

                                            Cash in
                                        </a>
                                    </div>
                                    <div class="req-cash-out-btn">
                                        <a href="{{ route('wallet.request_cash_out') }}" class="btn btn-request-cash-out">
                                            <svg class="mr-2" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.3327 11L17.0402 9.70746L11.916 14.8225V3.66663H10.0827V14.8225L4.96768 9.69829L3.66602 11L10.9993 18.3333L18.3327 11Z" fill="#D73019"/>
                                            </svg>

                                            Request Cash out
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-craft-min-height mt-2 wallet-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-start border-bottom">
                                <div class="card-customer-wallet-title">
                                    Wallet Transaction History
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <form id="sort_transaction" action="" method="GET">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="cart-wallet-label">Sort By</div>
                                                <div class="ml-3">
                                                    <select class="custom-select cart-wallet-select-dropdown" name="transaction_type" id="transaction_type" onchange="sort_transaction()">
                                                        <option value="">Transaction Type</option>
                                                        <option value="cash_in" @isset($transaction_type) @if ($transaction_type == 'cash_in') selected @endif @endisset>Cash in</option>
                                                        <option value="cash_out" @isset($transaction_type) @if ($transaction_type == 'cash_out') selected @endif @endisset>Cash out</option>
                                                        <option value="refund" @isset($transaction_type) @if ($transaction_type == 'refund') selected @endif @endisset>Refund</option>
                                                        <option value="earnings_convert" @isset($transaction_type) @if ($transaction_type == 'earnings_convert') selected @endif @endisset>Earnings Converted</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-6 mt-3">
                                        <div class="d-flex justify-content-end">
                                            <div class="mr-lg-5 mr-2">
                                                <div class="cart-craft-cash-in">
                                                    Total cash in amount
                                                </div>
                                                <div class="cart-craft-cash-in-amount">
                                                    <span class="float-right text-success">
                                                        @php
                                                            $wallet_cash_ins = \App\Wallet::where('user_id', Auth::user()->id)
                                                                ->where('type', 'cash_in')
                                                                ->get(['id', 'amount']);

                                                            $total_cash_in = 0;

                                                            foreach ($wallet_cash_ins as $key => $value) {
                                                                $total_cash_in += $value->amount;
                                                            }
                                                        @endphp

                                                        + {{ single_price($total_cash_in) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="cart-craft-cash-in">
                                                    Total cash out amount
                                                </div>
                                                <div class="cart-craft-cash-in-amount">
                                                    <span class="float-right text-danger">
                                                        @php
                                                            $wallet_cash_outs = \App\Wallet::where('user_id', Auth::user()->id)
                                                                ->where('type', 'cash_out')
                                                                ->where('request_status', 'approved')
                                                                ->get(['id', 'amount']);

                                                            $total_cash_out = 0;

                                                            foreach ($wallet_cash_outs as $key => $value) {
                                                                $total_cash_out += $value->amount;
                                                            }
                                                        @endphp

                                                        - {{ single_price($total_cash_out) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (count($wallets) > 0)
                                <div>
                                    <table class="table aiz-table mb-0">
                                        <thead>
                                            <tr>
                                                <th class="table-header">#</th>
                                                <th class="table-header" data-breakpoints="lg">{{ translate('Date') }}</th>
                                                <th class="table-header" data-breakpoints="lg">{{ translate('Type') }}</th>
                                                <th class="table-header">{{ translate('Amount') }}</th>
                                                <th class="table-header text-status">{{ translate('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($wallets as $key => $wallet)
                                                <tr>
                                                    <td class="table-data">{{ ($key+1) + ($wallets->currentPage() - 1) * $wallets->perPage() }}</td>
                                                    <td class="table-data">{{ date('d-m-Y', strtotime($wallet->created_at)) }}</td>
                                                    <td class="table-data">{{ ucfirst(str_replace('_', ' ', $wallet->type)) }}</td>
                                                    <td class="table-data">
                                                        @if ($wallet->payment_method != 'Refund')
                                                            <span class="@if ($wallet->type == 'cash_in' || $wallet->type == 'earnings_convert') text-success @else text-danger @endif">
                                                                @if ($wallet->type == 'cash_in')
                                                                    +
                                                                @elseif ($wallet->type == 'earnings_convert')
                                                                    +
                                                                @else
                                                                    -
                                                                @endif
                                                                {{ single_price($wallet->amount) }}
                                                            </span>
                                                        @else
                                                            <span class="text-success">
                                                                + {{ single_price($wallet->amount) }}
                                                            </span>
                                                        @endif

                                                    </td>
                                                    <td class="text-status">
                                                        @if ($wallet->request_status == 'pending')
                                                            <span class="delivery-status delivery-status-processing" style="display: initial !important">
                                                                Processing
                                                            </span>
                                                        @elseif ($wallet->request_status == 'approved')
                                                            <span class="delivery-status delivery-status-picked-up" style="display: initial !important">
                                                                Success
                                                            </span>
                                                        @elseif ($wallet->request_status == 'rejected')
                                                            <span class="delivery-status delivery-status-rejected" style="display: initial !important">
                                                                Rejected
                                                            </span>
                                                        @endif
                                                        @if ($wallet->type == 'cash_in' && $wallet->request_status == 'pending')
                                                            <span id="check_payment_id_{{ $key }}" class="text-success font-weight-bold ml-2 refresh c-pointer" title="Re-check Payment Status" onclick="check_payment({{ $wallet }}, {{ $key }})">
                                                                <i id="icon-check_{{ $key }}" class="las la-undo-alt"></i>
                                                                <span id="check-text_{{ $key }}" style="display: none;"></span>
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                                    <div class="text-center">
                                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0)">
                                        <path d="M16.947 39.7451C18.8439 38.2577 22.8532 31.5 31.7766 31.5H45.7734V36.2112C45.7735 36.3886 45.8214 36.5627 45.9122 36.7151C46.0031 36.8674 46.1334 36.9924 46.2894 37.0769C46.4454 37.1613 46.6213 37.202 46.7986 37.1946C46.9758 37.1873 47.1478 37.1322 47.2963 37.0351L62.5541 27.0703C62.6912 26.9809 62.8038 26.8586 62.8818 26.7147C62.9597 26.5707 63.0006 26.4096 63.0006 26.2459C63.0006 26.0822 62.9597 25.9211 62.8818 25.7771C62.8038 25.6332 62.6912 25.5109 62.5541 25.4215L47.2963 15.4547C47.1477 15.3576 46.9756 15.3025 46.7983 15.2952C46.621 15.2879 46.445 15.3287 46.289 15.4132C46.1329 15.4977 46.0026 15.6229 45.9119 15.7754C45.8211 15.9279 45.7733 16.1021 45.7734 16.2796V20.9898H33.328C28.5375 20.9953 23.9448 22.9006 20.5572 26.2878C17.1696 29.675 15.2638 34.2675 15.2578 39.058C15.2578 39.2538 15.3162 39.4451 15.4255 39.6075C15.5348 39.7699 15.69 39.896 15.8713 39.9697C16.0526 40.0435 16.2518 40.0615 16.4434 40.0215C16.635 39.9815 16.8104 39.8853 16.947 39.7451Z" fill="#FFCFD1"/>
                                        <path d="M61.3108 38.5471C59.412 40.0355 55.4046 46.7932 46.4812 46.7932H32.4844V42.081C32.4842 41.9037 32.4361 41.7298 32.3452 41.5775C32.2543 41.4253 32.124 41.3004 31.968 41.2161C31.812 41.1318 31.6362 41.0912 31.459 41.0986C31.2819 41.106 31.11 41.1611 30.9616 41.2581L15.7038 51.2249C15.5671 51.3144 15.4548 51.4366 15.3771 51.5803C15.2995 51.7241 15.2588 51.8849 15.2588 52.0483C15.2588 52.2117 15.2995 52.3725 15.3771 52.5163C15.4548 52.6601 15.5671 52.7822 15.7038 52.8717L30.9616 62.8385C31.11 62.9355 31.2819 62.9906 31.459 62.998C31.6362 63.0054 31.812 62.9648 31.968 62.8805C32.124 62.7962 32.2543 62.6714 32.3452 62.5191C32.4361 62.3669 32.4842 62.1929 32.4844 62.0156V57.3044H44.9299C49.7207 57.2989 54.3137 55.3933 57.7014 52.0057C61.089 48.6181 62.9946 44.025 63 39.2342C63 39.0385 62.9416 38.8472 62.8324 38.6848C62.7231 38.5224 62.5679 38.3962 62.3865 38.3225C62.2052 38.2487 62.006 38.2307 61.8144 38.2707C61.6228 38.3107 61.4475 38.407 61.3108 38.5471Z" fill="#FFCFD1"/>
                                        <path d="M44.7891 0H2.95312C2.16991 0 1.41877 0.311132 0.86495 0.86495C0.311132 1.41877 0 2.16991 0 2.95312L0 28.5469C0 29.3301 0.311132 30.0812 0.86495 30.635C1.41877 31.1889 2.16991 31.5 2.95312 31.5H44.7891C45.5723 31.5 46.3234 31.1889 46.8772 30.635C47.4311 30.0812 47.7422 29.3301 47.7422 28.5469V2.95312C47.7422 2.16991 47.4311 1.41877 46.8772 0.86495C46.3234 0.311132 45.5723 0 44.7891 0V0ZM1.96875 2.95312C1.96875 2.69205 2.07246 2.44167 2.25707 2.25707C2.44167 2.07246 2.69205 1.96875 2.95312 1.96875H8.79145C8.57061 3.70108 7.78076 5.31104 6.5459 6.5459C5.31104 7.78076 3.70108 8.57061 1.96875 8.79145V2.95312ZM2.95312 29.5312C2.69205 29.5312 2.44167 29.4275 2.25707 29.2429C2.07246 29.0583 1.96875 28.8079 1.96875 28.5469V22.7085C3.70108 22.9294 5.31104 23.7192 6.5459 24.9541C7.78076 26.189 8.57061 27.7989 8.79145 29.5312H2.95312ZM45.7734 28.5469C45.7734 28.8079 45.6697 29.0583 45.4851 29.2429C45.3005 29.4275 45.0501 29.5312 44.7891 29.5312H38.9507C39.1716 27.7989 39.9614 26.189 41.1963 24.9541C42.4311 23.7192 44.0411 22.9294 45.7734 22.7085V28.5469ZM45.7734 20.7221C43.5154 20.952 41.4059 21.954 39.801 23.5589C38.1962 25.1638 37.1942 27.2733 36.9643 29.5312H10.7799C10.5499 27.273 9.54764 25.1632 7.94235 23.5583C6.33706 21.9534 4.22709 20.9516 1.96875 20.7221V10.7799C4.22704 10.5499 6.33678 9.54764 7.94172 7.94235C9.54665 6.33706 10.5484 4.22709 10.7779 1.96875H36.9623C37.1923 4.22704 38.1945 6.33678 39.7998 7.94172C41.4051 9.54665 43.5151 10.5484 45.7734 10.7779V20.7221ZM45.7734 8.79145C44.0411 8.57061 42.4311 7.78076 41.1963 6.5459C39.9614 5.31104 39.1716 3.70108 38.9507 1.96875H44.7891C45.0501 1.96875 45.3005 2.07246 45.4851 2.25707C45.6697 2.44167 45.7734 2.69205 45.7734 2.95312V8.79145Z" fill="#1B1464"/>
                                        <path d="M23.8711 7.13672C22.1676 7.13672 20.5023 7.64188 19.0858 8.58832C17.6694 9.53476 16.5654 10.88 15.9135 12.4538C15.2615 14.0277 15.091 15.7596 15.4233 17.4304C15.7557 19.1012 16.576 20.6359 17.7806 21.8405C18.9852 23.0451 20.5199 23.8654 22.1907 24.1978C23.8615 24.5301 25.5934 24.3596 27.1673 23.7076C28.7411 23.0557 30.0863 21.9517 31.0328 20.5353C31.9792 19.1188 32.4844 17.4535 32.4844 15.75C32.4818 13.4664 31.5735 11.2771 29.9587 9.66237C28.344 8.04763 26.1547 7.13932 23.8711 7.13672ZM23.8711 22.3945C22.5569 22.3945 21.2723 22.0048 20.1796 21.2747C19.0869 20.5446 18.2353 19.5069 17.7324 18.2928C17.2294 17.0786 17.0979 15.7426 17.3542 14.4537C17.6106 13.1648 18.2435 11.9809 19.1727 11.0516C20.102 10.1224 21.2859 9.48952 22.5748 9.23314C23.8637 8.97676 25.1997 9.10834 26.4138 9.61125C27.628 10.1142 28.6657 10.9658 29.3958 12.0585C30.1259 13.1512 30.5156 14.4358 30.5156 15.75C30.5135 17.5116 29.8128 19.2005 28.5672 20.4461C27.3215 21.6917 25.6327 22.3924 23.8711 22.3945Z" fill="#D71921"/>
                                        <path d="M37.2832 15.75C37.2832 16.0111 37.3869 16.2615 37.5715 16.4461C37.7561 16.6307 38.0065 16.7344 38.2676 16.7344H41.2207C41.4818 16.7344 41.7322 16.6307 41.9168 16.4461C42.1014 16.2615 42.2051 16.0111 42.2051 15.75C42.2051 15.4889 42.1014 15.2385 41.9168 15.0539C41.7322 14.8693 41.4818 14.7656 41.2207 14.7656H38.2676C38.0065 14.7656 37.7561 14.8693 37.5715 15.0539C37.3869 15.2385 37.2832 15.4889 37.2832 15.75Z" fill="#1B1464"/>
                                        <path d="M9.47461 14.7656H6.52148C6.26041 14.7656 6.01003 14.8693 5.82543 15.0539C5.64082 15.2385 5.53711 15.4889 5.53711 15.75C5.53711 16.0111 5.64082 16.2615 5.82543 16.4461C6.01003 16.6307 6.26041 16.7344 6.52148 16.7344H9.47461C9.73568 16.7344 9.98606 16.6307 10.1707 16.4461C10.3553 16.2615 10.459 16.0111 10.459 15.75C10.459 15.4889 10.3553 15.2385 10.1707 15.0539C9.98606 14.8693 9.73568 14.7656 9.47461 14.7656Z" fill="#1B1464"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0">
                                        <rect width="63" height="63" fill="white"/>
                                        </clipPath>
                                        </defs>
                                        </svg>
                                        <h3 class="cart-craft-text mb-0 mt-3">
                                            Your wallet history is empty.
                                        </h3>
                                    </div>
                                </div>
                            @endif
                        </div>                      
                    </div>
                    <div class="aiz-pagination">
                        {{ $wallets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">

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

        function show_wallet_modal(){
            $('#wallet_modal').modal('show');
        }

        function sort_transaction (el){
            $('#sort_transaction').submit();
        }

        var processing = false;

        function check_payment (el, key) {
            var data = {
                '_token': "{{ csrf_token() }}",
                'wallet_id': el.id,
                'type': 'wallet'
            };

            if (processing == false) {
                processing = true;

                $('#check_payment_id_' + key).addClass('spinner-border spinner-border-sm');
                $('#icon-check_' + key).hide();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('paynamics.query_check') }}',
                    data: data,
                    success: function (data) {
                        if (data.success) {
                            $('#check_payment_id_' + key).removeClass('spinner-border spinner-border-sm')
                            $('#check-text_' + key).show();
                            $('#check-text_' + key).text('Redirecting...')
                            
                            AIZ.plugins.notify('success', '{{ translate('Query is processing. Redirecting you now...') }}');

                            setTimeout(function () {
                                window.location = data.url;
                            }, 1000);
                        }
                    }
                })
            }
        }
    </script>
@endsection
