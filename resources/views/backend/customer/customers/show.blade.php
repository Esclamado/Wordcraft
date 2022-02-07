@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Profile Information') }}</h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="mr-4">
                    @if ($user->avatar_original != null)
                        <img src="{{ uploaded_asset($user->avatar_original ?? "N/A") }}" class="image rounded-circle customer-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    @else
                        <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle customer-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    @endif
                </div>
                <div class="customer-user-name">
                    {{ $user->name ?? "N/A" }}
                </div>
            </div>

            {{-- // User Info --}}
            <div class="mt-4">
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Referred By:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        @if ($user->referred_by != null)
                            {{ \App\User::where('id', $user->referred_by)->first()->name ?? 'N/A' }}
                        @endif
                    </div>
                </div>
                @if ($user->company_name != null)
                    <div class="row d-flex align-items-center mb-2">
                        <div class="col-5 col-md-2">
                            <div class="customer-user-label">
                                {{ translate('Company Name:') }}
                            </div>
                        </div>
                        <div class="col-5 col-md-5">
                            {{ $user->company_name ?? 'N/A' }}
                        </div>
                    </div>
                @endif
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Username:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ $user->username ?? 'N/A' }}
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Email:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ $user->email ?? 'N/A' }}
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Email Verified At:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ date('Y-m-d', strtotime($user->email_verified_at)) }}
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Phone:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ $user->phone ?? 'N/A' }}
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Balance:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ single_price($user->balance) }}
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('User Status:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        @if ($user->banned != 0) 
                            <span class="badge badge-danger w-auto">
                                Banned
                            </span>
                        @else
                            <span class="badge badge-success w-auto">
                                Open
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Full Address:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ $user->address ?? "No Info" }}
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Tin No.:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ $user->tin_no ?? "No Info" }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="" method="GET" id="sort_orders">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Orders') }}</h5>
                </div>

                <div class="col-lg-2">
                    <select select name="payment_status" id="payment_status" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Payment Status') }}</option>
                        <option value="unpaid" @isset($paym_status) {{ $paym_status == 'unpaid' ? 'selected' : '' }} @endisset>Unpaid</option>
                        <option value="paid" @isset($paym_status) {{ $paym_status == 'paid' ? 'selected' : '' }} @endisset>Paid</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="type" id="type" onchange="sort_orders()">
                        <option value="">{{ translate('Sort By') }}</option>
                        <option value="code,asc" @isset($col_name , $query) @if($col_name == 'code' && $query == 'asc') selected @endif @endisset>{{translate('Order code > ASC')}}</option>
                        <option value="code,desc" @isset($col_name , $query) @if($col_name == 'code' && $query == 'desc') selected @endif @endisset>{{translate('Order code < DESC')}}</option>
                        <option value="orderDetails,asc" @isset($col_name, $query) @if ($col_name == 'orderDetails' && $query == 'asc') selected @endif @endisset>{{ translate('No. of products (Low > High)') }}</option>
                        <option value="orderDetails,desc" @isset($col_name , $query) @if($col_name == 'orderDetails' && $query == 'desc') selected @endif @endisset>{{translate('No. of products (High > Low)')}}</option> --}}
                        <option value="grand_total,asc"@isset($col_name , $query) @if($col_name == 'grand_total' && $query == 'asc') selected @endif @endisset>{{translate('Total amount (Low > High)')}}</option>
                        <option value="grand_total,desc"@isset($col_name , $query) @if($col_name == 'grand_total' && $query == 'desc') selected @endif @endisset>{{translate('Total amount (High > Low)')}}</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                    </div>
                </div>
               
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                    </div>
                </div>
            </div>
        </form>
        
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Order Code') }}</th>
                        <th>{{ translate('Num. of Products') }}</th>
                        <th>{{ translate('Amount') }}</th>
                        <th>{{ translate('Delivery Status') }}</th>
                        <th>{{ translate('Payment Status') }}</th>
                        <th>{{ translate('Date') }}</th>
                        <th>{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>
                                {{ ($key + 1) + ($orders->currentPage() - 1) * $orders->perPage() }}
                            </td>
                            <td>{{ $order->code ?? 'N/A' }}</td>
                            <td>
                                {{ \App\OrderDetail::where('order_id', $order->id)->count() }}
                            </td>
                            <td>{{ single_price($order->grand_total ?? 'N/A') }}</td>
                            <td>
                                {{ ucfirst(str_replace('_', ' ', $order->delivery_status ?? 'N/A')) }}
                            </td>
                            <td>
                                @if ($order->payment_status == 'paid')
                                    <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                                @else
                                    <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                                @endif
                            </td>
                            <td>
                                {{ $order->created_at }}
                            </td>
                            <td>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('all_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                                    <i class="las la-eye"></i>
                                </a>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('customer.invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                                    <i class="las la-download"></i>
                                </a>
                                @if ($order->payment_status != 'paid')
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>                        
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $orders->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders () {
            $('#sort_orders').submit();
        }
    </script>
@endsection