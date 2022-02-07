<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

// Stocks
use App\WorldcraftStock;
use App\WorldcraftUpdateStock;

// Product Stocks
use App\ProductStock;
use Combinations;
use Illuminate\Support\Str;

use App\PickupPoint;

//walkin
use Illuminate\Support\Facades\Route;
class WorldcraftApiController extends Controller
{
    /**
     * Get list of stocks
     */
    public function list_of_stocks()
    {
        return response()->json();
    }

    /**
     * [add_stocks description]
     * @param Request $request [description]
     */
    public function add_stocks(Request $request)
    {
        $header = $request->header('Authorization');
        $decoded = base64_decode(str_replace('Basic', '', $header));
        list($username, $password) = explode(":", $decoded);

        if ($username == env('WORLDCRAFT_BASIC_USERNAME') && $password == env('WORLDCRAFT_BASIC_PASSWORD')) {
            foreach ($request->all() as $key => $value) {
                $validate = Validator::make($value, [
                    'sku_id' => 'required',
                    'pup_location_id' => 'required',
                    'quantity' => 'required'
                ], [
                    'sku_id.required' => "The SKU ID is required!",
                    'pup_location_id.required' => "The pickup point location ID is required!",
                    'quantity.required' => "The stocks field is required!",
                ]);

                if ($validate->fails()) {
                    $errors = null;
                    $errors = $validate->errors()->messages();

                    $response = [
                        'response_code' => 'R422',
                        'response_message' => 'Request failed, incomplete parameters. Please refer to errors to know what are the parameters missing.',
                        'errors' => $errors
                    ];
                } else {
                    $pickup_point = PickupPoint::where('id', $value['pup_location_id'])->exists();
                    $worldcraft_stock = WorldCraftStock::where('sku_id', $value['sku_id'])
                        ->where('pup_location_id', $value['pup_location_id'])
                        ->exists();

                    if ($worldcraft_stock) {
                        $response = [
                            'response_code' => 'R022',
                            'response_message' => "Stock with SKU ID: " . $value['sku_id'] . " already exists on pickup location ID: " . $value['pup_location_id']
                        ];
                    } else {
                        if ($pickup_point != false) {
                            try {
                                $worldcraft_stock_new = new WorldCraftStock;

                                $worldcraft_stock_new->sku_id = Str::slug($value['sku_id'], '-');
                                $worldcraft_stock_new->pup_location_id = $value['pup_location_id'];
                                $worldcraft_stock_new->quantity = $value['quantity'];

                                $worldcraft_stock_new->save();
                            } catch (\Exception $e) {
                                \Log::error($e);

                                $response = [
                                    'response_code' => 'R500',
                                    'response_message' => 'Something went wrong! This might not be your problem but ours, please contact us immediately.'
                                ];
                            }

                            $response = [
                                'response_code' => 'R001',
                                'response_message' => 'Request successful! New SKU ID added.'
                            ];
                        } elseif (!$pickup_point) {
                            $response = [
                                'response_code' => 'R003',
                                'response_message' => 'Parameter Pickup Point Location ID is not found'
                            ];
                        }
                    }
                }
            }
        } else {
            $response = [
                'response_code' => 'R405',
                'response_message' => 'Request not allowed. Please contact us for the Basic Username and Basic Password'
            ];
        }

        return response()->json($response);
    }

