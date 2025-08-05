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
                $entries = json_decode($voucher->vouchers, true);
                $labels = [];

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

    public function create()
    { 
        $ledgers = User::all(); 
        return view('admin.voucher.create', compact('ledgers')); 
    }
  

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
        }

        
        DB::table('vouchers')->insert([
            'voucher_type' => $request->voucher_type,
            'voucher_date' => $request->voucher_date,
            'vouchers'     => json_encode($finalVouchers),
            'VoucherApi'   => json_encode($bodies),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher stored successfully.');

        // return response()->json([
        //     'message'  => 'Voucher stored successfully.',
        //     'vouchers' => $finalVouchers,
        //     'bodies'   => $bodies,
        // ]);
    }

   public function getLedgers_OLD(Request $request)
    {
        $request->validate([
            'voucher_type' => 'required|string|in:Payment,Receipt,Contra,Journal,Sales,Purchase,Expense',
        ]);

        $voucherType = $request->voucher_type;
        try {
            // Payment
            if ($voucherType === 'Payment') {
                // Payment special case
                $fromGroupIds = Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
                $fromLedgers = User::whereIn('group_id', $fromGroupIds)
                                    ->select('id', 'name')
                                    ->get();

                // Get all ledgers that are NOT in Cash or Bank group
                $toLedgers = User::whereNotIn('group_id', $fromGroupIds)
                                    ->select('id', 'name')
                                    ->get();

                return response()->json([
                    'from' => $fromLedgers,
                    'to' => $toLedgers,
                ]);
            }
            // Receipt

            if ($voucherType === 'Receipt') {
                    // Get group IDs for 'Cash' and 'Bank'
                    $cashBankGroupIds = Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');

                    // FROM: All ledgers EXCEPT those in 'Cash' or 'Bank' group
                    $fromLedgers = User::whereNotIn('group_id', $cashBankGroupIds)
                                        ->select('id', 'name')
                                        ->get();

                    // TO: Only ledgers from 'Cash' or 'Bank' group
                    $toLedgers = User::whereIn('group_id', $cashBankGroupIds)
                                        ->select('id', 'name')
                                        ->get();

                    return response()->json([
                        'from' => $fromLedgers,
                        'to'   => $toLedgers,
                    ]);
            }
            if ($voucherType === 'Receipt') {
        // Step 1: Get group IDs for 'Cash' and 'Bank'
        $cashBankGroupIds = Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');

        // Step 2: Get FROM users (NOT in Cash/Bank groups)
        $fromUsers = User::whereNotIn('group_id', $cashBankGroupIds)->get();
        $fromLedgers = [];

        foreach ($fromUsers as $user) {
            $address = json_decode($user->address, true);
            $city = $address[0]['city'] ?? 'Unknown';

            $fromLedgers[] = [
                'id'   => $user->id,
                'name' => $user->name . ' - ' . $city,
            ];
        }

        // Step 3: Get TO users (IN Cash/Bank groups)
        $toUsers = User::whereIn('group_id', $cashBankGroupIds)->get();
        $toLedgers = [];

        foreach ($toUsers as $user) {
            $address = json_decode($user->address, true);
            $city = $address[0]['city'] ?? 'Unknown';

            $toLedgers[] = [
                'id'   => $user->id,
                'name' => $user->name . ' - ' . $city,
            ];
        }
    
        return response()->json([
            'from' => $fromLedgers,
            'to'   => $toLedgers,
        ]);
    }

            // Journal
            if ($voucherType === 'Journal') {
                $allLedgers = \App\Models\User::select('id', 'name')->get();

                return response()->json([
                    'from' => $allLedgers,
                    'to'   => $allLedgers,
                ]);
            }

            // Contra
            if ($voucherType === 'Contra') {
                // Get group IDs for 'Cash' and 'Bank'
                $cashBankGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');

                // Get ledgers only from those groups
                $ledgers = \App\Models\User::whereIn('group_id', $cashBankGroupIds)
                                ->select('id', 'name')
                                ->get();

                return response()->json([
                    'from' => $ledgers,
                    'to'   => $ledgers,
                ]);
            }

                // Sales
            if ($voucherType === 'Sales') {
                // FROM: Only 'Sales' group ledgers
                $salesGroupId = \App\Models\Group::where('group_name', 'Sales')->pluck('id'); // Fetch Sales group by name
                $fromLedgers = \App\Models\User::whereIn('group_id', $salesGroupId)
                                                    ->select('id', 'name')
                                                    ->get();

                // TO: Only 'Cash', 'Bank', 'Loan', and 'Expense' group ledgers
                $includedGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank', 'Loan', 'Expense'])->pluck('id');
                $toLedgers = \App\Models\User::whereIn('group_id', $includedGroupIds)
                                                    ->select('id', 'name')
                                                    ->get();

                return response()->json([
                    'from' => $fromLedgers,
                    'to'   => $toLedgers,
                ]);
            }


            // Purchase
            if ($voucherType === 'Purchase') {
                // Get Vendors Group ID
                $vendorsGroupId = \App\Models\Group::where('group_name', 'Vendors')->pluck('id');

                // FROM: Only users from Vendors Group
                $fromLedgers = \App\Models\User::whereIn('group_id', $vendorsGroupId)
                                            ->select('id', 'name')
                                            ->get();

                // TO: All users excluding Vendors Group
                $toLedgers = \App\Models\User::whereNotIn('group_id', $vendorsGroupId)
                                            ->select('id', 'name')
                                            ->get();
                    return response()->json([
                    'from' => $fromLedgers,
                    'to'   => $toLedgers,
                ]);
                
            }

        //Expense

        if ($voucherType === 'Expense') {
                $expenseGroupId = \App\Models\Group::where('group_name', 'Expense')->pluck('id');
            

                $fromLedgers = \App\Models\User::whereIn('group_id', $expenseGroupId)
                                            ->select('id', 'name')
                                            ->get();


                $toLedgers = \App\Models\User::whereNotIn('group_id', $expenseGroupId)
                                            ->select('id', 'name')
                                            ->get();

                

                return response()->json([
                    'from' => $fromLedgers,
                    'to'   => $toLedgers,
                ]);
            }


            

        // Normal case for other voucher types
            if (!isset($map[$voucherType])) {
                return response()->json(['from' => [], 'to' => []]);
            }

            $fromGroupIds = \App\Models\Group::whereIn('group_name', $map[$voucherType]['from'])->pluck('id');
            $fromLedgers = \App\Models\User::whereIn('group_id', $fromGroupIds)->select('id', 'name')->get();

            $toGroupIds = \App\Models\Group::whereIn('group_name', $map[$voucherType]['to'])->pluck('id');
            $toLedgers = \App\Models\User::whereIn('group_id', $toGroupIds)->select('id', 'name')->get();

            return response()->json([
                'from' => $fromLedgers,
                'to' => $toLedgers,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()]);
        }
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
        $voucher = Voucher::find($id);
        $ledgers = User::all(); 
        $voucherRows = is_string($voucher->vouchers) ? json_decode($voucher->vouchers, true) : $voucher->vouchers;

        return view('admin.voucher.edit', compact('voucher', 'ledgers', 'voucherRows'));
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
            }

            // Update the voucher record
            $voucher->update([
                'voucher_type' => $request->voucher_type,
                'voucher_date' => $request->voucher_date,
                'vouchers'     => json_encode($request->vouchers),
                'VoucherApi'   => json_encode($bodies),
            ]);

            // return response()->json([
            //     'message' => 'Voucher updated successfully!',
            //     // 'voucher' => $voucher->fresh(),
            //     'VoucherApi' => $bodies
            // ]);
            return redirect()->route('admin.voucher.index')->with('success', 'Voucher updated successfully!');
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
        $receiptVouchers = Voucher::where('voucher_type', 'Receipt')
            ->where('sataus', '0')
            ->whereNotNull('VoucherApi')
            ->where('VoucherApi', '!=', '')
            ->get();

        $paymentVouchers = Voucher::where('voucher_type', 'Payment')
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

        // Call Receipt API if there is any data
        $receiptResponse = null;
        if (!empty($receiptBody)) {
            $receiptResponse = Http::withHeaders([
                'X-Auth-Key' => 'test_992471d0e4cd4d12a0000000000000',
                'Template-Key' => '12',
                'CompanyName' => 'Tally Company Name',
                'version' => '3'
            ])->post('https://api.excel2tally.in/api/User/ReceiptVoucher', [
                'body' => $receiptBody
            ]);

            Voucher::whereIn('id', $receiptIds)->update(['sataus' => '1']);
        }

        // Call Payment API if there is any data
        $paymentResponse = null;
        if (!empty($paymentBody)) {
            $paymentResponse = Http::withHeaders([
                'X-Auth-Key' => 'test_992471d0e4cd4d12a0000000000000',
                'Template-Key' => '13',
                'CompanyName' => 'Tally Company Name',
                'version' => '3'
            ])->post('https://api.excel2tally.in/api/User/PaymentVoucher', [
                'body' => $paymentBody
            ]);

            Voucher::whereIn('id', $paymentIds)->update(['sataus' => '1']);
        }

        return response()->json([
            'status' => 'success',
            'receipt_count' => count($receiptBody),
            'payment_count' => count($paymentBody),
            'receipt_body' => $receiptBody,
            'payment_body' => $paymentBody,
            'receipt_api_response' => $receiptResponse ? $receiptResponse->json() : null,
            'payment_api_response' => $paymentResponse ? $paymentResponse->json() : null,
        ]);
    }

}
  

 
