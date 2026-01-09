<?php

namespace Modules\Visa\Interfaces;

interface VisaRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
}
