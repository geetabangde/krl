@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18"> LR / Consignment</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active"> LR / Consignment</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <!-- Order Booking listing Page -->
      <div class="row listing-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="card-title">📦 LR / Consignment</h4>
                     <p class="card-title-desc">View, edit, or delete order details below.</p>
                  </div>
                  @if (hasAdminPermission('create lr_consignment'))
                  <a href="{{ route('admin.consignments.create') }}" class="btn" id="addOrderBtn"
                     style="background-color: #ca2639; color: white; border: none; margin-left: 46%;">
                  <i class="fas fa-plus"></i> Add LR / Consignment
                  </a>
                  @endif
                  <!-- Freight Bill Form -->
                  <form id="lrForm" action="{{ route('admin.freight-bill.store') }}" method="post" style="display: inline;">
                     @csrf
                     <input type="hidden" name="selected_lrs" id="orderInputHidden">
                     {{-- @if (hasAdminPermission('add lr_consignment')) --}}
                     <button type="submit" id="generateBtn" class="btn custom-btn"
                        style="background-color: #ca2639; color: white; border: none; display: none;">
                     Freight Bill LR Generate
                     </button>
                     {{-- @endif --}}
                  </form>
               </div>
               <div class="card-body">
                  <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                     <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                           <tr>
                              <th><input type="checkbox" id="selectAll"></th>
                              <th>S.No</th>
                              <th>Order ID</th>
                              <th>LR NO</th>
                              <th>Customer</th>
                              <th>Consignor</th>
                              <th>Consignee</th>
                              <th>Date</th>
                              <th>From</th>
                              <th>To</th>
                              @if (hasAdminPermission('edit lr_consignment') || hasAdminPermission('delete lr_consignment')|| hasAdminPermission('view lr_consignment'))
                              <th>Action</th>
                              @endif
                           </tr>
                        </thead>
                        <tbody>
                           {{-- @dd($orders); --}}
                           @php $rowCount = 1; @endphp
                           @foreach($orders as $order)
                           @php
                           $lrDetails = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
                           @endphp
                           @if(!empty($lrDetails) && count($lrDetails) > 0)
                           @foreach($lrDetails as $lr)
                           <tr class="lr-row" data-id="{{ $order->id }}" data-customer-id="{{ $lr['customer_id'] ?? $order->customer_id }}">

                           <!-- <tr class="lr-row" data-id="{{ $order->id }}" data-customer-id="{{ $order->customer_id }}"> -->
                              <td>
                                 <input type="checkbox" class="lr-checkbox" value="{{ $order->order_id }}|{{ $lr['lr_number'] ?? '' }}">
                              </td>
                              <td>{{ $rowCount++ }}</td>
                              <td>{{ $order->order_id }}</td>
                              <td>{{ $lr['lr_number'] ?? '-' }}</td>
                              <td>
                                 @php
                                 $customerUser = \App\Models\User::find($lr['customer_id'] ?? null);
                                 $customerName = $order->customer->name ?? ($customerUser->name ?? '-');
                                 @endphp
                                 {{ $customerName }}
                              </td>
                              <td>
                                 @php
                                 $consignorUser = \App\Models\User::find($lr['consignor_id'] ?? null);
                                 $consignorName = $order->consignor->name ?? ($consignorUser->name ?? '-');
                                 @endphp
                                 {{ $consignorName }}
                              </td>
                              <td>
                                 @php
                                 $consigneeUser = \App\Models\User::find($lr['consignee_id'] ?? null);
                                 $consigneeName = $order->consignee->name ?? ($consigneeUser->name ?? '-');
                                 @endphp
                                 {{ $consigneeName }}
                              </td>
                              <td>{{ $lr['lr_date'] ?? '-' }}</td>
                              @php
                              $fromDestination = \App\Models\Destination::find($lr['from_location']);
                              $toDestination = \App\Models\Destination::find($lr['to_location']);
                              @endphp
                              <td>{{ $fromDestination->destination ?? '-' }}</td>
                              <td>{{ $toDestination->destination ?? '-' }}</td>
                             
                              @if (hasAdminPermission('edit lr_consignment') || hasAdminPermission('delete lr_consignment')|| hasAdminPermission('view lr_consignment'))
                              <td>
                              
                              @if (hasAdminPermission('view lr_consignment'))
                               
                                 <a href="{{ route('admin.consignments.documents', $lr['lr_number']) }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Documents"><i class="fas fa-file-alt text-primary"></i></a>
                              @endif
                              @if (hasAdminPermission('view lr_consignment'))
                                 <a href="{{ route('admin.consignments.view', $lr['lr_number']) }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Details"><i class="fas fa-eye text-primary"></i></a>
                                 @endif
                        
                              @if (hasAdminPermission('edit lr_consignment'))
                                 @php
                                    $isPodUploaded = $lr['pod_uploaded'] ?? 0;
                                    $lrNumber = $lr['lr_number'] ?? null;
                                 @endphp

                                 @if ($isPodUploaded)
                                    <button class="btn btn-sm btn-secondary" disabled>
                                          <i class="fas fa-pen text-warning"></i>
                                    </button>
                                 @elseif ($lrNumber)
                                    <a href="{{ route('admin.consignments.edit', [$order->order_id, $lrNumber]) }}"
                                       class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Edit Consignments">
                                          <i class="fas fa-pen text-warning"></i>
                                    </a>
                                 @else
                                    <button class="btn btn-sm btn-light" disabled>
                                          <i class="fas fa-exclamation-circle text-danger" title="LR Number missing"></i>
                                    </button>
                                 @endif
                              @endif
                              @if (hasAdminPermission('delete lr_consignment'))
                              <a href="{{ route('admin.consignments.delete', [$order->order_id, $lr['lr_number']]) }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Delete Consignments"><i class="fas fa-trash text-danger"></i></a>
                              @endif
                              <a href="{{ route('admin.consignments.assign', [$lr['lr_number']]) }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Assign eWay Bill">
                              <i class="fas fa-random text-danger"></i>
                              </a>
                              </td>
                           @endif
                           </tr>
                           @endforeach
                           @endif
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- End Page-content -->
</div>
<!-- end main content-->
<!-- Add this before any script that uses jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- JavaScript -->
<script>
const generateBtn = document.getElementById("generateBtn");
const orderInputHidden = document.getElementById("orderInputHidden");

