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
                <h5 class="mb-md-0 h6">{{ translate('Orders') }}</h5>
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
        <div class="row mb-3">
            <div class="col-12 col-lg-3 mb-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3 c-pointer" id="orders" onclick="toggleNav('orders')">
                    <p class="text-title-thin text-uppercase">Orders</p>
                    <div>
                        <span class="fw-600 fs-18">
                            @php
                                $orders_total_count = 0;

                                if ($date != null) {
                                    $orders_total_count = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                        ->count();
                                }

                                else {
                                    $orders_total_count = \App\Order::count();
                                }
                            @endphp

                            {{ $orders_total_count }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="average-orders" onclick="toggleNav('average-orders')">
                    <p class="text-title-thin text-uppercase">Average Order Value</p>
                    <div>
                        <span class="fw-600 fs-18">
                            @php
                                $average_order = 0;

                                if ($date != null) {
                                    $average_order = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                        ->avg('grand_total');
                                }

                                else {
                                    $average_order = \App\Order::avg('grand_total');
                                }
                            @endphp

                            {{ single_price($average_order) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <div>
                    <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="average-item" onclick="toggleNav('average-item')">
                        <p class="text-title-thin text-uppercase">Average Items Per Order</p>
                        <div>
                            <span class="fw-600 fs-18">
                                @php
                                    if ($date != null) {
                                        $order_list = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                            ->withCount('orderDetails')
                                            ->pluck('order_details_count');
                                    }

                                    else {
                                        $order_list = \App\Order::withCount('orderDetails')
                                            ->pluck('order_details_count');
                                    }

                                    if (!is_array($order_list)) {
                                        $sum = 0;
                                        $amt = count($order_list);

                                        foreach ($order_list as $num) {
                                            $sum += $num;
                                        }

                                        $average = ($amt > 0) ? ($sum / $amt) : false;

                                        $roundoff = round($average, 0);
                                    }
                                @endphp

                                {{ $roundoff }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="netsales" onclick="toggleNav('netsales')">
                    <p class="text-title-thin text-uppercase">Net Sales</p>
                    <div>
                        <span class="fw-600 fs-18">
                            @php
                                $net_sales = 0;
                                
                                if ($date != null) {
                                    $net_sales = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                        ->where('payment_status', 'paid')
                                        ->sum('grand_total');
                                }

                                else {
                                    $net_sales = \App\Order::where('payment_status', 'paid')
                                        ->sum('grand_total');
                                }
                            @endphp

                            {{ single_price($net_sales) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
       <div class="card" id="orders-content">
           <div class="card-header">
                <span class="fw-600">
                    Orders
                </span>
           </div>
            <div class="card-body overflow-auto">
                <canvas id="orderChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
            </div>
       </div>

       <div class="card" id="average-orders-content">
            <div class="card-header">
                <span class="fw-600">
                    Average Order Value
                </span>
            </div>
            <div class="card-body overflow-auto">
                <canvas id="averageorderChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
            </div>
        </div>

        <div class="card" id="average-item-content">
            <div class="card-header">
                <span class="fw-600">
                    Average items per order
                </span>
            </div>
            <div class="card-body overflow-auto">
                <canvas id="averageitemChart" class="d-flex justify-content-center w-100" width="1000" height="500">
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
                    Orders
                </span>
            </div>
            <div class="card-body overflow-auto">
                <table class="table aiz-table mb-0" id="allordersTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Status</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Item Sold</th>
                            <th>Coupons</th>
                            <th>Net Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($date != null)
                            @foreach ($period as $date_period)
                                @php
                                    $date_day = date('d', strtotime($date_period));
                                    $month = date('m', strtotime($date_period));
                                    $year = date('Y', strtotime($date_period));

                                    $order = \App\Order::whereDay('created_at', $date_day)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->latest()
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ date('F d, Y', strtotime($date_period)) }}</td>
                                    <td>
                                        {{ $order->code ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @if ($order != null)
                                            @if ($order->payment_status == 'paid' && $order->orderDetails->first()->delivery_stauts == 'picked_up')
                                                <span class="badge badge-success w-auto">Successful</span>
                                            @else
                                                <span class="badge badge-warning w-auto">Processing</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order != null)
                                            {{ $order->user != null ? $order->user->name : 'N\A' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order != null)
                                            {{ count($order->orderDetails) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            echo $items_sold = \App\OrderDetail::where('payment_status', 'paid')
                                                ->whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->count();
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            echo $coupons_used = \App\Order::where('coupon_discount', '!=', '0.00')
                                                ->whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->count();
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            $net_sales_table = \App\Order::where('payment_status', 'paid')
                                                ->whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('grand_total');
                                        @endphp

                                        {{ single_price($net_sales_table) }}
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            @foreach ($days as $key => $date_day)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $month = \Carbon\Carbon::parse($now)->format('m');
                                    $year = \Carbon\Carbon::parse($now)->format('Y');
                                
                                    $order = \App\Order::whereDay('created_at', $date_day)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->latest()
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $current_month }} {{ $date_day }}, {{ \Carbon\Carbon::now()->year }}</td>
                                    <td>
                                        {{ $order->code ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @if ($order != null)
                                            @if ($order->payment_status == 'paid' && $order->orderDetails->first()->delivery_stauts == 'picked_up')
                                                <span class="badge badge-success w-auto">Successful</span>
                                            @else
                                                <span class="badge badge-warning w-auto">Processing</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order != null)
                                            {{ $order->user != null ? $order->user->name : 'N\A' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order != null)
                                            {{ count($order->orderDetails) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            echo $items_sold = \App\OrderDetail::where('payment_status', 'paid')
                                                ->whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->count();
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            echo $coupons_used = \App\Order::where('coupon_discount', '!=', '0.00')
                                                ->whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->count();
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            $net_sales_table = \App\Order::where('payment_status', 'paid')
                                                ->whereDay('created_at', $date_day)
                                                ->whereMonth('created_at', $month)
                                                ->whereYear('created_at', $year)
                                                ->sum('grand_total');
                                        @endphp

                                        {{ single_price($net_sales_table) }}
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
    <script>

        $(document).ready(function () {
            $('#orders').addClass('navtab-active');
            $('#average-orders-content').toggle(false)
            $('#average-item-content').toggle(false)
            $('#netsales-content').toggle(false)
        });

        function toggleNav(id) {
            if (id == 'orders') {
                $('#orders').addClass('navtab-active');
                $('#average-orders').removeClass('navtab-active');
                $('#average-item').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#orders-content').toggle(true)
                $('#average-orders-content').toggle(false)
                $('#average-item-content').toggle(false)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'average-orders') {
                $('#orders').removeClass('navtab-active');
                $('#average-orders').addClass('navtab-active');
                $('#average-item').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#orders-content').toggle(false)
                $('#average-orders-content').toggle(true)
                $('#average-item-content').toggle(false)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'average-item') {
                $('#orders').removeClass('navtab-active');
                $('#average-orders').removeClass('navtab-active');
                $('#average-item').addClass('navtab-active');
                $('#netsales').removeClass('navtab-active');

                $('#orders-content').toggle(false)
                $('#average-orders-content').toggle(false)
                $('#average-item-content').toggle(true)
                $('#netsales-content').toggle(false)
            }

            else if (id == 'netsales') {
                $('#orders').removeClass('navtab-active');
                $('#average-orders').removeClass('navtab-active');
                $('#average-item').removeClass('navtab-active');
                $('#netsales').addClass('navtab-active');

                $('#orders-content').toggle(false)
                $('#average-orders-content').toggle(false)
                $('#average-item-content').toggle(false)
                $('#netsales-content').toggle(true)
            }
        }

    var chart_labels = new Array();
    var chart_orders_count = new Array();
    var chart_average_order = new Array();
    var chart_average_item = new Array();
    var chart_net_sales = new Array();

    @if ($date != null)
        @php
            $sorted_by_date_orders_count = [];
            $sorted_by_date_average_order = [];
            $sorted_by_date_average_item = [];
            $sorted_by_date_net_sales = [];
        @endphp

        @foreach ($period as $period_date)
            chart_labels.push("{{ date('F d, Y', strtotime($period_date)) }}")
            
            @php
                $day = date('d', strtotime($period_date));
                $month = date('m', strtotime($period_date));
                $year = date('Y', strtotime($period_date));

                $sorted_by_date_orders_count[] = \App\Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->count();

                $sorted_by_date_average_order[] = \App\Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->avg('grand_total');

                $average_order_item = \App\Order::withCount('orderDetails')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->pluck('order_details_count');
    
                    if (!is_array($average_order_item)) {
                        $sum = 0;
                        $amt = count($average_order_item);
    
                        foreach ($average_order_item as $num) {
                            $sum += $num;
                        }
    
                        $average = ($amt > 0) ? ($sum / $amt) : false;
                    }
    
                $sorted_by_date_average_item[] = $average;

                $sorted_by_date_net_sales[] = \App\Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->sum('grand_total');
            @endphp
        @endforeach

        @foreach ($sorted_by_date_orders_count as $date_orders_count)
            chart_orders_count.push("{{ $date_orders_count }}")
        @endforeach

        @foreach ($sorted_by_date_average_order as $date_average_order)
            chart_average_order.push("{{ $date_average_order }}")
        @endforeach

        @foreach ($sorted_by_date_average_item as $date_average_item)
            chart_average_item.push("{{ $date_average_item }}")
        @endforeach

        @foreach ($sorted_by_date_net_sales as $date_net_sales)
            chart_net_sales.push("{{ $date_net_sales }}")
        @endforeach
    @else 
        @foreach ($days as $key => $day) 
            chart_labels.push("{{ $current_month }} {{  $day }}")
        @endforeach

        @foreach ($orders_count as $key => $order_count)
            chart_orders_count.push("{{ $order_count }}")
        @endforeach

        @foreach ($average_order_value as $key => $average)
            chart_average_order.push("{{ $average }}")
        @endforeach

        @foreach($average_items_order as $key => $average_item)
            chart_average_item.push("{{ $average_item }}")
        @endforeach

        @foreach ($chart_net_sales as $key => $net_chart_sale)
            chart_net_sales.push("{{ $net_chart_sale }}")
        @endforeach
    @endif

    var order = document.getElementById('orderChart').getContext('2d');
    var orderChart = new Chart(order, {
        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Orders',
                data: chart_orders_count,
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

    var averageorder = document.getElementById('averageorderChart').getContext('2d');
    var averageorderChart = new Chart(averageorder, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Average Order Value',
                data: chart_average_order,
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

    var averageitem = document.getElementById('averageitemChart').getContext('2d');
    var averageitemChart = new Chart(averageitem, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Average Items per Order',
                data: chart_average_item,
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
    var netsale = new Chart(netsale, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Net Sales',
                data: chart_net_sales,
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
    </script>
@endsection
