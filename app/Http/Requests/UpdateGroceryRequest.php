<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * UpdateGroceryRequest
 *
 * @property string $listId
 * @property string $id
 * @property string $name
 */
class UpdateGroceryRequest extends FormRequest
{

    public function rules(): array
    {
        $listId = $this->route('listId');
        $id = $this->route('id');

        $this->merge([
            'listId' => $listId,
            'id' => $id,
        ]);

        return [
            'listId' => 'required|exists:grocery_lists,id',
            'id' => ['required', Rule::exists('groceries', 'id')->where('grocery_list_id', $listId)],
            'name' => ['required', Rule::unique('groceries', 'name')->where('grocery_list_id', $listId)->ignore($id)]
        ];
    }
}
