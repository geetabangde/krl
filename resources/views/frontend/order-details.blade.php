@extends('frontend.layouts.dashboard-app')
@section('title') {{ 'contact' }} @endsection
@section('content')
<style>
   .navbar-nav .nav-link {
   color: #333;
   transition: color 0.3s ease;
   }
   .navbar-nav .nav-link:hover {
   color: #007bff;
   }
   .navbar-nav .badge {
   font-size: 10px;
   padding: 2px 5px;
   }
   .dropdown-menu {
   font-size: 0.9rem;
   border-radius: 8px;
   }
   .theme-btn:hover {
   background-color: #0056b3;
   color: #fff;
   }
   .theme-btn {
   background-color: #c72336;
   color: #fff;
   border: none;
   transition: background-color 0.3s ease;
   font-weight: 600 !important;
   border-radius: 10px !important;
   margin-left: 20px;
   }
   .navbar-nav .badge {
   font-size: 12px;
   padding: 2px 5px;
   margin-top: 23px;
   }
   /* Primary and Secondary Colors */
   .text-secondary-custom {
   color: #003F72 !important;
   }
   .custom-badge {
   background-color: #c72336;
   color: #fff;
   font-size: 0.7rem;
   padding: 4px 6px;
   border-radius: 10px;
   }
   .custom-dropdown {
   border: 1px solid #e0e0e0;
   border-radius: 8px;
   background-color: #f8f9fa;
   }
   .dropdown-item:hover {
   background-color: #003F72;
   color: #fff;
   }
   .dropdown-item i {
   min-width: 16px;
   }
   .view-all-link {
   color: #c72336;
   font-weight: 500;
   }
   .view-all-link:hover {
   color: #fff;
   background-color: #c72336;
   }
   .theme-btn {
   background-color: #003F72;
   color: #fff;
   transition: background 0.3s ease;
   }
   .theme-btn:hover {
   background-color: none !important;
   color: #fff;
   }
   .profile-dropdown {
   border: 1px solid #e0e0e0;
   border-radius: 8px;
   background-color: #f8f9fa;
   }
   .profile-dropdown .dropdown-item {
   font-size: 0.9rem;
   padding: 8px 12px;
   border-radius: 6px;
   }
   .profile-dropdown .dropdown-item:hover {
   background-color: #003F72;
   color: #fff;
   }
   .text-secondary-custom {
   color: #003F72;
   }
   .navbar .nav-item .dropdown-menu .dropdown-item:hover {
   background: none;
   color: #c72336 !important;
   }
   .bg-primary-custom {
   background-color: #c72336 !important;
   color: #fff;
   }
   .btn-danger {
   background-color: #c72336;
   border-color: #c72336;
   }
   .btn-danger:hover {
   background-color: #a31c2c;
   border-color: #a31c2c;
   }
   .table thead th {
   background-color: #f8f9fa;
   }
   .pagination .page-link {
   color: #003F72;
   }
   .pagination .active .page-link {
   background-color: #c72336 !important;
   border-color: #c72336 !important;
   }
   .res {
   margin-top: 4%;
   }
   :root {
   --primary-color: #c72336;
   --secondary-color: #003F72;
   }
   .card-header-title {
   color: var(--secondary-color);
   font-weight: 600;
   }
   .btn-primary-custom {
   background-color: var(--primary-color);
   color: #fff;
   border: none;
   }
   .btn-primary-custom:hover {
   background-color: #a91b2b;
   }
   .btn-secondary-outline {
   border: 1px solid var(--secondary-color);
   color: var(--secondary-color);
   }
   .btn-secondary-outline:hover {
   background-color: var(--secondary-color);
   color: #fff;
   }
   .badge-custom {
   background-color: var(--primary-color);
   }
   .text-secondary-custom {
   color: #003F72 !important;
   font-weight: 600;
   }
   .accordion-item>.accordion-header .accordion-button {
   font-weight: 600;
   color: #c72336 !important;
   }
   .accordion-button:not(.collapsed) {
   color: var(--bs-accordion-active-color);
   background-color: #fff;
   box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color);
   color: #003F72 !important;
   font-weight: 600;
   }
   .in-btn {
   background-color: #c72336;
   color: white;
   width: 146px;
   font-weight: 600;
   padding: 10px;
   font-size: 15px;
   }
   @media (max-width: 576px) {
   .table-responsive {
   font-size: 0.875rem;
   }
   }
   @media (max-width: 576px) {
   .nav-btn {
   margin-top: 10px;
   }
   .profile-dropdown {
   min-width: 100%;
   }
   }
   @media (max-width: 576px) {
   .custom-dropdown {
   min-width: 100%;
   }
   }
   @media (max-width: 767.98px) {
   .res .col-custom {
   width: 50%;
   flex: 0 0 50%;
   }
   .portfolio-sidebar .widget {
   background: var(--color-white);
   padding: 15px;
   border-radius: 7px;
   margin-bottom: 0px;
   box-shadow: 0 0 12px 2px rgb(0 0 0 / 5%);
   height: 136px;
   }
   .portfolio-sidebar .widget .title {
   font-size: 18px;
   }
   .portfolio-sidebar h3 {
   color: #c72336;
   font-size: 32px;
   margin-top: -15px;
   }
   .navbar .offcanvas-header .btn-close {
   background-color: var(--color-red);
   background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 2l12 12M14 2L2 14'/%3E%3C/svg%3E");
   background-size: 1rem;
   background-repeat: no-repeat;
   background-position: center;
   }
   .navbar-toggler span {
   border: none;
   }
   .in-btn {
   background-color: #c72336;
   color: white;
   width: 111px;
   font-weight: 600;
   padding: 5px;
   font-size: 12px;
   }
   .accordion-item>.accordion-header .accordion-button {
   font-weight: 600;
   color: #c72336 !important;
   padding: 12px;
   font-size: 14px;
   }
   .navbar-nav .badge {
   font-size: 12px;
   padding: 2px 5px;
   margin-top: 0;
   }
   .card {
   margin-top: -35px;
   }
   }
