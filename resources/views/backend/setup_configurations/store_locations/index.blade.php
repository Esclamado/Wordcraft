@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebard text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Store Locations') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('store-locations.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Store Location') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Store Locations') }}</h5>
            </div>
            <div class="col-md-4">
                <form action="" id="sort_store_locations" method="GET">
                    <div class="input-group input-group-sm">
                        <input type="text" id="search" name="search" @isset ($sort_search) value="{{ $sort_search }}" @endisset class="form-control" placeholder="{{ translate('Type name & enter') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body overflow-auto">
            <table class="table aiz-table mb-0" id="storelocationTable">
                <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th onclick="sortTable(1)" class="c-pointer">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Island') }}
                        </th>
                        <th onclick="sortTable(2)" class="c-pointer">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Name') }}
                        </th>
                        <th onclick="sortTable(3)" class="c-pointer">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Address') }}
                        </th>
                        <th>{{ translate('Phone Number') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th width="10%" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($store_locations as $key => $location)
                        <tr>
                            <td>{{ ($key + 1) + ($store_locations->currentPage() - 1) * $store_locations->perPage() }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $location->island_name)) }}</td>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->address }}</td>
                            <td>{{ $location->phone_number }}</td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="update_status(this)" value="{{ $location->id }}" @if ($location->status == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('store-locations.edit', $location->id) }}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('store-locations.delete', $location->id) }}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="pull-right">
                    {{ $store_locations->appends(request()->input())->links() }}
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
        function update_status (el) {
            if (el.checked) {
                var status = 1;
            }

            else {
                var status = 0;
            }

            $.post('{{ route('store-locations.update_status') }}', { _token: '{{ csrf_token() }}', id: el.value, status: status }, function (data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Store location status updated successfully') }}');
                }

                else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("storelocationTable");
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
                shouldSwitch= true;
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
            switchcount ++;      
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
