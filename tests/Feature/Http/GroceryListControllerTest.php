<?php

namespace Tests\Feature\Http;

use App\Models\Grocery;
use App\Models\GroceryList;
use Illuminate\Support\Str;
use Tests\TestCase;

class GroceryListControllerTest extends TestCase
{
    // region create

    /** @test */
    public function create_functionality_requires_a_name(): void
    {
        $this->postJson(route('grocery-list.create'), [])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name');
    }

    /** @test */
    public function create_functionality_requires_a_unique_name(): void
    {
        $existingList = GroceryList::factory()->create();

        $this->postJson(route('grocery-list.create'), ['name' => $existingList->name])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name');
    }

    /** @test */
    public function create_functionality_returns_the_new_model(): void
    {
        $this->postJson(route('grocery-list.create'), ['name' => 'Pro Shop'])
            ->assertOk()
            ->assertSeeText('Pro Shop');

    }

    // endregion create

    // region update

    /** @test */
    public function can_update_a_lists_name(): void
    {
        $list = GroceryList::factory()->create();

        $name = 'New name';

        $this->patchJson(route('grocery-list.update', [$list->id]), ['name' => $name])
            ->assertOk()
            ->assertSeeText($name);

        static::assertSame($name, $list->fresh()->name);
    }

    /** @test */
    public function a_lists_name_must_be_unique_when_updating(): void
    {
        GroceryList::factory()->create(['name' => $existingName = 'existing name']);
        $list = GroceryList::factory()->create();

        $this->patchJson(route('grocery-list.update', [$list->id]), ['name' => $existingName])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name');
    }

    /** @test */
    public function a_lists_own_name_is_not_considered_when_updating(): void
    {
        $list = GroceryList::factory()->create();

        $this->patchJson(route('grocery-list.update', [$list->id]), ['name' => $list->name])
            ->assertOk();
    }

    // endregion update

    // region get

    /** @test */
    public function get_is_unprocessable_if_route_id_is_not_found(): void
    {
        $this->getJson(route('grocery-list.get', Str::uuid()))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    /** @test */
    public function get_is_unprocessable_if_route_id_is_not_a_uuid(): void
    {
        $this->getJson(route('grocery-list.get', Str::random()))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    /** @test */
    public function can_get_a_grocery_list(): void
    {
        $list = GroceryList::factory()->create();

        $this->getJson(route('grocery-list.get', $list->id))
            ->assertOk()
            ->assertSeeText($list->name);
    }

    // endregion get

    // region getAll

    /** @test */
    public function get_all_returns_an_empty_collection_if_none_are_found(): void
    {
        $this->getJson(route('grocery-list.get-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /** @test */
    public function get_all_returns_a_paginated_collection(): void
    {
        GroceryList::factory(count: 15)->create();

        $this->getJson(route('grocery-list.get-all'))
            ->assertOk()
            ->assertJsonStructure([
                'current_page',
                'data' => [[
                    'id', 'name', 'created_at', 'updated_at', 'deleted_at',
                ]],
                'first_page_url',
                'from',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
            ]);
    }

    /** @test */
    public function get_all_returns_the_page_at_the_requested_size(): void
    {
        GroceryList::factory(count: 5)->create();

        $this->getJson(route('grocery-list.get-all').'?page=2&per_page=2')
            ->assertOk()
            ->assertJsonFragment([
                'current_page' => 2,
                'from' => 3,
                'to' => 4,
                'per_page' => 2,
            ]);
    }

    /** @test */
    public function get_all_returns_no_trashed_models_by_default(): void
    {
        GroceryList::factory(count: 5)->deleted()->create();

        $this->getJson(route('grocery-list.get-all'))
            ->assertOk()
            ->assertJsonFragment([
                'data' => [],
            ]);
    }

    /** @test */
    public function get_all_returns_trashed_models_when_requested(): void
    {
        GroceryList::factory(count: 5)->deleted()->create();

        $this->getJson(route('grocery-list.get-all').'?with_trashed=1')
            ->assertOk()
            ->assertJsonCount(5,'data');
    }

    // endregion getAll

    // region delete

    /** @test */
    public function can_delete_a_grocery_list(): void
    {
        $list = GroceryList::factory()->create();

        $this->deleteJson(route('grocery-list.delete', $list->id), ['id' => $list->id])
            ->assertNoContent();

        static::assertSoftDeleted($list);
    }

    // endregion delete

    // region reorder

    /** @test */
    public function can_reorder_a_list(): void
    {
        $list = GroceryList::factory()->create();
        [$item1, $item2] = Grocery::factory(count: 2)->create(['grocery_list_id' => $list->id]);

        $this->putJson(route('grocery-list.reorder', [$list->id]), ['order' => [$item2->id, $item1->id]])
            ->assertOk()
            ->assertJsonFragment([
                'id' => $item1->id,
                'order' => 1
            ])->assertJsonFragment([
                'id' => $item2->id,
                'order' => 0
            ]);

    }

    /** @test */
    public function must_supply_all_groceries_to_reorder(): void
    {
        $list = GroceryList::factory()->create();
        [$item1, $item2] = Grocery::factory(count: 2)->create(['grocery_list_id' => $list->id]);
        $item3 = Grocery::factory()->create();

        // not enough to reorder
        $this->putJson(route('grocery-list.reorder', [$list->id]), ['order' => [$item2->id]])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('order');

        // have enough, but the wrong ones.
        $this->putJson(route('grocery-list.reorder', [$list->id]), ['order' => [$item2->id, $item3->id]])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('order.1');
    }

    // endregion reorder

}
