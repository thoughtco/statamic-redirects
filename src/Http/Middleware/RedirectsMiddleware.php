<?php

namespace Thoughtco\Redirects\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Statamic\Facades\Entry;

class RedirectsMiddleware extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $url = $request->path();

        $redirect = Entry::query()
            ->where('collection', 'redirects')
            ->where('title', $url)
            ->first();

        if (!$redirect)
            return $next($request);

        return redirect($redirect->to, $redirect->get('code') ?? 302);
    }
}
