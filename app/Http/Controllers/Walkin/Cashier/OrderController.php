<?php

namespace App\Http\Controllers\Walkin\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SearchController;

use Illuminate\Http\Request;

use App\Order;
use App\OrderPayment;
use App\OrderNote;
use App\CmgLog;
use App\WorldcraftStock;
use Auth;
use Session;
use Cookie;
use App\Color;
use App\SubSubCategory;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\CmgLogController;
use App\Product;
use Illuminate\Support\Facades\Validator;
use App\PaymentMethodList;
use App\OtherPaymentMethod;
use Illuminate\Support\Facades\Crypt;
use App\OrderDetail;
use DB;
use App\OrderEditDetail;
use App\DefectiveItem;
class OrderController extends Controller
{
    public function listing(Request $request){
        $pup_store = '';
        if(isset($_COOKIE['store_data'])) {
            $store_name_pup = json_decode($_COOKIE['store_data'])->name;
            $pup_store = str_replace(' ','_',(strtolower($store_name_pup)));
        }
        $order_status = null;
        $payment_type = null;
        $payment_status = null;
        $sort_search = null;

        $orders = Order::rightJoin('users as a', 'a.id', '=', 'orders.user_id')
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->select('orders.id', 'orders.code', 'orders.grand_total', 'orders.order_status', 'orders.payment_type', 'orders.payment_status', 'orders.request_status','orders.created_at', 'a.first_name', 'a.last_name', 'a.name', 'orders.cr_number', 'orders.som_number', 'orders.dr_number', 'orders.si_number', 'orders.pickup_point_location', 'order_details.delivery_status', 'a.user_type', 'a.referred_by', 'a.display_name')
            ->distinct();
        
        if($request->order_status){
            $order_status = $request->order_status;
            if($request->order_status == 'pending'){
                $orders = $orders->where('orders.order_status', null);
            }else{
                $orders = $orders->where('orders.order_status', 'like', '%'.$order_status.'%');
            }
        }

        if ($request->search != null) {
            $sort_search = $request->search;

            $orders =  $orders->where('a.name', 'like', '%' . $sort_search . '%');
        }

        if($request->payment_status){
            $payment_status = $request->payment_status;
            $orders = $orders->where('orders.payment_status', $payment_status);
        }

        if($request->payment_type){
            $payment_type = $request->payment_type;
            $orders = $orders->where('orders.payment_type', 'like', '%'.$payment_type.'%');
        }

        $orders = $orders->where(['is_walkin' => '1', 'pickup_point_location' => $pup_store ])->orderBy('orders.created_at', 'desc')->paginate(15);
      
        return view('frontend.walkin.cashier.orders.index', compact('orders', 'order_status', 'payment_type', 'sort_search', 'payment_status'));
    }

    public function revised(Request $request){
        $request_status = null;
        $payment_type = null;
        $payment_status = null;
        $sort_search = null;

        $orders = Order::rightJoin('users as a', 'a.id', '=', 'orders.user_id')
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->select('orders.id', 'orders.code', 'orders.grand_total', 'orders.order_status', 'orders.payment_type', 'orders.payment_status', 'orders.request_status','orders.created_at', 'a.first_name', 'a.last_name', 'a.name', 'orders.cr_number', 'orders.som_number', 'orders.dr_number', 'orders.si_number', 'orders.pickup_point_location', 'order_details.delivery_status', 'a.user_type', 'a.referred_by', 'a.display_name')
            ->distinct();

        if($request->request_status){
            $request_status = $request->request_status;
            if($request->request_status == 'approved'){
                $orders = $orders->where('orders.request_status', 'like', '%'.$request_status.'%');
            }else{
                $orders = $orders->where('orders.request_status', 'like', '%'.$request_status.'%')->orWhere('orders.request_status', null);
            }
        }

        if ($request->search != null) {
            $sort_search = $request->search;

            $orders =  $orders->where('a.name', 'like', '%' . $sort_search . '%');
        }

        if($request->payment_status){
            $payment_status = $request->payment_status;
            $orders = $orders->where('orders.payment_status', $payment_status);
        }

        if($request->payment_type){
            $payment_type = $request->payment_type;
            $orders = $orders->where('orders.payment_type', 'like', '%'.$payment_type.'%');
        }

        $orders = $orders->where('is_walkin', '1')->where('orders.order_status', 'like', '%' . 'for_revision' . '%')->orderBy('orders.created_at', 'desc')->paginate(15);

        return view('frontend.walkin.cashier.orders.revised', compact('orders', 'request_status', 'payment_type', 'sort_search', 'payment_status'));
    }

