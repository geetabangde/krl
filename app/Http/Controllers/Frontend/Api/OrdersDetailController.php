<?php

namespace App\Http\Controllers\Frontend\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\PackageType;
use App\Models\Destination;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\FreightBill;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;


class OrdersDetailController extends Controller
{
public function ordersDashboard()
{
    $user = auth()->user();

    $orders = Order::where('customer_id', $user->id)->get();

    $totalOrders = $orders->count();
    $totalLrCount = 0;
    $freightBillCount = 0;
    $invoiceCount = 0;

    foreach ($orders as $order) {
        // --- Count LRs ---
        if (!empty($order->lr)) {
            $lrData = is_string($order->lr) ? json_decode($order->lr, true) : $order->lr;

            if (is_array($lrData)) {
                foreach ($lrData as $lr) {
                    if (isset($lr['lr_number'])) {
                        $totalLrCount++;
                    }
                }
            }
        }

        // --- Count Freight Bills ---
        $freightBills = DB::table('freight_bill')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order->order_id])
            ->get();

        $freightBillCount += $freightBills->count();

        // --- Count Invoices ---
        $fIDs = $freightBills->pluck('id');

        if (!$fIDs->isEmpty()) {
            $invoiceCount += DB::table('invoices')
                ->whereIn('freight_bill_id', $fIDs)
                ->count();
        }
    }

    return response()->json([
        'status' => true,
        'message' => ' Total Order details fetched successfully.',
        'total_orders' => $totalOrders,
        'total_lrs' => $totalLrCount,
        'total_freight_bills' => $freightBillCount,
        'total_invoices' => $invoiceCount,
    ]);
}
public function createOrder(Request $request)
{
   
    $lastId = Order::max('id') + 1;
    $generatedOrderId = 'ORD-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);

    $order = new Order();
    $order->description = $request->description;
    $order->order_id = $generatedOrderId;
    $order->customer_id = $request->user_id;
    $order->from_destination_id = $request->from_destination_id;
    $order->to_destination_id = $request->to_destination_id;
    $order->order_date = $request->order_date;
    $order->status = $request->status;
    $order->save();

    return response()->json([
        'success' => true,
        'message' => 'Order created successfully!',
        'data' => $order
    ], 201);
}
 public function order()
{
    $user = Auth::user();

$orders = Order::with('user')
    ->where('customer_id', $user->id)
    ->orderBy('created_at', 'desc') 
    ->get();
    if ($orders->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No orders found',
        ]);
    }

    return response()->json([
        'status' => true,
        'orders' => $orders
    ]);
}

// public function orderDetail($order_id)
// {
//     $user = Auth::user();

   
//     $freightBill = [];
//     $invoice = null;
//     $lrNumbers = [];
//     $urlslr = [];
//     $urlsfb = [];
//     $urlsinv = [];

//     $order = Order::where('order_id', $order_id)->first();

//     if ($order) {
//         // Get Freight Bills
//         $freightBill = DB::table('freight_bill')
//             ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order_id])
//             ->get();

//         $fIDs = DB::table('freight_bill')
//             ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order_id])
//             ->pluck('id');

//         // Get Invoice if Freight Bill IDs exist
//         if (!$fIDs->isEmpty()) {
//             $invoice = DB::table('invoices')->whereIn('freight_bill_id', $fIDs)->first();

//             foreach ($fIDs as $id) {
//                 $urlsfb[] = "https://delivron.in/user/fb-details/{$order_id}/{$id}";
//                  // $urlsfb[] = url("/user/fb-details/{$order_id}/{$id}");
//                 $urlsinv[] = "https://delivron.in/user/invoice-details/{$id}";
//                   //  $urlsinv[] = url("/user/invoice-details/{$id}");

//             }
//         }

//         // Get LR Details
//         if (!empty($order->lr)) {
//             $lrData = $order->lr;

//             if (is_string($lrData)) {
//                 $lrData = json_decode($lrData, true);
//             }

//             if (is_array($lrData)) {
//                 foreach ($lrData as $lr) {
//                     if (isset($lr['lr_number'])) {
//                         $lrNumber = $lr['lr_number'];
//                         $lrNumbers[] = $lrNumber;
//                         $urlslr[] = "https://delivron.in/user/lr-details/{$lrNumber}";
//                          // $urlslr[] = url("/user/lr-details/{$lrNumber}");
//                     }
//                 }
//             }
//         }
//     }

