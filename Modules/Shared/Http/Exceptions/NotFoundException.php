<?php

namespace Moodule\Shared\Http\Exceptions;

use Modules\Shared\Enums\HttpStatusCodeEnum;

class NotFoundException extends BaseException
{
    public function __construct(string $message = 'Resource not found', array $data = [])
    {
        parent::__construct($message, HttpStatusCodeEnum::NotFound->value, $data, false);
    }
}
