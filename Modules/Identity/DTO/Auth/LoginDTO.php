<?php
namespace Modules\Identity\DTO\Auth;
use Modules\Shared\DTO\BaseDTO;

class LoginDTO extends BaseDTO {
    public function __construct(public string $email, public string $password, public string $type, public string $deviceName) {}
}
