<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\FreightBill;
use App\Models\Destination;
use App\Models\VehicleType;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class FreightBillController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage freight_bill', only: ['index']),
            new Middleware('admin.permission:create freight_bill', only: ['create']),
            new Middleware('admin.permission:edit freight_bill', only: ['edit']),
            new Middleware('admin.permission:delete freight_bill', only: ['destroy']),
        ];
    }

public function index()
{
   $bills = FreightBill::with('order')->get()
               ->groupBy('freight_bill_number');
            //    dd($bills);

    return view('admin.freight-bill.index', compact('bills'));
}

public function edit(Request $request, $id)
{
    
      $anchor = FreightBill::findOrFail($id);
      

        $orderIds = json_decode($anchor->order_id, true);
        $lrNumbers = json_decode($anchor->lr_number, true);

       
        $vehicleTypes = VehicleType::pluck('vehicletype', 'id');

        $matchedEntries = [];

        foreach ($orderIds as $orderId) {
            $order = Order::where('order_id', $orderId)->first();
            if (!$order) continue;

            $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);

            foreach ($lrs as $lrDetail) {
                if (in_array($lrDetail['lr_number'], $lrNumbers)) {
                    $lrDetail['from_destination'] = Destination::find($lrDetail['from_location'])->destination ?? '-';
                    $lrDetail['to_destination']   = Destination::find($lrDetail['to_location'])->destination ?? '-';
                    $lrDetail['freight_type']     = $order->order_method ?? '-';

                    
                    $vehicleTypeId = $lrDetail['vehicle_type'] ?? null;
                    $lrDetail['vehicletype'] = $vehicleTypes[$vehicleTypeId] ?? '-';

                    



                    $matchedEntries[] = $lrDetail;
                }
            }
        }
        // Pick the first order from loop for header display (or use anchor->order)
        $firstOrder = Order::where('order_id', $orderIds[0] ?? null)->first();

       // ✅ Totals Calculation
        $totals = [
            'lr_charges'       => 0,
            'hamali'           => 0,
            'other_charges'    => 0,
            'freight_amount'   => 0,
            'less_advance'     => 0,
            'balance_freight'  => 0,
        ];

        foreach ($matchedEntries as $entry) {
            $totals['lr_charges']      += floatval($entry['lr_charges'] ?? 0);
            $totals['hamali']          += floatval($entry['hamali'] ?? 0);
            $totals['other_charges']   += floatval($entry['other_charges'] ?? 0);
            $totals['freight_amount']  += floatval($entry['freight_amount'] ?? 0);
            $totals['less_advance']    += floatval($entry['less_advance'] ?? 0);
            $totals['balance_freight'] += floatval($entry['balance_freight'] ?? 0);
        }

        $totals['taxable_amount'] = $totals['freight_amount'] + $totals['lr_charges'] + $totals['hamali'] + $totals['other_charges'];
        $totals['gst_amount']     = round($totals['taxable_amount'] * 0.12, 2);
        $totals['total_amount']   = $totals['taxable_amount'] + $totals['gst_amount'];
        
   


        return view('admin.freight-bill.edit', [
            'freightBill'    => $anchor,
            'matchedEntries' => $matchedEntries,
            'order'          => $firstOrder,
            'totals'         => $totals,
        ]);
}

public function updateEntry(Request $request, $id)
{
    $validated = $request->validate([
        'field' => 'required|string',
        'value' => 'required|numeric',
    ]);

    $freightBill = FreightBill::findOrFail($id);
    $orderIds = json_decode($freightBill->order_id, true);

    foreach ($orderIds as $orderId) {
        $order = Order::where('order_id', $orderId)->first();
        if (!$order) continue;

        $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);

        // Match by LR number (id replaced with lr_number now)
        foreach ($lrs as &$lr) {
            if ($lr['lr_number'] == $request->input('entry_id')) {
                $lr[$validated['field']] = $validated['value'];
            }
        }

        $order->lr = json_encode($lrs);
        $order->save();
    }

    // Recalculate totals after update
    $updatedTotals = $this->recalculateTotals($freightBill->id);

    return response()->json(['success' => true, 'updated_totals' => $updatedTotals]);
}

public function updateTotals(Request $request, $id)
{
    $validated = $request->validate([
        'field' => 'required|string',
        'value' => 'required|numeric',
    ]);

    $freightBill = FreightBill::findOrFail($id);
    $freightBill->{$validated['field']} = $validated['value'];
    $freightBill->save();

    $updatedTotals = $this->recalculateTotals($id);

    return response()->json(['success' => true, 'updated_totals' => $updatedTotals]);
}

