<?php

namespace App\Http\Controllers;

use App\CouponCategory;
use Illuminate\Http\Request;

class CouponCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;

        $coupon_categories = CouponCategory::orderBy('created_at', 'desc')
            ->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;

            $coupon_categories = $coupon_categories->where('name', 'like', '%' . $sort_search . '%');
        }

        $coupon_categories = $coupon_categories->paginate(10);

        return view('backend.marketing.coupon_categories.index', compact('coupon_categories', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.marketing.coupon_categories.create');
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
            'name' => 'required|max:70',
        ]);

        $coupon_category = new CouponCategory;

        $coupon_category->name = $request->name;
        $coupon_category->description = $request->description;

        if ($coupon_category->save()) {
            flash(translate('Coupon category successfully saved!'))->success();
        }

        else {
            flash(translate('Something went wrong!'))->error();
        }
        
        return redirect()->route('coupon-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CouponCategory  $couponCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CouponCategory $couponCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CouponCategory  $couponCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CouponCategory $couponCategory)
    {
        return view('backend.marketing.coupon_categories.edit', compact('couponCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CouponCategory  $couponCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CouponCategory $couponCategory)
    {
        $this->validate($request, [
            'name' => 'required|max:70'
        ]);

        $couponCategory->name = $request->name;
        $couponCategory->description = $request->description;
        
        if ($couponCategory->save()) {
            flash(translate('Coupon category successfully updated!'))->success();
        } 

        else {
            flash(translate('Something went wrong'))->error();
        }

        return redirect()->route('coupon-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CouponCategory  $couponCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon_category = CouponCategory::findOrFail($id);

        if (CouponCategory::destroy($id)) {
            flash(translate('Coupon Category has been deleted successfully'))->success();
            return redirect()->back();
        }
        else {
            flash(translate('Something went wrong'))->error();
            return redirect()->back();
        }
    }

    public function update_status(Request $request) {
        $coupon_category = CouponCategory::findOrFail($request->id);
        $coupon_category->status = $request->status;
        if ($coupon_category->save()) {
            return 1;
        }

        return 0;
    }
}
