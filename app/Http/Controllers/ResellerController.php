<?php

namespace App\Http\Controllers;

use App\Reseller;
use App\EmploymentStatusFile;
use Illuminate\Http\Request;
use App\User;
use App\Customer;
use App\BusinessSetting;
use App\OtpConfiguration;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OTPVerificationController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Cookie;
use Nexmo;
use Twilio\Rest\Client;
use \stdClass;
use Illuminate\Support\Str;
use Session;
use Auth;
use App\RefundRequest;

// Reseller
use App\ResellerCustomer;
use App\ResellerCustomerOrder;
use App\OrderDetail;
use App\AffiliateUser;
use App\AffiliateWithdrawRequest;
use App\Wallet;
use App\Order;

// DB
use DB;

use App\EmployeeReseller;


class ResellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $step)
    {
        if (Auth::check()) {
            if (Auth::user()->user_type == 'customer') {
                $id = 1;
                if($step == 1){

                    if ($request->has('referral_code')) {
                        Cookie::queue('referral_code', $request->referral_code, 43200);
                    }

                    $page_data['page'] = 1;
                    $data_array = [];
                    $page_data['data'] = [];

                    array_push($page_data['data'],$data_array);

                    $data = json_encode($page_data);

                    Cookie::queue('rgest', $data, 43200);

                } else {
                    $id = $step;
                }

                return view('frontend.reseller_registration',compact('id'));
            } else {
                return redirect()->route('home');
            }
        }
        return redirect()->route('home');
    }

    /**
     * [validate_step_1 description]
     * @param [type] $request [description]
     */
    private function validate_step_1 ($request) : void {
        $message = [
            'e_idnumber.required' => "Please input employee ID No. If you don't have any referrals you can just click the skip button below."
        ];

        $this->validate($request, [
            'e_idnumber' => 'required'
        ], $message);
    }

    /**
     * [validate_step_2 description]
     * @param [type] $request [description]
     */
    private function validate_step_2 ($request) : void {
        $message = [
            'firstName.required'            => 'Please input your first name',
            'lastName.required'             => 'Please input your last name',
            'mobileNumber.required'         => 'Please input your mobile number',
            'emailAddress.required'         => 'Please input your e-mail address',
            'address.required'              => 'Please input your full address',
            'city.required'                 => 'Please input your city',
            'birthdate.required'            => 'Please input your birthdate'
        ];

        $this->validate($request, [
            'firstName'     => 'required|max:50',
            'lastName'      => 'required|max:50',
            'mobileNumber'  => 'required|min:11',
            'emailAddress'  => 'required|email|max:50',
            'address'       => 'required',
            'postalCode'    => 'max:4',
            'city'          => 'required',
            'birthdate'     => 'required'
        ], $message);
    }

    /**
     * [validate_step_3 description]
     * @param [type] $request            [description]
     * @param [type] $employement_status [description]
     */
    private function validate_step_3 ($request, $employment_status) : void {
        $message = [
            'employmentStatus.required' => 'Please select your employment status'
        ];

        $rules = [
            'employmentStatus' => 'required'
        ];

        // Validate Employed
        if ($employment_status == 'Employed')
        {
            $message = [
                'companyName.required'          => 'Please input your company name',
                'companyContactNo.required'     => 'Please input your company contact number',
                'companyAddress.required'       => 'Please input your company full address',
                'companyId.required'            => 'Please attach your company ID',
                'emp_governmentId.required'     => 'Please attach your valid government ID',
                'employee_tin.max'              => "Please enter the correct TIN Number",
            ];

            $rules = [
                'companyName'       => 'required',
                'companyContactNo'  => 'required',
                'companyAddress'    => 'required',
                'companyId'         => 'required',
                'emp_governmentId'  => 'required',
                'employee_tin'      => 'max:12',
            ];
        }

        else if ($employment_status == 'Business')
        {
            $message = [
                'businessName.required'         => 'Please input your business name',
                'businessAddress.required'      => 'Please input your business address',
                'natureOfBusiness.required'     => 'Please input the nature of your business',
                'office.required'               => 'Please input your full office address',
                'yearsInBusiness.required'      => 'Please input how many years in business you have',
                'mayorsBusinessPermit.required' => "Please attach your mayor's business permit",
                'dti.required'                  => "Please attach your DTI/SEC certificate of registration",
                'bir.required'                  => "Please attch your BIR certificate of registration",
                'bus_governmentId.required'     => "Please attach one of your valid government-issued ID",
                'businessStructure.required'    => "Please attach your business structure of the owned company",
                'business_tin.max'              => "Please enter the correct TIN Number",
                
            ];

            $rules = [
                'businessName'          => 'required',
                'businessAddress'       => 'required',
                'natureOfBusiness'      => 'required',
                'office'                => 'required',
                'yearsInBusiness'       => 'required',
                'mayorsBusinessPermit'  => 'required',
                'dti'                   => 'required',
                'bir'                   => 'required',
                'bus_governmentId'      => 'required',
                'businessStructure'     => 'required',
                'business_tin'          => 'max:12',
            ];
        }

        else if ($employment_status == 'Freelancer')
        {
            $message = [
                'fre_governmentId.required'     => 'Please attach your valid government ID',
                'freelance_tin.max'             => "Please enter the correct TIN Number",
            ];

            $rules = [
                'fre_governmentId'  => 'required',
                'freelance_tin'     => 'max:12',
            ];
        }

        else if ($employment_status == 'Student')
        {
            $message = [
                'schoolId.required'         => "Please attach your school's ID",
                'parentConsent.required'    => "Please attach your parent's consent letter",
                'student_tin.max'           => "Please enter the correct TIN Number",
            ];

            $rules = [
                'schoolId'      => 'required',
                'parentConsent' => 'required',
                'student_tin'   => 'max:12',
            ];
        }

        else if ($employment_status == 'Housewife')
        {
            $message = [
                'hou_governmentId.required'  => 'Please attach your valid government ID',
                'housewife_tin.max'          => "Please enter the correct TIN Number",
            ];

            $rules = [
                'hou_governmentId'  => 'required',
                'housewife_tin'     => 'max:12',
            ];
        }

        else if ($employment_status == 'Others')
        {
            $message = [
                'oth_governmentId.required'      => "Please attach your valid government ID",
                'other_tin.max'                  => "Please enter the correct TIN Number",
            ];

            $rules = [
                'oth_governmentId'  => 'required',
                'other_tin'         => 'max:12',
            ];
        }

        $this->validate($request, $rules, $message);
    }

    /**
     * [reseller_register description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function reseller_register (Request $request, $id) {
        $page_controller    = json_decode(Cookie::get('rgest'));
        $page               = $page_controller->page ?? null;
        $data_length        = count($page_controller->data ?? json_decode(json_encode([])));

        if ($id == 1) {
            // First Step
            $this->validate_step_1($request);

            if ($request->e_idnumber != null) {
                // Check if employee id exists
                $employee = User::where('employee_id', $request->e_idnumber)->exists();

                if (!$employee) {
                    flash (translate('Employee does not exists!'));
                    return redirect()->back();
                }
            }

            $data_array = [
                'employeeIdNo'          => $request->e_idnumber ?? '',
                'employeeFirstName'     => $request->e_fname ?? '',
                'employeeLastName'      => $request->e_lname ?? '',
                'employeePosition'      => $request->e_position ?? '',
                'employeeEmailAddress'  => $request->e_emailaddress ?? '',
            ];

            $page_controller->page = 2;
            $page_controller->data[$page - 1] = $data_array;

            array_push($page_controller->data, []);

            $data = json_encode($page_controller);
            Cookie::queue('rgest', $data, 43200);

            $id = 2;

            return redirect('/reseller/registration/step/' . $id);
        }

        else if ($id == 2) {
            // Second step
            $this->validate_step_2($request);

            // Check if user is trying to register an already existing email
            if (Auth::user()->email != $request->emailAddress) {
                if (filter_var($request->emailAddress, FILTER_VALIDATE_EMAIL)) {
                    $user_exists = User::where('email', $request->emailAddress)->exists();

                    if ($user_exists) {
                        flash(translate('Email already exists.'))->error();
                        return redirect()->back();
                    }
                }
            }

            $request->mobileNumber = $string = str_replace(' ', '', $request->mobileNumber);

            $phone_exists = User::where('phone', '+' . $request->countryCode . $request->mobileNumber)
                ->where('id', '!=', Auth::user()->id)->exists();

            if ($phone_exists) {
                flash(translate('Phone already exists'))->error();
                return redirect()->back();
            }

            $birthdate = date('Y-m-d', strtotime($request->birthdate));

            $data_array = [
                'firstName'     => $request->firstName ?? '',
                'lastName'      => $request->lastName ?? '',
                'countryCode'   => $request->countryCode ?? '',
                'country'       => $request->country ?? '',
                'mobileNumber'  => str_replace(' ', '', $request->mobileNumber) ?? '',
                'phoneNumber'   => str_replace(' ', '', $request->phoneNumber) ?? '',
                'emailAddress'  => $request->emailAddress ?? '',
                'address'       => $request->address ?? '',
                'city'          => $request->city ?? '',
                'postalCode'    => $request->postalCode ?? '',
                'postal_code'   => $request->postalCode ?? '',
                'birthdate'     => $birthdate ?? '',
            ];

            $page_controller->page = 3;
            $page_controller->data[$page - 1] = $data_array;
            array_push($page_controller->data, []);
            $data = json_encode($page_controller);
            Cookie::queue('rgest', $data, 43200);

            $id = 3;

            $user_update = User::findOrFail(Auth::user()->id);

            flash(translate('Congratulations! One last step to register as our reseller.'))->success();
            return redirect('/reseller/registration/step/'. $id);
        }

        else if ($id == 3) {
            $this->validate_step_3($request, $request->employmentStatus);

            if ($request->employmentStatus == 'Employed') {
                // Save employment details
                $request->governmentId  = $request->emp_governmentId;
                $request->tin           = $request->employee_tin;

                /* Clear data */
                /* Business */
                $request->businessName          = null;
                $request->businessAddress       = null;
                $request->natureOfBusiness      = null;
                $request->office                = null;
                $request->yearsInBusiness       = null;
                $request->mayorsBusinessPermit  = null;
                $request->dti                   = null;
                $request->bir                   = null;
                $request->businessStructure     = null;

                /* student */
                $request->schoolId          = null;
                $request->parentConsent     = null;
                $request->student_tin       = null;

                /* Freelancer */
                $request->freelance_tin     = null;
                $request->fre_governmentId  = null;

                /* Housewife */
                $request->housewife_tin     = null;
                $request->hou_governmentId  = null;

                /* Others */
                $request->other_tin         = null;
                $request->oth_governmentId  = null;
            }

            else if ($request->employmentStatus == 'Business') {
                $request->governmentId  = $request->bus_governmentId;
                $request->tin           = $request->business_tin;

                /* Clear data */

                /* Employed */
                $request->companyName       = null;
                $request->companyContactNo  = null;
                $request->companyAddress    = null;
                $request->companyId         = null;

                /* student */
                $request->schoolId          = null;
                $request->parentConsent     = null;

                /* Freelancer */
                $request->fre_governmentId  = null;

                /* Housewife */
                $request->hou_governmentId  = null;

                /* Others */
                $request->oth_governmentId  = null;
            }

            else if ($request->employmentStatus == 'Freelancer')
            {
                $request->governmentId  = $request->fre_governmentId;
                $request->tin           = $request->freelance_tin;

                /* clear data */
                /* employed */
                $request->companyName       = null;
                $request->companyContactNo  = null;
                $request->companyAddress    = null;
                $request->companyId         = null;

                /* business */
                $request->businessName          = null;
                $request->businessAddress       = null;
                $request->natureOfBusiness      = null;
                $request->office                = null;
                $request->yearsInBusiness       = null;
                $request->mayorsBusinessPermit  = null;
                $request->dti                   = null;
                $request->bir                   = null;
                $request->businessStructure     = null;

                /* student */
                $request->schoolId          = null;
                $request->parentConsent     = null;

                /* Housewife */
                $request->hou_governmentId  = null;

                /* Others */
                $request->oth_governmentId  = null;
            }

            else if ($request->employmentStatus == 'Student')
            {
                /* clear data */
                /* employed */
                $request->companyName       = null;
                $request->companyContactNo  = null;
                $request->companyAddress    = null;
                $request->companyId         = null;

                /* business */
                $request->businessName          = null;
                $request->businessAddress       = null;
                $request->natureOfBusiness      = null;
                $request->office                = null;
                $request->yearsInBusiness       = null;
                $request->mayorsBusinessPermit  = null;
                $request->dti                   = null;
                $request->bir                   = null;
                $request->businessStructure     = null;

                /* Freelancer */
                $request->fre_governmentId  = null;

                /* Housewife */
                $request->hou_governmentId  = null;

                /* Others */
                $request->oth_governmentId  = null;
            }

            else if ($request->employmentStatus == 'Housewife')
            {
                $request->governmentId      = $request->hou_governmentId;
                $request->tin               = $request->housewife_tin;

                /* clear data */
                /* employed */
                $request->companyName       = null;
                $request->companyContactNo  = null;
                $request->companyAddress    = null;
                $request->companyId         = null;

                /* business */
                $request->businessName          = null;
                $request->businessAddress       = null;
                $request->natureOfBusiness      = null;
                $request->office                = null;
                $request->yearsInBusiness       = null;
                $request->mayorsBusinessPermit  = null;
                $request->dti                   = null;
                $request->bir                   = null;
                $request->businessStructure     = null;

                /* Freelancer */
                $request->fre_governmentId  = null;

                /* student */
                $request->schoolId          = null;
                $request->parentConsent     = null;

                /* Others */
                $request->oth_governmentId  = null;
            }

            else if ($request->employmentStatus == 'Others')
            {
                $request->governmentId  = $request->oth_governmentId;
                $request->tin           = $request->other_tin;

                /* clear data */
                /* employed */
                $request->companyName       = null;
                $request->companyContactNo  = null;
                $request->companyAddress    = null;
                $request->companyId         = null;

                /* business */
                $request->businessName          = null;
                $request->businessAddress       = null;
                $request->natureOfBusiness      = null;
                $request->office                = null;
                $request->yearsInBusiness       = null;
                $request->mayorsBusinessPermit  = null;
                $request->dti                   = null;
                $request->bir                   = null;
                $request->businessStructure     = null;

                /* Freelancer */
                $request->fre_governmentId  = null;

                /* student */
                $request->schoolId          = null;
                $request->parentConsent     = null;

                /* Housewife */
                $request->hou_governmentId  = null;
            }

            $data_array = [
                'employmentStatus'      => $request->employmentStatus ?? '',
                'tin'                   => $request->tin ?? '',
                'companyName'           => $request->companyName ?? '',
                'companyContactNo'      => $request->companyContactNo ?? '',
                'companyAddress'        => $request->companyAddress ?? '',
                'businessName'          => $request->businessName ?? '',
                'businessAddress'       => $request->businessAddress ?? '',
                'natureOfBusiness'      => $request->natureOfBusiness ?? '',
                'office'                => $request->office ?? '',
                'files'                 => [
                    'company_id'                => $request->companyId ?? '',
                    'governmentId'              => $request->governmentId ?? '',
                    'mayors_business_permit'    => $request->mayors_business_permit ?? '',
                    'dti'                       => $request->dti ?? '',
                    'bir'                       => $request->bir ?? '',
                    'government_issued_id'      => $request->government_issued_id ?? '',
                    'business_structure'        => $request->business_structure ?? '',
                    'school_id'                 => $request->school_id ?? '',
                    'parent_consent'            => $request->parent_consent ?? ''
                ]
            ];

            $page_controller->page = 4;
            $page_controller->data[$page - 1] = $data_array;

            $this->save_reseller ($page_controller);

            return redirect()->route('dashboard');
        }

        else {

            $page_data['page'] = 1;
            $data_array = [];
            $page_data['data'] = [];

            array_push($page_data['data'], $data_array);

            $data = json_encode($page_data);

            Cookie::queue('rgest', $data, 43200);

            $id = 1;

            return redirect('/reseller/registration/step/' . $id);
        }

        $page_data['page'] = 1;
        $data_array = [];
        $page_data['data'] = [];

        array_push($page_data['data'], $data_array);

        $data = json_encode($page_data);

        Cookie::queue('rgest', $data, 43200);

        $id = 1;

        return redirect('/reseller/registratin/step/' . $id);
    }

    /**
     * [save_reseller description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function save_reseller ($data)
    {
        foreach ($data->data as $key => $item) {
            foreach ($item as $keySave => $item_save) {
                $save_data[$keySave] = $item_save;
            }
        }

        if (Auth::check()) {
            $user = Auth::user();

            $ref_code               = substr($user->id . Str::random(), 0, 10);
            $user->name             = $save_data['firstName'] . ' ' . $save_data['lastName'] ?? '';
            $user->email            = $save_data['emailAddress'] ?? '';
            $user->phone            = '+' . $save_data['countryCode'] . $save_data['mobileNumber'] ?? '';
            $user->birthdate        = $save_data['birthdate'] ?? '';
            $user->address          = $save_data['address'] ?? '';
            $user->country          = $save_data['country'] ?? '';
            $user->city             = $save_data['city'] ?? '';
            $user->postal_code      = $save_data['postalCode'] ?? '';
            $user->user_type        = 'reseller';
            $user->referral_code    = $ref_code;

            // Create new affiliate user
            $affiliate_user = new AffiliateUser;

            $affiliate_user->user_id    = $user->id;
            $affiliate_user->status     = 1;
            $affiliate_user->save();

            $employee_id_exists = array_key_exists('employeeIdNo', $save_data);

            if ($employee_id_exists) {
                $ref_by = User::where('employee_id', $save_data['employeeIdNo'])->first()->id;

                $user->referred_by = $ref_by;
                $user->save();
            }

            if ($user->referred_by != null) {
                $employee_reseller = new EmployeeReseller;

                $employee_reseller->employee_id     = $user->referred_by;
                $employee_reseller->reseller_id     = $user->id;
                $employee_reseller->date_of_sign_up = \Carbon\Carbon::now();
                $employee_reseller->date_joined     = \Carbon\Carbon::now();

                $employee_reseller->save();
            }

            if ($user->save()) {
                $newformat = date('d-m-Y', strtotime($save_data['birthdate']));

                $reseller = new Reseller;

                $reseller->user_id                  = $user->id;
                $reseller->telephone_number         = $save_data['phoneNumber'] ?? '';
                $reseller->tin                      = $save_data['tin'] ?? '';
                $reseller->employment_status        = $save_data['employmentStatus'] ?? '';
                $reseller->company_name             = $save_data['companyName'] ?? '';
                $reseller->company_address          = $save_data['companyAddress'] ?? '';
                $reseller->company_contact          = $save_data['companyContact'] ?? '';
                $reseller->business_name            = $save_data['businessName'] ?? '';
                $reseller->business_address         = $save_data['businessAddress'] ?? '';
                $reseller->nature_of_business       = $save_data['natureOfBusiness'] ?? '';
                $reseller->office                   = $save_data['office'] ?? '';
                $reseller->years_in_business        = $save_data['yearsInBusiness'] ?? '';

                if ($reseller->save()) {
                    foreach ($save_data['files'] as $key => $items) {
                        if ($items) {
                            $employment_status_files                = new EmploymentStatusFile;
                            $employment_status_files->reseller_id   = $reseller->id;
                            $employment_status_files->img_type      = $key;
                            $employment_status_files->img           = $items;
                            $employment_status_files->save();
                        }
                    }

                    flash(translate('Successfully registered as reseller!'))->success();
                    return redirect()->route('dashboard');
                }

                else {
                    flash(translate('Something went wrong!'))->error();
                    return redirect()->route('home');
                }
            }
        }
    }

    /**
     * [reseller_viewed description]
     * @return [type] [description]
     */
    public function reseller_viewed()
    {
        $reseller = Reseller::where('user_id', Auth::user()->id)->first();

        $reseller->reseller_perks_viewed = 1;
        $reseller->save();

        return redirect()->back();
    }

    /**
     * Author: Ron-ron Asistores
     *
     * Get reseller's earnings
     */
    public function earnings()
    {
        $earnings = \App\ResellerEarning::where('reseller_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.user.reseller.earnings', compact('earnings'));
    }

    /**
     * Author: Ron-ron Asistores
     */
    public function convert_earnings(Request $request)
    {
        $rules = [
            'amount' => 'required'
        ];

        $message = [
            'amount.required' => 'Please input the amount you want to convert into wallet.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            $error = null;
            $error = $validator->errors()->messages();

            foreach ($error as $key => $item) {
                foreach ($item as $key => $err) {
                    flash (translate($err));
                    break;
                }
                break;
            }
            return redirect()->back();
        }

        else {
            $user = Auth::user();

            if ($user->user_type == 'reseller' && $user->reseller->is_verified == 0) {
                flash (translate("You have to meet the requirements first before converting your earnings into wallet balance!"));
                return redirect()->back();
            }

            if ($request->amount <= $user->affiliate_user->balance) {
                $wallet = new Wallet;

                $wallet->user_id = $user->id;
                $wallet->amount = $request->amount;
                $wallet->payment_method = "Earnings Convert";
                $wallet->payment_details = "Converted earnings to wallet";
                $wallet->type = 'earnings_convert';
                $wallet->request_status = 'approved';

                if ($wallet->save()) {
                    $affiliate_withdraw_request = new AffiliateWithdrawRequest;

                    $affiliate_withdraw_request->user_id    = $user->id;
                    $affiliate_withdraw_request->amount     = $request->amount;
                    $affiliate_withdraw_request->status     = 1;
                    $affiliate_withdraw_request->type       = 'convert_to_wallet';
                    $affiliate_withdraw_request->wallet_id  = $wallet->id;

                    if ($affiliate_withdraw_request->save()) {
                        $affiliate_user = AffiliateUser::where('user_id', $user->id)
                            ->first();

                        $affiliate_user->balance = $affiliate_user->balance - $request->amount;
                        $affiliate_user->save();

                        $user->balance += $request->amount;
                        $user->save();

                        $wallet->affiliate_withdraw_request_id = $affiliate_withdraw_request->id;
                        $wallet->save();

                        flash (translate('Earnings successfully converted to wallet!'))->success();
                        return redirect()->route('wallet.index');
                    }

                    else {
                        flash (translate('Something went wrong!'))->error();
                        return redirect()->back();
                    }
                }

                else {
                    flash (translate('Something went wrong!'))->error();
                    return redirect()->back();
                }

            }

            else {
                flash (translate("You can't convert earnings greater than your balance."))->warning();
                return redirect()->back();
            }
        }
    }

    public function my_customers (Request $request)
    {
        $sort_search = null;

        $customers = DB::table('reseller_customers')
            ->where('reseller_customers.reseller_id', '=', Auth::user()->id)
            ->join('users', 'reseller_customers.customer_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('reseller_customers.id', 'users.avatar', 'users.avatar_original', 'users.name', 'users.email', 'users.phone', 'reseller_customers.total_orders', 'reseller_customers.last_order_date')
            ->distinct();

        if ($request->has('search')) {
            $sort_search = $request->search;
            $customers = $customers->where(function ($query) use ($sort_search) {
                $query->where('users.name', 'like', '%' . $sort_search . '%')
                ->orWhere('users.email', 'like', '%' . $sort_search . '%');
            });
        }

        $customers = $customers->paginate(10);

        return view('frontend.user.reseller.my_customers', compact('customers', 'sort_search'));
    }

    public function my_customer_show($id)
    {
        $customer = ResellerCustomer::where('reseller_id', Auth::user()->id)
            ->where('id', decrypt($id))->first();

        $orders = ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
            ->where('customer_id', $customer->customer_id)
            ->orderBy('created_at', 'desc')
            ->distinct();

        $orders = $orders->paginate(10);

        return view('frontend.user.reseller.my_customer_show', compact('customer', 'orders'));
    }

    /**
     * [customer_orders description]
     * @return [type] [description]
     */
    public function customer_orders()
    {
        $orders = ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->distinct();

        $orders = $orders->paginate(10);

        return view('frontend.user.reseller.customer_orders', compact('orders'));
    }

    /**
     * [custoemr_order_returns description]
     * @return [type] [description]
     */
    public function customer_orders_returns()
    {
        $customers = ResellerCustomer::where('reseller_id', Auth::user()->id)
            ->pluck('customer_id');

        $customers_order = ResellerCustomerOrder::where('reseller_id', Auth::user()->id)
            ->whereIn('customer_id', $customers)
            ->pluck('order_id');

        $orders = RefundRequest::whereIn('order_id', $customers_order)
            ->latest()
            ->paginate(10);

        return view('frontend.user.reseller.customer_orders_returns', compact('orders'));
    }

    /**
     * [show_purchase_history description]
     * @return [type] [description]
     */
    public function show_purchase_history ($id)
    {
        $order = Order::where('id', decrypt($id))->firstOrFail();

        return view('frontend.user.reseller.earnings.order_show', compact('order'));
    }

    /**
     * [verify_reseller description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function verify_reseller ($id)
    {
        $reseller = Reseller::where('user_id', decrypt($id))
            ->first();

        $reseller->is_verified = 1;
        $reseller->verified_at = \Carbon\Carbon::now();
        $reseller->verified_by = Auth::user()->id;

        // check if reseller is employee's reseller
        $employee_reseller = \App\EmployeeReseller::where('reseller_id', $reseller->user_id)
            ->first();

        if ($employee_reseller != null) {
            $employee_reseller->is_verified = 1;
            $employee_reseller->save();
        }

        if ($reseller->save()) {
            flash(translate('Successfully verified reseller!'))->success();
        }

        else {
            flash(translate('Something went wrong'))->error();
        }

        return redirect()->back();
    }
}
