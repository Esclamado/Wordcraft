<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Seller;
use App\User;
use App\Search;
use App\WorldcraftUpdateStock;
use App\WorldcraftStock;
use Carbon\Carbon;
use App\Order;
use DB;
use App\Category;
use PDF;
use Auth;
use DateTime;

class ReportController extends Controller
{
    public function stock_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(15);
        return view('backend.reports.stock_report', compact('products','sort_by'));
    }

    public function in_house_sale_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('num_of_sale', 'desc')->where('added_by', 'admin');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(15);
        return view('backend.reports.in_house_sale_report', compact('products','sort_by'));
    }

    public function seller_sale_report(Request $request)
    {
        $sort_by =null;
        $sellers = Seller::orderBy('created_at', 'desc');
        if ($request->has('verification_status')){
            $sort_by = $request->verification_status;
            $sellers = $sellers->where('verification_status', $sort_by);
        }
        $sellers = $sellers->paginate(10);
        return view('backend.reports.seller_sale_report', compact('sellers','sort_by'));
    }

    public function wish_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(10);
        return view('backend.reports.wish_report', compact('products','sort_by'));
    }

    public function user_search_report(Request $request){
        $searches = Search::orderBy('count', 'desc')->paginate(10);
        return view('backend.reports.user_search_report', compact('searches'));
    }

    public function worldcraft_stocks (Request $request) {
        $sort_search = null;
        $date = $request->date;
        $filter = null;

        $stocks = WorldcraftStock::orderBy('created_at', 'desc')
            ->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;

            $stocks = $stocks->where(function ($query) use ($sort_search) {
                $query->whereHas('pickup_location', function ($q) use ($sort_search) {
                    $q->where('name', 'like', '%' . $sort_search . '%');
                })->orWhere('sku_id', 'like', '%' . $sort_search . '%');
            });
        }

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            if ($start_date == $end_date) {
                $stocks = $stocks->whereDate('created_at', $start_date);
            }

            else {
                $stocks = $stocks->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date);
            }
        }

        if ($request->has('filter') != null) {
            $filter = $request->filter;

            if ($filter == 'out_of_stocks') {
                $stocks = $stocks->where('quantity', 0);
            }

            if ($filter == 'low_stocks') {
                $stocks = $stocks->where('quantity', '<', 10)
                    ->where('quantity', '!=', 0);
            }

            if ($filter == 'in_stocks') {
                $stocks = $stocks->where('quantity', '>', 0);
            }
        }

        $stocks = $stocks->paginate(15);

        return view('backend.reports.worldcraft_stocks', compact('stocks', 'sort_search', 'date', 'filter'));
    }

    public function worldcraft_syncing_report(Request $request) {
        $sort_search = null;
        $change_type = null;
        $type = null;
        $date = $request->date;
        $pickup_point_filter = null;

        $pickup_points = \App\PickupPoint::orderBy('name', 'asc')->pluck('name', 'id');

        $stocks = WorldcraftUpdateStock::orderBy('created_at', 'desc')
            ->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;

            $stocks = $stocks->where(function ($query) use ($sort_search) {
                $query->whereHas('pickup_point', function ($q) use ($sort_search) {
                    $q->where('name', 'like', '%' . $sort_search . '%');
                })->orWhere('sku_id', 'like', '%' . $sort_search . '%');
            });
        }

        if ($request->change_type != "") {
            $change_type = $request->change_type;

            $stocks = $stocks->where('change_type', $change_type);
        }

        if ($request->type != "") {
            $type = $request->type;

            $stocks = $stocks->where('type', $type);
        }

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            if ($start_date == $end_date) {
                $stocks = $stocks->whereDate('created_at', $start_date);
            }

            else {
                $stocks = $stocks->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date);
            }
        }

        if ($request->has('pickup_point_filter')) {
            $pickup_point_filter = $request->pickup_point_filter;

            $stocks = $stocks->where('pup_location_id', $pickup_point_filter);
        }

        $stocks = $stocks->paginate(15);

        return view('backend.reports.worldcraft_syncing_updates', compact('stocks', 'sort_search', 'change_type', 'type', 'date', 'pickup_points', 'pickup_point_filter'));
    }

    /**
     * [all_users description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function all_users (Request $request) {
        $sort_search = null;
        $date = $request->date;
        $user_type = null;

        $users = User::distinct();

        if ($request->search != null) {
            $sort_search = $request->search;

            $users = $users->where('name', 'like', '%' . $sort_search . '%')
                ->orWhere('username', 'like', '%' . $sort_search . '%')
                ->orWhere('email', 'like', '%' . $sort_search . '%')
                ->orWhere('phone', 'like', '%' . $sort_search . '%');
        }

        if ($request->date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            if ($start_date == $end_date) {
                $users = $users->whereDate('created_at', $start_date);
            }

            else {
                $users = $users->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date);
            }
        }

        if ($request->user_type != null) {
            $user_type = $request->user_type;

            $users = $users->where('user_type', $user_type);
        }

        $users = $users->paginate(15);

        return view('backend.reports.all_users', compact('users', 'user_type', 'date', 'sort_search'));
    }

    public function orders_report (Request $request) {
        $period = null;
        $date = $request->date;

        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];
        $orders_count = [];
        $average_order_value = [];
        $average_items_order = [];
        $chart_net_sales = [];

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
    
                $orders_count[] = \App\Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
    
                $average_order_value[] = \App\Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->avg('grand_total');
    
                $average_order_item = \App\Order::withCount('orderDetails')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->pluck('order_details_count');
    
                    if (!is_array($average_order_item)) {
                        $sum = 0;
                        $amt = count($average_order_item);
    
                        foreach ($average_order_item as $num) {
                            $sum += $num;
                        }
    
                        $average = ($amt > 0) ? ($sum / $amt) : false;
                    }
    
                $average_items_order[] = $average;
    
                $chart_net_sales[] = \App\Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('grand_total');
            }
        }

        return view('backend.reports.orders_report', compact('days', 'current_month', 'orders_count', 'average_order_value', 'average_items_order', 'chart_net_sales', 'period', 'date'));
    }

    public function products_report (Request $request) {
        $period = null;
        $date = $request->date;

        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];
        $items_sold = [];
        $net_sales_data = [];
        $orders_data = [];

        $products = \App\ProductStock::where('sku', '!=', null);

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        
            // 
            if ($start_date == $end_date) {
                $products = $products->whereDate('created_at', $start_date);
            }
            
            else {
                $products = $products->whereBetween('created_at', [$start_date, $end_date]);
            }
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
    
                $items_sold[] = \App\OrderDetail::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
    
                $net_sales_data[] = Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('grand_total');
    
                $orders_data[] = Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
            }
        }

        $products = $products->paginate(10);

        $products->getCollection()->transform(function ($query) {
            $order_details_sum = \App\OrderDetail::where('variation', $query->variant)
                ->sum('price');

            $query->total_sold = format_price($order_details_sum);

            return $query;
        });

        return view('backend.reports.products_report', compact('days', 'current_month', 'items_sold', 'products', 'net_sales_data', 'orders_data', 'period', 'date'));
    }

    public function revenue_report (Request $request) {
        $period = null;
        $date = $request->date;

        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days_table = [];
        $days = [];
        $gross_sales = [];
        $returns_data = [];
        $coupons_data = [];
        $total_net_sales = [];
        $total_taxes_graph = [];
        $total_shipping_graph = [];
        $total_sales_graph = [];

        if ($date != null) {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
                $days_table[] = $day;
            }

            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
                $days_table[] = $day;
    
                $gross_sales[] = Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('grand_total');
    
                $returns_data[] = \App\RefundRequest::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('refund_amount');
    
                $coupons_data[] = Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('coupon_discount');
    
                $total_net_sales[] = Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('grand_total');
    
                $total_taxes_graph[] = \App\OrderDetail::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('tax');
    
                $total_shipping_graph[] = \App\OrderDetail::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('shipping_cost');
    
                $total_sales_graph[] = \App\Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('grand_total');
            }
        }
        
        return view('backend.reports.revenue_report', compact('days', 'current_month', 'gross_sales', 'returns_data', 'coupons_data', 'total_net_sales', 'total_taxes_graph', 'total_shipping_graph', 'total_sales_graph', 'days_table', 'period', 'date'));
    }

    public function variation_report (Request $request) {
        $period = null;
        $date = $request->date;
        
        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];
        $net_sales_data = [];
        $items_sold_data = [];
        $orders_data = [];

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
    
                $items_sold_data[] = \App\OrderDetail::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
    
                $net_sales_data[] = \App\Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('grand_total');
    
                $orders_data[] = \App\Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
            }
        }

        $product_variation = \App\ProductStock::orderBy('created_at', 'desc')
            ->where('variant', '!=', null)
            ->distinct()
            ->paginate(15);

        return view('backend.reports.variation_report', compact('days', 'current_month', 'net_sales_data', 'items_sold_data', 'orders_data', 'product_variation', 'period', 'date'));
    }

    public function category_report (Request $request) {
        $date = $request->date;
        $period = null;

        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];
        $items_sold_data = [];
        $net_sales_data = [];
        $orders_data = [];

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
    
                $items_sold_data[] = \App\OrderDetail::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
    
                $net_sales_data[] = \App\Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('grand_total');
    
                $orders_data[] = \App\Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
            }
        }

        $categories = \App\Category::where('level', 0)
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->paginate(15);

        return view('backend.reports.categories_report', compact('current_month', 'days', 'items_sold_data', 'net_sales_data', 'orders_data', 'categories', 'period', 'date'));
    }

    public function coupon_report (Request $request) {
        $date = $request->date;
        $period = null;

        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];
        $discounted_coupon = [];
        $amounts =  [];

        $start_date = null;
        $end_date = null;

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
    
                $discounted_coupon[] = \App\Coupon::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
                
                $amounts[] = \App\Order::where('coupon_discount', '!=', null)
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('coupon_discount');
            }
        }
        
        $coupons = \App\Coupon::orderBy('created_at', 'desc')
            ->distinct()
            ->paginate(15);

        return view('backend.reports.coupon_report', compact('days', 'current_month', 'discounted_coupon', 'amounts', 'coupons', 'start_date', 'end_date', 'period', 'date'));
    }

    public function tax_report (Request $request) {
        return view('backend.reports.tax_report');
    }

    public function stocks_report (Request $request) {
        return view('backend.reports.stocksreport');
    }

    public function download_report (Request $request) {
        $date = $request->date;
        $period = null;

        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];
        $downloads = [];
        
        $start_date = null;
        $end_date = null;

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
                
                $days[] = $day;
    
                $downloads[] = \App\ReportDownload::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
            } 
        }

        $all_downloads = \App\ReportDownload::orderBy('created_at', 'desc')
            ->paginate(15);

        return view('backend.reports.download_report', compact('days', 'current_month', 'downloads', 'all_downloads', 'start_date', 'end_date', 'period', 'date'));
    }

    public function overview_report (Request $request) {
        $period = null;
        $date = $request->date;

        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];
        $net_sales_data = [];
        $orders_data = [];
        
        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
    
                $net_sales_data[] = Order::where('payment_status', 'paid')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->sum('grand_total');
    
                $orders_data[] = Order::whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->count();
            }
        }

        $top_categories = Category::where('level', 0)
            ->paginate(10);

        $top_products = \App\Product::orderBy('num_of_sale', 'asc')
            ->paginate(10);

        return view('backend.reports.overview_report', compact('days', 'current_month', 'net_sales_data', 'orders_data', 'top_categories', 'top_products', 'period', 'date'));
    }

    public function island_report (Request $request) {
        $period = null;

        $date = $request->date;

        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];
        $orders = [];

        $north_luzon_orders = [];
        $south_luzon_orders = [];
        $visayas_orders = [];
        $mindanao_orders = [];

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            $period = \Carbon\CarbonPeriod::create($start_date, $end_date);
        }

        else {
            for ($i = 0; $i < $now->daysInMonth; $i++) {
                $day = $i + 1;
    
                $days[] = $day;
    
                $north_luzon_orders[] = Order::where('shipping_address', '!=', 'null')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "north_luzon"}\')')
                    ->count();
    
                $south_luzon_orders[] = Order::where('shipping_address', '!=', 'null')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "south_luzon"}\')')
                    ->count();
    
                $visayas_orders[] = Order::where('shipping_address', '!=', 'null')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "visayas"}\')')
                    ->count();
    
                $mindanao_orders[] = Order::where('shipping_address', '!=', 'null')
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', Carbon::parse($now)->format('m'))
                    ->whereYear('created_at', Carbon::parse($now)->format('Y'))
                    ->whereRaw('JSON_CONTAINS(shipping_address, \'{"island": "mindanao"}\')')
                    ->count();
            }
        }

        return view('backend.reports.island_report', compact('days', 'current_month', 'north_luzon_orders', 'south_luzon_orders', 'visayas_orders', 'mindanao_orders', 'date', 'period'));
    }

    public function pdf_download_worldcraft_stocks () 
    {
        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];

        for ($i = 0; $i < $now->daysInMonth; $i++) {
            $day = $i + 1;

            $days[] = $day;
        }
    }

    public function pdf_download_revenue_report ()
    {
        $now = Carbon::now();
        $current_month = Carbon::parse($now)->format('F');

        $days = [];

        for ($i = 0; $i < $now->daysInMonth; $i++) {
            $day = $i + 1;

            $days[] = $day;
        }

        try {
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                'logOutputFile' => storage_path('logs/log.htm'),
                'tempDir' => storage_path('logs/')
            ])->loadView('backend.downloads.revenue_report', compact('days', 'current_month'));
    
            $report_download = new \App\ReportDownload;
    
            $report_download->user_id = Auth::user()->id;
            $report_download->date = \Carbon\Carbon::now();
            $report_download->file_name = 'revenue_report_' . \Carbon\Carbon::parse($now)->format('Y-m-d') . '.pdf';
            $report_download->username = Auth::user()->name;
            $report_download->ip_address = request()->ip();
    
            $report_download->save();
        } catch (\Exception $e) {
            \Log::error($e);
        }
         
        return $pdf->download('revenue_report.pdf');
    }

    public function worldcraft_report() {
        $stocks = WorldcraftStock::orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])->loadView('backend.downloads.worldcraft_stocks_report', compact('stocks'));

        return $pdf->download('worldcraft_stocks_report.pdf');
    }
}
