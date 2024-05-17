<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseApiResourceCollection;
use App\Http\Responses\BaseApiResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use OpenApi\Annotations as OA;

/**
 * Class BaseController
 * @package App\Http\Controllers
 *
 * @OA\Info(
 *     title="Library-API",
 *     version="1.0.0",
 *     description="API documentation for managing books in a library",
 *     @OA\Contact(
 *         email="admin@example.com",
 *         name="Admin"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="UnauthenticatedResponce",
 *     type="object",
 *     @OA\Property(property="message", type="string", example="Unauthenticated.", description="Unauthenticated message")
 * )
 */
abstract class BaseController extends Controller
{
    /**
     * Constant of the default API pagination.
     */
    public const int DEFAULT_API_PAGINATION = 10;

    /**
     * Base api response class (status, data , errors, notify).
     *
     * @var BaseApiResponse
     */
    protected BaseApiResponse $response;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->response = new BaseApiResponse();
    }

    /**
     * Respond with a resource.
     *
     * @param  mixed  $resource
     * @param  int  $statusCode
     * @return BaseApiResponse
     */
    protected function respondWithResource(JsonResource $resource, int $statusCode = Response::HTTP_OK): BaseApiResponse
    {
        return $this->response->data($resource)->setStatusCode($statusCode);
    }

    /**
     * Respond with a collection.
     *
     * @param  mixed  $collection
     * @param  int  $statusCode
     * @return BaseApiResponse
     */
    protected function respondWithCollection(
        BaseApiResourceCollection $collection,
        int $statusCode = Response::HTTP_OK
    ): BaseApiResponse {
        return $this->response->data($collection)->setStatusCode($statusCode);
    }

    /**
     * Respond with no content.
     *
     * @return BaseApiResponse
     */
    protected function respondWithNoContent(): BaseApiResponse
    {
        return $this->response->data(null)->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
