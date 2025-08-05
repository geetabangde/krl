@extends('admin.layouts.app')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Voucher</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Voucher</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <!-- Voucher Listing Page -->
      <div class="row listing-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="card-title">🧾 Voucher List</h4>
                     <p class="card-title-desc">View, edit, or delete voucher records below.</p>
                  </div>
                  <a href="{{ route('admin.voucher.create') }}" class="btn" id="addVoucherBtn"
                     style="background-color: #ca2639; color: white; border: none;">
                  <i class="fas fa-plus"></i> Add
                  </a>
               </div>
               <div class="card-body">
                  <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Voucher Type</th>
                           <th>Date</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($vouchers as $key => $voucher)
                        <tr class="voucher-row" data-id="{{ $voucher->id }}">
                           <td>{{ $key + 1 }}</td>
                           <td>{{ $voucher->voucher_type }}</td>
                           <td>{{ \Carbon\Carbon::parse($voucher->voucher_date)->format('d-m-Y') }}</td>
                           <!-- Format date properly -->
                           <!-- From Ledger -->
                           <td class="text-center">
                              <div class="d-flex align-items-center gap-2">
                                 <a href="{{ route('admin.voucher.view', ['id' => $voucher->id]) }}" class="btn btn-sm btn-light view-group-btn">
                                 <i class="fas fa-eye text-primary"></i>
                                 </a>
                                 <a href="{{ route('admin.voucher.edit', ['id' => $voucher->id]) }}" class="btn btn-sm btn-light edit-btn">
                                 <i class="fas fa-pen text-warning"></i>
                                 </a>
                                 <a href="{{ route('admin.voucher.delete', ['id' => $voucher->id]) }}" class="btn btn-sm btn-light delete-btn">
                                 <i class="fas fa-trash text-danger"></i>
                                 </a>
                              </div>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
   </div>
   <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection