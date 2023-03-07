<?php

namespace Mpietrucha\GoogleTagManager\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Mpietrucha\GoogleTagManager\Facade\GoogleTagManager;

class AddGoogleTagManagerFlashData
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionKey = config('google-tag-manager.sessionKey');

        if (session()->has($sessionKey)) {
            GoogleTagManager::set(session($sessionKey));
        }

        $response = $next($request);

        session()->flash($sessionKey, GoogleTagManager::getFlashData());

        return $response;
    }
}
