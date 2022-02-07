<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiLog;

class ApiLogController extends Controller
{
    public function store($request, $response) {
        $api_log = new ApiLog;

        $api_log->request = $request;
        $api_log->response = $response;

        $api_log->save();
    }
}
