@extends('admin.layouts.app')
@section('title', 'Freight-bill | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Freight Bill</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Freight Bill</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <!-- LR / Consignment Listing Page -->
      <div class="row listing-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="card-title">📑 Freight Bill</h4>
                     <p class="card-title-desc">View, edit, or delete freight bill details below.</p>
                  </div>
               </div>
               <div class="card-body">
                  <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Freight Bill</th>
                           <th>LR No</th>
                           <th>Consignors</th>
                           <th>Consignees</th>
                           <th>Dates</th>
                           <th>From</th>
                           <th>To</th>
                           @if (hasAdminPermission('edit freight_bill') || hasAdminPermission('delete freight_bill')|| hasAdminPermission('view freight_bill'))
                           <th>Action</th>
                           @endif
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($bills))
                        @foreach($bills as $billNumber => $entries)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $billNumber }}</td>
                           <td>
                              @foreach($entries as $e)
                              @php
                              // Agar lr_number JSON string hai to decode kar do
                              $lrNumbers = is_string($e->lr_number) ? json_decode($e->lr_number, true) : $e->lr_number;
                              @endphp
                              @if(is_array($lrNumbers))
                              @foreach($lrNumbers as $lr)
                              {{ $lr }}<br>
                              @endforeach
                              @else
                              {{ $lrNumbers }}<br>
                              @endif
                              @endforeach
                           </td>
                           {{-- Consignors --}}
                           <td>
                              @php
                              $consignors = collect();
                              foreach ($entries as $e) {
                              $orderIds = json_decode($e->order_id, true);
                              if (is_array($orderIds)) {
                              foreach ($orderIds as $orderId) {
                              $order = \App\Models\Order::where('order_id', $orderId)->first();
                              if ($order) {
                              $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
                              foreach ($lrs as $lr) {
                              if (!empty($lr['consignor_id'])) {
                              $user = \App\Models\User::find($lr['consignor_id']);
                              if ($user && !$consignors->contains('id', $user->id)) {
                              $consignors->push($user);
                              }
                              }
                              }
                              }
                              }
                              }
                              }
                              @endphp
                              @foreach($consignors as $consignor)
                              {{ $consignor->name }}<br>
                              @endforeach
                           </td>
                           {{-- Consignees --}}
                           <td>
                              @php
                              $consignees = collect();
                              foreach ($entries as $e) {
                              $orderIds = json_decode($e->order_id, true);
                              if (is_array($orderIds)) {
                              foreach ($orderIds as $orderId) {
                              $order = \App\Models\Order::where('order_id', $orderId)->first();
                              if ($order) {
                              $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
                              foreach ($lrs as $lr) {
                              if (!empty($lr['consignee_id'])) {
                              $user = \App\Models\User::find($lr['consignee_id']);
                              if ($user && !$consignees->contains('id', $user->id)) {
                              $consignees->push($user);
                              }
                              }
                              }
                              }
                              }
                              }
                              }
                              @endphp
                              @foreach($consignees as $consignee)
                              {{ $consignee->name }}<br>
                              @endforeach
                           </td>
                           <!-- LR Dates -->
                           <td>
                              @foreach($entries as $e)
                                 @php
                                       $lrNumbers = is_string($e->lr_number) ? json_decode($e->lr_number, true) : $e->lr_number;
                                       $lrDates = [];

                                       if (is_array($lrNumbers)) {
                                          $orderIds = json_decode($e->order_id, true);
                                          if (is_array($orderIds)) {
                                             foreach ($orderIds as $orderId) {
                                                   $order = \App\Models\Order::where('order_id', $orderId)->first();
                                                   if ($order) {
                                                      $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
                                                      foreach ($lrNumbers as $lrNumber) {
                                                         $detail = collect($lrs)->firstWhere('lr_number', $lrNumber);
                                                         if (isset($detail['lr_date'])) {
                                                               $date = \Carbon\Carbon::parse($detail['lr_date'])->format('Y-m-d');
                                                               if (!in_array($date, $lrDates)) {
                                                                  $lrDates[] = $date;
                                                               }
                                                         }
                                                      }
                                                   }
                                             }
                                          }
                                       }
                                 @endphp

                                 @foreach($lrDates as $date)
                                       {{ $date }}<br>
                                 @endforeach
                              @endforeach
                           </td>

                           <!-- From Location -->
                           <!-- From Location -->
                           <td>
                              @php
                              $fromLocations = collect();
                              foreach ($entries as $e) {
                              $orderIds = json_decode($e->order_id, true);
                              if (is_array($orderIds)) {
                              foreach ($orderIds as $orderId) {
                              $order = \App\Models\Order::where('order_id', $orderId)->first();
                              if ($order) {
                              $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
                              foreach ($lrs as $lr) {
                              if (!empty($lr['from_location'])) {
                              $location = \App\Models\Destination::find($lr['from_location']);
                              if ($location && !$fromLocations->contains('id', $location->id)) {
                              $fromLocations->push($location);
                              }
                              }
                              }
                              }
                              }
                              }
                              }
                              @endphp
                              @foreach($fromLocations as $fromLocation)
                              {{ $fromLocation->destination }}<br>
                              @endforeach
                           </td>
                           <!-- To Location -->
                           <!-- To Location -->
                           <td>
                              @php
                              $toLocations = collect();
                              foreach ($entries as $e) {
                              $orderIds = json_decode($e->order_id, true);
                              if (is_array($orderIds)) {
                              foreach ($orderIds as $orderId) {
                              $order = \App\Models\Order::where('order_id', $orderId)->first();
                              if ($order) {
                              $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
                              foreach ($lrs as $lr) {
                              if (!empty($lr['to_location'])) {
                              $location = \App\Models\Destination::find($lr['to_location']);
                              if ($location && !$toLocations->contains('id', $location->id)) {
                              $toLocations->push($location);
                              }
                              }
                              }
                              }
                              }
                              }
                              }
                              @endphp
                              @foreach($toLocations as $toLocation)
                              {{ $toLocation->destination }}<br>
                              @endforeach
                           </td>
                           @if (hasAdminPermission('edit freight_bill') || hasAdminPermission('delete freight_bill') || hasAdminPermission('view freight_bill'))
                           <td>
                              @if (hasAdminPermission('view freight_bill'))
                              <a href="{{ route('admin.freight-bill.view', $e->id) }}" class="btn btn-sm btn-light view-btn" data-bs-toggle="tooltip" title="View Freight Bill"><i class="fas fa-eye text-primary"></i></a>
                              @endif
                              @if (hasAdminPermission('edit freight_bill'))
                              <a href="" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Edit Freight Bill"><i class="fas fa-pen text-warning"></i></a>
                              @endif
                              @if (hasAdminPermission('delete freight_bill'))
                              <a href="#" data-url="{{ route('admin.freight-bill.delete', $e->id) }}" class="btn btn-sm btn-light delete-btn" data-bs-toggle="tooltip" title="Delete Freight Bill">
                                 <i class="fas fa-trash text-danger"></i>
                              </a>
                              @endif
                           </td>
                           @endif
                        </tr>
                        @endforeach
                        @endif
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- container-fluid -->
</div>
<!-- modal code -->
<!-- add modal -->
<div class="modal fade" id="addTyreModal" tabindex="-1" aria-labelledby="addTyreModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="addTyreModalLabel">🛞 Add Freight Bill</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="{{ route('admin.freight-bill.store') }}" method="post">
               @csrf
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label class="form-label">🏢 Freight Bill</label>
                     <input type="text" class="form-control" id="inputCompany"
                        placeholder="Enter Notes" name="notes" required>
                  </div>
               </div>
               <div class="text-end">
                  @if (hasAdminPermission('add freight_bill'))
                  <button type="submit" class="btn btn-primary">Add
                  freight bill</button>
                  @endif
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- add modal -->
<!-- update modal -->
{{-- //update tyre model --}}
<div class="modal fade" id="updateTyreModal" tabindex="-1" aria-labelledby="updateTyreModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">🛞 Edit FreightBill</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="editForm"  method="post" action="">
               @csrf
               @method('PUT')
               <div class="row">
                  <input type="hidden" id="editid">
                  <div class="col-md-6 mb-3">
                     <label class="form-label">🏢 FreightBill</label>
                     <input type="text" class="form-control" placeholder="Enter notes"
                        id="editCompany" name="notes" required>
                  </div>
               </div>
               <div class="text-end">
                  <button type="submit" class="btn btn-primary">Update FreightBill </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- update modal -->
<!-- modal code -->
<script>
   document.addEventListener('DOMContentLoaded', function () {
   // Event delegation from document since child rows are dynamically inserted
   document.addEventListener('click', function (e) {
     // Check if the clicked element or its parent has class 'edit-btn'
     const btn = e.target.closest('.edit-btn');
     if (!btn) return;
   
     const tyreData = {
         id: btn.dataset.id,
         name: btn.dataset.name,
         
     };
   
     // console.log("Clicked row data:", tyreData);
   
     // Fill modal fields
     $('#editid').val(tyreData.id);
     $('#editCompany').val(tyreData.name);
      
   
     let form = document.getElementById('editForm');
     form.action = `/admin/freight-bill/update/${tyreData.id}`;
     // Show modal
     $('#updateTyreModal').modal('show');
   });
   });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
       document.getElementById("addTyreBtn").addEventListener("click", function () {
           var addTyreModal = new bootstrap.Modal(document.getElementById("addTyreModal"));
           addTyreModal.show();
       });
       document.getElementById("updateTyreBtn").addEventListener("click", function () {
               var updateTyreBtnTyreModal = new bootstrap.Modal(document.getElementById("updateTyreModal"));
               updateTyreModal.show();
           });  
   });
</script>

 <script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete this freight-bill record?')) return;

            const url = this.getAttribute('data-url');

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Deleted successfully.');
                if (data.status === 'success') {
                    location.reload();
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