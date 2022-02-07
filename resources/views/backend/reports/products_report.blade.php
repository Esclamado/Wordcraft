@extends('backend.layouts.app')

@section('content')
<div class="card">
    <form class="" action="" method="GET" id="sortorders">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Products') }}</h5>
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

        <div class="card m-4 d-none" id="singleproduct">
            <div class="card-header">
                <span class="fw-600">
                    Single Product
                </span>
            </div>
            <div class="card-body overflow-auto">
               <div class="row">
                    <div class="col-10">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Search') }}">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">{{ translate('Submit') }}</button>
                        </div>
                    </div>
               </div>
            </div>
        </div>

        <form id="comparedata" method="POST" action="">
            <div class="card m-4 d-none" id="comparison">
                <div class="card-header">
                    <span class="fw-600">
                        Compare Products
                    </span>
                </div>
                <div class="card-body overflow-auto">
                   <div class="row">
                        <div class="col-11">
                            <div class="form-group mb-0">
                                <div class="compareSection">
                                    <input class="form-control mb-3" type="text" name="compare" action="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-1">
                            <input class="btn-primary btn d-flex align-content-center w-100" type="button" id="more" value ="Add" />
                        </div>
                   </div>
                </div>
                <div class="card-footer">
                   <div class="row">
                        <div class="col-auto">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">{{ translate('Compare') }}</button>
                            </div>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                            <a href="">
                                Clear All
                            </a>
                        </div>
                   </div>
                </div>
            </div>
        </form>

       
    </form>
    <div class="card-body overflow-auto">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="itemsold" onclick="toggleNav('itemsold')">
                    <p class="text-title-thin text-uppercase">Item Sold</p>
                    <div>
                        <span class="fw-600 fs-18">
                            @php
                                $order_details = 0;

                                if ($date != null) {
                                    $start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
                                    $end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

                                    $order_details = \App\OrderDetail::whereBetween('created_at', [$start_date, $end_date])
                                        ->where('payment_status', 'paid')
                                        ->count();
                                }

                                else {
                                    $order_details = \App\OrderDetail::where('payment_status', 'paid')->count();
                                }
                            @endphp

                            {{ $order_details }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="netsales" onclick="toggleNav('netsales')">
                    <p class="text-title-thin text-uppercase">Net Sales</p>
                    <div>
                        @php
                            $net_sales = 0;
                            
                            if ($date != null) {
                                $start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
                                $end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

                                $net_sales = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                    ->where('payment_status', 'paid')
								    ->sum('grand_total');
                            }
                            $net_sales = \App\Order::where('payment_status', 'paid')
								->sum('grand_total');
                        @endphp
                        <span class="fw-600 fs-18">{{ single_price($net_sales) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div>                    
                    <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="orders" onclick="toggleNav('orders')">
                        <p class="text-title-thin text-uppercase">Orders</p>
                        <div>
                            @php
                                $orders = 1;

                                if ($date != null) {
                                    $start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
                                    $end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

                                    $orders = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                        ->where('payment_status', 'paid')
                                        ->count();
                                }
                                
                                else {
                                    $orders = \App\Order::where('payment_status', 'paid')->count();
                                }
                            @endphp
                            <span class="fw-600 fs-18">{{ $orders }}</span>
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
                    Products
                </span>
             </div>
            <div class="card-body overflow-auto">
                <table class="table aiz-table mb-0" id="allordersTable">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Variation</th>
                            <th>Total Sold</th>
                            <th>Total Gross Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->variant }}</td>
                                <td>{{ $product->total_sold }}</td>
                                <td>{{ $product->total_sold }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
         </div>
         <div class="aiz-pagination">
             {{ $products->links() }}
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

            $("select.products").change(function(){
                var selectedProduct = $(this).children("option:selected").val();
                
                if (selectedProduct == 'allproduct') {
                    $('#singleproduct').addClass('d-none');
                    $('#comparison').addClass('d-none');
                }

                else if (selectedProduct == 'singleproduct') {
                    $('#singleproduct').addClass('d-block');
                    $('#comparison').addClass('d-none');
                }

                else if (selectedProduct == 'comparison') {
                    $('#singleproduct').addClass('d-none');
                    $('#comparison').addClass('d-block');
                }
                else {
                    $('#singleproduct').addClass('d-none');
                    $('#comparison').addClass('d-none');
                }
            });
        });

        $('select.products').on('change', function() {
            var selectedProduct = $(this).children("option:selected").val();
                
                if (selectedProduct == 'allproduct') {
                    $('#singleproduct').addClass('d-none');
                    $('#comparison').addClass('d-none');
                }

                else if (selectedProduct == 'singleproduct') {
                    $('#singleproduct').addClass('d-block');
                    $('#comparison').addClass('d-none');
                }

                else if (selectedProduct == 'comparison') {
                    $('#singleproduct').addClass('d-none');
                    $('#comparison').addClass('d-block');
                }
                else {
                    $('#singleproduct').addClass('d-none');
                    $('#comparison').addClass('d-none');
                }
        });

        $("#more").click(function() {
            var newBloc = $(".compareSection").eq(0).clone();
            newBloc.find("input").val("");
            $(".compareSection").last().after(newBloc);
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

    var net_labels = new Array();
    var items_sold = new Array();
    var net_sales_data = new Array();
    var order_data = new Array();

    @if ($date != null)
        @php
            $sorted_by_date_items_sold = [];
            $sorted_by_date_net_sales = [];
            $sorted_by_date_order_data = [];
        @endphp

        @foreach ($period as $date_period)
            net_labels.push("{{ date('F d, Y', strtotime($date_period)) }}")

            @php 
                $sorted_by_date_items_sold[] = \App\OrderDetail::where('payment_status', 'paid')
                    ->whereDay('created_at', date('d', strtotime($date_period)))
                    ->whereMonth('created_at', date('m', strtotime($date_period)))
                    ->whereYear('created_at', date('Y', strtotime($date_period)))
                    ->count();

                $sorted_by_date_net_sales[] = \App\Order::where('payment_status', 'paid')
                    ->whereDay('created_at', date('d', strtotime($date_period)))
                    ->whereMonth('created_at', date('m', strtotime($date_period)))
                    ->whereYear('created_at', date('Y', strtotime($date_period)))
                    ->sum('grand_total');

                $sorted_by_date_order_data[] = \App\Order::where('payment_status', 'paid')
                    ->whereDay('created_at', date('d', strtotime($date_period)))
                    ->whereMonth('created_at', date('m', strtotime($date_period)))
                    ->whereYear('created_at', date('Y', strtotime($date_period)))
                    ->count();
            @endphp
        @endforeach

        @foreach ($sorted_by_date_items_sold as $sorted_items_sold)
            items_sold.push("{{ $sorted_items_sold }}")
        @endforeach

        @foreach ($sorted_by_date_net_sales as $sorted_net_sales)
            net_sales_data.push("{{ $sorted_net_sales }}")
        @endforeach

        @foreach ($sorted_by_date_order_data as $sorted_order_data)
            net_sales_data.push("{{ $sorted_order_data }}")
        @endforeach
    @else 
        @foreach ($days as $key => $value)
            net_labels.push("{{ $current_month }} {{ $value }}");
        @endforeach

        @foreach ($items_sold as $key => $sold)
            items_sold.push("{{ $sold }}")
        @endforeach

        @foreach ($net_sales_data as $key => $sale)
            net_sales_data.push("{{ $sale }}")
        @endforeach

        @foreach ($orders_data as $key => $order)
            order_data.push("{{ $order }}")
        @endforeach
    @endif

    var itemsold = document.getElementById('itemsoldChart').getContext('2d'); 
    var itemsoldChart = new Chart(itemsold, {

        type: 'line',
        data: {
            labels: net_labels,
            datasets: [{
                label: 'Item Sold',
                data: items_sold,
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
                data: net_sales_data,
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
            labels: net_labels,
            datasets: [{
                label: 'Orders',
                data: order_data,
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

    const tagContainer = document.querySelector('.tag-container');
    const input = document.querySelector('.tag-container input');

    let tags = [];

    function createTag(label) {
    const div = document.createElement('div');
    div.setAttribute('class', 'tag');
    const span = document.createElement('span');
    span.innerHTML = label;
    const closeIcon = document.createElement('i');
    closeIcon.innerHTML = 'close';
    closeIcon.setAttribute('class', 'material-icons');
    closeIcon.setAttribute('data-item', label);
    div.appendChild(span);
    div.appendChild(closeIcon);
    return div;
    }

    function clearTags() {
    document.querySelectorAll('.tag').forEach(tag => {
        tag.parentElement.removeChild(tag);
    });
    }

    function addTags() {
    clearTags();
    tags.slice().reverse().forEach(tag => {
        tagContainer.prepend(createTag(tag));
    });
    }

    input.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') {
        e.target.value.split(',').forEach(tag => {
            tags.push(tag);  
        });
        
        addTags();
        input.value = '';
        }
    });
    document.addEventListener('click', (e) => {
    console.log(e.target.tagName);
    if (e.target.tagName === 'I') {
        const tagLabel = e.target.getAttribute('data-item');
        const index = tags.indexOf(tagLabel);
        tags = [...tags.slice(0, index), ...tags.slice(index+1)];
        addTags();    
    }
    })

    input.focus();


    </script>     
@endsection