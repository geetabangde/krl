@extends('admin.layouts.app')

@section('content')
<div class="page-content">
  <div class="container-fluid">
    <!-- Voucher Details Card -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h4>📄 Voucher Details View</h4>
          <p>View details for the voucher.</p>
        </div>
        <a href="{{ route('admin.voucher.index') }}" class="btn btn-danger">
          ⬅ Back to Listing
        </a>
      </div>

      <div class="card-body">
        <!-- Voucher Info Block -->
        <div class="row mb-3">
          <div class="col-md-4">
            🗂️ <strong>Voucher Type:</strong> {{ $voucher->voucher_type ?? 'N/A' }}
          </div>
          <div class="col-md-4">
            📅 <strong>Voucher Date:</strong> {{ \Carbon\Carbon::parse($voucher->voucher_date)->format('d-m-Y') }}
          </div>
          <div class="col-md-4">
            🆔 <strong>Voucher ID:</strong> {{ $voucher->id }}
          </div>
        </div>

        @php
          $voucherRows = is_string($voucher->vouchers) ? json_decode($voucher->vouchers, true) : $voucher->vouchers;

        @endphp

        @if (!empty($voucherRows) && is_array($voucherRows))
          @foreach ($voucherRows as $transaction)
            <div class="border rounded p-3 mb-3">
              <div class="row mb-2">
                <div class="col-md-4">🔢 <strong>Voucher No:</strong> {{ $transaction['voucher_no'] ?? 'N/A' }}</div>
                <div class="col-md-4">🔗 <strong>Transaction ID:</strong> {{ $transaction['transaction_id'] ?? 'N/A' }}</div>
                <div class="col-md-4">💰 <strong>Amount:</strong> ₹{{ number_format($transaction['amount'] ?? 0, 2) }}</div>
              </div>

              <div class="row mb-2">
              @php
                 
                  [$fromId, $fromAddressIndex] = explode('__', $transaction['from_account'] ?? '__');
                  [$toId, $toAddressIndex] = explode('__', $transaction['to_account'] ?? '__');

                  $fromUser = App\Models\User::find($fromId);
                  $toUser = App\Models\User::find($toId);

                  $fromAddresses = [];
                  $toAddresses = [];

                  if ($fromUser && $fromUser->address) {
                     $fromAddresses = is_string($fromUser->address) ? json_decode($fromUser->address, true) : $fromUser->address;
                  }

                  if ($toUser && $toUser->address) {
                     $toAddresses = is_string($toUser->address) ? json_decode($toUser->address, true) : $toUser->address;
                  }

                  $fromAddress = $fromAddresses[$fromAddressIndex] ?? [];
                  $toAddress = $toAddresses[$toAddressIndex] ?? [];

                  $fromCity = $fromAddress['city'] ?? 'N/A';
                  $fromState = $fromAddress['state'] ?? 'N/A';

                  $toCity = $toAddress['city'] ?? 'N/A';
                  $toState = $toAddress['state'] ?? 'N/A';
                  @endphp

                  <div class="col-md-4">
                  🏦 <strong>From Account:</strong> {{ $fromUser->name ?? 'N/A' }}<br>
                  📍 <small>{{ $fromCity }}, {{ $fromState }}</small>
                  </div>

                  <div class="col-md-4">
                  🏦 <strong>To Account:</strong> {{ $toUser->name ?? 'N/A' }}<br>
                  📍 <small>{{ $toCity }}, {{ $toState }}</small>
                  </div>

                  <div class="col-md-4">
                  💳 <strong>Cash/Credit:</strong> {{ $transaction['cash_credit'] ?? 'N/A' }}
                  </div>


              <div class="row mb-2">
                <div class="col-md-4">🏦 <strong>Instrument Type:</strong> {{ $transaction['instrument_type'] ?? 'N/A' }}</div>
                <div class="col-md-4">🔢 <strong>Instrument Number:</strong> {{ $transaction['instrument_number'] ?? 'N/A' }}</div>
                <div class="col-md-4">📅 <strong>Instrument Date:</strong> {{ $transaction['instrument_date'] ?? 'N/A' }}</div>
              </div>

              <div class="row mb-2">
                <div class="col-md-4">⏳ <strong>Credit Day:</strong> {{ $transaction['credit_day'] ?? 'N/A' }}</div>
                <div class="col-md-4">💸 <strong>TDS Payable:</strong> {{ $transaction['tds_payable'] ?? 'N/A' }}</div>
                <div class="col-md-4">👤 <strong>Assigned To:</strong> {{ $transaction['assigned_to'] ?? 'N/A' }}</div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  📝 <strong>Narration:</strong> {{ $transaction['narration'] ?? 'N/A' }}
                </div>
                <div class="col-md-6">
                  🗒️ <strong>Tally Narration:</strong> {{ $transaction['tally_narration'] ?? 'N/A' }}
                </div>
              </div>
            </div>
          @endforeach
        @else
          <p>No voucher transactions found.</p>
        @endif

      </div>
    </div>
  </div>
</div>
@endsection
