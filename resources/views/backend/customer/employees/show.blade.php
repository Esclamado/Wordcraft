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

            <div class="mt-4">
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
            </div>
        </div>
    </div>

    <div class="card">
        <form action="" method="GET" id="sort_resellers">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="md-0 h6">{{ translate('Employee Resellers') }}</h5>
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
                        <th>{{ translate('Reseller') }}</th>
                        <th>{{ translate('Date Joined') }}</th>
                        <th>{{ translate('Total Succesful Orders') }}</th>
                        <th>{{ translate('Earnings') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resellers as $key => $reseller)
                        <tr>
                            <td>{{ ($key + 1) + ($resellers->currentPage() - 1) * $resellers->perPage() }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-2">
                                        @if ($reseller->reseller != null)
                                            @if ($reseller->reseller->avatar_original != null)
                                                <img src="{{ uploaded_asset($reseller->reseller->avatar_original ?? "N/A" ) }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                            @else
                                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle table-user-image" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                            @endif
                                        @endif
                                    </div>
                                    <div>
                                        {{ $reseller->reseller->name ?? "N/A" }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ date('m-d-Y', strtotime($reseller->reseller->date_joined ?? "N/A" )) }}
                            </td>
                            <td>
                                {{ $reseller->reseller != null ? $reseller->reseller->total_successful_orders : "N/A" }}
                            </td>
                            <td>
                                {{ $reseller->reseller != null ? single_price($reseller->reseller->total_earnings) : "N/A" }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $resellers->links() }}
            </div>
        </div>
    </div>
@endsection
