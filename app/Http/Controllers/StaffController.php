<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Role;
use App\User;
use App\AffiliateUser;
use Hash;
use Illuminate\Support\Str;

// Mail
use Mail;
use App\Mail\EmailManager;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $sort_by_role = null;

        $staffs = Staff::orderBy('created_at', 'desc');

        if ($request->role != null) {
            $sort_by_role = $request->role;

            $staffs = $staffs->where('role_id', $sort_by_role);
        }

        if ($request->has('search')) {
            $sort_search = $request->search;

            $staffs = $staffs->whereHas('user', function ($query) use ($sort_search) {
                $query->where('name', 'like', '%' . $sort_search . '%')
                    ->orWhere('email', 'like', '%' . $sort_search . '%')
                    ->orWhere('username', 'like', '%' . $sort_search . '%')
                    ->orWhere('employee_id', 'like', '%' . $sort_search . '%');
            });
        }

        $staffs = $staffs->paginate(15);

        $roles = Role::all();

        return view('backend.staff.staffs.index', compact('staffs', 'sort_search', 'roles', 'sort_by_role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('backend.staff.staffs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::find($request->role_id);
        $role = strtolower($role->name);
        $user = new User;

        if ($role == 'employee') {
            $this->validate($request, [
                'employee_id' => 'required|max:255|unique:users,employee_id',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'required',
                'password' => 'required|max:255',
            ]);
            
            $phone_number = str_replace('+' . $request->country_code, '', str_replace(' ', '', $request->phone));
            $check_phone_exists = User::where('phone', '+' . $phone_number)
                ->exists();

            if ($check_phone_exists) {
                flash(translate('Phone number already exists'));
                return redirect()->back();
            }

            $user->employee_id = $request->employee_id;
            $user->user_type = $role;
            $user->email_verified_at = date("Y-m-d H:i:s");
        }

        else {
            $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'required',
                'password' => 'required|max:70',
            ]);

            $phone_number = str_replace('+' . $request->country_code, '', str_replace(' ', '', $request->phone));
            $check_phone_exists = User::where('phone', '+' . $phone_number)
                ->exists();

            if ($check_phone_exists) {
                flash(translate('Phone number already exists'));
                return redirect()->back();
            }

            $user->user_type = "staff";
        }

        $user->unique_id = unique_code(9);
        $user->email = $request->email;
        $user->phone = '+' . $request->country_code . $phone_number;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $this->check_username(mb_strtolower(str_replace(' ', '.', $request->first_name)) . '.' . mb_strtolower(str_replace(' ', '.', $request->last_name)));
        $user->password = Hash::make($request->password);
        $user->permissions = json_encode($request->permissions);

        if ($user->save()) {
            $staff = new Staff;

            $staff->user_id = $user->id;
            $staff->role_id = $request->role_id;

            $ref_code = substr($user->id.Str::random(), 0, 10);
            $user->referral_code = $ref_code;

            $user->save();

            if ($staff->save()) {
                if ($user->user_type == 'employee') {
                    $array['view'] = 'emails.newsletter';
                    $array['subject'] = 'Worldcraft Employee Account';
                    $array['from'] = env('MAIL_USERNAME');
                    $array['content'] = "
                        <html>
                            <body>
                                <h3>Hello!</h3>
                                <br />
                                <p>Worldcraft PH has created you an employee account. The following information is for your eyes only.</p>
                                <br />
                                <ul>
                                    <li>Employee ID: <b>$user->employee_id</b></li>
                                    <li>Email: <b>$user->email</b></li>
                                    <li>Password: <b>$request->password</b></li>
                                </ul>
                                <br />
                                <p>If you have any concerns you can contact the management.</p>
                                <br />
                                <p>Thank you!</p>
                            </body>
                        </html>
                    ";

                    Mail::to($user->email)->queue(new EmailManager($array));
                }

                flash(translate('Staff has been inserted successfully'))->success();
                return redirect()->route('staffs.index');
            }
        }
    }

    private function check_username ($username) {
        $username_exists = User::where('username', $username)
            ->exists();

        if ($username_exists) {
            return $username . '.' . unique_order_number();
        }

        else {
            return $username;
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
        $staff = Staff::findOrFail(decrypt($id));
        $roles = Role::all();
        return view('backend.staff.staffs.edit', compact('staff', 'roles'));
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
        $role = Role::find($request->role_id);
        $role = strtolower($role->name);
        $staff = Staff::findOrFail($id);

        $user = User::where('id', $staff->user_id)
            ->first();

        if ($role == 'employee') {
            $this->validate($request, [
                'employee_id' => 'required|max:255|unique:users,employee_id,' . $user->id,
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'required',
            ]);
            
            $phone_number = str_replace('+' . $request->country_code, '', str_replace(' ', '', $request->phone));
            $check_phone_exists = User::where('phone', '+' . $phone_number)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($check_phone_exists) {
                flash(translate('Phone number already exists'));
                return redirect()->back();
            }

            $user->employee_id = $request->employee_id;
            $user->user_type = $role;
            $user->email_verified_at = date("Y-m-d H:i:s");
        }

        else {
            $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'required',
            ]);

            $phone_number = str_replace('+' . $request->country_code, '', str_replace(' ', '', $request->phone));
            $check_phone_exists = User::where('phone', '+' . $phone_number)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($check_phone_exists) {
                flash(translate('Phone number already exists'));
                return redirect()->back();
            }

            $user->user_type = "staff";
        }

        $user->email = $request->email;
        $user->phone = '+' . $request->country_code . $phone_number;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $this->check_username(mb_strtolower(str_replace(' ', '.', $request->first_name)) . '.' . mb_strtolower(str_replace(' ', '.', $request->last_name)));
        $user->permissions = json_encode($request->permissions);

        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }

        if ($user->save()) {
            if ($role == 'employee') {
                if ($user->referral_code == null) {
                    $ref_code = substr($user->id.Str::random(), 0, 10);
                    $user->referral_code = $ref_code;

                    $user->save();
                } 
            }

            $staff->role_id = $request->role_id;
            if ($staff->save()) {
                flash(translate('Staff has been updated successfully'))->success();
                return redirect()->route('staffs.index');
            }
        }

        else {
            flash (translate('Something went wrong'))->error();
            return redirect()->back();
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
        User::destroy(Staff::findOrFail($id)->user->id);
        if(Staff::destroy($id)){
            flash(translate('Staff has been deleted successfully'))->success();
            return redirect()->route('staffs.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * [ban_employee description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function ban_employee($id) {
        $employee = User::findOrFail($id);

        if ($employee->banned == 1) {
            $employee->banned = 0;
            flash (translate('Employee unbanned successfully'))->success();
        }

        else {
            $employee->banned = 1;
            flash(translate('Employee banned successfully'))->success();
        }

        $employee->save();
        return redirect()->back();
    }
}
