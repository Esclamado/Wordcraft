@extends('backend.layouts.app')

@section('content')
<div class="card">
    <form class="" action="" method="GET" id="sortorders">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Islands') }}</h5>
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

    @php
        $island_orders = \App\Order::where('shipping_address', '!=', "null")
            ->distinct();

        $luzon_count = 0;
        $visayas_count = 0;
        $mindanao_count = 0;

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            if ($start_date == $end_date) {
                $island_order = $island_orders->whereDate('created_at', $start_date);
            }

            else {
                $island_orders = $island_orders->whereBetween('created_at', [$start_date, $end_date]);
            }
        }

        $island_orders = $island_orders->get();

        foreach ($island_orders as $key => $order) {
            $island = json_decode($order->shipping_address)->island ?? null;

            if ($island != null) {
                if ($island == 'north_luzon' || $island == 'south_luzon') {
                    $luzon_count += 1;
                }
                    
                elseif ($island == 'visayas') {
                    $visayas_count += 1;
                }

                elseif ($island == 'mindanao') {
                    $mindanao_count += 1;
                }
            }
        }
    @endphp
    <div class="card-body overflow-auto">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="itemsold" onclick="toggleNav('itemsold')">
                    <p class="text-title-thin text-uppercase">Luzon</p>
                    <div>
                        <span class="fw-600 fs-18">
                            {{ $luzon_count }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="netsales" onclick="toggleNav('netsales')">
                    <p class="text-title-thin text-uppercase">Visayas</p>
                    <div>
                        <span class="fw-600 fs-18">
                            {{ $visayas_count }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div>                    
                    <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="orders" onclick="toggleNav('orders')">
                        <p class="text-title-thin text-uppercase">Mindanao</p>
                        <div>
                            <span class="fw-600 fs-18">
                                {{ $mindanao_count }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="itemsold-content">
            <div class="card-header">
                 <span class="fw-600">
                     North Luzon Orders
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="itemsoldChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>

        <div class="card" id="itemsold-2-content">
            <div class="card-header">
                 <span class="fw-600">
                     South Luzon Orders
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="itemsoldChart-2" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>
 
        <div class="card" id="netsales-content">
             <div class="card-header">
                 <span class="fw-600">
                     Visayas Orders
                 </span>
             </div>
             <div class="card-body overflow-auto">
                <canvas id="netsaleChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
         </div>
 
         <div class="card" id="orders-content">
             <div class="card-header">
                 <span class="fw-600">
                    Mindanao Orders
                 </span>
             </div>
             <div class="card-body overflow-auto">
                <canvas id="orderChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
         </div>

        <div class="card">
            <div class="card-header">
                <span class="fw-600">
                    Island Report
                </span>
            </div>

            <div class="card-body overflow-auto">
                <table class="table aiz-table mb-0" id="allordersTable">
                    <thead>
                        <tr>
                            <th>Island</th>
                            <th>Item Sold</th>
                            <th>Net Sales</th>
                            <th>Orders</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>North Luzon</td>
                            <td>
                                @php
                                    $orders_items_sold = \App\Order::where('shipping_address', '!=', null) 
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "north_luzon"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_items_sold = $orders_items_sold->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_items_sold = $orders_items_sold->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_items_sold = $orders_items_sold->pluck('id');
                                    
                                    $items_sold = \App\OrderDetail::distinct()->whereIn('order_id', $orders_items_sold)
                                        ->count();
                                @endphp

                                {{ $items_sold }}
                            </td>
                            <td>
                                @php
                                    $orders_net_sales = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "north_luzon"}\')')
                                        ->distinct();
                                    
                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_net_sales = $orders_net_sales->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_net_sales = $orders_net_sales->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_net_sales = $orders_net_sales->sum('grand_total');
                                @endphp
                                
                                {{ single_price($orders_net_sales) }}
                            </td>
                            <td>
                                @php
                                    $orders_count = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "north_luzon"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_count = $orders_count->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_count = $orders_count->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_count = $orders_count->count();
                                @endphp
                                
                                {{ $orders_count }}
                            </td>
                        </tr>
                        <tr>
                            <td>South Luzon</td>
                            <td>
                                @php
                                    $orders_items_sold = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "south_luzon"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_items_sold = $orders_items_sold->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_items_sold = $orders_items_sold->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_items_sold = $orders_items_sold->pluck('id');
                                    
                                    $items_sold = \App\OrderDetail::distinct()->whereIn('order_id', $orders_items_sold)
                                        ->count();
                                @endphp

                                {{ $items_sold }}
                            </td>
                            <td>
                                @php
                                    $orders_net_sales = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "south_luzon"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_net_sales = $orders_net_sales->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_net_sales = $orders_net_sales->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_net_sales = $orders_net_sales->sum('grand_total');
                                @endphp
                                
                                {{ single_price($orders_net_sales) }}
                            </td>
                            <td>
                                @php
                                    $orders_count = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "south_luzon"}\')')
                                        ->distinct();
                                        
                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_count = $orders_count->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_count = $orders_count->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_count = $orders_count->count();
                                @endphp
                                
                                {{ $orders_count }}
                            </td>
                        </tr>
                        <tr>
                            <td>Visayas</td>
                            <td>
                                @php
                                    $orders_items_sold = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "visayas"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_items_sold = $orders_items_sold->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_items_sold = $orders_items_sold->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_items_sold = $orders_items_sold->pluck('id');
                                    
                                    $items_sold = \App\OrderDetail::distinct()->whereIn('order_id', $orders_items_sold)
                                        ->count();
                                @endphp

                                {{ $items_sold }}
                            </td>
                            <td>
                                @php
                                    $orders_net_sales = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "visayas"}\')')
                                        ->distinct();
                                    
                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_net_sales = $orders_net_sales->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_net_sales = $orders_net_sales->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_net_sales = $orders_net_sales->sum('grand_total');
                                @endphp
                                
                                {{ single_price($orders_net_sales) }}
                            </td>
                            <td>
                                @php
                                    $orders_count = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "visayas"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_count = $orders_count->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_count = $orders_count->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_count = $orders_count->count();
                                @endphp
                                
                                {{ $orders_count }}
                            </td>
                        </tr>
                        <tr>
                            <td>Mindanao</td>
                            <td>
                                @php
                                    $orders_items_sold = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "mindanao"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_items_sold = $orders_items_sold->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_items_sold = $orders_items_sold->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_items_sold = $orders_items_sold->pluck('id');

                                    $items_sold = \App\OrderDetail::distinct()->whereIn('order_id', $orders_items_sold)
                                        ->count();
                                @endphp

                                {{ $items_sold }}
                            </td>
                            <td>
                                @php
                                    $orders_net_sales = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "mindanao"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_net_sales = $orders_net_sales->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_net_sales = $orders_net_sales->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_net_sales = $orders_net_sales->sum('grand_total');
                                @endphp
                                
                                {{ single_price($orders_net_sales) }}
                            </td>
                            <td>
                                @php
                                    $orders_count = \App\Order::where('shipping_address', '!=', 'null')
                                        ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "mindanao"}\')')
                                        ->distinct();

                                    if ($date != null) {
                                        $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
                                        $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

                                        if ($start_date == $end_date) {
                                            $orders_count = $orders_count->whereDate('created_at', $start_date);
                                        }

                                        else {
                                            $orders_count = $orders_count->whereBetween('created_at', [$start_date, $end_date]);
                                        }
                                    }

                                    $orders_count = $orders_count->count();
                                @endphp
                                
                                {{ $orders_count }}
                            </td>
                        </tr>
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
            $('#itemsold').addClass('navtab-active');
            $('#netsales-content').toggle(false)
            $('#orders-content').toggle(false)
        });

        function toggleNav(id) {
            if (id == 'itemsold') {
                $('#itemsold').addClass('navtab-active');
                $('#itemsold').addClass('navtab-active');
                $('#netsales').removeClass('navtab-active');
                $('#orders').removeClass('navtab-active');

                $('#itemsold-content').toggle(true)
                $('#itemsold-2-content').toggle(true)
                $('#netsales-content').toggle(false)
                $('#orders-content').toggle(false)
            }

            else if (id == 'netsales') {
                $('#itemsold').removeClass('navtab-active');
                $('#netsales').addClass('navtab-active');
                $('#orders').removeClass('navtab-active');

                $('#itemsold-content').toggle(false)
                $('#itemsold-2-content').toggle(false)
                $('#netsales-content').toggle(true)
                $('#orders-content').toggle(false)
            }

            else if (id == 'orders') {
                $('#itemsold').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');
                $('#orders').addClass('navtab-active');

                $('#itemsold-content').toggle(false)
                $('#itemsold-2-content').toggle(false)
                $('#netsales-content').toggle(false)
                $('#orders-content').toggle(true)
            }
        }

    var chart_labels = new Array();
    var chart_north_luzon_items_sold = new Array();
    var chart_south_luzon_items_sold = new Array();
    var chart_visayas_items_sold = new Array();
    var chart_mindanao_items_sold = new Array();

    @if ($date != null)
        @php
            $sorted_by_date_north_luzon = [];
            $sorted_by_date_south_luzon = [];
            $sorted_by_date_visayas = [];
            $sorted_by_date_mindanao = [];
        @endphp

        @foreach ($period as $date_period)
            chart_labels.push("{{ date('F d, Y', strtotime($date_period)) }}")

            @php
                $sorted_by_date_north_luzon[] = \App\Order::where('shipping_address', '!=', null)
                    ->whereDay('created_at', date('d', strtotime($date_period)))
                    ->whereMonth('created_at', date('m', strtotime($date_period)))
                    ->whereYear('created_at', date('Y', strtotime($date_period)))
                    ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "north_luzon"}\')')
                    ->count();

                $sorted_by_date_south_luzon[] = \App\Order::where('shipping_address', '!=', null)
                    ->whereDay('created_at', date('d', strtotime($date_period)))
                    ->whereMonth('created_at', date('m', strtotime($date_period)))
                    ->whereYear('created_at', date('Y', strtotime($date_period)))
                    ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "south_luzon"}\')')
                    ->count();

                $sorted_by_date_visayas[] = \App\Order::where('shipping_address', '!=', null)
                    ->whereDay('created_at', date('d', strtotime($date_period)))
                    ->whereMonth('created_at', date('m', strtotime($date_period)))
                    ->whereYear('created_at', date('Y', strtotime($date_period)))
                    ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "visayas"}\')')
                    ->count();

                $sorted_by_date_mindanao[] = \App\Order::where('shipping_address', '!=', null)
                    ->whereDay('created_at', date('d', strtotime($date_period)))
                    ->whereMonth('created_at', date('m', strtotime($date_period)))
                    ->whereYear('created_at', date('Y', strtotime($date_period)))
                    ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "mindanao"}\')')
                    ->count();
            @endphp
        @endforeach

        @foreach($sorted_by_date_north_luzon as $north_luzon)
            chart_north_luzon_items_sold.push("{{ $north_luzon }}")
        @endforeach

        @foreach($sorted_by_date_south_luzon as $south_luzon)
            chart_south_luzon_items_sold.push("{{ $south_luzon }}")
        @endforeach

        @foreach($sorted_by_date_visayas as $visaya)
            chart_visayas_items_sold.push("{{ $visaya }}")
        @endforeach

        @foreach($sorted_by_date_mindanao as $mindanao)
            chart_mindanao_items_sold.push("{{ $mindanao }}")
        @endforeach
        
    @else
        @foreach ($days as $key => $day) 
            chart_labels.push("{{ $current_month }} {{ $day }}")
        @endforeach

        @foreach ($north_luzon_orders as $key => $north_luz_sold) 
            chart_north_luzon_items_sold.push("{{ $north_luz_sold }}")
        @endforeach

        @foreach ($south_luzon_orders as $key => $south_luz_sold) 
            chart_south_luzon_items_sold.push("{{ $south_luz_sold }}")
        @endforeach

        @foreach ($visayas_orders as $key => $visays_order) 
            chart_visayas_items_sold.push("{{ $visays_order }}")
        @endforeach

        @foreach ($mindanao_orders as $key => $mindanao_order) 
            chart_mindanao_items_sold.push("{{ $mindanao_order }}")
        @endforeach
    @endif

    var itemsold = document.getElementById('itemsoldChart').getContext('2d'); 
    var itemsoldChart = new Chart(itemsold, {
        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'North Luzon Orders',
                data: chart_north_luzon_items_sold,
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

    var itemsold2 = document.getElementById('itemsoldChart-2').getContext('2d'); 
    var itemsoldChart = new Chart(itemsold2, {
        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'South Luzon Orders',
                data: chart_south_luzon_items_sold,
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
            labels: chart_labels,
            datasets: [{
                label: 'Visayas Orders',
                data: chart_visayas_items_sold,
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

    var order = document.getElementById('orderChart').getContext('2d'); 
    var orderChart = new Chart(order, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Mindanao Orders',
                data: chart_mindanao_items_sold,
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
