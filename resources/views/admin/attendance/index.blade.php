@extends('admin.layouts.app')
@section('title', 'Attendance | KRL')
@section('content')

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="page-content">
<div class="container-fluid">

   <!-- Page Header -->
   <div class="row mb-2">
      <div class="col-md-6">
         <h4 class="mb-sm-0 font-size-18">Attendance</h4>
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
      </div>
   </div>

   <!-- Date Filter Form -->
   <form method="GET" action="{{ route('admin.attendance.index') }}" class="mb-3">
      <div class="input-group" style="max-width: 300px;">
         <input type="text" name="date" id="calendarInput" class="form-control" placeholder="Select Date" value="{{ request('date') ?? now()->toDateString() }}">
         <button type="submit" class="btn btn-outline-primary">Search</button>
      </div>
   </form>

   <!-- Attendance Table -->
   <div class="card">
      <div class="card-body">
         <form id="bulkAttendanceForm" method="POST" action="{{ route('admin.attendance.update') }}">
            @csrf
            <div class="input-group mb-3">
               <select name="status" class="form-select form-select-sm me-2" id="bulkStatusSelect" required style="width: 200px;">
                  <option value="">Select Status</option>
                  <option value="present">Present</option>
                  <option value="absent">Absent</option>
                  <option value="halfday">Halfday</option>
               </select>
               <input type="text" name="remark" id="bulkRemark" class="form-control form-control-sm me-2 d-none" placeholder="Enter remark">
               <input type="hidden" name="date" value="{{ $today }}">
               <button type="submit" class="btn btn-sm btn-danger">Apply to Selected</button>
            </div>

            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
               <thead>
                  <tr>
                     <th><input type="checkbox" id="selectAll"> S.No</th>
                     <th>Employee Id</th>
                     <th>Full Name</th>
                     <th>Status</th>
                     <th>Remark</th>
                     <th>Date</th>
                  </tr>
               </thead>
               
               <tbody>
    @forelse ($attendances as $key => $attendance)
        <tr>
            <td>
                <input type="checkbox" name="employee_ids[]" class="employee-checkbox" value="{{ $attendance->admin->id }}">
                {{ $loop->iteration }}
            </td>
            <td>EMP##{{ $attendance->admin->id }}</td>
            <td>{{ $attendance->admin->name }}</td>
            <td>
                @if ($attendance->status === 'present')
                    <span class="badge bg-success">Present</span>
                @elseif ($attendance->status === 'absent')
                    <span class="badge bg-danger">Absent</span>
                @elseif ($attendance->status === 'halfday')
                    <span class="badge bg-primary">Halfday</span>
                @elseif ($attendance->status === 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>{{ $attendance->remark }}</td>
            <td>{{ $attendance->date }}</td>
        </tr>
    @empty
        <tr>
            <td class="text-center text-muted">No attendance found for this date.</td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            
        </tr>
    @endforelse
</tbody>

            </table>
         </form>
      </div>
   </div>

</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
   // Initialize flatpickr with selected date
   flatpickr("#calendarInput", {
      dateFormat: "Y-m-d",
      defaultDate: "{{ request('date') ?? now()->toDateString() }}"
   });

   // Select/Deselect all checkboxes
   document.getElementById('selectAll').addEventListener('change', function () {
      document.querySelectorAll('.employee-checkbox').forEach(cb => cb.checked = this.checked);
   });

   // Show remark input only if status is 'absent'
   document.getElementById('bulkStatusSelect').addEventListener('change', function () {
      const remarkInput = document.getElementById('bulkRemark');
    //   if (this.value === 'absent') {
         remarkInput.classList.remove('d-none');
         remarkInput.setAttribute('required', 'required');
    //   } else {
    //      remarkInput.classList.add('d-none');
    //      remarkInput.removeAttribute('required');
    //      remarkInput.value = '';
    //   }
   });

   // DataTable Init
   $(document).ready(function () {
      $('.table').DataTable();
   });
</script>
@endsection
