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
                <form action="#" method="POST">
                        @csrf
                        @foreach($ewaybills as $index => $bill)
                            <h4 class="mb-3">Update Part B: <strong>{{ $bill['ewbNo'] ?? '' }}</strong></h4>

                            <div class="card mb-4 shadow-sm p-3">
                                <div class="form-group mb-2">
                                    <label>Vehicle No</label>
                                    <input type="text" name="ewaybills[{{ $index }}][vehicle_no]" class="form-control"
                                        value="{{ old("ewaybills.$index.vehicle_no", $bill['vehicleNo'] ?? '') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>From Place</label>
                                    <input type="text" name="ewaybills[{{ $index }}][from_place]" class="form-control"
                                        value="{{ old("ewaybills.$index.from_place", $bill['fromPlace'] ?? '') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>To Place</label>
                                    <input type="text" name="ewaybills[{{ $index }}][to_place]" class="form-control"
                                        value="{{ old("ewaybills.$index.to_place", $bill['toPlace'] ?? '') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label>Reason Code </label>
                                    <input type="text" name="ewaybills[{{ $index }}][reasoncode]" class="form-control"
                                        value="{{ old("ewaybills.$index.reasoncode", $bill['reasoncode'] ?? '') }}">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Reason Remark</label>
                                    <input type="text" name="ewaybills[{{ $index }}][reasonremarks]" class="form-control"
                                        value="{{ old("ewaybills.$index.reasonremarks", $bill['reasonremarks'] ?? '') }}">
                                </div>
                                <div class="form-group mb-2">
                                    <label>TransDocNo</label>
                                    <input type="text" name="ewaybills[{{ $index }}][transDocNo]" class="form-control"
                                        value="{{ old("ewaybills.$index.transDocNo", $bill['transDocNo'] ?? '') }}">
                                </div>
                                <div class="form-group mb-2">
                                    <label>TransDocDate</label>
                                    <input type="text" name="ewaybills[{{ $index }}][transDocDate]" class="form-control"
                                        value="{{ old("ewaybills.$index.transDocDate", $bill['transDocDate'] ?? '') }}">
                                </div>
                                <div class="form-group mb-2">
                                    <label>TransMode</label>
                                    <input type="text" name="ewaybills[{{ $index }}][transMode]" class="form-control"
                                        value="{{ old("ewaybills.$index.transMode", $bill['transMode'] ?? '') }}">
                                </div>
                                <div class="form-group mb-2">
                                    <label>VehicleType</label>
                                    <input type="text" name="ewaybills[{{ $index }}][vehicleType]" class="form-control"
                                        value="{{ old("ewaybills.$index.vehicleType", $bill['vehicleType'] ?? '') }}">
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