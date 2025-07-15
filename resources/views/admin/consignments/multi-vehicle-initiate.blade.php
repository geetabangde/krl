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
                        <label>From Place</label>
                        <input type="text" class="form-control" name="fromPlace" value="BANGALORE">
                    </div>

                    <div class="form-group mt-2">
                        <label>To Place</label>
                        <input type="text" class="form-control" name="toPlace" value="CHENNAI">
                    </div>

                    <div class="form-group mt-2">
                        <label>Reason</label>
                        <input type="text" class="form-control" name="reasonRem" value="vehicle broke down">
                    </div>

                    <div class="form-group mt-2">
                        <label>Total Quantity</label>
                        <input type="number" class="form-control" name="totalQuantity" value="4">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Initiate</button>
                </form>

                @if(isset($response))
                    <div class="mt-4 alert alert-success">
                        <strong>Initiated Successfully</strong><br>
                        <strong>eWay Bill No:</strong> {{ $response['ewbNo'] }}<br>
                        <strong>Group No:</strong> {{ $response['groupNo'] }}<br>
                        <strong>Date:</strong> {{ $response['createdDate'] }}

                        <div class="mt-3">
                            {{-- Use named routes instead of hardcoded URLs --}}
                            <a href="{{ route('admin.consignments.add_vehicle_form', ['ewbNo' => $response['ewbNo'], 'groupNo' => $response['groupNo']]) }}" class="btn btn-success">
                                ➕ Add Vehicle
                            </a>

                            <!-- <a href="{{ route('admin.consignments.change_vehicle_form', ['ewbNo' => $response['ewbNo'], 'groupNo' => $response['groupNo']]) }}" class="btn btn-warning">
                                🔁 Change Vehicle
                            </a> -->
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