<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroceryListRequest;
use App\Http\Requests\GetGroceryListRequest;
use App\Http\Requests\GetPaginatedListRequest;
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

    public function getAll(GetPaginatedListRequest $request)
    {
        return response()->json($this->groceryListRepository->getAll(
            withTrashed: $request->with_trashed,
            page: $request->page,
            perPage: $request->per_page
        ), Response::HTTP_OK);
    }

}
