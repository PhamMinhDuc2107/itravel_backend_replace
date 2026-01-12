<?php

namespace Modules\Shared\Repositories;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Shared\Contracts\BaseRepositoryContract;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;
abstract class BaseRepository implements BaseRepositoryContract
{
    protected Model $model;
    protected Builder $builder;

    public function query(): Builder
    {
        $this->builder = $this->model->newQuery();
        return $this->builder;
    }

    /* ========= CORE ========= */

    public function all(array $columns = ['*']): Collection
    {
        return $this->query()->get($columns);
    }

    public function paginate(
        int $perPage = 15,
        array $filters = [],
        array $search = [],
        array $sorts = [],
        array $columns = ['*']
    ): LengthAwarePaginator
    {
        $query = $this->query();

        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $query->where($field, $value);
            }
        }

        foreach ($search as $field => $keyword) {
            if ($keyword) {
                $query->where($field, 'LIKE', "%$keyword%");
            }
        }

        foreach ($sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query->paginate($perPage, $columns);
    }

    public function findById(int|string $id, array $columns = ['*'])
    {
        return $this->query()->find($id, $columns);
    }

    public function findOrFail(int|string $id, array $columns = ['*'])
    {
        return $this->query()->findOrFail($id, $columns);
    }


    /* ========= WRITE ========= */

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function updateById(int|string $id, array $data): bool
    {
        return (bool) $this->query()
            ->whereKey($id)
            ->update($data);
    }

    public function deleteById(int|string $id): bool
    {
        return (bool) $this->query()
            ->whereKey($id)
            ->delete();
    }

    public function restoreById(int|string $id): bool
    {
        return (bool) $this->query()
            ->withTrashed()
            ->whereKey($id)
            ->restore();
    }

    public function forceDeleteById(int|string $id): bool
    {
        return (bool) $this->query()
            ->withTrashed()
            ->whereKey($id)
            ->forceDelete();
    }


    /* ========= BULK ========= */

    public function bulkCreate(array $rows): bool
    {
        return $this->model->insert($rows);
    }

    public function bulkUpdate(array $conditions, array $data): int
    {
        return $this->query()
            ->where($conditions)
            ->update($data);
    }

    public function bulkDelete(array $conditions): int
    {
        return $this->query()
            ->where($conditions)
            ->delete();
    }


    /* ========= QUERY BY CONDITION ========= */

    public function firstBy(array $conditions, array $columns = ['*'])
    {
        return $this->query()
            ->where($conditions)
            ->first($columns);
    }

    public function getBy(array $conditions, array $columns = ['*']): Collection
    {
        return $this->query()
            ->where($conditions)
            ->get($columns);
    }

    public function exists(array $conditions): bool
    {
        return $this->query()
            ->where($conditions)
            ->exists();
    }

    public function count(array $conditions = []): int
    {
        return $this->query()
            ->where($conditions)
            ->count();
    }


    /* ========= ADVANCED ========= */

    public function when(bool $condition, Closure $callback): static
    {
        if ($condition) {
            $callback($this->builder);
        }

        return $this;
    }

    public function lockForUpdate(): static
    {
        $this->builder->lockForUpdate();
        return $this;
    }

    public function with(array $relations): static
    {
        $this->builder->with($relations);
        return $this;
    }

    public function withoutGlobalScopes(): static
    {
        $this->builder->withoutGlobalScopes();
        return $this;
    }


    /* ========= TRANSACTION ========= */

    public function transaction(Closure $callback)
    {
        return DB::transaction($callback);
    }
}