    public function refunds(Request $request){
        $request_status = null;
        $payment_type = null;
        $payment_status = null;
        $sort_search = null;

        $orders = Order::where('orders.order_status', 'like', '%' . 'refund' . '%')
            ->orWhere('orders.order_status', 'like', '%' . 'cancel' . '%')
            ->rightJoin('users as a', 'a.id', '=', 'orders.user_id')->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->select('orders.id', 'orders.code', 'orders.grand_total', 'orders.order_status', 'orders.payment_type', 'orders.payment_status', 'orders.request_status', 'orders.reason_type', 'orders.created_at', 'a.first_name', 'a.last_name', 'a.name', 'orders.som_number', 'orders.dr_number', 'orders.si_number', 'orders.pickup_point_location', 'order_details.delivery_status', 'a.user_type', 'a.referred_by', 'a.display_name')
            ->distinct();

        if($request->request_status){
            $request_status = $request->request_status;
            $orders = $orders->where('orders.request_status', $request->request_status);
        }

        if ($request->search != null) {
            $sort_search = $request->search;

            $orders =  $orders->where('a.name', 'like', '%' . $sort_search . '%');
        }

        if($request->payment_status){
            $payment_status = $request->payment_status;
            $orders = $orders->where('orders.payment_status', $payment_status);
        }

        if($request->payment_type){
            $payment_type = $request->payment_type;
            $orders = $orders->where('orders.payment_type', 'like', '%'.$payment_type.'%');
        }

        $orders = $orders->where('is_walkin', '1')->orderBy('orders.created_at', 'desc')->paginate(15);

        return view('frontend.walkin.cashier.orders.refunds', compact('orders', 'request_status', 'payment_type', 'sort_search', 'payment_status'));
    }
    
    public function view(Request $request, $id)
    {
        $order = Order::findOrFail(decrypt($id));

        $proof_of_payments = OrderPayment::where('order_id', $order->id)
            ->latest()
            ->paginate(10);
            
        $notes_for_customer = OrderNote::where('order_id', $order->id)
            ->where('type', 'customer')
            ->latest()
            ->paginate(10);

        $total_payment = OrderPayment::where('order_id', $order->id)->sum('amount');
        
        $notes_for_admin = OrderNote::where('order_id', $order->id)
            ->where('type', 'admin')
            ->latest()
            ->paginate(10);

        $cmg_logs = \App\CmgLog::where('order_id', $order->id)
            ->latest()
            ->paginate(10);
        
        $other_payment_methods = OtherPaymentMethod::orderBy('name', 'asc')->paginate(15);
       
        return view('frontend.walkin.cashier.orders.show', compact('order', 'proof_of_payments', 'notes_for_customer', 'notes_for_admin', 'cmg_logs', 'other_payment_methods', 'total_payment'));
        
    }

