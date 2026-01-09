<?php

namespace Modules\Payment\Interfaces;

interface PaymentRepositoryInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
}
