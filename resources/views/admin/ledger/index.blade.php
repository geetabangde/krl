@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
 <!-- start page title -->
            <div class="row">
                    <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Ledgers</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Ledgers</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Ledgers Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">📊 Ledgers</h4>
                                        <p class="card-title-desc">
                                            Overview of ledgers, including ledger name, group,and opening balance.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Company Name</th>
                                                <!-- <th>Voucher Type</th> -->
                                                <!-- <th>Type (Debit/Credit)</th> -->
                                                <th>Closing Balance</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ledgerSummary as $index => $entry)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $entry['company'] }}</td>
                                                <!-- <td>{{ $entry['voucher_type'] }}</td> -->
                                                <!-- <td>{{ $entry['type'] }}</td> -->
                                                <td>{{ number_format($entry['amount'], 2) }}</td>
                                                <td>
                                                    <a href="{{ route('admin.ledger.view', ['id' => $entry['ledger_id']]) }}"
                                                    class="btn btn-sm btn-light view-btn"
                                                    data-bs-toggle="tooltip"
                                                    title="View Ledgers">
                                                        <i class="fas fa-eye text-primary"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

@endsection