    public function cr_number(Request $request)
    {
        $this->validate($request, [
            'cr_number' => 'required|unique:orders,cr_number,' . $request->order_id,
        ]);
      
        if (Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions))) {
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
                $order->payment_type = $request->payment_type;
                $order->payment_reference = $request->payment_reference;
    
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
        $conditions = ['published' => 1];
        $products = null;
        
        if($request->q != null){
            $products = Product::where($conditions);

            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name', 'like', '%'.$request->q.'%')->orWhere('tags', 'like', '%'.$request->q.'%');

            $products = filter_products($products)->paginate(20)->appends(request()->query());
        }

        
        return view('frontend.walkin.cashier.orders.show', compact('order', 'proof_of_payments', 'notes_for_customer', 'notes_for_admin', 'cmg_logs', 'products'));
    }

    public function order_cr_number(Request $request){
      
       $cr_number_unique = OrderPayment::where('cr_number', $request->cr_number)
                            ->orWhere('payment_reference', $request->payment_reference)
                            ->first();

       if(!$cr_number_unique){
            $request->amount = str_replace(',','', $request->amount);
        
            $order_payment = new OrderPayment;
            $this->validate($request, [
                'cr_number' => 'required|unique:orders,cr_number,' . $request->order_id,
            ]);



            if (Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions))) {
                $order = Order::findOrFail($request->order_id);
                
                $data = [];
                $data['user_id'] = Auth::user()->id;
                $data['order_id'] = $order->id;
                
                if ($order_payment->cr_number == null) {
                    $data['activity'] = "Added CR Number: $request->cr_number";
                } else {
                    $data['activity'] = "Updated CR Number: From $order_payment->cr_number to $request->cr_number";
                }
        
                $cmg_log = new CmgLogController;
                $cmg_log->store($data);

                $order_payment->order_id = $request->order_id;
                $order_payment->user_id = $request->user_id;
                $order_payment->payment_method = $request->payment_method;
                $order_payment->cr_number = $request->cr_number;
                $order_payment->payment_reference = $request->payment_reference;
                $order_payment->amount = $request->amount;
                if ($order_payment->save()) {
                    flash(translate("CR Number successfuly saved!"))->success();
                } else {
                    flash(translate('Something went wrong!'))->error();
                }
            }

            // if($order->grand_total == OrderPayment::where('order_id', $order->id)->sum('amount')){
            //     $order->update([
            //         'payment_status' => 'paid'
            //     ]);
            // }
    
            return redirect()->back();
       }else{
            flash(translate("Please check your CR Number or Reference Number!"))->error();
            return redirect()->back();
       } 
    }

    public function updateOrder(Request $request){
        return $request->price;
    }

    public function addToOrderCashier(Request $request)
    {
        
        if (Session::has('coupon_id') && Session::has('coupon_discount')) {
            $request->session()->forget('coupon_id');
            $request->session()->forget('coupon_discount');
        }
        
        $product = Product::find($request->id);

        $data = array();
        $data['id'] = $product->id;
        $data['owner_id'] = $product->user_id;
        $str = '';
        $tax = 0;
        $data['pickup_location'] = mb_strtolower(str_replace(' ', '_', $request->pickup_location));
        $data['pickup_order'] = $request->pickup_order;

        if($product->digital != 1 && $request->quantity < $product->min_qty) {
            return array('status' => 0, 'view' => view('frontend.partials.minQtyNotSatisfied', [
                'min_qty' => $product->min_qty
            ])->render());
        }

        //check the color enabled or disabled for the product
        if($request->has('color')){
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        if ($product->digital != 1) {
            //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
            foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
                else{
                    $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
            }
        }

        $data['variant'] = $str;

        if ($str != null && $product->variant_product){
            $product_stock = $product->stocks->where('variant', $str)->first()->sku;
            $price = $product->stocks->where('variant', $str)->first()->price;
        }

        else {
            $product_stock = $product->sku;
            $price = $product->unit_price;
        }
        
        // Check quantity and check if already existing on cart
        // Get PUP Location ID
        $pup_location_id = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $data['pickup_location'])))->first()->id;
        $quantity = null;

        
        if ($product_stock != null) {
            // Get quantity
            $quantity = \App\WorldcraftStock::where('sku_id', $product_stock)
                ->where('pup_location_id', $pup_location_id)
                ->first();
        }
        
        if ($quantity != null) {
            $quantity = $quantity->quantity;

            if (Session::has('cart')) {
                $product_exists_in_cart = Session::get('cart')->where('id', $product->id)->first();

                if ($product_exists_in_cart != null) {
                    if ($quantity <= $product_exists_in_cart['quantity'] && $product->advance_order != 1) {
                        return array('status' => 0, 'view' => view('frontend.partials.outOfStockCart')->render());
                    }
                } else {
                    if ($quantity < $request['quantity'] && $product->advance_order != 1){
                        return array('status' => 0, 'view' => view('frontend.partials.outOfStockCart')->render());
                    }
                }
            }
        }
        

        else {
            return array('status' => 0, 'view' => view('frontend.partials.outOfStockCart')->render());
        }
        
        if(Auth::check()){
            if(Auth::user()->user_type == 'reseller' || Auth::user()->user_type == 'employee'){
                if($product->discount_type == 'percent'){
                    if(Auth::user()->user_type == 'reseller'){
                        $price -= ($price*$product->reseller_discount)/100;
                    }elseif(Auth::user()->user_type == 'employee'){
                        $price -= ($price*$product->employee_discount)/100;
                    }
                }elseif($product->discount_type == 'amount'){
                    if(Auth::user()->user_type == 'reseller'){
                        $price -= $product->reseller_discount;
                    }elseif(Auth::user()->user_type == 'employee'){
                        $price -= $product->employee_discount;
                    }
                }
            }else{
             
                //discount calculation based on flash deal and regular discount
                //calculation of taxes
                $flash_deals = \App\FlashDeal::where('status', 1)->get();
                $inFlashDeal = false;
                foreach ($flash_deals as $flash_deal) {
                    if ($flash_deal != null && $flash_deal->status == 1  && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                        $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                        if($flash_deal_product->discount_type == 'percent'){
                            $price -= ($price*$flash_deal_product->discount)/100;
                        }
                        elseif($flash_deal_product->discount_type == 'amount'){
                            $price -= $flash_deal_product->discount;
                        }
                        $inFlashDeal = true;
                        break;
                    }
                }
                if (!$inFlashDeal) {
                    if($product->discount_type == 'percent'){
                        $price -= ($price*$product->discount)/100;
                    }
                    elseif($product->discount_type == 'amount'){
                        $price -= $product->discount;
                    }
                }
            }
            
        }

        else {
           
            //discount calculation based on flash deal and regular discount
            //calculation of taxes
            $flash_deals = \App\FlashDeal::where('status', 1)->get();
            $inFlashDeal = false;
            foreach ($flash_deals as $flash_deal) {
                if ($flash_deal != null && $flash_deal->status == 1  && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                    $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                    if($flash_deal_product->discount_type == 'percent'){
                        $price -= ($price*$flash_deal_product->discount)/100;
                    }
                    elseif($flash_deal_product->discount_type == 'amount'){
                        $price -= $flash_deal_product->discount;
                    }
                    $inFlashDeal = true;
                    break;
                }
            }
            if (!$inFlashDeal) {
                if($product->discount_type == 'percent'){
                    $price -= ($price*$product->discount)/100;
                }
                elseif($product->discount_type == 'amount'){
                    $price -= $product->discount;
                }
            }
        }
        
        if($product->tax_type == 'percent'){
            $tax = ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $tax = $product->tax;
        }
        
        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['tax'] = $tax;
        $data['shipping'] = 0;
        $data['product_referral_code'] = null;
        $data['digital'] = $product->digital;
        
        if ($request['quantity'] == null){
            $data['quantity'] = 1;
        }
        
        // if(Cookie::has('referred_product_id') && Cookie::get('referred_product_id') == $product->id) {
        //     $data['product_referral_code'] = Cookie::get('product_referral_code');
        // }
       
        
        // if($request->session()->has('cart')) {
        //     $foundInCart = false;
        //     $cart = collect();

        //     foreach ($request->session()->get('cart') as $key => $cartItem){
        //         if($cartItem['id'] == $request->id && $cartItem['pickup_location'] == $request->pickup_location){
        //             if($str != null){
        //                 if($cartItem['variant'] == $str){
        //                     $foundInCart = true;
        //                     $cartItem['quantity'] += $request['quantity'];
        //                 }
        //             }else{
        //                 $foundInCart = true;
        //                 $cartItem['quantity'] += $request['quantity'];
        //             }

        //         }
        //         $cart->push($cartItem);
        //     }

        //     if (!$foundInCart) {
        //         $cart->push($data);
        //     }

        //     $request->session()->put('cart', $cart);
        // }
        // else{
        //     $cart = collect([$data]);
        //     $request->session()->put('cart', $cart);
        // }
        
        $handlingfees = collect(json_decode($request['handlingFee']));
        $request->session()->put('handlingFee', $handlingfees);
        
        $orderId = $request->order_id ?  $request->order_id : null;
        
        if ($request->pickup_location != "") {
            
            $decrypted = decrypt($request->order_id);
            $order_id = $decrypted;
           
            $order_detail = new OrderEditDetail();
            $order_detail->order_id = $order_id;
            $order_detail->seller_id = $data['owner_id'];
            $order_detail->product_id = $data['id'];
            $order_detail->variation = $data['variant'];
            $order_detail->price = $data['price'] * $data['quantity'];
            $order_detail->quantity = $data['quantity'];
            $order_detail->is_edit = '1';
            $order_detail->order_type = 'same_day_pickup';
            $order_detail->save();
            return array('status' => 1, 'view' => view('frontend.walkin.partials.addedToOrder', compact('product', 'data','orderId'))->render());
            
        }else { 
            return array('status' => 0);
        }
    }

    public function editOrderDetailStore(Request $request){
  
        $order_details = OrderDetail::where('order_id', $request->order_id)->get();
        $order_edit_details = OrderEditDetail::where('order_id', $request->order_id)->get()->first();
     
        if(!$order_edit_details){
            foreach ($order_details as $order => $item) {
                $edit_order = new OrderEditDetail();
    
                $edit_order->order_id = $item->order_id;
                $edit_order->seller_id = $item->seller_id;
                $edit_order->product_id = $item->product_id;
                $edit_order->variation = $item->variation;
                $edit_order->price = $item->price;
                $edit_order->tax = $item->tax;
                $edit_order->shipping_cost = $item->shipping_cost;
                $edit_order->quantity = $item->quantity;
                $edit_order->edit_qty = $item->edit_qty;
                $edit_order->partial_released_qty = $item->partial_released_qty;
                $edit_order->payment_status = $item->payment_status;
                $edit_order->is_edit = $item->is_edit;
                $edit_order->delivery_status = $item->delivery_status;
                $edit_order->shipping_type = $item->shipping_type;
                $edit_order->pickup_point_id = $item->pickup_point_id;
                $edit_order->order_type = $item->order_type;
                $edit_order->product_refferal_code = $item->product_referral_code;
                $edit_order->partial_released = $item->partial_released;
                $edit_order->order_type = $item->order_type;
                $edit_order->save();
            }
        }
            $response=(object)[
                "success" => true,
                "url" => route('cashier.order.view', [encrypt($request->order_id), 'edit=1']),
                "result" => [
                    "message" => "Successfull Insert in Order Edit Details"
                ]
            ];
            return response()->json($response, 201);
    }

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

        if (Auth::user()->staff->role->name != 'CMG') {
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $order_note = new OrderNote;

        $order_note->order_id = $request->order_id;
        $order_note->user_id = Auth::user()->id;
        $order_note->type = $request->type;
        $order_note->message = $request->message;

        if ($order_note->save()) {
            if ($order_note->type == 'customer') {
                $send_sms = new OTPVerificationController;
                $send_sms->send_note_to_customer($order_note);
            }

            flash(translate("Successfully added note!"));
            return redirect()->back();
        }

        else {
            flash (translate("Something went wrong"))->error();
            return redirect()->back();
        }
    }

    public function update_order($id)
    {
        $update_order = Order::where('id', $id)->get()->first();
        $order_detail = OrderDetail::where('order_id', $update_order->id)->get();
        $sum_total = 0;
        foreach($order_detail as $order => $item){
            $sum_total += $item->price;
        }
        Order::where('id', $update_order->id)->update(array('grand_total' => $sum_total));
    }   

    public function update_order_status(Request $request){
    
        $rules = [
            'order_id' => 'required',
        ];
        $message = [
            'order_id.required' => 'Invalid request, please try again later!',
        ];
        if(($request->order_status == "cancel" || $request->order_status == "for_revision") && Auth::user()->user_type == 'Cashier'){
            $rules['reason_type'] = 'required';
            $message['reason_type.required'] = 'Please select reason type!';
            if($request->reason_type && $request->reason_type == "others"){
                $rules['reason_field'] = 'required';
                $message['reason_field.required'] = 'Reason field is required!';
            }
        }

        $validator = Validator::make($request->all(),$rules,$message);

        if ($validator->fails()) {
            $errors = null;
            $errors = $validator->errors()->messages();

            foreach ($errors as $key => $item) {
                foreach ($item as $error) {
                    flash(translate($error))->error();
                    return redirect()->back();
                }
            }
        }else{
            $order = Order::find($request->order_id);
            $data = [
                'order_status' => $request->order_status,
            ];  
            
            if($request->request_status == 'approved'){
                if($request->order_status == 'refund'){
                    $data['request_status'] = $request->request_status;
                    $success_message = "Refund request approved successfully!";
                }else if($request->order_status == 'for_revision' && Auth::user()->staff->role->name == 'Inventory Assistant'){
                    $payment = OrderPayment::where('order_id', $order->id)->sum('amount');
                    $edit_items = OrderEditDetail::where('order_id', $order->id)->whereNull('is_deleted')->get();
                    if($payment == $edit_items->sum('price')){
                        $data['payment_status'] = "paid";
                        $data['request_status'] = "approved";
                        $data['order_status'] = "for_release";
                        $success_message = "Order for released!";
                    }else{
                        if($payment < $edit_items->sum('price')){
                            $data['payment_status'] = "unpaid";
                            $data['order_status'] = "for_collection";
                            $success_message = "Order has been mark as unpaid!";
                        }else if($payment > $edit_items->sum('price')){
                            if($order->payment_type == 'cash'){
                                $data['order_status'] = "for_partial_refund";
                                $success_message = "Edit request has been approved!";
                            }else if($order->payment_type == 'bank_transfer'){
                                $data['request_status'] = "approved";
                                $data['order_status'] = "for_release";
                                $data['note'] = "Please submit Request for Payment Order to Finance for approval!";
                                $success_message = "Please submit Request for Payment Order to Finance for approval!";
                            }
                        }
                    }
                }

                $order_edit_details = OrderEditDetail::where('order_id', $request->order_id)->get();
                if($order_edit_details->first()){     

                    $pup_store = '';
                    $pup_id = null;
                    if(isset($_COOKIE['store_data'])) {
                        $store_name_pup = json_decode($_COOKIE['store_data'])->name;
                        $pup_store = str_replace(' ','_',(strtolower($store_name_pup)));
                        $pup_id = json_decode($_COOKIE['store_data'])->id;
                    }
                    $defective_item = [];

                    foreach($order_edit_details as $key => $orderDetail){
                        if($orderDetail->is_deleted == 1){
                            
                            $defective_array['location_id'] = $pup_id;
                            $defective_array['defective_qty'] = $orderDetail->quantity;
                            $sku = \App\ProductStock::where('product_id', $orderDetail->product_id)
                                ->where('variant', $orderDetail->variation)
                                ->first();
                                
                            if ($sku != null) {
                                $defective_array['sku'] = $sku->sku;
                                // array_push($defective_item, $sku->sku);
                            } else {
                                if(isset($orderDetail->product)){
                                    if(isset($orderDetail->product->sku)){
                                        $defective_array['sku'] = $orderDetail->product->sku;
                                        // array_push($defective_item, $orderDetail->product->sku);
                                    }
                                }
                            }
                            array_push($defective_item, $defective_array);
                           
                            $check_defective = DefectiveItem::where(['pup_id' => $defective_array['location_id'], 'sku' => $defective_array['sku']])->first();
                            if(!$check_defective){
                                $defective_insert = new DefectiveItem;
                                $defective_insert->sku = $defective_array['sku'];
                                $defective_insert->defective_qty = $defective_array['defective_qty'];
                                $defective_insert->pup_id = $defective_array['location_id'];
                                $defective_insert->save();
                            }else{
                                $total_defective_qty = $defective_array['defective_qty'] + $check_defective->defective_qty;
                                $check_defective->update(array('defective_qty' => $total_defective_qty ));
                            }
                        }
                    }

                    $this->defectiveItem($defective_item);
                                   
                    // start remove order sa ORDER DETAIL TABLE
                    $order_details = OrderDetail::where('order_id', $request->order_id)->get();
                    if($order_details){
                        foreach($order_details as $order => $item){
                            $remove_order = OrderDetail::findorfail($item->id);
                            $remove_order->delete();
                        }
                    }
                    // end remove order sa ORDER DETAIL TABLE

                    // start get order sa ORDER EDIT DETAIL TABLE
                    $order_edit_details_active = OrderEditDetail::where('order_id', $request->order_id)->whereNull('is_deleted')->get();
                    if($order_edit_details_active){
                        foreach($order_edit_details_active as $order => $item){
                            $add_order = new OrderDetail();
                            $add_order->order_id = $item->order_id;
                            $add_order->seller_id = $item->seller_id;
                            $add_order->product_id = $item->product_id;
                            $add_order->variation = $item->variation;
                            $add_order->price = $item->price;
                            $add_order->tax = $item->tax;
                            $add_order->shipping_cost = $item->shipping_cost;
                            $add_order->quantity = $item->quantity;
                            $add_order->edit_qty = $item->edit_qty;
                            $add_order->partial_released_qty = $item->partial_released_qty;
                            $add_order->payment_status = $item->payment_status;
                            $add_order->is_edit = $item->is_edit;
                            $add_order->delivery_status = $item->delivery_status;
                            $add_order->shipping_type = $item->shipping_type;
                            $add_order->pickup_point_id = $item->pickup_point_id;
                            $add_order->order_type = $item->order_type;
                            $add_order->product_referral_code = $item->product_refferal_code;
                            $add_order->partial_released = $item->partial_released;
                            $add_order->order_type = $item->order_type;
                            $add_order->save();
                        }   
                    }
                    // end get order sa ORDER EDIT DETAIL TABLE

                    // start remove order sa ORDER EDIT DETAIL TABLE
                    if($order_edit_details){
                        foreach($order_edit_details as $order => $item){
                            $remove_order = OrderEditDetail::findorfail($item->id);
                            $remove_order->delete();
                        }
                    }
                    // end remove order sa ORDER EDIT DETAIL TABLE
            
                    $get_order_detail = OrderDetail::where('order_id', $request->order_id)->get()->first();
                    $this->update_order($get_order_detail->order_id);
                }
               
            }else if($request->request_status == 'declined'){
                if($request->order_status == 'for_revision' || $request->order_status == 'refund'){
                    $data['order_status'] = 'for_release';
                    $success_message = "Refund request has been declined!";

                    $order_edit_details = OrderEditDetail::where('order_id', $request->order_id)->get();
                    // start remove order sa ORDER EDIT DETAIL TABLE
                    if($order_edit_details){
                        foreach($order_edit_details as $order => $item){
                            $remove_order = OrderEditDetail::findorfail($item->id);
                            $remove_order->delete();
                        }
                    }
                    // end remove order sa ORDER EDIT DETAIL TABLE
                }
            }else{
                if($request->order_status == "cancel" || $request->order_status == "for_revision"){
                    $data['request_status'] = 'pending';
                    $data['reason_type'] = $request->reason_type;
                    $data['reason_field'] = $request->reason_field ? $request->reason_field : null;
                    $success_message = $request->order_status == "for_revision" ? "Edit Request Sent!" : "Order has been cancelled!";
                    
                    $payment = OrderPayment::where('order_id', $order->id)->sum('amount');

                    if($request->order_status == "cancel"){                        
                        if($payment){
                            if($order->payment_type == 'cash'){
                                $data['order_status'] = "refund";
                                $success_message = "Order has been mark as refund!";
                            }else if($order->payment_type == 'bank_transfer'){
                                $data['order_status'] = "for_release";
                                $data['request_status'] = "pending";
                                $success_message = "Please submit Request for Payment Order to Finance for approval!";
                            }
                        }
                    }else if($request->order_status == "for_revision" && Auth::user()->staff->role->name == 'Inventory Assistant'){
                        $edit_items = OrderEditDetail::where('order_id', $order->id)->whereNull('is_deleted')->get();
                        if($payment < $edit_items->sum('price')){
                            $data['payment_status'] = "unpaid";
                        }else if($payment > $edit_items->sum('price')){
                            if($order->payment_type == 'cash'){
                                $data['order_status'] = "partial_refund_done";
                                $success_message = "Order has been mark as partial refund done!";
                            }else if($order->payment_type == 'bank_transfer'){
                                $data['request_status'] = "approved";
                                $data['order_status'] = "for_release";
                                $success_message = "Please submit Request for Payment Order to Finance for approval!";
                            }
                        }
                    }
                }else if($request->order_status == "released"){
                    $success_message = "Order has been marked as released!";
                   
                }else if($request->order_status == "for_release"){
                    
                    $payment = OrderPayment::where('order_id', $order->id)->sum('amount');
                    $edit_items = OrderEditDetail::where('order_id', $order->id)->whereNull('is_deleted')->get();
                    if(count($edit_items)){
                        if($payment == $edit_items->sum('price')){
                            $data['payment_status'] = 'paid';
                            $success_message = "Order marked as paid successfuly!";
                        }else{
                            flash(translate('Order has not yet been fully paid!'))->error();
                            return redirect()->route('cashier.order.view', ['id' => encrypt($order->id)]);
                        }
                    }else{
                        if($payment && $payment == $order->grand_total){
                            $data['payment_status'] = 'paid';
                            $success_message = "Order marked as paid successfuly!";

                            /* Deduct to stocks */
                            $items = null;
                            $is_edit_item = OrderDetail::where([['order_id', "=", $order->id], ['is_edit', "=", 1]])
                                            ->orWhere([['order_id', "=", $order->id], ['edit_qty', '!=', null]])
                                            ->first();
                            
                            if($is_edit_item){
                                $items = OrderDetail::where([['order_id', "=", $order->id], ['is_edit', "=", 1]])
                                    ->orWhere([['order_id', "=", $order->id], ['edit_qty', '!=', null]])
                                    ->get();
                            }else{
                                $items = OrderDetail::where('order_id', $order->id)->get();
                            }
                                   
                            if(isset($_COOKIE['store_data'])) {
                                $pup_id = json_decode($_COOKIE['store_data'])->id;
                            }
                            if($pup_id){
                                foreach ($items as $key => $item) {    
                                    // var_dump($item->edit_qty); die; 
                                    $product = \App\Product::where('id', $item->product_id)
                                        ->select('id', 'name')
                                        ->first();
        
                                    if ($item->variation != null) {
                                        $product_stock = \App\ProductStock::where('product_id', $item->product_id)
                                            ->where('variant', $item->variation)
                                            ->select('product_id', 'variant', 'sku')
                                            ->first()->sku;
                
                                        $worldcraft_stock = WorldcraftStock::where('sku_id', $product_stock)
                                            ->where('pup_location_id', $pup_id)
                                            ->first();
                                    }
                                    $worldcraft_stock->update([
                                        'quantity' =>  $worldcraft_stock->quantity - ($item->edit_qty ? ($item->edit_qty < 0 ? 0 : $item->edit_qty) : $item->quantity)
                                    ]);
                                }
                            }else{
                                flash(translate('An error occured!, Please try again later!'))->error();
                                return redirect()->route('cashier.order.view', ['id' => encrypt($order->id)]);
                            }
                        }else{
                            flash(translate('Orders has not yet been fully paid!'))->error();
                            return redirect()->route('cashier.order.view', ['id' => encrypt($order->id)]);
                        }
                    }
                }else if($request->order_status == 'pending'){
    
                    $payment = OrderPayment::where('order_id', $order->id)->sum('amount');
                    $total = OrderEditDetail::where('order_id', $order->id)->whereNull('is_deleted')->sum('price');
    
                    if($payment > $total){
                        dd('refund');
                    }else{
                        $data['payment_status'] = 'unpaid';
                        $data['order_status'] = 'for_release';
                        $data['grand_total'] = $total;
                        $success_message = "Edit order approved successfuly!";
                    }
                }else if($request->order_status == 'for_partial_refund'){
                    $data['order_status'] = 'for_release';
                    $success_message = "Order for released!";

                    /* Deduct to stocks */
                    $items = null;
                    $is_edit_item = OrderDetail::where([['order_id', "=", $order->id], ['is_edit', "=", 1]])
                                    ->orWhere([['order_id', "=", $order->id], ['edit_qty', '!=', null]])
                                    ->first();
                    
                    if($is_edit_item){
                        $items = OrderDetail::where([['order_id', "=", $order->id], ['is_edit', "=", 1]])
                            ->orWhere([['order_id', "=", $order->id], ['edit_qty', '!=', null]])
                            ->get();
                    }else{
                        $items = OrderDetail::where('order_id', $order->id)->get();
                    }
                           
                    if(isset($_COOKIE['store_data'])) {
                        $pup_id = json_decode($_COOKIE['store_data'])->id;
                    }
                    if($pup_id){
                        foreach ($items as $key => $item) {    
                            // var_dump($item->edit_qty); die; 
                            $product = \App\Product::where('id', $item->product_id)
                                ->select('id', 'name')
                                ->first();

                            if ($item->variation != null) {
                                $product_stock = \App\ProductStock::where('product_id', $item->product_id)
                                    ->where('variant', $item->variation)
                                    ->select('product_id', 'variant', 'sku')
                                    ->first()->sku;
        
                                $worldcraft_stock = WorldcraftStock::where('sku_id', $product_stock)
                                    ->where('pup_location_id', $pup_id)
                                    ->first();
                            }
                            $worldcraft_stock->update([
                                'quantity' =>  $worldcraft_stock->quantity - ($item->edit_qty ? ($item->edit_qty < 0 ? 0 : $item->edit_qty) : $item->quantity)
                            ]);
                        }
                    }else{
                        flash(translate('An error occured!, Please try again later!'))->error();
                        return redirect()->route('cashier.order.view', ['id' => encrypt($order->id)]);
                    }
                    
                }
            }
            

            if(Order::where('id', $request->order_id)->update($data)){
                flash(translate($success_message))->success();
                return redirect()->route('cashier.orders');
            }else{
                flash(translate("Something went wrong, Please try again later!"))->error();
                return redirect()->back();
            }
        }

    }

    public function defectiveItem($defective_item){
          
        $post_data = json_encode($defective_item);
        $username = 'worldcraft';
        $password = 'wc_api2021';
        
        // Prepare new cURL resource
        $crl = curl_init('https://multi-linegroupofcompanies.com/wc_soh_down/api/defective/add_defective.php');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLINFO_HEADER_OUT, true);
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
          
        // Set HTTP Header for POST request 
        curl_setopt($crl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'),
        );

        // Submit the POST request
        $result = curl_exec($crl);
        $err = curl_error($crl);

        // Close cURL session handle
        curl_close($crl);

        $responseArr = null;
        if ($err) {
            // var_dump("cURL Error #:" . $err);
        } else {
            // var_dump($result);
            $responseArr = json_decode($result,true);
            // var_dump($responseArr); die;
        }
       
    }

    public function destroy($id)
    {
        $destroy_orderDetails = OrderEditDetail::where('id', $id)->first();

        if($destroy_orderDetails->is_edit == 1){
            $destroy_orderDetails = OrderEditDetail::findOrFail($id);
            $destroy_orderDetails->delete();
        }else{
            $destroy_orderDetails->update([
                'is_deleted' => 1,
            ]);
        }
      
        // $price = $destroy_orderDetails->price;
        // $order_id = $destroy_orderDetails->order_id;
        // $destroy_orderDetails = OrderEditDetail::findOrFail($id);
        // $destroy_orderDetails->delete();
      
        flash(translate("Successfully remove an item!"));
        // $this->update_grandTotalDestroy($order_id, $price);
        return redirect()->back();
    }

    public function update_grandTotalDestroy($id, $price){
          
        $update_order = Order::where('id', $id)->get()->first();
        $sum_total = $update_order->grand_total - $price;
    
        if($update_order->id){
            Order::where('id', $update_order->id)->update(array('grand_total' => $sum_total));
        }
    }

    public function updateCashierQuantity(Request $request)
    {
        $order_edit_details = OrderEditDetail::where('id', $request->id)->get()->first();
     
        $singlePrice = $order_edit_details->price / $order_edit_details->quantity;
        $new_price = $singlePrice * $request->quantity;

        $edit_qty_total = ($order_edit_details->edit_qty ? $order_edit_details->edit_qty : 0) + ($request->quantity - $order_edit_details->quantity);
        
        $is_add = false;
        if($request->quantity > $order_edit_details->quantity){
            $is_add = true;
        }

        if($request->id){
            if($order_edit_details->is_edit != null){
                OrderEditDetail::where('id', $request->id)->update(array('price' => $new_price, 'quantity' => $request->quantity));
            }else{
                OrderEditDetail::where('id', $request->id)->update(array('price' => $new_price, 'quantity' => $request->quantity, 'edit_qty' => $edit_qty_total));
            }
        }
        $response=(object)[
            "success" => true,
            "new_price" => $new_price, 
            "is_add" => $is_add,
            "result" => [
                "message" => "Successfull Update Price and Quantity"
            ]
        ];
        return response()->json($response, 201);
 
    }

    public function cancelEditOrder(Request $request){
        $order_edit_details = OrderEditDetail::where('order_id', $request->order_id)->get();

        if($order_edit_details){
            foreach($order_edit_details as $order => $item){
                $destroy_order = OrderEditDetail::findOrFail($item->id);
                $destroy_order->delete();
            }
        }
       
        $response=(object)[
            "success" => true,
            "url" => route('cashier.order.view', encrypt($request->order_id)),
            "result" => [
                "message" => "Successfully Cancel Edit Order!"
            ]
        ];
        return response()->json($response, 201);

    }

    public function listDefectiveItem(){
        $defective_list = DB::table('defective_items AS di')
         ->join('product_stocks AS ps', 'di.sku', '=', 'ps.sku')
         ->join('pickup_points AS pp', 'di.pup_id', '=', 'pp.id')
         ->join('products AS p', 'ps.product_id', '=', 'p.id')
         ->select('di.id', 'pp.name AS ppname', 'p.name AS pname', 'di.defective_qty', 'di.sku')
         ->paginate(15);
        
        return view('frontend.walkin.defective_item.defective_items', compact('defective_list'));
    }
}
