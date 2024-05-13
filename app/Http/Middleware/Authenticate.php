<?php

namespace App\Http\Middleware;

use App\Http\Responses\BaseApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next): BaseApiResponse
    {
        if (Auth::check()) {
            return $next($request);
        }

        $response = new BaseApiResponse();
        return $response->error('Unauthorized', null, null, 401);
    }
}
