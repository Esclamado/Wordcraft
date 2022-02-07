<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Customer;
use App\BusinessSetting;
use App\OtpConfiguration;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MLM\v1\WebhookController;
use App\Http\Controllers\OTPVerificationController;
use App\UserKey;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Cookie;
use Nexmo;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $message = [
            'email.required' => 'Please input your email.',
            'email.email' => 'Your email must be a valid email address.',
            'phone.required' => 'Please input your phone number.',
            'country_code.required' => 'Please select your country.',
            'fname.required' => 'Please input your first name.',
            'lname.required' => 'Please input your last name.',
            'password.required' => 'Please input your password.',
            'password_confirmation.required' => 'Please input your confirm password.'
        ];

        $rules = [
            'email' => 'required|string|email|unique:users,email|max:70',
            'phone' => 'required|numeric',
            'country_code' => 'required',
            'fname' => 'required|string|max:50',
            'lname' => 'required|string|max:50',
            'password' => 'required|min:8|max:50',
            'password_confirmation' => 'required'
        ];

        if ($data['tin'] != null) {
            $rules = [
                'email' => 'required|string|email|unique:users,email|max:70',
                'phone' => 'required|numeric',
                'country_code' => 'required',
                'fname' => 'required|string|max:50',
                'lname' => 'required|string|max:50',
                'password' => 'required|min:8|max:50',
                'password_confirmation' => 'required',
                'tin' => 'min:12|max:12'
            ];
        }
        if(!array_key_exists('login_type', $data)){
            if ($data['isContact'] == '1') {
                $message['employeeid.required'] = 'Please input employee id.';
                $rules['employeeid'] = 'required';
            }    
        }
        if ($data['isCorporate'] == '1') {
            $message = [
                'email.required' => 'Please input your email.',
                'email.email' => 'Your email must be a valid email address.',
                'phone.required' => 'Please input your phone number.',
                'country_code.required' => 'Please select your country.',
                'fname.required' => 'Please input your first name.',
                'lname.required' => 'Please input your last name.',
                'password.required' => 'Please input your password.',
                'password_confirmation.required' => 'Please input your confirm password.',
                'companyname.required' => 'Please input your company name.',
                'tin1.required' => 'Please input your company tin number.',
                'tin1.min' => 'The company tin number must be at least 12 characters.',
                'tin1.max' => 'The company tin number may not be greater than 12 characters.'
            ];
            $rules = [
                'email' => 'required|string|email|unique:users,email|max:70',
                'phone' => 'required|numeric',
                'country_code' => 'required',
                'fname' => 'required|string|max:50',
                'lname' => 'required|string|max:50',
                'password' => 'required|min:8|max:50',
                'password_confirmation' => 'required',
                'companyname' => 'required',
                'tin1' => 'required|min:12|max:12'
            ];
        }
        return Validator::make($data, $rules, $message);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $referred_by = null;

        if(!array_key_exists('login_type', $data)){
            if ($data['isContact'] == 1) {
                $userRefferedId = User::where('employee_id', '=', $data['employeeid'])->first();
    
                if ($userRefferedId) {
                    $referred_by = $userRefferedId->id;
                }
            }
        }

        // Checking of username if it already exists
        $username = mb_strtolower(str_replace(' ', '.', $data['fname'])) . '.' . mb_strtolower(str_replace(' ', '.', $data['lname']));

        if (User::where('username', $username)->exists()) {
            $username = $username . rand(10, 100);
        }

        $account_type = null;

        // Get Account Type
        if ($data['isCorporate'] != 1) {
            $account_type = 'individual';
        } else {
            $account_type = 'corporate';
        }

        $word = '+' . $data['country_code'];
        $phone_number = str_replace('+' . $data['country_code'], '', str_replace(' ', '', $data['phone']));

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::create([
                'unique_id' => unique_code(9),
                'referred_by' => $referred_by,
                'username' => $username,
                'account_type' => $account_type,
                'company_name' => array_key_exists('companyname', $data) ? $data['companyname'] : null,
                'first_name' => $data['fname'],
                'last_name' => $data['lname'],
                'name' => $data['fname'] . ' ' . $data['lname'],
                'email' => $data['email'],
                'phone' => $word . $phone_number,
                'password' => Hash::make($data['password']),
                'tin_no' => isset($data['tin']) ? $data['tin'] : null
            ]);

            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
        } else {
            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated) {
                $user = User::create([
                    'unique_id' => unique_code(9),
                    'referred_by' => $referred_by,
                    'username' => $this->check_username($username),
                    'first_name' => $data['fname'] ?? null,
                    'last_name' => $data['lname'] ?? null,
                    'name' => $data['name'] ?? $data['fname'] . ' ' . $data['lname'],
                    'phone' =>  $word . $phone_number,
                    'password' => Hash::make($data['password']),
                    'verification_code' => rand(100000, 999999)
                ]);

                $customer = new Customer;
                $customer->user_id = $user->id;
                $customer->save();

                $otpController = new OTPVerificationController;
                $otpController->send_code($user);
            }
        }

        if (Cookie::has('referral_code')) {
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if ($referred_by_user != null) {
                $user->referred_by = $referred_by_user->id;
                $user->save();
            }
        }

        return $user;
    }

    public function register(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email or Phone already exists.'));
                return back();
            }
        }
        if (User::where('phone', '+' . $request->country_code . $request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }
        if ($request->password != $request->password_confirmation) {
            flash(translate("Password didn't matched"));
            return back();
        }

        $this->validator($request->all())->validate();
        if ($request->email == null || $request->email == "") {
            flash(translate("Email address is required!"))->error();
            return back();
        }

        $user = $this->create($request->all());
        $this->guard()->login($user);

        if ($user->email != null) {
            if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                flash(translate('Registration successful.'))->success();
            } else {
                event(new Registered($user));
                flash(translate('Registration successful. Please verify your email.'))->success();
            }
        }

        return $this->registered($request, $user, $request->password)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user, $phrase_to_encrypt)
    {
        // Create API Keys
        $token = Str::random(60);

        UserKey::create([
            'user_id' => $user->id,
            'public_key' => hash('sha256', $token),
            'private_key' => hash('sha256', $token)
        ]);

        $new_user = new WebhookController();
        $new_user->send_webhook_response_new_user($user, $phrase_to_encrypt);

        if ($user->email == null) {
                return redirect()->route('verification');
        } else {
            if($request->login_type == 'walkin'){            
                
                Auth::loginUsingId($user->id);
                
                return redirect()->route('walkin.login');
            }else{
                return redirect()->route('home');
            }
        }
    }

    private function check_username($username)
    {
        $username_exists = User::where('username', $username)
            ->exists();

        if ($username_exists) {
            return $username . '.' . unique_order_number();
        } else {
            return $username;
        }
    }
}
