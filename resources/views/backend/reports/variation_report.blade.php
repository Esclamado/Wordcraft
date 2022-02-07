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
                <h5 class="mb-md-0 h6">{{ translate('Variations') }}</h5>
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
            <div class="col-12 col-lg-4">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="itemsold" onclick="toggleNav('itemsold')">
                    <p class="text-title-thin text-uppercase">Item Sold</p>
                    <div>
                        <span class="fw-600 fs-18">
                            @php
                                $items_sold = 0;

                                if ($date != null) {
                                    $items_sold = \App\OrderDetail::whereBetween('created_at', [$start_date, $end_date])
                                        ->where('payment_status', 'paid')
                                        ->count();
                                }

                                else {
                                    $items_sold = \App\OrderDetail::where('payment_status', 'paid')
                                        ->count();
                                }
                            @endphp

                            {{ $items_sold }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
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
            <div class="col-12 col-lg-4">
                <div>                    
                    <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="orders" onclick="toggleNav('orders')">
                        <p class="text-title-thin text-uppercase">Orders</p>
                        <div>
                            <span class="fw-600 fs-18">
                                @php
                                    $orders_count = 0;

                                    if ($date != null) {
                                        $orders_count = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                            ->count();
                                    }

                                    else {
                                        $orders_count = \App\Order::count();
                                    }
                                @endphp

                                {{ $orders_count }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="itemsold-content">
            <div class="card-header">
                 <span class="fw-600">
                     Item Sold
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="itemsoldChart" class="d-flex justify-content-center w-100" width="1000" height="500">
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

        <div class="card">
            <div class="card-header">
                <span class="fw-600">
                    Variations
                </span>
            </div>

            <div class="card-body overflow-auto">
                <table class="table aiz-table mb-0" id="allordersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product/Variation</th>
                            <th>SKU</th>
                            <th>Item Sold</th>
                            <th>Net Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product_variation as $key => $item)
                            <tr>
                                <td>
                                    {{ ($key+1) + ($product_variation->currentPage() - 1)*$product_variation->perPage() }}
                                </td>
                                <td>
                                    {{ $item->variant }}
                                </td>
                                <td>
                                    {{ $item->sku }}
                                </td>
                                <td>
                                    @php
                                        $order_detail_num = \App\OrderDetail::where('product_id', $item->product_id)
                                            ->count();
                                    @endphp

                                    {{ $order_detail_num }}
                                </td>
                                <td>
                                    @php
                                        $order_detail = \App\OrderDetail::where('product_id', $item->product_id)
                                            ->sum('price')
                                    @endphp

                                    {{ single_price($order_detail) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $product_variation->links() }}
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
                $('#netsales').removeClass('navtab-active');
                $('#orders').removeClass('navtab-active');

                $('#itemsold-content').toggle(true)
                $('#netsales-content').toggle(false)
                $('#orders-content').toggle(false)
            }

            else if (id == 'netsales') {
                $('#itemsold').removeClass('navtab-active');
                $('#netsales').addClass('navtab-active');
                $('#orders').removeClass('navtab-active');

                $('#itemsold-content').toggle(false)
                $('#netsales-content').toggle(true)
                $('#orders-content').toggle(false)
            }

            else if (id == 'orders') {
                $('#itemsold').removeClass('navtab-active');
                $('#netsales').removeClass('navtab-active');
                $('#orders').addClass('navtab-active');

                $('#itemsold-content').toggle(false)
                $('#netsales-content').toggle(false)
                $('#orders-content').toggle(true)
            }
        }

    var chart_labels = new Array();
    var chart_items_sold = new Array();
    var chart_net_sales = new Array();
    var chart_orders_data = new Array();

    @if ($date != null)
        @php
            $sorted_by_date_net_sales = [];
            $sorted_by_date_items_sold = [];
            $sorted_by_date_orders_data = [];
        @endphp

        @foreach ($period as $date_period)
            chart_labels.push("{{ date('F d, Y', strtotime($date_period)) }}")

            @php
                $date_day = date('d', strtotime($date_period));
                $date_month = date('m', strtotime($date_period));
                $date_year = date('Y', strtotime($date_period));

                $sorted_by_date_items_sold[] = \App\OrderDetail::whereDay('created_at', $date_day)
                    ->whereMonth('created_at', $date_month)
                    ->whereYear('created_at', $date_year)
                    ->count();

                $sorted_by_date_net_sales[] = \App\Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $date_day)
                    ->whereMonth('created_at', $date_month)
                    ->whereYear('created_at', $date_year)
                    ->sum('grand_total');

                $sorted_by_date_orders_data[] = \App\Order::whereDay('created_at', $date_day)
                    ->whereMonth('created_at', $date_month)
                    ->whereYear('created_at', $date_year)
                    ->count();
            @endphp
        @endforeach     

        @foreach ($sorted_by_date_items_sold as $date_items_sold)
            chart_items_sold.push("{{ $date_items_sold }}")
        @endforeach

        @foreach ($sorted_by_date_net_sales as $date_net_sales)
            chart_net_sales.push("{{ $date_net_sales }}")
        @endforeach

        @foreach ($sorted_by_date_orders_data as $date_orders_data )
            chart_orders_data.push("{{ $date_orders_data }}")
        @endforeach
    @else

        @foreach ($days as $key => $day) 
            chart_labels.push("{{ $current_month }} {{ $day }}")
        @endforeach

        @foreach ($net_sales_data as $key => $net_sale_data) 
            chart_net_sales.push("{{ $net_sale_data }}")
        @endforeach
        
        @foreach ($items_sold_data as $key => $item_sold_data)
            chart_items_sold.push("{{ $item_sold_data }}")
        @endforeach

        @foreach ($orders_data as $key => $order_data)
            chart_orders_data.push("{{ $order_data }}")
        @endforeach

    @endif

    var itemsold = document.getElementById('itemsoldChart').getContext('2d'); 
    var itemsoldChart = new Chart(itemsold, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Item Sold',
                data: chart_items_sold,
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

    var order = document.getElementById('orderChart').getContext('2d'); 
    var orderChart = new Chart(order, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Orders',
                data: chart_orders_data,
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