    public function remove_stock(Request $request)
    {
        $header = $request->header('Authorization');
        $decoded = base64_decode(str_replace('Basic', '', $header));
        list($username, $password) = explode(":", $decoded);

        if ($username == env('WORLDCRAFT_BASIC_USERNAME') && $password == env('WORLDCRAFT_BASIC_PASSWORD')) {
            $validate = Validator::make($request->all(), [
                'sku_id' => 'required',
                'pup_location_id' => 'required',
            ], [
                'sku_id.required' => "The SKU ID is required!",
                'pup_location_id.required' => "The pickup point location ID is required!",
            ]);

            if ($validate->fails()) {
                $errors = null;
                $errors = $validate->errors()->messages();

                $response = [
                    'response_code' => 'R422',
                    'response_message' => 'Request failed, incomplete parameters. Please refer to errors to know what are the parameters missing.',
                    'errors' => $errors
                ];
            } else {
                $worldcraft_stock = WorldCraftStock::where('sku_id', $request->sku_id)
                    ->where('pup_location_id', $request->pup_location_id)
                    ->exists();

                $worldcraft_stock_sku_id = WorldcraftStock::where('sku_id', $request->sku_id)->exists();
                $worldcraft_stock_pup_id = WorldcraftStock::where('pup_location_id', $request->pup_location_id)->exists();

                if ($worldcraft_stock) {
                    try {
                        $worldcraft_stock_delete = WorldCraftStock::where('sku_id', $request->sku_id)
                            ->where('pup_location_id', $request->pup_location_id)
                            ->first();

                        $worldcraft_stock_delete->delete();

                        $response = [
                            'response_code' => 'R001',
                            'response_message' => 'Request successful! Stock is now deleted.'
                        ];
                    } catch (\Exception $e) {
                        \Log::error($e);

                        $response = [
                            'response_code' => 'R500',
                            'response_message' => 'Something went wrong! This might not be your problem but ours, please contact us immediately.'
                        ];
                    }
                } else if (!$worldcraft_stock_sku_id) {
                    $response = [
                        'response_code' => 'R002',
                        'repsonse_message' => 'Parameter SKU is not found'
                    ];
                } else if (!$worldcraft_stock_pup_id) {
                    $response = [
                        'response_code' => 'R003',
                        'response_message' => 'Parameter Pickup Point Location ID is not found'
                    ];
                } else {
                    $repsonse = [
                        'response_code' => 'R404',
                        'response_message' => "SKU ID: " . $request->sku_id . " cannot be found!"
                    ];
                }
            }
        }

        return response()->json($response);
    }

    /**
     * Receive stocks update
     */
    public function stocks_update(Request $request)
    {
        $header = $request->header('Authorization');
        $decoded = base64_decode(str_replace('Basic', '', $header));
        list($username, $password) = explode(":", $decoded);

        // Check if username and password is correct
        if ($username == env('WORLDCRAFT_BASIC_USERNAME') && $password == env('WORLDCRAFT_BASIC_PASSWORD')) {
            // Check if request parameters is complete
            $validate = Validator::make($request->all(), [
                'sku_id' => 'required',
                'pup_location_id' => 'required',
                'quantity' => 'required',
                'change_type' => 'required|in:add,remove',
                'type' => 'required|in:walk_in,transfer,other'
            ], [
                'sku_id.required' => "The SKU ID is required!",
                'pup_location_id.required' => "The pickup point location ID is required!",
                'quantity.required' => "The quantity is required!",
                'type.required' => "The type of transaction is required!",
                'change_type.required' => "The change type of transaction is required!"
            ]);

            // If Validator Fails
            if ($validate->fails()) {
                $errors = null;
                $errors = $validate->errors()->messages();

                $response = [
                    'response_code' => 'R422',
                    'response_message' => 'Request failed, incomplete parameters. Please refer to errors to know what are the parameters missing.',
                    'errors' => $errors
                ];
            }

            // If validator passes
            else {
                try {
                    $worldcraft_stock = WorldCraftStock::where('sku_id', $request->sku_id)
                        ->where('pup_location_id', $request->pup_location_id)
                        ->exists();

                    $worldcraft_stock_sku_id = WorldcraftStock::where('sku_id', $request->sku_id)->exists();
                    $worldcraft_stock_pup_id = WorldcraftStock::where('pup_location_id', $request->pup_location_id)->exists();
                    // Check if SKU ID exists on the current database
                    if ($worldcraft_stock) {
                        $worldcraft_stock = WorldCraftStock::where('sku_id', $request->sku_id)
                            ->where('pup_location_id', $request->pup_location_id)
                            ->first();

                        if ($request->change_type == 'add') {
                            $worldcraft_stock->quantity += $request->quantity;
                        } else if ($request->change_type == 'remove') {
                            $worldcraft_stock->quantity -= $request->quantity;
                            $worldcraft_stock->quantity = max($worldcraft_stock->quantity, 0);
                        }

                        if ($worldcraft_stock->save()) {
                            try {
                                $worldcraft_update_stock = new WorldcraftUpdateStock;

                                $worldcraft_update_stock->pup_location_id = $request->pup_location_id;
                                $worldcraft_update_stock->sku_id = Str::slug($request->sku_id, '-');
                                $worldcraft_update_stock->change_type = $request->change_type;
                                $worldcraft_update_stock->quantity = $request->quantity;
                                $worldcraft_update_stock->type = $request->type;
                                $worldcraft_update_stock->remarks = $request->remarks;

                                $worldcraft_update_stock->save();
                            } catch (\Exception $e) {
                                \Log::error($e);

                                $response = [
                                    'response_code' => 'R500',
                                    'response_message' => 'Something went wrong! This might not be your problem but ours, please contact us immediately.'
                                ];
                            }

                            $response = [
                                'response_code' => 'R001',
                                'response_message' => 'Request successful! Syncing is successfully done.'
                            ];
                        } else {
                            $response = [
                                'response_code' => 'R500',
                                'response_message' => 'Something went wrong! This might not be your problem but ours, please contact us immediately.'
                            ];
                        }
                    } else if (!$worldcraft_stock_sku_id) {
                        $response = [
                            'response_code' => 'R002',
                            'repsonse_message' => 'Parameter SKU is not found'
                        ];
                    } else if (!$worldcraft_stock_pup_id) {
                        $response = [
                            'response_code' => 'R003',
                            'response_message' => 'Parameter Pickup Point Location ID is not found'
                        ];
                    } else {
                        $response = [
                            'response_code' => 'R422',
                            'response_message' => "Stock with SKU ID: $request->sku_id and Pickup Point ID: $request->pup_location_id is not existing!"
                        ];
                    }
                } catch (\Exception $e) {
                    $response = [
                        'response_code' => 'R500',
                        'response_message' => 'Something went wrong, this might not be your problem but ours. Please contact us immediately.'
                    ];
                }
            }
        }

        // Return if Basic auth and password is wrong
        else {
            $response = [
                'response_code' => 'R405',
                'response_message' => 'Request not allowed. Please contact us for the Basic Username and Basic Password'
            ];
        }

        return response()->json($response);
    }

