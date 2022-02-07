<?php

namespace App\Http\Controllers;

use App\Utility\PayfastUtility;
use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\InstamojoController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\PaytmController;
use App\Order;
use App\BusinessSetting;
use App\Coupon;
use App\CouponUsage;
use App\User;
use App\Address;
use Session;
use App\Utility\PayhereUtility;

// Reseller Function
use App\ResellerCustomer;
use App\ResellerCustomerOrder;

// Employee Function
use App\EmployeeReseller;
use App\EmployeeCustomer;
use App\EmployeeCustomerOrder;

// Paynamics Integration
use App\Http\Controllers\PaynamicsController;
use Redirect;

// Coupon
use App\CouponBundle;

//walkin
use Illuminate\Support\Facades\Route;

class CheckoutController extends Controller
{
    //check the selected payment gateway and redirect to that controller accordingly
    public function checkout(Request $request)
    {
       
        $user = Auth::user();

        // Check if item still exists
        // Check if item ordered still has a stock
        $items_for_checkout = Session::get('toCheckout');
      
        foreach ($items_for_checkout as $item) {
            $pickup_point_location = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $item->pickup_location)))
                ->select('id', 'name')
                ->first();

            $product = \App\Product::where('id', $item->id)
                ->select('id', 'name', 'advance_order')
                ->first();

            if ($item->variant != null) {
                $product_stock = \App\ProductStock::where('product_id', $item->id)
                    ->where('variant', $item->variant)
                    ->select('product_id', 'variant', 'sku')
                    ->first()->sku;

                $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $product_stock)
                    ->select('sku_id', 'pup_location_id', 'quantity')
                    ->where('pup_location_id', $pickup_point_location->id)
                    ->first();

                // check if there's still a quantity
                if ($worldcraft_stock->quantity < $item->quantity && $product->advance_order != 1) {
                    flash("There's no more stock for item $product->name");
                    return redirect()->back();
                }
            }

            else {
                $product_sku = $product->sku;

                $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $product_sku)
                    ->select('sku_id', 'pup_location_id', 'quantity')
                    ->where('pup_location_id', $pickup_point_location->id)
                    ->first();
                
                // Check if there's still a quantity
                if ($worldcraft_stock->quantity < $item->quantity && $product->advance_order != 1) {
                    flash("There's no more stock for item $product->name");
                    return redirect()->back();
                }
            }
        }


        if (Auth::user()->user_type == 'reseller') {
            if (Auth::user()->reseller->is_verified != 1) {
                $subtotal = 0;
                $tax = 0;
                $total = 0;

                $toCheckout = Session::get('toCheckout');

                foreach ($toCheckout as $key => $cartItem) {
                    $subtotal += $cartItem->price*$cartItem->quantity;
                    $tax += $cartItem->tax*$cartItem->quantity;
                }

                $total += $subtotal + $tax;

                $minimum_purchase = \App\AffiliateOption::where('type', 'minimum_first_purchase')->first()->percentage ?? "N/A";

                if ($total < $minimum_purchase) {
                    flash("You have to purchase a minimum amount of " . single_price($minimum_purchase) . " on your first purchase!");
                    return redirect()->back();
                }
            }
        }

        // Check if payment option is not null
        if ($request->payment_option != null) {
            // Check Payment Type if Paynamics or Other payment methods
            if ($request->payment_type == 'paynamics') {
                $payment_type = \App\PaymentMethodList::where('value', $request->payment_option)
                    ->first()->type;

                $this->process_checkout($request);
                

                $request->session()->forget('coupon_id');
                $request->session()->forget('coupon_discount');
                $request->session()->forget('owner_id');
                $request->session()->forget('delivery_info');

                $orders = Order::findOrFail(Session::get('order_ids'));

                flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
                return redirect()->route('order_confirmed_pending_paynamics', compact('orders'));
            }

            else if ($request->payment_type == 'other-payment-method') {
                // Check what payment option
                if ($request->payment_option == 'user-wallet')
                {
                    $subtotal = 0;
                    $tax = 0;
                    $shipping = 0;

                    foreach (Session::get('toCheckout') as $key => $cartItem) {
                        $subtotal   += $cartItem->price * $cartItem->quantity;
                        $tax        += $cartItem->tax * $cartItem->quantity;

                        foreach (Session::get('handlingFee') as $handlingFeeKey => $handlingFeeItem) {
                            if(strtolower(str_replace(' ', '_', $handlingFeeItem->name)) == $cartItem->pickup_location){
                                $shipping += $handlingFeeItem->handling_fee * $cartItem->quantity;
                            }
                        }
                    }

                    $grand_total = $subtotal + $tax + $shipping;

                    if ($user->balance >= $grand_total)
                    {
                        $this->process_checkout($request);
                      
                        foreach ($request->session()->get('order_ids') as $item) {
                            $order = Order::findOrFail($item);
                            
                            $user->balance -= $order->grand_total;
                            $user->save();
                        }
                    }

                    else {
                        flash(translate("You don't have enough money on your wallet!"))->error();
                        return redirect()->back();
                    }

                    return $this->checkout_done($request->session()->get('order_ids'), null);
                }

                else
                {
                    $payment_type = \App\OtherPaymentMethod::where('unique_id', $request->payment_option)
                        ->first()->type;

                    $this->process_checkout($request, $request->payment_type);

                    $request->session()->forget('coupon_id');
                    $request->session()->forget('coupon_discount');
                    $request->session()->forget('owner_id');
                    $request->session()->forget('delivery_info');

                    $orders = Order::findOrFail(Session::get('order_ids'));

                    flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();

                    $route = Route::currentRouteName();

                    /* change redirection for walkin */
                    if(strpos($route, 'walkin') !== false){
                        return redirect()->route('walkin.order_confirmed', compact('orders'));
                    }else{
                        if ($payment_type == 'single_payment_option') {
                            return redirect()->route('order_confirmed', compact('orders'));
                        } else {
                            return redirect()->route('order_confirmed_pending', compact('orders'));
                        }
                    }
                    
                }
            }
        }

        else {
            flash(translate('Please select your payment option'))->info();
            return redirect()->back();
        }
    }

    private function process_checkout($request): void
    {
        Session::forget('order_ids');

        $pickup_location = [];

        foreach (Session::get('toCheckout') as $key => $cartItem){
            if(!in_array($cartItem->pickup_location, $pickup_location)){
                array_push($pickup_location,$cartItem->pickup_location);
            }
        }

        $order_ids = [];

        foreach($pickup_location as $loc){
            $orderController = new OrderController;
            $request->pickup_point_location = $loc;
            $order_id = $orderController->store($request);
            array_push($order_ids, $order_id);
        }

        $request->session()->put('order_ids', $order_ids);
        $request->session()->put('payment_type', 'cart_payment');
    }

    //redirects to this method after a successful checkout
    public function checkout_done($order_ids, $payment)
    {
      
        foreach($order_ids as $order_id){
            $order = Order::findOrFail($order_id);
            $order->payment_status = 'paid';
            $order->payment_details = $payment;
            $order->save();

            $customer_order = ResellerCustomerOrder::where('order_code', $order->code)
                ->exists();

            if ($customer_order) {
                $customer_order = ResellerCustomerOrder::where('order_code', $order->code)
                    ->first();

                $customer_order->payment_status = 'paid';
                $customer_order->save();

                // Check if reseller is employee's under
                $employee_reseller = EmployeeReseller::where('reseller_id', $customer_order->reseller_id)
                    ->exists();

                if ($employee_reseller) {
                    $employee_reseller = EmployeeReseller::where('reseller_id', $customer_order->reseller_id)
                        ->first();

                    $employee_reseller->remaining_purchase_to_be_verified -= $order->grand_total;

                    $minimum_purchase = \App\AffiliateOption::where('type', 'minimum_first_purchase')->first()->percentage;

                    if ($order->grand_total >= $minimum_purchase) {
                        $employee_reseller->is_verified = 1;
                    }

                    $employee_reseller->save();
                }
            }

            $employee_customer_order = EmployeeCustomerOrder::where('order_code', $order->code)
                ->exists();

            if ($employee_customer_order) {
                $employee_customer_order = EmployeeCustomerOrder::where('order_code', $order->code)
                    ->first();

                $employee_customer_order->payment_status = 'paid';
                $employee_customer_order->save();
            }

            if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliatePoints($order);
            }

            if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
                $clubpointController = new ClubPointController;
                $clubpointController->processClubPoints($order);
            }
            
            if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() == null || !\App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
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
            } else {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->save();
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay + $orderDetail->price + $orderDetail->tax + $orderDetail->shipping_cost;
                        $seller->save();
                    }
                }
            }

            $order->commission_calculated = 1;
            $order->save();
        }

        if (Session::has('cart')) {
            Session::put('cart', Session::get('cart')->where('owner_id', '!=', Session::get('owner_id')));
        }

        Session::forget('owner_id');
        Session::forget('payment_type');
        Session::forget('delivery_info');
        Session::forget('coupon_id');
        Session::forget('coupon_discount');
        Session::forget('toCheckout');

        $orders = Order::findOrFail(Session::get('order_ids'));

        flash(translate('Payment completed'))->success();
        return redirect()->route('order_confirmed', compact('orders'));
    }

    public function save_checkout_item(Request $request){
        Session::forget('toCheckout');

        $toCheckout = collect(json_decode($request->dataToSave));

        $toCheckout = $toCheckout['dataToSave'];

        if(count($toCheckout) > 0){
            $request->session()->put('toCheckout', $toCheckout);

            if (Session::has('toCheckout') && count(Session::get('toCheckout')) > 0) {
                return 'success';
            }
                return 'error in saving';
        }else{
            return 'no data found';
        }
    }
    public function get_shipping_info(Request $request)
    {
        if (Session::has('toCheckout') && count(Session::get('toCheckout')) > 0) {
            // $categories = Category::all();
            // return view('frontend.shipping_info', compact('categories'));
            // $request->address_id = "pickup_point_location";
            // $total = $this->store_shipping_info($request);
            
            $route = Route::currentRouteName();

            /* change redirection for walkin */
            if(strpos($route, 'walkin') !== false){
                return view('frontend.walkin.payment.payment_select');
            }else{
                return view('frontend.shipping_info');
            } 
            
        }
        flash(translate('Please select the items you want to checkout'))->error();
        return back();
    }

    public function store_shipping_info(Request $request)
    {
      
        if (Auth::check()) {
            if($request->address_id != "pickup_point_location"){
                if ($request->address_id == null) {
                    flash(translate("Please add shipping address"))->error();
                    return back();
                }
                $address = Address::findOrFail($request->address_id);
                $data['name'] = Auth::user()->name;
                $data['email'] = Auth::user()->email;
                $data['island'] = $address->island;
                $data['address'] = $address->address;
                $data['country'] = $address->country;
                $data['city'] = $address->city;
                $data['postal_code'] = $address->postal_code;
                $data['phone'] = $address->phone;
                $data['checkout_type'] = $request->checkout_type;
            }else{
                $data = null;
            }
        } else {
            if($request->address_id != "pickup_point_location"){
                $data['name'] = $request->name;
                $data['email'] = $request->email;
                $data['island'] = $request->island;
                $data['address'] = $request->address;
                $data['country'] = $request->country;
                $data['city'] = $request->city;
                $data['postal_code'] = $request->postal_code;
                $data['phone'] = $request->phone;
                $data['checkout_type'] = $request->checkout_type;
            }else{
                $data = null;
            }
        }
        $shipping_info = $data;
        
        $request->session()->put('shipping_info', $shipping_info);
        
        $subtotal = 0;
        $tax = 0;
        $shipping = 0;

        foreach (Session::get('cart') as $key => $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];
            // $shipping += $cartItem['shipping'] * $cartItem['quantity'];
            if($request->address_id == "pickup_point_location"){
                foreach (Session::get('handlingFee') as $handlingFeeKey => $handlingFeeItem) {
                    if(strtolower(str_replace(' ', '_', $handlingFeeItem->store)) == $cartItem['pickup_location']){
                        $shipping += $handlingFeeItem->handling_fee * $cartItem['quantity'];
                    }
                }
            }
            else{
                $shipping += $cartItem['shipping'] * $cartItem['quantity'];
            }
        }
        $total = $subtotal + $tax + $shipping;

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }

        $to_checkout = Session::get('toCheckout');
        
        return view('frontend.payment_select', compact('total', 'to_checkout'));
    }

    public function store_delivery_info(Request $request)
    {
        $request->session()->put('owner_id', $request->owner_id);

        if (Session::has('cart') && count(Session::get('cart')) > 0) {
            $cart = $request->session()->get('cart', collect([]));

            $cart = $cart->map(function ($object, $key) use ($request) {
                if (\App\Product::find($object['id'])->user_id == $request->owner_id) {
                    if ($request['shipping_type_' . $request->owner_id] == 'pickup_point') {
                        $object['shipping_type'] = 'pickup_point';
                        $object['pickup_point'] = $request['pickup_point_id_' . $request->owner_id];
                    } else {
                        $object['shipping_type'] = 'home_delivery';
                    }
                }
                return $object;
            });

            $request->session()->put('cart', $cart);

            $cart = $cart->map(function ($object, $key) use ($request) {
                if (\App\Product::find($object['id'])->user_id == $request->owner_id) {
                    if ($object['shipping_type'] == 'home_delivery') {
                        $object['shipping'] = getShippingCost($key);
                    }
                    else {
                        $object['shipping'] = 0;
                    }
                } else {
                    $object['shipping'] = 0;
                }
                return $object;
            });

            $request->session()->put('cart', $cart);

            $subtotal = 0;
            $tax = 0;
            $shipping = 0;

            foreach (Session::get('cart') as $key => $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $shipping += $cartItem['shipping'] * $cartItem['quantity'];
            }

            $total = $subtotal + $tax + $shipping;

            if (Session::has('coupon_discount')) {
                $total -= Session::get('coupon_discount');
            }

            $to_checkout = Session::get('toCheckout');

            return view('frontend.payment_select', compact('total', 'to_checkout'));
        } else {
            flash(translate('Your Cart was empty'))->warning();
            return redirect()->route('home');
        }
    }

    public function get_payment_info(Request $request)
    {
        $subtotal = 0;
        $tax = 0;
        $shipping = 0;

        foreach (Session::get('cart') as $key => $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];
            $shipping += $cartItem['shipping'] * $cartItem['quantity'];
        }

        $total = $subtotal + $tax + $shipping;

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }

        return view('frontend.payment_select', compact('total'));
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if ($coupon != null) {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                $user = Auth::user();

                if ($coupon->usage_limit != 0 || $coupon->usage_limit == null) {
                    if ($coupon->role_restricted == 1) {
                        $roles = json_decode($coupon->roles);
                        // Check if role restricted
                        if (!in_array($user->user_type, $roles)) {
                            flash(translate("Sorry, but you don't have the right role to use this coupon code!"))->warning();
                            return redirect()->back();
                        }
                    }

                    if ($coupon->individual_use == 1) {
                        if ($user->id != $coupon->individual_user_id) {
                            flash (translate("Sorry, but you are not allowed to use this coupon!"))->warning();
                            return redirect()->back();
                        }
                    }

                    if ($coupon->bundle_coupon == 1) {
                        if ($coupon->bundle_coupon_type == 'product') {
                            // Get items in cart
                            $cart_items = Session::get('toCheckout');

                            $cart_items = collect($cart_items);

                            // Get bundled items 
                            $bundled_items_id = CouponBundle::where('coupon_id', $coupon->id)
                                ->get(['id', 'product_id', 'product_quantity']);

                            if (count($bundled_items_id) == count($bundled_items_id->whereIn('product_id', $cart_items->pluck('id')))) {
                                $items = 0;
                                $minimum_quantity = 0;
                                $cart_quantity = 0;

                                foreach ($cart_items as $key => $item) {
                                    $cart_quantity = $item->quantity;

                                    $minimum_requirements = CouponBundle::where('coupon_id', $coupon->id)
                                        ->where('product_id', $item->id)
                                        ->first();

                                    if ($minimum_requirements != null) {
                                        $minimum_quantity = $minimum_requirements->product_quantity;
                                        $maximum_quantity = $minimum_requirements->product_quantity_max;

                                        if ($item->quantity >= $minimum_quantity && $item->quantity <= $maximum_quantity) {
                                            $coupon_bundle_item = CouponBundle::where('coupon_id', $coupon->id)
                                                ->where('product_id', $item->id)
                                                ->exists();

                                            if ($coupon_bundle_item) {
                                                $items += 1;
                                            }
                                        }

                                        else {
                                            flash (translate("You don't have the right items to use this coupon!"))->error();
                                            return redirect()->back();
                                        }
                                    }
                                }

                                if ($items != count($bundled_items_id)) {
                                    flash (translate ("You don't have the right items to use this coupon!"))->error();
                                    return redirect()->back();
                                }
                            }

                            else {
                                flash (translate("You don't have the right items to use this coupon!"))->error();
                                return redirect()->back();
                            }
                        }

                        elseif ($coupon->bundle_coupon_type == 'category') {
                            $cart_items = Session::get('toCheckout');

                            $to_checkout_items = collect($cart_items);

                            $product_category_ids = \App\Product::whereIn('id', $to_checkout_items->pluck('id'))
                                ->pluck('category_id');

                            // Get Bundled Items
                            $bundled_category_id = \App\CouponCategoryBundle::where('coupon_id', $coupon->id)
                                ->get(['id', 'category_id', 'category_quantity', 'category_quantity_max']);

                            // Check if the number of items with bundled category ids match
                            if (count($bundled_category_id) == count($bundled_category_id->whereIn('category_id', $product_category_ids))) {
                                $category_ids = \App\CouponCategoryBundle::where('coupon_id', $coupon->id)
                                    ->pluck('category_id');

                                foreach ($bundled_category_id as $key => $category) {
                                    $minimum_quantity = $category->category_quantity;
                                    $maximum_quantity = $category->category_quantity_max;
                                    
                                    $collective_quantity = 0;

                                    foreach ($to_checkout_items as $key => $item) {
                                        $product_item = \App\Product::where('id', $item->id)
                                            ->where('category_id', $category->category_id)
                                            ->exists();

                                        if ($product_item) {
                                            $collective_quantity += $item->quantity;
                                        }
                                    }

                                    if ($collective_quantity >= $minimum_quantity && $collective_quantity <= $maximum_quantity) {
                                        // Proceed
                                    }

                                    else {
                                        flash (translate("The items on your checkout cart does not meet the requirements!"))->error();
                                        return redirect()->back();
                                    }
                                }
                            }

                            else {
                                flash (translate("The items on your checkout cart does not meet the requirements!"))->error();
                                return redirect()->back();
                            }
                        }
                    }

                    $this->post_coupon_code($request, $coupon);
                }

                else {
                    flash(translate('Usage Limit has been reached for this coupon!'));
                    return redirect()->back();
                }
                
            } else {
                flash(translate('Coupon expired!'))->warning();
                return redirect()->back();
            }
        } else {
            flash (translate('Invalid Coupon!'))->warning();
            return redirect()->back();
        }
        
        return redirect()->back();
    }

    private function post_coupon_code ($request, $coupon) {
        $coupon_details = json_decode($coupon->details);

        $coupon_usage = \App\CouponUsage::where('user_id', Auth::user()->id)
            ->where('coupon_id', $coupon->id)
            ->first();

        if ($coupon_usage != null) {
            if ($coupon_usage->usages == $coupon->usage_limit_user) {
                flash(translate("You have reached the maximum usage limit for this coupon!"));
                return redirect()->back();
            }
        }

        if ($coupon->type == 'cart_base') {
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;

            foreach (Session::get('cart') as $key => $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $shipping += $cartItem['shipping'] * $cartItem['quantity'];
            }

            $sum = $subtotal + $tax + $shipping;

            if ($sum > $coupon_details->min_buy) {
                if ($coupon->discount_type == 'percent') {
                    $coupon_discount = ($sum * $coupon->discount) / 100;
                    if ($coupon_discount > $coupon_details->max_discount) {
                        $coupon_discount = $coupon_details->max_discount;
                    }
                }

                elseif ($coupon->discount_type == 'amount') {
                    $coupon_discount = $coupon->discount;
                }

                $request->session()->put('coupon_id', $coupon->id);
                $request->session()->put('coupon_discount', $coupon_discount);

                flash(translate('Coupon has ben applied'))->success();
                return redirect()->back();
            }

            else {
                flash ("You need at least " . single_price($coupon_details->min_buy) . " worth of order to use this coupon code!");
                return redirect()->back();
            }
        }

        else if ($coupon->type == 'product_base') {
            $coupon_discount = 0;

            foreach (Session::get('cart') as $key => $cartItem) {
                foreach ($coupon_details as $key => $coupon_detail) {
                    if ($coupon_detail->product_id == $cartItem['id']) {
                        if ($coupon->discount_type == 'percent') {
                            $coupon_discount += $cartItem['price'] * $cartItem['quantity'] * $coupon->discount / 100;
                        }

                        else if ($coupon->discount_type == 'amount') {
                            $coupon_discount += $coupon->discount;
                        }
                    }
                }
            }

            $request->session()->put('coupon_id', $coupon->id);
            $request->session()->put('coupon_discount', $coupon_discount);

            flash(translate('Coupon has ben applied'))->success();
            return redirect()->back();
        }
    }

    public function remove_coupon_code(Request $request)
    {
        $request->session()->forget('coupon_id');
        $request->session()->forget('coupon_discount');
        return back();
    }

    public function order_confirmed()
    {
        $orders = Order::findOrFail(Session::get('order_ids'));

        return view('frontend.walkin.order_confirmed', compact('orders'));
    }

    public function order_confirmed_pending()
    {
        $orders = Order::findOrFail(Session::get('order_ids'));

        return view('frontend.order_confirmed_pending', compact('orders'));
    }

    public function order_confirmed_pending_paynamics()
    {
        $orders = Order::findOrFail(Session::get('order_ids'));

        return view('frontend.order_confirmed_pending_paynamics', compact('orders'));
    }

    public function get_additional_fee (Request $request) {
        $payment_channel = \App\PaymentChannel::where('status', 1)
            ->where('value', $request->payment_channel)
            ->first();

        return [ 'status' => 1, 'name' => $payment_channel->name, 'rate' => $payment_channel->rate , 'price' => $payment_channel->price ];
    }
}
