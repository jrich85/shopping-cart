<?php

namespace Tests\Unit\Repositories;

use App\Models\Grocery;
use App\Models\GroceryList;
use App\Repositories\Contracts\GroceryItemRepositoryContract;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class GroceryItemRepositoryTest extends TestCase
{
    protected GroceryItemRepositoryContract $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = resolve(GroceryItemRepositoryContract::class);
    }

    /** @test */
    public function can_create_a_grocery_list_item(): void
    {
        $list = GroceryList::factory()->create(['name' => 'Uniforms']);

        $item = $this->repository->create(name: 'Sweater', groceryListId: $list->id);

        static::assertModelExists($item);
        static::assertSame('Sweater', $item->fresh()->name);
    }

    /** @test */
    public function can_get_all_items_for_a_list(): void
    {
        $list = GroceryList::factory()->create(['name' => 'Uniforms']);
        Grocery::factory(count:5)->create();
        $items = Grocery::factory(count: 4)->state(new Sequence(
            ['name' => 'Sweater'],
            ['name' => 'Socks'],
            ['name' => 'Helmet'],
            ['name' => 'Gloves'],
        ))->create(['grocery_list_id' => $list->id]);

        $itemNames = $items->pluck('name');

        $listItems = $this->repository->getAll($list->id);

        static::assertCount(4, $listItems);
        foreach ($listItems as $item) {
            static::assertContains($item->name, $itemNames);
        }
    }

}
