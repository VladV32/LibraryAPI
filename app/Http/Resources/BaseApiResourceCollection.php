<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use OpenApi\Annotations as OA;

/**
 * Base API collection class for paginated response.
 *
 * Class BaseApiResourceCollection
 * @package App\Http\Resources
 *
 * @OA\Schema(
 *     schema="PaginationLinks",
 *     description="Pagination links schema",
 *     @OA\Property(
 *         property="first",
 *         type="string",
 *         description="First page"
 *     ),
 *     @OA\Property(
 *         property="last",
 *         type="string",
 *         description="Last page"
 *     ),
 *     @OA\Property(
 *         property="prev",
 *         type="string",
 *         description="Previous page"
 *     ),
 *     @OA\Property(
 *         property="next",
 *         type="string",
 *         description="Next page"
 *     ),
 *     @OA\Property(
 *         property="current",
 *         type="integer",
 *         description="Current page number"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     description="Pagination meta schema",
 *     @OA\Property(
 *         property="total",
 *         type="integer",
 *         description="Total number of items"
 *     ),
 *     @OA\Property(
 *         property="per_page",
 *         type="integer",
 *         description="Number of items per page"
 *     ),
 *     @OA\Property(
 *         property="current_page",
 *         type="integer",
 *         description="Current page number"
 *     ),
 *     @OA\Property(
 *         property="last_page",
 *         type="integer",
 *         description="Last page number"
 *     ),
 *     @OA\Property(
 *         property="from",
 *         type="integer",
 *         description="Index of the first item in the current page"
 *     ),
 *     @OA\Property(
 *         property="to",
 *         type="integer",
 *         description="Index of the last item in the current page"
 *     )
 * )
 *
 * @OA\Schema(
 *      schema="Filters",
 *      type="array",
 *      @OA\Items(example="attributesNameCanFiltration")
 *  )
 */
abstract class BaseApiResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $dirtyData = $this->resource->toArray();

        if (isset($dirtyData['data'])) {
            $response = [
                'items' => $dirtyData['data'],
                'links' => $this->getLinks($this->resource),
                'meta' => $this->getMeta($this->resource)
            ];

            if ($filters = $this->getFilters($this->resource)) {
                $response['filters'] = $filters;
            }

            return $response;
        } else {
            return parent::toArray($request);
        }
    }

    /**
     * @param  mixed  $resource
     * @return array|null
     *
     */
    public function getFilters(mixed $resource): ?array
    {
        $items = $resource->items();

        if (isset($items[0]) && method_exists($items[0]->resource, 'getFilters')) {
            return $items[0]->resource->getFilters();
        }

        return null;
    }

    /**
     * Get meta data from serialized paginator.
     *
     * @param  LengthAwarePaginator  $data
     * @return array
     */
    protected function getMeta(LengthAwarePaginator $data): array
    {
        return [
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
        ];
    }

    /**
     * Return links from paginator.
     *
     * @param  LengthAwarePaginator  $data
     * @return array
     */
    protected function getLinks(LengthAwarePaginator $data): array
    {
        return [
            'first' => $data->url(1),
            'last' => $data->url($data->lastPage()),
            'prev' => $data->previousPageUrl(),
            'next' => $data->nextPageUrl(),
            'current' => $data->currentPage()
        ];
    }
}
