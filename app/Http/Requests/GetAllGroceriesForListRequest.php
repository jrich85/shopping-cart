<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * GetAllGroceriesForListRequest
 *
 * @property string $groceryListId
 */
class GetAllGroceriesForListRequest extends FormRequest
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
            'groceryListId' => 'exists:grocery_lists,id',
        ];

    }
}
