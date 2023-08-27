<?php

namespace Tests\Unit\Repositories;

use App\Models\Grocery;
use App\Models\GroceryList;
use App\Repositories\Contracts\GroceryListRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;

class GroceryListRepositoryTest extends TestCase
{
    protected GroceryListRepositoryContract $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = resolve(GroceryListRepositoryContract::class);
    }

    /** @test */
    public function can_create_a_grocery_list(): void
    {
        $groceryList = $this->repository->create(name: 'Uniforms');
        static::assertModelExists($groceryList);
        static::assertSame('Uniforms', $groceryList->fresh()->name);
    }

    /** @test */
    public function can_update_a_grocery_lists_name(): void
    {
        $groceryList = $this->repository->create(name: 'Uniforms');

        $this->repository->update(id: $groceryList->id, name: 'New Uniforms');

        static::assertSame('New Uniforms', $groceryList->fresh()->name);
    }

    /** @test */
    public function can_find_a_grocery_list_by_id(): void
    {
        /** @var Collection<int, GroceryList> $groceryLists */
        $groceryLists = GroceryList::factory(count: 5)->create();

        $expectedGroceryList = $groceryLists->random();

        $actualGroceryList = $this->repository->find($expectedGroceryList->id);

        static::assertNotEmpty($actualGroceryList);
        static::assertSame($expectedGroceryList->id, $actualGroceryList->id);
    }

    /** @test */
    public function null_value_is_returned_if_id_is_not_found(): void
    {
        static::assertNull($this->repository->find(Str::uuid()));
    }

    /** @test */
    public function can_delete_a_grocery_list(): void
    {
        $list = GroceryList::factory()->create();
        Grocery::factory(count: 5)->create(['grocery_list_id' => $list->id]);

        $this->repository->delete($list->id);

        static::assertSoftDeleted($list);
    }
}
