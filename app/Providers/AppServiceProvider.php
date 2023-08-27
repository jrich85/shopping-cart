<?php

namespace App\Providers;

use App\Repositories\Contracts\GroceryItemRepositoryContract;
use App\Repositories\Contracts\GroceryListRepositoryContract;
use App\Repositories\GroceryItemRepository;
use App\Repositories\GroceryListRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        GroceryListRepositoryContract::class => GroceryListRepository::class,
        GroceryItemRepositoryContract::class => GroceryItemRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
