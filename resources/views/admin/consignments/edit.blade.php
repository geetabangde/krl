@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<style>
   /* Make Select2 look like Bootstrap input */
   .select2-container .select2-selection--single {
   height: 38px !important; /* match Bootstrap .form-control height */
   padding: 6px 12px;
   }
   .select2-container--default .select2-selection--single .select2-selection__arrow {
   height: 38px !important;
   right: 6px;
   }
</style>
<!-- Order Booking Add Page -->
<div class="row order-booking-form">
<div class="col-12">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center mt-5">
   <div>
      <h4>🛒 consignments edit </h4>
      <p class="mb-0">Enter the required details for the order.</p>
   </div>
   <a href="{{ route('admin.consignments.index') }}" class="btn" id="backToListBtn"
      style="background-color: #ca2639; color: white; border: none;">
   ⬅ Back to Listing
   </a>
</div>
<!-- LR / Consignment add Form -->
<div class="row add-form">
<div class="col-12">
<div class="card">
  
   <form method="POST" action="{{ route('admin.consignments.update', $order->order_id) }}" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
         @php
         $lrList = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
         $lrData = $lrList[0] ?? []; 
         
         @endphp
         
         <div class="row">
            <!-- Consignor Details -->
            <div class="col-md-6">
               <h5>📦 Consignor (Sender)</h5>
               <select name="consignor_id" id="consignor_id" class="form-select my-select" onchange="setConsignorDetails()" required>
                  <option value="">Select Consignor Name</option>
                  @foreach($users as $user)
                  @php
                  $addresses = json_decode($user->address, true);
                  @endphp
                  @if(!empty($addresses) && is_array($addresses))
                  @foreach($addresses as $address)
                  @php
                  $formattedAddress = trim(
                  ($address['billing_address'] ?? '') . ', ' .
                  ($address['city'] ?? '') . ', ' .
                  ($address['consignment_address'] ?? '')
                  );
                  @endphp
                  <option
                  value="{{ $user->id }}"
                  data-gst-consignor="{{ $address['gstin'] ?? '' }}"
                  data-address-consignor="{{ $formattedAddress }}"
                  @if(old('consignor_id', $lrData['consignor_id'] ?? '') == $user->id) selected @endif
                  >
                  {{ $user->name }} - {{ $address['city'] ?? '' }}
                  </option>
                  @endforeach
                  @endif
                  @endforeach
               </select>
               <!-- Loading Address -->
               <div class="mb-3">
                  <label class="form-label">Consignor Loading Address</label>
                  <textarea name="consignor_loading" id="consignor_loading" class="form-control" rows="2"
                     placeholder="Enter all addresses" >{{ old('consignor_loading', $lrData['consignor_loading'] ?? '') }}</textarea>
               </div>
               <!-- GST -->
               <div class="mb-3">
                  <label class="form-label">Consignor GST</label>
                  <input type="text" name="consignor_gst" id="consignor_gst" class="form-control"
                     value="{{ old('consignor_gst', $lrData['consignor_gst'] ?? '') }}"
                     placeholder="Enter GST numbers" readonly >
               </div>
               <div class="mb-3 ">
                  <label class="form-label">💰 ORDER AMOUNT</label>
                  <input type="number" name="order_rate" class="form-control"  value="{{ old('order_rate', $lrData['order_rate'] ?? '') }}" placeholder="Enter Amount" id="byoder">
               </div>
            </div>
            <!-- Consignee Details -->
            <div class="col-md-6">
               <h5>📦 Consignee (Receiver)</h5>
               <div class="mb-3">
                  <label class="form-label">Lr date</label>
                  <input type="date" name="lr_date" class="form-control" value="{{ old('lr_date', $lrData['lr_date'] ?? '') }}"
                     placeholder="Enter lr name" required>
               </div>
               <div class="mb-3">
                  <select name="consignee_id" id="consignee_id" class="form-select my-select" onchange="setConsigneeDetails()" required>
                     <option value="">Select Consignee Name</option>
                     @foreach($users as $user)
                     @php
                     $addresses = json_decode($user->address, true);
                     @endphp
                     @if(!empty($addresses) && is_array($addresses))
                     @foreach($addresses as $address)
                     @php
                     $formattedAddress = trim(
                     ($address['billing_address'] ?? '') . ', ' .
                     ($address['city'] ?? '') . ', ' .
                     ($address['consignment_address'] ?? '')
                     );
                     @endphp
                     <option 
                     value="{{ $user->id }}"
                     data-gst-consignee="{{ $address['gstin'] ?? '' }}"
                     data-address-consignee="{{ $formattedAddress }}"
                     @if(old('consignee_id', $lrData['consignee_id'] ?? '') == $user->id) selected @endif
                     >
                     {{ $user->name }} - {{ $address['city'] ?? '' }}
                     </option>
                     @endforeach
                     @endif
                     @endforeach
                  </select>
                  <!-- Unloading Address -->
                  <div class="mb-3">
                     <label class="form-label">Consignee Unloading Address</label>
                     <textarea name="consignee_unloading" id="consignee_unloading" class="form-control" rows="2"
                        placeholder="Enter all addresses" required>{{ old('consignee_unloading', $lrData['consignee_unloading'] ?? '') }}</textarea>
                  </div>
                  <!-- GST -->
                  <div class="mb-3">
                     <label class="form-label">Consignee GST</label>
                     <input name="consignee_gst" id="consignee_gst" value="{{ old('consignee_gst', $lrData['consignee_gst'] ?? '') }}"
                        type="text" class="form-control" placeholder="Enter GST number" required>
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Date -->
               <!-- Vehicle Type -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">🚛 Vehicle Type</label>
                     <select name="vehicle_type" class="form-select my-select" required>
                        <option value="">Select Type</option>
                        @foreach ($vehiclesType as $type)
                        <option value="{{ $type->id }}" 
                        {{ isset($lrData['vehicle_type']) && $lrData['vehicle_type'] == $type->id ? 'selected' : '' }}>
                        {{ $type->vehicletype }}
                        </option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <!-- Vehicle Ownership -->
               <div class="col-md-4">
                  <label class="form-label">🛻 Vehicle Ownership</label>
                  <div class="d-flex gap-3">
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="vehicle_ownership" value="Own"
                        {{ old('vehicle_ownership', $lrData['vehicle_ownership'] ?? '') == 'Own' ? 'checked' : '' }}>
                        <label class="form-check-label">Own</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="vehicle_ownership" value="Other"
                        {{ old('vehicle_ownership', $lrData['vehicle_ownership'] ?? '') == 'Other' ? 'checked' : '' }}>
                        <label class="form-check-label">Other</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Delivery Mode -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">🚢 Delivery Mode</label>
                     <select name="delivery_mode" class="form-select my-select">
                        <option value="">Select Mode</option>
                        <option value="door_delivery" {{ old('delivery_mode', $lrData['delivery_mode'] ?? '') == 'door_delivery' ? 'selected' : '' }}>Door Delivery</option>
                        <option value="godwon_deliver" {{ old('delivery_mode', $lrData['delivery_mode'] ?? '') == 'godwon_deliver' ? 'selected' : '' }}>Godwon Deliver</option>
                     </select>
                  </div>
               </div>
               <!-- From Location -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label for="from_location" class="form-label">From Location</label>
                     <select name="from_location" class="form-select my-select" required>
                        <option value="">Select Origin</option>
                        @foreach ($destination as $loc)
                              <option value="{{ $loc->id }}"
                                 {{ old("from_location", $lrData['from_location'] ?? null) == $loc->id ? 'selected' : '' }}>
                                 {{ $loc->destination }}
                              </option>
                        @endforeach
                     </select>
                  </div>

               </div>
               <!-- To Location -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label for="to_location" class="form-label">To Location</label>
                     <select name="to_location" class="form-select my-select" required>
                        <option value="">Select Destination</option>
                        @foreach ($destination as $loc)
                              <option value="{{ $loc->id }}"
                                 {{ old("to_location", $lrData['to_location'] ?? null) == $loc->id ? 'selected' : '' }}>
                                 {{ $loc->destination }}
                              </option>
                        @endforeach
                     </select>
                  </div>

               </div>
               @php
               $insuranceStatus = old('insurance_status', $lrData['insurance_status'] ?? 'no');
               $insuranceDesc = old('insurance_description', $lrData['insurance_description'] ?? '');
               @endphp
               {{-- @dd($lrData['insurance_status']); --}}
               <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
                  <label class="form-label mb-0">🛡️ Insurance?</label>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="insurance_status" value="yes" id="createInsuranceYes"
                     {{ $insuranceStatus == 'yes' ? 'checked' : '' }}>
                     <label class="form-check-label" for="createInsuranceYes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="insurance_status" value="no" id="createInsuranceNo"
                     {{ $insuranceStatus == 'no' ? 'checked' : '' }}>
                     <label class="form-check-label" for="createInsuranceNo">No</label>
                  </div>
                  <!-- Insurance input field -->
                  <input type="text"
                     class="form-control {{ $insuranceStatus != 'yes' ? 'd-none' : '' }}"
                     name="insurance_description"
                     id="insuranceInput"
                     placeholder="Enter Insurance Number"
                     style="max-width: 450px;"
                     value="{{ $insuranceDesc }}">
               </div>
               {{-- insurence mode --}}
               <!-- Cargo Description Section -->
               <div class="row mt-4">
                  <div class="col-12">
                     <h5 class="mb-3 pb-3">📦 Cargo Description</h5>
                     <div class="mb-3 d-flex gap-3">
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="cargo_description_type" id="singleDoc" value="single" {{ old('cargo_description_type', 'single') == 'single' ? 'checked' : '' }} required>
                           <label class="form-check-label" for="singleDoc">Single Document</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="cargo_description_type" id="multipleDoc" value="multiple" required>
                           <label class="form-check-label" for="multipleDoc">Multiple Documents</label>
                        </div>
                     </div>
                     <!-- Cargo Details Table -->
                     <!-- Cargo Table -->
                     <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                           <thead>
                              <tr>
                                 <th>No. of Packages</th>
                                 <th>Packaging Type</th>
                                 <th>Description</th>
                                 <th>Actual Weight (kg)</th>
                                 <th>Charged Weight (kg)</th>
                                 <th>Unit</th>
                                 <th>Document No.</th>
                                 <th>Document Name</th>
                                 <th>Document Date</th>
                                 <th>Document Upload</th>
                                 <th>Eway Bill</th>
                                 <th>Valid Upto</th>
                                 <th>Declared value</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="cargoTableBody">
                              @php 
                              $cargoData = old('cargo', isset($lrData['cargo']) ? $lrData['cargo'] : [['packages_no' => '', 'package_type' => '', 'package_description' => '', 'weight' => '', 'actual_weight' => '', 'charged_weight' => '', 'document_no' => '', 'document_name' => '', 'document_date' => '', 'eway_bill' => '', 'valid_upto' => '']]); 
                              @endphp
                              

                              @foreach ($cargoData as $index => $cargo)
                              <tr>
                                 <td><input type="number" name="cargo[{{ $index }}][packages_no]" class="form-control" value="{{ $cargo['packages_no'] }}" min="0"  required></td>
                                 <td>
                                    <select name="cargo[{{ $index }}][package_type]" class="form-select" required>
                                       <option value="">Select Packaging Type</option>
                                       @foreach($package as $type)
                                       <option value="{{ $type->id }}" {{ $cargo['package_type'] == $type->id ? 'selected' : '' }}>
                                       {{ $type->package_type }}
                                       </option>
                                       @endforeach
                                    </select>
                                 </td>
                                 <td><input type="text" name="cargo[{{ $index }}][package_description]" class="form-control" value="{{ $cargo['package_description'] }}" required></td>
                                 <td><input type="number" name="cargo[{{ $index }}][actual_weight]" class="form-control" min="0" value="{{ $cargo['actual_weight'] }}" required></td>
                                 {{-- 
                                 <td><input type="number" name="cargo[{{ $index }}][charged_weight]" class="form-control" value="{{ $cargo['charged_weight'] }}" required></td>
                                 --}}
                                 <td><input type="number" name="cargo[{{ $index }}][charged_weight]" min="0"  value="{{ $cargo['charged_weight'] }}" class="form-control" oninput="calculateTotalChargedWeight()"></td>
                                 <td>
                                    <select class="form-select" name="cargo[{{ $index }}][unit]">
                                       <option value="">Select Unit</option>
                                       <option value="kg" {{ ($cargo['unit'] ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                                       <option value="ton" {{ ($cargo['unit'] ?? '') == 'ton' ? 'selected' : '' }}>Ton</option>
                                    </select>
                                 </td>
                                 <td><input type="text" name="cargo[{{ $index }}][document_no]" class="form-control" value="{{ $cargo['document_no'] }}" ></td>
                                 <td><input type="text" name="cargo[{{ $index }}][document_name]" class="form-control" value="{{ $cargo['document_name'] }}" ></td>
                                 <td><input type="date" name="cargo[{{ $index }}][document_date]" class="form-control" value="{{ $cargo['document_date'] }}" ></td>
                                 
                                 <td><input type="file" name="cargo[{{ $index }}][document_file]" class="form-control" >
                                    <input type="hidden" name="cargo[{{ $index }}][old_document_file]" class="form-control" value="{{ $cargo['document_file'] ?? '' }}" >
                                 </td>

                                 <td><input type="text" name="cargo[{{ $index }}][eway_bill]" class="form-control" value="{{ $cargo['eway_bill'] }}" required></td>
                                 <td><input type="date" name="cargo[{{ $index }}][valid_upto]" class="form-control" value="{{ $cargo['valid_upto'] }}" required></td>
                                 <td><input name="cargo[{{ $index }}][declared_value]" type="number" value="{{ $cargo['declared_value'] ?? '' }}" min="0"  class="form-control" placeholder="0" required></td>
                                 <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                     <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm" style="background: #ca2639; color: white;"
                           onclick="addRow()">
                        <span style="filter: invert(1);">➕</span> Add Row</button>
                     </div>
                  </div>
               </div>
               <!-- Freight Details Section -->
               <div class="row mt-4">
                  <div class="col-12">
                     <h5 class="pb-3">🚚 Freight Details</h5>
                     <div class="mb-3 d-flex gap-3">
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="freightType"
                           id="freightPaid" value="paid"
                           onchange="toggleFreightTable()"
                           {{ (isset($lrData['freightType']) && $lrData['freightType'] == 'paid') ? 'checked' : '' }}>
                           <label class="form-check-label" for="freightPaid">Paid</label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="freightType"
                           id="freightToPay" value="to_pay"
                           onchange="toggleFreightTable()"
                           {{ (isset($lrData['freightType']) && $lrData['freightType'] == 'to_pay') ? 'checked' : '' }}>
                           <label class="form-check-label" for="freightToPay">To Pay</label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="freightType"
                           id="freightToBeBilled" value="to_be_billed"
                           onchange="toggleFreightTable()"
                           {{ (isset($lrData['freightType']) && $lrData['freightType'] == 'to_be_billed') ? 'checked' : '' }}>
                           <label class="form-check-label" for="freightToBeBilled">To Be Billed</label>
                        </div>
                     </div>
                     <!-- Freight Charges Table -->
                     <div class="table-responsive" id="freightTableContainer">
                        <table class="table table-bordered align-middle text-center" id="freight-table">
                           <thead>
                              <tr>
                                 <th>Freight</th>
                                 <th>LR Charges</th>
                                 <th>Hamali</th>
                                 <th>Other Charges</th>
                                 <th>GST</th>
                                 <th>Total Freight</th>
                                 <th>Less Advance</th>
                                 <th>Balance Freight</th>
                              </tr>
                           </thead>
                           <tbody id="freightBody">
                              <tr>
                                 <td>
                                    <input type="number" name="freight_amount" value="{{ old('freight_amount', $lrData['freight_amount'] ?? '') }}" class="form-control freight-amount" min="0"  placeholder="Enter Freight Amount" readonly>
                                 </td>
                                 <td>
                                    <input type="number" name="lr_charges"  value="{{ old('lr_charges', $lrData['lr_charges'] ?? '') }}" class="form-control lr-charges" min="0"  placeholder="Enter LR " >
                                 </td>
                                 <td>
                                    <input type="number" name="hamali"  value="{{ old('hamali', $lrData['hamali'] ?? '') }}" class="form-control hamali" min="0"  placeholder="Enter Hamali " >
                                 </td>
                                 <td>
                                    <input type="number" name="other_charges"   value="{{ old('other_charges', $lrData['other_charges'] ?? '') }}" class="form-control other-charges" min="0"  placeholder="Enter Other " >
                                 </td>
                                 <td>
                                    <input type="number" name="gst_amount"  value="{{ old('gst_amount', $lrData['gst_amount'] ?? '') }}" class="form-control gst-amount" min="0"  placeholder=" GST Amount" readonly>
                                 </td>
                                 <td>
                                    <input type="number" name="total_freight"  value="{{ old('total_freight', $lrData['total_freight'] ?? '') }}" class="form-control total-freight" min="0"  placeholder="Total Freight" readonly>
                                 </td>
                                 <td>
                                    <input type="number" name="less_advance"  value="{{ old('less_advance', $lrData['less_advance'] ?? '') }}" class="form-control less-advance" min="0"  placeholder="Less Advance Amount" >
                                 </td>
                                 <td>
                                    <input type="number" name="balance_freight"  value="{{ old('balance_freight', $lrData['balance_freight'] ?? '') }}" class="form-control balance-freight" min="0"  placeholder="Balance Freight" readonly>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>

                <!-- vehical description -->
                <div class="row mt-4">
                   <div class="col-12">
                     <h5 class="mb-3 pb-3">📦 Vehicle Description</h5>
                     <!-- Cargo Details Table -->
                     <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                           <thead class="">
                            <tr>
                                  <th>#</th>
                                 <th>Vehicle No.</th>
                                 <th>Remarks</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                            <tbody id="vehicleTableBody">
                               @php 
                                    $vehicleData = old('vehicle', isset($lrData['vehicle']) ? $lrData['vehicle'] : [['vehicle_no' => '', 'remarks' => '']]); 
                                @endphp
                                

                                @foreach ($vehicleData as $index => $vehicle)
                                          <tr>
                                             <td>
                                                <!-- Radio button for selecting one vehicle -->
                                                <div class="form-check">
                                                   <input type="radio" name="selected_vehicle" value="{{ $index }}"
                                                      class="form-check-input" {{ isset($vehicle['is_selected']) && $vehicle['is_selected'] ? 'checked' : '' }}>
                                                </div>
                                             </td>
                                             <td>
                                                <select name="vehicle[{{ $index }}][vehicle_no]" class="form-select" required>
                                                   <option value="">Select Vehicle NO.</option>
                                                   @foreach ($vehicles as $v)
                                                   <option value="{{ $v->vehicle_no }}"
                                                      {{ $vehicle['vehicle_no'] == $v->vehicle_no ? 'selected' : '' }}>
                                                      {{ $v->vehicle_no }}
                                                   </option>
                                                   @endforeach
                                                </select>
                                             </td>
                                             <td>
                                                <input type="text" name="vehicle[{{ $index }}][remarks]" class="form-control"
                                                   value="{{ $vehicle['remarks'] ?? '' }}" placeholder="Remarks" required>
                                             </td>
                                             <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removevehicleRow(this)">🗑</button>
                                             </td>
                                          </tr>
                                          @endforeach


                            </tbody>
                        </table>
                     </div>
                     <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm" style="background: #ca2639; color: white;"
                           onclick="addvehicleRow()">
                        <span style="filter: invert(1);">➕</span> Add Row</button>
                     </div>
                     
                  </div>  
                </div>

               <!-- vehical description -->


                
               <!-- Freight Details Section -->
               <div class="row">
                  <!-- Declared Value -->
                  <div class="col-md-6 mt-3">
                     <input type="hidden" id="totalChargedWeight" class="form-control" readonly>
                     <div class="mb-3">
                        <label class="form-label " style="font-weight: bold;">💰 Total Declared Value
                        (Rs.)</label>
                        <input type="number" id="totalDeclaredValue"  required  value="{{ old('total_declared_value', $lrData['toatal_declared_value'] ?? '') }}"  name="total_declared_value" class="form-control">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Submit Button -->
                  <div class="row mt-4 mb-4">
                     <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Consignment 
                        </button>
                     </div>
                  </div>
               </div>
            </div>
   </form>
   </div>
   </div>
</div>
{{-- image view --}}
{{-- add charge weigth --}}
<script>
   function calculateTotalChargedWeight() {
       let total = 0;
       const inputs = document.querySelectorAll('input[name$="[charged_weight]"]');
   
       inputs.forEach(input => {
           total += parseFloat(input.value) || 0;
       });
   
       document.getElementById('totalChargedWeight').value = total.toFixed(2);
   }
   
   // Page load pe call karo
   document.addEventListener('DOMContentLoaded', function () {
       calculateTotalChargedWeight();  // ⚡ Existing values ka total dikhega on load
   });
</script>
{{-- add charge weigth --}}
<script>
   function toggleFreightTable() {
       const tbody = document.getElementById('freightBody');
   
       const selectedFreightType = document.querySelector('input[name="freightType"]:checked').value;
   
       if (selectedFreightType === 'to_be_billed') {
           tbody.style.display = 'none';
           const inputs = tbody.querySelectorAll('input');
           inputs.forEach(input => input.removeAttribute('required'));
       } else {
           tbody.style.display = 'table-row-group';
           const inputs = tbody.querySelectorAll('input');
           inputs.forEach(input => input.setAttribute('required', 'required'));
       }
   }
   
   // Auto-call this function on page load (to show/hide based on preselected value)
   document.addEventListener('DOMContentLoaded', function () {
       toggleFreightTable();
   });
</script>
<script>
   const yesRadio = document.getElementById('createInsuranceYes');
   const noRadio = document.getElementById('createInsuranceNo');
   const insuranceInput = document.getElementById('insuranceInput');
   
   function toggleInsuranceField() {
       if (yesRadio.checked) {
           insuranceInput.classList.remove('d-none');
       } else {
           insuranceInput.classList.add('d-none');
           insuranceInput.value = '';
       }
   }
   
   // Run on load
   window.addEventListener('DOMContentLoaded', toggleInsuranceField);
   
   // Run on change
   yesRadio.addEventListener('change', toggleInsuranceField);
   noRadio.addEventListener('change', toggleInsuranceField);
</script>
<script>
   let cargoIndex = {{ count($cargoData) }};
     const packageTypes = @json($package);
   
   function calculateTotalDeclaredValue() {
       let total = 0;
       const inputs = document.querySelectorAll('.declared-value');
   
       inputs.forEach(input => {
           total += parseFloat(input.value) || 0;
       });
   
       document.getElementById('totalDeclaredValue').value = total;
   }
   
   function addRow() {
       const tbody = document.getElementById('cargoTableBody');
       const row = document.createElement('tr');
   
        // Build package_type dropdown dynamically
        let packageOptions = '<option value="">Select Packaging Type</option>';
        packageTypes.forEach(pkg => {
            packageOptions += `<option value="${pkg.id}">${pkg.package_type}</option>`;
        });
   
       row.innerHTML = `
           <td><input type="number" name="cargo[${cargoIndex}][packages_no]" class="form-control"></td>
   
   
            <td>
                <select name="cargo[${cargoIndex}][package_type]" class="form-select" required>
                    ${packageOptions}
                </select>
            </td>
   
           <td><input type="text" name="cargo[${cargoIndex}][package_description]" class="form-control"></td>
           <td><input type="number" name="cargo[${cargoIndex}][actual_weight]" class="form-control"></td>
               <td><input type="number" name="cargo[${cargoIndex}][charged_weight]" class="form-control" oninput="calculateTotalChargedWeight()"></td>
   
           <td>
               <select class="form-select my-select" name="cargo[${cargoIndex}][unit]" required>
               <option value="">Select Unit</option>
               <option value="kg">Kg</option>
               <option value="ton">Ton</option>
               </select>
            </td>
           <td><input type="text" name="cargo[${cargoIndex}][document_no]" class="form-control"></td>
           <td><input type="text" name="cargo[${cargoIndex}][document_name]" class="form-control"></td>
           <td><input type="date" name="cargo[${cargoIndex}][document_date]" class="form-control"></td>
           <td><input type="file" name="cargo[${cargoIndex}][document_file]" class="form-control"></td>
           <td><input type="text" name="cargo[${cargoIndex}][eway_bill]" class="form-control"></td>
           <td><input type="date" name="cargo[${cargoIndex}][valid_upto]" class="form-control"></td>
           <td><input type="number" name="cargo[${cargoIndex}][declared_value]" class="form-control declared-value" oninput="calculateTotalDeclaredValue()" required></td>
           <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button></td>
       `;
   
       tbody.appendChild(row);
       cargoIndex++;
       calculateTotalDeclaredValue(); // Update total on row add
   }
   
   function removeRow(button) {
       button.closest('tr').remove();
       calculateTotalDeclaredValue(); // Update total on row remove
   }

  // vehicle description

   const vehicles = @json($vehicles);
   let vehicleIndex = {{ count($vehicleData) }};
   

function addvehicleRow() {
    const tbody = document.getElementById('vehicleTableBody');
     let rowCount = document.querySelectorAll('#vehicleTableBody tr').length;
    const row = document.createElement('tr');

    let vehicleOptions = `<option value="">Select Vehicle No.</option>`;
    vehicles.forEach(vehicle => {
        vehicleOptions += `<option value="${vehicle.vehicle_no}">${vehicle.vehicle_no}</option>`;
    });

    row.innerHTML = `
         <td>
            <div class="form-check">
                <input type="checkbox" name="vehicle[${vehicleIndex}][is_selected]" value="1" class="form-check-input" checked>
            </div>
        </td>
        <td>
            <select name="vehicle[${vehicleIndex}][vehicle_no]" class="form-select my-select" required>
                ${vehicleOptions}
            </select>
        </td>
        <td>
            <input type="text" name="vehicle[${vehicleIndex}][remarks]" class="form-control" placeholder="Remarks" required>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removevehicleRow(this)">🗑</button>
        </td>
    `;

    tbody.appendChild(row);
    vehicleIndex++;
}


function removevehicleRow(button) {
    button.closest('tr').remove();
}



   // Run once after DOM loads to handle existing rows
   document.addEventListener('DOMContentLoaded', function () {
       document.querySelectorAll('input[name$="[declared_value]"]').forEach(input => {
           input.classList.add('declared-value');
           input.addEventListener('input', calculateTotalDeclaredValue);
       });
   
       calculateTotalDeclaredValue();
   });
</script>
<script>
   document.getElementById('createInsuranceYes').addEventListener('click', function () {
       let myModal = new bootstrap.Modal(document.getElementById('insuranceModal'));
       myModal.show();
   });
</script>
<script>
   function setConsignorDetails() {
       const selected = document.getElementById('consignor_id');
       const selectedOption = selected.options[selected.selectedIndex];
       const gst = selectedOption.getAttribute('data-gst-consignor') || '';
       const address = selectedOption.getAttribute('data-address-consignor') || '';
   
       document.getElementById('consignor_gst').value = gst;
       document.getElementById('consignor_loading').value = address;
   }
   
   document.addEventListener('DOMContentLoaded', function () {
       const select = document.getElementById('consignor_id');
       if (select && select.value !== '') {
           setConsignorDetails();
       }
   });
</script>
<script>
   function setConsigneeDetails() {
       const selected = document.getElementById('consignee_id');
       const selectedOption = selected.options[selected.selectedIndex];
       const gst = selectedOption.getAttribute('data-gst-consignee') || '';
       const address = selectedOption.getAttribute('data-address-consignee') || '';
   
       document.getElementById('consignee_gst').value = gst;
       document.getElementById('consignee_unloading').value = address;
   }
   
   // On edit page load
   document.addEventListener('DOMContentLoaded', function () {
       const select = document.getElementById('consignee_id');
       if (select && select.value !== '') {
           setConsigneeDetails();
       }
   });
</script>
<script>
   document.addEventListener('input', function(e) {
       const row = e.target.closest('tr');
       if (!row) return;
   
       // Get all input values
       const freight = parseFloat(row.querySelector('.freight-amount')?.value) || 0;
       const lrCharges = parseFloat(row.querySelector('.lr-charges')?.value) || 0;
       const hamali = parseFloat(row.querySelector('.hamali')?.value) || 0;
       const otherCharges = parseFloat(row.querySelector('.other-charges')?.value) || 0;
       const gstPercent = 12; // Fixed GST percentage (12%)
       const lessAdvance = parseFloat(row.querySelector('.less-advance')?.value) || 0;
   
       // Total before GST
       const subtotal = freight + lrCharges + hamali + otherCharges;
   
       // GST amount calculation
       const gstAmount = subtotal * gstPercent / 100; // 12% GST
   
       // Update GST amount input field with the calculated value
       const gstAmountInput = row.querySelector('.gst-amount');
       if (gstAmountInput) {
           gstAmountInput.value = gstAmount.toFixed(2); // Show calculated GST amount (e.g., 120)
       }
   
       // Total Freight = subtotal + gst
       const totalFreight = subtotal + gstAmount;
   
       // Balance Freight = total - less advance
       const balance = totalFreight - lessAdvance;
   
       // Update values
       if (row.querySelector('.total-freight')) {
           row.querySelector('.total-freight').value = totalFreight.toFixed(2);
       }
   
       if (row.querySelector('.balance-freight')) {
           row.querySelector('.balance-freight').value = balance.toFixed(2);
       }
   });
</script>
<script>
   function updateFreightAmount() {
       const byOrder = parseFloat(document.getElementById('byoder')?.value) || 0;
       const chargedWeight = parseFloat(document.getElementById('totalChargedWeight')?.value) || 0;
       const result = byOrder * chargedWeight;
   
       const freightInput = document.querySelector('.freight-amount');
       if (freightInput) {
           freightInput.value = result.toFixed(2);
       }
   }
   
   function calculateTotalChargedWeight() {
       let total = 0;
       const inputs = document.querySelectorAll('input[name$="[charged_weight]"]');
   
       inputs.forEach(input => {
           total += parseFloat(input.value) || 0;
       });
   
       document.getElementById('totalChargedWeight').value = total.toFixed(2);
   
       // Call freight updater here
       updateFreightAmount(); 
   }
   
   document.addEventListener('DOMContentLoaded', function () {
       calculateTotalChargedWeight();
       updateFreightAmount();
   
       // Bind event to byOrder input
       document.getElementById('byoder').addEventListener('input', updateFreightAmount);
   
       // Bind charged weight inputs
       document.querySelectorAll('input[name$="[charged_weight]"]').forEach(input => {
           input.addEventListener('input', calculateTotalChargedWeight);
       });
   });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery Script -->
<script>
   function toggleFreightTable() {
      const selectedType = $('input[name="freightType"]:checked').val();
      if (selectedType === 'to_be_billed') {
         $('#freightTableContainer').hide();
      } else {
         $('#freightTableContainer').show();
      }
   }
   
   // Run on page load
   $(document).ready(function () {
      toggleFreightTable();
   });
</script>
@endsection