@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
    <!-- Order Booking listing Page -->
      <div class="row listing-form">
        <div class="col-12">
         
        <div class="card">
            <div class="container mt-4">
                <h4 class="mb-4">Assign eWay Bill to LR: <strong>{{ $lr_number }}</strong></h4>

                {{-- DATE PICKER FORM --}}
                <form method="GET" action="{{ route('admin.consignments.assign', [$lr_number]) }}" class="mb-4 row g-3">
                    <div class="col-md-4">
                        <label for="eway_date" class="form-label">Select eWayBill Date</label>
                        <input type="date" name="date" class="form-control" value="{{ \Carbon\Carbon::createFromFormat('d/m/Y', $ewayBillDate)->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-primary">Get</button>
                    </div>
                    <div class="col-md-4">
                        <label for="ewaybill_input" class="form-label">Enter eWay Bill No</label>
                        <div class="input-group">
                            <input type="text" id="ewaybill_input" class="form-control" placeholder="Enter eWay Bill Number">
                            <button type="button" class="btn btn-primary" onclick="searchEwayBill()">Search</button>
                        </div>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(count($ewayBills) > 0)
                <form id="assignForm" method="POST" action="{{ route('admin.consignments.assign.save', [$lr_number]) }}" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Select</th>
                                <th>eWay Bill No</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Doc No</th>
                                <th>Doc Date</th>
                                <th>Delivery Place</th>
                                <th>Pin Code</th>
                                <th>State Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ewayBills as $bill)
                                <tr>
                                    <td><input type="checkbox" class="ewaybill-checkbox" data-ewbno="{{ $bill['ewbNo'] }}" name="selected_ewb[]" value="{{ $bill['ewbNo'] }}" @if(in_array($bill['ewbNo'], $assigned_eway_bills ?? [])) checked @endif></td>
                                    <td>{{ $bill['ewbNo'] }}</td>
                                    <td>{{ $bill['ewbDate'] }}</td>
                                    <td>{{ $bill['status'] }}</td>
                                    <td>{{ $bill['docNo'] }}</td>
                                    <td>{{ $bill['docDate'] }}</td>
                                    <td>{{ $bill['delPlace'] }}</td>
                                    <td>{{ $bill['delPinCode'] }}</td>
                                    <td>{{ $bill['delStateCode'] }}</td>
                                   <td>
                                    <a href="javascript:void(0)" onclick="confirmAndViewEwayBill('{{ $bill['ewbNo'] }}')">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success mt-3">Assign Selected eWayBills</button>
                </form>
                @else
                    <div class="alert alert-warning">No eWay Bills found for the selected date.</div>
                @endif
            </div>
        </div>
    </div>
      </div>
    </div>
   <!-- End Page-content -->
</div>

<!-- modal  -->
<!-- Modal for eWay Bill Details -->
<!-- Modal -->
<div class="modal fade" id="ewayBillModal" tabindex="-1" aria-labelledby="ewayBillModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">eWay Bill Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="ewayBillDetailsBody"></div>
      <div class="modal-footer">
        <form method="POST" action="{{ route('admin.consignments.assign.save', [$lr_number]) }}">
          @csrf
          <input type="hidden" name="selected_ewb[]" id="selected_ewb_hidden">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Assign & Update Part B</button>
        </form>
      </div>
    </div>
  </div>
</div>

 <!-- modal -->
  <!-- Confirmation Modal -->
<div class="modal fade" id="confirmViewModal" tabindex="-1" aria-labelledby="confirmViewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to view this eWay Bill?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="confirmYesBtn">Yes</button>
      </div>
    </div>
  </div>
</div>

<script>
function searchEwayBill() {
    const ewbNo = $('#ewaybill_input').val().trim();
    if (!ewbNo) {
        alert("Please enter a valid eWay Bill number.");
        return;
    }

    $.ajax({
        url: "{{ route('admin.consignments.vehicle_eway_bill') }}",
        method: "GET",
        data: { ewbs: ewbNo },
        success: function(response) {
            if (!response.success || !response.ewaybill_data) {
                alert("No eWay Bill found with this number.");
                return;
            }

            const ewb = response.ewaybill_data;
            const item = ewb.itemList && ewb.itemList.length > 0 ? ewb.itemList[0] : null;

            let html = `<table class='table table-bordered'>
                <tr><th>eWay Bill No</th><td>${ewb.ewbNo}</td></tr>
                <tr><th>eWay Bill Date</th><td>${ewb.ewayBillDate}</td></tr>
                <tr><th>Document</th><td>${ewb.docType} - ${ewb.docNo} (${ewb.docDate})</td></tr>
                <tr><th>From Party</th><td>${ewb.fromTrdName} (${ewb.fromGstin})<br>${ewb.fromAddr1}, ${ewb.fromAddr2}, ${ewb.fromPlace}, ${ewb.fromPincode}</td></tr>
                <tr><th>To Party</th><td>${ewb.toTrdName} (${ewb.toGstin})<br>${ewb.toAddr1}, ${ewb.toAddr2}, ${ewb.toPlace}, ${ewb.toPincode}</td></tr>
                <tr><th>Total Invoice</th><td>₹ ${ewb.totInvValue}</td></tr>
                <tr><th>Valid Upto</th><td>${ewb.validUpto || '-'}</td></tr>
                <tr><th>Distance</th><td>${ewb.actualDist} km</td></tr>
                <tr><th>Status</th><td>${ewb.status}</td></tr>
                 <tr><th>Vehicle Number</th><td>${ewb.VehiclListDetails && ewb.VehiclListDetails.length > 0 ? ewb.VehiclListDetails[0].vehicleNo : '-'}</td></tr>
            </table>`;

            if (item) {
                html += `<h6 class="mt-4">Item Detail</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>HSN Code</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${item.hsnCode}</td>
                            <td>${item.productDesc}</td>
                            <td>${item.quantity}</td>
                            <td>${item.qtyUnit}</td>
                        </tr>
                    </tbody>
                </table>`;
            }

            $('#ewayBillDetailsBody').html(html);
            $('#selected_ewb_hidden').val(ewb.ewbNo);
            $('#ewayBillModal').modal('show');
        },
        error: function() {
            alert("Something went wrong while fetching eWay Bill.");
        }
    });
}
</script>


