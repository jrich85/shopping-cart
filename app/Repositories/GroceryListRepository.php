<?php

namespace App\Repositories;

use App\Models\GroceryList;
use App\Repositories\Contracts\GroceryListRepositoryContract;

class GroceryListRepository implements GroceryListRepositoryContract
{
    public GroceryList $model;

    /** @inheritDoc */
    public function create(string $name): GroceryList
    {
        return $this->model->newModelQuery()->create(['name' => $name]);
    }

}
