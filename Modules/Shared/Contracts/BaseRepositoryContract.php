<?php

namespace Modules\Shared\Contracts;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface BaseRepositoryContract
{
    /* ========= CORE ========= */

    public function query(): Builder;

    public function all(array $columns = ['*']): Collection;

    public function paginate(
        int $perPage = 15,
        array $filters = [],
        array $search = [],
        array $sorts = [],
        array $columns = ['*']
    ): LengthAwarePaginator;

    public function findById(int|string $id, array $columns = ['*']);

    public function findOrFail(int|string $id, array $columns = ['*']);


    /* ========= WRITE ========= */

    public function create(array $data);

    public function updateById(int|string $id, array $data): bool;

    public function deleteById(int|string $id): bool;

    public function restoreById(int|string $id): bool;

    public function forceDeleteById(int|string $id): bool;


    /* ========= BULK ========= */

    public function bulkCreate(array $rows): bool;

    public function bulkUpdate(array $conditions, array $data): int;

    public function bulkDelete(array $conditions): int;


    /* ========= QUERY BY CONDITION ========= */

    public function firstBy(array $conditions, array $columns = ['*']);

    public function getBy(array $conditions, array $columns = ['*']): Collection;

    public function exists(array $conditions): bool;

    public function count(array $conditions = []): int;


    /* ========= ADVANCED ========= */

    public function when(bool $condition, Closure $callback): static;

    public function lockForUpdate(): static;

    public function with(array $relations): static;

    public function withoutGlobalScopes(): static;


    /* ========= TRANSACTION ========= */

    public function transaction(Closure $callback);
}
