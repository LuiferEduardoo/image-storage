<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new HttpException(403, 'Invalid token');
    }

    /**
     * Determine if the request is sending JSON.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function expectsJson(Request $request)
    {
        return $request->expectsJson() || $request->isJson();
    }
}
