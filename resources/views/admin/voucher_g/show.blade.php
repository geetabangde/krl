@extends('admin.layouts.app')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- View Vehicle Details Page -->
      <div class="view-vehicle-form">
         <div class="card">
            <!-- View Voucher Details Section -->
            <div class="row view-form">
               <div class="col-12">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                           <h4>📄 View Voucher Details</h4>
                           <p>Review the details of the selected voucher.</p>
                        </div>
                        <a href="{{ route('admin.voucher.index') }}" class="btn" 
                           style="background-color: #ca2639; color: white; border: none;">
                        ⬅ Back
                        </a>
                     </div>
                     <div class="card-body">
                        <p><strong>Voucher ID:</strong> <span>{{ $voucher->id }}</span></p>
                        <p><strong>Voucher Type:</strong> {{ $voucher->voucher_type }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($voucher->voucher_date)->format('d-m-Y') }}</p>
                        <!-- Format the date properly -->
                        <!-- Handle the From and To Ledger details (may be null) -->
                        <p><strong>From Account:</strong> {{ $voucher->fromLedger->ledger_name ?? 'N/A' }}</p>
                        <p><strong>To Account:</strong> {{ $voucher->toLedger->ledger_name ?? 'N/A' }}</p>
                        <!-- Display the vouchers transactions (from the decoded JSON field) -->
                        @if ($voucher->voucher_data)
                        <div>
                           @foreach($voucher->voucher_data as $transaction)
                           <div>
                              <p><strong>From Account:</strong> {{ $transaction->from_account }}</p>
                              <p><strong>To Account:</strong> {{ $transaction->to_account }}</p>
                              <p><strong>Amount:</strong> ₹{{ number_format($transaction->amount, 2) }}</p>
                              <p><strong>Narration:</strong> {{ $transaction->narration ?? 'N/A' }}</p>
                              <p><strong>Tally Narration:</strong> {{ $transaction->tally_narration ?? 'N/A' }}</p>
                              <p><strong>Assigned To:</strong> {{ $transaction->assigned_to ?? 'N/A' }}</p>
                              <hr>
                           </div>
                           @endforeach
                        </div>
                        @else
                        <p>No transaction details available.</p>
                        @endif
                        <p><strong>Amount:</strong> ₹{{ number_format($voucher->amount, 2) ?? 'N/A' }}</p>
                        <!-- Amount may be null -->
                        <p><strong>Narration:</strong> {{ $voucher->narration ?? 'N/A' }}</p>
                        <p><strong>Tally Narration:</strong> {{ $voucher->tally_narration ?? 'N/A' }}</p>
                        <p><strong>Assigned To:</strong> {{ $voucher->assigned_to ?? 'N/A' }}</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
@endsection