<?php

namespace App\Http\Requests;

use App\Repositories\Contracts\GroceryListRepositoryContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * ReorderGroceriesRequest
 *
 * @property string $id
 * @property array $order
 */
class ReorderGroceriesRequest extends FormRequest
{
    public function authorize()
    {
        // todo: auth'z
        return true;
    }

    public function rules()
    {
        $listRepository = resolve(GroceryListRepositoryContract::class);

        $listId = $this->route('id');
        $this->merge([
            'id' => $listId,
        ]);

        $currentCount = $listRepository->find($listId)->groceries()->count();

        return [
            'id' => 'required|exists:grocery_lists,id',
            'order' => 'required|array|size:'.$currentCount,
            'order.*' => ['required', Rule::exists('groceries', 'id')->where('grocery_list_id', $listId)]
        ];
    }
}
