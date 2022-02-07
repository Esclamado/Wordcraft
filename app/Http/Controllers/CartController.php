<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubSubCategory;
use App\Category;
use Session;
use App\Color;
use Cookie;
use Auth;
use Illuminate\Support\Facades\Route;

class CartController extends Controller
{
    public function index(Request $request)
    {
        //dd($cart->all());
        $categories = Category::all();
        Session::forget('toCheckout');

        $route = Route::currentRouteName();

        /* change redirection for walkin */
        if(strpos($route, 'walkin') !== false){
            return view('frontend.walkin.cart.view_cart', compact('categories'));
        }else{
            return view('frontend.view_cart', compact('categories'));
        }
       
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.partials.addToCart', compact('product'));
    }

    public function updateNavCart(Request $request)
    {
        return view('frontend.partials.cart');
    }


    public function addToCart(Request $request)
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

        if(Cookie::has('referred_product_id') && Cookie::get('referred_product_id') == $product->id) {
            $data['product_referral_code'] = Cookie::get('product_referral_code');
        }

        if($request->session()->has('cart')) {
            $foundInCart = false;
            $cart = collect();

            foreach ($request->session()->get('cart') as $key => $cartItem){
                if($cartItem['id'] == $request->id && $cartItem['pickup_location'] == $request->pickup_location){
                    if($str != null){
                        if($cartItem['variant'] == $str){
                            $foundInCart = true;
                            $cartItem['quantity'] += $request['quantity'];
                        }
                    }else{
                        $foundInCart = true;
                        $cartItem['quantity'] += $request['quantity'];
                    }

                }
                $cart->push($cartItem);
            }

            if (!$foundInCart) {
                $cart->push($data);
            }

            $request->session()->put('cart', $cart);
        }
        else{
            $cart = collect([$data]);
            $request->session()->put('cart', $cart);
        }

        $handlingfees = collect(json_decode($request['handlingFee']));
        $request->session()->put('handlingFee', $handlingfees);

        if ($request->pickup_location != "") {
            $route = Route::currentRouteName();
        
            if(strpos($route, 'walkin') !== false){
                return array('status' => 1, 'view' => view('frontend.walkin.partials.addedToCart', compact('product', 'data'))->render());
            }else{
                return array('status' => 1, 'view' => view('frontend.partials.addedToCart', compact('product', 'data'))->render());
            }
        }

        else {
            return array('status' => 0);
        }
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart', $cart);
        }

        if (Session::has('coupon_id') && Session::has('coupon_discount')) {
            $request->session()->forget('coupon_id');
            $request->session()->forget('coupon_discount');
        }
        
        return view('frontend.partials.cart_details');
    }

    public function removeWalkinFromCart(Request $request)
    {
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart', $cart);
        }

        if (Session::has('coupon_id') && Session::has('coupon_discount')) {
            $request->session()->forget('coupon_id');
            $request->session()->forget('coupon_discount');
        }
        
        return view('frontend.walkin.cart.view_cart');
    }
     //removes multiple items from Cart
    public function removeItemsFromCart(Request $request)
    {
        // dd($request->key);die;
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart', collect([]));
            if(count($request->key)>0){
                foreach ($request->key as $key => $id){
                    $cart->forget($id);
                }
            }
           else{
            $cart->forget($request->key);
           }
            $request->session()->put('cart', $cart);
        }

        if (Session::has('coupon_id') && Session::has('coupon_discount')) {
            $request->session()->forget('coupon_id');
            $request->session()->forget('coupon_discount');
        }
        
        return view('frontend.partials.cart_details');
    }
    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('cart', collect([]));

        $cart = $cart->map(function ($object, $key) use ($request) {
            if($key == $request->key){
                $product = \App\Product::find($object['id']);

                if($object['variant'] != null && $product->variant_product){
                    $product_stock = $product->stocks->where('variant', $object['variant'])->first();

                    $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $product_stock->sku)
                        ->first()->quantity;

                    $quantity = $worldcraft_stock;

                    if($quantity >= $request->quantity){
                        if($request->quantity >= $product->min_qty){
                            $object['quantity'] = $request->quantity;
                        }
                    }
                }

                elseif ($product->current_stock >= $request->quantity) {
                    $object['quantity'] = $request->quantity;
                }

                else {
                    $object['quantity'] = $request->quantity;
                }
            }
            return $object;
        });

        if (Session::get('coupon_id') != null && Session::get('coupon_discount') != null) {
            Session::forget('coupon_id');
            Session::forget('coupon_discount');
        }

        $request->session()->put('cart', $cart);

        return Session::get('cart');
        // return view('frontend.partials.cart_details');
    }
}
