<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Voucher;
use App\Models\LedgerMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

  
    public function create()
    { 
        $ledgers = User::all(); 
        return view('admin.voucher.create', compact('ledgers')); 
    }
    
    // VoucherController.php

  public function store(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'voucher_type' => 'required|string',
        'voucher_date' => 'required|date',
        'vouchers' => 'required|array',
        'vouchers.*.voucher_no' => 'required|string',
        'vouchers.*.from_account' => 'required|integer',
        'vouchers.*.to_account' => 'required|integer',
        'vouchers.*.amount' => 'required|numeric',
        'vouchers.*.assigned_to' => 'nullable|string',
        'vouchers.*.narration' => 'nullable|string',
        'vouchers.*.tally_narration' => 'nullable|string',
        'vouchers.*.against_voucher' => 'nullable|array',
        'vouchers.*.against_voucher.*' => 'nullable|string',
        'vouchers.*.sales_voucher' => 'nullable|array',
        'vouchers.*.sales_voucher.*' => 'nullable|string',
        'vouchers.*.transaction_id' => 'nullable|string',
        'vouchers.*.credit_day' => 'nullable|integer',
        'vouchers.*.cash_credit' => 'nullable|string|in:Cash,Credit',
        'vouchers.*.tds_payable' => 'nullable|numeric',
    ]);

    // Mapping for voucher labels sent from frontend
    $againstVoucherLabels = $request->input('against_voucher_labels', []);

    $vouchersData = [];

    foreach ($validated['vouchers'] as $voucherData) {
        // Build against_voucher with label + amount
        $readableAgainstVouchers = [];
        if (!empty($voucherData['against_voucher'])) {
            foreach ($voucherData['against_voucher'] as $id) {
                $label = $againstVoucherLabels[$id] ?? $id;

                // Extract amount from ₹
                preg_match('/₹([\d,\.]+)/', $label, $matches);
                $amount = isset($matches[1]) ? (float) str_replace(',', '', $matches[1]) : null;

                $readableAgainstVouchers[] = [
                    'label' => $label,
                    'amount' => $amount,
                ];
            }
        }

        // Build sales_voucher with label + amount
        $salesVoucherReadable = [];
        if (!empty($voucherData['sales_voucher'])) {
            foreach ($voucherData['sales_voucher'] as $v) {
                $label = $againstVoucherLabels[$v] ?? $v;

                preg_match('/₹([\d,\.]+)/', $label, $matches);
                $amount = isset($matches[1]) ? (float) str_replace(',', '', $matches[1]) : null;

                $salesVoucherReadable[] = [
                    'label' => $label,
                    'amount' => $amount,
                ];
            }
        }

        // Final voucher entry
        $vouchersData[] = [
            'voucher_no' => $voucherData['voucher_no'],
            'from_account' => $voucherData['from_account'],
            'to_account' => $voucherData['to_account'],
            'amount' => $voucherData['amount'],
            'assigned_to' => $voucherData['assigned_to'] ?? null,
            'narration' => $voucherData['narration'] ?? null,
            'tally_narration' => $voucherData['tally_narration'] ?? null,
            'against_voucher' => !empty($readableAgainstVouchers) ? $readableAgainstVouchers : null,
            'sales_voucher' => !empty($salesVoucherReadable) ? $salesVoucherReadable : null,
            'transaction_id' => $voucherData['transaction_id'] ?? null,
            'credit_day' => $voucherData['credit_day'] ?? null,
            'cash_credit' => $voucherData['cash_credit'] ?? null,
            'tds_payable' => $voucherData['tds_payable'] ?? null,
        ];
    }

    // Save Voucher Entry
    $voucher = Voucher::create([
        'voucher_type' => $validated['voucher_type'],
        'voucher_date' => $validated['voucher_date'],
        'vouchers' => json_encode($vouchersData),
    ]);
    // return($voucher);

    // Redirect or return success
    return redirect()->route('admin.voucher.index')->with('success', 'Voucher created successfully!');
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
            $fromGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
            $fromLedgers = \App\Models\User::whereIn('group_id', $fromGroupIds)
                                ->select('id', 'name')
                                ->get();

            // Get all ledgers that are NOT in Cash or Bank group
            $toLedgers = \App\Models\User::whereNotIn('group_id', $fromGroupIds)
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
                $cashBankGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');

                // FROM: All ledgers EXCEPT those in 'Cash' or 'Bank' group
                $fromLedgers = \App\Models\User::whereNotIn('group_id', $cashBankGroupIds)
                                    ->select('id', 'name')
                                    ->get();

                // TO: Only ledgers from 'Cash' or 'Bank' group
                $toLedgers = \App\Models\User::whereIn('group_id', $cashBankGroupIds)
                                    ->select('id', 'name')
                                    ->get();

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




