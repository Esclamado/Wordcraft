<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use App\Order;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date;
        $sort_search = null;

        $customers = User::where('user_type', 'customer')
            ->orderBy('name', 'asc')
            ->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;

            $customers = $customers->where(function ($query) use ($sort_search) {
                $query->where('name', 'like', '%' . $sort_search .'%')
                    ->orWhere('email', 'like', '%' . $sort_search . '%')
                    ->orWhere('username', 'like', '%' . $sort_search . '%')
                    ->orWhere('phone', 'like', '%' . $sort_search . '%');
            });
        }

        if ($request->date != null) {
            $start_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[0]))->toDateTimeString();
            $end_date = \Carbon\Carbon::parse(strtotime(explode(" to ", $date)[1]))->toDateTimeString();

            if ($start_date == $end_date) {
                $customers = $customers->where('created_at', '>=', $start_date);
            }

            else {
                $customers = $customers->where('created_at', '>=', $start_date)
                    ->where('created_at', '<=', $end_date);
            }
        }

        $customers = $customers->paginate(15);

        return view('backend.customer.customers.index', compact('customers', 'sort_search', 'date'));
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
        //
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
        Order::where('user_id', $id)->delete();

        if(User::destroy($id)){
            flash(translate('Customer has been deleted successfully'))->success();
            return redirect()->back();
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function login($id)
    {
        $customer = Customer::findOrFail(decrypt($id));

        $user  = $customer->user;

        auth()->login($user, true);

        return redirect()->route('dashboard');
    }

    public function ban($id) {
        $user = User::findOrFail($id);

        if ($user->banned == 1) {
            $user->banned = 0;

            $user->save();
            flash(translate('User un-banned successfully'))->success();
            return redirect()->back();
        }

        else {
            $user->banned = 1;
            
            $user->save();
            flash(translate('User banned successfully'))->success();
            return redirect()->back();
        }
    }
}
