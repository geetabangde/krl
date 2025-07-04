<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthenticateAdminOrEmployee
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check() || Auth::guard('employee')->check()) {
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}

