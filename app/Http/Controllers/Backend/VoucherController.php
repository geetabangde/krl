<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Group;
use App\Models\Setting;
use App\Models\LedgerMaster;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Event\ResponseEvent;


class VoucherController extends Controller
{   
    // Display a listing of the resource.
    public function index()
    {
        // Fetch vouchers with their related ledger information
        $vouchers = Voucher::with(['fromLedger', 'toLedger'])->latest()->get();
        
        // Decode the JSON 'vouchers' field into an array only if it's a string
        foreach ($vouchers as $voucher) {
            // Check if 'vouchers' is a string before decoding
            if (is_string($voucher->vouchers)) {
                $voucher->vouchers = json_decode($voucher->vouchers, true);
            }
        }
        // return($vouchers);

        return view('admin.voucher.index', compact('vouchers'));
    }
    // Show the form for creating a new resource.
    public function create()
    { 
        $ledgers = User::all(); 
        return view('admin.voucher.create', compact('ledgers')); 
    }
    public function show($id)
    {
        $voucher = Voucher::with(['fromLedger', 'toLedger'])->findOrFail($id);
        return view('admin.voucher.show', compact('voucher'));
    }
    
    public function destroy($id)
   {
    $voucher = Voucher::findOrFail($id);
    $voucher->delete();
    return redirect()->route('admin.voucher.index')->with('success', 'Voucher deleted successfully!');
   }

    public function edit($id)
{
    $voucher = Voucher::findOrFail($id); 
    $ledgers = User::all();

    $voucherRows = is_string($voucher->vouchers) 
        ? json_decode($voucher->vouchers, true) 
        : $voucher->vouchers;
    $voucherApiRows = is_string($voucher->VoucherApi) 
        ? json_decode($voucher->VoucherApi, true) 
        : $voucher->VoucherApi;
    
    // dd($voucherApiRows, $voucherRows);
    
    return view('admin.voucher.edit', compact('voucher', 'ledgers', 'voucherRows', 'voucherApiRows'));
}



