<?php

namespace App\Repositories\Contracts;

use App\Models\GroceryList;

interface GroceryListRepositoryContract
{
    /**
     * Creates a grocery list with the given name.
     *
     * @param string $name
     * @return GroceryList
     */
    public function create(string $name): GroceryList;
}
