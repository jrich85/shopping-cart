<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGroceryListRequest extends FormRequest
{
    public function authorize(): bool
    {
        // todo: auth'z
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        $this->merge([
            'id' => $id,
        ]);

        return [
            'id' => 'required|exists:grocery_lists,id',
            'name' => ['required', Rule::unique('grocery_lists', 'name')->ignore($id)]
        ];
    }
}
