@extends('backend.layouts.app')

@section('content')

    <div class="card">
        <form class="" action="" method="GET" id="sort_resellers">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-0 h6">{{ translate('All Employees') }}</h5>
                </div>

                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Employee Name & hit Enter') }}">
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
            <table class="table aiz-table mb-0" id="all_resellers_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Employee ID</th>
                        <th>{{ translate('Referral Code') }}</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Username') }}</th>
                        <th>{{ translate('Phone') }}</th>
                        <th>{{ translate('Email Address') }}</th>
                        <th>{{ translate('User Status') }}</th>
                        <th>{{ translate('Registered At') }}</th>
                        <th>{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $key => $employee)
                        <tr>
                            <td>
                                {{ ($key + 1) + ($employees->currentPage() - 1) * $employees->perPage() }}
                            </td>
                            <td>{{ $employee->unique_id ?? 'N/A' }}</td>
                            <td>{{ $employee->employee_id }}</td>
                            <td>{{ $employee->referral_code }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->username }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @if ($employee->banned != 0)
                                    <span class="badge badge-danger w-auto">
                                        Banned
                                    </span>
                                @else
                                    <span class="badge badge-success w-auto">
                                        Open
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ date('Y-m-d', strtotime($employee->created_at)) }}
                            </td>
                            <td>
                                <a href="{{route('employee_user_show', encrypt($employee->id))}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate("View Profile") }}">
                                    <i class="las la-user-circle"></i>
                                </a>
                                <a href="{{route('user.login.admin', encrypt($employee->id))}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate("Login as ") . $employee->name }}">
                                    <i class="las la-sign-in-alt"></i>
                                </a>
                                @if($employee->banned != 1)
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm" onclick="confirm_ban('{{route('customers.ban', $employee->id)}}');" title="{{ translate('Ban this employee') }}">
                                        <i class="las la-user-slash"></i>
                                    </a>
                                @else
                                    <a href="#" class="btn btn-soft-success btn-icon btn-circle btn-sm" onclick="confirm_unban('{{route('customers.ban', $employee->id)}}');" title="{{ translate('Unban this employee') }}">
                                        <i class="las la-user-check"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $employees->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-ban">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{translate('Do you really want to ban this employee?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <a type="button" id="confirmation" class="btn btn-primary">{{translate('Proceed!')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-unban">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{translate('Do you really want to un-ban this employee?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <a type="button" id="confirmationunban" class="btn btn-primary">{{translate('Proceed!')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function confirm_ban(url)
        {
            $('#confirm-ban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmation').setAttribute('href' , url);
        }

        function confirm_unban(url)
        {
            $('#confirm-unban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmationunban').setAttribute('href' , url);
        }
    </script>
@endsection
