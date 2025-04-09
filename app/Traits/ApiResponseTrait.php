<?php

namespace App\Traits;

trait ApiResponseTrait
{
    private bool $isOnlyBody = false;

    public function onlyBody(): void
    {
        $this->isOnlyBody = true;
    }

    public function responseError($payload = null, string $message = "", int $statusCode = 422, array $headers = [])
    {
        $data = [
            'error' => true,
            'message' => $message,
            'payload' => $payload
        ];

        return $this->isOnlyBody ? $data : response()->json($data, $statusCode, $headers);
    }

    public function responseSuccess($payload = null, string $message = "", int $statusCode = 200, array $headers = [])
    {
        $data = [
            'error' => false,
            'message' => $message,
            'payload' => $payload
        ];

        return $this->isOnlyBody ? $data : response()->json($data, $statusCode, $headers);
    }
}
