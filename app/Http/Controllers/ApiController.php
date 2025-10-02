<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller {

    public function response($data, $message = '', $status = 200)
    {
        $data = [
            'data' => $data,
            'message' => $message
        ];
        return response()->json($data, $status);
    }

}