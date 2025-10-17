<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Khandelwal Roadlines LR</title>
      <style>
      * {
      box-sizing: border-box;
      }
         /* Original CSS */
   /* Ensure body has no margin or padding */
   body {
      margin: 0 !important;   /* No margin on the body */
      padding: 20 !important;  /* No padding on the body */
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      color: #17356e;
   }

/* Ensure the main container starts at the top with no padding or margin */
.container {
    max-width: 1000px;
    margin: 0 auto !important; /* Center the container */
    padding: 20 !important; /* Remove any padding */
    background-color: #fff;
    position: relative;
    width: 100%;
}

/* For print, enforce zero margins and padding */
/* For print, enforce zero margins and padding */
@media print {
    @page {
        size: 176mm 250mm;   /* Exact B5 size (Portrait) */
        margin: 0 !important;  /* Set margin to zero */
    }
    body {
        margin: 0 !important;  /* No margin for body */
        padding: 0 !important; /* No padding for body */
    }

    .container {
        margin: 0 !important;    /* Remove container margin */
        padding: 0 !important;   /* Remove container padding */
        width: 100%;
        height: 100%;  /* Ensure the container takes the full height */
    }
    /* Remove unnecessary space between sections */
    .header-section,
    .bill-section,
    .freight-section,
    .left-header,
    .right-header {
        margin: 0 !important;   /* Remove margin */
        padding: 0 !important;  /* Remove padding */
    }

    /* Ensure terms section is printed correctly */
    .terms {
        margin: 0 !important;
        padding: 5mm !important;  /* Print-safe padding */
        box-sizing: border-box;
        width: auto !important;
        max-width: 100% !important;
    }
    .print-btn {
        display: none !important; /* Hide print button during print */
    }
}

