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
                    <a href="{{ route('admin.accounts_receivable.index') }}" class="btn" id="backToListBtn"
                        style="background-color: #ca2639; color: white; border: none;">
                        ⬅ Back to Listing
                    </a>
                </div>
                <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    
                                </div>
                               <div class="card-body">
                                    <h5>Account Details for: <strong>{{ $label }}</strong></h5>
                                    <table class="table table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Type</th>
                                                <th>Customer Name</th>
                                                <th>Date</th>
                                                <th>Bill Amount</th>
                                                <th>Amount Received</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalSales = 0;
                                                $totalReceived = 0;
                                            @endphp

                                            @foreach ($entries as $index => $entry)
                                                @php
                                                    $isSale = $entry['type'] === 'Sales';
                                                    $totalSales += $isSale ? $entry['amount'] : 0;
                                                    $totalReceived += !$isSale ? $entry['received'] : 0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $entry['type'] }}</td>
                                                    <td>{{ $entry['customer_name'] }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($entry['date'])->format('d/m/Y') }}</td>
                                                    <td>
                                                        ₹{{ number_format($isSale ? $entry['amount'] : 0, 2) }}
                                                    </td>
                                                    <td>
                                                        ₹{{ number_format(!$isSale ? $entry['received'] : 0, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            {{-- Totals --}}
                                            <tr class="fw-bold bg-light">
                                                <td colspan="4">Total</td>
                                                <td>₹{{ number_format($totalSales, 2) }}</td>
                                                <td>₹{{ number_format($totalReceived, 2) }}</td>
                                            </tr>
                                            <tr class="fw-bold bg-secondary text-white">
                                                <td colspan="5" class="text-end">Pending Amount</td>
                                                <td>₹{{ number_format($totalSales - $totalReceived, 2) }}</td>
                                            </tr>
                                        </tbody>
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