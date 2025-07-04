<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Admin;

class AdminTokenSession
{
    public function handle(Request $request, Closure $next)
    {
        // Agar admin already login hai to aage badh jao
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // URL me ?token=XYZ123 se token nikalo
        $token = $request->query('token') ?? $request->bearerToken();

        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);

            // Token valid hai aur wo Admin ka hai
            if ($accessToken && $accessToken->tokenable_type === Admin::class) {
                $admin = $accessToken->tokenable;
                // Laravel session me login karwa do
                Auth::guard('admin')->login($admin);
            }
        }

        return $next($request);
    }
}
