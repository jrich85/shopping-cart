<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * AddGroceryToListRequest
 *
 * @property string $name
 * @property string $groceryListId
 */
class AddGroceryToListRequest extends FormRequest
{
    public function authorize(): bool
    {
        // todo: auth'z
        return true;
    }

    public function rules(): array
    {
        $listId = $this->route('id');

        $this->merge(['groceryListId' => $listId]);

        return [
            'name' => [
                'bail',
                'required',
                Rule::unique('groceries', 'name')
                    ->whereNull('deleted_at')
                    ->where('grocery_list_id', $listId),
            ],
            'groceryListId' => 'exists:grocery_lists,id',
        ];
    }
}
