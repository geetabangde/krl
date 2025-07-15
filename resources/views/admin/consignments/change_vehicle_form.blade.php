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
                        <h4 class="text-center">Multi Vehicle Change</h4>
                    </div>
                </div> 
                <form method="POST" action="{{ route('admin.consignments.call_change_vehicle') }}">
                    @csrf

                    <input type="hidden" name="ewbNo" value="{{ $ewbNo }}">
                    <input type="hidden" name="groupNo" value="{{ $groupNo }}">

                    <div class="mb-2">
                        <label>Old Vehicle No</label>
                        <input type="text" name="oldvehicleNo" class="form-control" required placeholder="Enter Old Vehicle No MP09CD1234">
                    </div>

                    <div class="mb-2">
                        <label>New Vehicle No</label>
                        <input type="text" name="newVehicleNo" class="form-control" required placeholder="Enter New Vehicle No MP10XY7789">
                    </div>

                    <div class="mb-2">
                        <label>Old Transport Doc No</label>
                        <input type="text" name="oldTranNo" class="form-control" required placeholder="Enter Old Trans Doc No L8897678">
                    </div>

                    <div class="mb-2">
                        <label>New Transport Doc No</label>
                        <input type="text" name="newTranNo" class="form-control" required placeholder="Enter New Trans Doc No LR789456">
                    </div>

                    <div class="mb-2">
                        <label>From Place</label>
                        <input type="text" name="fromPlace" class="form-control" required placeholder="Enter From Place BANGALORE">
                    </div>

                    <div class="mb-2">
                        <label>From State Code</label>
                        <input type="number" name="fromState" class="form-control" required placeholder="Enter From State Code 07">
                    </div>

                    <button class="btn btn-danger mt-2">Change Vehicle</button>
                </form>


                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>
        </div>
    </div>
      </div>
    </div>
   <!-- End Page-content -->
</div>

@endsection