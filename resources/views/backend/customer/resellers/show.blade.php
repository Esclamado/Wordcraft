@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <h5 class="mb-0 h6">{{ translate('Profile Information') }}</h5>
            </div>
            <div class="text-right">
                @if ($user->reseller != null)
                    @if ($user->reseller->is_verified != 1)
                        <a href="#" class="btn btn-success confirm-verification" data-href="{{ route('reseller_verify', encrypt($user->id)) }}" title="Verify Reseller">
                            Verify Reseller <i class="las la-check ml-2"></i>
                        </a>
                    @endif
                @endif
            </div>
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
                            {{ translate('TIN #:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ $user->reseller->tin ?? "No data" }}
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('Address:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        {{ $user->address ?? "No data" }}
                    </div>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <div class="col-5 col-md-2">
                        <div class="customer-user-label">
                            {{ translate('IDs:') }}
                        </div>
                    </div>
                    <div class="col-5 col-md-5">
                        <div class="row">
                            <div class="col-3">
                                @foreach ($user->reseller->employmentstatusfiles as $item)
                                    <img src="{{ uploaded_asset($item->img) }}" class="w-100 h-100" alt="">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="mt-4">
                <div class="customer-user-subtitle d-flex align-items-center">
                    <svg class="mr-3" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0)">
                    <path d="M20.1784 4.66649H16.2514V2.36594C16.2514 1.91215 15.8835 1.54431 15.4298 1.54431H5.57025C5.11647 1.54431 4.74862 1.91215 4.74862 2.36594V4.66649H0.821625C0.367842 4.66649 0 5.03433 0 5.48811V18.6341C0 19.0879 0.367842 19.4557 0.821625 19.4557H20.1784C20.6322 19.4557 21 19.0879 21 18.6341C21 11.3709 21 5.85776 21 5.48811C21 5.03433 20.6322 4.66649 20.1784 4.66649ZM6.39187 3.18756H14.6081V4.66649H6.39187V3.18756ZM1.64325 6.30974H19.3568V8.18592L10.5 11.1934L1.64325 8.18592V6.30974ZM1.64325 17.8125V9.92131L10.2358 12.8391C10.4071 12.8973 10.5928 12.8973 10.7642 12.8391L19.3567 9.92131V17.8125H1.64325Z" fill="#D71921"/>
                    </g>
                    <defs>
                    <clipPath id="clip0">
                    <rect width="21" height="21" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>

                    {{ translate('Employment Details') }}
                </div>

                <div class="mt-4">
                    <div class="row d-flex align-items-center mb-2">
                        <div class="col-5 col-md-2">
                            <div class="customer-user-label">
                                {{ translate('Employment Status:') }}
                            </div>
                        </div>
                        <div class="col-5 col-md-10">
                            <div class="customer-user-data">
                                {{ $user->reseller != null ? $user->reseller->employment_status : "N/A" }}
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex align-items-center mb-2">
                        <div class="col-5 col-md-2">
                            <div class="customer-user-label">
                                {{ translate('Telephone Number:') }}
                            </div>
                        </div>
                        <div class="col-7 col-md-10">
                            <div class="customer-user-data">
                                {{ $user->reseller != null ? $user->reseller->telephone_number : "N/A" }}
                            </div>
                        </div>
                    </div>

                    @php
                        $employment_status = $user->reseller != null ? $user->reseller->employment_status : "N/A";
                    @endphp

                    @if ($employment_status == 'Employed')
                        @include('backend.customer.partials.employed')
                    @elseif ($employment_status == 'Freelancer')
                        @include('backend.customer.partials.freelancer')
                    @elseif ($employment_status == 'Business')
                        @include('backend.customer.partials.business')
                    @endif

                    @foreach ($reseller_uploaded_files as $key => $value)
                        <div class="row d-flex align-items-center mb-2">
                            <div class="col-5 col-md-2">
                                <div class="customer-user-label">
                                    <span class="text-capitalize">
                                        {{ ucfirst(str_replace('_', ' ', $value->img_type ?? "N/A" )) }}:
                                    </span>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="customer-user-data">
                                    <a href="{{ uploaded_asset($value->img ?? "N/A") }}" class="text-primary" target="_blank">
                                        {{ str_replace('uploads/all/', '', uploaded_asset_name($value->img ?? "N/A")) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr>

            <div class="mt-4">
                <div class="customer-user-subtitle d-flex align-items-center">
                    <svg class="mr-3" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0)">
                    <path d="M20.1784 4.66649H16.2514V2.36594C16.2514 1.91215 15.8835 1.54431 15.4298 1.54431H5.57025C5.11647 1.54431 4.74862 1.91215 4.74862 2.36594V4.66649H0.821625C0.367842 4.66649 0 5.03433 0 5.48811V18.6341C0 19.0879 0.367842 19.4557 0.821625 19.4557H20.1784C20.6322 19.4557 21 19.0879 21 18.6341C21 11.3709 21 5.85776 21 5.48811C21 5.03433 20.6322 4.66649 20.1784 4.66649ZM6.39187 3.18756H14.6081V4.66649H6.39187V3.18756ZM1.64325 6.30974H19.3568V8.18592L10.5 11.1934L1.64325 8.18592V6.30974ZM1.64325 17.8125V9.92131L10.2358 12.8391C10.4071 12.8973 10.5928 12.8973 10.7642 12.8391L19.3567 9.92131V17.8125H1.64325Z" fill="#D71921"/>
                    </g>
                    <defs>
                    <clipPath id="clip0">
                    <rect width="21" height="21" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>

                    {{ translate('Agent Info') }}
                </div>

                @php
                    $employee = \App\User::where('id', $user->referred_by)
                        ->select('name', 'employee_id', 'id', 'email')
                        ->first();
                @endphp

                <div class="mt-4">
                    <div class="row d-flex align-items-center mb-2">
                        <div class="col-5 col-md-2">
                            <div class="customer-user-label">
                                {{ translate('Name:') }}
                            </div>
                        </div>
                        <div class="col-5 col-md-8">
                            <div class="customer-user-data">
                                {{ $employee->name ?? "N/A" }}
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <div class="col-5 col-md-2">
                            <div class="customer-user-label">
                                {{ translate('Employee ID:') }}
                            </div>
                        </div>
                        <div class="col-5 col-md-8">
                            <div class="customer-user-data">
                                {{ $employee->employee_id ?? "N/A" }}
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <div class="col-5 col-md-2">
                            <div class="customer-user-label">
                                {{ translate('Email:') }}
                            </div>
                        </div>
                        <div class="col-5 col-md-8">
                            <div class="customer-user-data">
                                {{ $employee->email ?? "N/A" }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="" method="GET" id="sort_customers">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-0 h6">{{ translate('Reseller Customers') }}</h5>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Name & hit Enter') }}">
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Customer') }}</th>
                        <th>{{ translate('Email') }}</th>
                        <th>{{ translate('Mobile') }}</th>
                        <th>{{ translate('Total Orders') }}</th>
                        <th>{{ translate('Last Order') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $key => $customer)
                        <tr>
                            <td>
                                {{ ($key + 1) + ($customers->currentPage() - 1) * $customers->perPage() }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-2">
                                        @if ($customer->avatar_original != null)
                                            <img src="{{ uploaded_asset($customer->avatar_original ?? "N/A") }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                        @else
                                            <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                        @endif
                                    </div>
                                    <div>
                                        {{ $customer->name ?? "N/A" }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $customer->email ?? "N/A" }}
                            </td>
                            <td>
                                {{ $customer->phone ?? "N/A" }}
                            </td>
                            <td>
                                {{ $customer->total_orders ?? "N/A" }}
                            </td>
                            <td>
                                {{ date('m-d-Y', strtotime($customer->last_order_date ?? "N/A" )) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div id="verify-reseller" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Reseller Confirmation') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">
                        {{ translate('Are you sure you want to verify ') . $user->name }}
                    </p>
                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a href="" id="verify-reseller-link" class="btn btn-primary mt-2">{{ translate('Verify') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
