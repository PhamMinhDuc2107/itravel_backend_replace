<?php
namespace Modules\Travel\Services;
use Modules\Travel\Contracts\TravelRepositoryContract;

class TravelService {
    public function __construct(protected TravelRepositoryContract $repo) {}
}
