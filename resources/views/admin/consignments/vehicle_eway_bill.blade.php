@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
    <!-- Order Booking listing Page -->
      <div class="row listing-form">
        <div class="col-12">
         
        <div class="card">
            <div class="container mb-4 mt-4">
                <a href="{{ route('admin.consignments.index') }}" class="btn" id="backToListBtn"
                    style="background-color: #ca2639; color: white; border: none;">
                ⬅ Back to Listing
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.consignments.vehicle_eway_bill.update') }}" method="POST">
                    @if(session('results'))
                        <div class="mt-3">
                            @foreach(session('results') as $result)
                                @if(isset($result['success']) && $result['success'])
                                    <div class="alert alert-success">
                                        ✅ eWay Bill #{{ $result['ewbNo'] }} updated successfully.  
                                        <small>{{ $result['message'] ?? '' }}</small>
                                    </div>
                                @elseif(isset($result['error']))
                                    <div class="alert alert-danger">
                                        ❌ eWay Bill #{{ $result['ewbNo'] }} failed.  
                                        <br><strong>Message:</strong> {{ $result['error'] }}  
                                        @if(!empty($result['errorCode']))
                                            <br><strong>Code:</strong> {{ $result['errorCode'] }}
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- CSRF Token -->

                    @csrf
                    @foreach($ewaybills as $index => $bill)
                        <h4 class="mb-3">Update Part B: <strong>{{ $bill['ewbNo'] ?? '' }}</strong></h4>

                        @php
                            $vehicleDetails = $bill['VehiclListDetails'][0] ?? [];
                        @endphp

                        <div class="card mb-4 shadow-sm p-3">
                            
                            <div class="form-group mb-2">
                                <label>Vehicle No</label>
                                <input type="text" name="ewaybills[{{ $index }}][vehicle_no]" class="form-control"
                                    value="{{ old("ewaybills.$index.vehicle_no", $vehicleDetails['vehicleNo'] ?? '') }}">
                            </div>
                            <div class="form-group mb-2">
                                <label>From State Code</label>
                                <input type="text" name="ewaybills[{{ $index }}][from_state_code]" class="form-control" 
                                    value="{{ old("ewaybills.$index.from_state_code", $bill['fromStateCode'] ?? '') }}">
                            </div>


                            <div class="form-group mb-2">
                                <label>From Place</label>
                                <input type="text" name="ewaybills[{{ $index }}][from_place]" class="form-control"
                                    value="{{ old("ewaybills.$index.from_place", $vehicleDetails['fromPlace'] ?? $bill['fromPlace'] ?? '') }}">
                            </div>

                            <div class="form-group mb-2">
                                <label>To Place</label>
                                <input type="text" name="ewaybills[{{ $index }}][to_place]" class="form-control"
                                    value="{{ old("ewaybills.$index.to_place", $bill['toPlace'] ?? '') }}">
                            </div>

                            <!-- Reason Code -->
                                <div class="form-group mb-2">
                                    <label>Reason Code</label>
                                    <select name="ewaybills[{{ $index }}][reasoncode]" class="form-control" required>
                                        <option value="">-- Select Reason --</option>
                                        <option value="1" {{ old("ewaybills.$index.reasoncode", $bill['reasoncode'] ?? '') == '1' ? 'selected' : '' }}>1 - Transhipment</option>
                                        <option value="2" {{ old("ewaybills.$index.reasoncode", $bill['reasoncode'] ?? '') == '2' ? 'selected' : '' }}>2 - Vehicle Breakdown</option>
                                        <option value="3" {{ old("ewaybills.$index.reasoncode", $bill['reasoncode'] ?? '') == '3' ? 'selected' : '' }}>3 - Not Verified by Tax Officer</option>
                                        <option value="4" {{ old("ewaybills.$index.reasoncode", $bill['reasoncode'] ?? '') == '4' ? 'selected' : '' }}>4 - Other</option>
                                    </select>
                                </div>

                            <div class="form-group mb-2">
                                <label>Reason Remark</label>
                                <input type="text" name="ewaybills[{{ $index }}][reasonremarks]" class="form-control"
                                    value="{{ old("ewaybills.$index.reasonremarks", $bill['reasonremarks'] ?? '') }}">
                            </div>

                            <div class="form-group mb-2">
                                <label>TransDocNo</label>
                                <input type="text" name="ewaybills[{{ $index }}][transDocNo]" class="form-control"
                                    value="{{ old("ewaybills.$index.transDocNo", $vehicleDetails['transDocNo'] ?? '') }}">
                            </div>

                            <div class="form-group mb-2">
                                <label>TransDocDate</label>
                                <input type="text" name="ewaybills[{{ $index }}][transDocDate]" class="form-control"
                                    value="{{ old("ewaybills.$index.transDocDate", $vehicleDetails['transDocDate'] ?? '') }}">
                            </div>

                            

                            <!-- TransMode (1=Road, 2=Rail, 3=Air, 4=Ship) -->
                            <div class="form-group mb-2">
                                <label>Trans Mode</label>
                                <select name="ewaybills[{{ $index }}][transMode]" class="form-control" required>
                                    <option value="">-- Select Mode --</option>
                                    <option value="1" {{ old("ewaybills.$index.transMode", $vehicleDetails['transMode'] ?? '') == '1' ? 'selected' : '' }}>1 - Road</option>
                                    <option value="2" {{ old("ewaybills.$index.transMode", $vehicleDetails['transMode'] ?? '') == '2' ? 'selected' : '' }}>2 - Rail</option>
                                    <option value="3" {{ old("ewaybills.$index.transMode", $vehicleDetails['transMode'] ?? '') == '3' ? 'selected' : '' }}>3 - Air</option>
                                    <option value="4" {{ old("ewaybills.$index.transMode", $vehicleDetails['transMode'] ?? '') == '4' ? 'selected' : '' }}>4 - Ship</option>
                                </select>
                            </div>

                            <!-- Vehicle Type (R=Regular, O=ODC) -->
                            <div class="form-group mb-2">
                                <label>Vehicle Type</label>
                                <select name="ewaybills[{{ $index }}][vehicleType]" class="form-control" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="R" {{ old("ewaybills.$index.vehicleType", $bill['vehicleType'] ?? '') == 'R' ? 'selected' : '' }}>R - Regular</option>
                                    <option value="O" {{ old("ewaybills.$index.vehicleType", $bill['vehicleType'] ?? '') == 'O' ? 'selected' : '' }}>O - Over Dimensional Cargo</option>
                                </select>
                            </div>

                            <input type="hidden" name="ewaybills[{{ $index }}][ewb_no]" value="{{ $bill['ewbNo'] ?? '' }}">
                        </div>
                    @endforeach

                    <!-- ✅ Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update Part B</button>
                    </div>
                </form>

            </div>
        </div>


    </div>

      </div>
    </div>
   <!-- End Page-content -->
</div>



@endsection