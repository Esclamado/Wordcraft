<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\AffiliateController;
use App\Order;
use App\Product;
use App\ProductStock;
use App\Color;
use App\OrderDetail;
use App\CouponUsage;
use App\OtpConfiguration;
use App\User;
use App\BusinessSetting;
use Auth;
use Session;
use DB;
use PDF;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\OrderPayment;

// Reseller Models
use App\ResellerCustomer;
use App\ResellerCustomerOrder;

// Employee Models
use App\EmployeeReseller;
use App\EmployeeCustomer;
use App\EmployeeCustomerOrder;

// Declined order
use App\Http\Controllers\OrderDeclinedController;

// Paynamics Integration
use App\Http\Controllers\PaynamicsController;
use App\PaynamicsTransactionRequest;

use App\OrderNote;

use App\Http\Controllers\WorldcraftApiController;
use App\Coupon;

// Logging
use App\Http\Controllers\CmgLogController;
use App\Http\Controllers\MLM\v1\WebhookController;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.seller_id', Auth::user()->id)
            ->select('orders.id')
            ->distinct();

        if ($request->payment_status != null) {
            $orders = $orders->where('order_details.payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }

        if ($request->delivery_status != null) {
            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }

        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }

        $orders = $orders->paginate(15);

        foreach ($orders as $key => $value) {
            $order = \App\Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }

        return view('frontend.user.seller.orders', compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }

    // All Orders
    public function all_orders(Request $request)
    {
        $date = $request->date;
        $col_name = 'created_at';
        $query = 'desc';
        $sort_search = null;
        $paym_status = null;
        $delivery_status = null;
        $type = $col_name . ',' . $query;
        $pup_location = null;

        $orders = Order::rightJoin('users as a', 'a.id', '=', 'orders.user_id')
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->select('orders.id', 'orders.code', 'orders.grand_total', 'orders.payment_status', 'orders.created_at', 'a.first_name', 'a.last_name', 'orders.cr_number', 'orders.som_number', 'orders.dr_number', 'orders.si_number', 'orders.pickup_point_location', 'order_details.delivery_status', 'a.user_type', 'a.referred_by', 'a.display_name')
            ->where('is_walkin', null)
            ->distinct();

        if ($request->search != null) {
            $sort_search = $request->search;

            $orders = $orders->where(function ($query) use ($sort_search) {
                $query->where('code', 'like', '%' . $sort_search . '%')
                    ->orWhere('a.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('delivery_status', 'like', '%' . $sort_search . '%')
                    ->orWhere('cr_number', 'like', '%' . $sort_search . '%');
            });
        }

        if ($date != null) {
            $start_date = date('Y-m-d', strtotime(explode(" to ", $date)[0]));
            $end_date   = date('Y-m-d', strtotime(explode(" to ", $date)[1]));

            if ($start_date == $end_date) {
                $orders = $orders->whereDate('orders.created_at', $start_date);
            } else {
                $orders = $orders->whereDate('orders.created_at', '>=', $start_date)
                    ->whereDate('orders.created_at', '<=', $end_date);
            }
        }

        if ($request->type != null) {
            $type = $request->type;

            $var = explode(",", $type);
            $col_name = $var[0];
            $query = $var[1];

            if ($col_name == 'orderDetails') {
                $orders = $orders->withCount('orderDetails');
                $orders = $orders->orderBy('order_details_count', $query);
            } else {
                $orders = $orders->orderBy($col_name, $query);
            }
        } else {
            $orders = $orders->orderBy($col_name, $query);
        }

        if ($request->payment_status != null) {
            $paym_status = $request->payment_status;

            $orders = $orders->where('orders.payment_status', '=', $paym_status);
        }

        if ($request->delivery_status != null) {
            $delivery_status = $request->delivery_status;

            $orders = $orders->where('order_details.delivery_status', 'like', '%' . $delivery_status . '%');
        }

        if ($request->pup_location != null) {
            $pup_location = $request->pup_location;

            $orders = $orders->where('orders.pickup_point_location', $pup_location);
        }

        if (Auth::user()->user_type == 'staff') {
            $pup_location_id = \App\PickupPoint::where('staff_id', 'like', '%' . Auth::user()->staff->id . '%')
                ->pluck('id');

            $pup_location = \App\PickupPoint::whereIn('id', $pup_location_id)
                ->get();

            $orders = $orders->where(function ($query) use ($pup_location) {
                foreach ($pup_location as $location) {
                    $query->orWhere('orders.pickup_point_location', mb_strtolower(str_replace(' ', '_', $location->name)));
                }
            });

            $pup_location = $request->pup_location;
        }

        if (Auth::user()->user_type == 'staff' && Auth::user()->staff->role->name == 'CMG') {
            $orders = $orders->where('orders.payment_status', 'paid');
        }

        $orders = $orders->paginate(15);

        return view('backend.sales.all_orders.index', compact('orders', 'sort_search', 'date', 'col_name', 'query', 'paym_status', 'delivery_status', 'pup_location'));
    }

    public function all_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));

        $proof_of_payments = OrderPayment::where('order_id', $order->id)
            ->get();

        $notes_for_customer = OrderNote::where('order_id', $order->id)
            ->where('type', 'customer')
            ->latest()
            ->paginate(10);

        $notes_for_admin = OrderNote::where('order_id', $order->id)
            ->where('type', 'admin')
            ->latest()
            ->paginate(10);
            
        $cmg_logs = \App\CmgLog::where('order_id', $order->id)
        
            ->latest()
            ->paginate(10);
           
        return view('backend.sales.all_orders.show', compact('order', 'proof_of_payments', 'notes_for_customer', 'notes_for_admin', 'cmg_logs'));
    }

    // Inhouse Orders
    public function admin_orders(Request $request)
    {
        $date = $request->date;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.seller_id', $admin_user_id)
            ->select('orders.id')
            ->distinct();

        if ($request->payment_type != null) {
            $orders = $orders->where('order_details.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($date != null) {
            $orders = $orders->where('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.inhouse_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'date'));
    }

    public function show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();

        $proof_of_payment = OrderPayment::where('order_id', $order->id)
            ->first();

        return view('backend.sales.inhouse_orders.show', compact('order', 'proof_of_payment'));
    }

    // Seller Orders
    public function seller_orders(Request $request)
    {
        $date = $request->date;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.seller_id', '!=', $admin_user_id)
            ->select('orders.id')
            ->distinct();

        if ($request->payment_type != null) {
            $orders = $orders->where('order_details.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($date != null) {
            $orders = $orders->where('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.seller_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'date'));
    }

    public function seller_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('backend.sales.seller_orders.show', compact('order'));
    }


    // Pickup point orders
    public function pickup_point_order_index(Request $request)
    {
        $date = $request->date;
        $sort_search = null;

        if (Auth::user()->user_type == 'staff' && Auth::user()->staff->pick_up_point != null) {
            //$orders = Order::where('pickup_point_id', Auth::user()->staff->pick_up_point->id)->get();
            $orders = DB::table('orders')
                ->orderBy('code', 'desc')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('order_details.pickup_point_id', Auth::user()->staff->pick_up_point->id)
                ->select('orders.id')
                ->distinct();

            if ($request->has('search')) {
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
            }
            if ($date != null) {
                $orders = $orders->where('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders'));
        } else {
            //$orders = Order::where('shipping_type', 'Pick-up Point')->get();
            $orders = DB::table('orders')
                ->orderBy('code', 'desc')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('order_details.shipping_type', 'pickup_point')
                ->select('orders.id')
                ->distinct();

            if ($request->has('search')) {
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
            }
            if ($date != null) {
                $orders = $orders->where('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
        }
    }

    public function pickup_point_order_sales_show($id)
    {
        if (Auth::user()->user_type == 'staff') {
            $order = Order::findOrFail(decrypt($id));

            $proof_of_payment = OrderPayment::where('order_id', $order->id)
                ->first();
            return view('backend.sales.pickup_point_orders.show', compact('order'));
        } else {
            $order = Order::findOrFail(decrypt($id));

            $proof_of_payment = OrderPayment::where('order_id', $order->id)
                ->first();
            return view('backend.sales.pickup_point_orders.show', compact('order', 'proof_of_payment'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $order = new Order;

        if (Auth::check()) {
            $order->user_id = Auth::user()->id;
        } else {
            $order->guest_id = mt_rand(100000, 999999);
        }

        $order->shipping_address = (json_encode($request->session()->get('shipping_info'))) ?? null;

        $order->payment_type = $request->payment_option;
        $order->delivery_viewed = '0';
        $order->payment_status_viewed = '0';
        $order->date = strtotime('now');
        $order->payment_option = $request->payment_type;
        $order->note = $request->note;
        $order->is_walkin          = '1';
        

        if ($request->payment_type == 'paynamics') {
            $order->payment_channel = $request->payment_channel;
        }

        $order->pickup_point_location = $request->pickup_point_location;

        if ($order->save()) {
            $now = \Carbon\Carbon::now();

            $order->code = $now->year . $now->month . '-' . $order->id;
            $order->unique_code = $order->id . '-' . unique_order_code();

            $subtotal = 0;
            $tax = 0;
            $shipping = 0;

            //calculate shipping is to get shipping costs of different types
            $admin_products = array();
            $seller_products = array();

            $referral_code = null;

            $cartLeft = collect(Session::get('cart'));

            //Order Details Storing
            // foreach (Session::get('cart')->where('owner_id', Session::get('owner_id')) as $key => $cartItem){

            $toCheckout = Session::get('toCheckout');

            // foreach ($toCheckout['dataToSave'] as $key => $cartItem){
            foreach ($toCheckout as $key => $cartItem) {
                // $product = Product::find($cartItem['id']);

                if ($cartItem->pickup_location == $request->pickup_point_location) {
                    $cart_left_handle = collect();
                    foreach ($cartLeft as $onCartKey => $onCartItem) {
                        if ($onCartItem['id'] == $cartItem->id && $onCartItem['pickup_location'] == $cartItem->pickup_location && $onCartItem['variant'] == $cartItem->variant) {
                        } else {
                            $cart_left_handle->push($onCartItem);
                        }
                    }
                    $cartLeft = $cart_left_handle;

                    $product = Product::find($cartItem->id);

                    if ($product->added_by == 'admin') {
                        // array_push($admin_products, $cartItem['id']);
                        array_push($admin_products, $cartItem->id);
                    } else {
                        $product_ids = array();
                        if (array_key_exists($product->user_id, $seller_products)) {
                            $product_ids = $seller_products[$product->user_id];
                        }
                        // array_push($product_ids, $cartItem['id']);
                        array_push($product_ids, $cartItem->id);
                        $seller_products[$product->user_id] = $product_ids;
                    }

                    // $subtotal += $cartItem['price']*$cartItem['quantity'];
                    $subtotal += $cartItem->price * $cartItem->quantity;
                    // $tax += $cartItem['tax']*$cartItem['quantity'];
                    $tax += $cartItem->tax * $cartItem->quantity;

                    // $product_variation = $cartItem['variant'];
                    $product_variation = $cartItem->variant;
                    $isPickupPointLocation = $cartItem->pickup_location ? true : false;

                    if (!$isPickupPointLocation) {
                        if ($product_variation != null) {
                            $product_stock = $product->stocks->where('variant', $product_variation)->first();
                            // if($product->digital != 1 &&  $cartItem['quantity'] > $product_stock->qty){
                            if ($product->digital != 1 &&  $cartItem->quantity > $product_stock->qty) {
                                flash(translate('The requested quantity is not available for ') . $product->getTranslation('name'))->warning();
                                $order->delete();
                                return redirect()->route('cart')->send();
                            } else {
                                // $product_stock->qty -= $cartItem['quantity'];
                                $product_stock->qty -= $cartItem->quantity;
                                $product_stock->save();
                            }
                        } else {
                            // if ($product->digital != 1 && $cartItem['quantity'] > $product->current_stock) {
                            if ($product->digital != 1 && $cartItem->quantity > $product->current_stock) {
                                flash(translate('The requested quantity is not available for ') . $product->getTranslation('name'))->warning();
                                $order->delete();
                                return redirect()->route('cart')->send();
                            } else {
                                // $product->current_stock -= $cartItem['quantity'];
                                $product->current_stock -= $cartItem->quantity;
                                $product->save();
                            }
                        }
                    }

                    $order_detail = new OrderDetail;

                    $order_detail->order_id  = $order->id;
                    $order_detail->seller_id = $product->user_id;
                    $order_detail->product_id = $product->id;
                    $order_detail->variation = $product_variation;
                    $order_detail->order_type = strtolower($cartItem->pickup_order);
                    // $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                    $order_detail->price = $cartItem->price * $cartItem->quantity;
                    // $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                    $order_detail->tax = $cartItem->tax * $cartItem->quantity;
                    // $order_detail->shipping_type = $cartItem['shipping_type'];
                    $order_detail->shipping_type = $cartItem->shipping_type ?? null;
                    // $order_detail->product_referral_code = $cartItem['product_referral_code'];
                    $order_detail->product_referral_code = $cartItem->product_referral_code;

                    // $referral_code = $cartItem['product_referral_code'];
                    $referral_code = $cartItem->product_referral_code;
                    //Dividing Shipping Costs
                    // if ($cartItem['shipping_type'] == 'home_delivery') {
                    if ($order_detail->shipping_type == 'home_delivery') {
                        $order_detail->shipping_cost = getShippingCost($key);
                    } else {
                        if ($isPickupPointLocation) {
                            foreach (Session::get('handlingFee') as $hfKey => $hfValue) {
                                if (strtolower(str_replace(' ', '_', $hfValue->name)) == $cartItem->pickup_location) {
                                    $order_detail->shipping_cost = $hfValue->handling_fee;
                                }
                            }
                        } else {
                            $order_detail->shipping_cost = 0;
                        }
                    }

                    $shipping += $order_detail->shipping_cost;

                    // if ($cartItem['shipping_type'] == 'pickup_point') {
                    if ($order_detail->shipping_type == 'pickup_point') {
                        $order_detail->pickup_point_id = $cartItem['pickup_point'];
                    }
                    //End of storing shipping cost

                    // $order_detail->quantity = $cartItem['quantity'];
                    $order_detail->quantity = $cartItem->quantity;
                    $order_detail->save();

                    $product->num_of_sale++;
                    $product->save();
                }
            }

            if (count($cartLeft) <= 0) {
                $request->session()->forget('cart');
            } else {
                $request->session()->put('cart', $cartLeft);
            }

            $convenience_fee = 0;

            if ($request->payment_type == 'paynamics') {
                // get payment channel
                $payment_channel = \App\PaymentChannel::where('status', 1)
                    ->where('value', $request->payment_channel)
                    ->first();

                if ($payment_channel->rate == 'fixed') {
                    $convenience_fee = $payment_channel->price;
                } else {
                    $total_without_convenience_fee = $subtotal + $tax + $shipping;

                    $convenience_fee = ($payment_channel->price / 100) * $total_without_convenience_fee;
                }
            }

            $order->grand_total = $subtotal + $tax + $shipping + $convenience_fee;
            $order->convenience_fee = $convenience_fee;

            if (Session::has('coupon_discount')) {
                $order->grand_total -= Session::get('coupon_discount');
                $order->coupon_discount = Session::get('coupon_discount');

                $coupon = Coupon::where('id', Session::get('coupon_id'))->first();

                $order->coupon_code = $coupon->code;

                $usage = CouponUsage::where('user_id', Auth::user()->id)
                    ->where('coupon_id', Session::get('coupon_id'))
                    ->first();

                if ($usage != null) {
                    $coupon->usage_limit -= 1;
                    $coupon->save();

                    $usage->usages += 1;
                    $usage->save();
                } else {
                    $coupon->usage_limit -= 1;
                    $coupon->save();

                    $coupon_usage = new CouponUsage;

                    $coupon_usage->user_id = Auth::user()->id;
                    $coupon_usage->coupon_id = Session::get('coupon_id');
                    $coupon_usage->usages += 1;
                    $coupon_usage->save();
                }
            }

            $order->save();

            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_order')->first()->value) {
                try {
                    $otpController = new OTPVerificationController;
                    $otpController->send_order_code($order);
                } catch (\Exception $e) {
                }
            }

            // If referrer is reseller
            if ($referral_code != "") {
                $referrer_user = User::where('referral_code', $referral_code)->first();

                $order_details = OrderDetail::where('order_id', $order->id)
                    ->where('product_referral_code', $referral_code)
                    ->count();

                if ($referrer_user->user_type == 'reseller') {
                    $referral_customer = ResellerCustomer::where('customer_id', Auth::user()->id)
                        ->where('reseller_id', $referrer_user->id)
                        ->exists();

                    if (!$referral_customer) {
                        $customer = new ResellerCustomer;

                        $customer->reseller_id = $referrer_user->id;
                        $customer->customer_id = Auth::user()->id;
                        $customer->total_orders += 1;
                        $customer->last_order_date = \Carbon\Carbon::now();

                        $customer->save();
                    } else {
                        $customer = ResellerCustomer::where('customer_id', Auth::user()->id)->first();

                        $customer->total_orders += 1;
                        $customer->last_order_date = \Carbon\Carbon::now();

                        $customer->save();
                    }

                    $customer_order = new ResellerCustomerOrder;

                    $customer_order->reseller_id        = $referrer_user->id;
                    $customer_order->customer_id        = Auth::user()->id;
                    $customer_order->order_id           = $order->id;
                    $customer_order->order_code         = $order->code;
                    $customer_order->date               = $order->date;
                    $customer_order->number_of_products = $order_details;
                    $customer_order->order_status       = 'pending';
                    $customer_order->payment_status     = 'unpaid';
                    
                    $customer_order->save();
                } elseif ($referrer_user->user_type == 'employee') {
                    $referral_customer = EmployeeCustomer::where('customer_id', Auth::user()->id)
                        ->where('employee_id', $referrer_user->id)
                        ->exists();

                    $order_details = OrderDetail::where('order_id', $order->id)
                        ->where('product_referral_code', $referral_code)
                        ->count();

                    if (!$referral_customer) {
                        $customer = new EmployeeCustomer;

                        $customer->employee_id = $referrer_user->id;
                        $customer->customer_id = Auth::user()->id;
                        $customer->total_orders += 1;
                        $customer->last_order_date = \Carbon\Carbon::now();

                        $customer->save();
                    } else {
                        $customer = EmployeeCustomer::where('customer_id', Auth::user()->id)->first();

                        $customer->total_orders += 1;
                        $customer->last_order_date = \Carbon\Carbon::now();

                        $customer->save();
                    }

                    $customer_order = new EmployeeCustomerOrder;

                    $customer_order->employee_id        = $referrer_user->id;
                    $customer_order->customer_id        = Auth::user()->id;
                    $customer_order->order_id           = $order->id;
                    $customer_order->order_code         = $order->code;
                    $customer_order->date               = $order->date;
                    $customer_order->number_of_products = $order_details;
                    $customer_order->order_status       = 'pending';
                    $customer_order->payment_status     = 'unpaid';

                    $customer_order->save();
                }
            } else if ($order->user->referred_by != null) {

                $referrer_user = User::where('id', $order->user->referred_by)
                    ->first();

                $order_details = OrderDetail::where('order_id', $order->id)
                    ->count();

                if ($referrer_user->user_type == 'employee') {
                    if ($order->user->user_type == 'customer') {
                        $referral_customer = EmployeeCustomer::where('customer_id', $order->user_id)
                            ->where('employee_id', $referrer_user->id)
                            ->exists();

                        $order_details = OrderDetail::where('order_id', $order->id)
                            ->count();

                        if (!$referral_customer) {
                            $customer = new EmployeeCustomer;

                            $customer->employee_id = $referrer_user->id;
                            $customer->customer_id = $order->user_id;
                            $customer->total_orders += 1;
                            $customer->last_order_date = \Carbon\Carbon::now();

                            $customer->save();
                        } else {
                            $customer = EmployeeCustomer::where('customer_id', $order->user_id)
                                ->first();

                            $customer->total_orders += 1;
                            $customer->last_order_date = \Carbon\Carbon::now();

                            $customer->save();
                        }

                        $customer_order = new EmployeeCustomerOrder;

                        $customer_order->employee_id            = $referrer_user->id;
                        $customer_order->customer_id            = $order->user_id;
                        $customer_order->order_id               = $order->id;
                        $customer_order->order_code             = $order->code;
                        $customer_order->date                   = $order->date;
                        $customer_order->number_of_products     = $order_details;
                        $customer_order->order_status           = 'pending';
                        $customer_order->payment_status         = 'unpaid';

                        $customer_order->save();
                    } else if ($order->user->user_type == 'reseller') {

                        $referral_customer = EmployeeReseller::where('reseller_id', $order->user_id)
                            ->where('employee_id', $referrer_user->id)
                            ->exists();

                        $order_details = OrderDetail::where('order_id', $order->id)
                            ->count();

                        if ($referral_customer) {
                            $employee_reseller_order = new \App\EmployeeResellerOrder;

                            $employee_reseller_order->employee_id = $referrer_user->id;
                            $employee_reseller_order->reseller_id = $order->user_id;
                            $employee_reseller_order->order_id = $order->id;
                            $employee_reseller_order->order_code = $order->code;
                            $employee_reseller_order->date = $order->date;
                            $employee_reseller_order->number_of_products = $order_details;
                            $employee_reseller_order->order_status = 'pending';
                            $employee_reseller_order->payment_status = 'unpaid';

                            $employee_reseller_order->save();
                        }
                    }
                }
            }

            if ($request->payment_type == 'paynamics') {
                $handle_paynamics = new PaynamicsController;
                $response = $handle_paynamics->handle_payment($request->payment_option, $request->payment_channel, $order);

                $order->payment_reference = json_decode($response)->pay_reference ?? null;
                $order->save();

                try {
                    $paynamics_transaction = new PaynamicsTransactionRequest;

                    $paynamics_transaction->user_id = $order->user_id;
                    $paynamics_transaction->notifiable_id = $order->id;
                    $paynamics_transaction->type = 'order';
                    $paynamics_transaction->request_id = $order->unique_code;
                    $paynamics_transaction->response_id = json_decode($response)->response_id ?? null;
                    $paynamics_transaction->timestamp = json_decode($response)->timestamp ?? null;
                    $paynamics_transaction->expiry_limit = json_decode($response)->expiry_limit ?? null;
                    $paynamics_transaction->pay_reference = json_decode($response)->pay_reference ?? null;
                    $paynamics_transaction->direct_otc_info = json_encode(json_decode($response)->direct_otc_info) ?? null;
                    $paynamics_transaction->signature = json_decode($response)->signature ?? null;
                    $paynamics_transaction->response_code = json_decode($response)->response_code ?? null;
                    $paynamics_transaction->response_message = json_decode($response)->response_message ?? null;
                    $paynamics_transaction->response_advise = json_decode($response)->response_advise ?? null;

                    $paynamics_transaction->save();
                } catch (\Exception $e) {
                    \Log::error($e);
                }
            }

            $worldcraft_stock_api = new WorldcraftApiController;
            // ito ung nagbbawas sa quantity sa table ng worldcraft stocks
            // $worldcraft_stock_api->pass_stocks_update($order);
           

            $new_order = new WebhookController();
            $new_order->send_webhook_response_new_order($order);

            $array['view'] = 'emails.invoice';
            $array['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
            $array['from'] = env('MAIL_USERNAME');
            $array['order'] = $order;

            foreach ($seller_products as $key => $seller_product) {
                try {
                    Mail::to(\App\User::find($key)->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {
                }
            }

            //sends email to customer with the invoice pdf attached
            if (env('MAIL_USERNAME') != null) {
                try {
                    Mail::to(Auth::user()->email)->queue(new InvoiceEmailManager($array));
                    Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {
                }
            }

            return $order->id;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $reason = null)
    {
        $order = Order::findOrFail($id);

        if ($order != null) {
            // Return stocks
            foreach ($order->orderDetails as $order_detail) {
                $pickup_point_location = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $order->pickup_point_location)))->first();

                if ($pickup_point_location != null) {
                    if ($order_detail->variation != null || $order_detail->variation != "") {
                        $product_stock = \App\ProductStock::where('product_id', $order_detail->product_id)
                            ->where('variant', $order_detail->variation)
                            ->first();

                        if ($product_stock != null) {
                            $qty_ordered = $order_detail->quantity;

                            $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $product_stock->sku)
                                ->where('pup_location_id', $pickup_point_location->id)
                                ->first();

                            $worldcraft_stock->quantity += $qty_ordered;
                            $worldcraft_stock->save();
                        }
                    } else {
                        $qty_ordered = $order_detail->quantity;

                        $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $order_detail->product->sku)
                            ->where('pup_location_id', $pickup_point_location->id)
                            ->first();

                        if ($worldcraft_stock != null) {
                            $worldcraft_stock->quantity += $qty_ordered;
                            $worldcraft_stock->save();
                        }
                    }
                }
            }

            // Pass cancelled order api
            $pass_cancelled_order = new \App\Http\Controllers\WorldcraftApiController;
            $pass_cancelled_order->cancelled_order($order);

            // Save declined order
            $declined_order = new OrderDeclinedController;
            $declined_order->store($order, $reason);

            foreach ($order->orderDetails as $key => $orderDetail) {
                try {
                    if ($orderDetail->variation != null) {
                        $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variation)->first();

                        if ($product_stock != null) {
                            $product_stock->qty += $orderDetail->quantity;
                            $product_stock->save();
                        }
                    } else {
                        $product = $orderDetail->product;
                        $product->current_stock += $orderDetail->quantity;
                        $product->save();
                    }
                } catch (\Exception $e) {
                }

                $orderDetail->delete();
            }
            $order->delete();

            flash(translate('Order successfully deleted'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->save();
        return view('frontend.user.seller.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->save();

        $status = null;

        if ($request->status == 'partial_release') {
            $product_count = $order->orderDetails->sum('quantity');

            if ($product_count > 1) {
                // Do Nothing ...
            } else {
                return [
                    'success' => 0,
                    'status' => ucfirst(str_replace('_', ' ', $request->status)),
                ];
            }
        }

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                $status = $request->status;
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                $status = $request->status;
            }
        }

        if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_delivery_status')->first()->value) {
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_delivery_status($order);
            } catch (\Exception $e) {
            }
        }

        // Customer Order

        $customer_order = ResellerCustomerOrder::where('order_code', $order->code)
            ->exists();

        if ($customer_order) {
            $customer_order = ResellerCustomerOrder::where('order_code', $order->code)
                ->first();

            $customer_order->order_status = $status;
            $customer_order->save();
        }

        $customer_employee_order = EmployeeCustomerOrder::where('order_code', $order->code)
            ->exists();

        if ($customer_employee_order) {
            $customer_employee_order = EmployeeCustomerOrder::where('order_code', $order->code)
                ->first();

            $customer_employee_order->order_status = $status;
            $customer_employee_order->save();
        }

        $employee_reseller_order = \App\EmployeeResellerOrder::where('order_id', $order->id)
            ->exists();

        if ($employee_reseller_order) {
            $employee_reseller_order = \App\EmployeeResellerOrder::where('order_id', $order->id)
                ->first();

            $employee_reseller_order->order_status = $status;
            $employee_reseller_order->save();
        }

        $update_delivery_status_api = new \App\Http\Controllers\WorldcraftApiController;
        $update_delivery_status_api->delivery_status_update($order);

        return [
            'success' => 1,
            'status' => ucfirst(str_replace('_', ' ', $status)),
            'bare_status' => $status
        ];
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->save();

        if ($order->cr_number == null) {
            flash(translate('CR Number must be filled out first by the Treasurer'))->error();
            return redirect()->back();
        }

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }

        $status = 'paid';
        foreach ($order->orderDetails as $key => $orderDetail) {
            if ($orderDetail->payment_status != 'paid') {
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();

        if ($order->payment_status == 'paid' && $order->commission_calculated == 0) {
            if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() == null || !\App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
                if ($order->payment_type == 'cash_on_delivery') {
                    if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                        foreach ($order->orderDetails as $key => $orderDetail) {
                            $orderDetail->payment_status = 'paid';
                            $orderDetail->save();
                            if ($orderDetail->product->user->user_type == 'seller') {
                                $seller = $orderDetail->product->user->seller;
                                $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price * $commission_percentage) / 100;
                                $seller->save();
                            }
                        }
                    } else {
                        foreach ($order->orderDetails as $key => $orderDetail) {
                            $orderDetail->payment_status = 'paid';
                            $orderDetail->save();
                            if ($orderDetail->product->user->user_type == 'seller') {
                                $commission_percentage = $orderDetail->product->category->commision_rate;
                                $seller = $orderDetail->product->user->seller;
                                $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price * $commission_percentage) / 100;
                                $seller->save();
                            }
                        }
                    }
                } elseif ($order->manual_payment) {
                    if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                        foreach ($order->orderDetails as $key => $orderDetail) {
                            $orderDetail->payment_status = 'paid';
                            $orderDetail->save();
                            if ($orderDetail->product->user->user_type == 'seller') {
                                $seller = $orderDetail->product->user->seller;
                                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
                                $seller->save();
                            }
                        }
                    } else {
                        foreach ($order->orderDetails as $key => $orderDetail) {
                            $orderDetail->payment_status = 'paid';
                            $orderDetail->save();
                            if ($orderDetail->product->user->user_type == 'seller') {
                                $commission_percentage = $orderDetail->product->category->commision_rate;
                                $seller = $orderDetail->product->user->seller;
                                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
                                $seller->save();
                            }
                        }
                    }
                }
            }

            if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliatePoints($order);
            }

            if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
                if ($order->user != null) {
                    $clubpointController = new ClubPointController;
                    $clubpointController->processClubPoints($order);
                }
            }

            $order->commission_calculated = 1;
            $order->save();
        }

        if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value) {
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_payment_status($order);
            } catch (\Exception $e) {
            }
        }

        $customer_order = ResellerCustomerOrder::where('order_code', $order->code)
            ->exists();

        if ($customer_order) {
            $customer_order = ResellerCustomerOrder::where('order_code', $order->code)
                ->first();

            $customer_order->payment_status = $status;
            $customer_order->save();
        }

        $customer_employee_order = EmployeeCustomerOrder::where('order_code', $order->code)
            ->exists();

        if ($customer_employee_order) {
            $customer_employee_order = EmployeeCustomerOrder::where('order_code', $order->code)
                ->first();

            $customer_employee_order->payment_status = $status;
            $customer_employee_order->save();
        }

        if ($order->user->user_type == 'reseller' && $order->user->reseller->is_verified != 1) {
            $reseller = \App\Reseller::where('user_id', $order->user_id)
                ->first();

            $reseller->is_verified = 1;
            $reseller->verified_at = \Carbon\Carbon::now();
            $reseller->save();
        }

        // Check if reseller is employee's under
        $employee_reseller = EmployeeReseller::where('reseller_id', $order->user->id)
            ->exists();

        if ($employee_reseller) {
            $employee_reseller = EmployeeReseller::where('reseller_id', $order->user->id)
                ->first();

            $employee_reseller->remaining_purchase_to_be_verified -= $order->grand_total;
            $employee_reseller->total_successful_orders += 1;

            $minimum_purchase = \App\AffiliateOption::where('type', 'minimum_first_purchase')->first()->percentage;

            if ($order->grand_total >= $minimum_purchase) {
                $employee_reseller->is_verified = 1;
            }

            $employee_reseller->save();
        }

        $employee_reseller_order = \App\EmployeeResellerOrder::where('order_id', $order->id)
            ->exists();

        if ($employee_reseller_order) {
            $employee_reseller_order = \App\EmployeeResellerOrder::where('order_id', $order->id)
                ->first();

            $employee_reseller_order->payment_status = $status;
            $employee_reseller_order->save();
        }

        // Send update to api
        $update_payment_status_api = new \App\Http\Controllers\WorldcraftApiController;
        $update_payment_status_api->payment_status_update($order);

        return 1;
    }

    public function update_partial_release(Request $request, $id)
    {
        $this->validate($request, [
            'partial_released_qty' => 'required|numeric'
        ]);

        $order_detail = OrderDetail::where('id', $id)
            ->first();

        if ($order_detail->quantity > 1) {

            if ($request->partial_released_qty < $order_detail->quantity) {
                $order_detail->partial_released = 1;
                $order_detail->partial_released_qty = $request->partial_released_qty;

                $order_detail->save();
            } else {
                flash(translate("You can't release quantity more than the ordered quantity"))->error();
                return redirect()->back();
            }
        } else {
            flash(translate('Sorry but you cannot partial release items with one quantity'))->error();
            return redirect()->back();
        }

        flash(translate("Partial release successfully saved"))->success();
        return redirect()->back();
    }

    /**
     * Upload CR Number
     */
    public function cr_number(Request $request)
    {
        $this->validate($request, [
            'cr_number' => 'required|unique:orders,cr_number,' . $request->order_id
        ]);

        if (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name == 'Treasurer') {
            $order = Order::findOrFail($request->order_id);

            if (Auth::user()->user_type != 'admin' && $order->som_number != null && $order->si_number != null && $order->dr_number != null) {
                flash(translate("Sorry but you can't edit the cr number!"));
            } else {
                $data = [];
                $data['user_id'] = Auth::user()->id;
                $data['order_id'] = $order->id;

                if ($order->cr_number == null) {
                    $data['activity'] = "Added CR Number: $request->cr_number";
                } else {
                    $data['activity'] = "Updated CR Number: From $order->cr_number to $request->cr_number";
                }

                $cmg_log = new CmgLogController;
                $cmg_log->store($data);

                $order->cr_number = $request->cr_number;

                if ($order->save()) {
                    flash(translate("CR Number successfully saved!"))->success();
                } else {
                    flash(translate('Something went wrong!'))->error();
                }
            }
        } else {
            flash(translate("Sorry, but you don't have the right permission to add on this column"))->warning();
        }

        return redirect()->back();
    }

    /**
     * Upload CMG Number
     */
    public function upload_cmg(Request $request)
    {
        $this->validate($request, [
            'som_number' => 'required|unique:orders,som_number,' . $request->order_id,
            'som_number_date' => 'required|date',
            'si_number' => 'required|unique:orders,si_number,' . $request->order_id,
            'si_number_date' => 'required|date',
            'dr_number' => 'required|unique:orders,dr_number,' . $request->order_id,
            'dr_number_date' => 'required|date'
        ]);

        if (Auth::user()->user_type == 'admin' || Auth::user()->staff->role->name != 'CMG') {
            flash(translate("Sorry, but you don't have the right permission to add on this column"))->warning();
        } else {
            $order = Order::findOrFail($request->order_id);

            if ($order) {
                if ($request->has('som_number') && $request->som_number != $order->som_number) {
                    $data = [];
                    $data['user_id'] = Auth::user()->id;
                    $data['order_id'] = $order->id;

                    if ($order->som_number == null) {
                        $data['activity'] = "Added SOM Number: $request->som_number";
                    } else {
                        $data['activity'] = "Updated SOM Number: From $order->som_number to $request->som_number <br/> SOM Date: From $order->som_number_date to $request->som_number_date";
                    }

                    $cmg_log = new CmgLogController;
                    $cmg_log->store($data);
                }

                if ($request->has('si_number') && $request->si_number != $order->si_number) {
                    $data = [];
                    $data['user_id'] = Auth::user()->id;
                    $data['order_id'] = $order->id;

                    if ($order->si_number == null) {
                        $data['activity'] = "Added SI Number: $request->si_number";
                    } else {
                        $data['activity'] = "Updated SI Number: From: $order->si_number to $request->si_number <br/> SI Date: From $order->si_number_date to $request->si_number_date";
                    }

                    $cmg_log = new CmgLogController;
                    $cmg_log->store($data);
                }

                if ($request->has('dr_number') && $request->dr_number != $order->dr_number) {
                    $data = [];
                    $data['user_id'] = Auth::user()->id;
                    $data['order_id'] = $order->id;

                    if ($order->dr_number == null) {
                        $data['activity'] = "Added DR Number: $request->dr_number";
                    } else {
                        $data['activity'] = "Updated DR Number: From $order->dr_number to $request->dr_number <br/> DR Date: From $order->dr_number_date to $request->dr_number_date";
                    }

                    $cmg_log = new CmgLogController;
                    $cmg_log->store($data);
                }

                $order->som_number          = $request->som_number;
                $order->som_number_date     = $request->som_number_date;
                $order->si_number           = $request->si_number;
                $order->si_number_date      = $request->si_number_date;
                $order->dr_number           = $request->dr_number;
                $order->dr_number_date      = $request->dr_number_date;

                if ($order->save()) {
                    flash(translate("CMG Number's successfully updated"))->success();
                }
            } else {
                flash(translate('Something went wrong!'))->failed();
            }

            return redirect()->back();
        }
    }
}
