<?php

namespace App\Http\Middleware;

/**
 * This file is part of Laratrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Laratrust
 */

use Illuminate\Support\Facades\Config;
use Closure;
use Laratrust\Middleware\LaratrustMiddleware;

class LaratrustPermission extends LaratrustMiddleware
{
    /**
     * Handle incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure $next
     * @param  string  $permissions
     * @param  string|null  $team
     * @param  string|null  $options
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions, $team = null, $options = '')
    {
//        if($permissions != "read-admin-panel")
//        d(
//            AuthUser()->email ,
//            Support(),
//            'permissions', $permissions, $team, $options,
//            Config::get('laratrust.middleware.handling', 'abort'),
//            Config::get('laratrust.middleware.params', '403')
//        );
        if (Support()) {
            return $next($request);
        }

//        d(
//            AuthUser()->email ,
//            User()->cant($permissions),
//            !Support() && !$this->authorization('permissions', $permissions, $team, $options),
//            $permissions,
//            $team,
//            $options
//        );
        if ($this->authorization('permissions', $permissions, $team, $options)) {
            return call_user_func(
                Config::get('laratrust.middleware.handling', 'abort'),
                Config::get('laratrust.middleware.params', '403')
            );
//            return $this->unauthorized();
        }

        return $next($request);
    }
}
