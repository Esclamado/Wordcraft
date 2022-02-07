<?php

namespace App\Http\Controllers\Walkin\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Http\Controllers\OTPVerificationController;
use Auth;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        if($request->login_type == "employee"){

            $request->validate([    
                'unique_id' => 'required',
            ]);

            $user = User::where('unique_id', '=', $request->unique_id)->first();

            if($user){
                if($user->user_type == 'reseller' || $user->user_type == 'employee'){
    
                    $id = $this->sendCode($user);
    
                    return redirect()->route('walkin.verification', encrypt($id));
                }else{
                    flash(translate("Invalid Employee/Reseller ID."))->error();
                    return redirect()->back();
                }
            }else{
                flash(translate("Invalid Employee/Reseller ID."))->error();
                return redirect()->back();
            }

        }else if($request->email || $request->phone){
            if($request->email){
                $user = User::where('email', '=', $request->email)->first();
            }else{
                $user = User::where('phone', '+' . $request->country_code . $request->phone)->first();
            }
            if($user){
                if($user->user_type == 'customer'){
                    $id = $this->sendCode($user);
                    return redirect()->route('walkin.verification', encrypt($id));
                }else{
                    flash(translate("Invalid Email Address/Phone Number"))->error();
                    return redirect()->back();
                }
            }else{
                flash(translate("Invalid Email Address/Phone Number"))->error();
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function sendCode($user){
        $user = User::findOrFail($user->id);

        $user->temporary_code = rand(100000, 999999);

        if ($user->save()) {
            $otp_code = new OTPVerificationController;
            $otp_code->send_login_code($user);

            return $user->id;
        }
    }

   
}
