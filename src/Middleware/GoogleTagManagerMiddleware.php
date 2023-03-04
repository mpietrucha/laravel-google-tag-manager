<?php

namespace Mpietrucha\GoogleTagManager\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mpietrucha\GoogleTagManager\Facade\GoogleTagManager;

class GoogleTagManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionKey = config('googletagmanager.sessionKey');

        if (session()->has($sessionKey)) {
            GoogleTagManager::set(session($sessionKey));
        }

        $response = $next($request);

        session()->flash($sessionKey, GoogleTagManager::getFlashData());

        return $response;
    }
}
