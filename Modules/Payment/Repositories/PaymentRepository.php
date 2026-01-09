<?php

namespace Modules\Payment\Repositories;

use Modules\Payment\Interfaces\PaymentRepositoryInterface;
use Modules\Payment\Models\PaymentModel;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function getAll()
    {
        return PaymentModel::all();
    }

    public function findById(int $id)
    {
        return PaymentModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return PaymentModel::create($data);
    }
}
