<?php

namespace Modules\Visa\Repositories;

use Modules\Visa\Interfaces\VisaRepositoryInterface;
use Modules\Visa\Models\VisaModel;

class VisaRepository implements VisaRepositoryInterface
{
    public function getAll()
    {
        return VisaModel::all();
    }

    public function findById(int $id)
    {
        return VisaModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return VisaModel::create($data);
    }
}
