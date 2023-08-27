<?php

namespace App\Repositories\Contracts;

use App\Models\GroceryList;
use Illuminate\Contracts\Pagination\Paginator;

interface GroceryListRepositoryContract
{
    /**
     * Creates a grocery list with the given name.
     *
     * @param string $name
     * @return GroceryList
     */
    public function create(string $name): GroceryList;

    /**
     * Updates the grocery list with the new name
     *
     * @param string $id
     * @param string $name
     * @return GroceryList
     */
    public function update(string $id, string $name): GroceryList;

    /**
     * Search for a grocery list by its id.
     *
     * @param string $id
     * @return GroceryList|null
     */
    public function find(string $id): ?GroceryList;

    /**
     * Get a paginated list of all the grocery lists. Optionally include trashed models.
     *
     * @param bool $withTrashed
     * @return Paginator
     */
    public function getAll(bool $withTrashed=false): Paginator;

    /**
     * Soft-delete a specific grocery list, by id.
     *
     * @param string $id
     * @return void
     */
    public function delete(string $id): void;

}
