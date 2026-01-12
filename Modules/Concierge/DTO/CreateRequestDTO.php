<?php
namespace Modules\Concierge\DTO;
use Modules\Shared\DTO\BaseDTO;
class CreateRequestDTO extends BaseDTO {
    public function __construct(public string $customer_name, public string $service_type) {}
}
