<?php

namespace Modules\Booking\Services;

use Modules\Booking\Interfaces\BookingRepositoryInterface;

class BookingService
{
    public function __construct(
        protected BookingRepositoryInterface $repository
    ) {}

    public function getList()
    {
        return $this->repository->getAll();
    }
}
