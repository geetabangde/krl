@extends('admin.layouts.app')
@section('title', 'Employees | KRL')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Payroll</h4>
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
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Payroll</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <form method="GET" class="row mb-3">
                <div class="col-md-3">
                    <label>Month</label>
                    <select name="month" class="form-control">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Year</label>
                    <select name="year" class="form-control">
                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <div class="row listing-form">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title">🧾 Payroll Listing</h4>
                                <p class="card-title-desc">Summary of employee payroll based on attendance data.</p>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Employee ID</th>
                                        <th>Full Name</th>
                                        <th>Gross Salary</th>
                                        <th>Net Salary</th>
                                        <th>Present Days</th>
                                        <th>Working Days</th>
                                        @if (hasAdminPermission('edit payroll'))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payrollData as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>EMP#{{ str_pad($data['employee']->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $data['employee']->name }} </td>
                                            <td>₹{{ number_format($data['total_salary'], 2) }}</td>
                                            <td>₹{{ number_format($data['payable_salary'], 2) }}</td>
                                            <td>{{ $data['present_days'] }}</td>
                                            <td>{{ $data['working_days'] }}</td>
                                            @if (hasAdminPermission('edit payroll'))
                                            <td>
                                                @if (hasAdminPermission('view payroll'))
                                                    <a href="{{ route('admin.payroll.show', $data['employee']->id) }}">
                                                        <button class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="View Payroll">
                                                            <i class="fas fa-eye text-primary"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                                {{-- <a href="#">
                                                    <button class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Edit Payroll">
                                                        <i class="fas fa-pen text-warning"></i>
                                                    </button>
                                                </a> --}}
                                                {{-- <a href="#">
                                                    <button class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Delete Payroll">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </a> --}}
                                            </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No payroll data found for selected month.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
