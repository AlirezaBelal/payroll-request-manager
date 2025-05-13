<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role != $role && auth()->user()->role != 'super_admin') {
            abort(403, 'دسترسی غیرمجاز');
        }

        return $next($request);
    }
}
