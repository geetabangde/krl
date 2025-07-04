<?php

// app/Http/Middleware/AuthenticateAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
         // Check if either admin OR employee guard is logged in
        if (!Auth::guard('admin')->check() && !Auth::guard('employee')->check()) {
            return redirect()->route('admin.login');
        }


        return $next($request);
    }
}

