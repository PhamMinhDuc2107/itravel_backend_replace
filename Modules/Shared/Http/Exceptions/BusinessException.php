<?php

namespace Moodule\Shared\Http\Exceptions;

use Modules\Shared\Enums\HttpStatusCodeEnum;

class BusinessException extends BaseException
{
    public function __construct(
        string $message,
        array $data = [],
        int $statusCode = HttpStatusCodeEnum::BadRequest->value
    ) {
        parent::__construct($message, $statusCode, $data, true);
    }
}
