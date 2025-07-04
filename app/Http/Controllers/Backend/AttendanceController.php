<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AttendanceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage attendance', only: ['index']),
            new Middleware('admin.permission:create attendance', only: ['create']),
            new Middleware('admin.permission:edit attendance', only: ['edit']),
            new Middleware('admin.permission:delete attendance', only: ['destroy']),
        ];
    }
public function index(Request $request)
{
    $date = $request->input('date') ?? now()->toDateString();
    $today = Carbon::createFromFormat('Y-m-d', $date);

    $employees = Admin::all();

    // Start from 1st June
    $startDate = Carbon::create(2025, 6, 1);

    while ($startDate->lte($today)) {
        foreach ($employees as $employee) {
            
            if ($employee->created_at->gt($startDate)) {
                continue;
            }

            $alreadyExists = Attendance::where('admin_id', $employee->id)
                ->whereDate('date', $startDate)
                ->exists();

            if (!$alreadyExists) {
                Attendance::create([
                    'admin_id' => $employee->id,
                    'date' => $startDate->toDateString(),
                    'status' => $startDate->isSunday() ? 'absent' : 'present',
                    'remark' => $startDate->isSunday() ? 'Holiday (Sunday)' : 'Present',
                ]);
            }
        }

        $startDate->addDay(); // next date
    }

    $attendances = Attendance::with('admin')
        ->whereDate('date', $today)
        ->get();

    return view('admin.attendance.index', compact('attendances', 'today', 'employees'));
}



    
// public function index(Request $request)
// {
//     $date = $request->input('date') ?? now()->toDateString();
//     $today = Carbon::createFromFormat('Y-m-d', $date);
   

//     $employees = Admin::all();

    
//     if ($today->isToday()) {
//         foreach ($employees as $employee) {
//             $alreadyExists = Attendance::where('admin_id', $employee->id)
//                 ->whereDate('date', $today)
//                 ->exists();

//             if (!$alreadyExists) {
//                 Attendance::create([
//                     'admin_id' => $employee->id,
//                     'date' => $today,
//                     'status' => $today->isSunday() ? 'absent' : 'present',
//                     'remark' => $today->isSunday() ? 'Holiday (Sunday)' : 'Present',
//                 ]);
//             }
//         }
//     }

//     $attendances = Attendance::with('admin')
//         ->whereDate('date', $today)
//         ->get();

//     return view('admin.attendance.index', compact('attendances', 'today', 'employees'));
// }


public function update(Request $request)
   {
    // return $request->all();
    $request->validate([
        'status' => 'required|in:present,absent,halfday',
        'employee_ids' => 'required|array',
        'employee_ids.*' => 'exists:admins,id', 
        'remark' => 'nullable|string|max:255',
        'date' => 'required|date',
    ]);

    $date = Carbon::parse($request->date)->format('Y-m-d');

    foreach ($request->employee_ids as $employeeId) {
        Attendance::updateOrCreate(
            ['admin_id' => $employeeId, 'date' => $date],
            ['status' => $request->status, 'remark' => $request->remark]
        );
    }

    return redirect()->back()->with('success', 'Attendance updated successfully!');
    }
}