function updateSelectedLRs() {
  const selectedData = [];
  const selectedCustomerIds = new Set();
  const selectedCheckboxes = document.querySelectorAll(".lr-checkbox:checked");

  let customerIdRef = null;
  let isValid = true;

  selectedCheckboxes.forEach(cb => {
    const row = cb.closest("tr");
    const customerId = row.getAttribute("data-customer-id");

    // First selected customer
    if (!customerIdRef) {
      customerIdRef = customerId;
    }

    // If customer mismatch, uncheck this checkbox
    if (customerId !== customerIdRef) {
      cb.checked = false; // ❌ Uncheck only mismatched customer checkbox
      isValid = false;
    } else {
      // ✅ Only push valid customer LRs
      const [order_id, lr_number] = cb.value.split("|");
      selectedData.push({ order_id, lr_number });
      if (customerId !== null && customerId !== "") {
        selectedCustomerIds.add(customerId);
      }
    }
  });

  if (!isValid) {
    alert("Different customers selected. Freight bill cannot be generated.");
  }

  // Update hidden input and button
  if (selectedData.length > 0 && selectedCustomerIds.size === 1) {
    orderInputHidden.value = JSON.stringify(selectedData);
    generateBtn.style.display = "inline-block";
  } else {
    orderInputHidden.value = '';
    generateBtn.style.display = "none";
  }
}



// Individual checkbox change
document.querySelectorAll(".lr-checkbox").forEach(cb =>
  cb.addEventListener("change", updateSelectedLRs)
);

// Select All checkbox
document.getElementById("selectAll").addEventListener("change", function () {
  document.querySelectorAll(".lr-checkbox").forEach(cb => cb.checked = this.checked);
  updateSelectedLRs();
});

// Submit
generateBtn.addEventListener("click", function (e) {
  e.preventDefault();
  if (generateBtn.style.display !== "none") {
    document.getElementById("lrForm").submit();
  }
});

// Initially hidden
generateBtn.style.display = "none";
</script>


<script>
   document.getElementById('selectAll').addEventListener('change', function() {
       const checkboxes = document.querySelectorAll('input[name="selected_rows[]"]');
       checkboxes.forEach(cb => cb.checked = this.checked);
   });
</script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
       document.querySelectorAll('.delete-btn').forEach(button => {
           button.addEventListener('click', function (e) {
               e.preventDefault();
   
               if (!confirm('Are you sure you want to delete all LR entries under this order ID?')) return;
   
               const url = this.getAttribute('href');
   
               fetch(url, {
                   method: 'DELETE',
                   headers: {
                       'X-CSRF-TOKEN': '{{ csrf_token() }}',
                       'Accept': 'application/json'
                   }
               })
               .then(response => response.json())
               .then(data => {
                   alert(data.message);
                   if (data.status === 'success') {
                       location.reload(); // or redirect
                   }
               })
               .catch(error => {
                   console.error('Error:', error);
                   alert('Something went wrong.');
               });
           });
       });
   });
</script>
@endsection