/* Add this to remove any extra margin or padding above the printed content */
@media print {
    .container {
        min-height: 100vh; /* Ensures the container takes the full height */
    }

    /* Override any top margin that might appear unexpectedly */
    * {
        margin-top: 0 !important; /* Ensure no top margin for any element */
    }
}
         .header-section {
         display: flex;
         justify-content: space-between;
         gap: 10px;
         }
         .bill-section {
         width: 74%;
         }
         .freight-section {
         width: 25%;
         }
         .left-header {
         display: flex;
         align-items: flex-start;
         justify-content: space-between;
         }
         .left-header img {
         height: auto;
         margin-right: 10px;
         }
         .left-header-content {
         flex: 1;
         }
         .left-header-content p,
         .left-header-content small {
         margin: 0;
         font-size: 14px;
         }
         .coly {
         /* border: 2px solid #002366; */
         padding: 5px;
         font-size: 14px;
         /* background-color: #eef2ff; */
         width: 220px;
         margin-left: 10px;
         }
         .coly strong {
         display: block;
         text-align: center;
         margin-bottom: 4px;
         font-size: 12px;
         color: #e90a0a;
         }
         .right-header {
         width: 100%;
         font-size: 14px;
         border: 2px solid #002366;
         padding: 5px;
         margin-top: 10px;
         height: 354px;
         }
         /* .right-header p {
         margin: 4px 0;
         } */
         h1 {
         color: red;
         font-size: 20px;
         margin: 5px 0;
         }
         .notice {
         border: 2px solid #002366;
         margin: 10px 0;
         padding: 6px;
         font-size: 14px;
         /* background-color: #eef2ff; */
         }
         .notice label {
         margin-right: 10px;
         }
         .consignor-consignee {
         display: flex;
         justify-content: space-between;
         border: 2px solid #002366;
         padding: 10px;
         font-size: 14px;
         margin-bottom: 10px;
         gap: 10px;
         }
         .consignor-consignee .box {
         width: 49%;
         border: 1px solid #002366;
         padding: 10px;
         box-sizing: border-box;
         min-height: 150px;
         }
         .consignor-consignee .box p {
         margin: 4px 0;
         }
         table {
         width: 100%;
         border-collapse: collapse;
         font-size: 14px;
         margin-bottom: 10px;
         }
         td,
         th {
         border: 2px solid #002366;
         padding: 4px;
         }
         .freight-box {
         width: 100%;
         border: 2px solid #002366;
         font-size: 14px;
         background: #f9f9f9;
         margin-top: 12px;
         }
         .freight-box h4 {
         margin: 0;
         padding: 5px;
         text-align: center;
         border-bottom: 2px solid #002366;
         background-color: snow;
         font-size: 16px;
         }
         .freight-box .section {
         display: flex;
         justify-content: space-between;
         padding: 4px;
         border-bottom: 2px solid #002366;
         }
         .e-way {
         font-size: 14px;
         margin-top: 20px;
         padding-top: 10px;
         border-top: 2px solid #002366;
         }
      .signature {
    text-align: LEFT;
    font-size: 10px;
    margin-top: 8px;
    font-weight: bold;
}
         .terms {
         margin-top: 40px;
         font-size: 16px;
         padding: 35px 70px;
         /* border: 2px solid #002366; */
         width: 1000px;
         margin: auto;
         background: #fff;
         margin-top: 13px;
         }
         .terms h3 {
         text-align: center;
         margin-bottom: 10px;
         font-size: 24px;
         padding-bottom: 18px;
         }
         .terms ol {
         padding-left: 20px;
         line-height: 1.6;
         }
         .terms li {
         padding-bottom: 10px;
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
         text-align: center;
         display: block;
         }
         .print-btn:hover {
         background-color: #a71f2e;
         }
         .tr1 {
         border-bottom: 2px solid #002366;
         width: 67%;
         text-align: center;
         margin: auto;
         margin-top: 4%;
         padding-bottom: 5px;
         }
         .tr2 {
         font-weight: 600 !important;
         font-size: 16px !important;
         color: inherit !important;
         }
         .pan {
         border: 2px solid #002366;
         text-align: center;
         padding: 5px;
         }
         .consignor-consignee-table {
         width: 100%;
         border-collapse: collapse;
         font-size: 14px;
         margin-bottom: 0px;
         }
         .consignor-consignee-table td {
         border: 2px solid #002366;
         padding: 0;
         vertical-align: top;
         width: 50%;
         }
         .section-wrapper {
         padding: 10px;
         }
         .section-heading {
         /* background-color: #e6f0ff; */
         color: #002366;
         font-weight: bold;
         padding: 8px 10px;
         border-bottom: 2px solid #002366;
         }
         .address-line {
         padding: 4px 10px;
         }
         .date{
         font-size: 16px;
         /* border-bottom: 2px solid; */
         /* padding-bottom: 11px !important; */
         margin-bottom: 13px !important;
         }
         @media print {
         .print-btn {
         display: none;
         }
         }
         @media print {
         @page {
            size: 176mm 250mm;   /* ✅ Exact B5 size (Portrait) */
            margin: 0mm;        /* Adjust as needed */
         }
         .terms {
            width: auto !important;           /* ✅ auto fit to page */
            max-width: 100% !important;
            padding: 5mm !important;         /* use print-safe padding */
            box-sizing: border-box;
            margin: 0 auto !important;
      }

         /* Hide print button during print */
         .print-btn {
            display: none !important;
         }
         }
      </style>
   </head>
   <body>
      <!-- @php
         $lrDetails = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
         @endphp -->
      <div class="container">
         <div class="header-section">
            <div class="bill-section">
               <div class="left-header">
                  <div class="left-header-content">
                     <img src="{{ asset('uploads/' . $settings->logo) }}" alt="logo" style="width: 100%;">
                     <p>Head Office: {{ $settings->head_office }}</p>
                     <small>MOBILE – {{ $settings->mobile }}</small><br>
                     <small>Offices - {{ $settings->offices }}</small><br>
                     <small>Email: {{ $settings->email }}</small><br>
                     <small>Website: {{ $settings->website }}</small><br>
                  </div>
                  <div class="coly">
                     <strong class="tr1">CONSIGNEE COPY</strong>
                     <strong class="tr2">AT OWNER’S RISK</strong>
                     <div class="pan">
                        <div class="gst"> GSTIN / Transporter Id
                           for EWAY Bill 23AABFM6400F1ZX
                        </div>
                        <div class="pan2"><strong>PAN:</strong> AABFM6400F</div>
                     </div>
                  </div>
               </div>
               <div class="notice" style="display: flex; align-items: center; gap: 20px; font-size: 14px;">
                  <div style="flex: 1; display: flex; align-items: center;">
                     <span style="font-weight: bold; margin-right: 5px;">GST to be charged from</span>
                     <div style="flex: 1; border-bottom: 1px solid #000;"></div>
                  </div>
                  <div style="flex: 1; display: flex; align-items: center;">
                     <span style="font-weight: bold; margin-right: 5px;">GSTIN</span>
                     <div style="flex: 1; border-bottom: 1px solid #000;"></div>
                  </div>
               </div>
               <div>
                  @php
                  if (!function_exists('cleanAddress')) {
                  function cleanAddress($address) {
                  $clean = preg_replace('/(Address:\s*)+/i', '', $address);
                  $clean = preg_replace('/,+/', ',', $clean);
                  return trim($clean, ', ');
                  }
                  }
                  $lr = $lrEntries; // a single LR entry
                  $consignorUser = \App\Models\User::find($lr['consignor_id'] ?? null);
                  $consigneeUser = \App\Models\User::find($lr['consignee_id'] ?? null);
                  @endphp
                  <table class="consignor-consignee-table">
                     <tr>
                        {{-- CONSIGNOR --}}
                        <td>
                           <div class="section-heading">CONSIGNOR'S NAME & ADDRESS</div>
                           <div class="address-line">• {{ $consignorUser->name ?? '-' }}</div>
                           <div class="address-line">
                              {{ isset($lr['consignor_loading']) ? cleanAddress($lr['consignor_loading']) : '-' }}
                           </div>
                           <div class="address-line">GSTIN - {{ $lr['consignor_gst'] ?? '-' }}</div>
                        </td>
                        {{-- CONSIGNEE --}}
                        <td>
                           <div class="section-heading">CONSIGNEE'S NAME & ADDRESS</div>
                           <div class="address-line">• {{ $consigneeUser->name ?? '-' }}</div>
                           <div class="address-line">
                              {{ isset($lr['consignee_unloading']) ? cleanAddress($lr['consignee_unloading']) : '-' }}
                           </div>
                           <div class="address-line">GSTIN - {{ $lr['consignee_gst'] ?? '-' }}</div>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
            <div class="freight-section">
               <div class="right-header">
                  @php
                  // Use single LR entry directly
                  $lr = $lrEntries;
                  // Find vehicle details
                  // $vehicle = collect($vehicles)->firstWhere('id', $lr['vehicle_no'] ?? null);
                  @endphp
                  <p><strong>L.R. No:</strong> {{ $lr['lr_number'] ?? '-' }}</p>
                  <p class="date" style="font-size: 16px;">
                     <strong>Dated:</strong> {{ $lr['lr_date'] ?? '-' }}
                  </p>
                  @php
                  $selectedVehicles = array_filter($lr['vehicle'] ?? [], function ($v) {
                  return isset($v['is_selected']) && $v['is_selected'];
                  });
                  @endphp
                  @forelse($selectedVehicles as $v)
                  <p><strong>Vehicles No:</strong> {{ $v['vehicle_no'] ?? '-' }}</p>
                  @empty
                  <p>N/A</p>
                  @endforelse
                  @php
                  // Find the vehicle by its ID (not vehicle_type)
                  $vehicle = \App\Models\VehicleType::find($lr['vehicle_type']);
                  @endphp
                  <p><strong>Vehicle Type:</strong> {{ $vehicle->vehicletype ?? '-' }}</p>
                  {{-- 
                  <p><strong>Delivery Mode:</strong> {{ $lr['delivery_mode'] ?? 'N/A' }}</p>
                  --}}
                  <p><strong>Delivery Mode:</strong>
                     @if(isset($lr['delivery_mode']))
                     @if($lr['delivery_mode'] == 'door_delivery')
                     Door Delivery
                     @elseif($lr['delivery_mode'] == 'godwon_delivery')
                     Godwon Delivery
                     @else
                     {{ ucfirst(str_replace('_', ' ', $lr['delivery_mode'])) }}
                     @endif
                     @else
                     N/A
                     @endif
                  </p>
                  @php
                  $fromDestination = \App\Models\Destination::find($lr['from_location']);
                  $toDestination = \App\Models\Destination::find($lr['to_location']);
                  @endphp
                  <p><strong>From:</strong> {{ $fromDestination->destination ?? '-' }}</p>
                  <p><strong>To:</strong> {{ $toDestination->destination ?? '-' }}</p>

                  
               </div>
               <div class="freight-box" style="display:none;">
                  <h4>FREIGHT</h4>
                  @php
                  $lr = $lrEntries; // Already a single LR entry
                  @endphp
                  <div class="section">
                     <label><input type="checkbox" {{ ($lr['freightType'] ?? '') == 'paid' ? 'checked' : '' }}> PAID</label>
                     <label><input type="checkbox" {{ ($lr['freightType'] ?? '') == 'to_pay' ? 'checked' : '' }}> TO PAY</label>
                     <label><input type="checkbox" {{ ($lr['freightType'] ?? '') == 'to_be_billed' ? 'checked' : '' }}> TO BE BILLED</label>
                  </div>
                  <div class="section"><span>FREIGHT</span> <span>{{ $lr['freight_amount'] ?? '-' }}</span></div>
                  <div class="section"><span>LR CHARGES</span> <span>{{ $lr['lr_charges'] ?? '-' }}</span></div>
                  <div class="section"><span>HAMALI</span> <span>{{ $lr['hamali'] ?? '-' }}</span></div>
                  <div class="section"><span>OTHER CHARGES</span> <span>{{ $lr['other_charges'] ?? '-' }}</span></div>
                  <div class="section"><span>GST</span> <span>{{ $lr['gst_amount'] ?? '-' }}</span></div>
                  <div class="section"><span>TOTAL FREIGHT</span> <span>{{ $lr['total_freight'] ?? '-' }}</span></div>
                  <div class="section"><span>LESS ADVANCE</span> <span>{{ $lr['less_advance'] ?? '-' }}</span></div>
                  <div class="section"><span>BALANCE FREIGHT</span> <span>{{ $lr['balance_freight'] ?? '-' }}</span></div>
               </div>
            </div>
         </div>
         <div class="container" style="padding:10px 0;">
            @php
            $total_actual_weight = 0;
            $total_charged_weight = 0;
            foreach($lrEntries['cargo'] as $cargo) {
            $isValid = !empty($cargo['packages_no']) || !empty($cargo['package_type']) || !empty($cargo['package_description']) || !empty($cargo['actual_weight']) || !empty($cargo['charged_weight']);
            if ($isValid) {
            $total_actual_weight += $cargo['actual_weight'] ?? 0;
            $total_charged_weight += $cargo['charged_weight'] ?? 0;
            }
            }
            @endphp
            <table border="1" style="border-collapse: collapse; width: 100%; text-align: center;">
               <thead>
                  <tr>
                     <th>No. of Packages</th>
                     <th>Method of Packing</th>
                     <th>Description Said to contain</th>
                     <th>Weight</th>
                  </tr>
               </thead>
               <tbody>
                  @php
                  $totalActualWeight = $totalChargedWeight = 0;
                  $validCargos = collect($lrEntries['cargo'])->filter(function($cargo) {
                  return !empty($cargo['packages_no']) || !empty($cargo['package_type']) || !empty($cargo['package_description']);
                  })->values();
                  $rowCount = $validCargos->count();
                  @endphp
                  @foreach($validCargos as $index => $cargo)
                  @php
                  $totalActualWeight += $cargo['actual_weight'] ?? 0;
                  $totalChargedWeight += $cargo['charged_weight'] ?? 0;
                  @endphp
                  <tr>
                     <td>{{ $cargo['packages_no'] ?? '' }}</td>
                     <td>{{ $packageTypes[$cargo['package_type']] ?? '' }}</td>
                     <td style="text-align: left;">
                        {{ $cargo['package_description'] ?? '' }}
                        </br>
                        {{ isset($cargo['document_name']) ? \Illuminate\Support\Str::limit($cargo['document_name']) : '' }},
                        - {{ $cargo['document_no'] ?? '' }}, <strong>Dt:</strong> {{ isset($cargo['document_date']) ? \Illuminate\Support\Carbon::parse($cargo['document_date'])->format('d/m/Y') : '' }}
                        </br>
                        <!-- <strong>Eway Bill No:</strong> {{ $cargo['eway_bill'] ?? '' }} -->
                     </td>
                     {{-- Display merged weight cell only for the first row --}}
                     @if($index === 0)
                     <td rowspan="{{ $rowCount }}" style="vertical-align: top; text-align: left; padding: 8px;">
                        <div style="padding-top: 5px;">
                           <strong>Actual<br> Weight:</strong> {{ $totalActualWeight }}
                        </div>
                        <hr style="width: 100%; height: 3px; background-color: #003366; border: none; margin: 10px 0;">
                        <div style="padding-top: 5px;">
                           <strong>Charged Weight:</strong> {{ $totalChargedWeight }}
                        </div>
                        <!-- Freight Section Start -->
                        <hr style="width: 100%; height: 3px; background-color: #003366; border: none; margin: 10px 10px 10px 0;">
                        <div style="border: 2px solid #003366; padding: 5px; text-align: center; margin-top: 8px;">
                           <div style="font-weight: bold; color: #003366; font-size: 14px; border-bottom: 2px solid #003366; padding-bottom: 3px; margin-bottom: 5px;">
                              FREIGHT
                           </div>
                           <div style="display: flex; justify-content: space-between; gap: 5px;">
                              <div style="flex: 1; text-align: center;">
                                 <div style="border: 2px solid #003366; width: 26px; height: 26px; margin: 0 auto; margin-bottom: 3px;"></div>
                                 <span style="font-size: 12px; font-weight: bold;">PAID</span>
                              </div>
                              <div style="flex: 1; text-align: center;">
                                 <div style="border: 2px solid #003366; width: 26px; height: 26px; margin: 0 auto; margin-bottom: 3px;"></div>
                                 <span style="font-size: 12px; font-weight: bold;">TO PAY</span>
                              </div>
                              <div style="flex: 1; text-align: center;">
                                 <div style="border: 2px solid #003366; width: 26px; height: 26px; margin: 0 auto; margin-bottom: 3px;"></div>
                                 <span style="font-size: 12px; font-weight: bold;">TO BE<br>BILLED</span>
                              </div>
                           </div>
                        </div>
                        <div class="signature">
            For: KHANDELWAL ROADLINES
         </div>
                        <!-- Freight Section End -->
                         
                     </td>
                     @endif
                  </tr>
                  @endforeach
               </tbody>
            </table>
            @php
            if (!function_exists('toArray')) {
            function toArray($value) {
            return is_array($value) ? $value : json_decode($value, true);
            }
            }
            $ewayBills = toArray($order->eway_bill ?? []);
            $validUpto = toArray($order->valid_upto ?? []);
            $declaredValue = $order->declared_value ?? '__________';
            @endphp
            <!-- E-Way Bill Section -->
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; border: 1px solid #003366;">
               <tr>
                  <td style="border: 2px solid #003366; padding: 5px; width: 80%;">
                     <strong>E-WAY BILL NO.</strong><br>
                     @if(!empty($lrEntries['eway_bills']) && is_array($lrEntries['eway_bills']))
                        @foreach($lrEntries['eway_bills'] as $eway)
                           {{ $eway }}@if(!$loop->last), @endif
                        @endforeach
                     @else
                        <em>_______________________</em>
                     @endif
                  </td>
                  <td style="border: px solid #003366; padding: 5px; width: 20%; vertical-align: top;">
                     <strong>VALID UPTO</strong><br>
                     @if(!empty($validUpto) && is_array($validUpto))
                        @foreach($validUpto as $date)
                           {{ $date }}<br>
                        @endforeach
                     @else
                        <em>__________</em>
                     @endif
                  </td>
               </tr>
            </table>
            <div style="display: flex; align-items: center; margin-top: 8px;">
               <span style="font-weight: bold; margin-right: 5px;">Declared Value Rs.</span>
               <span style="display: inline-block; border-bottom: 2px solid #000; padding: 0 5px;">
                  {{ $lr['total_declared_value'] ?? '__________' }}
               
               </span>
            </div>

         </div>
         
      </div>
      <div class="terms">
         <h3>TERMS & CONDITIONS</h3>
         <ol>
            <li>The company does not take responsibility for leakage, breakage, shortage or damage by rain, sun or
               weather and sender is responsible for proper packing.
            </li>
            <li>Fresh fruits are to be arrived at the risk of the consignor or consignee as they are apparently to
               be spoiled on the way.
            </li>
            <li>The company will send goods at earliest. Goods may be sent in one lot or parts, according to
               convenience.
            </li>
            <li>The goods will be delivered to the consignee or his agent against payment of all charges.</li>
            <li>The goods will be delivered at destination – company’s godown, only unless settled otherwise in
               writing.
            </li>
            <li>The delivery of the goods will have to be taken within seven days after its arrival at destination.
               Failing to the same will be liable to demurrage of Rs. 100/- per ton per day or Rs. 100/- per
               package per day and will be stored at owner’s risk.
            </li>
            <li>If there is any claim on a/c of this goods receipt, the same shall have to be informed within
               fifteen days, failing to same will be considered as no claim.
            </li>
            <li>The company takes absolutely no responsibility for delays or losses due to accident, strikes, fire
               or any other causes beyond our control and due to breakdown of vehicle en route and for the
               consequences thereof.
            </li>
            <li>Once the delivery is given against a receipt, no claim will be entertained after that.</li>
            <li>If any govt. authority assesses the goods wrongly, company will not be responsible for such faults
               and claim if any shall be made on such items from govt. authority themselves, is to be paid by
               consignee or consignor as the case may be.
            </li>
         </ol>
      </div>
      <!-- Print Button -->
      <button class="print-btn" id="openModalBtn">🖨️ Download / Print LR</button>
      <!-- Copy Selection Modal -->
