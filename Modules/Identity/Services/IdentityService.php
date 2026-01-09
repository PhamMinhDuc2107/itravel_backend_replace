<?php

namespace Modules\Identity\Services;

use Modules\Identity\Interfaces\IdentityRepositoryInterface;

class IdentityService
{
    public function __construct(
        protected IdentityRepositoryInterface $repository
    ) {}

    public function getList()
    {
        return $this->repository->getAll();
    }
}
