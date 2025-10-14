<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Voucher;
use App\Models\LedgerMaster;
use App\Models\Group;
use App\Models\VoucherPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherListController extends Controller
{
    public function index()
    {   
        $groups = \App\Models\Group::all();
        // for easier use in the view/JS.
    $permissions = \App\Models\VoucherPermission::all();
    
    $voucherPermissions = [];
    foreach ($permissions as $permission) {
        $voucherPermissions[$permission->voucher_type][$permission->type] = $permission->group_id;
    }

        // return($groups);
        return view('admin.voucherList.index', compact('groups','voucherPermissions'));
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $validated = $request->validate([
            'voucher_type' => 'required|string',
            // Corrected: The field name is 'permission_type' in the frontend JS
            'permission_type' => 'required|string|in:from,to', 
            // Corrected: Expects an array of group IDs, and each must exist in the groups table
            'group_id' => 'required|array', 
            'group_id.*' => 'exists:groups,id', 
        ]);

        try {
            // 2. Implode the array of group IDs into a comma-separated string
            $groups_string = implode(',', array_unique($validated['group_id']));
            
            // 3. Update or Create the permission record
            VoucherPermission::updateOrCreate(
                [
                    'voucher_type' => $validated['voucher_type'],
                    'permission_type' => $validated['permission_type'] // Use the correct field name
                ],
                [
                    // Save the comma-separated string to the database
                    'group_id' => $groups_string 
                ]
            );

            // Return a JSON response for the frontend fetch call
            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully!',
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Voucher Permission Update Error: ' . $e->getMessage()); 
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update permission.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePermission(Request $request)
    {
        $validated = $request->validate([
            'voucher_type' => 'required|string',
            'edit_type' => 'required|string|in:from,to',
            'group_id' => 'required|exists:groups,id',
        ]);

        VoucherPermission::updateOrCreate(
            [
                'voucher_type' => $validated['voucher_type'],
                'permission_type' => $validated['edit_type']
            ],
            [
                'group_id' => $validated['group_id']
            ]
        );

        return back()->with('success','Permission updated successfully!');
    }

  
}
  

 
