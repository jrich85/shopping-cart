<?php

use App\Http\Controllers\GroceryItemController;
use App\Http\Controllers\GroceryListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('grocery-list')->group(function () {

    // region grocery lists

    Route::get('/', [GroceryListController::class, 'getAll'])->name('grocery-list.get-all');
    Route::post('/', [GroceryListController::class, 'create'])->name('grocery-list.create');
    Route::patch('/{id}', [GroceryListController::class, 'update'])->name('grocery-list.update');
    Route::put('/{id}/items', [GroceryListController::class, 'reorder'])->name('grocery-list.reorder');
    Route::delete('/{id}', [GroceryListController::class, 'delete'])->name('grocery-list.delete');
    Route::get('/{id}', [GroceryListController::class, 'get'])->name('grocery-list.get');

    // endregion grocery lists

    // region grocery items

    Route::get('/{id}/items', [GroceryItemController::class, 'getAll'])->name('grocery-list.items.get-all');
    Route::post('/{id}/items', [GroceryItemController::class, 'create'])->name('grocery-list.item.create');
    Route::patch('/{listId}/items/{id}', [GroceryItemController::class, 'update'])->name('grocery-list.item.update');
    Route::delete('/{listId}/items/{id}', [GroceryItemController::class, 'delete'])->name('grocery-list.item.delete');

    // endregion grocery items
});
