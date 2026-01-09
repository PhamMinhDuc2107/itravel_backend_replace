<?php

namespace Modules\Booking\Interfaces;

interface BookingRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
}
