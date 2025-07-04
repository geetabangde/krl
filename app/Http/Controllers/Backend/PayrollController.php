<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class PayrollController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage payroll', only: ['index']),
            new Middleware('admin.permission:create payroll', only: ['create']),
            new Middleware('admin.permission:edit payroll', only: ['edit']),
            new Middleware('admin.permission:delete payroll', only: ['destroy']),
        ];
    }
   public function index(Request $request)
{
    $month = $request->input('month', Carbon::now()->month);
    $year = $request->input('year', Carbon::now()->year);

    $startDate = Carbon::create($year, $month, 1)->startOfMonth();
    $endDate = Carbon::create($year, $month, 1)->endOfMonth();

    
    $workingDays = 0;
    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        if (!$date->isSunday()) {
            $workingDays++;
        }
    }

    $employees = Admin::with([
        'attendances' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
    ])->get();

    $payrollData = $employees->map(function ($employee) use ($workingDays) {
        $present = $employee->attendances->where('status', 'present')->count();
        $halfday = $employee->attendances->where('status', 'halfday')->count();
        $presentDays = $present + $halfday;

        // Payable salary = full days + 0.5 * halfdays
        $dailySalary = $workingDays > 0 ? ($employee->salary / $workingDays) : 0;
        $payableSalary = round(($present * $dailySalary) + ($halfday * $dailySalary / 2), 2);

        return [
            'employee' => $employee,
            'total_salary' => $employee->salary,
            'present_days' => $presentDays,
            'working_days' => $workingDays,
            'payable_salary' => $payableSalary,
        ];
    });

    return view('admin.payroll.index', compact('payrollData', 'workingDays', 'month', 'year'));
}

public function show($employeeId, Request $request)
{
    $employee = Admin::findOrFail($employeeId);

    $month = $request->input('month', Carbon::now()->format('m'));
    $year = $request->input('year', Carbon::now()->format('Y'));

    try {
        $monthYear = Carbon::createFromDate($year, $month)->format('F Y');
    } catch (\Exception $e) {
        $monthYear = null;
    }

    $startDate = Carbon::create($year, $month, 1);
    $endDate = $startDate->copy()->endOfMonth();
    $totalDaysInMonth = $endDate->day;

    
    $attendances = Attendance::where('admin_id', $employee->id)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->get()
        ->keyBy('date');

   
    $workingDays = 0;
    for ($d = $startDate->copy(); $d->lte($endDate); $d->addDay()) {
        if (!$d->isSunday()) {
            $workingDays++;
        }
    }

    
    $dailySalary = $workingDays > 0 ? ($employee->salary / $workingDays) : 0;

    
    $presentDays = 0;
    $halfDays = 0;
    $runningTotal = 0;
    $days = [];

    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        $dateStr = $date->format('Y-m-d');
        $dayName = $date->format('l');
        $isSunday = $dayName === 'Sunday';

        $attendance = $attendances->get($dateStr);
        $status = $attendance->status ?? 'absent';

        $daySalary = 0;
        if ($status === 'present') {
            $daySalary = $dailySalary;
            $presentDays++;
        } elseif ($status === 'halfday') {
            $daySalary = $dailySalary / 2;
            $halfDays++;
        }

        $runningTotal += $daySalary;

        $days[] = [
            'date' => $dateStr,
            'day' => $dayName,
            'status' => $status,
            'salary' => round($daySalary, 2),
            'is_sunday' => $isSunday,
        ];
    }

    $totalPayable = round($runningTotal, 2);

    return view('admin.payroll.show', compact(
        'employee',
        'monthYear',
        'presentDays',
        'halfDays',
        'totalDaysInMonth',
        'workingDays',
        'days',
        'totalPayable'
    ));
}

//    public function show($employeeId, Request $request)
// {
//     $employee = Admin::findOrFail($employeeId);

    
//     $month = $request->input('month', Carbon::now()->format('m'));
//     $year = $request->input('year', Carbon::now()->format('Y'));

   
//     try {
//         $monthYear = Carbon::createFromDate($year, $month)->format('F Y');
//     } catch (\Exception $e) {
//         $monthYear = null;
//     }

   
//     $startDate = Carbon::create($year, $month, 1);
//     $endDate = $startDate->copy()->endOfMonth();
//     $totalDaysInMonth = $endDate->day;

   
//     $attendances = Attendance::where('admin_id', $employee->id)
//         ->whereMonth('date', $month)
//         ->whereYear('date', $year)
//         ->get()
//         ->keyBy('date');

  
//     $workingDays = 0;
//     $presentDays = 0;
//     $halfDays = 0;
//     $runningTotal = 0;
//     $days = [];

//     for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
//         $dateStr = $date->format('Y-m-d');
//         $dayName = $date->format('l');
//         $isSunday = $dayName === 'Sunday';

//         if (!$isSunday) {
//             $workingDays++;
//         }

//         $attendance = $attendances->get($dateStr);
//         $status = $attendance->status ?? 'absent';

//         // Salary calculation
//         $daySalary = 0;
//         if ($status === 'present') {
//             $daySalary = $employee->salary / $workingDays;
//             $presentDays++;
//         } elseif ($status === 'halfday') {
//             $daySalary = ($employee->salary / $workingDays) / 2;
//             $halfDays++;
//         }

//         $runningTotal += $daySalary;

//         $days[] = [
//             'date' => $dateStr,
//             'day' => $dayName,
//             'status' => $status,
//             'salary' => round($daySalary, 2),
//             'is_sunday' => $isSunday,
//         ];
//     }

//     $totalPayable = round($runningTotal, 2);

//     return view('admin.payroll.show', compact(
//         'employee',
//         'monthYear',
//         'presentDays',
//         'halfDays',
//         'totalDaysInMonth',
//         'workingDays',
//         'days',
//         'totalPayable'
//     ));
// }
}

