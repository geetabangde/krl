<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsPayableController extends Controller
{
   

public function index()
{
    $vouchers = DB::table('vouchers')->get();
    $users = DB::table('users')->pluck('name', 'id')->toArray();

    $payables = [];

    foreach ($vouchers as $voucher) {
        $voucherDecoded = json_decode($voucher->vouchers, true);
        $voucherEntries = is_string($voucherDecoded) ? json_decode($voucherDecoded, true) : $voucherDecoded;

        if (!is_array($voucherEntries)) continue;

        // Step 1: Handle Purchase & Expense vouchers
        if (in_array($voucher->voucher_type, ['Purchase', 'Expense'])) {
            foreach ($voucherEntries as $entry) {
                $fromName = $users[$entry['from_account']] ?? $entry['from_account'];
                $toName = $users[$entry['to_account']] ?? $entry['to_account'];
                $amount = $entry['amount'];
                $date = $voucher->voucher_date;

                $label = "{$voucher->voucher_type} - {$fromName} → {$toName} ({$date}) → ₹{$amount}";

                $payables[$label] = [
                    'supplier_name' => $fromName,
                    'bill_date' => $date,
                    'amount' => (float) $amount,
                    'paid' => 0,
                ];
            }
        }

        // Step 2: Handle Payment vouchers
        if ($voucher->voucher_type === 'Payment') {
            foreach ($voucherEntries as $entry) {
                if (!empty($entry['against_voucher']) && is_array($entry['against_voucher'])) {
                    foreach ($entry['against_voucher'] as $linked) {
                        $label = $linked['label'];

                        if (isset($payables[$label])) {
                            $payables[$label]['paid'] += (float) $entry['amount'];
                        }
                    }
                }
            }
        }
    }

    // Step 3: Build final report
    $report = [];

    foreach ($payables as $label => $entry) {
        $report[] = [
            'label' => $label,
            'supplier_name' => $entry['supplier_name'],
            'bill_date' => Carbon::parse($entry['bill_date'])->format('d/m/Y'),
            'amount' => $entry['amount'],
            'paid' => $entry['paid'],
            'pending' => $entry['amount'] - $entry['paid'],
        ];
    }

    return view('admin.accounts_payable.index', compact('report'));
}

  
    
    // Show Create Form
    public function create()
    {
        return view('admin.accounts_payable.create'); // 🚀 Ensure You Have This View
    }
    
    
   
  public function show(Request $request)
{
    $label = urldecode($request->label);
    $vouchers = DB::table('vouchers')->get();
    $users = DB::table('users')->pluck('name', 'id')->toArray();

    $entries = [];

    foreach ($vouchers as $voucher) {
        $voucherDecoded = json_decode($voucher->vouchers, true);
        $voucherEntries = is_string($voucherDecoded) ? json_decode($voucherDecoded, true) : $voucherDecoded;

        if (!is_array($voucherEntries)) continue;

        // Handle Purchase and Expense
        if (in_array($voucher->voucher_type, ['Purchase', 'Expense'])) {
            foreach ($voucherEntries as $entry) {
                $fromName = $users[$entry['from_account']] ?? $entry['from_account'];
                $toName = $users[$entry['to_account']] ?? $entry['to_account'];
                $amount = $entry['amount'];
                $date = $voucher->voucher_date;

                $thisLabel = "{$voucher->voucher_type} - {$fromName} → {$toName} ({$date}) → ₹{$amount}";

                if ($thisLabel === $label) {
                    $entries[] = [
                        'type' => $voucher->voucher_type,
                        'supplier_name' => $toName,
                        'date' => $date,
                        'amount' => (float) $amount,
                        'paid' => 0,
                        'pending' => (float) $amount,
                    ];
                }
            }
        }

        // Handle Payment vouchers
        if ($voucher->voucher_type === 'Payment') {
            foreach ($voucherEntries as $entry) {
                $against = $entry['against_voucher'] ?? [];

                if (is_array($against)) {
                    foreach ($against as $againstEntry) {
                        if ($againstEntry['label'] === $label) {
                            $toName = $users[$entry['to_account']] ?? $entry['to_account'];
                            $entries[] = [
                                'type' => 'Payment',
                                'supplier_name' => $toName,
                                'date' => $voucher->voucher_date,
                                'amount' => 0,
                                'paid' => (float) $entry['amount'],
                                'pending' => 0,
                            ];
                        }
                    }
                }
            }
        }
    }

    return view('admin.accounts_payable.show', compact('entries', 'label'));
}

    
  


 
      
  }
  

 
