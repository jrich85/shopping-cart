<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CreateGroceryListRequest
 *
 * @property string $name
 */
class CreateGroceryListRequest extends FormRequest
{
    public function authorize(): bool
    {
        // todo: auth'z
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|unique:grocery_lists,name'
        ];
    }

    /** @inheritDoc */
    public function messages(): array
    {
        return [
            'name' => [
                'unique' => 'A list already exists with this name.',
            ]
        ];
    }
}