</style>
<section class="container my-5 py-5 mt-2">
   <div class="card shadow-sm p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
         <h4 class="card-header-title" style="color: #c72336;">
            <i class="fas fa-file-alt me-2 "></i>Order Details
         </h4>
         <a href="{{ route('user.dashboard') }}" class="btn btn-secondary-outline btn-sm">
         <i class="fas fa-arrow-left me-1"></i>Back
         </a>
      </div>
     
      <div class="row mb-3">
         <div class="col-md-6">
            <p><strong>Order ID:</strong> <span class="text-secondary-custom">{{ $order->order_id ?? 'N/A' }}</span></p>
            <p><strong>From:</strong> <span class="text-secondary-custom">{{ $order->fromDestination->destination ?? 'N/A' }}</span></p>
            <p><strong>Description:</strong> <span class="text-secondary-custom">{{ $order->description ?? 'N/A' }}</span>
            </p>
         </div>
         <div class="col-md-6">
            <p><strong>Date:</strong> <span class="text-secondary-custom">{{ $order->order_date ?? 'N/A' }}</span></p>
            <p><strong>To:</strong> <span class="text-secondary-custom">{{ $order->toDestination->destination ?? 'N/A' }}</span></p>
           
         </div>
      </div>
      <hr>
      <h5 class="mb-3 text-secondary-custom">
         <i class="fas fa-info-circle me-2 "></i>Additional Information
      </h5>
      <ul>
      @php
         $userAddress = App\Models\User::find($order->customer_id);
      @endphp
      @if (!empty($userAddress->address) && is_array($userAddress->address))
      @foreach ($userAddress->address as $address)
      <ul>
         <li><strong>Location:</strong> {{ $address['city'] ?? '' }}</li>
         <li><strong>GSTIN :</strong> {{ $address['gstin'] ?? '' }}</li>
         <li><strong>Billing Address :</strong> {{ $address['billing_address'] ?? '' }}</li>
         <li><strong>Consignment Address :</strong> {{ $address['consignment_address'] ?? '' }}</li>
         <li><strong>Mobile Number :</strong> {{ $address['mobile_number'] ?? '' }}</li>
         <li><strong>Email :</strong> {{ $address['email'] ?? '' }}</li>
         <li><strong>POC:</strong> {{ $address['poc'] ?? '' }}</li>
      </ul>
      @endforeach
      @else
      <p>No Address Available</p>
      @endif
      <hr>
      <!-- LR Section with heading and button -->
      <div class="d-flex justify-content-between mt-4 align-items-center mb-3">
         <h5 class="mb-0" style="color: #003F72;">
            <i class="fas fa-truck me-2"></i>LR
         </h5>
         <form action="{{ route('order.requests') }}" method="post">
            @csrf
         <input type="hidden" value="{{ $order->order_id}}" name="order_id">
         <input type="hidden" value="Request-lr" name="status">
         <!-- <button name="submit">req</button> -->
           @if(empty($order->lr))
         <button  type="submit" class="btn btn-sm in-btn" style="background-color: #c72336; color: white;" type="button"
            data-bs-toggle="collapse" data-bs-target="#lrSection" aria-expanded="false"
            aria-controls="lrSection">
         Request LR
         </button>
         @endif
         </form>
        
      </div>
      <!-- Collapsible LR Section -->
      <div class="collapse show" id="lrSection">
         <div class="accordion" id="lrAccordion">
         @php
         $lrData = is_array($order->lr) ? $order->lr : (json_decode($order->lr ?? '[]', true) ?? []);
         @endphp
         @if(!empty($order->lr))
          @foreach($lrData as $index => $lr)
            <div class="accordion-item">
               <h2 class="accordion-header" id="lrHeading2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                     data-bs-target="#lrCollapse2" aria-expanded="false" aria-controls="lrCollapse2"
                     style="color: #003F72;">
                 {{ $lr['lr_number'] ?? '' }}
                  </button>
               </h2>
               <div id="lrCollapse2" class="accordion-collapse collapse" aria-labelledby="lrHeading2"
                  data-bs-parent="#lrAccordion">
                  <div class="accordion-body">
                     <div class="row align-items-center g-3">
                        <div class="col-md-auto">
                           <strong>LR Number:</strong> <span
                              class="text-secondary-custom"> {{ $lr['lr_number'] ?? '' }}</span>
                        </div>
                        <div class="col-md-auto">
                           <strong>LR Date:</strong> <span
                              class="text-secondary-custom">{{ $lr['lr_date'] ?? '' }}</span>
                        </div>
                       
                        <div class="col-md-auto">
                              @php   
                             $from = App\Models\Destination::find($lr['from_location']);
                             $to = App\Models\Destination::find($lr['to_location']);
                              @endphp
                           <strong>From:</strong> <span class="text-secondary-custom">{{$from->destination ?? ''}}</span>
                        </div>
                        <div class="col-md-auto">
                           <strong>To:</strong> <span class="text-secondary-custom">{{$to->destination ?? ''}}</span>
                        </div>
                        <div class="col-md text-end">
                         <a href="{{ route('user.lr_details', ['lr_number' => $lr['lr_number']]) }}" class="btn btn-sm px-3"
                              style="background-color: #003F72; color: white;">
                              <i class="fas fa-eye me-1"></i>View LR
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
            @else
            <h6 style="color: red;">No Found LR</h6>
            @endif
            <!-- Add more LR items here as needed -->
         </div>
      </div>
      <!-- FB Section with heading and button -->
      <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
         <h5 class="mb-0" style="color: #003F72;">
            <i class="fas fa-file-invoice me-2"></i>Freight Bill (FB)
         </h5>
          <form action="{{ route('order.requests') }}" method="post">
            @csrf
         <input type="hidden" value="{{ $order->order_id}}" name="order_id">
         <input type="hidden" value="Request-freeghtBill" name="status">
         @if(empty($freightBill) || count($freightBill) == 0)
      <button  type="submit" class="btn btn-sm in-btn" style="background-color: #28a745; color: white;" type="button"
        data-bs-toggle="collapse" data-bs-target="#fbSection" aria-expanded="false"
        aria-controls="fbSection">
        Send Request FB
    </button>
     </form>
