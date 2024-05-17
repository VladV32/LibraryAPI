<?php

namespace App\Http\Requests;

class ShowBookRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'book' => ['required', 'exists:books,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'book' => $this->route('book'),
        ]);
    }

    public function messages(): array
    {
        return [
            'book.exists' => trans('Book not found'),
        ];
    }
}