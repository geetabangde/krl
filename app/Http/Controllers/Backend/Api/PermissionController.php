<?php
namespace App\Http\Controllers\Backend\Api;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
 public function modulesPermission(Request $request)
{
    $user = auth()->user();
    $roleId = $user->role;

    $role = Role::find($roleId);

    if (!$role) {
        return response()->json(['error' => 'Role not found'], 404);
    }

    
    $permissions = $role->permissions
        ->pluck('name')
        ->filter(function ($permission) {
            return str_starts_with($permission, 'manage');
        })
        ->values(); 

    return response()->json([
        'message' => 'Modues permissions fetched successfully',
        'role_id' => $roleId,
        'permissions' => $permissions
    ]);
}

}
