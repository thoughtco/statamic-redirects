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

        $redirect = Entry::findByUri('/redirects/'.$url);

        if (!$redirect) {

            $redirect = Entry::whereCollection('redirects')
                ->where('from', '/redirects/'.$url)
                ->first();

            if (!$redirect)
                return $next($request);

        }

        return redirect($redirect->to, $redirect->code ?? 302);
    }
}
