<?php

namespace Modules\Hotel\Services;

use Modules\Hotel\Interfaces\HotelRepositoryInterface;

class HotelService
{
    public function __construct(
        protected HotelRepositoryInterface $repository
    ) {}

    public function getList()
    {
        return $this->repository->getAll();
    }
}
