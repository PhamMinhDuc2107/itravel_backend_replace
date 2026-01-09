<?php

namespace Modules\Hotel\Interfaces;

interface HotelRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
}
