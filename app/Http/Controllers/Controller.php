<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseApiResponse;

abstract class Controller
{
    protected BaseApiResponse $response;

    public function __construct()
    {
        $this->response = new BaseApiResponse();
    }
}
