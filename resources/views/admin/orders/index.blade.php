@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')

<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Order Booking</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Order Booking</li>
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
                     <h4 class="card-title">📦 Order Booking</h4>
                     <p class="card-title-desc">View, edit, or delete order details below.</p>
                  </div>
                  @if (hasAdminPermission('create order_booking'))
                  <a href="{{ route('admin.orders.create') }}" class="btn" id="addOrderBtn"
                     style="background-color: #ca2639; color: white; border: none;">
                  <i class="fas fa-plus"></i> Add Order Booking
                   </a>
                   @endif
                 
               </div>
               <div class="card-body">
                  <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Order ID</th>
                           <th>Lr Number</th>
                           <th>Customer Name</th>
                           <th>Consignment Details</th>
                           <th>Consignment Pickup Date</th>
                           <th>Status   </th>
                          @if (hasAdminPermission('edit order_booking') || hasAdminPermission('delete order_booking')|| hasAdminPermission('view order_booking'))
                           <th>Action</th>@endif
                        </tr>
                     </thead>
                    <tbody>
                        @foreach($orders as $key => $order)
                        <tr class="order-row" data-id="{{ $order->id }}">
                            <td>{{ $key + 1 }}</td> <!-- Serial Number -->
                            <td>{{ $order->order_id }}</td>
                            <td>
                                 @if(is_array($order->lr))
                                    @foreach($order->lr as $lr)
                                          {{ $lr['lr_number'] ?? '-' }}<br>
                                    @endforeach
                                 @elseif(is_string($order->lr))
                                    @php
                                          $decodedLr = json_decode($order->lr, true);
                                    @endphp
                                    @if(is_array($decodedLr))
                                          @foreach($decodedLr as $lr)
                                             {{ $lr['lr_number'] ?? '-' }}<br>
                                          @endforeach
                                    @else
                                          {{ $order->lr }}
                                    @endif
                                 @else
                                    -
                                 @endif
                           </td>
                           <td>{{ $order->customer->name ?? '-' }}</td>


                            <td>{{ $order->description }}</td>
                            <td>{{ $order->order_date }}</td>

                           <td 
                           id="status-{{ $order->order_id }}" 
                           class="status-cell text-center px-2 py-1 text-white fw-bold" 
                           data-order_id="{{ $order->order_id }}" 
                           data-status="{{ $order->status }}" 
                           style="cursor: pointer; "
                           >
                           <sapan style="background-color:Blue;">{{ str_replace('-', ' ', $order->status) }}</sapan>
                           </td>


                        @if (hasAdminPermission('edit order_booking') || hasAdminPermission('delete order_booking')|| hasAdminPermission('view order_booking'))
                           <td>
                              @if (hasAdminPermission('view order_booking'))
                            <a href="{{ route('admin.orders.documents', $order->order_id) }}" class="btn btn-sm btn-light view-btn" data-bs-toggle="tooltip" title="View Documents"><i class="fas fa-file-alt text-primary"></i>
                              @endif
                            </a>
                            @if (hasAdminPermission('view order_booking'))
                            <a href="{{ route('admin.orders.view', $order->order_id) }}" class="btn btn-sm btn-light view-btn" data-bs-toggle="tooltip" title="View Order"><i class="fas fa-eye text-primary"></i>
                            </a>
                            @endif
                           @if (hasAdminPermission('edit order_booking'))
                                 @php
                                    $lrs = $order['lr'] ?? [];
                                    $allPodUploaded = false;

                                    if (is_array($lrs) && count($lrs) > 0) {
                                       $allPodUploaded = true;

                                       foreach ($lrs as $lr) {
                                          if (empty($lr['pod_uploaded']) || $lr['pod_uploaded'] == false || $lr['pod_uploaded'] == 0) {
                                             $allPodUploaded = false;
                                             break;
                                          }
                                       }
                                    }
                                 @endphp

                                 @if ($allPodUploaded)
                                    <button class="btn btn-sm btn-secondary" disabled>
                                       <i class="fas fa-pen text-warning"></i>
                                    </button>
                                 @else
                                    <a href="{{ route('admin.orders.edit', $order->order_id) }}"
                                       class="btn btn-sm btn-light edit-btn" data-bs-toggle="tooltip" title="Edit Order">
                                       <i class="fas fa-pen text-warning"></i>
                                    </a>
                                 @endif
                              @endif
                              @if (hasAdminPermission('delete order_booking'))
                              <a href="{{ route('admin.orders.delete', $order->order_id) }}"
                                    class="btn btn-sm btn-light delete-btn"
                                    data-bs-toggle="tooltip"
                                    title="Delete Order"
                                    onclick="return confirm('Are you sure you want to delete this order?');">
                                    <i class="fas fa-trash text-danger"></i>
                                 </a>
                            
                              @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach

                    </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- End Page-content -->
</div>
<!-- end main content-->



<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <form id="statusUpdateForm" method="post">
       @method('POST')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <!-- Hidden order ID -->
          <input type="hidden" id="orderIdInput" name="order_id">

          <!-- Status Dropdown -->
          <div class="mb-3">
            <label for="statusSelect" class="form-label">Select Status</label>
            <select class="form-select" id="statusSelect" name="status" required>
              {{-- <option value="Material-Collected">Material Collected</option>
              <option value="In-Transit">In Transit</option> --}}
              <option value="Delivered">Delivered</option>
              <option value="Completed">Completed</option>
              <option value="Processing">Processing</option>
              <option value="Delivered">Delivered</option>
              <option value="Request-lr">LR Request</option>
              <option value="Request-freeghtBill">Freight-Bill Request</option>
              <option value="Request-invioce">Invoice Request</option>
              <!-- Add more status options as needed -->
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Status</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- 
<script>
  $(document).ready(function() {
    // Open modal on status cell click
    $('.status-cell').click(function() {
      var orderId = $(this).data('order_id');
      var currentStatus = $(this).data('status');

      $('#orderIdInput').val(orderId);
      $('#statusSelect').val(currentStatus);
      $('#statusModal').modal('show');
    });

    // AJAX form submit
    $('#statusUpdateForm').submit(function(e) {
      e.preventDefault();

      var orderId = $('#orderIdInput').val();
      var newStatus = $('#statusSelect').val();

      // $.ajax({
      //   url: '/admin/orders/update-status/' + orderId,
      //   method: 'POST',
      //   data: {
      //     _token: '{{ csrf_token() }}',
      //     status: newStatus
      //   },
      //   success: function(response) {
      //     if (response.success) {
      //       $('#statusModal').modal('hide');

      //       // Update status text and data-status attribute
      //       $('#status-' + orderId).text(newStatus);
      //       $('#status-' + orderId).data('status', newStatus);
      //     } else {
      //       alert('Status update failed!');
      //     }
      //   },
      //   error: function() {
      //     alert('Error occurred while updating status.');
      //   }
      // });
    });
  });
</script> --}}


<script>
  $(document).ready(function() {
    // Open modal on status cell click
    $('.status-cell').click(function() {
      var orderId = $(this).data('order_id');
      var currentStatus = $(this).data('status');

      $('#orderIdInput').val(orderId);
      $('#statusSelect').val(currentStatus);

      // Set form action dynamically
      let form = document.getElementById('statusUpdateForm');
      form.action = `/admin/orders/update-status/${orderId}`;

      $('#statusModal').modal('show');
    });

    // Regular form submission, no AJAX
    $('#statusUpdateForm').submit(function() {
      // Allow default submission to backend route
      return true; // Optional — form submits by default
    });
  });
</script>



@endsection