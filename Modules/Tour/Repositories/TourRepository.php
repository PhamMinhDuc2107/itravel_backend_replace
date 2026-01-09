<?php

namespace Modules\Tour\Repositories;

use Modules\Tour\Interfaces\TourRepositoryInterface;
use Modules\Tour\Models\TourModel;

class TourRepository implements TourRepositoryInterface
{
    public function getAll()
    {
        return TourModel::all();
    }

    public function findById(int $id)
    {
        return TourModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return TourModel::create($data);
    }
}
