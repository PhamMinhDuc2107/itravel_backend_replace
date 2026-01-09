<?php

namespace Modules\Payment\Services;

use Modules\Payment\Interfaces\PaymentRepositoryInterface;

class PaymentService
{
    public function __construct(
        protected PaymentRepositoryInterface $repository
    ) {}

    public function getList()
    {
        return $this->repository->getAll();
    }
}
