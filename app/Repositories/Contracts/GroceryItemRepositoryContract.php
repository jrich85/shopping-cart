<?php

namespace App\Repositories\Contracts;

use App\Models\Grocery;
use Illuminate\Support\Collection;

interface GroceryItemRepositoryContract
{
    /**
     * Create a new grocery item on the list provided.
     *
     * @param string $name
     * @param string $groceryListId
     * @return Grocery
     */
    public function create(string $name, string $groceryListId): Grocery;

    /**
     * Gets all grocery items for a list.
     *
     * @param string $groceryListId
     * @param bool $withTrashed
     * @return Collection<int, Grocery>
     */
    public function getAll(string $groceryListId, bool $withTrashed = false): Collection;
}
