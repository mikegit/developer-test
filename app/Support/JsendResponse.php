<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class JsendResponse
{
    /**
     * @param array<string, mixed> $data
     */
    public static function success(string $message, array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function error(string $message, int $errorCode, array $data = [], int $status = 422): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error_code' => $errorCode,
            'data' => $data,
        ], $status);
    }
}
