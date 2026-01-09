<?php

namespace Modules\Tour\Services;

use Modules\Tour\Interfaces\TourRepositoryInterface;

class TourService
{
    public function __construct(
        protected TourRepositoryInterface $repository
    ) {}

    public function getList()
    {
        return $this->repository->getAll();
    }
}
