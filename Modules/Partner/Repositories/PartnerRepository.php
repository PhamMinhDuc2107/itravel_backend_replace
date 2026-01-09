<?php

namespace Modules\Partner\Repositories;

use Modules\Partner\Interfaces\PartnerRepositoryInterface;
use Modules\Partner\Models\PartnerModel;

class PartnerRepository implements PartnerRepositoryInterface
{
    public function getAll()
    {
        return PartnerModel::all();
    }

    public function findById(int $id)
    {
        return PartnerModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return PartnerModel::create($data);
    }
}
