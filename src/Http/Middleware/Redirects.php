<?php

namespace Thoughtco\Redirects\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Statamic\Facades\Entry;
use Statamic\Support\Str;

class Redirects extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $url = $request->path();

        $redirect = Entry::findByUri('/redirects/'.$url);

        if (!$redirect)
            return $next($request);

        return redirect($redirect->to, $redirect->code ?? 302);
    }
}
