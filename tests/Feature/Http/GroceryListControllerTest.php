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

    // endregion getAll
}
