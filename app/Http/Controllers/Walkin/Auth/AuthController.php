<?php

namespace App\Http\Controllers\Walkin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StoreLocation;
use Cookie;
use Auth;
use DB;
use PickupPoint;
use Illuminate\Support\Facades\Hash;

/* Models */
use App\User;

/* Controllers  */
use App\Http\Controllers\OTPVerificationController;
class AuthController extends Controller
{
    public function index(){
      // if(!$id){
      //   return redirect()->route('walkin.store_selection');
      // }
      // else{
      //   $store = DB::table('store_locations')->where('id', $id)->first();
      //   $storeVar = ['id'=>$store->id];
      //   $storeString = json_encode($storeVar);
        
      //   setcookie("storeCookie", $storeString, time() + (10 * 365 * 24 * 60 * 60),'/');
      //   var_dump(json_decode($storeVar)); die;
      // }
      
      if(!isset($_COOKIE['store_data'])) {
        return redirect()->route('walkin.store_selection');
      }else{
        $storeString = json_decode($_COOKIE['store_data'], true);
      }
      if(Auth::check()){
        $user =  Auth::user();
        if(isset($user->user_type)){
            if($user->user_type == 'staff'){
              return redirect()->route('admin.dashboard');
            }else{
              return redirect()->route('walkin.product');   
            }
        }
      }
      return view('frontend.walkin.auth.login');
    }

    public function register(){
        if(!isset($_COOKIE['store_data'])) {
          return redirect()->route('walkin.store_selection');
        }else{
          $storeString = json_decode($_COOKIE['store_data'], true);
        }
        if(Auth::check()){
            return redirect()->route('walkin.product');
        }
        return view('frontend.walkin.auth.register');
    }

    public function storeSelection(){
      // if(isset($_COOKIE['store_data'])) {
      //   return redirect()->route('walkin.login');
      // }
      $store = DB::table('pickup_points')->get()->toArray();
      return view('frontend.walkin.auth.store_selection',  compact('store'));
    }

    public function locationValidation(Request $request){
      
      $compare_email = $request->compare_email;
      $user = DB::table('users')->where('email', $compare_email)->get()->first();

    
      if($user){
       
        if (Hash::check($request->password, $user->password)) {
          $staff = DB::table('staff')->where('user_id', $user->id)->get()->first();
          if($staff){
            if($staff->role_id == 9){
              $store = \App\PickupPoint::where('name', 'LIKE', '%' . $user->first_name . '%')->first()->toArray();
              // var_dump($store); die;

              $store_string = json_encode($store);
              // var_dump($store_string); 
              setcookie("store_data", $store_string, time() + (10 * 365 * 24 * 60 * 60),'/');
              flash(translate('Successfully setup the Location!'))->success();
              return redirect()->route('walkin.login');
            }
          }
        }
      }
   
      
      flash (translate("Please check your email & password!"))->error();
      return redirect()->back();

      

      // $staff_ids = $request->store_id ? json_decode($request->store_id, true)['staff_id'] : null;
      // if($staff_ids){
      //   if($compare_staff_id){
      //     if(strpos($staff_ids, $compare_staff_id) !== false){
      //       return redirect()->route('walkin.login');
      //     }else{
      //       flash (translate("Please Check Your Staff ID!"))->error();
      //       return redirect()->back();
      //     }
      //   }else{
      //     flash (translate("Please Input Staff ID!"))->error();
      //   return redirect()->back();
      //   }
      // }else{
      //   flash (translate("Please Select Location Store!"))->error();
      //   return redirect()->back();
      // }
    }
}
