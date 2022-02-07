@extends('backend.layouts.app')

@section('content')
<div class="card">
    <form class="" action="" method="GET" id="sortorders">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Overview') }}</h5>
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
    <div class="card-body">
		<div>
			<h5 class="fw-600">
			  Performance
			</h5>
			<hr>
		</div>
		<div class="row">
			<div class="col-12 col-lg-3">
				<a href="{{ route('revenue_report.index') }}#totalsale">
					<div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="totalsale">
						<p class="text-title-thin text-uppercase">Total Sales</p>
						<div>
							@php
								$total_sales = 0;

								if ($date != null) {
									$start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
            						$end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

									$total_sales = \App\Order::whereBetween('created_at', [$start_date, $end_date])
										->sum('grand_total');
								}

								else {
									$total_sales = \App\Order::sum('grand_total');
								}

							@endphp
							<span class="fw-600 fs-18">{{ single_price($total_sales) }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-12 col-lg-3">
				<a href="{{ route('revenue_report.index') }}#netsale">
					<div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="netsale">
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

								else {
									$net_sales = \App\Order::where('payment_status', 'paid')
										->sum('grand_total');	
								}
							@endphp
							<span class="fw-600 fs-18">{{ single_price($net_sales) }}</span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-12 col-lg-3">
				<a href="{{ route('orders_report.index') }}">
					<div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="orders">
						<p class="text-title-thin text-uppercase">Orders</p>
						<div>
							@php
								$orders = 0;

								if ($date != null) {
									$start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
            						$end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

									$orders = \App\Order::whereBetween('created_at', [$start_date, $end_date])
										->count();
								}

								else {
									$orders = \App\Order::count();
								}
							@endphp
							<span class="fw-600 fs-18">{{ $orders }}</span>
						</div>
					</div>
				  </a>
			</div>
			<div class="col-12 col-lg-3">
				<a href="{{ route('variation_report.index') }}">
					<div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="itemsold">
						<p class="text-title-thin text-uppercase">Item Sold</p>
						<div>
							@php
								$items_sold = 0;

								if ($date != null) {
									$start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
            						$end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();
									
									$items_sold = \App\OrderDetail::whereBetween('created_at', [$start_date, $end_date])
										->count();
								}

								else {
									$items_sold = \App\OrderDetail::count();
								}
							@endphp
							<span class="fw-600 fs-18">{{ $items_sold }}</span>
						</div>
					</div>
				  </a>
			</div>
		</div>
		<div>
			<h5 class="fw-600">Charts</h5>
			<hr>
		</div>
		<div class="row">
			<div class="col-6">
				<div class="card">
					<div class="card-header">
						<span class="fw-600">
						Net Sales
						</span>
					</div>
					<div class="card-body overflow-auto">
						<canvas id="netsaleChart" width="200" height="130"></canvas>
					</div>
				</div>
			</div>

			<div class="col-6">
				<div class="card">
					<div class="card-header">
						<span class="fw-600">
						Orders
						</span>
					</div>
					<div class="card-body overflow-auto">
						<canvas id="orderChart" width="200" height="130"></canvas>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div>
			<h5 class="fw-600">
				Leaderboards
			</h5>
			<hr>
		</div>

       <div class="row">
			<div class="col-12 col-lg-6">
				<div class="card">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Top Categories - Item Sold') }}</h6>
					</div>
					<div class="card-body">
						<table class="table aiz-table mb-0" id="allordersTable">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ translate('Category') }}</th>
									<th>{{ translate('Item Sold') }}</th>
									<th>{{ translate('Net Sales') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($top_categories as $key => $category)
									<tr>
										<td>{{ $key + 1 }}</td>
										<td>{{ $category->name }}</td>
										<td>
											@php
												$items_sold = \App\Product::where('category_id', $category->id)
													->sum('num_of_sale');
											@endphp

											{{ $items_sold }}
										</td>
										<td>
											@php
												$products = \App\Product::where('category_id', $category->id)
													->pluck('id');

												$net_sales = \App\OrderDetail::whereIn('product_id', $products)
													->sum('price');
											@endphp

											{{ single_price($net_sales) }}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table> 
					</div>
				</div>
				<div class="aiz-pagination">
					{{ $top_categories->links() }}
				</div>
			</div>

            <div class="col-6">
				<div class="card">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Top Products - Item Sold') }}</h6>
					</div>
					<div class="card-body">
						<table class="table aiz-table mb-0" id="allordersTable">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ translate('Product') }}</th>
									<th>{{ translate('Item Sold') }}</th>
									<th>{{ translate('Net Sales') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($top_products as $key => $product)
									<tr>
										<td>{{ $key + 1 }}</td>
										<td>{{ $product->getTranslation('name') }}</td>
										<td>{{ $product->num_of_sale }}</td>
										<td>
											@php
												$order_details = \App\OrderDetail::where('product_id', $product->id)
													->sum('price');
											@endphp

											{{ single_price($order_details) }}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="aiz-pagination">
					{{ $top_products->links() }}
				</div>
            </div>
          </div>
       </div>
    </div>
</div>

@endsection

@section('script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"></script>
    <script type="text/javascript">
      
		var netsale = document.getElementById('netsaleChart').getContext('2d');
		var net_labels = new Array();
		var net_sales = new Array();
		var orders_data = new Array();

		@if ($date != null)
			@php
				$sorted_by_date_net_sales = [];
				$sorted_by_date_orders_data = [];
			@endphp
		
			@foreach ($period as $date_period)
				net_labels.push("{{ date('F d, Y', strtotime($date_period)) }}")

				@php 
					$sorted_by_date_net_sales[] = \App\Order::where('payment_status', 'paid')
						->whereDay('created_at', date('d', strtotime($date_period)))
						->whereMonth('created_at', date('m', strtotime($date_period)))
						->whereYear('created_at', date('Y', strtotime($date_period)))
						->sum('grand_total');

					$sorted_by_date_orders_data[] = \App\Order::whereDay('created_at', date('d', strtotime($date_period)))
						->whereMonth('created_at', date('m', strtotime($date_period)))
						->whereYear('created_at', date('Y', strtotime($date_period)))
						->count();
				@endphp
			@endforeach

			@foreach ($sorted_by_date_net_sales as $sorted_net_sale) 
				net_sales.push("{{ $sorted_net_sale }}")
			@endforeach
			
			@foreach ($sorted_by_date_orders_data as $sorted_orders_data)
				orders_data.push("{{ $sorted_orders_data }}")
			@endforeach
		@else
			@foreach ($days as $key => $value)
				net_labels.push("{{ $current_month }} {{ $value }}");
			@endforeach

			@foreach($net_sales_data as $key => $sale)
				net_sales.push("{{ $sale }}");
			@endforeach

			@foreach($orders_data as $key => $order)
				orders_data.push("{{ $order }}")
			@endforeach
		@endif

		var netsaleChart = new Chart(netsale, {
			type: 'line',
			data: {
				labels: net_labels,
				datasets: [{
					label: 'Net Sales',
					data: net_sales,
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
					borderWidth: 4
				}],
			},
			options: {
				scales: {
					x: {
						ticks: {
							autoSkip: true,
							maxTicksLimit: 6,
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
					data: orders_data,
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
							maxTicksLimit: 6,
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