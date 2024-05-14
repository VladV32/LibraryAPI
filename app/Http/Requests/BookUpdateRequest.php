<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="BookUpdateRequest",
 *     description="Book update request body data",
 *     type="object",
 *     required={"id"},
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
class BookUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'word_count' => 'nullable|integer',
            'price' => 'nullable|numeric',
        ];
    }
}
