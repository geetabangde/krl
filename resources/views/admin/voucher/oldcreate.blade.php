@extends('admin.layouts.app')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- Voucher Add/Edit Form -->
      <div class="row add-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4>➕ Add Voucher</h4>
                     <p>Fill in the details to create a new voucher.</p>
                  </div>
                  <a href="{{ route('admin.voucher.index') }}" class="btn" id="backToVoucherListBtn"
                     style="background-color: #ca2639; color: white; border: none;">
                  ⬅ Back
                  </a>
               </div>
               <form method="POST" action="{{ route('admin.voucher.store') }}">
                  @csrf
                  <div class="card-body">
                     <!-- Row 1: Voucher Type & Date -->
                     <div class="row">
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="form-label">Voucher Type <span class="text-danger">*</span></label>
                              <select class="form-control voucher-type" name="voucher_type" id="voucher_type" required>
                                 <option value="">-- Select --</option>
                                 <option value="Payment">Payment</option>
                                 <option value="Receipt">Receipt</option>
                                 <option value="Journal">Journal</option>
                                 <option value="Contra">Contra</option>
                                 <option value="Sales">Sales</option>
                                 <option value="Purchase">Purchase</option>
                                 <option value="Expense">Expense</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="form-label">Date <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" name="voucher_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                           </div>
                        </div>
                     </div>
                     <!-- Voucher Rows -->
                     <div id="voucherRows">
                        <div class="voucher-row" data-index="0">
                           <!-- This block will be cloned -->
                           <!-- Number Voucher  -->
                           <div class="col-md-6">
                              <div class="mb-3">
                                 <label class="form-label">Voucher Number<span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="vouchers[0][voucher_no]">
                              </div>
                           </div>
                           <!-- Against Voucher (hidden by default) -->
                           <div class="col-md-6 against-voucher-container" style="display: none;">
                              <div class="mb-3">
                                 <label class="form-label">Against Voucher<span class="text-danger">*</span></label>
                                 <select class="form-control" name="vouchers[0][against_voucher][]" id="against_voucher" multiple>
                                    <!-- Options will be dynamically set in JS -->
                                 </select>
                              </div>
                           </div>
                           <!-- Sales Voucher (for Sales) -->
                            <div class="col-md-6 sales-voucher-container" style="display: none;">
                              <div class="mb-3">
                                 <label class="form-label"> Receipt Voucher<span class="text-danger">*</span></label>
                                 <select class="form-control" name="vouchers[0][sales_voucher][]" id="sales_voucher" multiple>
                                    <option value="sale">SaleS</option>
                                 </select>
                              </div>
                           </div>
                           <!-- Transaction ID (hidden by default) -->
                            <div class="col-md-6 transaction-id-container" style="display: none;">
                              <div class="mb-3">
                                 <label class="form-label">Transaction Id </label>
                                 <input type="text" class="form-control" id="transaction_id" name="vouchers[0][transaction_id]" />
                              </div>
                           </div>
                           <!-- Credit Days -->
                            <div class="col-md-6 credit-days-container" style="display: none;">
                              <div class="mb-3">
                                 <label class="form-label">Credit Days</label>
                                 <input type="text" class="form-control" name="vouchers[0][credit_day]">
                              </div>
                           </div>
                           <!-- Cash / Credit Radios Wrapper -->
                            <div class="col-md-6 cash-credit-container" style="display:none;">
                              <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name="vouchers[0][cash_credit]" id="cash_option" value="Cash">
                                 <label class="form-check-label" for="cash_option">Cash</label>
                              </div>
                              <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name="vouchers[0][cash_credit]" id="credit_option" value="Credit" checked>
                                 <label class="form-check-label" for="credit_option">Credit</label>
                              </div>
                           </div>
                           <!-- TDS Payable -->
                           <div class="col-md-6 tds-payable-container" style="display: none;">
                              <div class="mb-3">
                                 <label class="form-label">TDS Payable</label>
                                 <input type="text" class="form-control" name="vouchers[0][tds_payable]">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">From Account <span class="text-danger">*</span></label>
                                    <select class="form-control from_account" name="vouchers[0][from_account]" required>
                                       <option value="">-- Select From Account --</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">To Account <span class="text-danger">*</span></label>
                                    <select class="form-control to_account" name="vouchers[0][to_account]" required>
                                       <option value="">-- Select To Account --</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="vouchers[0][amount]" placeholder="Enter amount" required>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label">Assign</label>
                                    <select class="form-control" name="vouchers[0][assigned_to]">
                                       <option value="">-- Select Person or Entity --</option>
                                       <option value="Person A">Person A</option>
                                       <option value="Person B">Person B</option>
                                       <option value="Entity X">Entity X</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                            <!--  -->
                           <div class="row">
                                 <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Narration</label>
                                       <textarea class="form-control narration-input" name="vouchers[0][narration]" rows="2"></textarea>
                                       
                                       <div class="form-check mt-2">
                                          <input type="checkbox" class="form-check-input toggle-tally same-as-tally" id="toggle_tally_0" checked>
                                          <label class="form-check-label" for="toggle_tally_0">Same as Tally Narration</label>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-6 tally-narration d-none">
                                    <div class="mb-3">
                                       <label class="form-label">Tally Narration</label>
                                       <textarea class="form-control tally-narration-input" name="vouchers[0][tally_narration]" rows="2"></textarea>
                                    </div>
                                 </div>
                           </div>

                           <!--  -->
                           <div class="text-end mb-3 removeRowContainer d-none">
                              <button type="button" class="btn btn-danger removeRowBtn">Remove</button>
                           </div>
                           <hr>
                        </div>
                     </div>
                     <!-- Add More -->
                     <div class="mb-3">
                        <button type="button" class="btn btn-secondary" id="addMoreBtn">+ Add More</button>
                     </div>
                       <!-- Container for hidden inputs -->
                        <div id="againstVoucherLabelsContainer"></div>
                     <!-- Submit -->
                     <div class="row">
                        <div class="col-12 text-end">
                           <button type="submit" class="btn btn-primary">Save Voucher</button>
                        </div>
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

