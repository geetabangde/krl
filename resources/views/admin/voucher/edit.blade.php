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
        <a href="{{ route('admin.voucher.index') }}" class="btn" id="backToListBtn"
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
              <option value="Payment" {{ $voucher->voucher_type == 'Payment' ? 'selected' : '' }}>
              Payment</option>
              <option value="Receipt" {{ $voucher->voucher_type == 'Receipt' ? 'selected' : '' }}>
              Receipt</option>
              <option value="Journal" {{ $voucher->voucher_type == 'Journal' ? 'selected' : '' }}>
              Journal</option>
              <option value="Contra" {{ $voucher->voucher_type == 'Contra' ? 'selected' : '' }}>Contra
              </option>
              <option value="Sales" {{ $voucher->voucher_type == 'Sales' ? 'selected' : '' }}>Sales
              </option>
              <option value="Purchase" {{ $voucher->voucher_type == 'Purchase' ? 'selected' : '' }}>
              Purchase</option>
              <option value="Expense" {{ $voucher->voucher_type == 'Expense' ? 'selected' : '' }}>
              Expense</option>
            </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
            <label class="form-label">Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="voucher_date" value="{{ $voucher->voucher_date }}"
              required>
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
            <input type="text" class="form-control" name="vouchers[{{ $index }}][voucher_no]"
            value="{{ $row['voucher_no'] ?? '' }}" required>
          </div>
          </div>
          {{-- @dd($voucher); --}}
          <!-- Against Voucher (conditionally shown) -->
          <div class="col-md-6 against-voucher-container"
          style="display: {{ in_array($voucher->voucher_type, ['Payment']) ? 'block' : 'none' }};">
          <div class="mb-3">
            <label class="form-label">Against Voucher</label>
            @php

          $rawAgainst = $row['against_voucher'] ?? [];


          if (is_string($rawAgainst)) {
          $againstVouchers = collect(json_decode($rawAgainst, true) ?? []);
          } elseif (is_array($rawAgainst)) {
          $againstVouchers = collect($rawAgainst);
          } else {
          $againstVouchers = collect();
          }


          if ($againstVouchers->isNotEmpty() && is_string($againstVouchers->first())) {
          $againstVouchers = $againstVouchers->map(fn($val) => ['label' => $val]);
          }
         @endphp

            <select class="form-control against-voucher-select"
            name="vouchers[{{ $index }}][against_voucher][]" multiple
            data-selected='@json($againstVouchers->pluck("label"))'>
            @foreach ($againstVouchers as $v)
          <option value="{{ $v['label'] ?? '' }}" selected>{{ $v['label'] ?? '' }}</option>
        @endforeach
            </select>

          </div>
          </div>

          {{-- @dd($voucher->vouchers); --}}
          <div class="col-md-6 sales-voucher-container"
          style="display: {{ in_array($voucher->voucher_type, ['Receipt']) ? 'block' : 'none' }};">
          <div class="mb-3">
            <label class="form-label">Receipt Voucher</label>
            @php

          $sales = collect($row['sales_voucher'] ?? [])->map(function ($v) {
          return is_array($v) ? $v : ['label' => $v];
          });
         @endphp

            <select class="form-control sales-voucher-select" name="vouchers[{{ $index }}][sales_voucher][]"
            multiple data-selected='@json($sales->pluck("label"))'>
            @foreach ($sales as $v)
          <option value="{{ $v['label'] }}" selected>{{ $v['label'] }}</option>
        @endforeach
            </select>
          </div>
          </div>
          <!-- Transaction ID (conditionally shown) -->
          <div class="col-md-6 transaction-id-container"
          style="display: {{ in_array($voucher->voucher_type, ['Payment', 'Receipt', 'Contra']) ? 'block' : 'none' }};">
          <div class="mb-3">
            <label class="form-label">Transaction ID</label>
            <input type="text" class="form-control" name="vouchers[{{ $index }}][transaction_id]"
            value="{{ $row['transaction_id'] ?? '' }}">
          </div>
          </div>
          {{-- @dd($voucher->vouchers); --}}
          <div class="col-md-6 sales-voucher-container payment-container"
          style="display: {{ in_array($voucher->voucher_type, ['Receipt']) ? 'block' : 'none' }};">
            <div class="mb-3">
              <label class="form-label">Is Advance Receipt</label>
              <select name="vouchers[0][is_advance_receipt]" class="form-control">
                <option value="">Select an Option</option>
                <option value="Yes" {{ (isset($row['is_advance_receipt']) && $row['is_advance_receipt'] == 'Yes') ? 'selected' : '' }}>Yes
                </option>
                <option value="No" {{ (isset($row['is_advance_receipt']) && $row['is_advance_receipt'] == 'No') ? 'selected' : '' }}>No</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 sales-voucher-container payment-container"
          style="display: {{ in_array($voucher->voucher_type, ['Payment', 'Receipt']) ? 'block' : 'none' }};">
              <div class="mb-3">
                  <label class="form-label">Instrument Type</label>
                  <select name="vouchers[{{ $index }}][instrument_type]" class="form-control">
                    <option value="">Select Type</option>
                    @foreach(['Cheque', 'NEFT', 'RTGS'] as $type)
                  <option value="{{ $type }}" {{ (isset($row['instrument_type']) && $row['instrument_type'] == $type) ? 'selected' : '' }}>
                  {{ $type }}
                  </option>
                @endforeach
                  </select>
              </div>
          </div>

          <div class="col-md-6 sales-voucher-container payment-container"
          style="display: {{ in_array($voucher->voucher_type, ['Payment', 'Receipt']) ? 'block' : 'none' }};">
          <div class="mb-3">
            <label class="form-label">Instrument Number</label>
            <input type="text" name="vouchers[0][instrument_number]" class="form-control"
              value="{{ old("vouchers.$index.instrument_number", $row['instrument_number'] ?? '') }}">
            </div>
          </div>

          <div class="col-md-6 sales-voucher-container payment-container"
          style="display: {{ in_array($voucher->voucher_type, ['Payment', 'Receipt']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Instrument Date</label>
          <input type="date" name="vouchers[0][instrument_date]" class="form-control"
            value="{{ old("vouchers.$index.instrument_date", $row['instrument_date'] ?? '') }}">
          </div>
          </div>
          <!-- Is Invoice for sales -->
          <div class="col-md-6 is-invoice-container" style="display: {{ in_array($voucher->voucher_type, ['Sales']) ? 'block' : 'none' }};">
            <div class="mb-3">
                <label class="form-label">Is Invoice</label>
                <select name="vouchers[{{ $index }}][is_invoice]" class="form-control">
                  <option value="">Select an Option</option>
                  <option value="Yes" {{ (isset($row['is_invoice']) && $row['is_invoice'] == 'Yes') ? 'selected' : '' }}>Yes
                  </option>
                  <option value="No" {{ (isset($row['is_invoice']) && $row['is_invoice'] == 'No') ? 'selected' : '' }}>No</option>
                </select>
            </div>
          </div>
          <!-- bill wise details -->
          <div class="col-md-6 bill-wise-container"
          style="display: {{ in_array($voucher->voucher_type, ['Sales']) ? 'block' : 'none' }};">
            <div class="mb-3">
            <label class="form-label">Bill Wise</label>
            <select name="vouchers[{{ $index }}][bill_wise]" class="form-control">
              <option value="">Select an Option</option>
              <option value="Yes" {{ (isset($row['bill_wise']) && $row['bill_wise'] == 'Yes') ? 'selected' : '' }}>Yes
              </option>
              <option value="No" {{ (isset($row['bill_wise']) && $row['bill_wise'] == 'No') ? 'selected' : '' }}>No</option>
            </select>
            </div>
          </div>
          <!-- irn ack no for sales -->
          <div class="col-md-6 irn-ack-no-container"
          style="display: {{ in_array($voucher->voucher_type, ['Sales']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">IRN Ack No</label>
          <input type="text" name="vouchers[{{ $index }}][irn_ack_no]" class="form-control"
            value="{{ old("vouchers.$index.irn_ack_no", $row['irn_ack_no'] ?? '') }}">
          </div>
          </div>
          <!-- irn ack date for sales -->
          <div class="col-md-6 irn-ack-date-container"
          style="display: {{ in_array($voucher->voucher_type, ['Sales']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">IRN Ack Date</label>
          <input type="date" name="vouchers[{{ $index }}][irn_ack_date]" class="form-control"
            value="{{ old("vouchers.$index.irn_ack_date", $row['irn_ack_date'] ?? '') }}">
          </div>
          </div>
          <!-- irn_no for sales -->
          <div class="col-md-6 irn-no-container"
          style="display: {{ in_array($voucher->voucher_type, ['Sales']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">IRN No</label>
          <input type="text" name="vouchers[{{ $index }}][irn_no]" class="form-control"
            value="{{ old("vouchers.$index.irn_no", $row['irn_no'] ?? '') }}">
          </div>
          </div>
          <!-- irn bill to place -->
          <div class="col-md-6 irn-bill-to-place-container"
          style="display: {{ in_array($voucher->voucher_type, ['Sales']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">IRN Bill To Place</label>
          <input type="text" name="vouchers[{{ $index }}][irn_bill_to_place]" class="form-control"
            value="{{ old("vouchers.$index.irn_bill_to_place", $row['irn_bill_to_place'] ?? '') }}">
          </div>
          </div>
          <!-- irn ship to state -->
           <div class="col-md-6 irn-ship-to-state-container"
          style="display: {{ in_array($voucher->voucher_type, ['Sales']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">IRN Ship To State</label>
          <input type="text" name="vouchers[{{ $index }}][irn_ship_to_state]" class="form-control"
            value="{{ old("vouchers.$index.irn_ship_to_state", $row['irn_ship_to_state'] ?? '') }}">
          </div>
          </div>
          
          <!-- purchase for supplier inv no -->
          <div class="col-md-6supplier-inv-no-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Supplier Inv No</label>
          <input type="text" name="vouchers[{{ $index }}][supplier_inv_no]" class="form-control"
            value="{{ old("vouchers.$index.supplier_inv_no", $row['supplier_inv_no'] ?? '') }}">
          </div>
          </div>
          <!-- purchase for supplier inv date -->
          <div class="col-md-6 supplier-inv-date-container" style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};"> 
            <div class="mb-3">
          <label class="form-label">Supplier Inv Date</label>
          <label class="form-label">Supplier Inv Date</label>
          <input type="date" name="vouchers[{{ $index }}][supplier_inv_date]" class="form-control"
            value="{{ old("vouchers.$index.supplier_inv_date", $row['supplier_inv_date'] ?? '') }}">
          </div>
          </div>
          <!-- vat tin no -->
          <div class="col-md-6 vat-tin-no-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">VAT Tin No</label>
          <input type="text" name="vouchers[{{ $index }}][vat_tin_no]" class="form-control"
            value="{{ old("vouchers.$index.vat_tin_no", $row['vat_tin_no'] ?? '') }}">
          </div>
          </div>
          <!-- cst no -->
          <div class="col-md-6 cst-no-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">CST No</label>
          <input type="text" name="vouchers[{{ $index }}][cst_no]" class="form-control"
            value="{{ old("vouchers.$index.cst_no", $row['cst_no'] ?? '') }}">
          </div>
          </div>
          <!-- service tax no -->
          <div class="col-md-6 service-tax-no-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Service Tax No</label>
          <input type="text" name="vouchers[{{ $index }}][service_tax_no]" class="form-control"
          value="{{ old("vouchers.$index.service_tax_no", $row['service_tax_no']?? '') }}">
          </div>
          </div>
           <!-- dr cr journal -->
          <div class="col-md-6 dr-cr-journal-container"
          style="display: {{ in_array($voucher->voucher_type, ['Journal']) ? 'block' : 'none' }};">
            <div class="mb-3">
            <label class="form-label">DR/CR Journal</label>
            <input type="text" name="vouchers[{{ $index }}][dr_cr_journal]" class="form-control"
              value="{{ old("vouchers.$index.dr_cr_journal", $row['dr_cr_journal'] ?? '') }}">
            </div>
          </div>
          <!-- bill ref no -->
          <div class="col-md-6 mb-3 bill-ref-no-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Bill Ref No</label>
          <input type="text" name="vouchers[{{ $index }}][bill_ref_no]" class="form-control"
            value="{{ old("vouchers.$index.bill_ref_no", $row['bill_ref_no'] ?? '') }}">
          </div>
          </div>
          <!-- cost center -->
          <div class="col-md-6 cost-center-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Cost Center</label>
          <input type="text" name="vouchers[{{ $index }}][cost_center]" class="form-control"
            value="{{ old("vouchers.$index.cost_center", $row['cost_center'] ?? '') }}">
          </div>
          </div>
          <!-- stock item -->
          <div class="col-md-6 stock-item-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Stock Item</label>
          <input type="text" name="vouchers[{{ $index }}][stock_item]" class="form-control"
            value="{{ old("vouchers.$index.stock_item", $row['stock_item'] ?? '') }}">
          </div>
          </div>
          <!-- godown -->
          <div class="col-md-6 godown-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Godown</label>
          <input type="text" name="vouchers[{{ $index }}][godown]" class="form-control"
          value="{{ old("vouchers.$index.godown", $row['godown']?? '') }}">
          </div>
          </div>
          <!-- batch no -->
          <div class="col-md-6 batch-no-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Batch No</label>
          <input type="text" name="vouchers[{{ $index }}][batch_no]" class="form-control"
            value="{{ old("vouchers.$index.batch_no", $row['batch_no'] ?? '') }}">
          </div>
          </div>
          <!-- qty -->
           <div class="col-md-6 qty-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Quantity</label>
          <input type="number" name="vouchers[{{ $index }}][qty]" class="form-control"
            value="{{ old("vouchers.$index.qty", $row['qty'] ?? '') }}">
          </div>
          </div>
          <!-- rate -->
          <div class="col-md-6 rate-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">Rate</label>
          <input type="number" name="vouchers[{{ $index }}][rate]" class="form-control"
            value="{{ old("vouchers.$index.rate", $row['rate'] ?? '') }}">
          </div>
          </div>
          <!-- uom -->
           <div class="col-md-6 uom-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase']) ? 'block' : 'none' }};">
          <div class="mb-3">
          <label class="form-label">UOM</label>
          <input type="text" name="vouchers[{{ $index }}][uom]" class="form-control"
          value="{{ old("vouchers.$index.uom", $row['uom']?? '') }}">
          </div>
          </div>

          <!-- Credit Days (conditionally shown) -->
          <div class="col-md-6 credit-days-container"
          style="display: {{ in_array($voucher->voucher_type, ['Sales', 'Purchase', 'Expense']) ? 'block' : 'none' }};">
          <div class="mb-3">
            <label class="form-label">Credit Days</label>
            <input type="number" class="form-control" name="vouchers[{{ $index }}][credit_day]"
            value="{{ $row['credit_day'] ?? '' }}">
          </div>
          </div>
          <!-- Cash/Credit (conditionally shown) -->
          <div class="col-md-6 cash-credit-container"
          style="display: {{ in_array($voucher->voucher_type, ['Sales', 'Purchase', 'Expense']) ? 'block' : 'none' }};">
          <div class="mb-3">
            <label class="form-label">Payment Type</label>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="vouchers[{{ $index }}][cash_credit]"
            id="cash_{{ $index }}" value="Cash" {{ isset($row['cash_credit']) && $row['cash_credit'] == 'Cash' ? 'checked' : '' }}>
            <label class="form-check-label" for="cash_{{ $index }}">Cash</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="vouchers[{{ $index }}][cash_credit]"
            id="credit_{{ $index }}" value="Credit" {{ !isset($row['cash_credit']) || $row['cash_credit'] == 'Credit' ? 'checked' : '' }}>
            <label class="form-check-label" for="credit_{{ $index }}">Credit</label>
            </div>
          </div>
          </div>
          <!-- TDS Payable (conditionally shown) -->
          <div class="col-md-6 tds-payable-container"
          style="display: {{ in_array($voucher->voucher_type, ['Purchase', 'Expense']) ? 'block' : 'none' }};">
          <div class="mb-3">
            <label class="form-label">TDS Payable</label>
            <input type="number" class="form-control" name="vouchers[{{ $index }}][tds_payable]"
            value="{{ $row['tds_payable'] ?? '' }}">
          </div>
          </div>
          <!-- From/To Accounts -->
          <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
            <label class="form-label">From Account <span class="text-danger">*</span></label>
            <select class="form-control from_account" name="vouchers[{{ $index }}][from_account]" required
            data-selected="{{ $row['from_account'] ?? '' }}">
            <option value="">-- Select From Account --</option>
            </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
            <label class="form-label">To Account <span class="text-danger">*</span></label>
            <select class="form-control to_account" name="vouchers[{{ $index }}][to_account]" required
            data-selected="{{ $row['to_account'] ?? '' }}">
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
            <input type="number" class="form-control" name="vouchers[{{ $index }}][amount]"
            value="{{ $row['amount'] ?? '' }}" required>
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
            <textarea class="form-control" name="vouchers[{{ $index }}][narration]"
            rows="2">{{ $row['narration'] ?? '' }}</textarea>
            <div class="form-check mt-2">
            <input type="checkbox" class="form-check-input toggle-tally" id="toggle_tally_{{ $index }}" {{ empty($row['tally_narration']) ? 'checked' : '' }}>
            <label class="form-check-label" for="toggle_tally_{{ $index }}"> Same as Tally
            Narration</label>
            </div>
            </div>
          </div>
          <div class="col-md-6 tally-narration {{ empty($row['tally_narration']) ? 'd-none' : '' }}">
            <div class="mb-3">
            <label class="form-label">Tally Narration</label>
            <textarea class="form-control" name="vouchers[{{ $index }}][tally_narration]"
            rows="2">{{ $row['tally_narration'] ?? '' }}</textarea>
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
    document.addEventListener('DOMContentLoaded', function () {
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



        fromSelect.innerHTML = '<option value="">-- Select From Account --</option>';
        data.from?.forEach(item => {
          const optionValue = `${item.id}__${item.address_index}`;
          const option = new Option(item.name, optionValue); // Optional: show city
          if (optionValue == selectedFrom) option.selected = true;
          fromSelect.add(option);
        });

        toSelect.innerHTML = '<option value="">-- Select To Account --</option>';
        data.to?.forEach(item => {
          const optionValue = `${item.id}__${item.address_index}`;
          const option = new Option(item.name, optionValue);
          if (optionValue == selectedTo) option.selected = true;
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
      // for sales
      const isInvoiceContainer = row.querySelector('.is-invoice-container');
      const billWiseContainer = row.querySelector('.bill-wise-container');
      const irnAckNoContainer = row.querySelector('.irn-ack-no-container');
      const irnAckDateContainer = row.querySelector('.irn-ack-date-container');
      const irnNoContainer = row.querySelector('.irn-no-container');
      const irnBillToPlaceContainer = row.querySelector('.irn-bill-to-place-container');
      const irnShipToStateContainer = row.querySelector('.irn-ship-to-state-container');
      const irnShipToStateCodeContainer = row.querySelector('.irn-ship-to-state-code-container');
      // for purchase
      const supplierInvNoContainer = row.querySelector('.supplier-inv-no-container');
      const supplierInvDateContainer = row.querySelector('.supplier-inv-date-container');
      const vatTinNoContainer = row.querySelector('.vat-tin-no-container');
      const cstNoContainer = row.querySelector('.cst-no-container');  
      const cstDateContainer = row.querySelector('.cst-date-container');  
      const serviceTaxNoContainer = row.querySelector('.service-tax-no-container');

      // for journal
      const drCrJournalContainer = row.querySelector('.dr-cr-journal-container');
      const billRefNoContainer = row.querySelector('.bill-ref-no-container');
      const costCenterContainer = row.querySelector('.cost-center-container');
      const stockItemContainer = row.querySelector('.stock-item-container');
      const godownContainer = row.querySelector('.godown-container');
      const batchNoContainer = row.querySelector('.batch-no-container');
      const qtyContainer = row.querySelector('.qty-container');
      const rateContainer = row.querySelector('.rate-container');
      const uomContainer = row.querySelector('.uom-container');

      // Hide all containers first
      againstVoucherContainer.style.display = 'none';
      salesVoucherContainer.style.display = 'none';
      transactionIdContainer.style.display = 'none';
      creditDaysContainer.style.display = 'none';
      cashCreditContainer.style.display = 'none';
      tdsPayableContainer.style.display = 'none';

      // and for sales
      isInvoiceContainer.style.display = 'none';
      billWiseContainer.style.display = 'none';
      irnAckNoContainer.style.display = 'none';
      irnAckDateContainer.style.display = 'none';
      irnNoContainer.style.display = 'none';
      irnBillToPlaceContainer.style.display = 'none';
      irnShipToStateContainer.style.display = 'none';
      irnShipToStateCodeContainer.style.display = 'none';

      // and for purchase
      supplierInvNoContainer.style.display = 'none';
      supplierInvDateContainer.style.display = 'none';
      vatTinNoContainer.style.display = 'none';
      cstNoContainer.style.display = 'none';  
      cstDateContainer.style.display = 'none';  
      serviceTaxNoContainer.style.display = 'none';
      // for journal
      drCrJournalContainer.style.display = 'none';
      billRefNoContainer.style.display = 'none';
      costCenterContainer.style.display = 'none';
      stockItemContainer.style.display = 'none';
      godownContainer.style.display = 'none';
      batchNoContainer.style.display = 'none';
      qtyContainer.style.display = 'none';
      rateContainer.style.display = 'none';
      uomContainer.style.display = 'none';

      // Show relevant containers based on type
      if (type === 'Payment') {
      againstVoucherContainer.style.display = 'block';
      transactionIdContainer.style.display = 'block';
      row.querySelectorAll('.payment-container').forEach(el => {
        el.style.display = 'block';
      });
      } else if (type === 'Receipt') {

      salesVoucherContainer.style.display = 'block';
      transactionIdContainer.style.display = 'block';
      row.querySelectorAll('.payment-container').forEach(el => {
        el.style.display = 'block';
      });
      } else if (type === 'Contra') {
      transactionIdContainer.style.display = 'block';
      } else if (type === 'Sales') {
      creditDaysContainer.style.display = 'block';
      cashCreditContainer.style.display = 'block';

      // for sales

      isInvoiceContainer.style.display = 'block';
      billWiseContainer.style.display = 'block';
      irnAckNoContainer.style.display = 'block';
      irnAckDateContainer.style.display = 'block';
      irnNoContainer.style.display = 'block';
      irnBillToPlaceContainer.style.display = 'block';
      irnShipToStateContainer.style.display = 'block';
      irnShipToStateCodeContainer.style.display = 'block';

      } else if (type === 'Purchase' || type === 'Expense') {
      creditDaysContainer.style.display = 'block';
      cashCreditContainer.style.display = 'block';
      tdsPayableContainer.style.display = 'block';
      // for purchase
      supplierInvNoContainer.style.display = 'block';
      supplierInvDateContainer.style.display = 'block';
      vatTinNoContainer.style.display = 'block';
      cstNoContainer.style.display = 'block';
      cstDateContainer.style.display = 'block';
      serviceTaxNoContainer.style.display = 'block';
      }
      else if (type === 'Journal') {
      drCrJournalContainer.style.display = 'block';
      billRefNoContainer.style.display = 'block';
      costCenterContainer.style.display = 'block';
      stockItemContainer.style.display = 'block';
      godownContainer.style.display = 'block';
      batchNoContainer.style.display = 'block';
      qtyContainer.style.display = 'block';
      rateContainer.style.display = 'block';
      uomContainer.style.display = 'block';
    }

    // Voucher type change handler
    voucherTypeSelect.addEventListener('change', function () {
      const type = this.value;
      document.querySelectorAll('.voucher-row').forEach(row => {
      updateRowFields(row, type);
      });
      fetchLedgersAndPopulateDropdowns(type);
    });

    // Add new row
    document.getElementById('addMoreBtn').addEventListener('click', function () {
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
    document.addEventListener('click', function (e) {
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

      toggle.addEventListener('change', function () {
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