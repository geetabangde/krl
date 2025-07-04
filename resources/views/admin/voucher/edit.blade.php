@extends('admin.layouts.app')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <div class="row add form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4>🚛 Vehicle Details</h4>
                     <p>Enter the required details for the vehicle.</p>
                  </div>
                  <a  href="{{ route('admin.voucher.index') }}" class="btn" id="backToListBtn"
                     style="background-color: #ca2639; color: white; border: none;">
                  ⬅ Back to Listing
                  </a>
               </div>
               <form method="POST" action="{{ route('admin.voucher.update', $voucher->id) }}" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                     <!-- Row 1: Voucher Type & Date -->
                     <div class="row">
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="form-label">Voucher Type <span class="text-danger">*</span></label>
                              <select class="form-control" name="voucher_type" id="voucher_type" required>
                                 <option value="">-- Select --</option>
                                 <option value="Payment" {{ $voucher->voucher_type == 'Payment' ? 'selected' : '' }}>Payment</option>
                                 <option value="Receipt" {{ $voucher->voucher_type == 'Receipt' ? 'selected' : '' }}>Receipt</option>
                                 <option value="Journal" {{ $voucher->voucher_type == 'Journal' ? 'selected' : '' }}>Journal</option>
                                 <option value="Contra" {{ $voucher->voucher_type == 'Contra' ? 'selected' : '' }}>Contra</option>
                                 <option value="Sales" {{ $voucher->voucher_type == 'Sales' ? 'selected' : '' }}>Sales</option>
                                 <option value="Purchase" {{ $voucher->voucher_type == 'Purchase' ? 'selected' : '' }}>Purchase</option>
                                 <option value="Expense" {{ $voucher->voucher_type == 'Expense' ? 'selected' : '' }}>Expense</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="form-label">Date <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" name="voucher_date" value="{{ $voucher->voucher_date }}" required>
                           </div>
                        </div>
                     </div>
                     <!-- Voucher Rows -->
                     <div id="voucherRows">
                        @php
                        $voucherRows = is_string($voucher->vouchers) ? json_decode($voucher->vouchers, true) : $voucher->vouchers;
                        @endphp
                        @foreach($voucherRows as $index => $row)
                        <div class="voucher-row" data-index="{{ $index }}">
                           <!-- Voucher Number -->
                           <div class="col-md-6">
                              <div class="mb-3">
                                 <label class="form-label">Voucher Number<span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="vouchers[{{ $index }}][voucher_no]" value="{{ $row['voucher_no'] ?? '' }}" required>
                              </div>
                           </div>
                           <!-- Against Voucher (conditionally shown) -->
                           <!-- Against Voucher (conditionally shown) -->
                           <div class="col-md-6 against-voucher-container" style="display: {{ in_array($voucher->voucher_type, ['Payment']) ? 'block' : 'none' }};">
                              <div class="mb-3">
                                 <label class="form-label">Against Voucher</label>
                                 <select class="form-control against-voucher-select"
                                 name="vouchers[{{ $index }}][against_voucher][]"
                                 multiple
                                 data-selected='@json(collect($row['against_voucher'] ?? [])->pluck("label"))'>
                                 @if (!empty($row['against_voucher']))
                                 @foreach ($row['against_voucher'] as $v)
                                 <option value="{{ $v['label'] }}" selected>{{ $v['label'] }}</option>
                                 @endforeach
                                 @endif
                                 </select>
                              </div>
                           </div>
                           <!-- Sales Voucher (conditionally shown) -->
                           <!-- Sales Voucher (conditionally shown) -->
                           <div class="col-md-6 sales-voucher-container" style="display: {{ in_array($voucher->voucher_type, ['Receipt']) ? 'block' : 'none' }};">
                              <div class="mb-3">
                                 <label class="form-label">Receipt Voucher</label>
                                 <select class="form-control sales-voucher-select"
                                 name="vouchers[{{ $index }}][sales_voucher][]"
                                 multiple
                                 data-selected='@json(collect($row['sales_voucher'] ?? [])->pluck("label"))'>
                                 @if (!empty($row['sales_voucher']))
                                 @foreach ($row['sales_voucher'] as $v)
                                 <option value="{{ $v['label'] }}" selected>{{ $v['label'] }}</option>
                                 @endforeach
                                 @endif
                                 </select>
                              </div>
                           </div>
                           <!-- Transaction ID (conditionally shown) -->
                           <div class="col-md-6 transaction-id-container" style="display: {{ in_array($voucher->voucher_type, ['Payment', 'Receipt', 'Contra']) ? 'block' : 'none' }};">
                              <div class="mb-3">
                                 <label class="form-label">Transaction ID</label>
                                 <input type="text" class="form-control" name="vouchers[{{ $index }}][transaction_id]" value="{{ $row['transaction_id'] ?? '' }}">
                              </div>
                           </div>
                           <!-- Credit Days (conditionally shown) -->
                           <div class="col-md-6 credit-days-container" style="display: {{ in_array($voucher->voucher_type, ['Sales', 'Purchase', 'Expense']) ? 'block' : 'none' }};">
                              <div class="mb-3">
                                 <label class="form-label">Credit Days</label>
                                 <input type="number" class="form-control" name="vouchers[{{ $index }}][credit_day]" value="{{ $row['credit_day'] ?? '' }}">
                              </div>
                           </div>
                           <!-- Cash/Credit (conditionally shown) -->
                           <div class="col-md-6 cash-credit-container" style="display: {{ in_array($voucher->voucher_type, ['Sales', 'Purchase', 'Expense']) ? 'block' : 'none' }};">
                              <div class="mb-3">
                                 <label class="form-label">Payment Type</label>
                                 <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="vouchers[{{ $index }}][cash_credit]" id="cash_{{ $index }}" value="Cash" {{ isset($row['cash_credit']) && $row['cash_credit'] == 'Cash' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cash_{{ $index }}">Cash</label>
                                 </div>
                                 <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="vouchers[{{ $index }}][cash_credit]" id="credit_{{ $index }}" value="Credit" {{ !isset($row['cash_credit']) || $row['cash_credit'] == 'Credit' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="credit_{{ $index }}">Credit</label>
                                 </div>
                              </div>
                           </div>
                           <!-- TDS Payable (conditionally shown) -->
                           <div class="col-md-6 tds-payable-container" style="display: {{ in_array($voucher->voucher_type, ['Purchase', 'Expense']) ? 'block' : 'none' }};">
                              <div class="mb-3">
                                 <label class="form-label">TDS Payable</label>
                                 <input type="number" class="form-control" name="vouchers[{{ $index }}][tds_payable]" value="{{ $row['tds_payable'] ?? '' }}">
                              </div>
                           </div>
                           <!-- From/To Accounts -->
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">From Account <span class="text-danger">*</span></label>
                                    <select class="form-control from_account" name="vouchers[{{ $index }}][from_account]" required data-selected="{{ $row['from_account'] ?? '' }}">
                                       <option value="">-- Select From Account --</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">To Account <span class="text-danger">*</span></label>
                                    <select class="form-control to_account" name="vouchers[{{ $index }}][to_account]" required data-selected="{{ $row['to_account'] ?? '' }}">
                                       <option value="">-- Select To Account --</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!-- Amount and Assignment -->
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="vouchers[{{ $index }}][amount]" value="{{ $row['amount'] ?? '' }}" required>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">Assign</label>
                                    <select class="form-control" name="vouchers[{{ $index }}][assigned_to]">
                                       <option value="">-- Select --</option>
                                       <option value="Person A" {{ isset($row['assigned_to']) && $row['assigned_to'] == 'Person A' ? 'selected' : '' }}>Person A</option>
                                       <option value="Person B" {{ isset($row['assigned_to']) && $row['assigned_to'] == 'Person B' ? 'selected' : '' }}>Person B</option>
                                       <option value="Entity X" {{ isset($row['assigned_to']) && $row['assigned_to'] == 'Entity X' ? 'selected' : '' }}>Entity X</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!-- Narration -->
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">Narration</label>
                                    <textarea class="form-control" name="vouchers[{{ $index }}][narration]" rows="2">{{ $row['narration'] ?? '' }}</textarea>
                                    <div class="form-check mt-2">
                                       <input type="checkbox" class="form-check-input toggle-tally" id="toggle_tally_{{ $index }}" {{ empty($row['tally_narration']) ? 'checked' : '' }}>
                                       <label class="form-check-label" for="toggle_tally_{{ $index }}"> Same as Tally Narration</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6 tally-narration {{ empty($row['tally_narration']) ? 'd-none' : '' }}">
                                 <div class="mb-3">
                                    <label class="form-label">Tally Narration</label>
                                    <textarea class="form-control" name="vouchers[{{ $index }}][tally_narration]" rows="2">{{ $row['tally_narration'] ?? '' }}</textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="text-end mb-3 remove-row-container {{ $loop->first ? 'd-none' : '' }}">
                              <button type="button" class="btn btn-danger remove-row-btn">Remove</button>
                           </div>
                           <hr>
                        </div>
                        @endforeach
                     </div>
                     <div class="mb-3">
                        <button type="button" class="btn btn-secondary" id="addMoreBtn">+ Add More</button>
                     </div>
                     <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update Voucher</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       const voucherTypeSelect = document.getElementById('voucher_type');
       let ledgerOptions = null;
   
       // Initialize Select2 for multi-select fields
       function initSelect2() {
           $('.against-voucher-select').select2({
               placeholder: "Select voucher(s)",
               allowClear: true,
               width: '100%'
           });
           
           $('.sales-voucher-select').select2({
               placeholder: "Select voucher(s)",
               allowClear: true,
               width: '100%'
           });
       }
   
       // Fetch ledgers and populate dropdowns
      function fetchLedgersAndPopulateDropdowns(type) {
       if (!type) return;
   
      fetch(`/admin/voucher/get-ledgers?voucher_type=${type}`)
       
           .then(response => response.json())
           .then(data => {
               ledgerOptions = data;
   
               document.querySelectorAll('.voucher-row').forEach(row => {
                   const fromSelect = row.querySelector('.from_account');
                   const toSelect = row.querySelector('.to_account');
                   const selectedFrom = fromSelect.getAttribute('data-selected');
                   const selectedTo = toSelect.getAttribute('data-selected');
   
                   // From Account
                   fromSelect.innerHTML = '<option value="">-- Select From Account --</option>';
                   data.from?.forEach(item => {
                       const option = new Option(item.name, item.id);
                       if (item.id == selectedFrom) option.selected = true;
                       fromSelect.add(option);
                   });
   
                   // To Account
                   toSelect.innerHTML = '<option value="">-- Select To Account --</option>';
                   data.to?.forEach(item => {
                       const option = new Option(item.name, item.id);
                       if (item.id == selectedTo) option.selected = true;
                       toSelect.add(option);
                   });
   
                   // ✅ Against Voucher (for Payment)
                   const againstVoucherSelect = row.querySelector('.against-voucher-select');
                   const selectedAgainst = JSON.parse(againstVoucherSelect?.dataset.selected || '[]').map(String);
   
                   if (type === 'Payment' && againstVoucherSelect) {
                       againstVoucherSelect.innerHTML = '';
                       data.against_vouchers?.forEach(v => {
                           const option = new Option(v.label, v.label);
                           if (selectedAgainst.includes(v.label)) option.selected = true;
                           againstVoucherSelect.add(option);
                       });
   
                       $(againstVoucherSelect).val(selectedAgainst).trigger('change');
                   }
   
                   // ✅ Sales Voucher (for Receipt)
                   const salesVoucherSelect = row.querySelector('.sales-voucher-select');
                   const selectedSales = JSON.parse(salesVoucherSelect?.dataset.selected || '[]').map(String);
   
                   if (type === 'Receipt' && salesVoucherSelect) {
                       salesVoucherSelect.innerHTML = '';
                       data.against_vouchers?.forEach(v => {
                           const option = new Option(v.label, v.label);
                           if (selectedSales.includes(v.label)) option.selected = true;
                           salesVoucherSelect.add(option);
                       });
   
                       $(salesVoucherSelect).val(selectedSales).trigger('change');
                   }
               });
           })
           .catch(error => {
               console.error('Error fetching ledgers:', error);
               alert('An error occurred while fetching the ledgers.');
           });
   }
   
   
       // Update row fields based on voucher type
       function updateRowFields(row, type) {
           const againstVoucherContainer = row.querySelector('.against-voucher-container');
           const salesVoucherContainer = row.querySelector('.sales-voucher-container');
           const transactionIdContainer = row.querySelector('.transaction-id-container');
           const creditDaysContainer = row.querySelector('.credit-days-container');
           const cashCreditContainer = row.querySelector('.cash-credit-container');
           const tdsPayableContainer = row.querySelector('.tds-payable-container');
   
           // Hide all containers first
           againstVoucherContainer.style.display = 'none';
           salesVoucherContainer.style.display = 'none';
           transactionIdContainer.style.display = 'none';
           creditDaysContainer.style.display = 'none';
           cashCreditContainer.style.display = 'none';
           tdsPayableContainer.style.display = 'none';
   
           // Show relevant containers based on type
           if (type === 'Payment') {
               againstVoucherContainer.style.display = 'block';
               transactionIdContainer.style.display = 'block';
           } else if (type === 'Receipt') {
               salesVoucherContainer.style.display = 'block';
               transactionIdContainer.style.display = 'block';
           } else if (type === 'Contra') {
               transactionIdContainer.style.display = 'block';
           } else if (type === 'Sales') {
               creditDaysContainer.style.display = 'block';
               cashCreditContainer.style.display = 'block';
           } else if (type === 'Purchase' || type === 'Expense') {
               creditDaysContainer.style.display = 'block';
               cashCreditContainer.style.display = 'block';
               tdsPayableContainer.style.display = 'block';
           }
       }
   
       // Voucher type change handler
       voucherTypeSelect.addEventListener('change', function() {
           const type = this.value;
           document.querySelectorAll('.voucher-row').forEach(row => {
               updateRowFields(row, type);
           });
           fetchLedgersAndPopulateDropdowns(type);
       });
   
       // Add new row
       document.getElementById('addMoreBtn').addEventListener('click', function() {
           const container = document.getElementById('voucherRows');
           const rows = container.querySelectorAll('.voucher-row');
           const newRow = rows[rows.length - 1].cloneNode(true);
           const newIndex = rows.length;
           const voucherType = voucherTypeSelect.value;
   
           // Update all name attributes with new index
           newRow.querySelectorAll('[name]').forEach(el => {
               const name = el.name.replace(/\[\d+\]/, `[${newIndex}]`);
               el.name = name;
           });
   
           // Update IDs for radio buttons and their labels
           newRow.querySelectorAll('[id]').forEach(el => {
               const oldId = el.id;
               const newId = oldId.replace(/\d+$/, newIndex);
               el.id = newId;
               
               // Update corresponding labels
               const label = newRow.querySelector(`label[for="${oldId}"]`);
               if (label) label.setAttribute('for', newId);
           });
   
           // Reset form values
           newRow.querySelectorAll('input:not([type="radio"]):not([type="checkbox"]), textarea, select').forEach(field => {
               field.value = '';
           });
   
           // Reset checkboxes and radios
           newRow.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
               checkbox.checked = true;
           });
           newRow.querySelectorAll('input[type="radio"]').forEach(radio => {
               radio.checked = false;
               if (radio.value === 'Credit') radio.checked = true;
           });
   
           // Reset tally narration
           const toggleTally = newRow.querySelector('.toggle-tally');
           toggleTally.checked = true;
           newRow.querySelector('.tally-narration').classList.add('d-none');
   
           // Setup toggle narration listener
           setupTallyNarrationToggle(newRow);
   
           // Show remove button
           newRow.querySelector('.remove-row-container').classList.remove('d-none');
   
           // Initialize fields based on current voucher type
           updateRowFields(newRow, voucherType);
   
           // If ledger options are available, populate dropdowns
           if (ledgerOptions) {
               const fromSelect = newRow.querySelector('.from_account');
               const toSelect = newRow.querySelector('.to_account');
   
               fromSelect.innerHTML = '<option value="">-- Select From Account --</option>';
               ledgerOptions.from?.forEach(item => {
                   fromSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
               });
   
               toSelect.innerHTML = '<option value="">-- Select To Account --</option>';
               ledgerOptions.to?.forEach(item => {
                   toSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
               });
           }
   
           container.appendChild(newRow);
           initSelect2();
       });
   
       // Remove row
       document.addEventListener('click', function(e) {
           if (e.target.classList.contains('remove-row-btn')) {
               const rows = document.querySelectorAll('.voucher-row');
               if (rows.length > 1) {
                   e.target.closest('.voucher-row').remove();
               } else {
                   alert('At least one row is required.');
               }
           }
       });
   
       // Toggle tally narration
       function setupTallyNarrationToggle(row) {
           const toggle = row.querySelector('.toggle-tally');
           const narrationContainer = row.querySelector('.tally-narration');
           
           toggle.addEventListener('change', function() {
               if (this.checked) {
                   narrationContainer.classList.add('d-none');
               } else {
                   narrationContainer.classList.remove('d-none');
               }
           });
       }
   
       // Initialize tally narration toggles for existing rows
       document.querySelectorAll('.voucher-row').forEach(row => {
           setupTallyNarrationToggle(row);
       });
   
       // Initialize on page load
       initSelect2();
       fetchLedgersAndPopulateDropdowns(voucherTypeSelect.value);
   });
</script>
@endsection