<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Other Payment Methods
use Auth;
use App\OtherPaymentMethod;
use App\OtherPaymentMethodStep;
use App\OtherPaymentMethodBankDetail;

class OtherPaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;

        $other_payment_methods = OtherPaymentMethod::orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $sort_search = $request->search;
            $other_payment_methods = $other_payment_methods->where('name', 'like', '%' . $sort_search . '%');
        }

        $other_payment_methods = $other_payment_methods->paginate(15);

        return view('backend.setup_configurations.other_payment_methods.index', compact('other_payment_methods', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.setup_configurations.other_payment_methods.create');
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
            'unique_id' => 'required',
            'name' => "required",
            'title' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);

        $other_payment_method = new OtherPaymentMethod;

        $other_payment_method->unique_id = $request->unique_id;
        $other_payment_method->name = $request->name;
        $other_payment_method->title = $request->title;
        $other_payment_method->description = $request->description;
        $other_payment_method->type = $request->type;

        $other_payment_method->save();

        $request_steps = [];

        for ($i = 1; $i <= $request->total_steps; $i++) {
            $step = 'step_' . $i;
            array_push($request_steps, $request->input($step));
        }

        if ($request_steps[0] != null) {
            foreach ($request_steps as $key => $value) {
                $other_payment_method_steps = new OtherPaymentMethodStep;

                $other_payment_method_steps->other_payment_method_id = $other_payment_method->id;
                $other_payment_method_steps->step = $value;

                $other_payment_method_steps->save();
            }
        }

        flash(translate('Other payment method successfully added!'))->success();
        return redirect()->route('other-payment-methods.index');
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
        $other_payment_method = OtherPaymentMethod::where('id', decrypt($id))
            ->first();

        $other_payment_method_steps = OtherPaymentMethodStep::where('other_payment_method_id', $other_payment_method->id)
            ->get();

        return view('backend.setup_configurations.other_payment_methods.edit', compact('other_payment_method', 'other_payment_method_steps'));
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
            'unique_id' => 'required',
            'name' => "required",
            'title' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);
        
        $other_payment_method = OtherPaymentMethod::where('id', $id)
            ->first();

        $other_payment_method->unique_id = $request->unique_id;
        $other_payment_method->name = $request->name;
        $other_payment_method->title = $request->title;
        $other_payment_method->description = $request->description;
        $other_payment_method->type = $request->type;

        $other_payment_method->save();

        $request_steps = [];

        for ($i = 1; $i <= $request->total_steps; $i++) {
            $step = 'step_' . $i;
            array_push($request_steps, $request->input($step));
        }

        if ($request_steps[0] != null) {
            $existing_steps = OtherPaymentMethodStep::where('other_payment_method_id', $other_payment_method->id)
                ->get();

            foreach ($existing_steps as $key => $value) {
                OtherPaymentMethodStep::destroy($value->id);
            }

            foreach ($request_steps as $key => $value) {
                $other_payment_method_steps = new OtherPaymentMethodStep;

                $other_payment_method_steps->other_payment_method_id = $other_payment_method->id;
                $other_payment_method_steps->step = $value;

                $other_payment_method_steps->save();
            }
        }

        flash(translate('Other payment method is successfully updated!'))->success();
        return redirect()->route('other-payment-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OtherPaymentMethod::destroy($id);

        flash(translate('Other payment method is successfully deleted!'))->success();
        return redirect()->route('other-payment-methods.index');
    }

    /**
     * [update_status description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    function update_status (Request $request) {
        $other_payment_method = OtherPaymentMethod::findOrFail($request->id);
        $other_payment_method->status = $request->status;
        $other_payment_method->is_walkin = $request->is_walkin;

        if($other_payment_method->save()) {
            return 1;
        }

        return 0;
    }

    /**
     * [update_follow_up_instruction_status description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    function update_follow_up_instruction_status (Request $request) {
        $other_payment_method = OtherPaymentMethod::findOrFail($request->id);
        $other_payment_method->follow_up_instruction = $request->status;

        if ($other_payment_method->save()) {
            return 1;
        }

        return 0;
    }

    /**
     * [other_payment_method_bank_details description]
     * @return [type] [description]
     */
    public function other_payment_method_bank_details()
    {
        $bank_details = OtherPaymentMethodBankDetail::orderBy('created_at', 'desc')
            ->paginate(15);

        return view('backend.setup_configurations.other_payment_methods.bank_details', compact('bank_details'));
    }

    /**
     * [other_payment_method_bank_details_create description]
     * @return [type] [description]
     */
    public function other_payment_method_bank_details_create()
    {
        $other_payment_methods = OtherPaymentMethod::where('status', 1)
            ->get();

        return view('backend.setup_configurations.other_payment_methods.bank_details_create', compact('other_payment_methods'));
    }

    public function other_payment_method_bank_details_store(Request $request)
    {
        $bank_detail = new OtherPaymentMethodBankDetail;

        $bank_detail->other_payment_method_id = $request->parent_id;
        $bank_detail->pickup_point_location = $request->pup_location_id;
        $bank_detail->bank_image = $request->bank_image;
        $bank_detail->bank_name = $request->bank_name;
        $bank_detail->bank_acc_name = $request->bank_acc_name;
        $bank_detail->bank_acc_number = $request->bank_acc_number;

        $bank_detail->save();

        flash(translate('Successfully saved bank.'))->success();
        return redirect()->route('bank_lists.index');
    }

    public function other_payment_method_bank_details_edit ($id)
    {
        $bank_detail = OtherPaymentMethodBankDetail::findOrFail(decrypt($id));
        $other_payment_methods = OtherPaymentMethod::where('status', 1)
            ->get();

        return view('backend.setup_configurations.other_payment_methods.bank_details_edit', compact('bank_detail', 'other_payment_methods'));
    }

    public function other_payment_method_bank_details_update (Request $request, $id)
    {
        $bank_detail = OtherPaymentMethodBankDetail::findOrFail($id);

        $bank_detail->other_payment_method_id = $request->parent_id;
        $bank_detail->pickup_point_location = $request->pup_location_id;
        $bank_detail->bank_image = $request->bank_image;
        $bank_detail->bank_name = $request->bank_name;
        $bank_detail->bank_acc_name = $request->bank_acc_name;
        $bank_detail->bank_acc_number = $request->bank_acc_number;

        if ($bank_detail->save()) {
            flash(translate("Successfully updated bank details!"))->success();
            return redirect()->route('bank_lists.index');
        }

        else {
            flash(translate("Something went wrong"))->error();
            return redirect()->back();
        }
    }

    public function other_payment_method_bank_details_delete($id)
    {
        OtherPaymentMethodBankDetail::destroy($id);

        flash(translate('Payment Method is successfully deleted!'))->success();
        return redirect()->back();
    }

    /**
     * [update_status description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    function update_bank_status (Request $request) {
        $OtherPaymentMethodBankDetail = OtherPaymentMethodBankDetail::findOrFail($request->id);
        $OtherPaymentMethodBankDetail->status = $request->status;

        if($OtherPaymentMethodBankDetail->save()) {
            return 1;
        }

        return 0;
    }
}
