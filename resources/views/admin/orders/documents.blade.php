@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')

<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18"> LR / Consignment Documents</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active"> LR / Consignment/</li>
                     <li class="breadcrumb-item active">Documents </li>
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
                     <h4 class="card-title">📦 LR / Consignment Documents </h4>
                     <p class="card-title-desc"> Documents View , edit, or delete order details below.</p>
                  </div>
               </div>
               {{-- <pre>{{ dd($order) }}</pre> --}}

               <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Order ID</th>
                            <th>LR Number</th>
                            <th>Document Name</th>
                            <th>Document Image</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @php $count = 1; @endphp
                 @if(!empty($order->lr))
                        @foreach ($order->lr as $lr)
                            @if (!empty($lr['cargo']) && is_array($lr['cargo']))
                                @foreach ($lr['cargo'] as $cargo)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $order->order_id ?? '-' }}</td>
                                        <td>{{ $lr['lr_number'] ?? '-' }}</td>
                                        <td>{{ $cargo['document_name'] ?? '-' }}</td>
                                       
                                        <td>
                                         
                                            @if (!empty($cargo['document_file']))
                                                <img src="{{ asset('storage/'. $cargo['document_file']) }}" alt="Document" width="100">

                                            @else
                                                No Image
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        @endif
                
                    </tbody>
                </table>
                
               </div>
            </div>
         </div>
      </div>
      <!-- pod upload -->
      <!-- pod upload -->
   </div>
   <!-- End Page-content -->
</div>

@endsection