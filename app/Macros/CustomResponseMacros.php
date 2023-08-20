<?php

namespace App\Macros;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;

class CustomResponseMacros
{
    public static function register()
    {
        Response::macro('diaaJson', function ($data = [], $status = 200, array $headers = []) {
            $response = [
                'data' => $data,
            ];
            return response()->json($response, $status, $headers);
        });
    }
}
