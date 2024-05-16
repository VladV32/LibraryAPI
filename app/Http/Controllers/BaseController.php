<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseApiResponse;
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
     * @OA\Schema(
     *      schema="UnauthenticatedResponce",
     *      type="object",
     *      @OA\Property(property="message", type="string", example="Unauthenticated", description="Unauthenticated message")
     * )
     */
}
