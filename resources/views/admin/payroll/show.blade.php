@extends('admin.layouts.app')
@section('title', 'Employees | KRL')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Payroll Details</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payroll</li>
                            <li class="breadcrumb-item active">Show</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <label for="month">Month</label>
                <select name="month" id="month" class="form-select">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3">
                <label for="year">Year</label>
                <select name="year" id="year" class="form-select">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <h5>Payroll Summary</h5>
                    <div class="row">
                        <div class="col-md-6"><strong>Employee:</strong> {{ $employee->name }} </div>
                        <div class="col-md-6"><strong>Month:</strong> {{ $monthYear ?? 'Not available' }}</div>
                        <div class="col-md-4"><strong>Total Days:</strong> {{ $totalDaysInMonth }}</div>
                        <div class="col-md-4"><strong>Working Days:</strong> {{ $workingDays }}</div>
                        <div class="col-md-4"><strong>Present:</strong> {{ $presentDays }} | Half Day: {{ $halfDays }}</div>
                        <div class="col-md-4"><strong>Gross Salary:</strong> ₹{{ number_format($employee->salary, 2) }}</div>
                        <div class="col-md-4"><strong>Net Salary:</strong> ₹{{ number_format($totalPayable, 2) }}</div>
                    </div>
                </div>

                <h5 class="mt-4">Daily Logs</h5>

                @if(count($days) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Status</th>
                                    <th>Daily Salary</th>
                                    <th>Running Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $runningTotal = 0; @endphp
                                @foreach($days as $day)
                                {{-- @dd($days); --}}
                                    @php 
                                        $runningTotal += $day['salary'] ?? 0;
                                        $isSunday = $day['is_sunday'];
                                    @endphp
                                    <tr style="{{ $isSunday ? 'background-color: #343a40; color: white;' : '' }}">
                                        <td>{{ $day['date'] }}</td>
                                        {{-- <td>{{ $day['day'] }}</td> --}}
                                        <td style="color: {{ $day['day'] === 'Sunday' ? 'red' : 'inherit' }}">
                                            {{ $day['day'] }}
                                        </td>
                                        <td class="fw-bold"
                                            style="
                                                @switch($day['status'])
                                                    @case('absent') background-color: #f8d7da; color: #721c24; @break
                                                    @case('present') background-color: #d4edda; color: #155724; @break
                                                    @case('halfday') background-color: #d1ecf1; color: #0c5460; @break
                                                @endswitch">
                                            {{ ucfirst($day['status']) }}
                                        </td>
                                        <td>₹{{ number_format($day['salary'] ?? 0, 2) }}</td>
                                        <td>₹{{ number_format($runningTotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">No attendance data found for this month.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection