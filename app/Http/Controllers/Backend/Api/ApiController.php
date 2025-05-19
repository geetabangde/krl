<?php


namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'API is working!']);
    }

    public function profile(Request $request)
   {
        $admin = Auth::guard('admin-api')->user();

        if ($admin) {
            return response()->json([
                'status' => true,
                'message' => 'Profile fetched',
                'data' => $admin
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Not authenticated'
            ], 401);
        }
   }

   public function updateProfile(Request $request)
   {
       $admin = Auth::guard('admin-api')->user(); // ✅ fetch admin from token
   
       if (!$admin) {
           return response()->json([
               'status' => false,
               'message' => 'Unauthorized user'
           ], 401);
       }
   
       $validator = Validator::make($request->all(), [
           'name'  => 'sometimes|string|max:255',
           'email' => 'sometimes|email|max:255|unique:admins,email,' . $admin->id,
       ]);
   
       if ($validator->fails()) {
           return response()->json([
               'status' => false,
               'errors' => $validator->errors()
           ], 422);
       }
   
       // ✅ Update only if fields are present
       if ($request->has('name')) {
           $admin->name = $request->name;
       }
   
       if ($request->has('email')) {
           $admin->email = $request->email;
       }
   
       $admin->save();
   
       return response()->json([
           'status' => true,
           'message' => 'Profile updated successfully',
           'data' => $admin
       ], 200);
   }
}
