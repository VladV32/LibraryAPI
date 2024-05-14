<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="BookResource",
 *     description="Book resource",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the book",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the book",
 *         example="Sample Book"
 *     ),
 *     @OA\Property(
 *         property="publisher",
 *         type="string",
 *         description="Publisher of the book",
 *         example="Publisher Name"
 *     ),
 *     @OA\Property(
 *         property="author",
 *         type="string",
 *         description="Author of the book",
 *         example="Author Name"
 *     ),
 *     @OA\Property(
 *         property="genre",
 *         type="string",
 *         description="Genre of the book",
 *         example="Fiction"
 *     ),
 *     @OA\Property(
 *         property="publication_date",
 *         type="string",
 *         description="Publication date of the book",
 *         format="date-time",
 *         example="2022-01-01T00:00:00.000000Z"
 *     ),
 *     @OA\Property(
 *         property="word_count",
 *         type="integer",
 *         description="Word count of the book",
 *         example=50000
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="Price of the book",
 *         example=25.99
 *     )
 * )
 */
class BookResource extends JsonResource
{
    /**
     * BookResource constructor.
     *
     * @param  Book  $resource
     */
    public function __construct(Book $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'publisher' => $this->resource->publisher,
            'author' => $this->resource->author,
            'genre' => $this->resource->genre,
            'publication_date' => $this->resource->publication_date->toISOString(),
            'word_count' => $this->resource->word_count,
            'price' => $this->resource->price,
        ];
    }
}
