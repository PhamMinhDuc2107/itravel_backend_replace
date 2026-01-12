<?php
namespace Modules\Travel\Repositories;
use Modules\Shared\Repositories\BaseRepository;
use Modules\Travel\Contracts\TravelRepositoryContract;

class TravelRepository extends BaseRepository implements TravelRepositoryContract {
    public function getAll() { return []; }
}