//     return response()->json([
//         'status' => true,
//         'message' => 'Order details fetched successfully.',
//         'order' => $order,
//         'lr_numbers' => $lrNumbers,
//         'freightBill' => $freightBill,
//         'invoice' => $invoice,
//         'lr_urls' => $urlslr,
//         'fb_urls' => $urlsfb,
//         'inv_urls' => $urlsinv,
//     ]);
// }
public function orderDetail($order_id)
{
    $user = Auth::user();

    $freightBill = [];
    $invoice = null;
    $lrNumbers = [];
    $urlslr = [];
    $urlsfb = [];
    $urlsinv = [];

    $order = Order::where('order_id', $order_id)->first();

    if ($order) {
        // Get Freight Bills
        $freightBill = DB::table('freight_bill')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order_id])
            ->get();

        $fIDs = DB::table('freight_bill')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order_id])
            ->pluck('id');

        // Get Invoice if Freight Bill IDs exist
        if (!$fIDs->isEmpty()) {
            $invoice = DB::table('invoices')->whereIn('freight_bill_id', $fIDs)->first();

            foreach ($fIDs as $id) {
                $urlsfb[] = "https://delivron.in/user/fb-details/{$order_id}/{$id}";
                $urlsinv[] = "https://delivron.in/user/invoice-details/{$id}";
            }
        }

        // Get LR Details
        if (!empty($order->lr)) {
            $lrData = $order->lr;

            if (is_string($lrData)) {
                $lrData = json_decode($lrData, true);
            }

            if (is_array($lrData)) {
                foreach ($lrData as $key => &$lr) {
                    // Replace from_location ID with destination name
                    if (!empty($lr['from_location'])) {
                        $fromDest = Destination::find($lr['from_location']);
                        $lr['from_location'] = $fromDest ? $fromDest->destination : null;
                    }

                   
                    if (!empty($lr['to_location'])) {
                        $toDest = Destination::find($lr['to_location']);
                        $lr['to_location'] = $toDest ? $toDest->destination : null;
                    }

                    // Save LR number and URL
                    if (isset($lr['lr_number'])) {
                        $lrNumber = $lr['lr_number'];
                        $lrNumbers[] = $lrNumber;
                        $urlslr[] = "https://delivron.in/user/lr-details/{$lrNumber}";
                    }
                }

                // Set updated LR data back to order
                $order->lr = $lrData;
            }
        }
    }

    return response()->json([
        'status' => true,
        'message' => 'Order details fetched successfully.',
        'order' => $order,
        'lr_numbers' => $lrNumbers,
        'freightBill' => $freightBill,
        'invoice' => $invoice,
        'lr_urls' => $urlslr,
        'fb_urls' => $urlsfb,
        'inv_urls' => $urlsinv,
    ]);
}


public function getLrDetails($lr_number)
{
    $orders = DB::table('orders')->get();
   

    foreach ($orders as $order) {
        $lrData = json_decode($order->lr, true);
      
       
        if (!is_array($lrData)) {
            $lrData = json_decode(json_decode($order->lr), true);
        }

       if (!$lrData) {
        return response()->json([
            'status' => false,
            'message' => 'lr not found.'
        ], 404);
    }

        if (is_array($lrData)) {
            foreach ($lrData as $entry) {
                if (isset($entry['lr_number']) && $entry['lr_number'] == $lr_number) {
                    $lrEntries = $entry;

                    $vehicles = Vehicle::all();
                    $users = User::all();
                   $packageTypes =PackageType::all()->pluck('package_type', 'id')->toArray();

                  
                     return response()->json([
                            'status' => true,
                            'message' => 'lr details fetched successfully.',
                            'data' => [
                                'packageTypes'    => $packageTypes,
                                'orders' => $orders,
                                'order'          => $order,
                                'lrEntries'         => $lrEntries,
                                'users'         => $users,
                                'vehicles'         => $vehicles,
                            ]
                        ], 200);
                }
            }
        }
         

    }

    
     return response()->json([
            'status' => false,
            'message' => 'LR Number not found.'
        ], 404);
}
public function getfbDetails($order_id, $id)
    {   
       
        $anchor = FreightBill::findOrFail($id);
   if (!$anchor) {
        return response()->json([
            'status' => false,
            'message' => 'Freight Bill not found.'
        ], 404);
    }
        $orderIds = json_decode($anchor->order_id, true);
        $lrNumbers = json_decode($anchor->lr_number, true);

       
        $vehicleTypes = VehicleType::pluck('vehicletype', 'id');

        $matchedEntries = [];

        foreach ($orderIds as $orderId) {
            $order = Order::where('order_id', $order_id)->first();
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

        $firstOrder = Order::where('order_id', $orderIds[0] ?? null)->first();

      
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
        
         return response()->json([
        'status' => true,
        'message' => 'Freight Bill details fetched successfully.',
        'data' => [
            'freightBill'    => $anchor,
            'matchedEntries' => $matchedEntries,
            'order'          => $firstOrder,
            'totals'         => $totals,
        ]
    ], 200);
       
    }
  public function getInvDetails($id)
   {
    $freightBill = FreightBill::with('invoice')->findOrFail($id);
   if (!$freightBill) {
        return response()->json([
            'status' => false,
            'message' => 'Freight Bill not found.'
        ], 404);
    }

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
  return response()->json([
        'status' => true,
        'message' => 'Invoice details fetched successfully.',
        'data' => [
            'freightBill'      => $freightBill,
            'settings'         => $settings,
            'totals'           => $totals,
            'customerDetails'  => $customerDetails,
            'pickupAddress'    => $pickupAddress,
            'deliveryAddress'  => $deliveryAddress,
            'lrNumbers'        => $lrNumbers,
            'ewayBillsByLR'    => $ewayBillsByLR,
            'matchedEntries'   => $matchedEntries,
        ]
    ]);
    }


public function getrequestLR(Request $request)
{
    $request->validate([
        'order_id' => 'required'
    ]);

    $order_id = $request->order_id;
    $order = Order::where('order_id', $order_id)->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found.'
        ], 404);
    }

   
    if (empty($order->lr)) {
        $order->status = 'Request-lr';
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'LR request submitted successfully.',
            'status' => $order->status,
        ]);
    }

  
    return response()->json([
        'success' => false,
        'message' => 'LR already exists for this order.',
    ]);
}

