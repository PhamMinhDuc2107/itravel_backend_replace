<?php

namespace Modules\Partner\Interfaces;

interface PartnerRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
}
