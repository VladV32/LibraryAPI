<?php

namespace App\Http\Requests;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="UpdateBookRequest",
 *     description="Book update request body data",
 *     type="object",
 *     required={"book"},
 *     @OA\Property(
 *         property="title",
 *         description="Book title",
 *         type="string",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="publisher",
 *         description="Book publisher",
 *         type="string",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="author",
 *         description="Book author",
 *         type="string",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="genre",
 *         description="Book genre",
 *         type="string",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="publication_date",
 *         description="Publication date of the book",
 *         type="string",
 *         format="date"
 *     ),
 *     @OA\Property(
 *         property="word_count",
 *         description="Word count of the book",
 *         type="integer",
 *         format="int64"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         description="Price of the book",
 *         type="number",
 *         format="float"
 *     )
 * )
 */
class UpdateBookRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book' => 'required|exists:books,id',
            'title' => 'required_if:title,!=,|string|min:1|max:255',
            'publisher' => 'required_if:publisher,!=,|string|min:1|max:255',
            'author' => 'required_if:author,!=,|string|min:1|max:255',
            'genre' => 'required_if:genre,!=,|string|min:1|max:255',
            'publication_date' => 'required_if:publication_date,!=,|date',
            'word_count' => 'required_if:word_count,!=,|integer',
            'price' => 'required_if:price,!=,|numeric',
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