<div id="copyModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:2000; justify-content:center; align-items:center;">
  <div style="background:#fff; padding:20px; border-radius:8px; width:400px; text-align:center; position:relative;">
    <h3>Select Copies to Download</h3>
    <div style="text-align:left; margin:20px 0;">
      <label><input type="checkbox" id="copyConsignor" checked> Consignor Copy</label><br>
      <label><input type="checkbox" id="copyConsignee" checked> Consignee Copy</label><br>
      <label><input type="checkbox" id="copyDriver" checked> Driver Copy</label><br>
      <label><input type="checkbox" id="copyHO" checked> HO Copy</label>
    </div>
    <button id="modalDownloadBtn" style="padding:10px 20px; background:#ca2639; color:white; border:none; border-radius:5px; cursor:pointer;">Download PDF</button>
    <button id="modalCloseBtn" style="padding:10px 20px; margin-left:10px; background:#999; color:white; border:none; border-radius:5px; cursor:pointer;">Cancel</button>
  </div>
</div>
<!-- <script>
const modal = document.getElementById('copyModal');
const openModalBtn = document.getElementById('openModalBtn');
const closeModalBtn = document.getElementById('modalCloseBtn');
const downloadBtn = document.getElementById('modalDownloadBtn');

openModalBtn.addEventListener('click', () => modal.style.display = 'flex');
closeModalBtn.addEventListener('click', () => modal.style.display = 'none');

