@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- View Vehicle Details Page -->
        <div class="view-vehicle-form">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    
                    <a href="{{ route('admin.ledger.index') }}" class="btn" id="backToListBtn"
                        style="background-color: #ca2639; color: white; border: none;">
                        ⬅ Back to Listing
                    </a>
                </div>
                 <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                     <h4 class="mb-3">Ledger: {{ $ledger->name }}</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Voucher Type</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Narration</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($voucherRecords as $index => $row)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $row['date'] }}</td>
                                                        <td>{{ $row['type'] }}</td>
                                                        <td>{{ $row['debit'] ? number_format($row['debit'], 2) : '' }}</td>
                                                        <td>{{ $row['credit'] ? number_format($row['credit'], 2) : '' }}</td>
                                                        <td>{{ $row['narration'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            {{-- ✅ Totals and Closing --}}
                                           <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-end">Total</th>
                                                    <th>{{ number_format($totalDebit, 2) }}</th>
                                                    <th>{{ number_format($totalCredit, 2) }}</th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-end">Closing Balance</th>
                                                    <th colspan="2">
                                                            @php
                                                                $closing = $closingBalance;
                                                                $closingType = $closing >= 0 ? 'Dr' : 'Cr';
                                                                $closingColor = $closing >= 0 ? 'text-success' : 'text-danger';
                                                                $closingFormatted = number_format($closing, 2); // Will include - if negative
                                                            @endphp
                                                            <span class="{{ $closingColor }}">
                                                                {{ $closingFormatted }}
                                                            </span>
                                                        </th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>

                                        </table>
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