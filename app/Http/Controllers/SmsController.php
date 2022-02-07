<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nexmo;
use Twilio\Rest\Client;
use App\OtpConfiguration;
use App\User;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$users = User::all();
        return view('otp_systems.sms.index',compact('users'));
    }

    //send message to multiple users
    public function send(Request $request)
    {
        $bulk_sms = true;

        if (OtpConfiguration::where('type', 'bulkgate_sms')->first()->value == 1) {

            $phone = '';

            foreach ($request->user_phones as $key => $phoneNumbers) {
                $phone .= $phoneNumbers . ';';
            }

            sendSMS($phone, env('APP_NAME'), $request->content, $bulk_sms);
        }

        else {
            foreach ($request->user_phones as $key => $phone) {
                sendSMS($phone, env('APP_NAME'), $request->content);
            }
        }

    	flash(translate('SMS has been sent.'))->success();
    	return redirect()->route('admin.dashboard');
    }
}
