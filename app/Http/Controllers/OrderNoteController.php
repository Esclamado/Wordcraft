<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderNote;
use Auth;
use App\Http\Controllers\OTPVerificationController;

class OrderNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $order_notes = OrderNote::where('order_id', $request->order_id)
            ->get(['order_id', 'user_id', 'type', 'message']);
    }

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
    public function destroy($id)
    {
        //
    }
}
