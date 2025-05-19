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
                                        <p class="card-title-desc">Overview of ledgers, including ledger name, group,
                                            and opening balance.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ledger Name</th>
                                                <th>Ledger Group</th>
                                                <th>Opening Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vouchers as $index => $voucher)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $voucher->fromLedger->ledger_name ?? '-' }}</td>
                                                    <td>{{ $voucher->fromLedger->group->group_name ?? '-' }}</td>
                                                    <!-- <td>{{ $voucher->toLedger->ledger_name ?? '-' }}</td>
                                                    <td>{{ $voucher->toLedger->group->group_name ?? '-' }}</td> -->
                                                    <td>₹{{ number_format($voucher->amount, 2) }}</td>
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
