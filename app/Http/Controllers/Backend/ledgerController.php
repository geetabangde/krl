<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\LedgerMaster;
use App\Models\Group;
use App\Models\Voucher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ledgerController extends Controller
{
public function index()
{
    $voucherEntries = Voucher::all();
    $allLedgers = User::pluck('name', 'id'); // [id => name]

    $ledgerData = []; // ledger-wise debit & credit sum

    foreach ($voucherEntries as $entry) {
        $decodedVouchers = json_decode($entry->vouchers, true);
        $type = strtolower($entry->voucher_type);

        foreach ($decodedVouchers as $v) {
            $fromId = $v['from_account'] ?? null;
            $toId = $v['to_account'] ?? null;
            $amount = $v['amount'] ?? 0;

            // Setup structure
            if ($fromId && !isset($ledgerData[$fromId])) {
                $ledgerData[$fromId] = ['ledger_id' => $fromId, 'company' => $allLedgers[$fromId] ?? 'Unknown', 'debit' => 0, 'credit' => 0];
            }
            if ($toId && !isset($ledgerData[$toId])) {
                $ledgerData[$toId] = ['ledger_id' => $toId, 'company' => $allLedgers[$toId] ?? 'Unknown', 'debit' => 0, 'credit' => 0];
            }

            switch ($type) {
                case 'payment':
                case 'purchase':
                case 'expense':
                    if ($toId) {
                        $ledgerData[$toId]['debit'] += $amount;
                    }
                    break;

                case 'receipt':
                    if ($fromId) {
                        $ledgerData[$fromId]['credit'] += $amount;
                    }
                    break;

                case 'sales':
                    if ($toId) {
                        $ledgerData[$toId]['credit'] += $amount;
                    }
                    break;

                case 'journal':
                    if ($fromId) {
                        $ledgerData[$fromId]['debit'] += $amount;
                    }
                    if ($toId) {
                        $ledgerData[$toId]['credit'] += $amount;
                    }
                    break;
            }
        }
    }

    // Now prepare final array with closing balance and latest voucher type
    $ledgerSummary = [];

    foreach ($ledgerData as $id => $data) {
        $closing = $data['debit'] - $data['credit'];
        $typeLabel = $closing >= 0 ? 'Dr' : 'Cr';

        $ledgerSummary[] = [
            'ledger_id' => $id,
            'company' => $data['company'],
            'amount' => abs($closing),
            'type' => $typeLabel,
            'voucher_type' => 'Closing Balance',
        ];
    }

    return view('admin.ledger.index', compact('ledgerSummary'));
}





public function show($id)
{
    $ledger = User::findOrFail($id);

    $voucherEntries = Voucher::all();
    $voucherRecords = [];

    $totalDebit = 0;
    $totalCredit = 0;

    foreach ($voucherEntries as $entry) {
        $decoded = json_decode($entry->vouchers, true);
        $type = strtolower($entry->voucher_type); // Normalize
        $date = $entry->voucher_date ?? '';

        foreach ($decoded as $v) {
            $fromId = $v['from_account'] ?? null;
            $toId = $v['to_account'] ?? null;
            $amount = $v['amount'] ?? 0;
            $narration = $v['narration'] ?? '';

            $isDebit = false;
            $isCredit = false;

            // 🔍 Classification based on company perspective
            switch ($type) {
                case 'payment':
                case 'purchase':
                case 'expense':
                    if ($toId == $id) $isDebit = true;
                    break;

                case 'receipt':
                    if ($fromId == $id) $isCredit = true;
                    break;

                case 'sales':
                    if ($toId == $id) $isCredit = true;
                    break;

                case 'journal':
                    if ($fromId == $id) $isDebit = true;
                    if ($toId == $id) $isCredit = true;
                    break;

                // 'contra' or unknown types = ignore
                default:
                    continue 2; // Skip this voucher entry
            }

            if ($isDebit || $isCredit) {
                $voucherRecords[] = [
                    'date' => $date,
                    'type' => ucfirst($type),
                    'debit' => $isDebit ? $amount : '',
                    'credit' => $isCredit ? $amount : '',
                    'narration' => $narration,
                ];

                if ($isDebit) {
                    $totalDebit += $amount;
                }

                if ($isCredit) {
                    $totalCredit += $amount;
                }
            }
        }
    }

    $closingBalance = $totalDebit - $totalCredit;

    return view('admin.ledger.show', compact('ledger', 'voucherRecords', 'totalDebit', 'totalCredit', 'closingBalance'));
}




    public function create()
    {
        return view('admin.ledger_master.create'); // 🚀 Ensure You Have This View
    }
}
  

 
