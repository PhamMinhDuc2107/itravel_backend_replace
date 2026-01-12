<?php
namespace Modules\Concierge\Services;
use Modules\Concierge\Contracts\ConciergeRepositoryContract;

class ConciergeService {
    public function __construct(protected ConciergeRepositoryContract $repo) {}
}
