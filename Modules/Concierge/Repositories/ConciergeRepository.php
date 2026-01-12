<?php
namespace Modules\Concierge\Repositories;
use Modules\Shared\Repositories\BaseRepository;
use Modules\Concierge\Contracts\ConciergeRepositoryContract;

class ConciergeRepository extends BaseRepository implements ConciergeRepositoryContract {
    public function getAll() { return []; }
}
