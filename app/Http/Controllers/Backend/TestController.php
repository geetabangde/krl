<?php



namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


use App\Models\User;
class TestController extends Controller implements HasMiddleware

{
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('admin.permission:manage users', only: ['index']),
    //         new Middleware('admin.permission:create users', only: ['create']),
    //         new Middleware('admin.permission:edit users', only: ['edit']),
    //         new Middleware('admin.permission:delete users', only: ['destroy']),
    //     ];
    // }
      public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage employees', only: ['index']),
            new Middleware('admin.permission:create employees', only: ['create']),
            new Middleware('admin.permission:edit employees', only: ['edit']),
            new Middleware('admin.permission:delete employees', only: ['destroy']),
        ];
    }
   public function  index(){
    $users=Admin::latest()->get();
   
    return view('admin.user.index',compact('users'));
   }
   public function create() {
    $roles=Role::all();
    return view('admin.user.create',compact('roles'));
    }

   public function edit($id)
    {
        $roles=Role::all();
        $user=Admin::find($id);
        return view('admin.user.edit', compact('user','roles'));
    }


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|string',
        'password' => '',
        'employee_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    $filename = null;

    // Step 1: Check file is uploaded
    if ($request->hasFile('employee_photo')) {
        $file = $request->file('employee_photo');

        if ($file->isValid()) {
            $filename = 'employee_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename); // file saved
        }
    }


    // Save admin and store the return value
    $admin = Admin::create([
        'name' => $request->name,
        'last_name' => $request->last_name,
        'phone_number' => $request->phone_number,
        'state' => $request->state,
        'email' => $request->email,
        'ifsc_code' => $request->ifsc_code,
        'salary' => $request->salary,
        'status' => $request->status,
        'pan_number' => $request->pan_number,
        'bank_account_number' => $request->bank_account_number,
        'aadhaar_number' => $request->aadhaar_number,
        'pin_code' => $request->pin_code,
        'address' => $request->address,
        'designation' => $request->designation,
        'department' => $request->department,
        'date_of_joining' => $request->date_of_joining,
        'emergency_contact_number' => $request->emergency_contact_number,
        'role' => $request->role, 
        'password' => Hash::make($request->password),
        'employee_photo' => $filename, // Save file name in DB
    ]);

    // Now you can use $admin
    // dd($admin);


    return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
}

public function update(Request $request, $id)
{
    $admin = Admin::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'role' => 'required|string',
        'employee_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    $filename = $request->old_employee_photo; // Default to old photo

    // New file upload logic
    if ($request->hasFile('employee_photo') && $request->file('employee_photo')->isValid()) {
        $file = $request->file('employee_photo');
        $filename = 'employee_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
    }

    // Update fields
    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->role = $request->role;
    $admin->last_name = $request->last_name;
    $admin->phone_number = $request->phone_number;
    $admin->designation = $request->designation;
    $admin->department = $request->department;
    $admin->date_of_joining = $request->date_of_joining;
    $admin->emergency_contact_number = $request->emergency_contact_number;
    $admin->address = $request->address;
    $admin->state = $request->state;
    $admin->pin_code = $request->pin_code;
    $admin->aadhaar_number = $request->aadhaar_number;
    $admin->pan_number = $request->pan_number;
    $admin->bank_account_number = $request->bank_account_number;
    $admin->ifsc_code = $request->ifsc_code;
    $admin->status = $request->status;
    $admin->salary = $request->salary;

    // Update password only if filled
    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    // Update employee photo
    $admin->employee_photo = $filename;

    $admin->save();

    return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
}



public function destroy($id)
{
    $user = Admin::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');
}

}
