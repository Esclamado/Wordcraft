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
                                {{ translate('My Customer') }}
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
                                    <li class="active"><a href="{{ route('reseller.my_customers') }}" class="text-breadcrumb text-secondary-color fw-600">{{ translate('My Customers') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-craft-min-height mt-2">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <form class="" action="" method="GET">
                                    <div class="form-group">
                                        <input type="text" name="search" id="search" class="form-control form-control-lg" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="Search Customer">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="customer-order-table">
                            <div class="mt-3">
                                @if (count($customers) != 0)
                                    <div>
                                        <table class="table aiz-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="table-header">#</th>
                                                    <th class="table-header">Customer</th>
                                                    <th class="table-header">Email</th>
                                                    <th class="table-header">Mobile</th>
                                                    <th class="table-header">Total Orders</th>
                                                    <th class="table-header">Last Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customers as $key => $value)
                                                    <tr>
                                                        <td class="table-data">
                                                            {{ $key + 1 }}
                                                        </td>
                                                        <td class="table-data">
                                                            <a href="{{ route('reseller.my_customer.show', encrypt($value->id)) }}">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-2">
                                                                        @if ($value->avatar_original != null)
                                                                            <img src="{{ uploaded_asset($value->avatar_original ?? "N/A") }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
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
                                                            {{ $value->email ?? "N/A" }}
                                                        </td>
                                                        <td class="table-data">
                                                            {{ $value->phone ?? "N/A" }}
                                                        </td>
                                                        <td class="table-data">
                                                            {{ $value->total_orders ?? "N/A" }}
                                                        </td>
                                                        <td class="table-data">
                                                            {{ date('m-d-Y', strtotime($value->last_order_date ?? "N/A" )) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-center align-items-center card-craft-min-height">
                                        <div class="text-center">
                                            <svg width="73" height="69" viewBox="0 0 73 69" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M56.9407 31.3589V37.4381C51.2586 34.5922 44.4894 34.9941 39.184 38.4918V36.208C39.191 33.3874 37.8954 30.721 35.6729 28.9832L35.7105 28.9353C36.8244 25.0685 40.3624 22.186 44.6216 22.186H47.7969C52.8551 22.1941 56.9487 26.3012 56.9407 31.3589Z" fill="#FFCFD1"/>
                                            <path d="M52.354 12.2248V12.2705C52.3534 15.6661 49.6139 18.426 46.2183 18.4513H46.1291C42.6927 18.4529 39.9059 15.6683 39.9043 12.2318V12.2195C39.9054 8.78516 42.6889 6.00107 46.1238 6H46.1318C49.5672 6.00054 52.3523 8.78409 52.354 12.2195V12.2248Z" fill="#FFCFD1"/>
                                            <path d="M39.1839 36.2081V38.4919C36.3397 40.3727 34.0946 43.0288 32.7125 46.1461L32.6716 46.1284H17.6904V36.178C17.699 31.1198 21.8061 27.0261 26.8649 27.0342H30.0396C35.0978 27.0428 39.192 31.1499 39.1839 36.2081Z" fill="#FFCFD1"/>
                                            <path d="M34.6625 17.0097V17.0124C34.6625 20.4478 31.8785 23.233 28.4431 23.2346H28.4377C25.0013 23.2362 22.2145 20.4516 22.2129 17.0151V17.0071C22.2129 13.5717 24.997 10.7865 28.4323 10.7849H28.4404C31.8758 10.7849 34.6609 13.569 34.6625 17.0044V17.0097Z" fill="#FFCFD1"/>
                                            <path d="M21.1641 28.8693L21.2329 28.9585C19.0001 30.6882 17.6922 33.3536 17.6906 36.1779V41.2791H0V31.3288C0.00752303 26.2711 4.1146 22.1775 9.17281 22.186H12.3185C16.4272 22.1936 20.0346 24.9191 21.1641 28.8693Z" fill="#FFCFD1"/>
                                            <path d="M16.9702 12.2195V12.2248C16.946 13.8821 16.2797 15.4651 15.1114 16.6409C13.9556 17.8021 12.3838 18.454 10.7453 18.4513C7.30889 18.4529 4.52212 15.6683 4.52051 12.2318V12.2221C4.52051 8.78731 7.30459 6.00215 10.7394 6H10.748C14.1834 6.00054 16.9686 8.78409 16.9702 12.2195Z" fill="#FFCFD1"/>
                                            <path d="M61.7557 33.8835C69.8274 37.9261 73.5911 47.3735 70.511 55.8584C67.4308 64.344 58.4831 69.177 49.6978 67.1006C40.9129 65.0243 35.0761 56.6967 36.1207 47.7303C37.1653 38.7638 44.7605 32.0011 53.7882 32C56.554 31.9989 59.2827 32.6443 61.7557 33.8835Z" fill="#D71921"/>
                                            <path d="M49.3718 46.1666L52.7048 49.4999L49.3718 52.8331C48.8761 53.329 48.8761 54.1324 49.3718 54.6283C49.6195 54.8761 49.9443 55 50.2689 55C50.594 55 50.9188 54.8762 51.1663 54.6283L54.5 51.2948L57.8334 54.6283C58.0811 54.876 58.4059 55 58.7307 55C59.0555 55 59.3801 54.8762 59.628 54.6283C60.1237 54.1326 60.1237 53.3292 59.628 52.833L56.2952 49.4999L59.6282 46.1666C60.1239 45.6709 60.1239 44.8673 59.6282 44.3715C59.1325 43.8762 58.3294 43.8762 57.8336 44.3715L54.5 47.7048L51.1667 44.3715C50.6708 43.8762 49.8676 43.8762 49.372 44.3715C48.8761 44.8673 48.8761 45.6709 49.3718 46.1666Z" fill="white"/>
                                            <path d="M40.9211 13.0088C40.8868 8.98067 37.6019 5.73929 33.5738 5.75863C29.5462 5.77851 26.2925 9.05214 26.2979 13.0802C26.3032 17.1083 29.565 20.3733 33.5931 20.3819H33.5963V19.2605L33.6022 20.3502C37.6475 20.3373 40.9206 17.054 40.9211 13.0088ZM33.5958 18.1809H33.5931C30.7644 18.1787 28.4731 15.8847 28.4742 13.056C28.4753 10.2279 30.7687 7.9355 33.5974 7.9355C36.4256 7.9355 38.719 10.2279 38.7201 13.056C38.7212 15.8847 36.4299 18.1787 33.6012 18.1809H33.5958Z" fill="#1B1464"/>
                                            <path d="M43.9629 8.23683C43.964 12.2821 47.2408 15.5622 51.2856 15.567H51.3855C55.3711 15.567 58.6136 12.2612 58.6136 8.27499V8.2234C58.6098 4.17812 55.3271 0.901271 51.2813 0.905033C47.2354 0.908794 43.9591 4.19155 43.9629 8.23737V8.23683ZM56.4125 8.22931V8.27499C56.4125 11.0558 54.1502 13.366 51.3774 13.366H51.2856C48.4531 13.3676 46.1553 11.073 46.1532 8.24059C46.1505 5.40815 48.4445 3.10984 51.277 3.10661C54.1099 3.10339 56.4088 5.39686 56.4125 8.22931Z" fill="#1B1464"/>
                                            <path d="M15.9003 15.567H15.903C17.8348 15.5702 19.6876 14.7996 21.0483 13.4283C22.4191 12.0521 23.2009 10.196 23.2283 8.2529C23.2283 8.24592 23.2283 8.23194 23.2283 8.2255C23.2181 4.18452 19.9359 0.915728 15.8949 0.921639C11.8539 0.92755 8.5814 4.20601 8.58301 8.24699C8.58408 12.2885 11.8593 15.5643 15.9003 15.567ZM15.9057 3.10495C18.7295 3.10925 21.0187 5.3952 21.0273 8.21905C21.0069 9.58986 20.4561 10.8994 19.491 11.8726C18.542 12.8296 17.2502 13.367 15.903 13.3659H15.9003C13.0996 13.3186 10.8544 11.0343 10.8555 8.23302C10.8571 5.43174 13.1049 3.14955 15.9057 3.10495Z" fill="#1B1464"/>
                                            <path d="M63.1531 32.7783V27.3655C63.1531 21.7086 58.6145 17.0803 52.9555 17.0803H49.7802C45.6748 17.0981 41.9621 19.5243 40.2979 23.2772C38.7497 22.3744 36.9904 21.8973 35.1983 21.8951H32.0047C30.2185 21.8962 28.4641 22.368 26.9181 23.2627C25.271 19.5162 21.5702 17.0927 17.4771 17.0803H14.3158C8.64283 17.0803 4.03439 21.6608 4 27.3332V37.2836C4.02579 37.9059 4.53522 38.3986 5.15856 38.4029H21.7459V42.1328C21.747 42.423 21.8641 42.7013 22.0716 42.905C22.2785 43.1086 22.5584 43.2215 22.8491 43.2177H36.2687C35.5965 45.1823 35.2563 47.2447 35.2617 49.3211C35.2617 59.7261 43.7268 68.195 54.1318 68.195C64.5363 68.195 72.9997 59.732 72.9997 49.327C72.9954 45.7729 71.9852 42.2924 70.0862 39.288C68.3849 36.549 65.9941 34.3045 63.1531 32.7783ZM49.7802 19.2814H52.9534C55.0872 19.2889 57.1298 20.1454 58.6306 21.6619C60.1315 23.1783 60.9671 25.23 60.952 27.3633V31.7477C58.7655 30.8922 56.4382 30.4548 54.0904 30.4585C51.0688 30.465 48.0924 31.1904 45.4072 32.5758V32.2141C45.4249 29.3371 44.2266 26.5863 42.1077 24.6394C43.3087 21.4367 46.3599 19.3061 49.7802 19.2814ZM6.20104 36.2019V27.3354C6.23436 22.8769 9.85888 19.2803 14.3174 19.2814H17.4755C20.877 19.3002 23.9099 21.4287 25.083 24.6222C22.9518 26.5573 21.7395 29.3038 21.7459 32.1824V36.2019H6.20104ZM23.947 32.184C23.955 27.7314 27.5548 24.1198 32.0069 24.0962H35.1962C36.9915 24.0999 38.7326 24.712 40.1351 25.8324C42.0889 27.3709 43.2228 29.7256 43.2061 32.2125V33.9176C40.616 35.722 38.5391 38.1681 37.1796 41.0167H23.947V32.184ZM54.1318 65.9977C44.9241 65.9977 37.4595 58.5331 37.4595 49.3259C37.4595 40.1182 44.9241 32.6537 54.1318 32.6537C56.7601 32.6537 59.2749 33.3136 61.6049 34.4141C67.2757 37.303 70.7987 42.9797 70.7987 49.3227C70.7987 58.5138 63.3218 65.9977 54.1318 65.9977Z" fill="#1B1464"/>
                                            </svg>
    
                                            <h3 class="cart-craft-text mb-0 mt-3">
                                                You don't have any customers yet.
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="aiz-pagination">
                    {{ $customers->links() }}
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