<!-- viewEwayBill -->
<script>
let selectedEwbNo = null;

// Step 1: Called on View button click
function confirmAndViewEwayBill(ewbNo) {
    selectedEwbNo = ewbNo;
    $('#confirmViewModal').modal('show');
}

// Step 2: Called when "Yes" is clicked in confirmation
document.getElementById('confirmYesBtn').addEventListener('click', function () {
    if (!selectedEwbNo) return;

    $('#confirmViewModal').modal('hide');

    $.ajax({
        url: "{{ route('admin.consignments.vehicle_eway_bill') }}",
        method: "GET",
        data: { ewbs: selectedEwbNo },
        success: function(response) {
            if (!response.success || !response.ewaybill_data) {
                alert("No eWay Bill found with this number.");
                return;
            }

            const ewb = response.ewaybill_data;
            const item = ewb.itemList && ewb.itemList.length > 0 ? ewb.itemList[0] : null;

            // Main eWay Bill HTML
            let html = `<table class='table table-bordered'>
                <tr><th>eWay Bill No</th><td>${ewb.ewbNo}</td></tr>
                <tr><th>eWay Bill Date</th><td>${ewb.ewayBillDate}</td></tr>
                <tr><th>Document</th><td>${ewb.docType} - ${ewb.docNo} (${ewb.docDate})</td></tr>
                <tr><th>From Party</th><td>${ewb.fromTrdName} (${ewb.fromGstin})<br>${ewb.fromAddr1}, ${ewb.fromAddr2}, ${ewb.fromPlace}, ${ewb.fromPincode}</td></tr>
                <tr><th>To Party</th><td>${ewb.toTrdName} (${ewb.toGstin})<br>${ewb.toAddr1}, ${ewb.toAddr2}, ${ewb.toPlace}, ${ewb.toPincode}</td></tr>
                <tr><th>Total Invoice</th><td>₹ ${ewb.totInvValue}</td></tr>
                <tr><th>Valid Upto</th><td>${ewb.validUpto || '-'}</td></tr>
                <tr><th>Distance</th><td>${ewb.actualDist} km</td></tr>
                <tr><th>Status</th><td>${ewb.status}</td></tr>
                 <tr><th>Vehicle Number</th><td>${ewb.VehiclListDetails && ewb.VehiclListDetails.length > 0 ? ewb.VehiclListDetails[0].vehicleNo : '-'}</td></tr>
            </table>`;

            // Only one item shown
            if (item) {
                html += `<h6 class="mt-4">Item Detail</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>HSN Code</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${item.hsnCode}</td>
                            <td>${item.productDesc}</td>
                            <td>${item.quantity}</td>
                            <td>${item.qtyUnit}</td>
                        </tr>
                    </tbody>
                </table>`;
            } else {
                html += `<p class="text-muted">No items available.</p>`;
            }

            $('#ewayBillDetailsBody').html(html);
            $('#selected_ewb_hidden').val(ewb.ewbNo);
            $('#ewayBillModal').modal('show');
        },
        error: function() {
            alert("Something went wrong while fetching eWay Bill.");
        }
    });
});
</script>



<!-- viewEwayBill -->
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!document.querySelectorAll('input[name="selected_ewb[]"]:checked').length) {
            e.preventDefault();
            alert("Please select at least one eWayBill.");
        }
    });
</script>



<script>
document.getElementById('assignForm').addEventListener('submit', function(e) {
    const selected = Array.from(document.querySelectorAll('.ewaybill-checkbox:checked'))
        .map(cb => cb.value);

    if (selected.length === 0) {
        e.preventDefault();
        alert("Please select at least one eWay Bill.");
        return;
    }

    // Create a hidden input with all selected ewbNos for redirect
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'selected_ewb_json';
    input.value = JSON.stringify(selected);
    this.appendChild(input);
});
</script>




@endsection