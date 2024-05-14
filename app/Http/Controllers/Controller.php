<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseApiResponse;
use OpenApi\Annotations as OA;

/**
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
abstract class Controller
{
    protected BaseApiResponse $response;

    public function __construct()
    {
        $this->response = new BaseApiResponse();
    }
}
