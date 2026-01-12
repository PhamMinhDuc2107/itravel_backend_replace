<?php
namespace Modules\Flight\Services;
use Modules\Flight\Contracts\FlightRepositoryContract;

class FlightService {
    public function __construct(protected FlightRepositoryContract $repo) {}
}