private function recalculateTotals($freightBillId)
{
    $freightBill = FreightBill::findOrFail($freightBillId);
    $orderIds = json_decode($freightBill->order_id, true);
    $freightAmount = 0;

    foreach ($orderIds as $orderId) {
        $order = Order::where('order_id', $orderId)->first();
        if (!$order) continue;

        $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
        foreach ($lrs as $lr) {
            $freightAmount += $lr['freight_amount'] ?? 0;
        }
    }

    $taxableAmount = $freightAmount + $freightBill->lr_charges + $freightBill->hamali + $freightBill->other_charges;
    $gstAmount = round($taxableAmount * 0.12, 2);
    $totalAmount = $taxableAmount + $gstAmount - $freightBill->less_advance;

    $freightBill->freight_amount = $freightAmount;
    $freightBill->taxable_amount = $taxableAmount;
    $freightBill->gst_amount = $gstAmount;
    $freightBill->total_amount = $totalAmount;
    $freightBill->save();

    return [
        'freight_amount' => $freightAmount,
        'taxable_amount' => $taxableAmount,
        'gst_amount' => $gstAmount,
        'total_amount' => $totalAmount,
    ];
}






public function destroy($id)
{
    try {
        $freightBill = FreightBill::where('freight_bill_number', $id)->firstOrFail();
        $freightBill->delete();

        return redirect()->back()->with('success', 'Freight bill deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error while deleting the entry.');
    }
}




 public function store(Request $request)
{
    $selectedLrs = json_decode($request->input('selected_lrs'), true);

    if (!$selectedLrs || !is_array($selectedLrs)) {
        return back()->with('error', 'No LR selected.');
    }

    $freightBillNumber = 'FB' . now()->format('Ymd') . '-' . str_pad(FreightBill::count() + 1, 3, '0', STR_PAD_LEFT);

    $orderIds = [];
    $lrNumbers = [];

    foreach ($selectedLrs as $item) {
        $order = Order::where('order_id', $item['order_id'])->first();
        if (!$order) continue;

        $lrArray = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);

        $matchedLr = collect($lrArray)->firstWhere('lr_number', $item['lr_number']);

        if ($matchedLr) {
            $orderIds[] = $item['order_id'];
            $lrNumbers[] = $matchedLr['lr_number'];
        }
    }

    $orderIds = array_values(array_unique($orderIds));
    $lrNumbers = array_values(array_unique($lrNumbers));

    
    $freightBill = FreightBill::create([
        'order_id' => json_encode($orderIds),     // encode to string
        'freight_bill_number' => $freightBillNumber,
        'lr_number' => json_encode($lrNumbers),   // encode to string
        'notes' => null,
    ]);

    return redirect()->route('admin.freight-bill.view', $freightBill->id)
        ->with('success', 'Freight bill generated successfully.');
}


    public function show(Request $request, $id)
    {   
        $anchor = FreightBill::findOrFail($id);

        $orderIds = json_decode($anchor->order_id, true);
        $lrNumbers = json_decode($anchor->lr_number, true);

        // ✅ Load all vehicle types as [id => name]
        $vehicleTypes = VehicleType::pluck('vehicletype', 'id');

        $matchedEntries = [];

        foreach ($orderIds as $orderId) {
            $order = Order::where('order_id', $orderId)->first();
            if (!$order) continue;

            $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);

            foreach ($lrs as $lrDetail) {
                if (in_array($lrDetail['lr_number'], $lrNumbers)) {
                    $lrDetail['from_destination'] = Destination::find($lrDetail['from_location'])->destination ?? '-';
                    $lrDetail['to_destination']   = Destination::find($lrDetail['to_location'])->destination ?? '-';
                    $lrDetail['freight_type']     = $order->order_method ?? '-';

                    
                    $vehicleTypeId = $lrDetail['vehicle_type'] ?? null;
                    $lrDetail['vehicletype'] = $vehicleTypes[$vehicleTypeId] ?? '-';

                    $matchedEntries[] = $lrDetail;
                }
            }
        }
        // Pick the first order from loop for header display (or use anchor->order)
        $firstOrder = Order::where('order_id', $orderIds[0] ?? null)->first();

       // ✅ Totals Calculation
        $totals = [
            'lr_charges'       => 0,
            'hamali'           => 0,
            'other_charges'    => 0,
            'freight_amount'   => 0,
            'less_advance'     => 0,
            'balance_freight'  => 0,
        ];

        foreach ($matchedEntries as $entry) {
            $totals['lr_charges']      += floatval($entry['lr_charges'] ?? 0);
            $totals['hamali']          += floatval($entry['hamali'] ?? 0);
            $totals['other_charges']   += floatval($entry['other_charges'] ?? 0);
            $totals['freight_amount']  += floatval($entry['freight_amount'] ?? 0);
            $totals['less_advance']    += floatval($entry['less_advance'] ?? 0);
            $totals['balance_freight'] += floatval($entry['balance_freight'] ?? 0);
        }

        $totals['taxable_amount'] = $totals['freight_amount'] + $totals['lr_charges'] + $totals['hamali'] + $totals['other_charges'];
        $totals['gst_amount']     = round($totals['taxable_amount'] * 0.12, 2);
        $totals['total_amount']   = $totals['taxable_amount'] + $totals['gst_amount'];
        
        //  dd($matchedEntries);

        return view('admin.freight-bill.view', [
            'freightBill'    => $anchor,
            'matchedEntries' => $matchedEntries,
            'order'          => $firstOrder,
            'totals'         => $totals,
        ]);
       
    }

    
    public function editByNumber($freight_bill_number)
    {
        $freightBills = FreightBill::where('freight_bill_number', $freight_bill_number)->get();
    
        if ($freightBills->isEmpty()) {
            abort(404, 'Freight Bill not found.');
        }
    
        $matchedEntries = [];
    
        foreach ($freightBills as $freightBill) {
            $order = Order::where('order_id', $freightBill->order_id)->first();
    
            if ($order) {
                $matchedEntries[] = [
                    'lr_number' => $freightBill->lr_number,
                    'lr_date' => $order->order_date,
                    'destination' => $order->from . ' - ' . $order->to,
                    'freight_type' => $order->order_method,
                    'rate' => $freightBill->rate ?? '-',
                    'amount' => $freightBill->amount ?? '-',
                    'cargo' => [
                        [
                            'package_description' => $order->description ?? '-',
                            'weight' => $freightBill->weight ?? '-',
                        ]
                    ]
                ];
            }
        }
    
        // Optionally send first order if needed
        $firstOrder = Order::where('order_id', $freightBills->first()->order_id)->first();
    
        return view('admin.freight-bill.edit', [
            'freightBillNumber' => $freight_bill_number,
            'order' => $firstOrder, // optional
            'matchedEntries' => $matchedEntries
        ]);
    }
    
    
    public function update(Request $request, $freight_bill_number)
    {
        $data = $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);
        FreightBill::where('freight_bill_number', $freight_bill_number)
                   ->update(['notes' => $data['notes']]);

        return redirect()
            ->route('admin.freight-bill.edit', $freight_bill_number)
            ->with('success', 'Notes updated successfully.');
    }
    
    public function Invoice()
{
    $invoices = FreightBill::orderBy('id', 'desc')->get(); // Using get() to manually handle pagination if needed

    $invoiceData = $invoices->map(function ($freightBill) {
        $orderIds = json_decode($freightBill->order_id, true);
        $lrNumbers = json_decode($freightBill->lr_number, true);

        $totals = [
            'freight_amount' => 0,
            'lr_charges' => 0,
            'hamali' => 0,
            'other_charges' => 0,
        ];

        foreach ($orderIds as $orderId) {
            $order = \App\Models\Order::where('order_id', $orderId)->first();
            if (!$order) continue;

            $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
            foreach ($lrs as $lr) {
                if (in_array($lr['lr_number'], $lrNumbers)) {
                    $totals['freight_amount'] += floatval($lr['freight_amount'] ?? 0);
                    $totals['lr_charges'] += floatval($lr['lr_charges'] ?? 0);
                    $totals['hamali'] += floatval($lr['hamali'] ?? 0);
                    $totals['other_charges'] += floatval($lr['other_charges'] ?? 0);
                }
            }
        }

        $taxable = $totals['freight_amount'] + $totals['lr_charges'] + $totals['hamali'] + $totals['other_charges'];
        $gst = round($taxable * 0.12, 2);
        $total = $taxable + $gst;

        return [
            'freightBill' => $freightBill,
            'taxable'     => $taxable,
            'gst'         => $gst,
            'total'       => $total,
        ];
    });

    return view('admin.freight-bill.invoice', compact('invoiceData'));
}

    

    public function InvoiceView($id)
   {
    $freightBill = FreightBill::with('invoice')->findOrFail($id);
   

    $settings = Settings::select('transporter', 'head_office', 'mobile', 'offices', 'email')->first();

    $orderIds = json_decode($freightBill->order_id, true);
    $lrNumbers = json_decode($freightBill->lr_number, true);

    $vehicleTypes = VehicleType::pluck('vehicletype', 'id');

    $matchedEntries = [];
    $customerDetails = null; 
    $pickupAddress = null;
    $deliveryAddress = null;
    $matchedLRNumbers = [];

    // eway bills by LR number
    $ewayBillsByLR = [];
    


    foreach ($orderIds as $orderId) {
       $order = Order::with('customer')->where('order_id', $orderId)->first();
       


        if (!$order) continue;

        if ($customerDetails === null && $order->customer) {
            $customerDetails = [
                'customer_id'      => $order->customer->id,
                'customer_name'    => $order->customer->name,
                'customer_gst'     => $order->customer->gst,
                'customer_address' => $order->customer->address,
            ];
        }
        // dd($customerDetails);
       
       
        if ($pickupAddress === null && $order->pickup_addresss) {
            $pickupAddress = $order->pickup_addresss;
        }

        // Set delivery address once
        if ($deliveryAddress === null && $order->deleiver_addresss) {
            $deliveryAddress = $order->deleiver_addresss;
        }



        $lrs = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);

        foreach ($lrs as $lrDetail) {
            if (in_array($lrDetail['lr_number'], $lrNumbers)) {
                $lrDetail['from_destination'] = Destination::find($lrDetail['from_location'])->destination ?? '-';
                $lrDetail['to_destination']   = Destination::find($lrDetail['to_location'])->destination ?? '-';
                $lrDetail['freight_type']     = $order->order_method ?? '-';

                $vehicleTypeId = $lrDetail['vehicle_type'] ?? null;
                $lrDetail['vehicletype'] = $vehicleTypes[$vehicleTypeId] ?? '-';

                // Collect eway bills from cargo array
                $ewayBills = [];
                if (!empty($lrDetail['cargo']) && is_array($lrDetail['cargo'])) {
                    foreach ($lrDetail['cargo'] as $cargoItem) {
                        if (!empty($cargoItem['eway_bill'])) {
                            $ewayBills[] = $cargoItem['eway_bill'];
                        }
                    }
                }

                // Assign eway bills array to lrDetail for view
                $lrDetail['eway_bills'] = $ewayBills;

                $matchedEntries[] = $lrDetail;

                 // Store eway bills by LR number (optional, if you want a separate array)
                $ewayBillsByLR[$lrDetail['lr_number']] = $ewayBills;
            }
        }
    }

    // Totals
    $totals = [
        'lr_charges'       => 0,
        'hamali'           => 0,
        'other_charges'    => 0,
        'freight_amount'   => 0,
        'less_advance'     => 0,
        'balance_freight'  => 0,
    ];

    foreach ($matchedEntries as $entry) {
        $totals['lr_charges']      += floatval($entry['lr_charges'] ?? 0);
        $totals['hamali']          += floatval($entry['hamali'] ?? 0);
        $totals['other_charges']   += floatval($entry['other_charges'] ?? 0);
        $totals['freight_amount']  += floatval($entry['freight_amount'] ?? 0);
        $totals['less_advance']    += floatval($entry['less_advance'] ?? 0);
        $totals['balance_freight'] += floatval($entry['balance_freight'] ?? 0);
    }

    $totals['taxable_amount'] = $totals['freight_amount'] + $totals['lr_charges'] + $totals['hamali'] + $totals['other_charges'];
    $totals['gst_amount']     = round($totals['taxable_amount'] * 0.12, 2);
    $totals['total_amount']   = $totals['taxable_amount'] + $totals['gst_amount'];

    // dd($freightBill);

    return view('admin.freight-bill.invoice-view', compact('freightBill', 'settings', 'totals','customerDetails','deliveryAddress','lrNumbers','ewayBillsByLR','matchedEntries'));
  }



   

    public function generateInvoice($id)
    {
        $freightBill = FreightBill::findOrFail($id);
        

        // Check if invoice already exists for this freight bill
        if ($freightBill->invoice) {
            return redirect()->back()->with('info', 'Invoice already generated.');
        }

        // Generate unique invoice number
        $datePrefix = now()->format('Ymd');
        $invoiceNumber = 'INV-' . $datePrefix . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);

        // Create invoice entry
        Invoice::create([
            'freight_bill_id' => $freightBill->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => now(),
        ]);

        return redirect()->route('admin.freight-bill.invoice-view', ['id' => $freightBill->id])
                        ->with('success', 'Invoice generated successfully.');
    }



}