@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Staffs') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('staffs.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Staffs') }}</span>
                </a>
            </div>
        </div>
    </div>

   

    <div class="card">
        <form class="" action="" method="GET" id="sortroles">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Staffs') }}</h5>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <select select name="role" id="role"
                            class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" onchange="sort_roles()">
                            <option value="">{{ translate('Filter by Role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @isset($sort_by_role) @if($sort_by_role == $role->id) selected @endif @endisset>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search" @isset($sort_search)
                            value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Order code & hit Enter') }}">
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
            <table class="table aiz-table mb-0" id="staffTable">
                <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th onclick="sortTable(1)" class="c-pointer">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z" />
                                    <path
                                        d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z" />
                                </svg>
                            </span>
                            {{ translate('Employee ID') }}
                        </th>
                        <th onclick="sortTable(1)" class="c-pointer">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z" />
                                    <path
                                        d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z" />
                                </svg>
                            </span>
                            {{ translate('Name') }}
                        </th>
                        <th onclick="sortTable(2)" class="c-pointer">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z" />
                                    <path
                                        d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z" />
                                </svg>
                            </span>{{ translate('Email') }}
                        </th>
                        <th>{{ translate('Phone') }}</th>
                        <th onclick="sortTable(4)" class="c-pointer">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z" />
                                    <path
                                        d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z" />
                                </svg>
                            </span>{{ translate('Role') }}
                        </th>
                        <th width="16%" class="text-center">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staffs as $key => $staff)
                        @if ($staff->user != null)
                            <tr>
                                <td>{{ $key + 1 + ($staffs->currentPage() - 1) * $staffs->perPage() }}</td>
                                <td>{{ $staff->user->employee_id ?? 'N\A' }}</td>
                                <td>{{ $staff->user->name }}</td>
                                <td>{{ $staff->user->email }}</td>
                                <td>{{ $staff->user->phone }}</td>
                                <td>
                                    @if ($staff->role != null)
                                        {{ $staff->role->getTranslation('name') }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($staff->user->banned != 1)
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                            onclick="confirm_ban('{{ route('staffs.ban', $staff->user->id) }}');"
                                            title="{{ translate('Ban this Customer') }}">
                                            <i class="las la-user-slash"></i>
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                            onclick="confirm_unban('{{ route('staffs.ban', $staff->user->id) }}');"
                                            title="{{ translate('Unban this Customer') }}">
                                            <i class="las la-user-check"></i>
                                        </a>
                                    @endif
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('staffs.edit', encrypt($staff->id)) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('staffs.destroy', $staff->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $staffs->appends(request()->input())->links() }}
            </div>
        </div>
    </div>


    <div class="modal fade" id="confirm-ban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ translate('Do you really want to deactivate this Employee?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a type="button" id="confirmation" class="btn btn-primary">{{ translate('Proceed!') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-unban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ translate('Do you really want to activate this Employee?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a type="button" id="confirmationunban" class="btn btn-primary">{{ translate('Proceed!') }}</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function sort_roles() {
            $('#sortroles').submit();
        }

        function confirm_ban(url) {
            $('#confirm-ban').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('confirmation').setAttribute('href', url);
        }

        function confirm_unban(url) {
            $('#confirm-unban').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('confirmationunban').setAttribute('href', url);
        }

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("staffTable");
            switching = true;

            dir = "asc";

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {

                    shouldSwitch = false;

                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];

                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
@endsection