downloadBtn.addEventListener('click', async () => {
    modal.style.display = 'none';

    const copies = [
        { id: 'copyConsignor', name: 'CONSIGNOR COPY' },
        { id: 'copyConsignee', name: 'CONSIGNEE COPY' },
        { id: 'copyDriver', name: 'DRIVER COPY' },
        { id: 'copyHO', name: 'HO COPY' }
    ];

    const selectedCopies = copies.filter(c => document.getElementById(c.id)?.checked);
    if (selectedCopies.length === 0) {
        alert("⚠️ Please select at least one copy to download.");
        return;
    }

    const originalContainer = document.querySelector('.container');
    const originalTerms = document.querySelector('.terms');

    if (!originalContainer) {
        alert("Main container (.container) not found!");
        return;
    }

    // Create a wrapper for the content
    const wrapper = document.createElement('div');
    wrapper.style.width = '176mm';      // B5 width
    wrapper.style.margin = '0';         // Remove all wrapper margin
    wrapper.style.padding = '0';        // Remove all wrapper padding
    wrapper.style.boxSizing = 'border-box';

    // Loop through each selected copy and generate pages
    selectedCopies.forEach((copy, index) => {
        // Create the page container
        const pageDiv = document.createElement('div');
        pageDiv.style.pageBreakAfter = index < selectedCopies.length - 1 ? 'always' : 'auto';
        pageDiv.style.width = '176mm';
        pageDiv.style.minHeight = '250mm'; // B5 height
        pageDiv.style.margin = '0';         // Zero margin for the page container
        pageDiv.style.padding = '0';        // Zero padding for the page container
        pageDiv.style.boxSizing = 'border-box';
        pageDiv.style.backgroundColor = '#fff';

        // Clone the container for each copy (Consignor, Consignee, etc.)
        const copyDiv = originalContainer.cloneNode(true);
        
        // Remove print button and modal elements from the clone
        copyDiv.querySelectorAll('.print-btn, #copyModal').forEach(el => el.remove());

        // Apply custom styling for the clone
        copyDiv.style.margin = '0';
        copyDiv.style.padding = '0'; // Top padding set to 0, other sides 10px
        copyDiv.style.maxWidth = '100%';  // Ensure it fits in the B5 page

        // Update copy label for each selected copy
        const labelEl = copyDiv.querySelector('.coly .tr1');
        if (labelEl) labelEl.textContent = copy.name;

        pageDiv.appendChild(copyDiv);
        wrapper.appendChild(pageDiv); // Append this copy page to the wrapper
    });

    // After all copies are printed, add Terms & Conditions
    if (originalTerms) {
        const termsPageDiv = document.createElement('div');
        termsPageDiv.style.pageBreakBefore = 'always'; // Forces Terms & Conditions to the last page
        termsPageDiv.style.width = '176mm'; 
        termsPageDiv.style.minHeight = '250mm';
        termsPageDiv.style.margin = '0';
        termsPageDiv.style.padding = '5mm'; // Padding for readability on the terms page
        termsPageDiv.style.boxSizing = 'border-box';
        termsPageDiv.style.backgroundColor = '#fff';

        // Clone the Terms & Conditions content
        const clonedTerms = originalTerms.cloneNode(true);
        clonedTerms.style.width = '100%';
        clonedTerms.style.margin = '0';
        clonedTerms.style.padding = '0'; 
        clonedTerms.style.marginTop = '0'; 
        clonedTerms.style.textAlign = 'center';

        termsPageDiv.appendChild(clonedTerms);
        wrapper.appendChild(termsPageDiv); // Append Terms & Conditions page to the wrapper
    }

    // Configure the pdf generation settings
    const opt = {
    margin: 0, // Ensure no margin around the PDF
    filename: 'LR-Copies.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    jsPDF: {
        unit: 'mm',
        format: 'a4',  // Let the format be 'a4', or use the auto setting below for dynamic size
        orientation: 'portrait',
        auto: true  // Dynamically set the height/width of the page based on content
    }
};

    // Check if html2pdf is loaded and generate the PDF
    if (typeof html2pdf === 'undefined') {
        const script = document.createElement('script');
        script.src = "https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js";
        script.onload = () => html2pdf().from(wrapper).set(opt).save();
        document.body.appendChild(script);
    } else {
        html2pdf().from(wrapper).set(opt).save();
    }
});
</script> -->



