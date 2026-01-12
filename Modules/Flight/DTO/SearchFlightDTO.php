<?php
namespace Modules\Flight\DTO;
use Modules\Shared\DTO\BaseDTO;
class SearchFlightDTO extends BaseDTO {
    public function __construct(public string $from_code, public string $to_code) {}
}
