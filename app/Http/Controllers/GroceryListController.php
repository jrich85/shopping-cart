<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroceryListRequest;
use App\Http\Requests\DeleteGroceryListRequest;
use App\Http\Requests\GetGroceryListRequest;
use App\Http\Requests\GetPaginatedListRequest;
use App\Http\Requests\ReorderGroceriesRequest;
use App\Http\Requests\UpdateGroceryListRequest;
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

    public function update(UpdateGroceryListRequest $request)
    {
        $updatedList = $this->groceryListRepository->update($request->id, $request->name);

        return response()->json([$updatedList->toJson()], Response::HTTP_OK);
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

    public function delete(DeleteGroceryListRequest $request)
    {
        $this->groceryListRepository->delete($request->id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function reorder(ReorderGroceriesRequest $request)
    {

        $updatedList = $this->groceryListRepository->reorder($request->id, $request->order);

        return response()->json(['data' => $updatedList], Response::HTTP_OK);
    }
}
