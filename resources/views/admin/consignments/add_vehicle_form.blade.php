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
                        <h4 class="text-center">Multi Vehicle Add</h4>
                    </div>
                </div> 
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.consignments.call_add_vehicle') }}">
                    @csrf
                    <input type="hidden" name="ewbNo" value="{{ $ewbNo }}">
                    <input type="hidden" name="groupNo" value="{{ $groupNo }}">
                    <div class="mb-2">
                        <label> Vehicle No</label>
                        <input type="text" name="vehicleNo" class="form-control" placeholder="Enter a vehicle number MP09CD1234" required>
                    </div>
                    <div class="mb-2">
                        <label> Trans Doc No</label>
                        <input type="text" name="transDocNo" class="form-control" placeholder="Enter a Trans Doc No L8897678" required>
                    </div>
                    <div class="mb-2">
                        <label> Trans Doc Date</label>
                        <input type="date" name="transDocDate" class="form-control" placeholder="Enter a Trans Doc Date 15/07/2025"  required>
                    </div>
                    <div class="mb-2">
                        <label> Quantity</label>
                        <input type="text" name="quantity" class="form-control" required placeholder="Enter a quantity">
                      </div>
                    <button class="btn btn-primary mt-2">Add Vehicle</button>
                </form>

                @if(isset($success))
                <a href="{{ route('admin.consignments.change_vehicle_form', ['ewbNo' => $ewbNo, 'groupNo' => $groupNo]) }}" class="btn btn-warning mt-3">Proceed to Change Vehicle</a>
                @endif
            </div>
        </div>
    </div>
      </div>
    </div>
   <!-- End Page-content -->
</div>







@endsection