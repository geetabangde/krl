<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Admin;

class AdminTokenToSession
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            $plainToken = substr($authHeader, 7);
            $token = PersonalAccessToken::findToken($plainToken);

            if ($token && $token->tokenable instanceof Admin) {
                auth()->guard('admin')->setUser($token->tokenable);
            }
        }

        return $next($request);
    }
}