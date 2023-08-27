<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * DeleteGroceryListRequest
 *
 * @property string $id
 */
class DeleteGroceryListRequest extends FormRequest
{
    public function authorize(): bool
    {
        // todo: auth'z
        return true;
    }

    public function rules(): array
    {
        $listId = $this->route('id');

        $this->merge(['id', $listId]);

        return [
            'id' => 'bail|required|exists:grocery_lists,id',
        ];
    }
}
