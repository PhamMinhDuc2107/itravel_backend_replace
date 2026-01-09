<?php

namespace Modules\Identity\Interfaces;

interface IdentityRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
}
