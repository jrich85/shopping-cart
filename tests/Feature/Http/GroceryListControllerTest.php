<?php

namespace Tests\Feature\Http;

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

    // region get

    /** @test */
    public function get_is_unprocessable_if_route_id_is_not_found(): void
    {
        $this->postJson(route('grocery-list.get', Str::uuid()))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    /** @test */
    public function get_is_unprocessable_if_route_id_is_not_a_uuid(): void
    {
        $this->postJson(route('grocery-list.get', Str::random()))
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
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
}
