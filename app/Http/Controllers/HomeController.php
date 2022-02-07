<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use Hash;
use App\Category;
use App\FlashDeal;
use App\Brand;
use App\Product;
use App\ProductStock;
use App\PickupPoint;
use App\CustomerPackage;
use App\CustomerProduct;
use App\User;
use App\Reseller;
use App\EmploymentStatusFile;
use App\Seller;
use App\Shop;
use App\Color;
use App\Order;
use App\BusinessSetting;
use App\Http\Controllers\SearchController;
use ImageOptimizer;
use Cookie;
use Illuminate\Support\Str;
use App\Mail\SecondEmailVerifyMailManager;
use Mail;
use App\Utility\TranslationUtility;
use App\Utility\CategoryUtility;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\MatchOldPassword;
use App\WorldcraftStock;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function login()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('frontend.user_login');
    }

    public function check_auth()
    {
        if (Auth::check()) {
            return 1;
        }

        else {
            return 2;
        }
    }

    public function registration(Request $request)
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        if ($request->has('referral_code')) {
            Cookie::queue('referral_code', $request->referral_code, 43200);
        } else {
            Cookie::queue(Cookie::forget('referral_code'));
        }
        return view('frontend.user_registration');
    }

    public function load_contact_us(){
        return view('frontend.contact_us');
    }

    public function load_about_us(){
        return view('frontend.about_us');
    }

    public function load_faq(){
        return view('frontend.faq');
    }

    public function cart_login(Request $request)
    {
        $user = User::whereIn('user_type', ['customer', 'reseller', 'employee'])
            ->where('email', $request->email)
            ->orWhere('phone', $request->email)
            ->orWhere('username', $request->email)
            ->first();

        if($user != null){
            if(Hash::check($request->password, $user->password)){
                if($request->has('remember')){
                    auth()->login($user, true);
                }
                else{
                    auth()->login($user, false);
                }
                flash(translate("You are now logged in"))->success();
            }
            else {
                flash(translate('Invalid email or password!'))->warning();
            }
        }
        return back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard()
    {   
        if(!isset($_COOKIE['store_data'])) {
            $user =  Auth::user();
            if(isset($user->user_type)){
                if($user->user_type == 'staff'){
                    return redirect()->route('walkin.store_selection');
                }
            }
        }
        
        return view('backend.dashboard');
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::user()->user_type == 'seller'){
            return view('frontend.user.seller.dashboard');
        }
        elseif(Auth::user()->user_type == 'customer'){
            $orders = Order::where('user_id', Auth::user()->id)->orderBy('code', 'desc')->paginate(9);
            return view('frontend.user.customer.dashboard',compact('orders'));
        }
        elseif(Auth::user()->user_type == 'employee'){
            return view('frontend.user.employee.dashboard');
        }
        elseif(Auth::user()->user_type == 'reseller'){
            return view('frontend.user.reseller.dashboard');
        }
        else {
            abort(404);
        }
    }

    public function profile(Request $request)
    {
        return view('frontend.user.customer.profile');
    }


    /**
     * [validate_customer description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    private function validate_customer($request) : void {
        $message = [
            'fname.required' => 'Please input your first name.',
            'lname.required' => 'Please input your last name.',
        ];

        $this->validate($request, [
            'fname' => 'required|max:70',
            'lname' => 'required|max:70',
            'mobile' => 'required|min:11',
            'username' => 'required|max:20|unique:users,username,' . Auth::user()->id,
        ], $message);
    }

    private function validate_reseller($data) {
        $message = [
            'fname.required' => 'Please input your first name.',
            'lname.required' => 'Please input your last name.',
            'country.required' => 'Please select your mobile number.',
            'countryCode.required' => 'Please select your mobile number.',
            'mobile.required' => 'Please input your mobile number.',
            'reselleraddress.required' => 'Please input your address.',
            'city.required' => 'Please input your city.',
            'birthday.required' => 'Please input your birthday.',
            'employmentStatus.required' => 'Please select employment status.'
        ];

        $rules = [
            'fname' => 'required',
            'lname' => 'required',
            'country' => 'required',
            'countryCode' => 'required',
            'mobile' => 'required|min:11',
            'reselleraddress' => 'required',
            'city' => 'required',
            'birthday' => 'required',
            'employmentStatus' => 'required',
            'username' => 'required|max:20|unique:users,username,' . Auth::user()->id
        ];

        if ( $data['employmentStatus'] == 'Others') {

            $message['oth_governmentId.required'] = 'Please attach government id.';

            $rules['oth_governmentId'] = 'required';

        }else if( $data['employmentStatus'] == 'Employed' ){

            $message['companyName.required'] = 'Please input company name.';
            $message['companyContactNo.required'] = 'Please input company contact number.';
            $message['companyAddress.required'] = 'Please input company address.';
            $message['companyId.required'] = 'Please attach company id.';
            $message['emp_governmentId.required'] = 'Please attach government id.';

            $rules['companyName'] = 'required';
            $rules['companyContactNo'] = 'required';
            $rules['companyAddress'] = 'required';
            $rules['companyId'] = 'required';
            $rules['emp_governmentId'] = 'required';

        }else if( $data['employmentStatus'] == 'Business' ){

            $message['businessName.required'] = 'Please input business name.';
            $message['businessAddress.required'] = 'Please input business address.';
            $message['natureOfBusiness.required'] = 'Please input nature of business.';
            $message['office.required'] = 'Please input office or shop.';
            $message['yearsInBusiness.required'] = 'Please input years in business.';
            $message['mayorsBusinessPermit.required'] = 'Please attach mayor’s business permit.';
            $message['dti.required'] = 'Please attach DTI/SEC certificate of registration.';
            $message['bir.required'] = 'Please attach BIR certificate of registrations.';
            $message['bus_governmentId.required'] = 'Please attach government-issued ID.';
            $message['businessStructure.required'] = 'Please attach business structure of the owned company.';

            $rules['businessName'] = 'required';
            $rules['businessAddress'] = 'required';
            $rules['natureOfBusiness'] = 'required';
            $rules['office'] = 'required';
            $rules['yearsInBusiness'] = 'required';
            $rules['mayorsBusinessPermit'] = 'required';
            $rules['dti'] = 'required';
            $rules['bir'] = 'required';
            $rules['bus_governmentId'] = 'required';
            $rules['businessStructure'] = 'required';

        }else if( $data['employmentStatus'] == 'Freelancer' ){

            $message['oth_governmentId.required'] = 'Please attach government id.';

            $rules['oth_governmentId'] = 'required';

        }else if( $data['employmentStatus'] == 'Housewife' ){

            $message['oth_governmentId.required'] = 'Please attach government id.';

            $rules['oth_governmentId'] = 'required';

        }else if( $data['employmentStatus'] == 'Student' ){

            $message['schoolId.required'] = 'Please attach school id.';
            $message['parentConsent.required'] = 'Please attach parent consent id.';

            $rules['schoolId'] = 'required';
            $rules['parentConsent'] = 'required';

        }

        return Validator::make($data, $rules, $message);
    }

    private function validate_password($request) : void {
        $message = [
            'current_password.required' => 'Please input your current password',
            'new_password.required' => 'Please input your new password',
        ];

        $this->validate($request, [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:8|max:70',
            'confirm_password' => 'required|same:new_password'
        ], $message);
    }

    /**
     * [customer_update_profile description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function customer_update_profile(Request $request)
    {
        $user_type = Auth::user()->user_type;

        $user = Auth::user();

        if ($user_type == 'employee') {
            $this->validate_customer($request);
        }

        else if ($user_type == 'customer') {
            $this->validate_customer($request);
        }

        else if($user_type == 'reseller'){
            if($request->employmentStatus != null){
                $this->validate_reseller($request->all())->validate();
            }
        }

        if ($user_type == 'reseller') {
            $this->validate_reseller($request->all())->validate();

            $reseller = Reseller::where('user_id', $user->id)
                ->first();

            $birthday = date('Y-m-d', strtotime($request->birthday));

            $reseller->telephone_number     = $request->phone ?? null;
            $reseller->employment_status    = $request->employmentStatus ?? null;
            $reseller->company_name         = $request->companyName ?? null;
            $reseller->company_contact      = $request->companyContactNo ?? null;
            $reseller->company_address      = $request->companyAddress ?? null;
            $reseller->business_name        = $request->businessName ?? null;
            $reseller->business_address     = $request->businessAddress ?? null;
            $reseller->office               = $request->office ?? null;
            $reseller->years_in_business    = $request->yearsInBusiness ?? null;
            $user->birthdate                = $birthday;
            
            $reseller_saved = false;

            if ($reseller->save()) {
                $reseller_saved = true;

                if ($request->employmentStatus == 'Others') {
                    $request->governmentId = $request->oth_governmentId;
                }

                else if ($request->employmentStatus == 'Employed') {
                    $request->governmentId = $request->emp_governmentId;
                }

                else if ($request->employmentStatus == 'Business') {
                    $request->governmentId = $request->bus_governmentId;
                }

                else if ($request->employmentStatus == 'Freelancer') {
                    $request->governmentId = $request->fre_governmentId;
                }

                else if ($request->employmentStatus == 'Housewife') {
                    $request->governmentId = $request->hou_governmentId;
                }

                else {
                    $request->governmentId = '';
                }

                $files = [
                    'companyId'             => $request->companyId ?? null,
                    'governmentId'          => $request->governmentId ?? null,
                    'mayorsBusinessPermit'  => $request->mayorsBusinessPermit ?? null,
                    'dti'                   => $request->dti ?? null,
                    'bir'                   => $request->dti ?? null,
                    'governmentIssuedId'    => $request->governmentIssuedId ?? null,
                    'businessStructure'     => $request->businessStructure ?? null,
                    'schoolId'              => $request->schoolId ?? null,
                    'parentConsent'         => $request->parentConsent ?? null,
                ];

                foreach($files as $key => $items){
                    if ($items) {
                        if(EmploymentStatusFile::where('reseller_id','=',$reseller->id)->where('img_type','=',$key)->first()){
                            $employment_status_files = EmploymentStatusFile::where('reseller_id','=',$reseller->id)->where('img_type','=',$key)->first();
                        }

                        else {
                            $employment_status_files = New EmploymentStatusFile;
                            $employment_status_files->reseller_id = $reseller->id;
                            $employment_status_files->img_type = $key;
                        }

                        $employment_status_files->img = $items;
                        $employment_status_files->save();
                    }
                }
            }
        }

        // Global User Inputs
        $user->display_name     = $request->display_name;
        $user->name             = $request->fname . ' ' . $request->lname;
        $user->first_name       = $request->fname;
        $user->last_name        = $request->lname;
        $user->username         = $request->username;
        $user->phone            = '+' . $request->countryCode . $request->mobile;
        $user->avatar_original  = $request->photo;
        

        if ($request->current_password != null || $request->new_password != null || $request->confirm_password != null) {
            $this->validate_password($request);

            // Update password
            $verify = password_verify($request->confirm_password, $user->password);

            if ($verify) {
                flash(translate('Cannot save current password!'))->error();
            }

            else {
                $user->password = Hash::make($request->new_password);
                $user->save();

                flash(translate('Your password is successfully updated!'))->success();
            }

            return redirect()->back();
        }

        if ($user_type == 'customer') {
            if ($user->save()) {
                flash(translate('Your profile has been updated successfully!'))->success();
                return redirect()->back();
            }
        }

        else if ($user_type == 'employee') {
            if ($user->save()) {
                flash(translate('Your profile has been updated successfully!'))->success();
                return redirect()->back();
            }
        }

        else if ($user_type == 'reseller') {
            $user->save();
            if ($reseller_saved) {
                flash (translate('Your profile has been updated successfully'))->success();
                return redirect()->back();
            }
        }
    }

    public function seller_update_profile(Request $request)
    {
        if(env('DEMO_MODE') == 'On'){
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $request->photo;

        $seller = $user->seller;
        $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
        $seller->bank_payment_status = $request->bank_payment_status;
        $seller->bank_name = $request->bank_name;
        $seller->bank_acc_name = $request->bank_acc_name;
        $seller->bank_acc_no = $request->bank_acc_no;
        $seller->bank_routing_no = $request->bank_routing_no;

        if($user->save() && $seller->save()){
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.index');
    }

    public function flash_deal_details($slug)
    {
        $flash_deal = FlashDeal::where('slug', $slug)->first();
        if($flash_deal != null)
            return view('frontend.flash_deal_details', compact('flash_deal'));
        else {
            abort(404);
        }
    }

    public function load_featured_section(){
        return view('frontend.partials.featured_products_section');
    }

    public function load_best_selling_section(){
        return view('frontend.partials.best_selling_section');
    }

    public function load_home_categories_section(){
        return view('frontend.partials.home_categories_section');
    }

    public function load_best_sellers_section(){
        return view('frontend.partials.best_sellers_section');
    }

    public function trackOrder(Request $request)
    {
        if ($request->has('order_code')) {
            if (Auth::check()) {
                $order = Order::where('user_id', Auth::user()->id)
                    ->where('code', $request->order_code)->first();

                if ($order != null) {
                    return view('frontend.track_order', compact('order'));
                }

                else {
                    flash(translate("We cannot find the order from the code you entered"));
                    return redirect()->back();
                }
            }

            else {
                flash(translate("Please login to track your order"));
                return redirect()->back();
            }
        }
        
        return view('frontend.track_order');
    }

    public function product(Request $request, $slug)
    {
        $order_id = $request->order_id;
        $detailedProduct  = Product::where('slug', $slug)->first();

        if($detailedProduct != null && $detailedProduct->published) {
            if ($request->has('product_referral_code')) {
                $user = User::where('referral_code', $request->product_referral_code)
                    ->first();

                if ($user != null) {
                    if ($user->banned != 1) {
                        Cookie::queue('product_referral_code', $request->product_referral_code, 43200);
                        Cookie::queue('referred_product_id', $detailedProduct->id, 43200);
                    }

                    else {
                        Cookie::queue(Cookie::forget('product_referral_code'));
                        Cookie::queue(Cookie::forget('referred_product_id'));
                    }
                }
            }

            else {
                Cookie::queue(Cookie::forget('product_referral_code'));
                Cookie::queue(Cookie::forget('referred_product_id'));
            }
            $route = Route::currentRouteName();
        
            if(strpos($route, 'walkin') !== false){
                return view('frontend.walkin.product.details', compact('detailedProduct', 'order_id'));
            }else{
                return view('frontend.product_details', compact('detailedProduct'));
            }
        }

        abort(404);
    }

    public function shop($slug)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null){
            $seller = Seller::where('user_id', $shop->user_id)->first();
            if ($seller->verification_status != 0){
                return view('frontend.seller_shop', compact('shop'));
            }
            else{
                return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
            }
        }
        abort(404);
    }

    public function filter_shop($slug, $type)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null && $type != null){
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        abort(404);
    }

    public function all_categories(Request $request)
    {
        $categories = Category::where('level', 0)->orderBy('name', 'asc')->get();
        return view('frontend.all_category', compact('categories'));
    }
    public function all_brands(Request $request)
    {
        $categories = Category::all();
        return view('frontend.all_brand', compact('categories'));
    }

    public function show_product_upload_form(Request $request)
    {
        if(\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated){
            if(Auth::user()->seller->remaining_uploads > 0){
                $categories = Category::where('parent_id', 0)
                    ->where('digital', 0)
                    ->with('childrenCategories')
                    ->get();
                return view('frontend.user.seller.product_upload', compact('categories'));
            }
            else {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.user.seller.product_upload', compact('categories'));
    }

    public function show_product_edit_form(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.user.seller.product_edit', compact('product', 'categories', 'tags', 'lang'));
    }

    public function seller_product_list(Request $request)
    {
        $search = null;
        $products = Product::where('user_id', Auth::user()->id)->where('digital', 0)->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $products = $products->where('name', 'like', '%'.$search.'%');
        }
        $products = $products->paginate(10);
        return view('frontend.user.seller.products', compact('products', 'search'));
    }

    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('published', 1)->where('tags', 'like', '%'.$request->search.'%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $request->search) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }           
                    }
                }
            }
        }

        $products = filter_products(Product::where('published', 1)->where('name', 'like', '%'.$request->search.'%'))->get()->take(3);

        $categories = Category::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        $shops = Shop::whereIn('user_id', verified_sellers_id())->where('name', 'like', '%'.$request->search.'%')->get()->take(3);
        $orderId = $request->searchOrderId ?  $request->searchOrderId : null;
        $location = $request->pickupLocation ?  $request->pickupLocation : null;
        
        if(sizeof($keywords)>0 || sizeof($categories)>0 || sizeof($products)>0 || sizeof($shops) >0){
            return view('frontend.partials.search_content', compact('products', 'categories', 'keywords', 'shops', 'orderId', 'location'));
        }
        return '0';
    }

    public function listing(Request $request)
    {
        return $this->search($request);
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $order_id = $request->order_id;
        $category = Category::where('slug', $category_slug)->first();
        if ($category != null) {
            return $this->search($request, $category->id, null, $order_id);
        }
        abort(404);
    }

    public function listingByBrand(Request $request, $brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->first();
        if ($brand != null) {
            return $this->search($request, null, $brand->id);
        }
        abort(404);
    }

    public function search(Request $request, $category_id = null, $brand_id = null, $order_id = null)
    {
        if(!$order_id){
            $order_id = $request->order_id;
        }
        $query = $request->q;
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;

        $conditions = ['published' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        if($seller_id != null){
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = Product::where($conditions);

        if($category_id != null){
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products = $products->whereIn('category_id', $category_ids);
        }

        if($min_price != null && $max_price != null){
            $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        if($query != null){
            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name', 'like', '%'.$query.'%')->orWhere('tags', 'like', '%'.$query.'%');
        }

        if($sort_by != null){
            switch ($sort_by) {
                case 'newest':
                    $products->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $products->orderBy('created_at', 'asc');
                    break;
                case 'price-asc':
                    $products->orderByRaw("unit_price + tax asc");
                    break;
                case 'price-desc':
                    $products->orderByRaw("unit_price + tax desc");
                    break;
                default:
                    // code...
                    break;
            }
        }


        $non_paginate_products = filter_products($products)->get();

        //Attribute Filter

        $attributes = array();
        foreach ($non_paginate_products as $key => $product) {
            if($product->attributes != null && is_array(json_decode($product->attributes))){
                foreach (json_decode($product->attributes) as $key => $value) {
                    $flag = false;
                    $pos = 0;
                    foreach ($attributes as $key => $attribute) {
                        if($attribute['id'] == $value){
                            $flag = true;
                            $pos = $key;
                            break;
                        }
                    }
                    if(!$flag){
                        $item['id'] = $value;
                        $item['values'] = array();
                        foreach (json_decode($product->choice_options) as $key => $choice_option) {
                            if($choice_option->attribute_id == $value){
                                $item['values'] = $choice_option->values;
                                break;
                            }
                        }
                        array_push($attributes, $item);
                    }
                    else {
                        foreach (json_decode($product->choice_options) as $key => $choice_option) {
                            if($choice_option->attribute_id == $value){
                                foreach ($choice_option->values as $key => $value) {
                                    if(!in_array($value, $attributes[$pos]['values'])){
                                        array_push($attributes[$pos]['values'], $value);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $selected_attributes = array();

        foreach ($attributes as $key => $attribute) {
            if($request->has('attribute_'.$attribute['id'])){
                foreach ($request['attribute_'.$attribute['id']] as $key => $value) {
                    $str = '"'.$value.'"';
                    $products = $products->where('choice_options', 'like', '%'.$str.'%');
                }

                $item['id'] = $attribute['id'];
                $item['values'] = $request['attribute_'.$attribute['id']];
                array_push($selected_attributes, $item);
            }
        }


        //Color Filter
        $all_colors = array();

        foreach ($non_paginate_products as $key => $product) {
            if ($product->colors != null) {
                foreach (json_decode($product->colors) as $key => $color) {
                    if(!in_array($color, $all_colors)){
                        array_push($all_colors, $color);
                    }
                }
            }
        }

        $selected_color = null;

        if($request->has('color')){
            $str = '"'.$request->color.'"';
            $products = $products->where('colors', 'like', '%'.$str.'%');

            $selected_color = $request->color;
        }


        // $products = filter_products($products)->paginate(20)->appends(request()->query());
        $route = Route::currentRouteName();

        // $route == 'walkin.product'
        if(strpos($route, 'walkin') !== false ){
            if(isset($_COOKIE['store_data'])) {
                $storeString = json_decode($_COOKIE['store_data'], true);
                $pup_location_id = $storeString['id'];
                $worldcraft_stocks = WorldcraftStock::where('pup_location_id', $pup_location_id)->pluck('sku_id')->toArray();
                $product_stocks = ProductStock::whereIn('sku', $worldcraft_stocks)->pluck('product_id')->toArray();
                $products = $products->whereIn('id', $product_stocks);
            }
            
            $products = filter_products($products)->paginate(20)->appends(request()->query());
         
            return view('frontend.walkin.product.listing', compact('products', 'query', 'category_id', 'brand_id', 'sort_by', 'seller_id','min_price', 'max_price', 'attributes', 'selected_attributes', 'all_colors', 'selected_color', 'order_id'));
        
        }else{
            $products = filter_products($products)->paginate(20)->appends(request()->query());
            return view('frontend.product_listing', compact('products', 'query', 'category_id', 'brand_id', 'sort_by', 'seller_id','min_price', 'max_price', 'attributes', 'selected_attributes', 'all_colors', 'selected_color'));
        }

    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function top_10_settings(Request $request)
    {
        foreach (Category::all() as $key => $category) {
            if(is_array($request->top_categories) && in_array($category->id, $request->top_categories)){
                $category->top = 1;
                $category->save();
            }
            else{
                $category->top = 0;
                $category->save();
            }
        }

        foreach (Brand::all() as $key => $brand) {
            if(is_array($request->top_brands) && in_array($brand->id, $request->top_brands)){
                $brand->top = 1;
                $brand->save();
            }
            else{
                $brand->top = 0;
                $brand->save();
            }
        }

        flash(translate('Top 10 categories and brands have been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }
    public function getEmployee(Request $request){
        $employee = User::where('employee_id','=',$request->employee_id)->first();

        return $employee != null ? $employee : "no_data";
    }
    public function testGetStock(Request $request){
        $stocklist = [
            'list' => [
                [
                    'id' => 1,
                    'store' => 'Cavite',
                    'stock' => 0,
                    'handling_fee' => "1.00"
                ],
                [
                    'id' => 2,
                    'store' => 'Manila',
                    'stock' => 40,
                    'handling_fee' => "1.00"
                ]
            ],
            'sku' => $request->sku,
        ];
        return  $stocklist;
    }
    public function variantSku(Request $request){
        $product_stock = ProductStock::where('product_id','=', $request->id)
            ->where('variant', '=', str_replace(' ', '', $request->variant))
            ->where('qty', '>=', 0)
            ->first();

        return $product_stock;
    }
    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;

        if($request->has('color')){
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        if(json_decode(Product::find($request->id)->choice_options) != null){
            foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
                else{
                    $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
            }
        }

        $product_stock = ProductStock::where('product_id','=', $product->id)
            ->where('variant', '=', $str)
            ->first();

        if ($product_stock != null) {
            $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $product_stock->sku)
                ->where('pup_location_id', $request->pup_location_id)
                ->first();
                // var_dump($product_stock->sku); 
        }

        else {
            // var_dump('111sasasas'); die;
            $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $product->sku)
                ->where('pup_location_id', $request->pup_location_id)
                ->first();  
        }

        $base_price = 0;
        
        if($str != null && $product->variant_product){
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;
            $base_price = $price;
            $quantity = $worldcraft_stock != null ? $worldcraft_stock->quantity : 0;
        }
        else {
            $price = $product->unit_price;
            $base_price = $price;
            $quantity = $worldcraft_stock != null ? $worldcraft_stock->quantity : 0;
        }

        $inFlashDeal = false;

        if (Auth::check()) {
            if (Auth::user()->user_type == 'reseller' || Auth::user()->user_type == 'employee') {
                if($product->discount_type == 'percent'){
                    if(Auth::user()->user_type == 'reseller'){
                        $price -= ($price*$product->reseller_discount)/100;
                    }elseif(Auth::user()->user_type == 'employee'){
                        $price -= ($price*$product->employee_discount)/100;
                    }
                }elseif($product->discount_type == 'amount'){
                    if(Auth::user()->user_type == 'reseller'){
                        $price -= $product->reseller_discount;
                    }elseif(Auth::user()->user_type == 'employee'){
                        $price -= $product->employee_discount;
                    }
                }
            }
            else {
                //discount calculation
                $flash_deals = \App\FlashDeal::where('status', 1)->get();
                $inFlashDeal = false;

                foreach ($flash_deals as $key => $flash_deal) {
                    if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                        $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                        if($flash_deal_product->discount_type == 'percent'){
                            $price -= ($price*$flash_deal_product->discount)/100;
                        }
                        elseif($flash_deal_product->discount_type == 'amount'){
                            $price -= $flash_deal_product->discount;
                        }
                        $inFlashDeal = true;
                        break;
                    }
                }

                if (!$inFlashDeal) {
                    if($product->discount_type == 'percent'){
                        $price -= ($price*$product->discount)/100;
                    }
                    elseif($product->discount_type == 'amount'){
                        $price -= $product->discount;
                    }
                }
            }
        }

        else {
            //discount calculation
            $flash_deals = \App\FlashDeal::where('status', 1)->get();
            $inFlashDeal = false;

            foreach ($flash_deals as $key => $flash_deal) {
                if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                    $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                    if($flash_deal_product->discount_type == 'percent'){
                        $price -= ($price*$flash_deal_product->discount)/100;
                    }
                    elseif($flash_deal_product->discount_type == 'amount'){
                        $price -= $flash_deal_product->discount;
                    }
                    $inFlashDeal = true;
                    break;
                }
            }

            if (!$inFlashDeal) {
                if($product->discount_type == 'percent'){
                    $price -= ($price*$product->discount)/100;
                }
                elseif($product->discount_type == 'amount'){
                    $price -= $product->discount;
                }
            }
        }

        if($product->tax_type == 'percent'){
            $price += ($price*$product->tax)/100;
        }

        elseif($product->tax_type == 'amount'){
            $price += $product->tax;
        }

        return array('price' => single_price($price * $request->quantity), 'quantity' => $quantity, 'pup_location_id' => $request->pup_location_id, 'digital' => $product->digital, 'variation' => $str, 'sku' => $product_stock->sku ?? null, 'base_price' => format_price($base_price) ?? '0.00');
    }

    public function sellerpolicy(){
        return view("frontend.policies.sellerpolicy");
    }

    public function returnpolicy(){
        return view("frontend.policies.returnpolicy");
    }

    public function supportpolicy(){
        return view("frontend.policies.supportpolicy");
    }

    public function terms(){
        return view("frontend.policies.terms");
    }

    public function privacypolicy(){
        return view("frontend.policies.privacypolicy");
    }

    public function get_pick_ip_points(Request $request)
    {
        $pick_up_points = PickupPoint::all();
        return view('frontend.partials.pick_up_points', compact('pick_up_points'));
    }

    public function get_category_items(Request $request){
        $category = Category::findOrFail($request->id);
        return view('frontend.partials.category_elements', compact('category'));
    }

    public function premium_package_index()
    {
        $customer_packages = CustomerPackage::all();
        return view('frontend.user.customer_packages_lists', compact('customer_packages'));
    }

    public function seller_digital_product_list(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)->where('digital', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.seller.digitalproducts.products', compact('products'));
    }
    public function show_digital_product_upload_form(Request $request)
    {
        if(\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated){
            if(Auth::user()->seller->remaining_digital_uploads > 0){
                $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
                $categories = Category::where('digital', 1)->get();
                return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
            }
            else {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }

        $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
        $categories = Category::where('digital', 1)->get();
        return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
    }

    public function show_digital_product_edit_form(Request $request, $id)
    {
        $categories = Category::where('digital', 1)->get();
        $lang = $request->lang;
        $product = Product::find($id);
        return view('frontend.user.seller.digitalproducts.product_edit', compact('categories', 'product', 'lang'));
    }

    // Ajax call
    public function new_verify(Request $request)
    {
        $email = $request->email;
        if(isUnique($email) == '0') {
            $response['status'] = 2;
            $response['message'] = 'Email already exists!';
            return json_encode($response);
        }

        $response = $this->send_email_change_verification_mail($request, $email);
        return json_encode($response);
    }


    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if(isUnique($email)) {
            $this->send_email_change_verification_mail($request, $email);
            flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            return back();
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

    public function send_email_change_verification_mail($request, $email)
    {
        $response['status'] = 0;
        $response['message'] = 'Unknown';

        $verification_code = Str::random(32);

        $array['subject'] = 'Email Verification';
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = 'Verify your account';
        $array['link'] = route('email_change.callback').'?new_email_verificiation_code='.$verification_code.'&email='.$email;
        $array['sender'] = Auth::user()->name;
        $array['details'] = "Email Second";

        $user = Auth::user();
        $user->new_email_verificiation_code = $verification_code;
        $user->save();

        try {
            Mail::to($email)->queue(new SecondEmailVerifyMailManager($array));

            $response['status'] = 1;
            $response['message'] = translate("Your verification mail has been Sent to your email.");

        } catch (\Exception $e) {
            // return $e->getMessage();
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function email_change_callback(Request $request){
        if($request->has('new_email_verificiation_code') && $request->has('email')) {
            $verification_code_of_url_param =  $request->input('new_email_verificiation_code');
            $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

            if($user != null) {

                $user->email = $request->input('email');
                $user->new_email_verificiation_code = null;
                $user->save();

                auth()->login($user, true);

                flash(translate('Email Changed successfully'))->success();
                return redirect()->route('dashboard');
            }
        }

        flash(translate('Email was not verified. Please resend your mail!'))->error();
        return redirect()->route('dashboard');

    }

    public function reset_password_with_code(Request $request){
        if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
            if (Hash::check($request->password, $user->password) == true) {
                flash(translate("You can't use your previous password!"))->error();
                return redirect()->route('user.login');
            }

            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();

                event(new PasswordReset($user));
                auth()->login($user, true);

                flash(translate('Password updated successfully'))->success();

                if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')
                {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            }
            else {
                flash("Password and confirm password didn't match")->warning();
                return back();
            }
        }
        else {
            flash("Verification code mismatch")->error();
            return back();
        }
    }

    public function store_locations () {
        return view('frontend.store_locations');
    }

    public function get_cities (Request $request) {
        $cities = \DB::table('refcitymun')
            ->orderBy('citymunDesc', 'asc')
            ->where('provCode', $request->province_code)
            ->get(['citymunDesc']);

        return $cities;
    }
}
