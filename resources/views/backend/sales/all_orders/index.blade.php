@extends('backend.layouts.app')

@section('content')
    @php
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
    @endphp
    <div class="card">
        <form class="" action="" method="GET" id="sortorders">
            <div class="card-header row gutters-5">
                @if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff' && Auth::user()->staff->role->name != 'CMG')
                <div class="col-lg-2">
                    <select select name="delivery_status" id="delivery_status" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Delivery Status') }}</option>
                        <option value="pending" {{ $delivery_status == 'pending' ? 'selected' : '' }}>{{ translate('Order Placed') }}</option>
                        <option value="confirmed" {{ $delivery_status == 'confirmed' ? 'selected' : '' }}>{{ translate('Confirmed') }}</option>
                        <option value="processing" {{ $delivery_status == 'processing' ? 'selected' : '' }}>{{ translate('Processing') }}</option>
                        <option value="partial_release" {{ $delivery_status == 'partial_release' ? 'selected' : '' }}>{{ translate('Partial Release') }}</option>
                        <option value="ready_for_pickup" {{ $delivery_status == 'ready_for_pickup' ? 'selected' : '' }}>{{ translate('Ready for Pickup') }}</option>
                        <option value="picked_up" {{ $delivery_status == 'picked_up' ? 'selected' : '' }}>{{ translate('Picked up') }}</option>
                    </select>
                </div>
                @endif
                <div class="col-lg-2">
                    <select select name="pup_location" id="pup_location" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" data-live-search="true" onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Pickup Location') }}</option>
                        @if (Auth::user()->user_type == 'staff')
                            @foreach (\App\PickupPoint::where('staff_id', 'like', '%' . Auth::user()->staff->id .'%')->where('pick_up_status', 1)->orderBy('name', 'asc')->get(['name']) as $pickup_point)
                                <option value="{{ mb_strtolower(str_replace(' ', '_', $pickup_point->name)) }}" @isset($pup_location) {{ $pup_location == mb_strtolower(str_replace(' ', '_', $pickup_point->name)) ? 'selected' : '' }} @endisset>{{ $pickup_point->name }}</option>
                            @endforeach
                        @else
                            @foreach (\App\PickupPoint::where('pick_up_status', 1)->orderBy('name', 'asc')->get(['name']) as $pickup_point)
                                <option value="{{ mb_strtolower(str_replace(' ', '_', $pickup_point->name)) }}" @isset($pup_location) {{ $pup_location == mb_strtolower(str_replace(' ', '_', $pickup_point->name)) ? 'selected' : '' }} @endisset>{{ $pickup_point->name }}</option>
                            @endforeach
                        @endif
                        
                    </select>
                </div>
                @if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff' && Auth::user()->staff->role->name != 'CMG')
                <div class="col-lg-2">
                    <select select name="payment_status" id="payment_status" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Payment Status') }}</option>
                        <option value="unpaid" @isset($paym_status) {{ $paym_status == 'unpaid' ? 'selected' : '' }} @endisset>Unpaid</option>
                        <option value="paid" @isset($paym_status) {{ $paym_status == 'paid' ? 'selected' : '' }} @endisset>Paid</option>
                    </select>
                </div>
                @endif
                <div class="col-lg-2">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="type" id="type" onchange="sort_orders()">
                        <option value="">{{ translate('Sort By') }}</option>
                        <option value="created_at,asc" @isset($col_name, $query) @if ($col_name == 'created_at' && $query == 'asc') selected @endif @endisset>{{ translate('Created At > ASC') }}</option>
                        <option value="created_at,desc" @isset($col_name, $query) @if ($col_name == 'created_at' && $query == 'desc') selected @endif @endisset>{{ translate('Created At > DESC') }}</option>
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
                        <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off" >
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                    </div>
                </div>

                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0 table-responsive" id="allordersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            {{ translate('Agent Name') }}
                        </th>
                        <th onclick="sortTable(1)" class="c-pointer" width="15%">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Order Code') }}
                        </th>
                        <th onclick="sortTable(2)" class="c-pointer" data-breakpoints="md">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('# of Products') }}
                        </th>
                        <th onclick="sortTable(3)" class="c-pointer" data-breakpoints="md" width="10%">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Customer') }}
                        </th>
                        <th data-breakpoints="md" width="10%">
                            {{ translate('Display Name') }}
                        </th>
                        <th class="c-pointer" data-breakpoints="md" width="10%">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Amount') }}
                        </th>
                        <th onclick="sortTable(5)" class="c-pointer" data-breakpoints="md" width="15%">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Delivery Status') }}
                        </th>
                        <th>
                            {{ translate('Payment Method') }}
                        </th>
                        <th>
                            {{ translate('Pickup Point') }}
                        </th>
                        <th>
                            {{ translate('CR #') }}
                        </th>
                        <th>
                            {{ translate('SOM #') }}
                        </th>
                        <th>
                            {{ translate('S.I. #') }}
                        </th>
                        <th>
                            {{ translate('D.R. #') }}
                        </th>
                        <th onclick="sortTable(10)" class="c-pointer" data-breakpoints="md" width="10%">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Payment Status') }}
                        </th>
                        <th onclick="sortTable(11)" class="c-pointer" data-breakpoints="md" width="10%">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Date') }}
                        </th>
                        {{-- @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                            <th>{{ translate('Refund') }}</th>
                        @endif --}}
                        <th class="text-right" width="5%">{{translate('options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>
                                {{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}
                            </td>
                            <td>
                                @php
                                    $referred_by = \App\User::where('id', $order->referred_by)->first();

                                    if ($referred_by != null) {
                                        echo $referred_by->first_name . ' ' . $referred_by->last_name;
                                    }

                                    else {
                                        echo "N\A";
                                    }
                                @endphp
                            </td>
                            <td>
                                {{ $order->code }}
                            </td>
                            <td>
                                {{ \App\OrderDetail::where('order_id', $order->id)->count() }}
                            </td>
                            <td>
                                {{ $order->first_name }} {{ $order->last_name }}  (<strong>{{ ucfirst($order->user_type) }}</strong>)
                            </td>
                            <td>
                                {{ $order->display_name ?? "N/A" }}
                            </td>
                            <td>
                                {{ single_price($order->grand_total) }}
                            </td>
                            <td>
                                {{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}
                            </td>
                            <td>
                                {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
                            </td>
                            <td>
                                {{ ucfirst(str_replace('_', ' ', $order->pickup_point_location)) }}
                            </td>
                            <td>
                                @if ($order->cr_number != null)
                                    {{ $order->cr_number }}
                                @else 
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($order->som_number != null)
                                    {{ $order->som_number }}
                                @else 
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($order->si_number != null)
                                    {{ $order->si_number }}
                                @else 
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($order->dr_number != null)
                                    {{ $order->dr_number }}
                                @else 
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($order->payment_status == 'paid')
                                    <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                                @else
                                    <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                                @endif
                            </td>
                            {{-- @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                <td>
                                    @if (count($order->refund_requests) > 0)
                                        {{ count($order->refund_requests) }} {{ translate('Refund') }}
                                    @else
                                        {{ translate('No Refund') }}
                                    @endif
                                </td>
                            @endif --}}
                            <td>
                                {{ $order->created_at }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('all_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                                    <i class="las la-eye"></i>
                                </a>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('customer.invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                                    <i class="las la-download"></i>
                                </a>
                                @if (Auth::user()->user_type == 'admin' && $order->payment_status != 'paid')
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

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(){
            $('#sortorders').submit();
        }

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("allordersTable");
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

        const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

        const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
            v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
            )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

        document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
            const table = th.closest('table');
            Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
                .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
                .forEach(tr => table.appendChild(tr) );
        })));

        var $rows = $('#allordersTable tr');
            $('#myInput').keyup(function() {
                var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });

        $("input[name='date']").change(function () {
            sortTable()
        });
    </script>
@endsection
