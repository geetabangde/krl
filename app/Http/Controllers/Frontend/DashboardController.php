<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Destination;
use App\Models\Order;
use App\Models\PackageType;
use App\Models\VehicleType;
use App\Models\Vehicle;
use App\Models\FreightBill;
use App\Models\Settings;

 use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Show dashboard to logged-in user
 public function dashboard()
{
    $user = Auth::user();

    $orders = Order::with(['fromDestination', 'toDestination'])
        ->where('customer_id', $user->id)
        ->latest()
        ->get();

    $ordersCount = Order::where('customer_id', $user->id)->count();

   $processingCount = Order::where('customer_id', $user->id)
    ->where('status', '"Processing"')
    ->count();

$completedCount = Order::where('customer_id', $user->id)
    ->where('status', '"Delivered"')
    ->count();

    $totalLrCount = 0;  // Initialize counter

    foreach ($orders as $order) {
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
    }

    return view('frontend.dashboard', compact(
        'user',
        'orders',
        'ordersCount',
        'processingCount',
        'completedCount',
        'totalLrCount'
    ));
}

    public function profile()
    {
       
        $user = Auth()->user();
        return view('frontend.profile', compact('user'));
    }

    public function updateProfile(Request $request)
   {   
        // return ($request->all());

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'pan_number' => $request->pan_number,
            'tan_number' => $request->tan_number,
            'address' => $request->address, 
        ]);

        return back()->with('success', 'Profile updated successfully');
   }
   
   public function OrderDetails($order_id)
  {
    $order = Order::with('user')->where('order_id', $order_id)->first();
   
    // $freightBill = FreightBill::where('order_id', $order_id)->get();
   $freightBill = DB::table('freight_bill')
    ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(order_id), '$[0]')) = ?", [$order_id])
    ->get();
       $destination = Destination::all();
    if (!$order) {
        return back()->with('error', 'Order not found.');
    }


    return view('frontend.order-details', compact('order','destination','freightBill'));
  }
public function lrDetails($lr_number)
{
    $orders = DB::table('orders')->get();
   

    foreach ($orders as $order) {
        $lrData = json_decode($order->lr, true);
      
       
        if (!is_array($lrData)) {
            $lrData = json_decode(json_decode($order->lr), true);
        }

       

        if (is_array($lrData)) {
            foreach ($lrData as $entry) {
                if (isset($entry['lr_number']) && $entry['lr_number'] == $lr_number) {
                    $lrEntries = $entry;

                    $vehicles = Vehicle::all();
                    $users = User::all();
                   $packageTypes =PackageType::all()->pluck('package_type', 'id')->toArray();

                    return view('frontend.lr-details', compact('packageTypes','orders', 'order', 'lrEntries', 'vehicles', 'users'));
                }
            }
        }
         

    }

    return redirect()->back()->with('error', 'LR Number not found.');
}

public function fbDetails($order_id, $id)
    {   
        $anchor = FreightBill::findOrFail($id);

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
        
      

        return view('frontend.fb-details', [
            'freightBill'    => $anchor,
            'matchedEntries' => $matchedEntries,
            'order'          => $firstOrder,
            'totals'         => $totals,
        ]);
       
    }
   
    public function invDetails($id)
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

   
    return view('frontend.inv-details', compact('freightBill', 'settings', 'totals','customerDetails','deliveryAddress','lrNumbers','ewayBillsByLR','matchedEntries'));
  }

 }