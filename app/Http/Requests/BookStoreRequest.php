<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="BookStoreRequest",
 *      description="Book store request schema",
 *      type="object",
 *      required={"title", "publisher", "author", "genre", "publication_date", "word_count", "price"},
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          example="Sample Book"
 *      ),
 *      @OA\Property(
 *          property="publisher",
 *          type="string",
 *          example="Publisher Name"
 *      ),
 *      @OA\Property(
 *          property="author",
 *          type="string",
 *          example="Author Name"
 *      ),
 *      @OA\Property(
 *          property="genre",
 *          type="string",
 *          example="Fiction"
 *      ),
 *      @OA\Property(
 *          property="publication_date",
 *          type="string",
 *          format="date",
 *          example="2022-01-01"
 *      ),
 *      @OA\Property(
 *          property="word_count",
 *          type="integer",
 *          example=50000
 *      ),
 *      @OA\Property(
 *          property="price",
 *          type="number",
 *          format="float",
 *          example=25.99
 *      )
 * )
 */
class BookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'word_count' => 'required|integer',
            'price' => 'required|numeric',
        ];
    }
}