<!-- JS: AJAX to fetch filtered ledgers -->
 <script>
   document.addEventListener('DOMContentLoaded', function () {
       const dateInput = document.querySelector('input[name="voucher_date"]');
       if (dateInput && !dateInput.value) {
           const today = new Date().toISOString().split('T')[0];
           dateInput.value = today;
       }
   });
</script>

 
<script>
document.addEventListener('DOMContentLoaded', function () {
    const voucherTypeSelect = document.getElementById('voucher_type');

    // Apply toggle logic for all existing rows
    document.querySelectorAll('.voucher-row').forEach(row => {
        setupTallyNarrationToggle(row);
    });

    // Main voucher type dropdown listener
    voucherTypeSelect.addEventListener('change', function () {
        const type = this.value;
        document.querySelectorAll('.voucher-row').forEach(row => {
            updateRowFields(row, type);
        });
        fetchLedgerOptions(type);
    });

    // Add More Button Click
    document.getElementById('addMoreBtn').addEventListener('click', function () {
    const container = document.getElementById('voucherRows');
    const rows = container.querySelectorAll('.voucher-row');
    const lastRow = rows[rows.length - 1];

    // Destroy Select2 instances on the last row before cloning
    $(lastRow).find('select').each(function () {
        if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).select2('destroy');
        }
    });

    // Clone the last row
    const newRow = lastRow.cloneNode(true);
    const newIndex = rows.length; // zero-based index, or use rows.length for next index

    // Update all name/id attributes and dataset index for new row
    updateRowIndexes(newRow, newIndex);

    // Reset all inputs except checkboxes/radios
    newRow.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]), textarea, select').forEach(field => {
        field.value = '';
    });



    // Reset checkboxes and radios
    newRow.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
    newRow.querySelectorAll('input[type="radio"]').forEach(rb => rb.checked = false);

    // Special handling for toggle-tally checkbox: default checked and hide narration
    const toggleTally = newRow.querySelector('.toggle-tally');
    toggleTally.checked = true;
    newRow.querySelector('.tally-narration').classList.add('d-none');

    // Setup toggle event listener on the new row
    setupTallyNarrationToggle(newRow);

    // Show remove button container
    newRow.querySelector('.removeRowContainer').classList.remove('d-none');

    // Hide all special containers initially
    newRow.querySelectorAll('.against-voucher-container, .sales-voucher-container, .transaction-id-container, .credit-days-container, .cash-credit-container, .tds-payable-container')
        .forEach(div => div.style.display = 'none');

      // Append new row to container
      container.appendChild(newRow);

      // Reinitialize Select2 on the new row's selects
      $(newRow).find('select').each(function () {
         $(this).select2({
               width: '100%',
               placeholder: $(this).attr('placeholder') || 'Select',
               allowClear: true
         });
      });

      // Finally update the new row fields based on current voucher type
      updateRowFields(newRow, voucherTypeSelect.value);

       // ✅ ✅ FIX: Re-fetch ledger options for the new row
        fetchLedgerOptions(voucherTypeSelect.value);
   });


    // Remove Row Button
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeRowBtn')) {
            const rows = document.querySelectorAll('.voucher-row');
            if (rows.length > 1) {
                e.target.closest('.voucher-row').remove();
            } else {
                alert('At least one row is required.');
            }
        }
    });

    // Function to setup tally narration toggle for a row
    function setupTallyNarrationToggle(row) {
        const toggle = row.querySelector('.toggle-tally');
        const narrationContainer = row.querySelector('.tally-narration');
        
        // Remove any existing event listeners to prevent duplication
        const newToggle = toggle.cloneNode(true);
        toggle.replaceWith(newToggle);
        
        // Add fresh event listener
        newToggle.addEventListener('change', function() {
            if (this.checked) {
                narrationContainer.classList.add('d-none');
            } else {
                narrationContainer.classList.remove('d-none');
            }
        });
    }

    function updateRowFields(row, type) {
        const index = row.dataset.index || 0;
        const againstVoucherContainer = row.querySelector('.against-voucher-container');
        const againstVoucherSelect = row.querySelector(`[name="vouchers[${index}][against_voucher][]"]`);
        const salesVoucherContainer = row.querySelector('.sales-voucher-container');
        const salesVoucherSelect = row.querySelector(`[name="vouchers[${index}][sales_voucher][]"]`);
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

        // Destroy existing Select2 instances
        if ($(againstVoucherSelect).hasClass("select2-hidden-accessible")) {
            $(againstVoucherSelect).select2('destroy');
        }
        if ($(salesVoucherSelect).hasClass("select2-hidden-accessible")) {
            $(salesVoucherSelect).select2('destroy');
        }

        // Clear selects
        againstVoucherSelect.innerHTML = '';
        salesVoucherSelect.innerHTML = '';

        if (type === 'Payment') {
            againstVoucherContainer.style.display = 'block';
            transactionIdContainer.style.display = 'block';
            
            const options = ['Purchase', 'Expense'];
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt;
                option.text = opt;
                againstVoucherSelect.appendChild(option);
            });
            
            $(againstVoucherSelect).select2({ 
                placeholder: "Select voucher(s)", 
                width: '100%' 
            });
        } 
        else if (type === 'Receipt') {
            salesVoucherContainer.style.display = 'block';
            transactionIdContainer.style.display = 'block';
            
            const options = ['Sales'];
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt;
                option.text = opt;
                salesVoucherSelect.appendChild(option);
            });
            
            $(salesVoucherSelect).select2({ 
                placeholder: "Select receipt voucher(s)", 
                width: '100%' 
            });
        } 
        else if (type === 'Contra') {
            transactionIdContainer.style.display = 'block';
        } 
        else if (type === 'Sales') {
            creditDaysContainer.style.display = 'block';
            cashCreditContainer.style.display = 'block';
        } 
        else if (type === 'Purchase' || type === 'Expense') {
            creditDaysContainer.style.display = 'block';
            cashCreditContainer.style.display = 'block';
            tdsPayableContainer.style.display = 'block';
        }
    }

    function updateRowIndexes(row, index) {
        row.dataset.index = index;
        
        // Update all name attributes
        row.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
        });
        
        // Update all IDs and corresponding 'for' attributes
        row.querySelectorAll('[id]').forEach(el => {
            const oldId = el.id;
            const newId = oldId.replace(/\d+$/, index);
            el.id = newId;
            
            // Update any labels pointing to this ID
            row.querySelectorAll(`label[for="${oldId}"]`).forEach(label => {
                label.setAttribute('for', newId);
            });
        });
        
        // Special handling for radio buttons
        row.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.name = `vouchers[${index}][cash_credit]`;
        });
        
        // Special handling for toggle-tally
        const toggle = row.querySelector('.toggle-tally');
        const newId = `toggle_tally_${index}`;
        toggle.id = newId;
        row.querySelector('label[for^="toggle_tally_"]').setAttribute('for', newId);
    }

    // Ledger Fetch Logic
   function fetchLedgerOptions(type) {
    if (!type) return;

    fetch(`/admin/voucher/get-ledgers?voucher_type=${type}`)
    
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('.voucher-row').forEach((row, index) => {
                const fromSelect = row.querySelector('.from_account');
                const toSelect = row.querySelector('.to_account');
                const againstVoucherSelect = row.querySelector(`[name="vouchers[${index}][against_voucher][]"]`);
                const salesVoucherSelect = row.querySelector(`[name="vouchers[${index}][sales_voucher][]"]`);

                // From / To accounts
                fromSelect.innerHTML = '<option value="">-- Select From Account --</option>';
                toSelect.innerHTML = '<option value="">-- Select To Account --</option>';

                data.from?.forEach(item => {
                    fromSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });

                data.to?.forEach(item => {
                    toSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });

                // Against Vouchers (Payment)
                  if (type === 'Payment' && againstVoucherSelect) {
                     againstVoucherSelect.innerHTML = '';
                     data.against_vouchers?.forEach(v => {
                        const option = document.createElement('option');
                        option.value = v.value;
                        option.text = v.label;
                        againstVoucherSelect.appendChild(option);

                        // 👇 Hidden field to pass label to backend (appending to container)
                        if (!document.querySelector(`input[name="against_voucher_labels[${v.value}]"]`)) {
                              const hidden = document.createElement('input');
                              hidden.type = 'hidden';
                              hidden.name = `against_voucher_labels[${v.value}]`;
                              hidden.value = v.label;
                              const labelContainer = document.getElementById('againstVoucherLabelsContainer');
                              if (labelContainer) {
                                 labelContainer.appendChild(hidden);
                              }
                        }
                     });
                     $(againstVoucherSelect).select2({
                        placeholder: "Select voucher(s)",
                        width: '100%'
                     });
                  }

                  // Sales Vouchers (Receipt)
                  if (type === 'Receipt' && salesVoucherSelect) {
                     salesVoucherSelect.innerHTML = '';
                     data.against_vouchers?.forEach(v => {
                        const option = document.createElement('option');
                        option.value = v.value;
                        option.text = v.label;
                        salesVoucherSelect.appendChild(option);

                        // 👇 Hidden field for sales_voucher label (appending to container)
                        if (!document.querySelector(`input[name="against_voucher_labels[${v.value}]"]`)) {
                              const hidden = document.createElement('input');
                              hidden.type = 'hidden';
                              hidden.name = `against_voucher_labels[${v.value}]`;
                              hidden.value = v.label;
                              const labelContainer = document.getElementById('againstVoucherLabelsContainer');
                              if (labelContainer) {
                                 labelContainer.appendChild(hidden);
                              }
                        }
                     });
                     $(salesVoucherSelect).select2({
                        placeholder: "Select receipt voucher(s)",
                        width: '100%'
                     });
                  }

            });
        })
        .catch(error => {
            console.error('Error fetching ledgers:', error);
            alert('An error occurred while fetching the ledgers.');
        });
   }



    // Initial load ledger fetch
    if (voucherTypeSelect.value) {
        fetchLedgerOptions(voucherTypeSelect.value);
    }
});
</script>
@endsection