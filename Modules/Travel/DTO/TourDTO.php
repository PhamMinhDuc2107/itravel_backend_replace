<?php
namespace Modules\Travel\DTO;
use Modules\Shared\DTO\BaseDTO;
class TourDTO extends BaseDTO {
    public function __construct(public string $title, public float $price) {}
}
