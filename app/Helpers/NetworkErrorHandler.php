<?php

namespace App\Helpers;

trait NetworkErrorHandler
{
    protected function cantResolveNetwork()
    {
        return response()->json([
            "success" => false,
            "status" => 504,
            "statusText" => "Gateway Timeout",
        ]);
    }
}
