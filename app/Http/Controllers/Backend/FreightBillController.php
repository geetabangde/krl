<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\FreightBill;
use App\Models\Destination;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use Illuminate\Support\Arr;
use App\Models\User;
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




public function destroy($id)
{
    try {
        $freightBill = FreightBill::findOrFail($id);
        $freightBill->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Freight bill deleted successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error while deleting the entry.'
        ], 500);
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

    // अब JSON encode कर के स्टोर करें ताकि DB में string हो, array नहीं
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

                    $matchedEntries[] = $lrDetail;
                }
            }
        }
        // Pick the first order from loop for header display (or use anchor->order)
        $firstOrder = Order::where('order_id', $orderIds[0] ?? null)->first();


        return view('admin.freight-bill.view', [
            'freightBill'    => $anchor,
            'matchedEntries' => $matchedEntries,
            'order'          => $firstOrder,
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
    
    // नया update method
    public function update(Request $request, $freight_bill_number)
    {
        $data = $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);

        // सभी रिकॉर्ड्स में same notes अपडेट कर देते हैं
        FreightBill::where('freight_bill_number', $freight_bill_number)
                   ->update(['notes' => $data['notes']]);

        return redirect()
            ->route('admin.freight-bill.edit', $freight_bill_number)
            ->with('success', 'Notes updated successfully.');
    }


}