@endif
{{-- @dd($lrData ); --}}
      </div>
      <!-- Collapsible FB Section -->
     <div class="collapse show" id="fbSection">
   <div class="accordion" id="fbAccordion">
      @if(!empty($freightBill) && count($freightBill) > 0)
         @foreach($freightBill as $index => $bill)
          @foreach($lrData as $index => $lr)
         <div class="accordion-item">
            <h2 class="accordion-header" id="fbHeading{{ $index }}">
               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#fbCollapse{{ $index }}" aria-expanded="false" aria-controls="fbCollapse{{ $index }}"
                  style="color: #003F72;">
               {{ $bill->freight_bill_number }}
               </button>
            </h2>
            <div id="fbCollapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="fbHeading{{ $index }}"
               data-bs-parent="#fbAccordion">
               <div class="accordion-body">
                  <div class="d-flex flex-wrap align-items-center justify-content-between g-3">
                     <div class="flex-fill">
                     @php
                         $name = App\Models\User::find($lr['consignee_id']);
                     @endphp   
                        <p><strong>Consignment Sent To: <span  class="text-secondary-custom">{{ $name->name}}</span></strong></p>
                        <p><span class="text-secondary-custom"><span style="color: black;">Address:</span> {{ $lr['consignee_unloading']}}</span></p>
                     </div>
                     <div class="flex-fill">
                        <p><strong>Freight:</strong> <span class="text-secondary-custom">Order</span></p>
                     </div>
                     <div class="flex-fill">
                        <p><strong>Bill No.:</strong> <span class="text-secondary-custom">{{ $bill->freight_bill_number }}</span></p>
                     </div>
                     <div class="flex-fill">
                        <p><strong>Date:</strong> <span class="text-secondary-custom">{{ $bill->created_at }}</span></p>
                     </div>
                     <div class="text-end">
                        <a href="{{ route('user.fb_details', ['order_id' => $order->order_id, 'id' => $bill->id]) }}" class="btn btn-sm mt-2"
                           style="background-color: #003F72; color: white;">
                           <i class="fas fa-eye me-1"></i>View FB
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
         @endforeach
      @else
         <h6 style="color: red;">No Freight Bill Found</h6>
      @endif
   </div>
