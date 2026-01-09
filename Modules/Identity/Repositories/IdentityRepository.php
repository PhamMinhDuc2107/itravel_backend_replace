<?php

namespace Modules\Identity\Repositories;

use Modules\Identity\Interfaces\IdentityRepositoryInterface;
use Modules\Identity\Models\IdentityModel;

class IdentityRepository implements IdentityRepositoryInterface
{
    public function getAll()
    {
        return IdentityModel::all();
    }

    public function findById(int $id)
    {
        return IdentityModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return IdentityModel::create($data);
    }
}
