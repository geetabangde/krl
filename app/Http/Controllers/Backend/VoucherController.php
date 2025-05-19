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

        return view('admin.voucher.index', compact('vouchers'));
    }

  
    public function create()
    { 
        $ledgers = LedgerMaster::all(); 
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
        'vouchers.*.from_account' => 'required|integer',
        'vouchers.*.to_account' => 'required|integer',
        'vouchers.*.amount' => 'required|numeric',
        'vouchers.*.assigned_to' => 'nullable|string',
        'vouchers.*.narration' => 'nullable|string',
        'vouchers.*.tally_narration' => 'nullable|string',
    ]);

    // Create the voucher entry
    $voucher = Voucher::create([
        'voucher_type' => $validated['voucher_type'],
        'voucher_date' => $validated['voucher_date'],
        'vouchers' => $validated['vouchers'],
    ]);

    // Redirect or return response
    return redirect()->route('admin.voucher.index')->with('success', 'Voucher created successfully!');
}







  public function getLedgers(Request $request)
  {
    $request->validate([
        'voucher_type' => 'required|string|in:Payment,Receipt,Contra,Journal,Sales,Purchase,Expense',
    ]);

    $voucherType = $request->voucher_type;

    // Define mappings with group_name instead of group_id
    $map = [
        'Expense' => ['from' => ['Bank', 'Cash'], 'to' => ['Expenses']],
    ];

    try {
        // Payment
        if ($voucherType === 'Payment') {
            // Payment special case
            $fromGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank'])->pluck('id');
            $fromLedgers = \App\Models\LedgerMaster::whereIn('group_id', $fromGroupIds)
                                ->select('id', 'ledger_name')
                                ->get();

            // Get all ledgers that are NOT in Cash or Bank group
            $toLedgers = \App\Models\LedgerMaster::whereNotIn('group_id', $fromGroupIds)
                                ->select('id', 'ledger_name')
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
                $fromLedgers = \App\Models\LedgerMaster::whereNotIn('group_id', $cashBankGroupIds)
                                    ->select('id', 'ledger_name')
                                    ->get();

                // TO: Only ledgers from 'Cash' or 'Bank' group
                $toLedgers = \App\Models\LedgerMaster::whereIn('group_id', $cashBankGroupIds)
                                    ->select('id', 'ledger_name')
                                    ->get();

                return response()->json([
                    'from' => $fromLedgers,
                    'to'   => $toLedgers,
                ]);
        }
        // Journal
        if ($voucherType === 'Journal') {
            $allLedgers = \App\Models\LedgerMaster::select('id', 'ledger_name')->get();

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
            $ledgers = \App\Models\LedgerMaster::whereIn('group_id', $cashBankGroupIds)
                            ->select('id', 'ledger_name')
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
            $fromLedgers = \App\Models\LedgerMaster::whereIn('group_id', $salesGroupId)
                                                ->select('id', 'ledger_name')
                                                ->get();

            // TO: Only 'Cash', 'Bank', 'Loan', and 'Expenses' group ledgers
            $includedGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank', 'Loan', 'Expenses'])->pluck('id');
            $toLedgers = \App\Models\LedgerMaster::whereIn('group_id', $includedGroupIds)
                                                ->select('id', 'ledger_name')
                                                ->get();

            return response()->json([
                'from' => $fromLedgers,
                'to'   => $toLedgers,
            ]);
        }


        // Purchase
        if ($voucherType === 'Purchase') {
            // FROM: Only 'Purchase' group ledgers
            $purchaseGroupId = \App\Models\Group::whereIn('group_name', 'Sales')->pluck('id');
            $fromLedgers = \App\Models\LedgerMaster::where('group_id', $purchaseGroupId)
                                        ->select('id', 'ledger_name')
                                        ->get();

            // TO: Only 'Cash', 'Bank', 'Loan', and 'Expenses' group ledgers
            $includedGroupIds = \App\Models\Group::whereIn('group_name', ['Cash', 'Bank', 'Loan', 'Expenses'])->pluck('id');
            $toLedgers = \App\Models\LedgerMaster::whereIn('group_id', $includedGroupIds)
                                        ->select('id', 'ledger_name')
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
        $fromLedgers = \App\Models\LedgerMaster::whereIn('group_id', $fromGroupIds)->select('id', 'ledger_name')->get();

        $toGroupIds = \App\Models\Group::whereIn('group_name', $map[$voucherType]['to'])->pluck('id');
        $toLedgers = \App\Models\LedgerMaster::whereIn('group_id', $toGroupIds)->select('id', 'ledger_name')->get();

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
    $ledgers = LedgerMaster::all(); 

    // Decode the vouchers field if it's stored as a JSON string
    $voucherRows = is_string($voucher->vouchers) ? json_decode($voucher->vouchers, true) : $voucher->vouchers;

    // Return the edit view with the voucher data, ledgers, and voucher rows
    return view('admin.voucher.edit', compact('voucher', 'ledgers', 'voucherRows'));
}




  public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'voucher_type' => 'required|string',
        'voucher_date' => 'required|date',
        'vouchers' => 'required|array|min:1',
        'vouchers.*.from_account' => 'required|integer|exists:ledger_master,id',
        'vouchers.*.to_account' => 'required|integer|exists:ledger_master,id',
        'vouchers.*.amount' => 'required|numeric|min:0',
        // 'assigned_to', 'narration', and 'tally_narration' are optional
    ]);

    // Find the existing voucher
    $voucher = Voucher::findOrFail($id);

    // Update basic fields
    $voucher->voucher_type = $request->voucher_type;
    $voucher->voucher_date = $request->voucher_date;

    // Prepare entries for JSON
    $voucherEntries = [];
    foreach ($request->vouchers as $voucherRow) {
        $voucherEntries[] = [
            'from_account' => $voucherRow['from_account'],
            'to_account' => $voucherRow['to_account'],
            'amount' => $voucherRow['amount'],
            'assigned_to' => $voucherRow['assigned_to'] ?? null,
            'narration' => $voucherRow['narration'] ?? null,
            'tally_narration' => $voucherRow['tally_narration'] ?? null,
        ];
    }

    // Convert the voucher entries to JSON and update the voucher
    $voucher->vouchers = json_encode($voucherEntries);
    
    // Save the updated voucher
    $voucher->save();

    // Redirect back to the voucher list or show a success message
    return redirect()->route('admin.voucher.index')->with('success', 'Voucher updated successfully.');
}






}
  

 
