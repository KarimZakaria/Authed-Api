<?php

namespace App\Http\Controllers\Api;

trait ResponseTrait
{
    public function apiResponse($data , $satus = null , $msg = null)
    {
        $response = [
            'data' => $data ,
            'satus' => $satus,
            'msg' => $msg,
        ];
        return response()->json($response);
    }
}
