<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 'R422',
                'message' => 'Request Failed; Incomplete or invalid parameters',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $user = User::where('email', $request->email)
            ->with('user_key')
            ->first();

        if ($user) {
            $cypher_method = 'AES-128-CTR';
            $key = base64_encode($user->user_key->public_key);
            $iv = 2 * openssl_cipher_iv_length($cypher_method);
            $decrypted_key = null;

            if (preg_match("/^(.{" . $iv . "})(.+)$/", $request->password, $regs)) {
                list(, $iv, $request->password) = $regs;
                if (ctype_xdigit($iv)) {
                    $plaintext = openssl_decrypt($request->password, $cypher_method, $key, $options = 0, hex2bin($iv));
                    if (ctype_print($plaintext)) {
                        $decrypted_key = $plaintext;
                    } else {
                        // Do nothing...
                    }
                } else {
                    // Do nothing...
                }
            }

            if (Hash::check($decrypted_key, $user->password)) {
                $token = $user->createToken('BVU MLM Access');

                $response = [
                    'response_code' => 'R001',
                    'message' => 'Request Successful',
                    'data' => [
                        'attributes' => [
                            'token' => $token->accessToken
                        ]
                    ]
                ];

                return response()->json($response, 200);
            } else {
                $response = [
                    'response_code' => 'R422',
                    'message' => 'Request Failed; Incomplete or invalid parameters',
                    'errors' => 'Invalid email address or password provided.'
                ];

                return response()->json($response, 422);
            }
        } else {
            $response = [
                'response_code' => 'R422',
                'message' => 'Request Failed; Incomplete or invalid parameters',
                'errors' => 'User not found'
            ];

            return response()->json($response, 422);
        }
    }
}
