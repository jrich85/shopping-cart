<?php

namespace Tests\Feature\Http;

use App\Models\Grocery;
use App\Models\GroceryList;
use Illuminate\Support\Str;
use Tests\TestCase;

class GroceryItemControllerTest extends TestCase
{
    // region create
    /** @test */
    public function create_functionality_requires_a_name_and_grocery_list_id(): void
    {
        // id is in the route, so supply a fake one
        $this->postJson(route('grocery-list.item.create', ['id' => Str::uuid()]), [])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name')
            ->assertJsonValidationErrorFor('groceryListId');
    }

    /** @test */
    public function create_functionality_requires_a_unique_name_within_the_list(): void
    {
        $list = GroceryList::factory()->create();

        $name = 'name';
        // on different list
        Grocery::factory()->create(['name' => $name]);

        $this->postJson(route('grocery-list.item.create', ['id' => $list->id]), [
            'name' => $name,
        ])->assertOk();

        $this->postJson(route('grocery-list.item.create', ['id' => $list->id]), [
            'name' => $name,
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('name');
    }

    /** @test */
    public function create_functionality_returns_the_new_model(): void
    {
        $list = GroceryList::factory()->create();

        $this->postJson(route('grocery-list.item.create', ['id' => $list->id]), ['name' => 'Bananas'])
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'name',
                'grocery_list_id',
                'created_at',
                'updated_at',
            ])
            ->assertSeeText('Bananas');

    }

    // endregion create

    // region getAll

    /** @test */
    public function can_get_all_items_in_a_grocery_list(): void
    {
        $list = GroceryList::factory()->create();

        Grocery::factory(count: 20)->create();
        Grocery::factory(count: 10)->create(['grocery_list_id' => $list->id]);

        $this->getJson(route('grocery-list.items.get-all', ['id' => $list->id]))
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure(['data' => [[
                'id',
                'name',
                'grocery_list_id',
                'created_at',
                'updated_at',
            ]]]);

    }
    // endregion getAll
}