// public function getrequestFB(Request $request){
//   $request->validate([
//         'order_id' => 'required'

//     ]);
//      $order_id= $request->order_id;
//       $order = Order::where('order_id', $order_id)->first();
     
//     if (!$order) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Order not found.'
//         ], 404);
//     }
    
   
//      $order->status ='Request-freeghtBill';
//     $order->save();

//     return response()->json([
//         'success' => true,
//         'message' => 'Status updated successfully.',
//         'status' => $order->status,
    
//     ]); 

// }

public function getrequestFB(Request $request)
{
    $request->validate([
        'order_id' => 'required'
    ]);

    $order_id = $request->order_id;
    $order = Order::where('order_id', $order_id)->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found.'
        ], 404);
    }

    
         $freightBill = DB::table('freight_bill')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order_id])
            ->get();

// return $freightBill;
    if ($freightBill->isEmpty()) {
        $order->status = 'Request-freeghtBill';
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Freight Bill request submitted successfully.',
            'status' => $order->status,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Freight bill already exists for this order.',
    ]);
}

// public function getrequestINV(Request $request){
//   $request->validate([
//         'order_id' => 'required'

//     ]);
//      $order_id= $request->order_id;
//       $order = Order::where('order_id', $order_id)->first();
//     if (!$order) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Order not found.'
//         ], 404);
//     }

//     $order->status ='Request-invioce';
//     $order->save();

//     return response()->json([
//         'success' => true,
//         'message' => 'Status updated successfully.',
//         'status' => $order->status,
//     ]);

// }
public function getrequestINV(Request $request)
{
    $request->validate([
        'order_id' => 'required'
    ]);

    $order_id = $request->order_id;
    $order = Order::where('order_id', $order_id)->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found.'
        ], 404);
    }

    
    $fIDs = DB::table('freight_bill')
        ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order_id])
        ->pluck('id');

      if ($fIDs->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Freight bill not found for this order.'
        ]);
    }

        $invoice = DB::table('invoices')
        ->whereIn('freight_bill_id', $fIDs)
        ->first();

   
    if ($invoice) {
        return response()->json([
            'success' => false,
            'message' => 'Invoice already exists for this order.'
        ]);
    }

       $order->status = 'Request-invoice';
    $order->save();

    return response()->json([
        'success' => true,
        'message' => 'Invoice request submitted successfully.',
        'status' => $order->status,
    ]);
}

public function destination(){
 $destination=Destination::all();    
  return response()->json([
        'success' => true,
        'message' => 'Status updated successfully.',
        'destination' =>$destination,
    ]);

}
public function getStatusList()
    {
        $statuses = [
            'Pending',
            'Processing',
            'Completed',
            'Cancelled',
        ];

        return response()->json([
            'statuses' => $statuses
        ]);
    }
}