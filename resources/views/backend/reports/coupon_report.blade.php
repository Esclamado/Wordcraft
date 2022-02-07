@extends('backend.layouts.app')

@section('content')
<div class="card">
    <form class="" action="" method="GET" id="sortorders">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Coupon') }}</h5>
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
            <div class="col-12 col-lg-6">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="discountcoupon" onclick="toggleNav('discountcoupon')">
                    <p class="text-title-thin text-uppercase">Discounted Coupon</p>
                    <div>
                        <span class="fw-600 fs-18">
                            @php
                                $number_discounted_coupon = 0;
                                
                                if ($date != null) {
                                    $number_discounted_coupon = \App\Coupon::whereBetween('created_at', [$start_date, $end_date])
                                        ->count();
                                }

                                else {
                                    $number_discounted_coupon = \App\Coupon::count();
                                }
                            @endphp

                            {{ $number_discounted_coupon }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left" id="amount" onclick="toggleNav('amount')">
                    <p class="text-title-thin text-uppercase">Amount</p>
                    <div>
                        <span class="fw-600 fs-18">
                            @php
                                $coupon_discounts = 0;

                                if ($date != null) {
                                    $coupon_discounts = \App\Order::whereBetween('created_at', [$start_date, $end_date])
                                        ->where('coupon_discount', '!=', null)
                                        ->sum('coupon_discount');
                                }

                                else {
                                    $coupon_discounts = \App\Order::where('coupon_discount', '!=', null)
                                        ->sum('coupon_discount');
                                }
                            @endphp

                            {{ single_price($coupon_discounts) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="discountcoupon-content">
            <div class="card-header">
                 <span class="fw-600">
                     Discounted Coupon
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="discountcouponChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>
 
        <div class="card" id="amount-content">
             <div class="card-header">
                 <span class="fw-600">
                     Amount
                 </span>
             </div>
             <div class="card-body overflow-auto">
                <canvas id="amountChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
         </div>
 
        <div class="card">
            <div class="card-header">
                <span class="fw-600">
                    Coupons
                </span>
            </div>
            <div class="card-body overflow-auto">
                <table class="table aiz-table mb-0" id="allordersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Coupon Code</th>
                            <th>Coupon Description</th>
                            <th>Orders</th>
                            <th>Amount Discounted</th>
                            <th>Created</th>
                            <th>Expired</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $key => $coupon)
                            <tr>
                                <td>{{ ($key+1) + ($coupons->currentPage() - 1)*$coupons->perPage() }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->description }}</td>
                                <td>{{ \App\Order::where('coupon_code', $coupon->code)->count() }}</td>
                                <td>
                                    @php
                                        $orders = \App\Order::where('coupon_code', $coupon->code)
                                            ->where('coupon_discount', '!=', null)
                                            ->sum('coupon_discount');
                                    @endphp

                                    {{ single_price($orders) }}
                                </td>
                                <td>
                                    {{ date('Y-m-d', strtotime($coupon->created_at)) }}
                                </td>
                                <td>{{ date('Y-m-d', $coupon->end_date) }}</td>
                                <td>
                                    {{ ucfirst(str_replace('_', ' ', $coupon->type)) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $coupons->links() }}
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
            $('#discountcoupon').addClass('navtab-active');
            $('#amount-content').toggle(false)
        });

        function toggleNav(id) {
            if (id == 'discountcoupon') {
                $('#discountcoupon').addClass('navtab-active');
                $('#amount').removeClass('navtab-active');

                $('#discountcoupon-content').toggle(true)
                $('#amount-content').toggle(false)
            }

            else if (id == 'amount') {
                $('#discountcoupon').removeClass('navtab-active');
                $('#amount').addClass('navtab-active');

                $('#discountcoupon-content').toggle(false)
                $('#amount-content').toggle(true)
            }
        }

    var chart_labels = new Array();
    var chart_discounted_coupon = new Array();
    var chart_amounts = new Array();

    @if ($date != null)
        @php
            $sorted_by_date_discounted_coupon = [];
            $sorted_by_date_amounts = [];
        @endphp

        @foreach ($period as $date_period)
            chart_labels.push("{{ date('F d, Y', strtotime($date_period)) }}")
        
            @php
                $date_day = date('d', strtotime($date_period));
                $date_month = date('m', strtotime($date_period));
                $date_year = date('Y', strtotime($date_period));

                $sorted_by_date_discounted_coupon[] = \App\Coupon::whereDay('created_at', $date_day)
                    ->whereMonth('created_at', $date_month)
                    ->whereYear('created_at', $date_year)
                    ->count();

                $sorted_by_date_amounts[] = \App\Order::where('coupon_discount', '!=', null)
                    ->whereDay('created_at', $date_day)
                    ->whereMonth('created_at', $date_month)
                    ->whereYear('created_at', $date_year)
                    ->sum('coupon_discount');
            @endphp
        @endforeach

        @foreach ($sorted_by_date_discounted_coupon as $date_discounted_coupon)
            chart_discounted_coupon.push("{{ $date_discounted_coupon }}")
        @endforeach

        @foreach ($sorted_by_date_amounts as $date_amount)
            chart_amounts.push("{{ $date_amount }}")
        @endforeach
    @else 
        @foreach ($days as $key => $day)
            chart_labels.push("{{ $current_month }} {{ $day }}")
        @endforeach

        @foreach ($discounted_coupon as $key => $coupon)
            chart_discounted_coupon.push("{{ $coupon }}")
        @endforeach

        @foreach ($amounts as $key => $amount)
            chart_amounts.push("{{ $amount }}")
        @endforeach
    @endif

    var discountcoupon = document.getElementById('discountcouponChart').getContext('2d'); 
    var discountcouponChart = new Chart(discountcoupon, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Discounted Coupons',
                data: chart_discounted_coupon,
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

    var amounts = document.getElementById('amountChart').getContext('2d'); 
    var amountChart = new Chart(amounts, {

        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: 'Amounts',
                data: chart_amounts,
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