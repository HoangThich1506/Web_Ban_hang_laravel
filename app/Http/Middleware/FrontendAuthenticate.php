<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontendAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('frontend_auth')) {
            return redirect()
                ->route('site.login')
                ->with('error', 'Vui long dang nhap de tiep tuc thanh toan.');
        }

        return $next($request);
    }
}
