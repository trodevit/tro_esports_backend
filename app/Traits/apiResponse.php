<?php

namespace App\Traits;

trait apiResponse
{
    public function successResponse($data, $message, $code)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse($data, $message, $code){
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
