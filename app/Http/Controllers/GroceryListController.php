<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroceryListRequest;

class GroceryListController extends \App\Http\Controllers\Controller
{
    public function create(CreateGroceryListRequest $request)
    {


        return response()->json([], 204);
    }
}
