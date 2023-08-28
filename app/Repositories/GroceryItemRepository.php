<?php

namespace App\Repositories;

use App\Models\Grocery;
use App\Repositories\Contracts\GroceryItemRepositoryContract;
use Illuminate\Support\Collection;

class GroceryItemRepository implements GroceryItemRepositoryContract
{
    public function __construct(public Grocery $model)
    {
    }

    /** @inheritDoc */
    public function create(string $name, string $groceryListId): Grocery
    {
        $currentCount = $this->model->where('grocery_list_id', $groceryListId)->count();

        return $this->model->newModelQuery()->create([
            'name' => $name,
            'grocery_list_id' => $groceryListId,
            'order' => $currentCount,
        ]);
    }

    /** @inheritDoc */
    public function update(string $groceryListId, string $id, string $name): Grocery
    {
        $grocery = $this->model->newModelQuery()
            ->where('id', $id)
            ->where('grocery_list_id', $groceryListId)
            ->firstOrFail();

        $grocery->update([
            'name' => $name,
        ]);

        return $grocery;
    }

    /** @inheritDoc */
    public function getAll(string $groceryListId, bool $withTrashed = false): Collection
    {
        $query = $this->model->newQuery()
            ->where('grocery_list_id', $groceryListId);

        if ($withTrashed) {
            $query->withTrashed();
        }

        $query->orderBy('order');

        return $query->get();
    }

    /** @inheritDoc */
    public function delete(string $listId, string $id): void
    {
        $this->model->newQuery()->where('grocery_list_id', $listId)
            ->where('id', $id)->delete();
    }

}
