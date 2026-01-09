<?php

namespace Modules\Visa\Services;

use Modules\Visa\Interfaces\VisaRepositoryInterface;

class VisaService
{
    public function __construct(
        protected VisaRepositoryInterface $repository
    ) {}

    public function getList()
    {
        return $this->repository->getAll();
    }
}