    /**
     * API Call to get all current products
     */
    public function get_all_products(Request $request)
    {
        $header = $request->header('Authorization');
        $decoded = base64_decode(str_replace('Basic', '', $header));
        list($username, $password) = explode(":", $decoded);

        // Check if username and password is correct
        if ($username == env('WORLDCRAFT_BASIC_USERNAME') && $password == env('WORLDCRAFT_BASIC_PASSWORD')) {
            $products = \App\Product::get();

            $data = [];
            $product_list = [];

            foreach ($products as $key => $product) {
                $product_list['product_name']       =   $product->getTranslation('name') ?? "N\A";
                $product_list['category']           =   $product->category->name ?? "N\A";
                $product_list['brand']              =   $product->brand->name ?? "N\A";
                $product_list['unit_price']         =   $product->unit_price ?? "N\A";
                $product_list['item_size']          =   $product->item_size ?? "N\A";
                $product_list['item_length']        =   $product->length ?? "N\A";
                $product_list['item_weight']        =   $product->weight ?? "N\A";
                $product_list['item_height']        =   $product->height ?? "N\A";
                $product_list['item_width']         =   $product->width ?? "N\A";
                $product_list['item_uom']           =   $product->item_unit_of_measurement ?? "N\A";

                $variations = $product->stocks;

                $variation_list = [];
                $data_variation = [];

                foreach ($variations as $key => $variation) {
                    $variation_list['name']         =   "";
                    $variation_list['variation']    =   $variation->variant ?? "N\A";
                    $variation_list['sku']          =   $variation->sku ?? "N\A";
                    array_push($data_variation, $variation_list);
                }

                $product_list['variations']         =   json_encode($data_variation);
                $product_list['package_length']     = $product->package_length ?? "N\A";
                $product_list['package_weight']     = $product->package_weight ?? "N\A";
                $product_list['package_height']     = $product->package_height ?? "N\A";
                $product_list['package_width']      = $product->package_width ?? "N\A";

                array_push($data, $product_list);
            }

            $response = [
                'products' => $data
            ];
        } else {
            $response = [
                'response_code' => 'R405',
                'response_message' => 'Request not allowed. Please contact us for the Basic Username and Basic Password'
            ];
        }

        return response()->json($response);
    }

