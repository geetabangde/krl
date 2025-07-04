<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Admin;
use App\Models\TaskManagement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EmployeeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage employees', only: ['index']),
            new Middleware('admin.permission:create employees', only: ['create']),
            new Middleware('admin.permission:edit employees', only: ['edit']),
            new Middleware('admin.permission:delete employees', only: ['destroy']),
        ];
    }

    public function index()
    {
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }
    
    public function create(){
        $roles=Role::all();
        return view('admin.employees.create',compact('roles'));
    }

    public function store(Request $request)
    {
        // return($request->all());

        // Validate the incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'date_of_joining' => 'nullable|date',
            'emergency_contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'state' => 'nullable|string|max:100',
            'pin_code' => 'nullable|string|max:10',
            'aadhaar_number' => 'nullable|string|max:20',
            'pan_number' => 'nullable|string|max:20',
            'bank_account_number' => 'nullable|string|max:30',
            'ifsc_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'salary' => 'nullable|numeric',
            'role' => 'required|string',
            // 'password' => '',
            'employee_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Validate as a file
        ]);
    
        // Create a new Employee instance
        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->phone_number = $request->phone_number;
        $employee->designation = $request->designation;
        $employee->department = $request->department;
        $employee->date_of_joining = $request->date_of_joining;
        $employee->emergency_contact_number = $request->emergency_contact_number;
        $employee->address = $request->address;
        $employee->state = $request->state;
        $employee->pin_code = $request->pin_code;
        $employee->aadhaar_number = $request->aadhaar_number;
        $employee->pan_number = $request->pan_number;
        $employee->bank_account_number = $request->bank_account_number;
        $employee->ifsc_code = $request->ifsc_code;
        $employee->status = $request->status;
        $employee->salary = $request->salary;
        $employee ->role = $request->role;
        $employee ->password = Hash::make($request->password);
    
        // Handle the employee photo upload
        if ($request->hasFile('employee_photo') && $request->file('employee_photo')->isValid()) {
            $employeePhotoPath = $request->file('employee_photo')->store('employees/employee_photos', 'public');
            $employee->employee_photo = $employeePhotoPath; // Assign the file path to the employee_photo field
        }
    
        // Save the employee record
        if ($employee->save()) {
            return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully!');
        }
    
        return redirect()->route('admin.employees.index')->with('error', 'Employee creation failed!');
    }

    public function edit($id){
        $employee=Employee::find($id);
        $roles=Role::all();
        return view('admin.employees.edit',compact('employee','roles'));

    }
    public function show($id){
        $employee=Admin::find($id);
      
        return view('admin.user.show',compact('employee'));

    }
    public function task($id)
    { 
    // Find the employee by ID and load their tasks
    $employee = Admin::with('tasks')->findOrFail($id); 

    // Return the view with the employee and their tasks
    return view('admin.user.task', compact('employee'));
}
    
public function update(Request $request, $id)
{
    $employee = Employee::findOrFail($id);

    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone_number' => 'required|string|max:20',
        'designation' => 'nullable|string|max:255',
        'department' => 'nullable|string|max:255',
        'date_of_joining' => 'nullable|date',
        'emergency_contact_number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'state' => 'nullable|string|max:100',
        'pin_code' => 'nullable|string|max:10',
        'aadhaar_number' => 'nullable|string|max:20',
        'pan_number' => 'nullable|string|max:20',
        'bank_account_number' => 'nullable|string|max:30',
        'ifsc_code' => 'nullable|string|max:20',
        'status' => 'required|in:active,inactive',
        'salary' => 'required|numeric',
        'employee_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', 
        'role' => 'required|string',
    ]);

   
   
    $employee->first_name = $request->first_name;
    $employee->last_name = $request->last_name;
    $employee->email = $request->email;
    $employee->phone_number = $request->phone_number;
    $employee->designation = $request->designation;
    $employee->department = $request->department;
    $employee->date_of_joining = $request->date_of_joining;
    $employee->emergency_contact_number = $request->emergency_contact_number;
    $employee->address = $request->address;
    $employee->state = $request->state;
    $employee->pin_code = $request->pin_code;
    $employee->aadhaar_number = $request->aadhaar_number;
    $employee->pan_number = $request->pan_number;
    $employee->bank_account_number = $request->bank_account_number;
    $employee->ifsc_code = $request->ifsc_code;
    $employee->status = $request->status;
    $employee->salary = $request->salary;
    $employee->role = $request->role;

   
    if ($request->hasFile('employee_photo') && $request->file('employee_photo')->isValid()) {
       
        $employeePhotoPath = $request->file('employee_photo')->store('employees/employee_photos', 'public');
        $employee->employee_photo = $employeePhotoPath;
    } else {
       
        $employee->employee_photo = $request->input('old_employee_photo');
    }

    // if ($request->filled('password')) {
    //     $admin->password = Hash::make($request->password);
    // }

    if ($employee->save()) {
        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully!');
    }

    return redirect()->route('admin.employees.index')->with('error', 'Employee not updated!');
}

    public function destroy($id){
        $employee=Employee::findOrFail($id);
       
        if($employee->delete()){
          return redirect()->back()->with('success', 'Employee deleted successfully!');
            
        }
        return redirect()->back()->with('error', 'Employee not deleted!');
    }
}


