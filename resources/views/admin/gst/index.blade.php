@extends('admin.layouts.app')
@section('content')

<div class="page-content">
<div class="container-fluid">
     <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">GST</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">GST</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- GST Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">📄 GST Listing</h4>
                                        <p class="card-title-desc">Overview of GST records and filing status.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>GST</th>
                                                <th>Invoice Number</th>
                                                <th>GST Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>27ABCDE1234F1Z5</td>
                                                <td>INV-1001</td>
                                                <td>₹5,000</td>
                                                <td><span class="badge bg-success">Filed</span></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>27WXYZ5678G9H6</td>
                                                <td>INV-1002</td>
                                                <td>₹3,200</td>
                                                <td><span class="badge bg-danger">Not Filed</span></td>
                                            </tr>
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
</div>
</div>
            <!-- End Page-content -->

@endsection
