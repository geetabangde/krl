<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsReceivableController extends Controller
{
public function index()
{
    $vouchers = DB::table('vouchers')->get();
    $users = DB::table('users')->pluck('name', 'id')->toArray(); // id => name

    $sales = [];

    foreach ($vouchers as $voucher) {
        $voucherDecoded = json_decode($voucher->vouchers, true);
        $voucherEntries = is_string($voucherDecoded) ? json_decode($voucherDecoded, true) : $voucherDecoded;

        if (!is_array($voucherEntries)) continue;

        // SALES VOUCHERS
        if ($voucher->voucher_type === 'Sales') {
            foreach ($voucherEntries as $entry) {
                $fromName = $users[$entry['from_account']] ?? $entry['from_account'];
                $toName   = $users[$entry['to_account']]   ?? $entry['to_account'];
                $amount   = $entry['amount'];
                $date     = $voucher->voucher_date;

                $label = "Sales - {$fromName} → {$toName} ({$date}) → ₹{$amount}";

                $sales[$label] = [
                    'customer_name' => $toName,
                    'invoice_date' => $date,
                    'amount' => (float) $amount,
                    'received' => 0,
                ];
            }
        }

        // RECEIPT VOUCHERS
        if ($voucher->voucher_type === 'Receipt') {
            foreach ($voucherEntries as $entry) {
                if (!empty($entry['sales_voucher']) && is_array($entry['sales_voucher'])) {
                    foreach ($entry['sales_voucher'] as $linkedSale) {
                        $label = $linkedSale['label'];

                        if (isset($sales[$label])) {
                            $sales[$label]['received'] += (float) $entry['amount'];
                        }
                    }
                }
            }
        }
    }

    $report = [];
    foreach ($sales as $label => $sale) {
        $report[] = [
             'label' => $label,
            'customer_name' => $sale['customer_name'],
            'invoice_date' => \Carbon\Carbon::parse($sale['invoice_date'])->format('d/m/Y'),
            'amount' => $sale['amount'],
            'received' => $sale['received'],
            'pending' => $sale['amount'] - $sale['received'],
        ];
    }

    // ✅ Check final output here
    // dd($report);

    return view('admin.accounts_receivable.index', compact('report'));
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

        if ($voucher->voucher_type === 'Sales') {
            foreach ($voucherEntries as $entry) {
                $fromName = $users[$entry['from_account']] ?? $entry['from_account'];
                $toName   = $users[$entry['to_account']] ?? $entry['to_account'];
                $amount   = $entry['amount'];
                $date     = $voucher->voucher_date;

                $thisLabel = "Sales - {$fromName} → {$toName} ({$date}) → ₹{$amount}";

                if ($thisLabel === $label) {
                    $entries[] = [
                        'type' => 'Sales',
                        'customer_name' => $toName,
                        'date' => $date,
                        'amount' => (float) $amount,
                        'received' => 0,
                    ];
                }
            }
        }

        if ($voucher->voucher_type === 'Receipt') {
            foreach ($voucherEntries as $entry) {
                if (!empty($entry['sales_voucher']) && is_array($entry['sales_voucher'])) {
                    foreach ($entry['sales_voucher'] as $linkedSale) {
                        if ($linkedSale['label'] === $label) {
                            $toName = $users[$entry['to_account']] ?? $entry['to_account'];
                            $entries[] = [
                                'type' => 'Receipt',
                                'customer_name' => $toName,
                                'date' => $voucher->voucher_date,
                                'amount' => (float) $entry['amount'],
                                'received' => (float) $entry['amount'],
                            ];
                        }
                    }
                }
            }
        }
    }

    return view('admin.accounts_receivable.show', compact('entries', 'label'));
}


}
  

 
