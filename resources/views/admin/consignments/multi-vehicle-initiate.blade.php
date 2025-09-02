@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
    <!-- Order Booking listing Page -->
      <div class="row listing-form">
        <div class="col-12">
         
        <div class="card">
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center">Multi Vehicle Initiate</h4>
                    </div>
                </div> 
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                 <form method="POST" action="{{ route('admin.consignments.call_initiate_api') }}">
                    @csrf

                    <div class="form-group mt-2">
                        <label><strong>eWay Bill No</strong></label>
                        <input type="number" class="form-control" name="ewbNo" value="721008936390" required>
                    </div>

                    <div class="form-group mt-2">
                        <label><strong>From Place</strong></label>
                        <input type="text" class="form-control" name="fromPlace" value="BANGALORE" required>
                    </div>

                    <div class="form-group mt-2">
                        <label><strong>From State Code</strong></label>
                        <input type="number" class="form-control" name="fromState" value="07" required>
                    </div>

                    <div class="form-group mt-2">
                        <label><strong>To Place</strong></label>
                        <input type="text" class="form-control" name="toPlace" value="CHENNAI" required>
                    </div>

                    <div class="form-group mt-2">
                        <label><strong>To State Code</strong></label>
                        <input type="number" class="form-control" name="toState" value="27" required>
                    </div>

                    <div class="form-group mt-2">
                        <label><strong>Transport Mode</strong> <small>(1 = Road, 2 = Rail, etc.)</small></label>
                        <input type="number" class="form-control" name="transMode" value="1" required>
                    </div>

                    <div class="form-group mt-2">
                        <label><strong>Reason for Multi Vehicle</strong></label>
                        <input type="text" class="form-control" name="reasonRem" value="vehicle broke down" required>
                    </div>

                    <div class="form-group mt-2">
                        <label><strong>Total Quantity</strong></label>
                        <input type="number" class="form-control" name="totalQuantity" value="4" required>
                    </div>

                    <div class="form-group mt-2">
                        <label><strong>Unit Code</strong> <small>(BOX, NOS, LTR, etc.)</small></label>
                        <input type="text" class="form-control" name="unitCode" value="BOX" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">🚛 Initiate Multi Vehicle</button>
                 </form>


                @if(isset($response))
                    <div class="mt-4 alert alert-success">
                        <strong>Initiated Successfully</strong><br>
                        <strong>eWay Bill No:</strong> {{ $response['ewbNo'] }}<br>
                        <strong>Group No:</strong> {{ $response['groupNo'] }}<br>
                        <strong>Date:</strong> {{ $response['createdDate'] }}

                        <div class="mt-3">
                            @if($vehicleChanged ?? false)
                                <div class="alert alert-info mt-3">
                                    ✅ Vehicle already added/changed for this eWay Bill.
                                </div>

                                <!-- View Modal Trigger -->
                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vehicleModal">
                                    👁️ View Vehicle Details
                                </button> -->
                            @elseif($vehicleAdded ?? false)
                                <a href="{{ route('admin.consignments.change_vehicle_form', ['ewbNo' => $response['ewbNo'], 'groupNo' => $response['groupNo']]) }}"
                                    class="btn btn-warning">
                                    🔁 Change Vehicle Details
                                </a>
                            @else
                                <a href="{{ route('admin.consignments.add_vehicle_form', ['ewbNo' => $response['ewbNo'], 'groupNo' => $response['groupNo']]) }}"
                                    class="btn btn-success">
                                    ➕ Add Vehicle
                                </a>
                            @endif
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>
      </div>
    </div>
   <!-- End Page-content -->
</div>

@endsection