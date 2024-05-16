<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * Class BookResourceCollection
 * @package App\Http\Resources
 *
 *
 * @OA\Schema(
 *     title="BookResourceCollection",
 *     description="Book resource collection schema",
 *     @OA\Property(
 *         property="books",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/BookResource")
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         ref="#/components/schemas/PaginationLinks"
 *     ),
 *     @OA\Property(
 *         property="meta",
 *         type="object",
 *         ref="#/components/schemas/PaginationMeta"
 *     )
 * )
 */
class BookResourceCollection extends BaseApiResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'books' => $this->collection->map->toArray($request),
            'links' => $this->getLinks($this->resource),
            'meta' => $this->getMeta($this->resource),
        ];
    }
}
