<?php

namespace App\Traits;

trait ApiResponser {

    protected function success($message = null, $code = 200)
    {
        return response()->json([
            'status'=> true,
            'message' => $message
        ], $code);
    }

    protected function failure($message = null, $code = 422)
    {
        return response()->json([
            'status'=> false,
            'message' => $message
        ], $code);
    }

}
