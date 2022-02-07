<?php

namespace App\Http\Controllers;

use App\PaymentChannel;
use App\PaymentMethodList;
use Illuminate\Http\Request;

class PaymentChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;

        $payment_channels = PaymentChannel::orderBy('payment_method_id', 'asc');

        if ($request->has('search')) {
            $sort_search = $request->search;

            $payment_channels = $payment_channels->where('name', 'like', '%' . $sort_search . '%')
                ->where('value', 'like', '%' . $sort_search . '%');
        }

        $payment_channels = $payment_channels->paginate(15);

        return view('backend.setup_configurations.payment_methods.payment_channels.index', compact('payment_channels', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment_methods = PaymentMethodList::get(['id', 'name']);

        return view('backend.setup_configurations.payment_methods.payment_channels.create', compact('payment_methods'));
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
            'payment_method' => 'required',
            'name' => 'required|max:70',
            'value' => 'required|max:70',
            'image' => 'required',
            'price' => 'required|integer',
            'description' => 'max:255'
        ]);

        $payment_channel = new PaymentChannel;

        $payment_channel->payment_method_id  = $request->payment_method;
        $payment_channel->name              = $request->name;
        $payment_channel->value             = $request->value;
        $payment_channel->image             = $request->image;
        $payment_channel->price             = $request->price;
        $payment_channel->rate              = $request->rate;
        $payment_channel->description       = $request->description;

        if ($payment_channel->save()) {
            flash(translate('Payment channel successfully saved!'))->success();
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentChannel  $paymentChannel
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentChannel $paymentChannel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentChannel  $paymentChannel
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentChannel $paymentChannel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentChannel  $paymentChannel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentChannel $paymentChannel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentChannel  $paymentChannel
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentChannel $paymentChannel)
    {
        //
    }

    /**
     * [update_status description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update_status (Request $request) {
        $payment_channel = PaymentChannel::findOrFail($request->id);
        $payment_channel->status = $request->status;

        if ($payment_channel->save()) {
            return 1;
        }

        return 0;
    }
}
