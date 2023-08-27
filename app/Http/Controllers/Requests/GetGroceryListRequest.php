<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * GetGroceryListRequest
 *
 * @property string $id
 */
class GetGroceryListRequest extends FormRequest
{
    public function authorize(): bool
    {
        // todo: auth'z
        return true;
    }

    public function rules(): array
    {
        $this->merge(['id' => $this->route('id')]);

        return [
            'id' => 'bail|required|string|uuid|exists:grocery_lists,id',
        ];
    }
}
