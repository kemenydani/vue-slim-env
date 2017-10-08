<?php

namespace middlewares;

use core\Auth as Auth;
use core\Role as Role;

class RoleMiddleware
{
    private $args = null;

    public function __construct($args)
    {
        // TODO: array of permissions or role
        $this->$args = $args;
    }

    public function __invoke($request, $response, $next)
    {
        // TODO: get the roles of the user  and match them against the middleware param
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