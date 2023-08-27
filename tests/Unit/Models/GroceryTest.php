<?php

namespace Tests\Unit\Models;

use App\Models\Grocery;
use App\Models\GroceryList;
use Tests\TestCase;

class GroceryTest extends TestCase
{
    // region creation

    /** @test */
    public function can_create_a_grocery_list(): void
    {
        $list = GroceryList::factory()->create();
        $grocery = new Grocery();
        $grocery->name = 'Apple';
        $grocery->grocery_list_id = $list->id;

        static::assertTrue($grocery->save());
        static::assertModelExists($grocery);
    }

    /** @test */
    public function can_create_a_grocery_list_with_factory(): void
    {
        $grocery = Grocery::factory()->create();
        static::assertModelExists($grocery);
    }

    // endregion creation

    // region relationships

    /** @test */
    public function belongs_to_a_grocery_list(): void
    {
        $list = GroceryList::factory()->create();
        $grocery = Grocery::factory()->create(['grocery_list_id' => $list->id]);

        static::assertSame($list->id, $grocery->groceryList->id);
    }

    // endregion relationships
}
