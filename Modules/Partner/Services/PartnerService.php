<?php

namespace Modules\Partner\Services;

use Modules\Partner\Interfaces\PartnerRepositoryInterface;

class PartnerService
{
    public function __construct(
        protected PartnerRepositoryInterface $repository
    ) {}

    public function getList()
    {
        return $this->repository->getAll();
    }
}
