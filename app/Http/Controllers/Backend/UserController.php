<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage customer', only: ['index']),
            new Middleware('admin.permission:create customer', only: ['create']),
            new Middleware('admin.permission:edit customer', only: ['edit']),
            new Middleware('admin.permission:delete customer', only: ['destroy']),
        ];
    }
    public function index()
    {   
      $users = User::all();
      $groups = Group::with('parent')->get();
      
      return view('admin.users.index', compact('users','groups')); 
    }

    public function edit($id)
   {
    $user = User::findOrFail($id);
    
    $groups = Group::all();
   // Decode the address JSON string to array
    $addresses = json_decode($user->address, true);

    return view('admin.users.edit', compact('user', 'groups', 'addresses'));
  }


    // Store category data
    public function store(Request $request)
   {
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required', 
        'password' => 'required', 
        'pan_number' => 'nullable|string',
        'tan_number' => 'nullable|string',
        'deductor' => 'nullable|string',
        'group_id' => 'required|integer|exists:groups,id',
        'address' => 'nullable|array',
        'address.*.city' => 'nullable|string',
        'address.*.gstin' => 'nullable|string',
        'address.*.billing_address' => 'nullable|string',
        'address.*.consignment_address' => 'nullable|string',
        'address.*.mobile_number' => 'nullable|string',
        'address.*.poc' => 'nullable|string',
        'address.*.email' => 'nullable|string|email',
    ]);

    $user = new User();

    $user->name = $validated['name'];
    $user->email = $validated['email']; 
    $user->password = Hash::make($validated['password']); 
    $user->pan_number = $validated['pan_number'] ?? null;
    $user->tan_number = $validated['tan_number'] ?? null;
    $user->deductor = $validated['deductor'] ?? null;
    $user->group_id = $validated['group_id'];
    $user->address = $validated['address'] ?? [];

    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'User added successfully!');
}



   
   public function show($id)
  {
    $user = User::findOrFail($id);
    return view('admin.users.view', compact('user'));
  }

 

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required',
        'pan_number' => 'nullable|string',
        'tan_number' => 'nullable|string',
        'deductor' => 'nullable|string',
        'group_id' => 'required|integer|exists:groups,id',
        'address' => 'nullable|array',
        'address.*.city' => 'nullable|string',
        'address.*.gstin' => 'nullable|string',
        'address.*.billing_address' => 'nullable|string',
        'address.*.consignment_address' => 'nullable|string',
        'address.*.mobile_number' => 'nullable|string',
        'address.*.poc' => 'nullable|string',
        'address.*.email' => 'nullable|string|email',
    ]);

    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email; 
    $user->pan_number = $request->pan_number;
    $user->tan_number = $request->tan_number;
    $user->deductor = $request->deductor;
    $user->group_id = $request->group_id;

    if ($request->has('address')) {
        $user->address = $request->address; // Assuming 'address' is casted as array/json in User model
    }
    // dd($user);

    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
}





public function destroy($id)
   {
    $user = User::findOrFail($id);
    $user->delete();

       return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
   }

}
