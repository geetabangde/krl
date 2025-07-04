<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Freight Bill</title>
  <style>
    @page {
      size: A4 landscape;
      margin: 0;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 20px;
      font-family: 'Segoe UI', sans-serif;
      background: #f2f2f2;
    }

    .print-btn {
      display: block;
      margin: 20px auto;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .print-btn:hover {
      background-color: #0056b3;
    }

    @media print {
      .print-btn {
        display: none;
      }
    }

    .container {
      max-width: 1100px;
      margin: auto;
      background: #fff;
      padding: 20px 25px;
      /* border-radius: 8px;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.15); */
    }

    .title {
      text-align: center;
      font-weight: bold;
      font-size: 22px;
      margin-bottom: 20px;
      text-transform: uppercase;
      border-bottom: 2px solid #000;
      padding-bottom: 8px;
    }

    .section {
      display: flex;
      justify-content: space-between;
      gap: 15px;
      margin-bottom: 15px;
    }

    .box {
      border: 1px solid #ccc;
      padding: 12px;
      /* border-radius: 6px; */
      background-color: #fcfcfc;
    }

    .left-box {
      flex: 1.5;
    }

    .right-box {
      flex: 1;
    }

    .half-box {
      flex: 1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14 px;
      margin-top: 10px;
    }

    th,
    td {
      border: 1px solid #888;
      padding: 6px;
      text-align: center;
    }

    th {
      background-color: #f0f0f0;
    }

    .total-in-words {
      margin-top: 15px;
      font-weight: 600;
    }

    .footer-section {
      display: flex;
      justify-content: space-between;
      gap: 15px;
      margin-top: 25px;
    }

    .terms {
      flex: 1.5;
      border: 1px solid #000;
      padding: 12px;
      /* border-radius: 6px; */
    }

    .gst-box {
      flex: 1;
      border: 1px solid #000;
      padding: 12px;
      /* border-radius: 6px; */
    }

    .gst-box strong {
      display: block;
      margin-bottom: 8px;
    }

    .grand-total {
      margin-top: 12px;
      text-align: right;
      font-weight: bold;
      font-size: 16px;
      border-top: 2px solid #000;
      padding-top: 8px;
    }

    .print-btn {

      padding: 12px 28px;
      background-color: #ca2639;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      transition: background 0.3s ease;
      z-index: 1000;
      margin: auto;
      margin-top: 2%;
      margin-bottom: 1%;
    }

    .print-btn:hover {
      background-color: #a71f2e;
    }

    @media print {
      .print-btn {
        display: none;
      }
    }

    th {
      background-color: #fff;
    }
    tfoot td {
    font-weight: bold;
    padding: 6px 8px;
    border:none !important;
}
tfoot td.text-end {
    text-align: right;
}
.editable-amount[contenteditable="true"],
.editable-freight[contenteditable="true"] {
    background-color: #fff7e6;
    border: 1px dashed #ff9900;
    cursor: text;
}
.editable-amount:focus,
.editable-freight:focus {
    outline: 2px solid #ff9900;
}



  </style>

</head>

<body>



  <div class="container">
    <div class="title">FREIGHT BILL – SINGLE LR OR MULTIPLE LR</div>

    <div class="section">
      <div class="box left-box">
        <strong>BILL TO / CONSIGNMENT SENT TO:</strong><br>
        [Party Name & Address Here]<br>
        <strong>Freight Type:</strong> {{ $order->order_method ?? '' }}
      </div>
      <div class="box right-box">
        <strong>Bill No.:</strong>{{ $freightBill->freight_bill_number ?? '-' }}<br>
        @if($order && $order->order_date)
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}
        @else
            <strong>Date:</strong> N/A
        @endif
       </div>
    </div>

    <!-- @foreach ($matchedEntries as $index => $entry)
        <div class="section">
        <div class="box half-box">
            <strong>From:</strong><br>
            {{ $entry['from_destination'] ?? '-' }}

        </div>

        <div class="box half-box">
            <strong>To:</strong><br>
        {{ $entry['to_destination'] ?? '-' }}
        </div>
        </div>
    @endforeach -->

  @php
  $allFroms = collect($matchedEntries)->pluck('from_destination')->filter()->toArray();
  $allTos = collect($matchedEntries)->pluck('to_destination')->filter()->toArray();
  @endphp

  <div class="section">
      <div class="box half-box">
          <strong>From:</strong><br>
          {{ implode(', ', $allFroms) }}
      </div>
      <div class="box half-box">
          <strong>To:</strong><br>
          {{ implode(', ', $allTos) }}
      </div>
  </div>


