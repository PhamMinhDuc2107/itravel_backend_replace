<?php

namespace Modules\Hotel\Repositories;

use Modules\Hotel\Interfaces\HotelRepositoryInterface;
use Modules\Hotel\Models\HotelModel;

class HotelRepository implements HotelRepositoryInterface
{
    public function getAll()
    {
        return HotelModel::all();
    }

    public function findById(int $id)
    {
        return HotelModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return HotelModel::create($data);
    }
}
