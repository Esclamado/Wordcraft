@extends('backend.layouts.app')

@section('content')

@php
    if ($date != null) {
        $start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
        $end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();
    }
@endphp

<div class="card">
    <form class="" action="" method="GET" id="sortorders">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Revenue') }}</h5>
            </div>

            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
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
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="gross-sales" onclick="toggleNav('gross-sales')">
                    <p class="text-title-thin text-uppercase">Gross Sales</p>
                    <div>
                        @php
                            $order = 0;

                            if ($date != null) {
                                $order = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                    ->sum('grand_total');
                            }
                            
                            else {
                                $order = \App\Order::sum('grand_total');
                            }
                        @endphp
                        <span class="fw-600 fs-18">{{ single_price($order) }}</span>
                    </div>
                </div>
                <div>
                    <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="taxes" onclick="toggleNav('taxes')">
                        <p class="text-title-thin text-uppercase">Taxes</p>
                        <div>
                            @php
                                $taxes = 0;
                                
                                if ($date != null) {
                                    $taxes = \App\OrderDetail::whereBetween('created_at', [$start_date, $end_date])
                                        ->sum('tax');
                                }
                                 
                                else {
                                    $taxes = \App\OrderDetail::sum('tax');
                                }
                            @endphp
                            <span class="fw-600 fs-18">{{ single_price($taxes) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="returns" onclick="toggleNav('returns')">
                    <p class="text-title-thin text-uppercase">Returns</p>
                    <div>
                        @php
                            $retursn = 0;

                            if ($date != null) {
                                $returns = \App\RefundRequest::whereBetween('created_at', [$start_date, $end_date])
                                    ->sum('refund_amount');
                            }

                            else {
                                $returns = \App\RefundRequest::sum('refund_amount');
                            }
                        @endphp
                        <span class="fw-600 fs-18">{{ single_price($returns) }}</span>
                    </div>
                </div>
                <div>
                    <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="shipping" onclick="toggleNav('shipping')">
                        <p class="text-title-thin text-uppercase">Shipping</p>
                        <div>
                            @php
                                $shipping = 0;

                                if ($date != null) {
                                    $shipping = \App\OrderDetail::whereBetween('created_at', [$start_date, $end_date])
                                        ->sum('shipping_cost');
                                }

                                else {
                                    $shipping = \App\OrderDetail::sum('shipping_cost');
                                }
                            @endphp
                            <span class="fw-600 fs-18">{{ single_price($shipping) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div>
                    <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="coupon" onclick="toggleNav('coupon')">
                        <p class="text-title-thin text-uppercase">Coupons</p>
                        <div>
                            @php
                                $coupons = 0;

                                if ($date != null) {
                                    $coupons = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                        ->sum('coupon_discount');
                                }

                                else {
                                    $coupons = \App\Order::sum('coupon_discount');
                                }
                            @endphp
                            <span class="fw-600 fs-18">{{ single_price($coupons) }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="total-sales" onclick="toggleNav('total-sales')">
                            <p class="text-title-thin text-uppercase">Total Sales</p>
                            <div>
                                @php
                                    $total_sales = 0;

                                    if ($date != null) {
                                        $total_sales = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                            ->where('payment_status', 'paid')
                                            ->sum('grand_total');
                                    }

                                    else {
                                        $total_sales = \App\Order::where('payment_status', 'paid')
                                            ->sum('grand_total');
                                    }
                                    
                                @endphp
                                <span class="fw-600 fs-18">{{ single_price($total_sales) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="netsales" onclick="toggleNav('netsales')">
                    <p class="text-title-thin text-uppercase">Net Sales</p>
                    <div>
                        @php
                            $net_sales = 0;
                            $returns_total = 0;
                            $taxes_total = 0;

                            if ($date != null) {
                                $taxes_total = \App\OrderDetail::whereBetween('created_at', [$start_date, $end_date])
                                    ->where('payment_status', 'paid')
                                    ->sum('tax');

                                $returns_total = \App\RefundRequest::whereBetween('created_at', [$start_date, $end_date])
                                    ->sum('refund_amount');

                                $net_sales = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                    ->where('payment_status', 'paid')
                                    ->sum('grand_total');

                                $net_sales = $net_sales - $returns_total - $taxes_total;
                            }

                            else {
                                $taxes_total = \App\OrderDetail::where('payment_status', 'paid')
                                    ->sum('tax');

                                $returns_total = \App\RefundRequest::sum('refund_amount');

                                $net_sales = \App\Order::where('payment_status', 'paid')
                                    ->sum('grand_total');

                                $net_sales = $net_sales - $returns_total - $taxes_total;
                            }
                        @endphp
                        <span class="fw-600 fs-18">{{ single_price($net_sales) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="gross-sale-content">
            <div class="card-header">
                 <span class="fw-600">
                     Gross Sale
                 </span>
            </div>
             <div class="card-body overflow-auto">
                 <canvas id="grossSaleChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                 </canvas>
             </div>
        </div>

        <div class="card" id="total-sale-content">
            <div class="card-header">
                 <span class="fw-600">
                     Total Sale
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="totalsaleChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>

        <div class="card" id="returns-content">
            <div class="card-header">
                 <span class="fw-600">
                     Returns
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="returnChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>

        <div class="card" id="taxes-content">
            <div class="card-header">
                 <span class="fw-600">
                     Taxes
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="taxChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>

        <div class="card" id="coupon-content">
            <div class="card-header">
                 <span class="fw-600">
                     Coupon
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="couponChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>

        <div class="card" id="shipping-content">
            <div class="card-header">
                 <span class="fw-600">
                     Shipping
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="shippingChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>

        <div class="card" id="netsales-content">
            <div class="card-header">
                 <span class="fw-600">
                     Net Sales
                 </span>
            </div>
             <div class="card-body overflow-auto">
                 <canvas id="netsaleChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span class="fw-600">
                    Revenue
                </span>
                <div class="float-right">
                    <div>
                        <span>
                            <a href="{{ route('pdf.download_revenue') }}">
                                <svg xmlns="http://www.w3.org/2000/svg"   width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download mr-1">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Download Revenue Table
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body overflow-auto">
                <table class="table aiz-table mb-0" id="allordersTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Orders</th>
                            <th>Gross Sales</th>
                            <th>Returns</th>
                            <th>Coupons</th>
                            <th>Net Sales</th>
                            <th>Taxes</th>
                            <th>Shipping</th>
                            <th>Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($date != null)
                            @foreach ($period as $date_period_table)
                                @php 
                                    $date_day = date('d', strtotime($date_period_table));
                                    $month = date('m', strtotime($date_period_table));
                                    $year = date('Y', strtotime($date_period_table));
                                @endphp
                                <tr>
                                    {{-- Date --}}
                                    <td>{{ date('F d, Y', strtotime($date_period_table)) }}</td>
                                    {{-- Orders --}}
                                    <td>
                                        @php
                                            $orders = \App\Order::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->count();
                                        @endphp

                                        {{ $orders }}
                                    </td>
                                    {{-- Gross Sales --}}
                                    <td>
                                        @php
                                            $gross_sales_table = \App\Order::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('grand_total');
                                        @endphp

                                        {{ single_price($gross_sales_table) }}
                                    </td>
                                    {{-- Returns --}}
                                    <td>
                                        @php
                                            $returns_table = \App\RefundRequest::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('refund_amount');
                                        @endphp

                                        {{ single_price($returns_table) }}
                                    </td>
                                    {{-- Coupons --}}
                                    <td>
                                        @php
                                            $coupons = \App\Order::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('coupon_discount');
                                        @endphp

                                        {{ single_price($coupons) }}
                                    </td>
                                    {{-- Net Sales --}}
                                    <td>
                                        @php
                                            $net_sales = 0;
                                            $taxes_data = 0;

                                            $taxes_data = (($taxes_data + $gross_sales_table) - $returns_table) / 1.12 * .12;
                                            $net_sales = ($net_sales + $gross_sales_table) - $returns_table - $taxes_data;
                                        @endphp

                                        {{ single_price($net_sales) }}
                                    </td>
                                    {{-- Taxes --}}
                                    <td>
                                        {{ single_price($taxes_data) }}
                                    </td>
                                    {{-- Shipping --}}
                                    <td>
                                        @php
                                            $shipping_costs_data = \App\OrderDetail::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('shipping_cost');
                                        @endphp

                                        {{ single_price($shipping_costs_data) }}
                                    </td>
                                    {{-- Total Sales --}}
                                    <td>
                                        @php
                                            $total_sales_data = \App\Order::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('grand_total');
                                        @endphp

                                        {{ single_price($total_sales_data) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            @foreach ($days as $key => $date_day)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $month = \Carbon\Carbon::parse($now)->format('m');
                                    $year = \Carbon\Carbon::parse($now)->format('Y');
                                @endphp

                                <tr>
                                    {{-- Date --}}
                                    <td>{{ $current_month }} {{ $date_day }}, {{ \Carbon\Carbon::now()->year }}</td>
                                    {{-- Orders --}}
                                    <td>
                                        @php
                                            $orders = \App\Order::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->count();
                                        @endphp

                                        {{ $orders }}
                                    </td>
                                    {{-- Gross Sales --}}
                                    <td>
                                        @php
                                            $gross_sales_table = \App\Order::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('grand_total');
                                        @endphp

                                        {{ single_price($gross_sales_table) }}
                                    </td>
                                    {{-- Returns --}}
                                    <td>
                                        @php
                                            $returns_table = \App\RefundRequest::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('refund_amount');
                                        @endphp

                                        {{ single_price($returns_table) }}
                                    </td>
                                    {{-- Coupons --}}
                                    <td>
                                        @php
                                            $coupons = \App\Order::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('coupon_discount');
                                        @endphp

                                        {{ single_price($coupons) }}
                                    </td>
                                    {{-- Net Sales --}}
                                    <td>
                                        @php
                                            $net_sales = 0;
                                            $taxes_data = 0;

                                            $taxes_data = (($taxes_data + $gross_sales_table) - $returns_table) / 1.12 * .12;
                                            $net_sales = ($net_sales + $gross_sales_table) - $returns_table - $taxes_data;
                                        @endphp

                                        {{ single_price($net_sales) }}
                                    </td>
                                    {{-- Taxes --}}
                                    <td>
                                        {{ single_price($taxes_data) }}
                                    </td>
                                    {{-- Shipping --}}
                                    <td>
                                        @php
                                            $shipping_costs_data = \App\OrderDetail::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('shipping_cost');
                                        @endphp

                                        {{ single_price($shipping_costs_data) }}
                                    </td>
                                    {{-- Total sales --}}
                                    <td>
                                        @php
                                            $total_sales_data = \App\Order::whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('grand_total');
                                        @endphp

                                        {{ single_price($total_sales_data) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="aiz-pagination">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
    <script type="text/javascript">

        var net_labels = new Array();
        var gross_sales = new Array();
        var returns_data = new Array();
        var coupons_data = new Array();
        var nets_sales = new Array();
        var total_taxes = new Array();
        var total_shipping = new Array();
        var total_sales = new Array();

        @if ($date != null) 
            @php 
                $sorted_by_date_gross_sales = [];
                $sorted_by_date_returns_data = [];
                $sorted_by_date_coupons_data = [];
                $sorted_by_date_nets_sales = [];
                $sorted_by_date_total_taxes = [];
                $sorted_by_date_total_shipping = [];
                $sorted_by_date_total_sales = [];
            @endphp

            @foreach ($period as $date_period)
                net_labels.push("{{ date('F d, Y', strtotime($date_period)) }}")

                @php
                    $sorted_by_date_gross_sales[] = \App\Order::whereDay('created_at', date('d', strtotime($date_period)))
                        ->whereMonth('created_at', date('m', strtotime($date_period)))
                        ->whereYear('created_at', date('Y', strtotime($date_period)))
                        ->sum('grand_total');

                    $sorted_by_date_returns_data[] = \App\RefundRequest::whereDay('created_at', date('d', strtotime($date_period)))
                        ->whereMonth('created_at', date('m', strtotime($date_period)))
                        ->whereYear('created_at', date('Y', strtotime($date_period)))
                        ->sum('refund_amount');

                    $sorted_by_date_coupons_data[] = \App\Order::whereDay('created_at', date('d', strtotime($date_period)))
                        ->whereMonth('created_at', date('m', strtotime($date_period)))
                        ->whereYear('created_at', date('Y', strtotime($date_period)))
                        ->sum('coupon_discount');

                    $sorted_by_date_nets_sales[] = \App\Order::where('payment_status', 'paid')
                        ->whereDay('created_at', date('d', strtotime($date_period)))
                        ->whereMonth('created_at', date('m', strtotime($date_period)))
                        ->whereYear('created_at', date('Y', strtotime($date_period)))
                        ->sum('grand_total');

                    $sorted_by_date_total_taxes[] = \App\OrderDetail::whereDay('created_at', date('d', strtotime($date_period)))
                        ->whereMonth('created_at', date('m', strtotime($date_period)))
                        ->whereYear('created_at', date('Y', strtotime($date_period)))
                        ->sum('tax');

                    $sorted_by_date_total_shipping[] = \App\OrderDetail::whereDay('created_at', date('d', strtotime($date_period)))
                        ->whereMonth('created_at', date('m', strtotime($date_period)))
                        ->whereYear('created_at', date('Y', strtotime($date_period)))
                        ->sum('shipping_cost');

                    $sorted_by_date_total_sales[] = \App\Order::where('payment_status', 'paid')
                        ->whereDay('created_at', date('d', strtotime($date_period)))
                        ->whereMonth('created_at', date('m', strtotime($date_period)))
                        ->whereYear('created_at', date('Y', strtotime($date_period)))
                        ->sum('grand_total');
                @endphp
            @endforeach

            @foreach ($sorted_by_date_gross_sales as $date_gross_sales)
                gross_sales.push("{{ $date_gross_sales }}")
            @endforeach

            @foreach ($sorted_by_date_returns_data as $date_returns_data)
                returns_data.push("{{ $date_returns_data }}")
            @endforeach

            @foreach ($sorted_by_date_coupons_data as $date_coupons_data)
                coupons_data.push("{{ $date_coupons_data }}")
            @endforeach

            @foreach ($sorted_by_date_nets_sales as $date_nets_sales)
                nets_sales.push("{{ $date_nets_sales }}")
            @endforeach

            @foreach ($sorted_by_date_total_taxes as $date_total_taxes)
                total_taxes.push("{{ $date_total_taxes }}")
            @endforeach

            @foreach ($sorted_by_date_total_shipping as $date_total_shipping)
                total_shipping.push("{{ $date_total_shipping }}")
            @endforeach

            @foreach ($sorted_by_date_total_sales as $date_total_sales)
                total_sales.push("{{ $date_total_sales }}")
            @endforeach
        @else
            @foreach ($days as $key => $value)
                net_labels.push("{{ $current_month }} {{ $value }}")
            @endforeach

            @foreach ($gross_sales as $key => $gross)
                gross_sales.push("{{ $gross }}")
            @endforeach

            @foreach ($returns_data as $key => $return)
                returns_data.push("{{ $return }}")
            @endforeach

            @foreach ($coupons_data as $key => $coupon)
                coupons_data.push("{{ $coupon }}")
            @endforeach

            @foreach ($total_net_sales as $key => $net)
                nets_sales.push("{{ $net }}")
            @endforeach

            @foreach ($total_taxes_graph as $key => $taxes)
                total_taxes.push("{{ $taxes }}")
            @endforeach

            @foreach ($total_shipping_graph as $key => $shipping)
                total_shipping.push("{{ $shipping }}")
            @endforeach

            @foreach ($total_sales_graph as $key => $total_sales)
                total_sales.push("{{ $total_sales }}")
            @endforeach
        @endif

        var grossSale = document.getElementById('grossSaleChart').getContext('2d');
        var grossSaleChart = new Chart(grossSale, {

        type: 'line',
        data: {
            labels: net_labels,
            datasets: [{
                label: 'Gross Sales',
                data: gross_sales,
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
							autoSkip: true,
							maxTicksLimit: 10,
							maxRotation: 0, //Do not change ticks width. Or increase              if you need to change also ticks.
						},
						afterCalculateTickRotation : function (self) {
							self.labelRotation = 90; //Or any other rotation of x-labels you need.
						}
					}
            }
        }
    });

    var returns = document.getElementById('returnChart').getContext('2d');
    var returnChart = new Chart(returns, {

        type: 'line',
        data: {
            labels: net_labels,
            datasets: [{
                label: 'Returns',
                data: returns_data,
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
							autoSkip: true,
							maxTicksLimit: 10,
							maxRotation: 0, //Do not change ticks width. Or increase              if you need to change also ticks.
						},
						afterCalculateTickRotation : function (self) {
							self.labelRotation = 90; //Or any other rotation of x-labels you need.
						}
					}
            }
        }
    });

    var coupon = document.getElementById('couponChart').getContext('2d');
    var couponChart = new Chart(coupon, {

        type: 'line',
        data: {
            labels: net_labels,
            datasets: [{
                label: 'Coupons',
                data: coupons_data,
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
							autoSkip: true,
							maxTicksLimit: 10,
							maxRotation: 0, //Do not change ticks width. Or increase              if you need to change also ticks.
						},
						afterCalculateTickRotation : function (self) {
							self.labelRotation = 90; //Or any other rotation of x-labels you need.
						}
					}
            }
        }
    });

    var netsale = document.getElementById('netsaleChart').getContext('2d');
    var netsaleChart = new Chart(netsale, {

        type: 'line',
        data: {
            labels: net_labels,
            datasets: [{
                label: 'Net Sales',
                data: nets_sales,
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
							autoSkip: true,
							maxTicksLimit: 10,
							maxRotation: 0, //Do not change ticks width. Or increase              if you need to change also ticks.
						},
						afterCalculateTickRotation : function (self) {
							self.labelRotation = 90; //Or any other rotation of x-labels you need.
						}
					}
            }
        }
    });

    var totalsale = document.getElementById('totalsaleChart').getContext('2d');
    var totalsaleChart = new Chart(totalsale, {

        type: 'line',
        data: {
            labels: net_labels,
            datasets: [{
                label: 'Total Sales',
                data: total_sales,
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
							autoSkip: true,
							maxTicksLimit: 10,
							maxRotation: 0, //Do not change ticks width. Or increase              if you need to change also ticks.
						},
						afterCalculateTickRotation : function (self) {
							self.labelRotation = 90; //Or any other rotation of x-labels you need.
						}
					}
            }
        }
    });

    var tax = document.getElementById('taxChart').getContext('2d');
    var taxChart = new Chart(tax, {

        type: 'line',
        data: {
            labels: net_labels,
            datasets: [{
                label: 'Taxes',
                data: total_taxes,
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
							autoSkip: true,
							maxTicksLimit: 10,
							maxRotation: 0, //Do not change ticks width. Or increase              if you need to change also ticks.
						},
						afterCalculateTickRotation : function (self) {
							self.labelRotation = 90; //Or any other rotation of x-labels you need.
						}
					}
            }
        }
    });

    var shipping = document.getElementById('shippingChart').getContext('2d');
    var shippingChart = new Chart(shipping, {

        type: 'line',
        data: {
            labels: net_labels,
            datasets: [{
                label: 'Shipping',
                data: total_shipping,
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
							autoSkip: true,
							maxTicksLimit: 10,
							maxRotation: 0, //Do not change ticks width. Or increase              if you need to change also ticks.
						},
						afterCalculateTickRotation : function (self) {
							self.labelRotation = 90; //Or any other rotation of x-labels you need.
						}
					}
            }
        }
    });

        $(document).ready(function () {

            var loc = window.location.href;
            if(window.location.href.indexOf("netsale") != -1) {
                $('#gross-sales').removeClass('navtab-active');
                $('#total-sales').removeClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').addClass('navtab-active');

                $('#gross-sale-content').toggle(false)
                $('#total-sale-content').toggle(false)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(true)
            }
            else if (window.location.href.indexOf("totalsale") != -1) {
                $('#gross-sales').removeClass('navtab-active');
                $('#total-sales').addClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#gross-sale-content').toggle(false)
                $('#total-sale-content').toggle(true)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(false)
            }
            else {
                $('#gross-sales').addClass('navtab-active');
                $('#total-sales').removeClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#gross-sale-content').toggle(true)
                $('#total-sale-content').toggle(false)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(false)
            }
        });

        function toggleNav(id) {
            if (id == 'gross-sales') {
                $('#gross-sales').addClass('navtab-active');
                $('#total-sales').removeClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#gross-sale-content').toggle(true)
                $('#total-sale-content').toggle(false)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'total-sales') {
                $('#gross-sales').removeClass('navtab-active');
                $('#total-sales').addClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#gross-sale-content').toggle(false)
                $('#total-sale-content').toggle(true)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'returns') {
                $('#gross-sales').removeClass('navtab-active');
                $('#total-sales').removeClass('navtab-active');
                $('#returns').addClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#gross-sale-content').toggle(false)
                $('#total-sale-content').toggle(false)
                $('#returns-content').toggle(true)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'taxes') {
                $('#gross-sales').removeClass('navtab-active');
                $('#total-sales').removeClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').addClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#gross-sale-content').toggle(false)
                $('#total-sale-content').toggle(false)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(true)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'coupon') {
                $('#gross-sales').removeClass('navtab-active');
                $('#total-sales').removeClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').addClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#gross-sale-content').toggle(false)
                $('#total-sale-content').toggle(false)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(true)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'shipping') {
                $('#gross-sales').removeClass('navtab-active');
                $('#total-sales').removeClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').addClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#gross-sale-content').toggle(false)
                $('#total-sale-content').toggle(false)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(true)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'netsales') {
                $('#gross-sales').removeClass('navtab-active');
                $('#total-sales').removeClass('navtab-active');
                $('#returns').removeClass('navtab-active');
                $('#taxes').removeClass('navtab-active');
                $('#coupon').removeClass('navtab-active');
                $('#shipping').removeClass('navtab-active');
                $('#netsales').addClass('navtab-active');

                $('#gross-sale-content').toggle(false)
                $('#total-sale-content').toggle(false)
                $('#returns-content').toggle(false)
                $('#taxes-content').toggle(false)
                $('#coupon-content').toggle(false)
                $('#shipping-content').toggle(false)
                $('#netsales-content').toggle(true)
            }
        }
</script>
<script type="text/javascript">

</script>
@endsection
