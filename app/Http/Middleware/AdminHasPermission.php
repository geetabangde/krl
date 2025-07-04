<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class AdminHasPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Check admin or employee guard
        $user = auth()->guard('admin')->user() ?? auth()->guard('employee')->user();

        if (!$user) {
            abort(403, 'Unauthorized'); // Neither admin nor employee authenticated
        }

        // Assuming $user->role contains role id or relationship
        $roleId = $user->role;

        // Find role
        $role = Role::find($roleId);

        if (!$role || !method_exists($role, 'permission')) {
            abort(403, 'Role or permissions not configured');
        }

        // Check if role has the required permission
        if (!$role->permission->pluck('name')->contains($permission)) {
            abort(403, 'Permission denied');  
        }

        return $next($request);
    }
}
