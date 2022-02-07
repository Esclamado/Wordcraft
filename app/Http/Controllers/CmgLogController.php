<?php

namespace App\Http\Controllers;

use App\CmgLog;
use Illuminate\Http\Request;

class CmgLogController extends Controller
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
    public function store($request)
    {
        CmgLog::create([
            'user_id' => $request['user_id'],
            'order_id' => $request['order_id'],
            'activity' => $request['activity']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CmgLog  $cmgLog
     * @return \Illuminate\Http\Response
     */
    public function show(CmgLog $cmgLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CmgLog  $cmgLog
     * @return \Illuminate\Http\Response
     */
    public function edit(CmgLog $cmgLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CmgLog  $cmgLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmgLog $cmgLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CmgLog  $cmgLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmgLog $cmgLog)
    {
        //
    }
}
