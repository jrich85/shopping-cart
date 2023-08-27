<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * DeleteGroceryRequest
 *
 * @property string $id
 * @property string $listId
 */
class DeleteGroceryRequest extends FormRequest
{
    public function authorize(): bool
    {
        // todo: auth'z
        return true;
    }

    public function rules(): array
    {
        $listId = $this->input('listId');

        return [
            'id' => Rule::exists('groceries', 'id')
                ->where('grocery_list_id', $listId),
            'listId' => 'exists:grocery_lists,id',
        ];

    }
}
