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
                    <input type="text" name="vehicleNo" class="form-control" required>

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