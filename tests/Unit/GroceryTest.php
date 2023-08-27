<?php

namespace Tests\Unit;

use App\Models\Grocery;
use App\Models\GroceryList;
use Tests\TestCase;

class GroceryTest extends TestCase
{
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

}
