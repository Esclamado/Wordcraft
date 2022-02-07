<div style="margin-left:auto;margin-right:auto;">
    <style media="all">
        @import url('https://fonts.googleapis.com/css?family=Dejavu+Sans:400,700');
        *{
            margin: 0;
            padding: 0;
            line-height: 1.5;
            font-family: 'Dejavu Sans', sans-serif;
            color: #333542;
        }
        div{
            font-size: 1rem;
        }
        .gry-color *,
        .gry-color{
            color:#878f9c;
        }
        table{
            width: 100%;
        }
        table th{
            font-weight: normal;
        }
        table.padding th{
            padding: .5rem .7rem;
        }
        table.padding td{
            padding: .7rem;
        }
        table.sm-padding td{
            padding: .2rem .7rem;
        }
        .border-bottom td,
        .border-bottom th{
            border-bottom:1px solid #eceff4;
        }
        .text-left{
            text-align:left;
        }
        .text-right{
            text-align:right;
        }
        .small{
            font-size: .85rem;
        }
        .strong{
            font-weight: bold;
        }
    </style>
    
        @php
            $logo = get_setting('header_logo');
        @endphp
    
        <div style="background: #eceff4;padding: 1.5rem;">
            <table>
                <tr>
                    <td>
                        @if($logo != null)
                            <img src="{{ uploaded_asset($logo) }}" height="40" style="display:inline-block;">
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" height="40" style="display:inline-block;">
                        @endif
                    </td>
                </tr>
            </table>
    
        </div>
        <div style="border-bottom:1px solid #eceff4;margin: 0 1.5rem;"></div>
    
        <div style="padding: 1.5rem;">
            <table class="padding text-left small border-bottom">
                <thead>
                    <tr class="gry-color" style="background: #eceff4;">
                        <th>Date</th>
                        <th>Orders</th>
                        <th>Gross Sales</th>
                        <th>Returns</th>
                        <th>Coupons</th>
                        <th>Net Sales</th>
                        <th>Taxes</th>
                        <th>Shiping</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @foreach ($days as $key => $date)
                        @php
                            $now = \Carbon\Carbon::now();
                            $month = \Carbon\Carbon::parse($now)->format('m');
                            $year = \Carbon\Carbon::parse($now)->format('Y');
                        @endphp

                        <tr>
                            <td>{{ $current_month }} {{ $date }}, {{ \Carbon\Carbon::now()->year }}</td>
                            <td>
                                @php
                                    $orders = \App\Order::whereDay('created_at', $date)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->count();
                                @endphp

                                {{ $orders }}
                            </td>
                            <td>
                                @php
                                    $gross_sales_table = \App\Order::whereDay('created_at', $date)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->sum('grand_total');
                                @endphp

                                {{ single_price($gross_sales_table) }}
                            </td>
                            <td>
                                @php
                                    $returns_table = \App\RefundRequest::whereDay('created_at', $date)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->sum('refund_amount');
                                @endphp

                                {{ single_price($returns_table) }}
                            </td>
                            <td>
                                @php
                                    $coupons = \App\Order::whereDay('created_at', $date)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->sum('coupon_discount');
                                @endphp

                                {{ single_price($coupons) }}
                            </td>
                            <td>
                                @php
                                    $net_sales = \App\Order::where('payment_status', 'paid')
                                        ->whereDay('created_at', $date)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->sum('grand_total');
                                @endphp

                                {{ single_price($net_sales) }}
                            </td>
                            <td>
                                @php
                                    $total_sales = \App\Order::whereDay('created_at', $date)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->sum('grand_total');
                                @endphp

                                {{ single_price($total_sales) }}
                            </td>
                            <td>
                                @php
                                    $taxes_data = \App\OrderDetail::whereDay('created_at', $date)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->sum('tax');
                                @endphp

                                {{ single_price($taxes_data) }}
                            </td>
                            <td>
                                @php
                                    $shipping_costs_data = \App\OrderDetail::whereDay('created_at', $date)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->sum('shipping_cost');
                                @endphp

                                {{ single_price($shipping_costs_data) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
    </div>
    