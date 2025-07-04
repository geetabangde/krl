@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
 <!-- start page title -->
 
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Account Receivable</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Account Receivable</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Accounts Receivable Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">💰 Accounts Receivable</h4>
                                        <p class="card-title-desc">Overview of accounts receivable, including customer
                                            details and payment status.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Invoice Date</th>
                                                <th>Amount</th>
                                                <th>Amount Received</th>
                                                <th>Pending</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($report as $index => $row)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $row['customer_name'] }}</td>
                                                    <td>{{ $row['invoice_date'] }}</td>
                                                    <td>₹{{ number_format($row['amount'], 2) }}</td>
                                                    <td>₹{{ number_format($row['received'], 2) }}</td>
                                                    <td>₹{{ number_format($row['pending'], 2) }}</td>
                                                    <td>
            <a href="{{ route('admin.accounts_receivable.view', ['label' => urlencode($row['label'])]) }}"
               class="btn btn-sm btn-light view-btn"
               data-bs-toggle="tooltip"
               title="View Account">
                <i class="fas fa-eye text-primary"></i>
            </a>
        </td>
                                                </tr>
                                            @endforeach
                                            <!-- Add more rows as needed -->
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
