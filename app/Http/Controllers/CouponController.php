<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Coupon;
use Schema;

use App\CouponCategory;

// Bundle 
use App\CouponBundle;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $category_id = null;
        $type = null;

        $coupons = Coupon::orderBy('id','desc')
            ->distinct();
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $coupons = $coupons->where('code', 'like', '%'. $sort_search . '%');
        }

        if ($request->category_id != "") {
            $category_id = $request->category_id;
            $coupons = $coupons->where('category_id', $category_id);
        }

        if ($request->type != "") {
            $type = $request->type;
            $coupons = $coupons->where('discount_type', $type);
        }

        $coupons = $coupons->paginate(10);

        return view('backend.marketing.coupons.index', compact('coupons', 'category_id', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coupon_categories = CouponCategory::where('status', 1)
            ->get(['id', 'name']);

        return view('backend.marketing.coupons.create', compact('coupon_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'coupon_type' => 'required',
            'category_id' => "required",
            'usage_limit' => 'integer|nullable',
            'usage_limit_user' => 'required'
        ]);

        if (count(Coupon::where('code', $request->coupon_code)->get()) > 0) {
            flash(translate('Coupon already exists for this coupon code'))->error();
            return redirect()->back();
        }

        $data = [
            'usage_limit' => 'required',
            'usage_limit_user' => 'required',
        ];

        $coupon = new Coupon;

        if ($request->coupon_type == 'product_base') {
            $coupon->type = $request->coupon_type;
            $coupon->code = $request->coupon_code;
            $coupon->discount = $request->discount;
            $coupon->discount_type = $request->discount_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime( $date_var[1]);
            $cupon_details = array();

            foreach($request->product_ids as $product_id) {
                $data['product_id'] = $product_id;
                array_push($cupon_details, $data);
            }
           
            $coupon->details = json_encode($cupon_details);
            
            $coupon->save();
        }

        elseif ($request->coupon_type == "cart_base") {
            $coupon->type             = $request->coupon_type;
            $coupon->code             = $request->coupon_code;
            $coupon->discount         = $request->discount;
            $coupon->discount_type    = $request->discount_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime( $date_var[1]);
            $data                     = array();
            $data['min_buy']          = $request->min_buy;
            $data['max_discount']     = $request->max_discount;
            $coupon->details          = json_encode($data);

            $coupon->save();
        }

        // Check for usage limit
        $coupon->category_id = $request->category_id;
        $coupon->usage_limit = $request->usage_limit;
        $coupon->usage_limit_user = $request->usage_limit_user;
        $coupon->description = $request->description;

        // Check if role restricted
        if ($request->role_restricted != null) {
            $coupon->role_restricted = 1;
            $coupon->roles = $request->roles;
        }

        // Check if for individual use only
        if ($request->individual_use != null) {
            $coupon->individual_use = 1;
            $coupon->individual_user_id = $request->individual_user_id;
        }

        if ($request->bundle_coupon != null) {

            $coupon->bundle_coupon_type = $request->bundle_coupon_type;
            $coupon->bundle_coupon = 1;

            if ($request->bundle_coupon_type == 'product') {
                foreach ($request->products as $key => $product) {
                    $bundle_products = new CouponBundle;
    
                    $bundle_products->coupon_id = $coupon->id;
                    $bundle_products->product_id = $product;
                    $bundle_products->product_quantity = $request['quantity_min_' . $product];
                    $bundle_products->product_quantity_max = $request['quantity_max_' . $product];
    
                    $bundle_products->save();
                }
            }

            else if ($request->bundle_coupon_type == 'category') {
                foreach ($request->categories as $key => $category) {
                    $bundle_categories = new \App\CouponCategoryBundle;

                    $bundle_categories->coupon_id = $coupon->id;
                    $bundle_categories->category_id = $category;
                    $bundle_categories->category_quantity = $request['quantity_min_' . $category];
                    $bundle_categories->category_quantity_max = $request['quantity_max_' . $category];

                    $bundle_categories->save();
                }
            }
        }

        if ($coupon->save()) {
            flash(translate('Coupon saved successfully!'))->success();
            return redirect()->route('coupon.index');
        }

        else {
            flash(translate('Something went wrong!'))->failed();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail(decrypt($id));
        $coupon_categories = CouponCategory::where('status', 1)
            ->get(['id', 'name']);
        return view('backend.marketing.coupons.edit', compact('coupon', 'coupon_categories'));
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

        $this->validate($request, [
            'coupon_type' => 'required',
            'category_id' => "required",
            'usage_limit' => 'required',
            'usage_limit_user' => 'required'
        ]);

        if (count(Coupon::where('id', '!=' , $id)->where('code', $request->coupon_code)->get()) > 0){
            flash(translate('Coupon already exist for this coupon code'))->error();
            return back();
        }

        $coupon = Coupon::findOrFail($id);

        if ($request->coupon_type == "product_base") {
            $coupon->type = $request->coupon_type;
            $coupon->code = $request->coupon_code;
            $coupon->discount = $request->discount;
            $coupon->discount_type  = $request->discount_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime( $date_var[1]);
            $cupon_details = array();

            foreach($request->product_ids as $product_id) {
                $data['product_id'] = $product_id;
                array_push($cupon_details, $data);
            }
            
            $coupon->details = json_encode($cupon_details);

            $coupon->save();
        }

        elseif ($request->coupon_type == "cart_base") {
            $coupon->type           = $request->coupon_type;
            $coupon->code           = $request->coupon_code;
            $coupon->discount       = $request->discount;
            $coupon->discount_type  = $request->discount_type;
            $date_var               = explode(" - ", $request->date_range);
            $coupon->start_date     = strtotime($date_var[0]);
            $coupon->end_date       = strtotime( $date_var[1]);
            $data                   = array();
            $data['min_buy']        = $request->min_buy;
            $data['max_discount']   = $request->max_discount;
            $coupon->details        = json_encode($data);
            
            $coupon->save();
        }

        // Coupon additional information
        $coupon->category_id = $request->category_id;
        $coupon->usage_limit = $request->usage_limit;
        $coupon->usage_limit_user = $request->usage_limit_user;
        $coupon->description = $request->description;

        // Check if role restricted
        if ($request->role_restricted != null) {
            $coupon->role_restricted = 1;
            $coupon->roles = $request->roles;
        }
        
        else {
            $coupon->role_restricted = 0;
        }

        // Check if for individual use only
        if ($request->individual_use != null) {
            $coupon->individual_use = 1;
            $coupon->individual_user_id = $request->individual_user_id;
        }

        else {
            $coupon->individual_use = 0;
        }

        // Check if bundled coupon is checked
        if ($request->bundle_coupon != null) {

            $coupon->bundle_coupon_type = $request->bundle_coupon_type;
            $coupon->bundle_coupon = 1;

            if ($request->bundle_coupon_type == 'product') {
                $coupon_bundles = CouponBundle::where('coupon_id', $coupon->id)->get();

                foreach ($coupon_bundles as $key => $bundle) {
                    $bundle->delete();
                }
    
                foreach ($request->products as $key => $product) {
                    $bundle_products = new CouponBundle;
    
                    $bundle_products->coupon_id = $coupon->id;
                    $bundle_products->product_id = $product;
                    $bundle_products->product_quantity = $request['quantity_min_' . $product];
                    $bundle_products->product_quantity_max = $request['quantity_max_' . $product];
    
                    $bundle_products->save();
                }
            }

            elseif ($request->bundle_coupon_type == 'category') {
                $coupon_category_bundles = \App\CouponCategoryBundle::where('coupon_id', $coupon->id)->get();

                foreach ($coupon_category_bundles as $key => $bundle_category) {
                    $bundle_category->delete();
                }

                foreach ($request->categories as $key => $category) {
                    $bundle_categories = new \App\CouponCategoryBundle;

                    $bundle_categories->coupon_id = $coupon->id;
                    $bundle_categories->category_id = $category;
                    $bundle_categories->category_quantity = $request['quantity_min_' . $category];
                    $bundle_categories->category_quantity_max = $request['quantity_max_' . $category];
                    
                    $bundle_categories->save();
                }
            }
        }

        else {
            $coupon->bundle_coupon = 0;
            $coupon->bundle_coupon_type = null;

            $coupon_bundles = CouponBundle::where('coupon_id', $coupon->id)->get();
            $coupon_category_bundles = \App\CouponCategoryBundle::where('coupon_id', $coupon->id)->get();

            foreach ($coupon_bundles as $key => $bundle) {
                $bundle->delete();
            }

            foreach ($coupon_category_bundles as $key => $category_bundle) {
                $category_bundle->delete();
            }
        }

        if ($coupon->save()) {
            flash(translate('Coupon has been saved successfully'))->success();
            return redirect()->route('coupon.index');
        }

        else {
            flash(translate('Something went wrong'))->danger();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        if(Coupon::destroy($id)){
            flash(translate('Coupon has been deleted successfully'))->success();
            return redirect()->route('coupon.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function get_coupon_form(Request $request)
    {
        if($request->coupon_type == "product_base") {
            return view('backend.marketing.coupons.product_base_coupon');
        }
        elseif($request->coupon_type == "cart_base"){
            return view('backend.marketing.coupons.cart_base_coupon');
        }
    }

    public function get_coupon_form_edit(Request $request)
    {
        if($request->coupon_type == "product_base") {
            $coupon = Coupon::findOrFail($request->id);
            return view('backend.marketing.coupons.product_base_coupon_edit',compact('coupon'));
        }
        elseif($request->coupon_type == "cart_base"){
            $coupon = Coupon::findOrFail($request->id);
            return view('backend.marketing.coupons.cart_base_coupon_edit',compact('coupon'));
        }
    }

    public function bundle_product(Request $request) {
        $product_ids = $request->product_ids;

        return view('backend.marketing.coupons.bundle_product', compact('product_ids'));
    }

    public function bundle_product_edit (Request $request) {
        $product_ids = $request->product_ids;
        $coupon_id = $request->coupon_id;

        return view('backend.marketing.coupons.bundle_product_edit', compact('product_ids', 'coupon_id'));
    }

    public function bundle_category (Request $request) {
        $category_ids = $request->category_ids;

        return view('backend.marketing.coupons.bundle_category', compact('category_ids'));
    }

    public function bundle_category_edit (Request $request) {
        $category_ids = $request->category_ids;
        $coupon_id = $request->coupon_id;

        return view('backend.marketing.coupons.bundle_category_edit', compact('category_ids', 'coupon_id'));
    }

}
