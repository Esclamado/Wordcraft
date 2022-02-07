@extends('backend.layouts.app')

@section('content')

<div class="col-12">
    <div class="card">
        <form id="sort_stocks" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h1 class="h6">{{ translate('Worldcraft Stocks') }}</h1>
                </div>
                <div class="col-lg-2">
                    <a href="{{ route('pdf.download_worldcraft_report') }}">
                        <svg xmlns="http://www.w3.org/2000/svg"   width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download mr-1">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Download Stocks Report
                    </a>
                </div>
                <div class="col-lg-2">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="filter" onchange="sort_stocks()">
                        <option value="">{{ translate('Filter by') }}</option>
                        <option value="out_of_stocks" @isset($filter) @if ($filter == 'out_of_stocks') selected @endif @endisset>{{translate('Out of Stocks')}}</option>
                        <option value="low_stocks" @isset($filter) @if ($filter == 'low_stocks') selected @endif @endisset>{{translate('Low Stocks')}}</option>
                        <option value="in_stocks" @isset($filter) @if ($filter == 'in_stocks') selected @endif @endisset>{{translate('In Stocks')}}</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" name="search" class="form-control form-control-sm" id="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Search sku id & hit enter') }}">
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
                        <th>{{ translate('SKU ID') }}</th>
                        <th>{{ translate('Pickup Location') }}</th>
                        <th>{{ translate('Stocks') }}</th>
                        <th>{{ translate('Created At') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $key => $value)
                        <tr>
                            <td>{{ ($key + 1) + ($stocks->currentPage() - 1) * $stocks->perPage() }}</td>
                            <td>{{ $value->sku_id }}</td>
                            <td>{{ $value->pickup_location->name ?? 'N/A' }}</td>
                            <td>{{ $value->quantity }}</td>
                            <td>{{ date('Y-m-d', strtotime($value->created_at)) }}</td>
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
