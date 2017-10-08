<?php

namespace middlewares;

use core\Auth as Auth;

class AuthMiddleware
{
    public function __invoke($request, $response, $next)
    {
        if(Auth::user())
        {
            return $next($request, $response);
        }
        else
        {
            return $response = $response->withRedirect('/', 403);
        }
    }
}