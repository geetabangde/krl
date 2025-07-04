<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tax Invoice - KHANDELWAL ROADLINES</title>


    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            background: #fff;
            color: #000;
        }

        .invoice-box {
            max-width: 1000px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 14px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #003F72;
        }

        .company {
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
            color: #c72336;
        }

        .flex-row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        table th {
            background-color: #f0f0f0;
        }

        .no-border td {
            border: none;
            padding: 4px 0;
        }

        .total-section td {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .note {
            font-style: italic;
            margin-top: 20px;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
        }

        .bank-details {
            margin-top: 20px;
        }

        .company img {
            width: 60%;
            float: inline-end;
            margin-top: -29px;
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

        .te p {
            margin: 9px 0;
        }

        /* Hide Print Button on Print */
        /* Print Specific Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12px;
                /* Reduce font size for better fit */
            }

            .invoice-box {
                max-width: 100%;
                margin: 0;
                padding: 15px;
                border: none;
                box-shadow: none;
                font-size: 12px;
            }

            .title {
                font-size: 16px;
                /* Slightly smaller title */
            }

            .company {
                font-size: 14px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th,
            table td {
                padding: 6px;
                /* Reduce padding to fit more content */
                font-size: 12px;
            }

            /* Prevent page breaks within the table */
            table,
            tr,
            td {
                page-break-inside: avoid;
            }

            .no-border td {
                border: none;
                padding: 4px 0;
            }

            /* Ensure content doesn't overflow outside page */
            .print-btn {
                display: none;
                /* Hide print button on printed page */
            }

            .note,
            .signature,
            .bank-details {
                font-size: 12px;
                /* Smaller text to avoid overflow */
            }

            .flex-row {
                display: block;
                /* Stack the elements for print */
                margin-top: 5px;
            }

            .flex-row .te {
                margin-bottom: 10px;
            }

            /* Make sure page doesn't overflow */
            .invoice-box {
                page-break-before: always;
                page-break-after: always;
            }
        }

        .flex-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .flex-row .te {
            width: 48%;
            font-size: 14px;
            line-height: 1.4;
        }

        /* Right align for te2 */
        .flex-row .te2 {
            text-align: right;
        }

        /* Ensure te2 content stays aligned during print */
        @media print {
            .flex-row {
                display: flex;
                justify-content: space-between;
            }

            .flex-row .te,
            .flex-row .te2 {
                width: 48%;
                font-size: 12px;
            }

            .flex-row .te2 {
                text-align: right;
            }

            .print-btn {
                display: none;
                /* Hide print button when printing */
            }
        }
        
        @media (max-width: 768px) {
    body {
        margin: 10px;
        padding: 10px;
        font-size: 12px;
    }

    .invoice-box {
        padding: 15px;
        font-size: 12px;
        box-shadow: none;
    }

    .title {
        font-size: 16px;
    }

    .company img {
        width: 100px;
        float: none;
        display: block;
        margin: 10px auto 0;
    }

    .flex-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .flex-row .te,
    .flex-row .te2 {
        width: 100%;
        text-align: left;
        font-size: 13px;
    }

    table {
        font-size: 12px;
        word-break: break-word;
    }

    table th,
    table td {
        padding: 6px;
    }

    .note,
    .bank-details,
    .signature {
        font-size: 12px;
    }

    .print-btn {
        font-size: 14px;
        padding: 10px 20px;
    }

    .signature {
        text-align: left;
    }

    .bank-details p {
        margin: 6px 0;
    }

    .note {
        margin-top: 15px;
    }

}

    </style>
</head>

<body>
    <div class="invoice-box">

        <div class="flex-row">
            <div>
                <div class="title">TAX INVOICE</div>
                <div>ORIGINAL FOR RECIPIENT</div>
            </div>
            <div class="company">
                <img src="assets/img/logo.jpg" alt="">
            </div>
        </div>

        <div class="flex-row">
            <div class="te">
                <p><strong>GSTIN:</strong> {{ $settings->transporter ?? 'N/A' }}</p>
                <p><strong>Head Office:</strong> {{ $settings->head_office ?? 'N/A' }}
                </p>
                <p><strong>Mobile:</strong>{{ $settings->mobile ?? 'N/A' }}</p>
                <p><strong>Offices :</strong>{{ $settings->offices ?? 'N/A' }}</p>
                <p><strong>Email:</strong>{{ $settings->email ?? 'N/A' }}</p>
            </div>
            <div class="te te2">
                <p><strong>Invoice No:</strong> {{ $freightBill->invoice->invoice_number ?? 'N/A' }}</p>
                <p><strong>Invoice Date:</strong> {{ $freightBill->invoice->invoice_date ?? 'N/A' }}</p>
            </div>
         </div>

        <table class="no-border">
            <tr>
                <td><strong>Customer Details:</strong> {{ $customerDetails['customer_name'] ?? '-' }}</td>
            </tr>
            <tr>
                <td> @foreach ($customerDetails['customer_address'] as $address)
                    <strong>GSTIN:</strong> {{ $address['gstin'] }}
                    <strong>Billing Address:</strong> {{ $address['billing_address'] }}
                
                @endforeach
                </td>
                <td><strong>Place of Supply:</strong> {{ $deliveryAddress ?? '-' }}</td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Description</th>
                    <th>Rate / Item</th>
                    <th>Qty</th>
                    <th>Taxable Value</th>
                    <th>Tax Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>TRANSPORTATION CHARGES <br><small>SAC: 996791</small></td>
                    <td>{{ number_format($totals['taxable_amount'], 2) }}</td>
                    <td>1</td>
                    <td>{{ number_format($totals['taxable_amount'], 2) }}</td>
                    <td>{{ number_format($totals['gst_amount'], 2) }} (12%)</td>
                    <td>{{ number_format($totals['total_amount'], 2) }}</td>
                </tr>
                
                <tr class="total-section">
                    <td colspan="4"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        @php
            $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
            $amountInWords = ucfirst($formatter->format($totals['total_amount'])) . ' Rupees Only';
        @endphp


   

        <p class="note"><strong>Amount in Words:</strong>{{ $amountInWords }}</p>

        <div class="bank-details">
            <p><strong>Bank Name:</strong> HDFC BANK</p>
            <p><strong>Account No:</strong> 50200012345678</p>
            <p><strong>IFSC Code:</strong> HDFC0001234</p>
            <p><strong>Branch:</strong> Indore Main Branch</p>
        </div>
        <div class="bank-details"><strong>Notes:</strong>

   


    <!-- LR Numbers comma separated -->
    <p><strong>LR Numbers:</strong>
    {{ implode(', ', array_column($matchedEntries, 'lr_number')) }}</p>

    

    <p><strong>Eway Bills:</strong>
    @php
        $allEwayBills = [];
        foreach ($matchedEntries as $lr) {
            if (!empty($lr['eway_bills']) && is_array($lr['eway_bills'])) {
                $allEwayBills = array_merge($allEwayBills, $lr['eway_bills']);
            }
        }
    @endphp

    @if(count($allEwayBills) > 0)
        {{ implode(', ', $allEwayBills) }}</p>
    @else
        <p>No Eway Bills found</p>
    @endif





            
        </div>

        <div class="signature">
            <p>For KHANDELWAL ROADLINES</p>
            <br><br>
            <p>Authorized Signatory</p>
        </div>

        <p class="note">Note: Please issue TDS certificate under 194C with PAN: ABCDE1234F</p>

    </div>

    <!-- Print Button -->
    <button class="print-btn" onclick="window.print()">🖨️ Print Invoice </button>
</body>

</html>