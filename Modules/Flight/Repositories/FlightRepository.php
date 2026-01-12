<?php
namespace Modules\Flight\Repositories;
use Modules\Shared\Repositories\BaseRepository;
use Modules\Flight\Contracts\FlightRepositoryContract;

class FlightRepository extends BaseRepository implements FlightRepositoryContract {
    public function getAll() { return []; }
}