public function getLedgers(Request $request)
{
    $request->validate([
        'voucher_type' => 'required|string|in:Payment,Receipt,Contra,Journal,Sales,Purchase,Expense',
    ]);

    $voucherType = $request->voucher_type;

    try {
        $response = [
            'from' => [],
            'to' => [],
            'against_vouchers' => [],
        ];

        // Common function to extract readable voucher line
        $formatVoucherLabel = function($voucher) {
            $entries = json_decode($voucher->vouchers, true);
            $labels = [];

            foreach ($entries as $v) {
                $from = \App\Models\User::find($v['from_account'])?->name ?? 'From';
                $to = \App\Models\User::find($v['to_account'])?->name ?? 'To';
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
            $fromGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
            $response['from'] = \App\Models\User::whereIn('group_id', $fromGroupIds)->select('id', 'name')->get();
            $response['to'] = \App\Models\User::whereNotIn('group_id', $fromGroupIds)->select('id', 'name')->get();

            // Fetch all Purchase and Expense vouchers
            $purchaseVouchers = \App\Models\Voucher::where('voucher_type', 'Purchase')->get();
            $expenseVouchers = \App\Models\Voucher::where('voucher_type', 'Expense')->get();

            $allVouchers = $purchaseVouchers->merge($expenseVouchers);
            foreach ($allVouchers as $voucher) {
                $response['against_vouchers'] = array_merge(
                    $response['against_vouchers'],
                    $formatVoucherLabel($voucher)
                );
            }
        } elseif ($voucherType === 'Receipt') {
            $cashBankGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
            $response['from'] = \App\Models\User::whereNotIn('group_id', $cashBankGroupIds)->select('id', 'name')->get();
            $response['to'] = \App\Models\User::whereIn('group_id', $cashBankGroupIds)->select('id', 'name')->get();

            // Fetch all Sales vouchers
            $salesVouchers = \App\Models\Voucher::where('voucher_type', 'Sales')->get();
            foreach ($salesVouchers as $voucher) {
                $response['against_vouchers'] = array_merge(
                    $response['against_vouchers'],
                    $formatVoucherLabel($voucher)
                );
            }
        } elseif ($voucherType === 'Journal') {
            $response['from'] = $response['to'] = \App\Models\User::select('id', 'name')->get();
        } elseif ($voucherType === 'Contra') {
            $groupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
            $ledgers = \App\Models\User::whereIn('group_id', $groupIds)->select('id', 'name')->get();
            $response['from'] = $response['to'] = $ledgers;
        } elseif ($voucherType === 'Sales') {
            $salesGroupId = \App\Models\Group::where('group_name', 'Sales')->pluck('id');
            $includedGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank', 'Loan', 'Expense'])->pluck('id');

            $response['from'] = \App\Models\User::whereIn('group_id', $salesGroupId)->select('id', 'name')->get();
            $response['to'] = \App\Models\User::whereIn('group_id', $includedGroupIds)->select('id', 'name')->get();
        } elseif ($voucherType === 'Purchase') {
            $vendorsGroupId = \App\Models\Group::where('group_name', 'Vendors')->pluck('id');
            $response['from'] = \App\Models\User::whereIn('group_id', $vendorsGroupId)->select('id', 'name')->get();
            $response['to'] = \App\Models\User::whereNotIn('group_id', $vendorsGroupId)->select('id', 'name')->get();
        } elseif ($voucherType === 'Expense') {
            $expenseGroupId = \App\Models\Group::where('group_name', 'Expense')->pluck('id');
            $response['from'] = \App\Models\User::whereIn('group_id', $expenseGroupId)->select('id', 'name')->get();
            $response['to'] = \App\Models\User::whereNotIn('group_id', $expenseGroupId)->select('id', 'name')->get();
        }
       
        
        return response()->json($response);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error: ' . $e->getMessage()]);
    }
}


public function show($id)
{
    $voucher = Voucher::with(['fromLedger', 'toLedger'])->findOrFail($id);

    // Decode the JSON stored in the vouchers field if it's not already decoded
    $voucher->voucher_data = json_decode($voucher->vouchers);

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
    // Fetch the voucher based on the ID
    $voucher = Voucher::find($id);

    // Fetch all ledgers for the dropdown
    $ledgers = User::all(); 

    // Decode the vouchers field if it's stored as a JSON string
    $voucherRows = is_string($voucher->vouchers) ? json_decode($voucher->vouchers, true) : $voucher->vouchers;
//    return($voucherRows);



    // Return the edit view with the voucher data, ledgers, and voucher rows
    return view('admin.voucher.edit', compact('voucher', 'ledgers', 'voucherRows'));
}




public function update(Request $request, $id)
{
    logger("Updating voucher with ID: ".$id);

    try {
        $voucher = Voucher::find($id);

        if (!$voucher) {
            logger("Voucher not found with ID: ".$id);
            abort(404, 'Voucher not found');
        }

        logger("Found voucher:", $voucher->toArray());

        // Validation
        $validated = $request->validate([
            'voucher_type' => 'required|string',
            'voucher_date' => 'required|date',
            'vouchers' => 'required|array',
            'vouchers.*.voucher_no' => 'required|string',
            'vouchers.*.from_account' => 'required|integer',
            'vouchers.*.to_account' => 'required|integer',
            'vouchers.*.amount' => 'required|numeric',
            'vouchers.*.assigned_to' => 'nullable|string',
            'vouchers.*.narration' => 'nullable|string',
            'vouchers.*.tally_narration' => 'nullable|string',
            'vouchers.*.against_voucher' => 'nullable|array',
            'vouchers.*.against_voucher.*' => 'nullable|string',
            'vouchers.*.sales_voucher' => 'nullable|array',
            'vouchers.*.sales_voucher.*' => 'nullable|string',
            'vouchers.*.transaction_id' => 'nullable|string',
            'vouchers.*.credit_day' => 'nullable|integer',
            'vouchers.*.cash_credit' => 'nullable|string|in:Cash,Credit',
            'vouchers.*.tds_payable' => 'nullable|numeric',
        ]);

        // against_voucher_labels from frontend
        $againstVoucherLabels = $request->input('against_voucher_labels', []);

        $vouchersData = [];

        foreach ($validated['vouchers'] as $voucherData) {
            // Against Voucher - label & amount
            $readableAgainstVouchers = [];
            if (!empty($voucherData['against_voucher'])) {
                foreach ($voucherData['against_voucher'] as $id) {
                    $label = $againstVoucherLabels[$id] ?? $id;

                    preg_match('/₹([\d,\.]+)/', $label, $matches);
                    $amount = isset($matches[1]) ? (float) str_replace(',', '', $matches[1]) : null;

                    $readableAgainstVouchers[] = [
                        'label' => $label,
                        'amount' => $amount,
                    ];
                }
            }

            // Sales Voucher - label & amount
            $salesVoucherReadable = [];
            if (!empty($voucherData['sales_voucher'])) {
                foreach ($voucherData['sales_voucher'] as $v) {
                    $label = $againstVoucherLabels[$v] ?? $v;

                    preg_match('/₹([\d,\.]+)/', $label, $matches);
                    $amount = isset($matches[1]) ? (float) str_replace(',', '', $matches[1]) : null;

                    $salesVoucherReadable[] = [
                        'label' => $label,
                        'amount' => $amount,
                    ];
                }
            }

            // Final voucher entry
            $vouchersData[] = [
                'voucher_no' => $voucherData['voucher_no'],
                'from_account' => $voucherData['from_account'],
                'to_account' => $voucherData['to_account'],
                'amount' => $voucherData['amount'],
                'assigned_to' => $voucherData['assigned_to'] ?? null,
                'narration' => $voucherData['narration'] ?? null,
                'tally_narration' => $voucherData['tally_narration'] ?? null,
                'against_voucher' => !empty($readableAgainstVouchers) ? $readableAgainstVouchers : null,
                'sales_voucher' => !empty($salesVoucherReadable) ? $salesVoucherReadable : null,
                'transaction_id' => $voucherData['transaction_id'] ?? null,
                'credit_day' => $voucherData['credit_day'] ?? null,
                'cash_credit' => $voucherData['cash_credit'] ?? null,
                'tds_payable' => $voucherData['tds_payable'] ?? null,
            ];
        }

        // Update voucher
        $voucher->update([
            'voucher_type' => $validated['voucher_type'],
            'voucher_date' => $validated['voucher_date'],
            'vouchers' => json_encode($vouchersData),
        ]);

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher updated successfully!');

    } catch (\Exception $e) {
        logger("Error updating voucher: ".$e->getMessage());
        return back()->with('error', 'Error updating voucher: '.$e->getMessage());
    }
}





}
  

 
