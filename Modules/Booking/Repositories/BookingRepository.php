<?php

namespace Modules\Booking\Repositories;

use Modules\Booking\Interfaces\BookingRepositoryInterface;
use Modules\Booking\Models\BookingModel;

class BookingRepository implements BookingRepositoryInterface
{
    public function getAll()
    {
        return BookingModel::all();
    }

    public function findById(int $id)
    {
        return BookingModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return BookingModel::create($data);
    }
}
