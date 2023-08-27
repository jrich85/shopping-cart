<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddGroceryToListRequest;
use App\Http\Requests\DeleteGroceryRequest;
use App\Http\Requests\GetAllGroceriesForListRequest;
use App\Http\Requests\UpdateGroceryRequest;
use App\Repositories\Contracts\GroceryItemRepositoryContract;
use Illuminate\Http\Response;

class GroceryItemController extends Controller
{
    public function __construct(protected GroceryItemRepositoryContract $repository)
    {
    }

    public function create(AddGroceryToListRequest $request)
    {
        return response()->json(
            $this->repository->create($request->name, $request->groceryListId),
            Response::HTTP_OK
        );
    }

    public function update(UpdateGroceryRequest $request)
    {
        $updatedItem = $this->repository->update($request->listId, $request->id, $request->name);

        return response()->json([$updatedItem->toJson()], Response::HTTP_OK);

    }

    public function getAll(GetAllGroceriesForListRequest $request)
    {
        return response()->json(
            ['data' => $this->repository->getAll($request->groceryListId)],
            Response::HTTP_OK
        );
    }

    public function delete(DeleteGroceryRequest $request)
    {
        $this->repository->delete($request->listId, $request->id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
