<?php

namespace App\Http\Controllers;

use App\StoreLocation;
use Illuminate\Http\Request;

class StoreLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;

        $store_locations = StoreLocation::orderBy('created_at', 'desc')->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;
            $store_locations = $store_locations->where('name', 'like', '%' . $sort_search . '%')
                ->orWhere('phone_number', 'like', '%' . $sort_search . '%')
                ->orWhere('address', 'like', '%' . $sort_search . '%');
        }

        $store_locations = $store_locations->paginate(15);

        return view('backend.setup_configurations.store_locations.index', compact('store_locations', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.setup_configurations.store_locations.create');
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
            'island_name' => 'required',
            'name' => 'required|max:30',
            'address' => 'required|max:100',
            'phone_number' => 'required|max:14',
            'google_maps_url' => 'required'
        ]);

        $store_location = new StoreLocation;

        $store_location->island_name = $request->island_name;
        $store_location->name = $request->name;
        $store_location->address = $request->address;
        $store_location->phone_number = $request->phone_number;
        $store_location->google_maps_url = $request->google_maps_url;

        $store_location->save();

        flash(translate('Successfully added store location!'))->success();
        return redirect()->route('store-locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoreLocation  $storeLocation
     * @return \Illuminate\Http\Response
     */
    public function show(StoreLocation $storeLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoreLocation  $storeLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreLocation $store_location)
    {
        return view('backend.setup_configurations.store_locations.edit', compact('store_location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoreLocation  $storeLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreLocation $store_location)
    {
        $this->validate($request, [
            'island_name' => 'required',
            'name' => 'required|max:30',
            'address' => 'required|max:100',
            'phone_number' => 'required|max:14',
            'google_maps_url' => 'required'
        ]);

        $store_location->island_name = $request->island_name;
        $store_location->name = $request->name;
        $store_location->address = $request->address;
        $store_location->phone_number = $request->phone_number;
        $store_location->google_maps_url = $request->google_maps_url;

        $store_location->save();

        flash(translate('Successfully updated store location!'))->success();
        return redirect()->route('store-locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoreLocation  $storeLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StoreLocation::destroy($id);

        flash(translate('Successfully deleted store location!'))->success();
        return redirect()->route('store-locations.index');
    }

    /**
     * [update_status description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    function update_status (Request $request)
    {
        $store_location = StoreLocation::findOrFail($request->id);

        $store_location->status = $request->status;

        if ($store_location->save()) {
            return 1;
        }

        return 0;
    }
}
