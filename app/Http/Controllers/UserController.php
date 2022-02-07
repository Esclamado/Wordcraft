<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Controllers\OTPVerificationController;
use App\Reseller;

use App\Order;
use App\EmploymentStatusFile;
use App\EmployeeReseller;

// Declined Orders
use App\OrderDeclined;

use DB;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    /**
     * [login description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function login ($id) {
        $user = User::findOrFail(decrypt($id));

        $user->temporary_code = rand(100000, 999999);

        if ($user->save()) {
            $otp_code = new OTPVerificationController;
            $otp_code->send_login_code($user);

            return redirect()->route('user.login.verification', encrypt($user->id));
        }
    }

    /**
     * [verification description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function verification ($id) {
        $user = User::findOrFail(decrypt($id));

        if(Route::currentRouteName() == "walkin.verification"){
            return view('frontend.walkin.auth.otp_verification', compact('user'));
        }else{
            return view('backend.customer.customers.otp_verification', compact('user'));
        }
    }

    /**
     * [verify description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function verify (Request $request) {
        
        $this->validate($request, [
            'code' => 'required'
        ]);

        $user = User::findOrFail($request->user_id);

        if ($request->code == $user->temporary_code) {
            $user->temporary_code = '';
            $user->save();

            auth()->login($user, true);

            flash(translate("You are now logged in as: $user->name!"))->success();
            if(Route::currentRouteName() == "walkin.verify"){
                return redirect()->route('walkin.product');
            }else{
                return redirect()->route('home');
            }
        }

        else {
            flash(translate("The code you entered is invalid. Please ask $user->name for the code."))->error();
            return redirect()->back();
        }
    }

    /**
     * [reseller_lists description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resellers_list (Request $request) {
        $date = $request->date;
        $sort_search = null;
        $sort_by_verification = null;

        $resellers = User::where('user_type', 'reseller')
            ->orderBy('name', 'asc')
            ->distinct();

        if ($request->verification != null) {
            $sort_by_verification = $request->verification;

            $resellers = $resellers->whereHas('reseller', function ($query) use ($sort_by_verification) {
                $query->where('is_verified', $sort_by_verification);
            });
        }

        if ($request->has('search') && $request->search != null) {
            $sort_search = $request->search;

            $resellers = $resellers->where(function ($query) use ($sort_search) {
                $query->where('name', 'like', '%' . $sort_search . '%')
                ->orWhere('username', 'like', '%' . $sort_search . '%')
                ->orWhere('email', 'like', '%' . $sort_search . '%')
                ->orWhere('phone', 'like', '%' . $sort_search . '%');
            });
        }

        if ($date != null) {
            $start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
            $end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

            if ($start_date == $end_date) {
                $resellers = $resellers->where('created_at', '>=', $start_date);
            }

            else {
                $resellers = $resellers->where('created_at', '>=', $start_date)
                    ->where('created_at', '<=', $end_date);
            }
        }

        $resellers = $resellers->paginate(10);

        return view('backend.customer.resellers.index', compact('resellers', 'sort_search', 'date'));
    }

    /**
     * [employee_list description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function employee_list (Request $request) {
        $date = $request->date;
        $sort_search = null;

        $employees = User::where('user_type', 'employee')
            ->orderBy('name', 'asc')
            ->distinct();

        if ($request->has('search') && $request->search != null) {
            $sort_search = $request->search;

            $employees = $employees->where(function ($query) use ($sort_search) {
                $query->where('name', 'like', '%' . $sort_search . '%')
                    ->orWhere('username', 'like', '%' . $sort_search . '%')
                    ->orWhere('email', 'like', '%' . $sort_search . '%')
                    ->orWhere('phone', 'like', '%' . $sort_search . '%');
            });
        }

        if ($date != null) {
            $start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
            $end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

            if ($start_date == $end_date) {
                $employees = $employees->where('created_at', '>=', $start_date);
            }

            else {
                $employees = $employees->where('created_at', '>=', $start_date)
                    ->where('created_at', '<=', $end_date);
            }
        }

        $employees = $employees->paginate(10);

        return view('backend.customer.employees.index', compact('employees', 'sort_search', 'date'));
    }

    public function customer_user_show (Request $request, $id) {
        $date = $request->date;
        $col_name = null;
        $query = null;
        $sort_search = null;
        $paym_status = null;
        $deliver_status = null;

        $user = User::findOrFail(decrypt($id));

        $orders = Order::where('user_id', $user->id)
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->select('orders.id', 'orders.code', 'orders.grand_total', 'orders.payment_status', 'orders.created_at', 'order_details.delivery_status')
            ->distinct();

        if ($request->search != null) {
            $sort_search = $request->search;

            $orders = $orders->where('code', 'like', '%' . $sort_search . '%')
                ->orWhere('delivery_status', 'like', '%' . $sort_search . '%');
        }

        if ($date != null) {
            $start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
            $end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

            if ($start_date == $end_date) {
                $orders = $orders->where('orders.created_at', '>=', $start_date);
            }

            else {
                $orders = $orders->where('orders.created_at', '>=', $start_date)
                    ->where('orders.created_at', '<=', $end_date);
            }
        }

        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];

            if ($col_name == 'orderDetails') {
                $orders = $orders->withCount('orderDetails');
                $orders = $orders->orderBy('order_details_count', $query);
            }

            else {
                $orders = $orders->orderBy($col_name, $query);
            }
        }

        if ($request->payment_status != null) {
            $paym_status = $request->payment_status;

            $orders = $orders->where('orders.payment_status', '=', $paym_status);
        }

        if ($request->delivery_status != null) {
            $deliver_status = $request->delivery_status;

            $orders = $orders->where('order_details.delivery_status', 'like', '%'.$sort_search. '%');
        }

        $orders = $orders->paginate(15);

        return view('backend.customer.customers.show', compact('user', 'orders', 'sort_search', 'date', 'col_name', 'query', 'paym_status', 'deliver_status'));
    }

    public function reseller_user_show (Request $request, $id) {
        $user = User::where('user_type', 'reseller')
            ->where('id', decrypt($id))
            ->first();

        $reseller_uploaded_files = EmploymentStatusFile::where('reseller_id', $user->id)
            ->select('reseller_id', 'img_type', 'img')
            ->get();

        $sort_search = null;

        $customers = DB::table('reseller_customers')
            ->where('reseller_customers.reseller_id', '=', $user->id)
            ->orderBy('reseller_customers.created_at', 'desc')
            ->join('users', 'reseller_customers.customer_id', '=', 'users.id')
            ->select('reseller_customers.id', 'users.avatar', 'users.avatar_original', 'users.name', 'users.email', 'users.phone', 'reseller_customers.total_orders', 'reseller_customers.last_order_date')
            ->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;
            $customers = $customers->where('users.name', 'like', '%' . $sort_search . '%')
                ->orWhere('users.email', 'like', '%' . $sort_search . '%');
        }

        $customers = $customers->paginate(10);

        return view('backend.customer.resellers.show', compact('user', 'reseller_uploaded_files', 'customers', 'sort_search'));
    }

    public function employee_user_show (Request $request, $id) {
        $sort_search = null;
        
        $user = User::where('user_type', 'employee')
            ->where('id', decrypt($id))
            ->first();

        $resellers = EmployeeReseller::where('employee_id', $user->id)
            ->latest()
            ->distinct();

        $resellers = $resellers->paginate(10);        

        return view('backend.customer.employees.show', compact('user', 'resellers'));
    }

    public function declined_orders () {
        $declined_orders = OrderDeclined::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.user.declined_orders.index', compact('declined_orders'));
    }
}
