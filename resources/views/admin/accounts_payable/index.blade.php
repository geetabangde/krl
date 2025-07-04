@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
 <!-- start page title -->
                     <!-- start page title -->
                     <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Account Payable</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Account Payable</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Accounts Payable Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">💳 Accounts Payable</h4>
                                        <p class="card-title-desc">Overview of accounts payable, including vendor
                                            details and payment status.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Vendor Name</th>
                                                <th>Bill Date</th>
                                                <th>Bill Amount</th>
                                                <th>Amount Paid</th>
                                                <th>Pending</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report as $index => $row)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $row['supplier_name'] }}</td>
                                                    <td>{{ $row['bill_date'] }}</td>
                                                    <td>₹{{ number_format($row['amount'], 2) }}</td>
                                                    <td>₹{{ number_format($row['paid'], 2) }}</td>
                                                    <td>₹{{ number_format($row['pending'], 2) }}</td>
                                                    <td><a href="{{ route('admin.accounts_payable.view', ['label' => urlencode($row['label'])]) }}"
                                                            class="btn btn-sm btn-light view-btn"
                                                            title="View Detail">
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
