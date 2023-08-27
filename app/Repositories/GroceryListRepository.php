<?php

namespace App\Repositories;

use App\Models\GroceryList;
use App\Repositories\Contracts\GroceryListRepositoryContract;
use Illuminate\Contracts\Pagination\Paginator;

class GroceryListRepository implements GroceryListRepositoryContract
{
    public function __construct(public GroceryList $model)
    {
    }

    /** @inheritDoc */
    public function create(string $name): GroceryList
    {
        return $this->model->newModelQuery()->create(['name' => $name]);
    }

    /** @inheritDoc */
    public function find(string $id): ?GroceryList
    {
        return $this->model->newModelQuery()->where('id', $id)->first();
    }

    /** @inheritDoc */
    public function getAll(bool $withTrashed = false, int $page = 1, int $perPage = 10): Paginator
    {
        $query = $this->model->newQuery();

        if ($withTrashed) {
            $query->withTrashed();
        }

        $query->orderBy('created_at', 'desc');

        return $query->simplePaginate(perPage: $perPage, page: $page);
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        $this->model->newQuery()->where('id', $id)->delete();
    }
}
