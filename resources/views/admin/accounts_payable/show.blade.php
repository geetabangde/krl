@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- View Vehicle Details Page -->
        <div class="view-vehicle-form">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>🚗 Vehicle Details View</h4>
                        <p class="mb-0">View details for the vehicle.</p>
                    </div>
                    <a href="{{ route('admin.accounts_payable.index') }}" class="btn" id="backToListBtn"
                        style="background-color: #ca2639; color: white; border: none;">
                        ⬅ Back to Listing
                    </a>
                </div>
                <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Account Payable Details for: <strong>{{ $label }}</strong></h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Type</th>
                                                <th>vendor Name</th>
                                                <th>Date</th>
                                                <th>Bill Amount</th>
                                                <th>Amount Paid</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($entries as $index => $entry)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $entry['type'] }}</td>
                                                <td>{{ $entry['supplier_name'] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($entry['date'])->format('d/m/Y') }}</td>
                                                <td>₹{{ number_format($entry['amount'], 2) }}</td>
                                                <td>₹{{ number_format($entry['paid'], 2) }}</td>
                                                <!-- <td>₹{{ number_format($entry['amount'] - $entry['paid'], 2) }}</td> -->
                                            </tr>
                                            @empty
                                            <tr><td colspan="7">No records found.</td></tr>
                                            @endforelse
                                        </tbody>
                                        {{-- ✅ Totals Footer --}}
                                            <tfoot>
                                                @php
                                                    $totalBill = collect($entries)->sum('amount');
                                                    $totalPaid = collect($entries)->sum('paid');
                                                    $totalPending = $totalBill - $totalPaid;
                                                @endphp
                                                <tr>
                                                    <th colspan="3" class="text-end">Total</th>
                                                    <th></th>
                                                    <th>₹{{ number_format($totalBill, 2) }}</th>
                                                    <th>₹{{ number_format($totalPaid, 2) }}</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" class="text-end">Pending Amount</th>
                                                    <th>₹{{ number_format($totalPending, 2) }}</th>
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