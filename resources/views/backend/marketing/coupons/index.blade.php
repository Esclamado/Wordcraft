@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('All Coupons')}}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('coupon.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add New Coupon')}}</span>
                </a>
            </div>
        </div>
    </div>


    <div class="card">
        <form action="" id="sort-coupons" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-0 h6">{{ translate('All Coupons') }}</h5>
                </div>
                <div class="col-lg-2">
                    <select name="category_id" id="" class="form-control aiz-selectpicker" data-live-search="true" onchange="sort_coupons()">
                        <option value="">Select Category</option>
                        @foreach (\App\CouponCategory::where('status', 1)->get(['id', 'name']) as $key => $item)
                            <option value="{{ $item->id }}" @isset($category_id) {{ $item->id == $category_id ? 'selected' : '' }} @endisset>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2">
                    <select name="type" id="" class="form-control aiz-selectpicker" onchange="sort_coupons()">
                        <option value="">Select Discount Type</option>
                        <option value="percent" @isset($type) {{ $type == 'percent' ? 'selected' : '' }} @endisset>Percent</option>
                        <option value="amount" @isset($type) {{ $type == 'amount' ? 'selected' : '' }} @endisset>Amount</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Code & hit Enter') }}">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        <div class="card-body overflow-auto">
            <table class="table aiz-table mb-0" id="allCouponsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Code') }}</th>
                        <th>{{ translate('Category') }}</th>
                        <th>{{ translate('Discount Type') }}</th>
                        <th>{{ translate('Description') }}</th>
                        <th>{{ translate('Usage Limit Per User') }}</th>
                        <th>{{ translate('Expiry Date') }}</th>
                        <th>{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $key => $coupon)
                    <tr>
                        <td>
                            {{ ($key+1) + ($coupons->currentPage() - 1) * $coupons->perPage() }}
                        </td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->category->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($coupon->discount_type) }}</td>
                        <td>{{ $coupon->description }}</td>
                        <td>{{ $coupon->usage_limit_user }}</td>
                        <td>{{ date('d-m-Y', $coupon->end_date) }}</td>
                        <td>
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('coupon.edit', encrypt($coupon->id) )}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('coupon.destroy', $coupon->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $coupons->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    
    <script type="text/javascript">

        function sort_coupons() {
            $('#sort-coupons').submit();
        }

        function sortTable(n) {
                    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                    table = document.getElementById("couponTable");
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


