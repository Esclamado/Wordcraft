<?php

namespace App\Http\Controllers\MLM\v1;

use App\Http\Controllers\Controller;
use App\ResellerEarning;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ApiController extends Controller
{
    public function retrieve_reseller(Request $request)
    {
        try {
            $user = User::where('unique_id', $request->reseller_id)
                ->where('user_type', 'reseller')
                ->first();

            if ($user && $user->reseller != null) {

                if ($user->referred_by != null) {
                    $response = [
                        'response_code' => 'R001',
                        'message' => 'Request Successful',
                        'data' => [
                            'attributes' => [
                                'id' => $user->id,
                                'unique_id' => $user->unique_id,
                                'referred_by' => [
                                    'id' => $user->referrer->id,
                                    'unique_id' => $user->referrer->unique_id,
                                    'name' => $user->referrer->name,
                                    'email' => $user->referrer->email,
                                    'phone' => $user->referrer->phone
                                ],
                                'name' => $user->name,
                                'email' => $user->email,
                                'phone' => str_replace(' ', '', $user->phone),
                                'referral_code' => $user->referral_code,
                                'last_login' => $user->last_login,
                                'created_at' => $user->created_at
                            ]
                        ]
                    ];
                } else {
                    $response = [
                        'response_code' => 'R001',
                        'message' => 'Request Successful',
                        'data' => [
                            'attributes' => [
                                'id' => $user->id,
                                'unique_id' => $user->unique_id,
                                'referred_by' => null,
                                'name' => $user->name,
                                'email' => $user->email,
                                'phone' => str_replace(' ', '', $user->phone),
                                'referral_code' => $user->referral_code,
                                'last_login' => $user->last_login,
                                'created_at' => $user->created_at
                            ]
                        ]
                    ];
                }
            } else {
                $response = [
                    'response_code' => 'R422',
                    'message' => 'Request Failed; Incomplete or invalid parameter',
                    'errors' => 'User does not exists'
                ];
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG') == true) {
                dd($e);
            }

            Log::error($e);

            return response()->json([
                'response_code' => 'R500',
                'message' => 'Something went wrong',
                'details' => 'Please contact us immediately.'
            ], 500);
        }
    }

    public function retrieve_reseller_verification(Request $request)
    {
        try {
            $user = User::where('unique_id', $request->reseller_id)
                ->where('user_type', 'reseller')
                ->first();

            if ($user && $user->reseller != null) {
                if ($user->referred_by != null) {
                    $response = [
                        'response_code' => 'R001',
                        'message' => 'Request Successful',
                        'data' => [
                            'attributes' => [
                                'id' => $user->id,
                                'unique_id' => $user->unique_id,
                                'referred_by' => [
                                    'id' => $user->referrer->id,
                                    'unique_id' => $user->referrer->unique_id,
                                    'name' => $user->referrer->name,
                                    'email' => $user->referrer->email,
                                    'phone' => $user->referrer->phone,
                                ],
                                'name' => $user->name,
                                'email' => $user->email,
                                'phone' => $user->phone,
                                'verified' => $user->reseller_is_verified == 1 ? true : false,
                                'referral_code' => $user->referral_code,
                                'created_at' => date('Y-m-d H:i:s', strtotime($user->created_at))
                            ]
                        ]
                    ];
                } else {
                    $response = [
                        'response_code' => 'R001',
                        'message' => 'Request Sucessful',
                        'data' => [
                            'attributes' => [
                                'id' => $user->id,
                                'unique_id' => $user->unique_id,
                                'referred_by' => null,
                                'name' => $user->name,
                                'email' => $user->email,
                                'phone' => $user->phone,
                                'verified' => $user->reseller_is_verified == 1 ? true : false,
                                'referral_code' => $user->referral_code,
                                'created_at' => date('Y-m-d H:i:s', strtotime($user->created_at))
                            ]
                        ]

                    ];
                }
            } else {
                $response = [
                    'response_code' => 'R422',
                    'message' => 'Request Failed; Incomplete or invalid parameter',
                    'error' => 'User is not registered as reseller.'
                ];
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG') == true) {
                dd($e);
            }

            Log::error($e);

            return response()->json([
                'response_code' => 'R500',
                'message' => 'Something went wrong',
                'details' => 'Please contact us immediately.'
            ], 500);
        }
    }

    public function retrieve_reseller_transactions(Request $request)
    {
        try {
            // Filtering
            $reseller_transactions = null;
            $reseller_id = null;
            $order_by = null;
            $filter_by_status = null;
            $filter_by_payment_method = null;
            $filter_by_grand_total = null;

            if (!empty($request->input('reseller_id'))) {
                $user = User::where('unique_id', $request->reseller_id)
                    ->where('user_type', 'reseller')
                    ->first();

                if ($user != null) {
                    $reseller_id = $user->id;
                    $reseller_transactions = ResellerEarning::where('reseller_id', $reseller_id)
                        ->select('id', 'reseller_id', 'order_id', 'customer_id', 'amount', 'income', 'paid_at', 'created_at')
                        ->distinct();
                } else {
                    $response = [
                        'response_code' => 'R422',
                        'message' => 'Request Failed; Incomplete or invalid parameter',
                        'error' => 'Reseller does not exists!'
                    ];
                }
            } else {
                $reseller_transactions = ResellerEarning::select('id', 'reseller_id', 'order_id', 'customer_id', 'amount', 'income', 'paid_at', 'created_at')
                    ->distinct();
            }

            if ($reseller_transactions != null) {
                if (!empty($request->input('order_by'))) {
                    $order_by = explode(',', $request->order_by);
                    $reseller_transactions = $reseller_transactions->orderBy($order_by[0], $order_by[1]);
                }

                if (!empty($request->input('filter_by_status'))) {
                    $filter_by_status = $request->filter_by_status;

                    if ($filter_by_status == 'completed') {
                        $reseller_transactions = $reseller_transactions->whereHas('order', function ($order) {
                            $order->where('payment_status', 'paid');
                        });
                    } else {
                        $reseller_transactions = $reseller_transactions->whereHas('order', function ($order) {
                            $order->where('payment_status', 'unpaid');
                        });
                    }
                }

                if (!empty($request->input('filter_by_payment_method'))) {
                    $filter_by_payment_method = $request->filter_by_payment_method;

                    $reseller_transactions = $reseller_transactions->whereHas('order', function ($order) use ($filter_by_payment_method) {
                        $order->where('payment_type', $filter_by_payment_method);
                    });
                }

                if (!empty($request->input('filter_by_grand_total'))) {
                    $filter_by_grand_total = $request->filter_by_grand_total;
                    $reseller_transactions = $reseller_transactions->orderBy('amount', $filter_by_grand_total);
                }

                $reseller_transactions = $reseller_transactions->get();
                $transactions = [];

                foreach ($reseller_transactions as $transaction) {
                    $trans = [];
                    $trans['id'] = $transaction->id;
                    $trans['order_code'] = $transaction->order->code;
                    $trans['customer'] = [
                        'id' => $transaction->customer->id,
                        'unique_id' => $transaction->customer->unique_id,
                        'name' => $transaction->customer->name,
                        'email' => $transaction->customer->email,
                        'phone' => str_replace(' ', '', $transaction->customer->phone)
                    ];

                    if ($transaction->order->payment_status == 'paid' && $transaction->order->orderDetails->first()->delivery_status == 'picked_up') {
                        $trans['status'] = 'completed';
                    } else {
                        $trans['status'] = 'processing';
                    }

                    $trans['payment_method'] = $transaction->order->payment_type;
                    $trans['payment_channel'] = $transaction->order->payment_channel;
                    $trans['grand_total'] = $transaction->order->grand_total;

                    $transaction_items = [];
                    foreach ($transaction->order->orderDetails as $item) {
                        $items = [];
                        $items['item_id'] = $item->product_id;
                        $items['item_name'] = $item->product->name;
                        $items['unit_price'] = $item->price / $item->quantity;
                        $items['quantity'] = $item->quantity;
                        $items['total_price'] = $item->price;
                        array_push($transaction_items, $items);
                    }

                    $trans['items'] = $transaction_items;
                    $trans['created_at'] = date('Y-m-d H:i:s', strtotime($transaction->created_at));

                    array_push($transactions, $trans);
                }

                $transactions['total_transactions'] = count($reseller_transactions);
                $transactions['total_earnings'] = $reseller_transactions->sum('income');

                $response = [
                    'data' => [
                        'attributes' => [
                            $this->paginate($transactions)
                        ]
                    ],
                    'total_transactions' => count($reseller_transactions),
                    'total_earnings' => $reseller_transactions->sum('income')
                ];
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG') == true) {
                dd($e);
            }

            Log::error($e);

            return response()->json([
                'response_code' => 'R500',
                'message' => 'Something went wrong',
                'details' => 'Please contact us immediately.'
            ], 500);
        }
    }

    public function retrieve_reseller_transaction(Request $request)
    {
        try {
            $reseller_id = null;

            $reseller_transaction = ResellerEarning::where('id', $request->transaction_id)
                ->select('id', 'reseller_id', 'order_id', 'customer_id', 'amount', 'income', 'paid_at', 'created_at')
                ->distinct();

            if (!empty($request->input('reseller_id'))) {
                $reseller_id = $request->reseller_id;
                $user = User::where('unique_id', $reseller_id)
                    ->where('user_type', 'reseller')
                    ->first();

                if ($user) {
                    $reseller_transaction = $reseller_transaction->where('reseller_id', $user->id);
                } else {
                    $response = [
                        'response_code' => 'R422',
                        'message' => 'Request Failed; Incomplete or invalid parameter',
                        'error' => 'Reseller does not exists!'
                    ];
                }
            }

            $reseller_transaction = $reseller_transaction->first();

            if ($reseller_transaction != null) {
                $transaction_items = [];

                foreach ($reseller_transaction->order->orderDetails as $item) {
                    $items = [];
                    $items['item_id'] = $item->product_id;
                    $items['item_name'] = $item->product->name;
                    $items['unit_price'] = $item->price / $item->quantity;
                    $items['quantity'] = $item->quantity;
                    $items['total_price'] = $item->price;
                    array_push($transaction_items, $items);
                }

                $response = [
                    'response_code' => 'R001',
                    'message' => 'Request Successful',
                    'data' => [
                        'attributes' => [
                            'id' => $reseller_transaction->id,
                            'order_code' => $reseller_transaction->order->code,
                            'customer' => [
                                'id' => $reseller_transaction->customer->id,
                                'unique_id' => $reseller_transaction->customer->unique_id,
                                'name' => $reseller_transaction->customer->name,
                                'email' => $reseller_transaction->customer->email,
                                'phone' => str_replace(" ", '', $reseller_transaction->customer->phone)
                            ],
                            'status' => $reseller_transaction->order->payment_status == 'paid' && $reseller_transaction->order->orderDetails->first()->delvery_status == 'picked_up' ? 'completed' : 'processing',
                            'payment_method' => $reseller_transaction->order->payment_type,
                            'payment_channel' => $reseller_transaction->order->payment_channel,
                            'grand_total' => $reseller_transaction->order->grand_total,
                            'items' => $transaction_items,
                            'created_at' =>  date('Y-m-d H:i:s', strtotime($reseller_transaction->created_at))
                        ]
                    ]
                ];
            } else {
                $response = [
                    'response_code' => 'R422',
                    'message' => 'Request Failed; Incomplete or invalid parameter',
                    'error' => 'Transaction does not exists!'
                ];
            }


            return response()->json($response, 200);
        } catch (\Exception $e) {
            if (getenv('APP_DEBUG') == true) {
                dd($e);
            }

            Log::error($e);

            return response()->json([
                'response_code' => 'R500',
                'message' => 'Something went wrong',
                'details' => 'Please contact us immediately.'
            ], 500);
        }
    }

    private function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
