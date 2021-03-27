<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function successResponse($message, $data, $code)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public function failedResponse($message, $code)
    {
        return response()->json([
            'status'  => 'failed',
            'message' => $message,
        ], $code);
    }
}