    /**
     * Pass products store
     *
     */
    public function new_product_store($product)
    {
        $username = env('WORLDCRAFT_API_USERNAME');
        $password = env('WORLDCRAFT_API_PASSWORD');

        $data = [];
        $variations = $product->stocks;
        $variation_data = [];

        foreach ($variations as $key => $variation) {
            $variation_data['name'] = "N/A";
            $variation_data['variation'] = $variation->variant;
            $variation_data['sku'] = $variation->sku;
            array_push($data, $variation_data);
        }

        $params = [
            'product_name' => $product->getTranslation('name'),
            'category' => $product->category->name ?? "N/A",
            'brand' => $product->brand->name ?? "N/A",
            'unit_price' => $product->unit_price ?? "N/A",
            'item_size' => $product->item_size ?? "N/A",
            'item_length' => $product->length ?? "N/A",
            'item_weight' => $product->weight ?? "N/A",
            'item_height' => $product->height ?? "N/A",
            'item_width' => $product->width ?? "N/A",
            'item_uom' => $product->item_unit_of_measurement ?? "N/A",
            'variations' => json_encode($data),
            'package_length' => $product->package_length,
            'package_weight' => $product->package_weight,
            'package_height' => $product->package_height,
            'package_width' => $product->width
        ];

        $url = env('WORLDCRAFT_API_PRODUCT_ENDPOINT');

        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($username . ':' . $password),
            'accept:application/json'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $api_logs = new \App\Http\Controllers\ApiLogController;
        $api_logs->store($params, $response);

        return $response;
    }

