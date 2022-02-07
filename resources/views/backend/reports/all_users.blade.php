@extends('backend.layouts.app')

@section('content')

<div class="col-12">
    <div class="card">
        <form class="" action="" method="GET" id="sortusers">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h1 class="h6">{{ translate('All Users') }}</h1>
                </div>
                <div class="col-md-2 ml-auto">
                    <select name="user_type" id="user_type" class="form-control form-control-sm aiz-selectpicker mb-2.mb-md-0" onchange="sort_users()">
                        <option value="">Select User Type</option>
                        <option value="customer" @isset($user_type) {{ $user_type == 'customer' ? 'selected' : '' }} @endisset>Customer</option>
                        <option value="reseller" @isset($user_type) {{ $user_type == 'reseller' ? 'selected' : '' }} @endisset>Reseller</option>
                        @foreach (\App\Role::get(['name']) as $key => $value)
                            <option value="{{ mb_strtolower($value->name) }}" @isset($user_type) {{ $user_type == mb_strtolower($value->name) ? 'selected' : '' }} @endisset>{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" class="aiz-date-range form-control" @isset($date) value="{{ $date }}" @endisset name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off" onchange="sort_users()">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" name="search" class="form-control form-control-sm" id="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate("Search for name, username, email or phone number & hit enter") }}">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body overflow-auto">
            <table class="table table-bordered aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <td>{{ translate('User Type') }}</td>
                        <td>{{ translate('Name') }}</td>
                        <td>{{ translate('Username') }}</td>
                        <td>{{ translate('Email') }}</td>
                        <td>{{ translate('Phone') }}</td>
                        <td>{{ translate('Date Registered') }}</td>
                        <td>{{ translate('Options') }}</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $value)
                        <tr>
                            <td>{{ ($key + 1) + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $value->user_type)) }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->username }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ date('Y-m-d', strtotime($value->created_at)) }}</td>
                            <td>
                                @if ($value->user_type != 'admin')
                                    <a href="{{route('user.login.admin', encrypt($value->id))}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate("Login as ") . $value->name }}">
                                        <i class="las la-sign-in-alt"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination mt-3">
                {{ $users->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        function sort_users(){
            $('#sortusers').submit();
        }
    </script>
@endsection
