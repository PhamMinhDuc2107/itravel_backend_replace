<?php

namespace Modules\Shared\Enums;
enum AccountStatusEnum: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Banned = 'Banned';

    public function label(): string
    {
        return match($this) {
            self::Active   => __('messages.labels.active'),
            self::Inactive => __('messages.labels.inactive'),
            self::Banned   => __('messages.labels.banned'),
        };
    }

}
