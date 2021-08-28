<?php


namespace App\Traits;



use Exception;
use Illuminate\Http\JsonResponse;

Trait TResponse
{
    /**
     * @param Exception $e
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseExceptionError(Exception $e, $statusCode = 500): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'File' => $e->getFile(),
                'status_code' => $statusCode,
            ]
        ], $statusCode);
    }

    public function responseError($message, $statusCode): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'status_code' => $statusCode,
            ]
        ], $statusCode);
    }
}
