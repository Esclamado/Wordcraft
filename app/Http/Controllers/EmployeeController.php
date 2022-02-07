<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

use DB;

use App\Order;
use App\RefundRequest;

// Reseller Models
use App\ResellerCustomer;
use App\ResellerEarning;
use App\ResellerCustomerOrder;

// Employee Models
use App\EmployeeReseller;
use App\EmployeeCustomer;
use App\EmployeeCustomerOrder;
use App\EmploymentStatusFile;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_resellers(Request $request)
    {
        $sort_search = null;

        $unverified_resellers = EmployeeReseller::where('employee_id', Auth::user()->id)
            ->where('is_verified', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $verified_resellers = DB::table('employee_resellers')
            ->where('employee_resellers.employee_id', '=', Auth::user()->id)
            ->where('employee_resellers.is_verified', '=', 1)
            ->orderBy('employee_resellers.created_at', 'desc')
            ->join('users', 'employee_resellers.reseller_id', '=', 'users.id')
            ->select('employee_resellers.reseller_id', 'users.name', 'users.avatar_original', 'users.avatar', 'employee_resellers.date_joined', 'employee_resellers.total_successful_orders', 'employee_resellers.total_earnings', 'employee_resellers.id')
            ->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;

            $verified_resellers = $verified_resellers->where('users.name', 'like', '%' . $sort_search . '%')
                ->orWhere('users.email', 'like'. '%' . $sort_search. '%');
        }

        $verified_resellers = $verified_resellers->paginate(10);

        return view('frontend.user.employee.my_resellers', compact('unverified_resellers', 'verified_resellers', 'sort_search'));
    }

    /**
     * Show reseller details
     *
     * @return \Illuminate\Http\Response
     */
    public function my_reseller_show($reseller_id)
    {
        $reseller = EmployeeReseller::where('reseller_id', decrypt($reseller_id))
            ->where('employee_id', Auth::user()->id)
            ->first();

        $transaction_histories = null;
        $reseller_uploaded_files = null;
        $collection = null;

        if ($reseller != null) {
            $reseller_uploaded_files = EmploymentStatusFile::where('reseller_id', $reseller->id)
                ->select('reseller_id', 'img_type', 'img')
                ->get();

            $reseller_customer_transaction_histories = ResellerCustomerOrder::where('reseller_id', $reseller->reseller_id)
                ->paginate(10);

            $reseller_transaction_histories = \App\EmployeeResellerOrder::where('reseller_id', $reseller->reseller_id)
                ->paginate(10);
        }

        return view('frontend.user.employee.my_reseller_show', compact('reseller', 'reseller_customer_transaction_histories', 'reseller_transaction_histories', 'reseller_uploaded_files'));
    }

    /**
     * Display a list of earnings
     *
     * @return \Illuminate\Http\Response
     */
    public function my_earnings(Request $request)
    {
        $sort_search = null;

        $earnings = DB::table('employee_earnings')
            ->where([
                ['employee_earnings.employee_id', '=', Auth::user()->id],
                ['employee_earnings.type', '=', 'customer_earning']
            ])
            ->orderBy('employee_earnings.created_at', 'desc')
            ->join('users', 'employee_earnings.customer_id', '=', 'users.id')
            ->join('orders', 'employee_earnings.order_id', '=', 'orders.id')
            ->distinct();

        if ($request->has('search') != null) {
            $sort_search = $request->search;

            $earnings = $earnings
                ->where([
                    ['employee_earnings.order_code', 'like', '%' . $sort_search . '%']
                ])
                ->orWhere([
                    ['users.name', 'like', '%' . $sort_search . '%'],
                    ['employee_earnings.employee_id', '=', Auth::user()->id],
                    ['employee_earnings.type', '=', 'customer_earning']
                ]);
        }

        $earnings = $earnings
            ->select(['users.avatar', 'users.avatar_original', 'users.name', 'employee_earnings.order_code', 'employee_earnings.paid_at', 'employee_earnings.amount', 'employee_earnings.income', 'employee_earnings.employee_id', 'employee_earnings.type', 'orders.id', 'orders.code'])
            ->paginate(10);

        return view('frontend.user.employee.earnings', compact('earnings', 'sort_search'));
    }

    /**
     * [my_earnings_order_show description]
     * @param  Requets $request [description]
     * @param  [type]  $slug    [description]
     * @return [type]           [description]
     */
    public function my_earnings_cutomer_order_show ($id)
    {
        $order = Order::where('id', decrypt($id))->firstOrFail();

        return view('frontend.user.employee.customers.order_code_show', compact('order'));
    }

    /**
     * Display a list of earnings for employee's resellers
     *
     * @return \Illuminate\Http\Response
     */
    public function my_earnings_reseller(Request $request)
    {
        $sort_search = null;

        $earnings = DB::table('employee_earnings')
            ->where([
                ['employee_earnings.employee_id', '=', Auth::user()->id],
                ['employee_earnings.type', '=', 'reseller_earning']
            ])
            ->orderBy('employee_earnings.created_at', 'desc')
            ->join('users', 'employee_earnings.reseller_id', '=', 'users.id')
            ->join('orders', 'employee_earnings.order_id', '=', 'orders.id')
            ->distinct();

        if ($request->has('search') != null) {
            $sort_search = $request->search;

            $earnings = $earnings
                ->where([
                    ['employee_earnings.order_code', 'like', '%' . $sort_search . '%']
                ])
                ->orWhere([
                    ['users.name', 'like', '%' . $sort_search . '%'],
                    ['employee_earnings.employee_id', '=', Auth::user()->id],
                    ['employee_earnings.type', '=', 'reseller_earning']
                ]);
        }

        $earnings = $earnings
            ->select(['employee_earnings.reseller_id', 'users.avatar', 'users.avatar_original', 'users.name', 'employee_earnings.order_code', 'employee_earnings.paid_at', 'employee_earnings.amount', 'employee_earnings.income', 'employee_earnings.employee_id', 'employee_earnings.type', 'orders.id', 'orders.code'])
            ->paginate(10);

        return view('frontend.user.employee.earnings_resellers', compact('earnings', 'sort_search'));
    }

    /**
     * [my_earnings_cutomer_order_show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function my_earnings_reseller_order_show ($id)
    {
        $order = Order::where('id', decrypt($id))->firstOrFail();

        return view('frontend.user.employee.resellers.order_code_show', compact('order'));
    }

    /**
     * Display a list of customer orders
     *
     * @return \Illuminate\Http\Response
     */
    public function my_customer_orders (Request $request)
    {
        $orders = EmployeeCustomerOrder::where('employee_id', Auth::user()->id)
            ->latest()
            ->distinct();

        $orders = $orders->paginate(10);

        return view('frontend.user.employee.customer_orders', compact('orders'));
    }

    public function my_customer_orders_returns (Request $request)
    {
        $customers = EmployeeCustomer::where('employee_id', Auth::user()->id)->pluck('customer_id');

        $orders = RefundRequest::whereIn('user_id', $customers)
            ->latest()
            ->paginate(10);

        return view('frontend.user.employee.customer_orders_returns', compact('orders'));
    }

    /**
     * Display a list of my customers
     *
     * @return \Illuminate\Http\Response
     */
    public function my_customers (Request $request)
    {
        $sort_search = null;

        $customers = DB::table('employee_customers')
            ->where('employee_customers.employee_id', '=', Auth::user()->id)
            ->orderBy('employee_customers.created_at', 'desc')
            ->join('users', 'employee_customers.customer_id', '=', 'users.id')
            ->select('employee_customers.id', 'users.avatar', 'users.avatar_original', 'users.name', 'users.email', 'users.phone', 'employee_customers.total_orders', 'employee_customers.last_order_date')
            ->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;
            $customers = $customers->where('users.name', 'like', '%' . $sort_search . '%')
                ->orWhere('users.email', 'like', '%' . $sort_search . '%');
        }

        $customers = $customers->paginate(10);

        return view('frontend.user.employee.my_customers', compact('customers', 'sort_search'));
    }

    /**
     * [my_customer_show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function my_customer_show($id)
    {
        $customer = EmployeeCustomer::where('id', decrypt($id))->first();

        $transaction_histories = DB::table('orders')
            ->where('user_id', $customer->customer_id)
            ->join('order_details', 'orders.id', '=', 'order_details.id')
            ->where('order_details.product_referral_code', '=', Auth::user()->referral_code)
            ->select('orders.code', 'orders.date', 'orders.grand_total', 'orders.payment_status', 'order_details.delivery_status')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(10);

        return view('frontend.user.employee.my_customer_show', compact('customer', 'transaction_histories'));
    }
}
