@extends('backend.layouts.app')

@section('content')
    
<div class="col-12">
    <div class="card">
        <form id="sort_stocks" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h1 class="h6">{{ translate('Worldcraft Stock Syncing Report') }}</h1>
                </div>
                <div class="col-md-2 ml-auto">
                    <select name="pickup_point_filter" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" onchange="sort_stocks()">
                        <option value="">Select Pickup Point</option>
                        @foreach ($pickup_points as $key => $value)
                            <option value="{{ $key }}" @isset($pickup_point_filter) {{ $pickup_point_filter == $key ? 'selected' : '' }} @endisset>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 ml-auto">
                    <select name="change_type" id="change_type" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" onchange="sort_stocks()">
                        <option value="">Select Change Type</option>
                        <option value="add" @isset($change_type) {{ $change_type == 'add' ? 'selected' : '' }} @endisset>Add</option>
                        <option value="remove" @isset($change_type) {{ $change_type =='remove' ? 'selected' : '' }} @endisset>Remove</option>
                    </select>
                </div>
                <div class="col-md-2 ml-auto">
                    <select name="type" id="type" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" onchange="sort_stocks()">
                        <option value="">Select Type</option>
                        <option value="walk_in" @isset($type) {{ $type == 'walk_in' ? 'selected' : '' }} @endisset>Walk In</option>
                        <option value="transfer" @isset($type) {{ $type == 'transfer' ? 'selected' : '' }} @endisset>Transfer</option>
                        <option value="other" @isset($type) {{ $type == 'other' ? 'selected' : '' }} @endisset>Other</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off" onchange="sort_stocks()">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" name="search" class="form-control form-control-sm" id="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Search Pickup Point Location or SKU ID & hit enter') }}">
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
                        <th>{{ translate('Pickup Point Location') }}</th>
                        <th>{{ translate('SKU ID') }}</th>
                        <th>{{ translate('Change Type') }}</th>
                        <th>{{ translate('Quantity') }}</th>
                        <th>{{ translate('Type') }}</th>
                        <th>{{ translate('Remarks') }}</th>
                        <th>{{ translate('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $key => $value)
                        <tr>
                            <td>{{ ($key + 1)  + ($stocks->currentPage() - 1) * $stocks->perPage() }}</td>
                            <td>{{ $value->pickup_point->name ?? "N/A" }}</td>
                            <td>{{ $value->sku_id }}</td>
                            <td>{{ ucfirst($value->change_type) }}</td>
                            <td>{{ $value->quantity }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $value->type)) }}</td>
                            <td>{!! $value->remarks ?? 'N/A' !!}</td>
                            <td>{{ date('Y-m-d @ H:i:s a', strtotime($value->created_at)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination mt-4">
                {{ $stocks->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        function sort_stocks() {
            $('#sort_stocks').submit();
        }
    </script>
@endsection