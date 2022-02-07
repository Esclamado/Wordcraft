<?php

namespace App\Http\Controllers;

use App\PaymentMethodList;
use Illuminate\Http\Request;

class PaymentMethodListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;

        $payment_method_lists = PaymentMethodList::orderBy('name', 'asc');

        if ($request->has('search')) {
            $sort_search = $request->search;
            $payment_method_lists = $payment_method_lists->where('name', 'like', '%' . $sort_search . '%');
        }

        $payment_method_lists = $payment_method_lists->paginate(15);

        return view('backend.setup_configurations.payment_method', compact('payment_method_lists', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.setup_configurations.payment_methods.create');
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
            'value' => 'required|unique:payment_method_lists',
        ]);

        $payment_method_list = new PaymentMethodList;

        $payment_method_list->name      = $request->name;
        $payment_method_list->value     = $request->value;

        if ($payment_method_list->save()) {
            flash(translate('Payment method successfully saved!'))->success();
        }

        else {
            flash(translate('Something went wrong'))->error();
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentMethodList  $paymentMethodList
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethodList $paymentMethodList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentMethodList  $paymentMethodList
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethodList $paymentMethodList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethodList  $paymentMethodList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethodList $paymentMethodList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethodList  $paymentMethodList
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethodList $paymentMethodList)
    {
        //
    }

    /**
     * [update_status description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    function update_status (Request $request) {
        $payment_method_list = PaymentMethodList::findOrFail($request->id);
        $payment_method_list->status = $request->status;
       

        if ($payment_method_list->save()) {
            return 1;
        }

        return 0;
    }
}
