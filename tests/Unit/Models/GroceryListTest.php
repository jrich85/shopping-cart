<?php

namespace Tests\Unit\Models;

use App\Models\GroceryList;
use Illuminate\Support\Str;
use Tests\TestCase;

class GroceryListTest extends TestCase
{
    /** @test */
    public function can_create_a_grocery_list(): void
    {
        $groceryList = new GroceryList();
        $groceryList->name = 'Groceries';

        static::assertTrue($groceryList->save());
        static::assertModelExists($groceryList);
    }

    /** @test */
    public function can_create_a_grocery_list_with_factory(): void
    {
        $groceryList = GroceryList::factory()->create();
        static::assertModelExists($groceryList);
    }

    /** @test */
    public function deleted_factory_state_creates_a_trashed_model(): void
    {
        $groceryList = GroceryList::factory()->deleted()->create();

        static::assertModelExists($groceryList);
        static::assertSoftDeleted($groceryList);
    }
}
