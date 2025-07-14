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
                    <input type="text" name="vehicleNo" class="form-control" required>
                    <input type="text" name="transDocNo" class="form-control" required>
                    <input type="date" name="transDocDate" class="form-control" required>
                    <input type="text" name="fromPlace" class="form-control" required>
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