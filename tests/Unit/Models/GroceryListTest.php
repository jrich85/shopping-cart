<?php

namespace Tests\Unit\Models;

use App\Models\Grocery;
use App\Models\GroceryList;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GroceryListTest extends TestCase
{
    // region creation

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

    // endregion creation

    // region relationships

    /** @test  */
    public function has_many_groceries(): void
    {
        $list = GroceryList::factory()->create();
        Grocery::factory(count: 5)->create();
        /** @var Collection<int, Grocery> $groceries */
        $groceries = Grocery::factory(count: 5)
            ->create(['grocery_list_id' => $list->id]);

        $groceries = $groceries->keyBy('id');

        static::assertCount(5, $list->fresh()->groceries);
        foreach ($list->groceries as $grocery) {
            static::assertArrayHasKey($grocery->id, $groceries);
        }
    }

    // endregion relationships
}
