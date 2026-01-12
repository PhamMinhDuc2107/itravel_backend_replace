<?php
namespace Modules\Identity\Enums;

enum AccountTypeEnum: string
{
    case Admin = 'admin';
    case User = 'user';
    case Partner = 'partner';
}
