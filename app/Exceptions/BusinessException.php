<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseException extends Exception
{
    public function __construct(
        string $message,
        protected int $statusCode = Response::HTTP_BAD_REQUEST,
        protected array $data = [],
        protected bool $shouldLog = true
    ) {
        parent::__construct($message, $statusCode);
    }


    public function report(): void
    {
        if (!$this->shouldLog) {
            return;
        }

        $logData = [
            'message' => $this->message,
            'data'    => $this->data,
            'file'    => $this->getFile(),
            'line'    => $this->getLine(),
            'user_id' => auth()->id() ?? 'guest',
            'url'     => request()->fullUrl(),
        ];

        if ($this->statusCode >= 500) {
            Log::error("[SYSTEM_ERROR] " . $this->message, $logData);
        } else {
            Log::warning("[BUSINESS_LOGIC] " . $this->message, $logData);
        }
    }


    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success'     => false,
            'message'     => $this->message,
            'status_code' => $this->statusCode,
            'data'        => !empty($this->data) ? $this->data : null,
            'timestamp'   => now()->toIso8601String()
        ], $this->statusCode);
    }
}
