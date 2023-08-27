<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\GetGroceryListRequest;
use App\Http\Requests\CreateGroceryListRequest;
use App\Repositories\Contracts\GroceryListRepositoryContract;
use Illuminate\Http\Response;

class GroceryListController extends Controller
{
    public function __construct(protected GroceryListRepositoryContract $groceryListRepository)
    {
    }

    public function create(CreateGroceryListRequest $request)
    {
        $newList = $this->groceryListRepository->create($request->name);

        return response()->json([$newList->toJson()], Response::HTTP_OK);
    }

    public function get(GetGroceryListRequest $request)
    {
        return response()->json($this->groceryListRepository->find($request->id), Response::HTTP_OK);
    }

}
