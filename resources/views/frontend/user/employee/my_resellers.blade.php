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
                                {{ translate('My Resellers') }}
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
                                    <li class="active"><a href="{{ route('employee.my_resellers') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('My Resellers') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @if (count($unverified_resellers) != 0 || count($verified_resellers) != 0)
                    <div class="card card-craft-min-height mt-2 verified-table">
                        <div class="card-body overflow-auto">
                            <div class="d-flex justify-content-start border-bottom mb-4">
                                <div class="card-customer-wallet-title">
                                    Unverified Resellers
                                </div>
                            </div>

                            <div class="reseller-subtitle">
                                These are the resellers you referred that are still pending for approval by WorldCraft.
                            </div>

                            <div>
                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="table-header">{{ translate('Resellers') }}</th>
                                            <th class="table-header">{{ translate('Email') }}</th>
                                            <th class="table-header text-center">{{ translate('Date Joined') }}</th>
                                            <th class="table-header text-center">{{ translate('Total Successful Orders') }}</th>
                                            <th class="table-header text-center">{{ translate('Total Earnings') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($unverified_resellers as $key => $value)
                                            <tr>
                                                <td class="table-data">
                                                    <a href="{{ route('employee.my_reseller_show', encrypt($value->reseller->id)) }}">
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2">
                                                                @if ($value->reseller->avatar_original != null)
                                                                    <img src="{{ uploaded_asset($value->reseller->avatar_original ?? "N/A") }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                @else
                                                                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                @endif
                                                            </div>
                                                            <div>
                                                                {{ $value->reseller->name ?? "N/A" }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="table-data">
                                                    {{ $value->reseller->email ?? "N/A" }}
                                                </td>
                                                <td class="table-data text-center">
                                                    {{ date('m-d-Y', strtotime($value->date_of_sign_up ?? "N/A")) }}
                                                </td>
                                                <td class="table-data text-center">
                                                    {{ $value->total_successful_orders ?? "N/A" }}
                                                </td>
                                                <td class="table-data text-right">
                                                    {{ single_price($value->total_earnings ?? "N/A") }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="aiz-pagination">
                        {{ $unverified_resellers->links() }}
                    </div>

                    <div class="card card-craft-min-height mt-2 verified-table">
                        <div class="card-body overflow-auto">
                            <div class="d-flex justify-content-start border-bottom mb-4">
                                <div class="card-customer-wallet-title">
                                    Verified Resellers
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12 col-lg-5">
                                    <form class="" action="" method="GET">
                                        <div class="form-group">
                                            <input type="text" name="search" id="search" class="form-control form-control-lg" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="Search Reseller">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div>
                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="table-header">{{ translate('Resellers') }}</th>
                                            <th class="table-header">{{ translate('Date Joined') }}</th>
                                            <th class="table-header">{{ translate('Total Successful Orders') }}</th>
                                            <th class="table-header">{{ translate('Total Earnings') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($verified_resellers as $key => $value)
                                            <tr>
                                                <td class="table-data">
                                                    <a href="{{ route('employee.my_reseller_show', encrypt($value->reseller_id)) }}">
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2">
                                                                @if ($value->avatar_original != null)
                                                                    <img src="{{ uploaded_asset($value->avatar_original ?? "N/A" ) }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                @else
                                                                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                                @endif
                                                            </div>
                                                            <div>
                                                                {{ $value->name ?? "N/A" }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="table-data">
                                                    {{ date('m-d-Y', strtotime($value->date_joined ?? "N/A" )) }}
                                                </td>
                                                <td class="table-data">
                                                    {{ $value->total_successful_orders ?? "N/A" }}
                                                </td>
                                                <td class="table-data">
                                                    {{ single_price($value->total_earnings ?? "N/A" ) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="aiz-pagination">
                        {{ $verified_resellers->links() }}
                    </div>
                @else
                    <div class="card card-craft-min-height mt-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-start border-bottom mb-4">
                                <div class="card-customer-wallet-title">
                                    List of Resellers
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12 col-lg-5">
                                    <form class="" action="" method="GET">
                                        <div class="form-group">
                                            <input type="text" name="search" id="search" class="form-control form-control-lg" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="Search Reseller">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                                    <div class="text-center">
                                        <svg width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0)">
                                        <path d="M28.3212 57.3052C36.9583 57.262 43.9251 50.2248 43.8819 41.5871C43.8387 32.9494 36.8019 25.9821 28.1648 26.0253C19.5277 26.0685 12.5609 33.1058 12.6041 41.7435C12.6473 50.3812 19.6841 57.3484 28.3212 57.3052Z" fill="#FFCFD1"/>
                                        <path d="M31.6878 40.4853C35.7392 40.4853 39.0353 37.189 39.0353 33.1374C39.0353 29.0858 35.7392 25.7896 31.6878 25.7896C27.6363 25.7896 24.3403 29.0857 24.3403 33.1374C24.3403 37.189 27.6363 40.4853 31.6878 40.4853ZM31.6878 28.4458C34.2746 28.4458 36.379 30.5505 36.379 33.1374C36.379 35.7243 34.2745 37.829 31.6878 37.829C29.101 37.829 26.9966 35.7243 26.9966 33.1374C26.9966 30.5503 29.101 28.4458 31.6878 28.4458Z" fill="#1B1464"/>
                                        <path d="M53.7291 49.3379C51.7225 49.3379 49.8679 50.0016 48.3732 51.1208L43.9179 46.6651C46.3289 43.8088 47.7163 40.1481 47.7163 36.3126C47.7163 32.3705 46.285 28.7568 43.916 25.962L47.7024 22.1752C48.221 21.6566 48.221 20.8156 47.7024 20.297C47.1836 19.7784 46.3426 19.7784 45.824 20.2971L42.0378 24.0837C39.2431 21.7145 35.6297 20.2832 31.6877 20.2832C27.7457 20.2832 24.1323 21.7145 21.3377 24.0836L14.4206 17.1661C15.1204 16.1121 15.5288 14.8485 15.5288 13.4913C15.5288 9.81823 12.5408 6.83008 8.86798 6.83008C5.19519 6.83008 2.20704 9.81836 2.20704 13.4913C2.20704 17.1642 5.19519 20.1525 8.86798 20.1525C10.2251 20.1525 11.4885 19.7441 12.5425 19.0443L19.4598 25.9619C17.0907 28.7566 15.6594 32.3703 15.6594 36.3126C15.6594 40.1481 17.0467 43.8088 19.4578 46.6652L12.8792 53.2442C11.5438 52.2852 9.90777 51.7198 8.1419 51.7198C3.6535 51.7198 0.00195312 55.3715 0.00195312 59.8601C0.00195312 64.3488 3.65337 68.0003 8.14177 68.0003C12.6302 68.0003 16.2817 64.3485 16.2817 59.86C16.2817 58.0941 15.7162 56.4579 14.7573 55.1224L21.3331 48.5462C22.0587 49.1623 22.8437 49.718 23.683 50.2027C26.1066 51.6022 28.8746 52.342 31.6877 52.342C34.5009 52.342 37.2689 51.6022 39.6924 50.2027C40.5317 49.718 41.3167 49.1623 42.0423 48.5462L46.5048 53.009C45.4181 54.4909 44.7753 56.3177 44.7753 58.2921C44.7753 63.2294 48.792 67.2462 53.729 67.2462C58.666 67.2462 62.6825 63.2294 62.6825 58.2921C62.6827 53.3547 58.6662 49.3379 53.7291 49.3379ZM4.86302 13.4913C4.86302 11.283 6.65944 9.48633 8.86772 9.48633C11.0759 9.48633 12.8723 11.283 12.8723 13.4913C12.8723 15.6996 11.0759 17.4963 8.86772 17.4963C6.65958 17.4963 4.86302 15.6996 4.86302 13.4913ZM31.6877 22.9394C39.0613 22.9394 45.0601 28.9386 45.0601 36.3126C45.0601 40.2547 43.3031 43.9757 40.3565 46.4936V44.607C40.3565 42.7682 38.8605 41.2722 37.0218 41.2722H26.3538C24.5149 41.2722 23.019 42.7682 23.019 44.607V46.4936C20.0724 43.9757 18.3155 40.2547 18.3155 36.3126C18.3153 28.9386 24.3141 22.9394 31.6877 22.9394ZM8.14177 65.3441C5.11802 65.3441 2.65807 62.884 2.65807 59.86C2.65807 56.8361 5.11816 54.3759 8.14177 54.3759C11.1654 54.3759 13.6255 56.836 13.6255 59.86C13.6255 62.884 11.1654 65.3441 8.14177 65.3441ZM37.7001 48.2609C35.8449 49.1951 33.7817 49.6859 31.6877 49.6859C29.5936 49.6859 27.5304 49.1951 25.6751 48.2609V44.6071C25.6751 44.233 25.9795 43.9286 26.3537 43.9286H37.0216C37.3956 43.9286 37.7 44.233 37.7 44.6071V48.2609H37.7001ZM53.7291 64.5898C50.2566 64.5898 47.4317 61.7646 47.4317 58.292C47.4317 54.8194 50.2567 51.9942 53.7291 51.9942C57.2015 51.9942 60.0264 54.8194 60.0264 58.292C60.0264 61.7646 57.2014 64.5898 53.7291 64.5898Z" fill="#1B1464"/>
                                        <path d="M49.5733 10.1675L52.8265 13.4211L49.5733 16.6745C49.0895 17.1586 49.0895 17.9427 49.5733 18.4268C49.8151 18.6686 50.1321 18.7896 50.449 18.7896C50.7663 18.7896 51.0833 18.6688 51.3249 18.4268L54.5788 15.173L57.8325 18.4268C58.0742 18.6686 58.3913 18.7895 58.7084 18.7895C59.0254 18.7895 59.3422 18.6687 59.5842 18.4268C60.0681 17.9429 60.0681 17.1587 59.5842 16.6745L56.3311 13.4211L59.5843 10.1675C60.0682 9.68362 60.0682 8.89928 59.5843 8.41538C59.1005 7.93185 58.3167 7.93185 57.8327 8.41538L54.5789 11.6689L51.3253 8.41538C50.8412 7.93185 50.0572 7.93185 49.5735 8.41538C49.0895 8.89928 49.0895 9.68362 49.5733 10.1675Z" fill="#CE141C"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0">
                                        <rect width="68" height="68" fill="white"/>
                                        </clipPath>
                                        </defs>
                                        </svg>

                                        <h3 class="cart-craft-text mb-0 mt-3">
                                            You have no resellers yet.
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card mt-2">
                    <div class="card-body">
                        <div class="employee-label">
                            Share this link to your friends to refer them and become a reseller in WorldCraft.
                        </div>

                        @if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && \App\AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status)
                            <div class="row">
                                @php
                                    if(Auth::user()->referral_code == null) {
                                        Auth::user()->referral_code = substr(Auth::user()->id.Str::random(), 0, 10);
                                        Auth::user()->save();
                                    }
                                    $referral_code = Auth::user()->referral_code;
                                    $referral_code_url = URL::to('/users/registration')."?referral_code=$referral_code";
                                @endphp
                                <div class="col">
                                    <div class="form-box-content">
                                        <div class="form-group">
                                            <input id="referral_code_url" class="form-control form-control-lg referral-link-input" value="{{ $referral_code_url }}" readonly type="text" style="height: 63px;" />
                                        </div>
                                        <button type=button id="ref-cpurl-btn" class="btn btn-primary float-right" data-attrcpy="{{translate('Copied')}}" onclick="copyToClipboard('url')" >

                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.375 0.75H3.375C2.55 0.75 1.875 1.425 1.875 2.25V12.75H3.375V2.25H12.375V0.75ZM14.625 3.75H6.375C5.55 3.75 4.875 4.425 4.875 5.25V15.75C4.875 16.575 5.55 17.25 6.375 17.25H14.625C15.45 17.25 16.125 16.575 16.125 15.75V5.25C16.125 4.425 15.45 3.75 14.625 3.75ZM6.375 15.75H14.625V5.25H6.375V15.75Z" fill="white"/>
                                            </svg>
                                                 {{translate('Copy Referral Link')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

        function copyToClipboard(btn){
            // var el_code = document.getElementById('referral_code');
            var el_url = document.getElementById('referral_code_url');
            // var c_b = document.getElementById('ref-cp-btn');
            var c_u_b = document.getElementById('ref-cpurl-btn');

            // if(btn == 'code'){
            //     if(el_code != null && c_b != null){
            //         el_code.select();
            //         document.execCommand('copy');
            //         c_b .innerHTML  = c_b.dataset.attrcpy;
            //     }
            // }

            if(btn == 'url'){
                if(el_url != null && c_u_b != null){
                    el_url.select();
                    document.execCommand('copy');
                    c_u_b .innerHTML  = c_u_b.dataset.attrcpy;
                }
            }
        }

        function show_affiliate_withdraw_modal(){
            $('#affiliate_withdraw_modal').modal('show');
        }
    </script>
@endsection

@endsection
