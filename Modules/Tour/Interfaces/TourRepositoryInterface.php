<?php

namespace Modules\Tour\Interfaces;

interface TourRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
}