    /**
     * Pass stocks update
     */
    public function pass_stocks_update($order)
    {

        $order_details = $order->orderDetails;

        foreach ($order_details as $key => $value) {
            $pickup_point_location = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $order->pickup_point_location)))
                ->first();

            if ($value->variation != null) {
                $product_stock = \App\ProductStock::where('product_id', $value->product_id)
                    ->where('variant', $value->variation)
                    ->first()->sku;

                $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $product_stock)
                    ->where('pup_location_id', $pickup_point_location->id)
                    ->first();

                $worldcraft_stock->quantity -= $value->quantity;
                $worldcraft_stock->save();
            } else {
                $product_sku = \App\Product::where('id', $value->product_id)
                    ->first()->sku;

                $worldcraft_stock = \App\WorldcraftStock::where('sku_id', $product_sku)
                    ->where('pup_location_id', $pickup_point_location->id)
                    ->first();

                $worldcraft_stock->quantity -= $value->quantity;
                $worldcraft_stock->save();
            }
        }

        $username = env('WORLDCRAFT_API_USERNAME');
        $password = env('WORLDCRAFT_API_PASSWORD');

        $pickup_point_location = \App\PickupPoint::where('name', ucfirst(str_replace('_', ' ', $order->pickup_point_location)))
            ->first()->id;

        $data = [];
        $order_details = [];

        foreach ($order->orderDetails as $key => $value) {
            $order_details['id'] = $value->id;

            if ($value->variation != null) {
                $variant = \App\ProductStock::where('product_id', $value->product_id)
                    ->where('variant', $value->variation)
                    ->first();

                $order_details['sku'] = $variant->sku;
            } else {
                $variant = \App\Product::where('id', $value->product_id)
                    ->first()->sku;

                $order_details['sku'] = $variant;
            }
            $order_details['item_price'] = $value->price / $value->quantity;
            $order_details['quantity'] = $value->quantity;
            $order_details['order_type'] = $value->order_type;
            $order_details['product_referral_code'] = $value->product_referral_code;

            array_push($data, $order_details);
        }

        $agent = User::where('id', $order->user->referred_by)
            ->first();

        if ($agent != null) {
            $agent_name = $agent->name;
        } else {
            $agent_name = "N\A";
        }

        $tin_no = null;

        if ($order->user->user_type == 'reseller') {
            $tin_no = $order->user->reseller['tin'] ?? "N/A";
        } else {
            $tin_no = $order->user->tin_no ?? "N/A";
        }

        $emp_id = null;

        if ($order->user->user_type == 'reseller' || $order->user->user_type == 'customer') {
            $emp_id = $agent != null ? $agent->id : "N\A";
        } else if ($order->user->user_type == 'employee') {
            $emp_id = $order->user->id;
        }

        $route = Route::currentRouteName();
        $params = [
            'agent_name' => $agent_name,
            'order_code' => $order->code ?? "N/A",
            'payment_option' => $order->payment_option ?? "N/A",
            'payment_type' => $order->payment_type ?? "N/A",
            'grand_total' => $order->grand_total ?? "N/A",
            'order_status' => [$order->payment_status, $order->orderDetails->first()->delivery_status] ?? "N/A",
            'payment_reference' => $order->payment_reference ?? "N/A",
            'coupon_code' => $order->coupon_code ?? "N/A",
            'coupon_discount' => $order->coupon_discount ?? "N/A",
            'cr_number' => $order->cr_number,
            'ar_number' => $order->ar_number,
            'som_number' => $order->som_number,
            'som_number_date' => $order->som_number_date,
            'si_number' => $order->si_number,
            'si_number_date' => $order->si_number_date,
            'dr_number' => $order->dr_number,
            'dr_number_date' => $order->dr_number_date,
            'date_ordered' => date('Y-m-d H:i:s', $order->date),
            'pickup_point_id' => $pickup_point_location,
            'customer_information' => [
                'emp_id' => $emp_id != null ? $emp_id : 'N\A',
                'unique_id' => $order->user->unique_id,
                'display_name' => $order->user->display_name,
                'tin_no' => $tin_no,
                'name' => $order->user->name,
                'email' => $order->user->email,
                'address' => strpos($route, 'walkin') !== false ? $pickup_point_location : json_decode($order->shipping_address)->address,
                'area' => strpos($route, 'walkin') !== false ? null : json_decode($order->shipping_address)->island,
                'type' => $order->user->user_type
            ],
            'order_details' => json_encode($data)
        ];

        $url = env("WORLDCRAFT_API_ORDERS_ENDPOINT");

        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($username . ':' . $password),
            'accept:application/json'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $api_logs = new \App\Http\Controllers\ApiLogController;
        $api_logs->store($params, $response);

        return [
            'response' => $response,
            'parameters' => $params
        ];
    }

    /**
     * Pass payment status update
     */
    public function payment_status_update($order)
    {
        $username = env('WORLDCRAFT_API_USERNAME');
        $password = env('WORLDCRAFT_API_PASSWORD');

        $params = [
            'order_code'        => $order->code ?? "N\A",
            'order_status'      => $order->payment_status ?? "N\A",
            'cr_number'         => $order->cr_number ?? "N\A",
            'ar_number'         => $order->ar_number ?? "N\A",
            'som_number'        => $order->som_number ?? "N\A",
            'som_number_date'   => $order->som_number_date ?? "N\A",
            'si_number'         => $order->si_number ?? "N\A",
            'si_number_date'    => $order->si_number_date ?? "N\A",
            'dr_number'         => $order->dr_number ?? "N\A",
            'dr_number_date'    => $order->dr_number_date ?? "N\A"
        ];

        $url = env("WORLDCRAFT_API_UPDATE_PAYMENT_STATUS");

        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($username . ':' . $password),
            'accept:application/json'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $api_logs = new \App\Http\Controllers\ApiLogController;
        $api_logs->store($params, $response);

        return [
            'response' => $response,
            'parameters' => $params
        ];
    }

    /**
     * Pass delivery status update
     */
    public function delivery_status_update($order)
    {
        $username = env('WORLDCRAFT_API_USERNAME');
        $password = env('WORLDCRAFT_API_PASSWORD');

        $params = [
            'order_code' => $order->code ?? "N\A",
            'delivery_status' => $order->orderDetails->first()->delivery_status ?? "N\A"
        ];

        $url = env("WORLDCRAFT_API_UPDATE_DELIVERY_STATUS");

        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($username . ':' . $password),
            'accept:application/json'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $api_logs = new \App\Http\Controllers\ApiLogController;
        $api_logs->store($params, $response);

        return [
            'response' => $response,
            'parameters' => $params
        ];
    }

    /**
     * Pass cancelled order 
     */
    public function cancelled_order($order)
    {
        $username = env('WORLDCRAFT_API_USERNAME');
        $password = env('WORLDCRAFT_API_PASSWORD');

        $params = [
            'order_code' => $order->code ?? "N\A",
            'order_status' => "Cancelled"
        ];

        $url = env("WORLDCRAFT_API_UPDATE_CANCELLED_ORDER");

        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($username . ':' . $password),
            'accept:application/json'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $api_logs = new \App\Http\Controllers\ApiLogController;
        $api_logs->store($params, $response);

        return [
            'response' => $response,
            'parameters' => $params
        ];
    }
}
