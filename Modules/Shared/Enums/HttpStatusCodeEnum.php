<?php

namespace Modules\Shared\Enums;

enum HttpStatusCodeEnum: int
{
    // 2xx Success
    case OK = 200;
    case Created = 201;
    case Accepted = 202;
    case NoContent = 204;

    // 4xx Client Errors
    case BadRequest = 400;
    case Unauthorized = 401;
    case PaymentRequired = 402;
    case Forbidden = 403;
    case NotFound = 404;
    case MethodNotAllowed = 405;
    case NotAcceptable = 406;
    case RequestTimeout = 408;
    case Conflict = 409;
    case Gone = 410;
    case UnprocessableEntity = 422;
    case TooManyRequests = 429;

    // 5xx Server Errors
    case InternalServerError = 500;
    case NotImplemented = 501;
    case BadGateway = 502;
    case ServiceUnavailable = 503;
    case GatewayTimeout = 504;

    /**
     * Get status message
     */
    public function message(): string
    {
        return match ($this) {
            // Success
            self::OK => 'OK',
            self::Created => 'Created',
            self::Accepted => 'Accepted',
            self::NoContent => 'No Content',

            // Client Errors
            self::BadRequest => 'Bad Request',
            self::Unauthorized => 'Unauthorized',
            self::PaymentRequired => 'Payment Required',
            self::Forbidden => 'Forbidden',
            self::NotFound => 'Not Found',
            self::MethodNotAllowed => 'Method Not Allowed',
            self::NotAcceptable => 'Not Acceptable',
            self::RequestTimeout => 'Request Timeout',
            self::Conflict => 'Conflict',
            self::Gone => 'Gone',
            self::UnprocessableEntity => 'Unprocessable Entity',
            self::TooManyRequests => 'Too Many Requests',

            // Server Errors
            self::InternalServerError => 'Internal Server Error',
            self::NotImplemented => 'Not Implemented',
            self::BadGateway => 'Bad Gateway',
            self::ServiceUnavailable => 'Service Unavailable',
            self::GatewayTimeout => 'Gateway Timeout',
        };
    }

    /**
     * Check if success (2xx)
     */
    public function isSuccess(): bool
    {
        return $this->value >= 200 && $this->value < 300;
    }

    /**
     * Check if client error (4xx)
     */
    public function isClientError(): bool
    {
        return $this->value >= 400 && $this->value < 500;
    }

    /**
     * Check if server error (5xx)
     */
    public function isServerError(): bool
    {
        return $this->value >= 500 && $this->value < 600;
    }

    /**
     * Check if error (4xx or 5xx)
     */
    public function isError(): bool
    {
        return $this->isClientError() || $this->isServerError();
    }
}