<table id="freightTable" class="table table-bordered">
    <thead>
      <tr>
          <th>S. No.</th>
          <th>LR No.</th>
          <th>LR Date</th>
          <th>Particulars</th>
          <th>Freight Type</th>
          <th>Weight / Quantity</th>
          <th>Rate</th>
          <th>Amount</th>
      </tr>
  </thead>
  <tbody>
  @foreach($matchedEntries as $index => $entry)
 
 
      <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $entry['lr_number'] }}</td>
          <td>{{ \Carbon\Carbon::parse($entry['lr_date'])->format('Y-m-d') }}</td>
          <td>{{ $entry['cargo'][0]['package_description'] ?? '-' }}</td>
          <td>{{ $entry['freight_type'] }}</td>

          {{-- Weight / Quantity --}}
          <td>
              @if($entry['freight_type'] == 'contract')
                  -
              @else
                  {{ $entry['cargo'][0]['charged_weight'] ?? '-' }}
                  {{ $entry['cargo'][0]['unit'] ?? '-' }}

              @endif
          </td>

          {{-- Rate --}}
          <td>
              @if($entry['freight_type'] == 'contract')
                  {{ $entry['vehicletype'] ?? '-' }}   (Vehicle Type)
              @else
                  {{ number_format($entry['order_rate'] ?? 0, 2) }}
              @endif
          </td>

          {{-- Amount --}}
          <td contenteditable="true"
              class="editable-freight"
              data-entry-id="{{ $entry['lr_number'] ?? $loop->index }}"
              data-field="freight_amount">
              {{ number_format($entry['freight_amount'] ?? 0, 2) }}
          </td>

      </tr>
  @endforeach
  </tbody>

    <tfoot>
        <tr>
            <td colspan="6"></td>
            <td class="text-end"><strong>Freight Subtotal</strong></td>
            <td id="freight-subtotal">₹ {{ number_format($totals['freight_amount'], 2) }}</td>
        </tr>
        @foreach (['lr_charges', 'hamali', 'other_charges', 'less_advance', 'balance_freight'] as $field)
            @if ($totals[$field] != 0)
            <tr class="editable-row" data-field="{{ $field }}">
                <td colspan="6"></td>
                <td class="text-end"><strong>{{ ucwords(str_replace('_', ' ', $field)) }}</strong></td>
                <td class="editable-amount" contenteditable="true"
                    data-field="{{ $field }}"
                    data-entry-id="{{ $freightBill->id }}">
                    ₹ {{ number_format($totals[$field], 2) }}
                </td>
            </tr>
            @endif
        @endforeach
        <tr>
            <td colspan="6"></td>
            <td class="text-end"><strong>Taxable Amount</strong></td>
            <td id="taxable-amount">₹ {{ number_format($totals['taxable_amount'], 2) }}</td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td class="text-end"><strong>GST (12%)</strong></td>
            <td id="gst-amount">₹ {{ number_format($totals['gst_amount'], 2) }}</td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td class="text-end"><strong>Total</strong></td>
            <td id="total-amount">₹ {{ number_format($totals['total_amount'], 2) }}</td>
        </tr>
    </tfoot>
  </table>


    <div class="total-in-words">
      Total in Words: ____________________________________________
    </div>

    <div class="footer-section">
      <div class="terms">
        <strong>Terms & Conditions:</strong><br>
        1. Payment due within 15 days.<br>
        2. Goods transported at owner's risk.<br>
        3. Subject to jurisdiction of Indore court.<br>
        4. No liability for delays due to unforeseen events.
      </div>

      <div class="gst-box">
        <strong>GST Breakdown:</strong>
        IGST @ 12%: ₹ _______<br>
        CGST @ 6%: ₹ _______<br>
        SGST @ 6%: ₹ _______

        <div class="grand-total">
          GRAND TOTAL: ₹ ____________
        </div>
      </div>
    </div>
  </div>
 
@php
    $id = request()->segment(4); 
@endphp
<div class="col-12" style="padding-bottom:20px; text-align: right;">
  <button type="submit" style="background-color:rgb(131, 29, 29); color: #fff; border: none; padding: 10px 20px; border-radius: 5px;"><a  style="text-decoration: none; color: white;"href="{{ route('admin.freight-bill.edit',['id' => $id]) }}">
    <i class="fas fa-save"></i>Save</a>
  </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Add this at bottom of your Blade file -->
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    function formatCurrency(amount) {
        const num = parseFloat(amount);
        if (isNaN(num)) return "₹ 0.00";
        return "₹ " + num.toFixed(2);
    }

    function updateEntry(id, entryId, field, value, cell) {
        const numValue = parseFloat(value);
        if (!isNaN(numValue)) {
            cell.innerText = formatCurrency(numValue); // ✅ Immediately show formatted value
        }

        fetch("/admin/freight-bill/update-entry/" + id, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ entry_id: entryId, field, value })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.updated_totals) {
                document.getElementById("freight-subtotal").innerText = formatCurrency(data.updated_totals.freight_amount);
                document.getElementById("taxable-amount").innerText = formatCurrency(data.updated_totals.taxable_amount);
                document.getElementById("gst-amount").innerText = formatCurrency(data.updated_totals.gst_amount);
                document.getElementById("total-amount").innerText = formatCurrency(data.updated_totals.total_amount);
            }
        });
    }

    function updateTotals(id, field, value, cell) {
        const numValue = parseFloat(value);
        if (!isNaN(numValue)) {
            cell.innerText = formatCurrency(numValue); // ✅ Immediately show formatted value
        }

        fetch("/admin/freight-bill/update/" + id, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ field, value })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.updated_totals) {
                document.getElementById("freight-subtotal").innerText = formatCurrency(data.updated_totals.freight_amount);
                document.getElementById("taxable-amount").innerText = formatCurrency(data.updated_totals.taxable_amount);
                document.getElementById("gst-amount").innerText = formatCurrency(data.updated_totals.gst_amount);
                document.getElementById("total-amount").innerText = formatCurrency(data.updated_totals.total_amount);
            }
        });
    }

    document.querySelectorAll('.editable-freight').forEach(cell => {
        cell.addEventListener('blur', function () {
            const id = "{{ $freightBill->id }}";
            const entryId = this.dataset.entryId;
            const field = this.dataset.field;
            const value = this.innerText.replace(/[^0-9.]/g, '');

            updateEntry(id, entryId, field, value, this); // Pass `this` as `cell`
        });
    });

    document.querySelectorAll('.editable-amount').forEach(cell => {
        cell.addEventListener('blur', function () {
            const id = "{{ $freightBill->id }}";
            const field = this.dataset.field;
            const value = this.innerText.replace(/[^0-9.]/g, '');

            updateTotals(id, field, value, this); // Pass `this` as `cell`
        });
    });
});
</script>






</body>

</html>