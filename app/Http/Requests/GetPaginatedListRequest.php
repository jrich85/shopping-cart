<?php

namespace App\Http\Requests;

/**
 * GetPaginatedListRequest
 *
 * @property bool $with_trashed
 * @property int $page
 * @property int $per_page
 */
class GetPaginatedListRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize(): bool
    {
        // todo: auth'z
        return true;
    }

    public function rules(): array
    {
        $this->merge([
            'with_trashed' => (bool)$this->query('with_trashed', 0),
            'page' => (int)$this->query('page', 1),
            'per_page' => (int)$this->query('per_page', 10),
        ]);

        return [
            'with_trashed' => 'bool',
            'page' => 'int',
            'per_page' => 'int',
        ];
    }
}