<script>
const modal = document.getElementById('copyModal');
const openModalBtn = document.getElementById('openModalBtn');
const closeModalBtn = document.getElementById('modalCloseBtn');
const downloadBtn = document.getElementById('modalDownloadBtn');

openModalBtn.addEventListener('click', () => modal.style.display = 'flex');
closeModalBtn.addEventListener('click', () => modal.style.display = 'none');

downloadBtn.addEventListener('click', async () => {
    modal.style.display = 'none';

    const copies = [
        { id: 'copyConsignor', name: 'CONSIGNOR COPY' },
        { id: 'copyConsignee', name: 'CONSIGNEE COPY' },
        { id: 'copyDriver', name: 'DRIVER COPY' },
        { id: 'copyHO', name: 'HO COPY' }
    ];

    const selectedCopies = copies.filter(c => document.getElementById(c.id)?.checked);
    if (selectedCopies.length === 0) {
        alert("⚠️ Please select at least one copy to download.");
        return;
    }

    const originalContainer = document.querySelector('.container');
    const originalTerms = document.querySelector('.terms');

    if (!originalContainer) {
        alert("Main container (.container) not found!");
        return;
    }

    // Create a wrapper for the content
    const wrapper = document.createElement('div');
    wrapper.style.width = '210mm';
    wrapper.style.margin = '0';
    wrapper.style.padding = '0';
    wrapper.style.boxSizing = 'border-box';

    // First add all selected copies
    selectedCopies.forEach((copy, index) => {
        const pageDiv = document.createElement('div');
        pageDiv.className = 'pdf-page';
        pageDiv.style.pageBreakAfter = index < selectedCopies.length - 1 ? 'always' : 'auto';
        pageDiv.style.width = '210mm';
        pageDiv.style.minHeight = '297mm';
        pageDiv.style.margin = '0';
        pageDiv.style.padding = '15mm';
        pageDiv.style.boxSizing = 'border-box';
        pageDiv.style.backgroundColor = '#fff';
        pageDiv.style.position = 'relative';

        // Clone the original container
        const copyDiv = originalContainer.cloneNode(true);
        
        // Remove unnecessary elements
        copyDiv.querySelectorAll('.print-btn, #copyModal, .no-print').forEach(el => el.remove());

        // Apply proper styling
        copyDiv.style.margin = '0';
        copyDiv.style.padding = '0';
        copyDiv.style.width = '100%';
        copyDiv.style.maxWidth = '180mm';
        copyDiv.style.overflow = 'visible';

        // Update copy label
        const labelEl = copyDiv.querySelector('.coly .tr1');
        if (labelEl) labelEl.textContent = copy.name;

        // Ensure all content is properly styled
        const tables = copyDiv.querySelectorAll('table');
        tables.forEach(table => {
            table.style.width = '100%';
            table.style.maxWidth = '100%';
            table.style.tableLayout = 'auto';
        });

        const cells = copyDiv.querySelectorAll('td, th');
        cells.forEach(cell => {
            cell.style.padding = '4px';
            cell.style.wordWrap = 'break-word';
        });

        pageDiv.appendChild(copyDiv);
        wrapper.appendChild(pageDiv);
    });

    // Add Terms & Conditions as last page
    if (originalTerms) {
        const termsPageDiv = document.createElement('div');
        termsPageDiv.className = 'pdf-page terms-page';
        termsPageDiv.style.pageBreakBefore = 'always';
        termsPageDiv.style.width = '210mm';
        termsPageDiv.style.minHeight = '297mm';
        termsPageDiv.style.margin = '0';
        termsPageDiv.style.padding = '20mm';
        termsPageDiv.style.boxSizing = 'border-box';
        termsPageDiv.style.backgroundColor = '#fff';

        const clonedTerms = originalTerms.cloneNode(true);
        clonedTerms.style.width = '100%';
        clonedTerms.style.margin = '0';
        clonedTerms.style.padding = '0';
        clonedTerms.style.fontSize = '12px';
        clonedTerms.style.lineHeight = '1.4';

        termsPageDiv.appendChild(clonedTerms);
        wrapper.appendChild(termsPageDiv);
    }

    // Simple PDF configuration
    const opt = {
        margin: 10,
        filename: 'LR-Copies.pdf',
        image: { 
            type: 'jpeg', 
            quality: 0.98 
        },
        html2canvas: {
            scale: 2,
            useCORS: true,
            scrollX: 0,
            scrollY: 0
        },
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        }
    };

    // Generate PDF
    if (typeof html2pdf === 'undefined') {
        const script = document.createElement('script');
        script.src = "https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js";
        script.onload = () => {
            html2pdf().set(opt).from(wrapper).save();
        };
        document.body.appendChild(script);
    } else {
        html2pdf().set(opt).from(wrapper).save();
    }
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</body>
</html>