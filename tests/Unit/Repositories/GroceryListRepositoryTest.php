<?php

namespace Tests\Unit\Repositories;

use App\Repositories\Contracts\GroceryListRepositoryContract;
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
}
