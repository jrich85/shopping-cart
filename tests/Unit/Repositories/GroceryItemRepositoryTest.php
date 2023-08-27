<?php

namespace Tests\Unit\Repositories;

use App\Models\Grocery;
use App\Models\GroceryList;
use App\Repositories\Contracts\GroceryItemRepositoryContract;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
    public function can_update_a_grocery_list_items_name(): void
    {
        $list = GroceryList::factory()->create(['name' => 'Uniforms']);
        $grocery = Grocery::factory()->create(['grocery_list_id' => $list->id]);

        $name = 'New name';

        $this->repository->update(groceryListId: $list->id, id: $grocery->id, name: $name);

        static::assertSame($name, $grocery->fresh()->name);
    }

    /** @test */
    public function item_must_be_in_list_to_be_updated(): void
    {
        $list = GroceryList::factory()->create(['name' => 'Uniforms']);
        $grocery = Grocery::factory()->create(['grocery_list_id' => $list->id]);

        $name = 'New name';

        $this->expectException(ModelNotFoundException::class);
        $this->repository->update(groceryListId: Str::uuid(), id: $grocery->id, name: $name);
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

    /** @test */
    public function can_delete_a_grocery_list_item(): void
    {
        $list = GroceryList::factory()->create();
        /** @var Collection<int, Grocery> $groceries */
        $groceries = Grocery::factory(count: 5)->create(['grocery_list_id' => $list->id]);

        $grocery = $groceries->random();

        $this->repository->delete($list->id, $grocery->id);

        static::assertSoftDeleted($grocery);
        static::assertCount(4, $list->fresh()->groceries);
    }

    /** @test */
    public function grocery_list_item_must_be_in_list_to_delete(): void
    {
        $list = GroceryList::factory()->create();
        /** @var Collection<int, Grocery> $groceries */
        $groceries = Grocery::factory(count: 5)->create(['grocery_list_id' => $list->id]);

        $grocery = $groceries->random();

        $this->repository->delete(Str::uuid(), $grocery->id);

        static::assertNotSoftDeleted($grocery);
        static::assertCount(5, $list->fresh()->groceries);
    }
}