</div>

{{-- Invoice Section --}}
<div class="d-flex justify-content-between align-items-center mb-3 mt-4">
   <h5 class="mb-0" style="color: #003F72;">
      <i class="fas fa-file-invoice-dollar me-2"></i>Invoice
   </h5>
   @php
   $hasInvoice = false;
   if (!empty($freightBill)) {
       foreach ($freightBill as $billCheck) {
           $invoiceCheck = \App\Models\Invoice::where('freight_bill_id', $billCheck->id)->first();
           if ($invoiceCheck) {
               $hasInvoice = true;
               break;
           }
       }
   }
@endphp
 <form action="{{ route('order.requests') }}" method="post">
            @csrf
         <input type="hidden" value="{{ $order->order_id}}" name="order_id">
         <input type="hidden" value="Request-invioce" name="status">
@if(!$hasInvoice)
   <button  type="submit" class="btn in-btn btn-sm" style="background-color: #17a2b8; color: white;" type="button"
      data-bs-toggle="collapse" data-bs-target="#invoiceSection" aria-expanded="false"
      aria-controls="invoiceSection">
      Pending Request
   </button>
    </form>
   @endif
</div>

<div class="collapse show" id="invoiceSection">
   <div class="accordion" id="invoiceAccordion">
      @if(!empty($freightBill) && count($freightBill) > 0)
         @foreach($freightBill as $index => $bill)
            @php
               $invoice = \App\Models\Invoice::where('freight_bill_id', $bill->id)->first();
            @endphp
            @if($invoice)
            <div class="accordion-item">
               <h2 class="accordion-header" id="invoiceHeading{{ $index }}">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                     data-bs-target="#invoiceCollapse{{ $index }}" aria-expanded="false"
                     aria-controls="invoiceCollapse{{ $index }}" style="color: #003F72;">
                  {{ $invoice->invoice_number }}
                  </button>
               </h2>
               <div id="invoiceCollapse{{ $index }}" class="accordion-collapse collapse"
                  aria-labelledby="invoiceHeading{{ $index }}" data-bs-parent="#invoiceAccordion">
                  <div class="accordion-body">
                     <div class="row align-items-center g-3">
                        <div class="col-md-auto">
                           <p><strong>Invoice Number:</strong> <span class="text-secondary-custom">{{ $invoice->invoice_number }}</span></p>
                        </div>
                        <div class="col-md-auto">
                           <p><strong>Date:</strong> <span class="text-secondary-custom">{{ $invoice->invoice_date }}</span></p>
                        </div>
                        <div class="col-md text-end">
                           <a href="{{ route('user.inv_details', $bill->id) }}" class="btn btn-sm mt-2"
                              style="background-color: #003F72; color: white;">
                              <i class="fas fa-eye me-1"></i>View Invoice
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endif
         @endforeach
      @else
         <h6 style="color: red;">No Invoice Found</h6>
      @endif
   </div>
</div>

   </div>
</section>
@endsection