    //  Store a newly created resource in storage.
    public function getLedgers(Request $request)
    {
        $voucherType = $request->voucher_type;

        try {
            $response = [
                'from' => [],
                'to' => [],
                'against_vouchers' => [],
            ];

            // Format user entries with multiple cities
            $formatUsersWithCities = function ($users) {
                $formatted = [];

                foreach ($users as $user) {
                    $addresses = $user->address;

                    if (is_string($addresses)) {
                        $addresses = json_decode($addresses, true); 
                    }

                    if (empty($addresses) || !is_array($addresses)) continue;
                    // if (!is_array($addresses)) continue;

                
                    foreach ($addresses as $index => $entry) {
                        $city = $entry['city'] ?? null;
                        if ($city) {
                            $formatted[] = [
                                'id' => $user->id,
                                'name' => "{$user->name} ({$city})",
                                'address_index' => $index,
                                'city' => $city
                            ];
                        }
                        }

                }
                
                return $formatted;
            };

            // Format voucher labels
            $formatVoucherLabel = function ($voucher) {
                $entries = $voucher->vouchers;
                $labels = [];

                if (!is_array($entries)) {
                    return [];
                }

                foreach ($entries as $v) {
                    $from = User::find($v['from_account'])?->name ?? 'From';
                    $to = User::find($v['to_account'])?->name ?? 'To';
                    $date = $voucher->voucher_date ?? 'N/A';
                    $amount = $v['amount'] ?? '0.00';

                    $labels[] = [
                        'value' => "{$voucher->voucher_type}_{$voucher->id}",
                        'label' => "{$voucher->voucher_type} - {$from} → {$to} ({$date}) → ₹{$amount}",
                    ];
                }

                return $labels;
            };


            if ($voucherType === 'Payment') {
                $fromGroupIds = Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
                $fromUsers = User::whereIn('group_id', $fromGroupIds)->select('id', 'name', 'address')->get();
                $toUsers = User::whereNotIn('group_id', $fromGroupIds)->select('id', 'name', 'address')->get();

                $response['from'] = $formatUsersWithCities($fromUsers);
                $response['to'] = $formatUsersWithCities($toUsers);

                $purchaseVouchers = Voucher::where('voucher_type', 'Purchase')->get();
                $expenseVouchers = Voucher::where('voucher_type', 'Expense')->get();

                $allVouchers = $purchaseVouchers->merge($expenseVouchers);
                foreach ($allVouchers as $voucher) {
                    $response['against_vouchers'] = array_merge(
                        $response['against_vouchers'],
                        $formatVoucherLabel($voucher)
                    );
                }

            } elseif ($voucherType === 'Receipt') {
                $cashBankGroupIds = Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
                $fromUsers = User::whereNotIn('group_id', $cashBankGroupIds)->select('id', 'name', 'address')->get();
                $toUsers = User::whereIn('group_id', $cashBankGroupIds)->select('id', 'name', 'address')->get();

                $response['from'] = $formatUsersWithCities($fromUsers);
                $response['to'] = $formatUsersWithCities($toUsers);
    
                $salesVouchers = Voucher::where('voucher_type', 'Sales')->get();
        
                foreach ($salesVouchers as $voucher) {
                    $response['against_vouchers'] = array_merge(
                        $response['against_vouchers'],
                        $formatVoucherLabel($voucher)
                    );
                }

            } elseif ($voucherType === 'Journal') {
                $allUsers = User::select('id', 'name', 'address')->get();
                $response['from'] = $response['to'] = $formatUsersWithCities($allUsers);

            } elseif ($voucherType === 'Contra') {
                $groupIds = Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
                $ledgers = User::whereIn('group_id', $groupIds)->select('id', 'name', 'address')->get();
                $response['from'] = $response['to'] = $formatUsersWithCities($ledgers);

            } elseif ($voucherType === 'Sales') {
                $salesGroupId = Group::where('group_name', 'Sales')->pluck('id');
                $includedGroupIds = Group::whereIn('group_name', ['Cash', 'Bank', 'Loan', 'Expense'])->pluck('id');

                $fromUsers = User::whereIn('group_id', $salesGroupId)->select('id', 'name', 'address')->get();
                $toUsers = User::whereIn('group_id', $includedGroupIds)->select('id', 'name', 'address')->get();

                $response['from'] = $formatUsersWithCities($fromUsers);
                $response['to'] = $formatUsersWithCities($toUsers);

            } elseif ($voucherType === 'Purchase') {
                $vendorsGroupId = Group::where('group_name', 'Vendors')->pluck('id');
                $fromUsers = User::whereIn('group_id', $vendorsGroupId)->select('id', 'name', 'address')->get();
                $toUsers = User::whereNotIn('group_id', $vendorsGroupId)->select('id', 'name', 'address')->get();

                $response['from'] = $formatUsersWithCities($fromUsers);
                $response['to'] = $formatUsersWithCities($toUsers);

            } elseif ($voucherType === 'Expense') {
                $expenseGroupId = Group::where('group_name', 'Expense')->pluck('id');
                $fromUsers = User::whereIn('group_id', $expenseGroupId)->select('id', 'name', 'address')->get();
                $toUsers = User::whereNotIn('group_id', $expenseGroupId)->select('id', 'name', 'address')->get();

                $response['from'] = $formatUsersWithCities($fromUsers);
                $response['to'] = $formatUsersWithCities($toUsers);
            }

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate & receive input (optional — adjust rules as needed)
        $request->validate([
            'voucher_type' => 'required|string',
            'voucher_date' => 'required|date',
            'vouchers'     => 'required|array',
        ]);

        // This maps voucher IDs to labels sent from frontend
        $againstVoucherLabels = $request->input('against_voucher_labels', []);

        $bodies = [];
        $finalVouchers = [];

        foreach ($request->vouchers as $voucher) {
            // Parse address indexes
            [$fromId, $fromAddressIndex] = explode('__', $voucher['from_account']);
            [$toId, $toAddressIndex] = explode('__', $voucher['to_account']);

            $fromUser = User::find($fromId);
            $toUser   = User::find($toId);

            $fromAddresses = is_string($fromUser->address) ? json_decode($fromUser->address, true) : $fromUser->address;
            $toAddresses   = is_string($toUser->address) ? json_decode($toUser->address, true) : $toUser->address;

            $fromAddress = $fromAddresses[$fromAddressIndex] ?? [];
            $toAddress   = $toAddresses[$toAddressIndex] ?? [];

            $amount = floatval($voucher['amount']);
            $toState = $toAddress['state'] ?? null;

            // GST Logic
            $cgstRate = 6;
            $sgstRate = 6;
            $igstRate = 12;

            if ($toState === 'Madhya Pradesh') {
                $cgstAmount = round($amount * $cgstRate / 100, 2);
                $sgstAmount = round($amount * $sgstRate / 100, 2);
                $igstAmount = 0;
                $totalTax = $cgstAmount + $sgstAmount;
            } else {
                $cgstAmount = 0;
                $sgstAmount = 0;
                $igstAmount = round($amount * $igstRate / 100, 2);
                $totalTax = $igstAmount;
            }

            $taxableValue = $amount - $totalTax;

            
            $readableAgainstVouchers = [];
            if (!empty($voucher['against_voucher'])) {
                foreach ($voucher['against_voucher'] as $id) {
                    $label = $againstVoucherLabels[$id] ?? $id;
                    preg_match('/₹([\d,\.]+)/', $label, $matches);
                    $vAmount = isset($matches[1]) ? (float) str_replace(',', '', $matches[1]) : null;

                    $readableAgainstVouchers[] = [
                        'label'  => $label,
                        'amount' => $vAmount,
                    ];
                }
            }

        
            $salesVoucherReadable = [];
            if (!empty($voucher['sales_voucher'])) {
                foreach ($voucher['sales_voucher'] as $id) {
                    $label = $againstVoucherLabels[$id] ?? $id;
                    preg_match('/₹([\d,\.]+)/', $label, $matches);
                    $vAmount = isset($matches[1]) ? (float) str_replace(',', '', $matches[1]) : null;

                    $salesVoucherReadable[] = [
                        'label'  => $label,
                        'amount' => $vAmount,
                    ];
                }
            }

        
            $finalVouchers[] = [
                'voucher_no'     => $voucher['voucher_no'],
                'from_account'   => $voucher['from_account'],
                'to_account'     => $voucher['to_account'],
                'amount'         => $amount,
                "is_advance_receipt" => $voucher['is_advance_receipt'] ?? '',
                "instrument_type"    => $voucher['instrument_type'] ?? '',
                "instrument_number"  => $voucher['instrument_number'] ?? '',
                "instrument_date"    => $voucher['instrument_date'] ?? '',
                'assigned_to'    => $voucher['assigned_to'] ?? null,
                'narration'      => $voucher['narration'] ?? null,
                'tally_narration'=> $voucher['tally_narration'] ?? null,
                'against_voucher'=> !empty($readableAgainstVouchers) ? $readableAgainstVouchers : null,
                'sales_voucher'  => !empty($salesVoucherReadable) ? $salesVoucherReadable : null,
                'transaction_id' => $voucher['transaction_id'] ?? null,
                'credit_day'     => $voucher['credit_day'] ?? null,
                'cash_credit'    => $voucher['cash_credit'] ?? null,
                'tds_payable'    => $voucher['tds_payable'] ?? null,
            ];
        
            if ($request->voucher_type === "Receipt") {
                $bodies[] = [
                    "Voucher Date"       => $request->voucher_date,
                    "Voucher Number"     => $voucher['voucher_no'] ?? '',
                    "Voucher Type"       => $request->voucher_type,
                    "Bank Reco Date"     => $request->voucher_date,
                    "Is Advance Receipt" => $voucher['is_advance_receipt'] ?? '',
                    "Instrument Type"    => $voucher['instrument_type'] ?? '',
                    "Instrument Number"  => $voucher['instrument_number'] ?? '',
                    "Instrument Date"    => $voucher['instrument_date'] ?? '',
                    "Amount"             => $amount,
                    "Taxable Value"      => $taxableValue,
                    "CGST Rate"          => $cgstRate,
                    "CGST Amount"        => $cgstAmount,
                    "SGST Rate"          => $sgstRate,
                    "SGST Amount"        => $sgstAmount,
                    "IGST Rate"          => $igstRate,
                    "IGST Amount"        => $igstAmount,
                    "Total Tax"          => $totalTax,
                    "Credit Ledgers"     => $toUser->name,
                    "Party Name"         => $toUser->name,
                    "Add 1"              => $toAddress['consignment_address'] ?? '',
                    "Add 2"              => $toAddress['billing_address'] ?? '',
                    "Add 3"              => $toAddress['billing_address'] ?? '',
                    "State"              => $toAddress['state'] ?? null,
                    "Place of Supply"    => $toAddress['state'] ?? null,
                    "Registration Type"  => 'Regular',
                    "GSTIN"              => $toAddress['gstin'] ?? '',
                    "Cash / Bank Ledger" => $fromUser->bank_name ?? '',
                    "Bill Name"          => 'KRL' . now()->format('YmdHis') . rand(10, 99),
                    "Ledger / Item"      => 'Professional',
                    "Issued Bank"        => $toUser->bank_name ?? '',
                    "Branch"             => $toUser->branch ?? '',
                    "Cost Center"        => "Office",
                    "Narration"          => $voucher['narration'] ?? '',
                ];
            }

            if ($request->voucher_type === "Payment") {
                $bodies[] = [
                    "Voucher Date"      => $request->voucher_date,
                    "Reco Date"         => $request->voucher_date,
                    "Voucher Number"    => $voucher['voucher_no'] ?? '',
                    "Voucher Type"      => $request->voucher_type,
                    "Cash/Bank Ledger"  => $fromUser->bank_name ?? '',
                    "Debit Ledgers"     => $fromUser->name,
                    "Bill Name"         => 'KRL' . now()->format('YmdHis') . rand(10, 99),
                    "Amount"            => $amount,
                    "Instrument Type"   => $voucher['instrument_type'] ?? '',
                    "Instrument Number" => $voucher['instrument_number'] ?? '',
                    "Instrument Date"   => $voucher['instrument_date'] ?? '',
                    "Cost Center"       => "Office",
                    "Narration"         => $voucher['narration'] ?? '',
                ];
            }
            if ($request->voucher_type === "Sales") {
                $bodies[] = [
                    "Date"                 => $request->voucher_date,
                    "Voucher No"           => $voucher['voucher_no'] ?? '',
                    "Voucher Type"         => $request->voucher_type,
                    "IS Invoice"           => $request->is_invoice ?? 'Yes',
                    "Bill Wise Details"    => $request->bill_wise_details ?? 'PO - 55555',
                    "Debit / Party Ledger" => $toUser->name,
                    "Address 1"            => $toAddress['consignment_address'] ?? '',
                    "Address 2"            => $toAddress['billing_address'] ?? '',
                    "Address 3"            => $toAddress['billing_address'] ?? '',
                    "Pincode"              => $toAddress['pincode'] ?? '',
                    "State"                => $toAddress['state'] ?? null,
                    "Place of Supply"      => $toAddress['state'] ?? null,
                    "Country"              => "India",
                    "GSTIN"                => $toAddress['gstin'] ?? '',
                    "GST Registration Type"=> "Regular",
                    "Consignee Name"       => $toUser->name ?? '',
                    "Consignee Add 1"      => $toAddress['consignment_address'] ?? '',
                    "Consignee Add 2"      => $toAddress['billing_address'] ?? '',
                    "Consignee Add 3"      => $toAddress['billing_address'] ?? '',
                    "Consignee State"      => $toAddress['state'] ?? null,
                    "Consignee Country"    => "India",
                    "Consignee Pincode"    => $toAddress['pincode'] ?? '',
                    "Consignee GSTIN"      => $toAddress['gstin'] ?? '',
                    "Credit Ledger 1"      => "Sales GST Local @ 18%",
                    "Credit Ledger 1 Amount" => $amount,
                    "Ledger 1 Description"   => "This is ledger description",
                    // 
                    "Credit Period"        => $voucher['credit_day'] ?? '',
                    "Cost Center"          => "Office",
                    "Narration"            => $voucher['narration'] ?? '',
                    "IRN Ack No"           => $voucher['irn_ack_no'] ?? '',
                    "IRN Ack Date"         => $voucher['irn_ack_date'] ?? '',
                    "IRN No"               => $voucher['irn_no'] ?? '',
                    "IRN Bill to Place"    => $voucher['irn_bill_to_place'] ?? '',
                    "IRN Ship to State"    => $voucher['irn_ship_to_state'] ?? '',
                ];
            }
            if ($request->voucher_type === "Purchase") {
                $bodies[] = [
                    "Date"                 => $request->voucher_date,
                    "Voucher No"           => $voucher['voucher_no'] ?? '',
                    "Voucher Type"         => $request->voucher_type,
                    
                    "Supplier Inv No"      => $voucher['supplier_inv_no'] ?? '',
                    "Supplier Inv Date"    => $voucher['supplier_inv_date'] ?? '',
                    "Credit / Party Ledger"=> $toUser->name,
                    "Address 1"            => $toAddress['consignment_address'] ?? '',
                    "Address 2"            => $toAddress['billing_address'] ?? '',
                    "Address 3"            => $toAddress['billing_address'] ?? '',
                    "State"                => $toAddress['state'] ?? null,
                    "Place of Supply"      => $toAddress['state'] ?? null,
                    "VAT Tin No"           => $voucher['vat_tin_no'] ?? '',
                    "CST No"               => $voucher['cst_no'] ?? '',
                    "Service Tax No"       => $voucher['service_tax_no'] ?? '',
                    "GSTIN"                => $toAddress['gstin'] ?? '',
                    "GST Registration Type"=> "Regular",

                    // Example fixed entries, but you can push dynamically
                    "Debit Ledger 1"       => "Purchase GST Interstate @ 18%",
                    "Debit Ledger 1 Amount"=> $amount,
                    "Ledger 1 Description" => "This is Ledger Description",

                    "Debit Period"         => $voucher['debit_day'] ?? '30 Days',
                    "Cost Center"          => "Department - B",
                    "Narration"            => $voucher['narration'] ?? '',
                ];
            }
            if ($request->voucher_type === "Journal") {
                
                $voucherData = is_array($voucher) ? $voucher : $voucher->toArray();

                // Example fixed entries, but you can push dynamically
                $bodies[] = [
                    "Date"             => $request->voucher_date,
                    "Voucher Number"   => $voucherData['voucher_no']   ?? '',
                    "Voucher Ref No"   => $voucherData['voucher_no'] ?? '',
                    "Voucher Ref Date" => $voucherData['voucher_date'] ?? '',
                    "Voucher Type"     => $request->voucher_type,

                    "From Ledger"      => $fromUser->name,
                    "To Ledger"        => $toUser->name,
                    "Debit / Credit"   => $voucherData['dr_cr'] ?? '',
                    "Bill Ref No"      => $voucherData['bill_ref_no'] ?? '',
                    "Amount"           => $voucherData['amount'] ?? 0,

                    "Cost Center"      => $voucherData['cost_center'] ?? null,
                    "Stock Item"       => $voucherData['stock_item'] ?? null,
                    "Godown"           => $voucherData['godown'] ?? null,
                    "Batch No"         => $voucherData['batch_no'] ?? null,
                    "QTY"              => $voucherData['qty'] ?? null,
                    "Rate"             => $voucherData['rate'] ?? null,
                    "UOM"              => $voucherData['uom'] ?? null,
                    "Item Amount"      => $voucherData['amount'] ?? null,

                    "Narration"        => $voucherData['narration'] ?? '',
                ];
            }

        }

        
        DB::table('vouchers')->insert([
            'voucher_type' => $request->voucher_type,
            'voucher_date' => $request->voucher_date,
            'vouchers'     => json_encode($finalVouchers),
            'VoucherApi'   => json_encode($bodies),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return response()->json([
            'message'  => 'Voucher stored successfully.',
            'vouchers' => $finalVouchers,
            'bodies'   => $bodies,
        ]);
    }
    
   

    public function update(Request $request, $id)
    {
        // return $request->All();
        logger("Updating voucher with ID: " . $id);

        try {
            $voucher = Voucher::find($id);

            if (!$voucher) {
                logger("Voucher not found with ID: " . $id);
                return response()->json(['error' => 'Voucher not found'], 404);
            }

            // Validate request
            $validated = $request->validate([
                'voucher_type' => 'required|string',
                'voucher_date' => 'required|date',
                'vouchers'     => 'required|array',
            ]);

            $bodies = [];

            foreach ($request->vouchers as $voucherItem) {
                [$fromId, $fromAddressIndex] = explode('__', $voucherItem['from_account']);
                [$toId, $toAddressIndex] = explode('__', $voucherItem['to_account']);

                $fromUser = User::find($fromId);
                $toUser = User::find($toId);

                $fromAddresses = is_string($fromUser->address) ? json_decode($fromUser->address, true) : $fromUser->address;
                $toAddresses = is_string($toUser->address) ? json_decode($toUser->address, true) : $toUser->address;

                $fromAddress = $fromAddresses[$fromAddressIndex] ?? [];
                $toAddress = $toAddresses[$toAddressIndex] ?? [];

                $amount = floatval($voucherItem['amount']);
                $toState = $toAddress['state'] ?? null;

                // GST Logic
                $cgstRate = 6;
                $sgstRate = 6;
                $igstRate = 12;

                if ($toState === 'Madhya Pradesh') {
                    $cgstAmount = round($amount * $cgstRate / 100, 2);
                    $sgstAmount = round($amount * $sgstRate / 100, 2);
                    $igstAmount = 0;
                    $totalTax = $cgstAmount + $sgstAmount;
                } else {
                    $cgstAmount = 0;
                    $sgstAmount = 0;
                    $igstAmount = round($amount * $igstRate / 100, 2);
                    $totalTax = $igstAmount;
                }

                $taxableValue = $amount - $totalTax;

                if ($request->voucher_type === "Receipt") {
                    $bodies[] = [
                        "Voucher Date"        => $request->voucher_date,
                        "Voucher Number"      => $voucherItem['voucher_no'] ?? '',
                        "Voucher Type"        => $request->voucher_type,
                        "Bank Reco Date"      => $request->voucher_date,
                        "Is Advance Receipt"  => $voucherItem['is_advance_receipt'] ?? '',
                        "Instrument Type"     => $voucherItem['instrument_type'] ?? '',
                        "Instrument Number"   => $voucherItem['instrument_number'] ?? '',
                        "Instrument Date"     => $voucherItem['instrument_date'] ?? '',
                        "Amount"              => $amount,
                        "Taxable Value"       => $taxableValue,
                        "CGST Rate"           => $cgstRate,
                        "CGST Amount"         => $cgstAmount,
                        "SGST Rate"           => $sgstRate,
                        "SGST Amount"         => $sgstAmount,
                        "IGST Rate"           => $igstRate,
                        "IGST Amount"         => $igstAmount,
                        "Total Tax"           => $totalTax,
                        "Credit Ledgers"      => $toUser->name,
                        "Party Name"          => $toUser->name,
                        "Add 1"               => $toAddress['consignment_address'] ?? '',
                        "Add 2"               => $toAddress['billing_address'] ?? '',
                        "Add 3"               => $toAddress['billing_address'] ?? '',
                        "State"               => $toAddress['state'] ?? null,
                        "Place of Supply"     => $toAddress['state'] ?? null,
                        "Registration Type"   => 'Regular',
                        "GSTIN"               => $toAddress['gstin'] ?? '',
                        "Cash / Bank Ledger"  => $fromUser->bank_name ?? '',
                        "Bill Name"           => 'KRL' . now()->format('YmdHis') . rand(10, 99),
                        "Ledger / Item"       => 'Professional',
                        "Issued Bank"         => $toUser->bank_name ?? '',
                        "Branch"              => $toUser->branch ?? '',
                        "Cost Center"         => "Office",
                        "Narration"           => $voucherItem['narration'] ?? '',
                    ];
                }

                if ($request->voucher_type === "Payment") {
                    $bodies[] = [
                        "Voucher Date"        => $request->voucher_date,
                        "Reco Date"           => $request->voucher_date,
                        "Voucher Number"      => $voucherItem['voucher_no'] ?? '',
                        "Voucher Type"        => $request->voucher_type,
                        "Cash/Bank Ledger"    => $fromUser->bank_name ?? '',
                        "Debit Ledgers"       => $fromUser->name,
                        "Bill Name"           => 'KRL' . now()->format('YmdHis') . rand(10, 99),
                        "Amount"              => $amount,
                        "Instrument Type"     => $voucherItem['instrument_type'] ?? '',
                        "Instrument Number"   => $voucherItem['instrument_number'] ?? '',
                        "Instrument Date"     => $voucherItem['instrument_date'] ?? '',
                        "Cost Center"         => "Office",
                        "Narration"           => $voucherItem['narration'] ?? '',
                    ];
                }
                if ($request->voucher_type === "Sales") {
                    $bodies[] = [
                        "Date"                 => $request->voucher_date,
                        "Voucher No"           => $voucherItem['voucher_no'] ?? '',
                        "Voucher Type"         => $request->voucher_type,
                        "IS Invoice"           => $request->is_invoice ?? 'Yes',
                        "Bill Wise Details"    => $request->bill_wise_details ?? 'PO - 55555',
                        "Debit / Party Ledger" => $toUser->name,
                        "Address 1"            => $toAddress['consignment_address'] ?? '',
                        "Address 2"            => $toAddress['billing_address'] ?? '',
                        "Address 3"            => $toAddress['billing_address'] ?? '',
                        "Pincode"              => $toAddress['pincode'] ?? '',
                        "State"                => $toAddress['state'] ?? null,
                        "Place of Supply"      => $toAddress['state'] ?? null,
                        "Country"              => "India",
                        "GSTIN"                => $toAddress['gstin'] ?? '',
                        "GST Registration Type"=> "Regular",
                        "Consignee Name"       => $toUser->name ?? '',
                        "Consignee Add 1"      => $toAddress['consignment_address'] ?? '',
                        "Consignee Add 2"      => $toAddress['billing_address'] ?? '',
                        "Consignee Add 3"      => $toAddress['billing_address'] ?? '',
                        "Consignee State"      => $toAddress['state'] ?? null,
                        "Consignee Country"    => "India",
                        "Consignee Pincode"    => $toAddress['pincode'] ?? '',
                        "Consignee GSTIN"      => $toAddress['gstin'] ?? '',
                        "Credit Ledger 1"      => "Sales GST Local @ 18%",
                        "Credit Ledger 1 Amount" => $amount,
                        "Ledger 1 Description"   => "This is ledger description",
                        // 
                        "Credit Period"        => $voucherItem['credit_day'] ?? '',
                        "Cost Center"          => "Office",
                        "Narration"            => $voucherItem['narration'] ?? '',
                        "IRN Ack No"           => $voucherItem['irn_ack_no'] ?? '',
                        "IRN Ack Date"         => $voucherItem['irn_ack_date'] ?? '',
                        "IRN No"               => $voucherItem['irn_no'] ?? '',
                        "IRN Bill to Place"    => $voucherItem['irn_bill_to_place'] ?? '',
                        "IRN Ship to State"    => $voucherItem['irn_ship_to_state'] ?? '',  
                    ];
                }
                if ($request->voucher_type === "Purchase") {
                    $bodies[] = [
                        "Date"                 => $request->voucher_date,
                        "Voucher No"           => $voucherItem['voucher_no'] ?? '',
                        "Voucher Type"         => $request->voucher_type,
                        
                        "Supplier Inv No"      => $voucherItem['supplier_inv_no'] ?? '',
                        "Supplier Inv Date"    => $voucherItem['supplier_inv_date'] ?? '',
                        "Credit / Party Ledger"=> $toUser->name,
                        "Address 1"            => $toAddress['consignment_address'] ?? '',
                        "Address 2"            => $toAddress['billing_address'] ?? '',
                        "Address 3"            => $toAddress['billing_address'] ?? '',
                        "State"                => $toAddress['state'] ?? null,
                        "Place of Supply"      => $toAddress['state'] ?? null,
                        "VAT Tin No"           => $voucherItem['vat_tin_no'] ?? '',
                        "CST No"               => $voucherItem['cst_no'] ?? '',
                        "Service Tax No"       => $voucherItem['service_tax_no'] ?? '',
                        "GSTIN"                => $toAddress['gstin'] ?? '',
                        "GST Registration Type"=> "Regular",

                        // Example fixed entries, but you can push dynamically
                        "Debit Ledger 1"       => "Purchase GST Interstate @ 18%",
                        "Debit Ledger 1 Amount"=> $amount,
                        "Ledger 1 Description" => "This is Ledger Description",

                        "Debit Period"         => $voucherItem['debit_day'] ?? '30 Days',
                        "Cost Center"          => "Department - B",
                        "Narration"            => $voucherItem['narration'] ?? '',
                    ];
                }
                if ($request->voucher_type === "Journal") {
                    $voucherData = is_array($voucherItem) ? $voucherItem : $voucherItem->toArray();
                    // Example fixed entries, but you can push dynamically
                    $bodies[] = [
                        "Date"             => $request->voucher_date,
                        "Voucher Number"   => $voucherData['voucher_no']   ?? '',
                        "Voucher Ref No"   => $voucherData['voucher_no'] ?? '',
                        "Voucher Ref Date" => $voucherData['voucher_date'] ?? '',
                        "Voucher Type"     => $request->voucher_type,
                        "From Ledger"      => $fromUser->name,
                        "To Ledger"        => $toUser->name,
                        "Debit / Credit"   => $voucherData['dr_cr'] ?? '',
                        "Bill Ref No"      => $voucherData['bill_ref_no'] ?? '',
                        "Amount"           => $voucherData['amount'] ?? 0,
                        "Cost Center"      => $voucherData['cost_center'] ?? null,
                        "Stock Item"       => $voucherData['stock_item'] ?? null,
                        "Godown"           => $voucherData['godown'] ?? null,
                        "Batch No"         => $voucherData['batch_no'] ?? null,
                        "QTY"              => $voucherData['qty'] ?? null,
                        "Rate"             => $voucherData['rate'] ?? null,
                        "UOM"              => $voucherData['uom'] ?? null,
                        "Item Amount"      => $voucherData['amount'] ?? null,
                        "Narration"        => $voucherData['narration'] ?? '',  // Ensure narration is included
                        // Ensure other dynamic entries are included as needed
                    ];
                }

            // Update the voucher record
            $voucher->update([
                'voucher_type' => $request->voucher_type,
                'voucher_date' => $request->voucher_date,
                'vouchers'     => json_encode($request->vouchers),
                'VoucherApi'   => json_encode($bodies),
            ]);

            return response()->json([
                'message' => 'Voucher updated successfully!',
                // 'voucher' => $voucher->fresh(),
                'VoucherApi' => $bodies
            ]);
        }
        } catch (\Exception $e) {
            logger("Error updating voucher: " . $e->getMessage());
            return response()->json([
                'error' => 'Error updating voucher',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    public function syncTally()
    {
        // -------- Receipt Vouchers --------
        $receiptVouchers = Voucher::where('voucher_type', 'Receipt')
            ->where('sataus', '0')
            ->whereNotNull('VoucherApi')
            ->where('VoucherApi', '!=', '')
            ->get();

        $receiptBody = [];
        $receiptIds = [];
        foreach ($receiptVouchers as $voucher) {
            $decodedApi = json_decode($voucher->VoucherApi, true);
            if (is_array($decodedApi)) {
                foreach ($decodedApi as $entry) {
                    $receiptBody[] = $entry;
                }
                $receiptIds[] = $voucher->id;
            }
        }

        $receiptResponse = null;
        if (!empty($receiptBody)) {
            $receiptResponse = Http::withHeaders([
                'X-Auth-Key'   => 'test_946ead867e5344189312ff54fd4097e4',
                'Template-Key' => '12',
                'CompanyName'  => 'Tally Company Name',
                'version'      => '3'
            ])->post('https://api.api2books.com/api/User/ReceiptVoucher', [
                'body' => $receiptBody
            ]);
            Voucher::whereIn('id', $receiptIds)->update(['sataus' => '1']);
        }

        // -------- Payment Vouchers --------
        $paymentVouchers = Voucher::where('voucher_type', 'Payment')
            ->where('sataus', '0')
            ->whereNotNull('VoucherApi')
            ->where('VoucherApi', '!=', '')
            ->get();

        $paymentBody = [];
        $paymentIds = [];
        foreach ($paymentVouchers as $voucher) {
            $decodedApi = json_decode($voucher->VoucherApi, true);
            if (is_array($decodedApi)) {
                foreach ($decodedApi as $entry) {
                    $paymentBody[] = $entry;
                }
                $paymentIds[] = $voucher->id;
            }
        }

        $paymentResponse = null;
        if (!empty($paymentBody)) {
            $paymentResponse = Http::withHeaders([
                'X-Auth-Key'   => 'test_946ead867e5344189312ff54fd4097e4',
                'Template-Key' => '13',
                'CompanyName'  => 'Tally Company Name',
                'version'      => '3'
            ])->post('https://api.api2books.com/api/User/PaymentVoucher', [
                'body' => $paymentBody
            ]);
            Voucher::whereIn('id', $paymentIds)->update(['sataus' => '1']);
        }

        // -------- Purchase Vouchers --------
        $purchaseVouchers = Voucher::where('voucher_type', 'Purchase')
            ->where('sataus', '0')
            ->whereNotNull('VoucherApi')
            ->where('VoucherApi', '!=', '')
            ->get();

        $purchaseBody = [];
        $purchaseIds = [];
        foreach ($purchaseVouchers as $voucher) {
            $decodedApi = json_decode($voucher->VoucherApi, true);
            if (is_array($decodedApi)) {
                foreach ($decodedApi as $entry) {
                    $purchaseBody[] = $entry;
                }
                $purchaseIds[] = $voucher->id;
            }
        }

        $purchaseResponse = null;
        if (!empty($purchaseBody)) {
            $purchaseResponse = Http::withHeaders([
                'X-Auth-Key'   => 'test_946ead867e5344189312ff54fd4097e4',
                'Template-Key' => '8',
                'CompanyName'  => 'Tally Company Name',
                'version'      => '3'
            ])->post('https://api.api2books.com/api/User/PurchaseWithoutInventory', [
                'body' => $purchaseBody
            ]);
            Voucher::whereIn('id', $purchaseIds)->update(['sataus' => '1']);
        }

        // -------- Journal Vouchers --------
        $journalVouchers = Voucher::where('voucher_type', 'Journal')
            ->where('sataus', '0')
            ->whereNotNull('VoucherApi')
            ->where('VoucherApi', '!=', '')
            ->get();

        $journalBody = [];
        $journalIds = [];
        foreach ($journalVouchers as $voucher) {
            $decodedApi = json_decode($voucher->VoucherApi, true);
            if (is_array($decodedApi)) {
                foreach ($decodedApi as $entry) {
                    $journalBody[] = $entry;
                }
                $journalIds[] = $voucher->id;
            }
        }

        $journalResponse = null;
        if (!empty($journalBody)) {
            $journalResponse = Http::withHeaders([
                'X-Auth-Key'   => 'test_946ead867e5344189312ff54fd4097e4',
                'Template-Key' => '18',
                'CompanyName'  => 'Tally Company Name',
                'version'      => '3'
            ])->post('https://api.api2books.com/api/User/JournalTemplate', [
                'body' => $journalBody
            ]);
            Voucher::whereIn('id', $journalIds)->update(['sataus' => '1']);
        }

        // -------- Sales Vouchers --------
        $salesVouchers = Voucher::where('voucher_type', 'Sales')
            ->where('sataus', '0')
            ->whereNotNull('VoucherApi')
            ->where('VoucherApi', '!=', '')
            ->get();

        $salesBody = [];
        $salesIds = [];
        foreach ($salesVouchers as $voucher) {
            $decodedApi = json_decode($voucher->VoucherApi, true);
            if (is_array($decodedApi)) {
                foreach ($decodedApi as $entry) {
                    $salesBody[] = $entry;
                }
                $salesIds[] = $voucher->id;
            }
        }

        $salesResponse = null;
        if (!empty($salesBody)) {
            $salesResponse = Http::withHeaders([
                'X-Auth-Key'   => 'test_946ead867e5344189312ff54fd4097e4',
                'Template-Key' => '2', // Sales Template Key
                'CompanyName'  => 'Tally Company Name',
                'version'      => '3'
            ])->post('https://api.api2books.com/api/User/SalesWithoutInventory', [
                'body' => $salesBody
            ]);
            Voucher::whereIn('id', $salesIds)->update(['sataus' => '1']);
        }
        // Return response
        return response()->json([
            'status' => 'success',
            'receipt_count'  => count($receiptBody),
            'payment_count'  => count($paymentBody),
            'purchase_count' => count($purchaseBody),
            'journal_count'  => count($journalBody),
            'sales_count'    => count($salesBody),

            'receipt_body'   => $receiptBody,
            'payment_body'   => $paymentBody,
            'purchase_body'  => $purchaseBody,
            'journal_body'   => $journalBody,
            'sales_body'     => $salesBody,

            'receipt_api_response'  => $receiptResponse ? $receiptResponse->json() : null,
            'payment_api_response'  => $paymentResponse ? $paymentResponse->json() : null,
            'purchase_api_response' => $purchaseResponse ? $purchaseResponse->json() : null,
            'journal_api_response'  => $journalResponse ? $journalResponse->json() : null,
            'sales_api_response'    => $salesResponse ? $salesResponse->json() : null,
        ]);
    }

}