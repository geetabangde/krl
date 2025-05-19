<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\Destination;
use App\Models\PackageType;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class ConsignmentNoteController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage lr_consignment', only: ['index']),
            new Middleware('admin.permission:create lr_consignment', only: ['create']),
            new Middleware('admin.permission:edit lr_consignment', only: ['edit']),
            new Middleware('admin.permission:delete lr_consignment', only: ['destroy']),
        ];
    }
   public function index(){
    $orders = Order::latest()->get();

    return view('admin.consignments.index', compact('orders'));
   }

   public function create()
   {
   
    $vehicles = Vehicle::all();
    $vehiclesType = VehicleType::all();
    $destination = Destination::all();
    $package = PackageType::all();
    $users = User::all();
    return view('admin.consignments.create', compact('vehicles','users','vehiclesType','destination','package'));
    }
    
    
     public function edit($order_id)
    {
        $order = Order::with(['consignor', 'consignee'])->where('order_id', $order_id)->firstOrFail();
        $vehicles = Vehicle::all();
        $users = User::all();
        $vehiclesType = VehicleType::all();
        $destination = Destination::all();
        $package = PackageType::all();
        $lrEntries = Order::where('order_id', $order->order_id)
                        ->where('order_date', '!=', $order->order_date) 
                        ->get();
       
        return view('admin.consignments.edit', compact('order', 'lrEntries','vehicles','users','vehiclesType','destination','package'));
    }


    
    public function store(Request $request)
    {
        $order = new Order();
    
        // Generate unique order ID


        $order->order_id = 'ORD-' . time();
        $order->order_method = 'order';
        $order->byorder = $request->byOrder;
    
        $cargoArray = [];
    
        // Step 1: Handle Cargo Data
        if (isset($request->cargo) && is_array($request->cargo)) {
            foreach ($request->cargo as $cargo) {
                $documentFilePath = null;
    
                // Handle file upload if document is present
                if (isset($cargo['document_file']) && $cargo['document_file']->isValid()) {
                    $documentFile = $cargo['document_file'];
                    $documentFilePath = $documentFile->store('orders/cargo_documents/', 'public');
                }
                
                // Add cargo data to cargo array
                $cargoArray[] = [
                    'packages_no'         => $cargo['packages_no'] ?? null,
                    'package_type'        => $cargo['package_type'] ?? null,
                    'package_description' => $cargo['package_description'] ?? null,
                    'actual_weight'       => $cargo['actual_weight'] ?? null,
                    'charged_weight'      => $cargo['charged_weight'] ?? null,
                    'document_no'         => $cargo['document_no'] ?? null,
                    'document_name'       => $cargo['document_name'] ?? null,
                    'document_date'       => $cargo['document_date'] ?? null,
                    'eway_bill'           => $cargo['eway_bill'] ?? null,
                    'valid_upto'          => $cargo['valid_upto'] ?? null,
                    'declared_value'      => $cargo['declared_value'] ?? null,
                    'document_file'       => $documentFilePath,
                ];
                // dd($cargoArray);
            }
        }
        
        // Step 2: Handle Vehicle Data
        $vehicleArray = [];

        if (isset($request->vehicle) && is_array($request->vehicle)) {
            foreach ($request->vehicle as $veh) {
                $vehicleArray[] = [
                    'vehicle_no' => $veh['vehicle_no'] ?? null,
                    'remarks'    => $veh['remarks'] ?? null,
                ];
                
            }
        }
        // dd($vehicleArray);


        

        // Step 3: Handle freightType logic
        $freight_amount = $lr_charges = $hamali = $other_charges = $gst_amount = $total_freight = $less_advance = $balance_freight = null;
    
        if ($request->freightType !== 'to_be_billed') {
            $freight_amount = $request->freight_amount;
            $lr_charges = $request->lr_charges;
            $hamali = $request->hamali;
            $other_charges = $request->other_charges;
            $gst_amount = $request->gst_amount;
            $total_freight = $request->total_freight;
            $less_advance = $request->less_advance;
            $balance_freight = $request->balance_freight;
        }
    
        // Step 4: Prepare LR Data
        $lrData = [
            'lr_number'           => $request->lr_number ?? 'LR-' . strtoupper(uniqid()),
            'lr_date'             => $request->lr_date,
            'vehicle_type'        => $request->vehicle_type,
            'vehicle_ownership'   => $request->vehicle_ownership,
            'delivery_mode'       => $request->delivery_mode,
            'from_location'       => $request->from_location,
            'to_location'         => $request->to_location,
            'insurance_description' => $request->insurance_description,
            'insurance_status'    => $request->insurance_status,
            'total_declared_value' => $request->total_declared_value,
            'order_rate'         => $request->order_rate,
    
            // Consignor data
            'consignor_id'        => $request->consignor_id,
            'consignor_gst'       => $request->consignor_gst,
            'consignor_loading'   => $request->consignor_loading,
    
            // Consignee data
            'consignee_id'        => $request->consignee_id,
            'consignee_gst'       => $request->consignee_gst,
            'consignee_unloading' => $request->consignee_unloading,
    
            // Charges
            'freightType'         => $request->freightType,
            'freight_amount'      => $freight_amount,
            'lr_charges'          => $lr_charges,
            'hamali'              => $hamali,
            'other_charges'       => $other_charges,
            'gst_amount'          => $gst_amount,
            'total_freight'       => $total_freight,
            'less_advance'        => $less_advance,
            'balance_freight'     => $balance_freight,
    
            // Cargo list
            'cargo'               => $cargoArray,
            'vehicle'              => $vehicleArray,
        ];

       
        // Step 5: Store LR data as array (wrapped in array so future multi-LR possible)
        $order->lr = json_encode([$lrData]);
    
        // Save the order
        $order->save();
        // dd($order);
    
        // Redirect to consignments index with success message
        return redirect()->route('admin.consignments.index')
            ->with('success', 'Single LR with multiple cargo stored successfully.');
    }
    



    public function update(Request $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();
        $order->order_method = 'order';
        $order->byorder = $request->byOrder;
        $cargoArray = [];
        /** ------------------ CARGO DATA ------------------ **/

        // Loop through cargo entries if available
        if (isset($request->cargo) && is_array($request->cargo)) {
            foreach ($request->cargo as $cargo) {
                $documentFilePath = null;
    
                // Upload new file if available and valid
                if (isset($cargo['document_file']) && $cargo['document_file'] instanceof \Illuminate\Http\UploadedFile && $cargo['document_file']->isValid()) {
                    $documentFilePath = $cargo['document_file']->store('orders/cargo_documents/', 'public');
                }
                // Otherwise use the old file path
                elseif (isset($cargo['old_document_file'])) {
                    $documentFilePath = $cargo['old_document_file'];
                }
    
                $cargoArray[] = [
                    'packages_no'         => $cargo['packages_no'] ?? null,
                    'package_type'        => $cargo['package_type'] ?? null,
                    'package_description' => $cargo['package_description'] ?? null,
                    'declared_value'      => $cargo['declared_value'] ?? null,
                    'actual_weight'       => $cargo['actual_weight'] ?? null,
                    'charged_weight'      => $cargo['charged_weight'] ?? null,
                    'unit'                => $cargo['unit'] ?? null,
                    'document_no'         => $cargo['document_no'] ?? null,
                    'document_name'       => $cargo['document_name'] ?? null,
                    'document_date'       => $cargo['document_date'] ?? null,
                    'eway_bill'           => $cargo['eway_bill'] ?? null,
                    'valid_upto'          => $cargo['valid_upto'] ?? null,
                    'document_file'       => $documentFilePath,
                ];
            }
        }
        
        /** ------------------ VEHICLE ARRAY ------------------ **/
          $vehicleArray = [];

            if (isset($request->vehicle) && is_array($request->vehicle)) {
                $selectedIndex = $request->input('selected_vehicle');

                foreach ($request->vehicle as $index => $vehicle) {
                    $vehicleArray[] = [
                        'vehicle_no'  => $vehicle['vehicle_no'] ?? null,
                        'remarks'     => $vehicle['remarks'] ?? null,
                        'is_selected' => ((string)$index === (string)$selectedIndex), // true only for selected
                    ];
                }
            }


        /** ------------------ FREIGHT CHARGES ------------------ **/

        // Default freight-related fields
        $freight_amount = $lr_charges = $hamali = $other_charges = $gst_amount = $total_freight = $less_advance = $balance_freight = null;
    
        // Only assign freight values if not "to_be_billed"
        if ($request->freightType !== 'to_be_billed') {
            $freight_amount = $request->freight_amount;
            $lr_charges = $request->lr_charges;
            $hamali = $request->hamali;
            $other_charges = $request->other_charges;
            $gst_amount = $request->gst_amount;
            $total_freight = $request->total_freight;
            $less_advance = $request->less_advance;
            $balance_freight = $request->balance_freight;
        }
        
        /** ------------------ LR DATA ------------------ **/


        $lrData = [
            'lr_number'              => $request->lr_number ?? 'LR-' . strtoupper(uniqid()),
            'lr_date'                => $request->lr_date,
            'vehicle_type'           => $request->vehicle_type,
            'vehicle_ownership'      => $request->vehicle_ownership,
            'delivery_mode'          => $request->delivery_mode,
            'from_location'          => $request->from_location,
            'to_location'            => $request->to_location,
            'insurance_status'       => $request->insurance_status,
            'insurance_description'  => $request->insurance_description,
    
            // Consignor
            'consignor_id'           => $request->consignor_id,
            'consignor_gst'          => $request->consignor_gst,
            'consignor_loading'      => $request->consignor_loading,
    
            // Consignee
            'consignee_id'           => $request->consignee_id,
            'consignee_gst'          => $request->consignee_gst,
            'consignee_unloading'    => $request->consignee_unloading,
    
            // Charges
            'freightType'            => $request->freightType,
            'freight_amount'         => $freight_amount,
            'lr_charges'             => $lr_charges,
            'hamali'                 => $hamali,
            'other_charges'          => $other_charges,
            'gst_amount'             => $gst_amount,
            'total_freight'          => $total_freight,
            'less_advance'           => $less_advance,
            'balance_freight'        => $balance_freight,
            'total_declared_value'   => $request->total_declared_value,
            'order_rate'             => $request->order_rate,
    
            // Cargo list
            'cargo'                  => $cargoArray,
             // Vehicle list
            'vehicle'                => $vehicleArray,

        ];
    
        $order->lr = json_encode([$lrData]);
        $order->save();
    
        return redirect()->route('admin.consignments.index')
            ->with('success', 'Order updated successfully with LR and Cargo.');
    }
    
    



public function show($id)
{
    $orders = DB::table('orders')->get();
    // dd($orders);

    foreach ($orders as $order) {
        $lrData = json_decode($order->lr, true);
        // dd($lrData);
       
        if (!is_array($lrData)) {
            $lrData = json_decode(json_decode($order->lr), true);
        }

       

        if (is_array($lrData)) {
            foreach ($lrData as $entry) {
                if (isset($entry['lr_number']) && $entry['lr_number'] == $id) {
                    $lrEntries = $entry;

                    $vehicles = \App\Models\Vehicle::all();
                    $users = \App\Models\User::all();
                   $packageTypes = \App\Models\PackageType::all()->pluck('package_type', 'id')->toArray();

                    return view('admin.consignments.view', compact('packageTypes','orders', 'order', 'lrEntries', 'vehicles', 'users'));
                }
            }
        }
         

    }

    return redirect()->back()->with('error', 'LR Number not found.');
}


public function docView($id)
{
    $orders = DB::table('orders')->get();
 

    foreach ($orders as $order) {
        $lrData = json_decode($order->lr, true);

       
        if (!is_array($lrData)) {
            $lrData = json_decode(json_decode($order->lr), true);
        }

        // dd($lrData); 

        if (is_array($lrData)) {
            foreach ($lrData as $entry) {
                if (isset($entry['lr_number']) && $entry['lr_number'] == $id) {
                    $lrEntries = $entry;
                    
                    return view('admin.consignments.documents', compact( 'lrEntries'));
                }
            }
        }
    }

    return redirect()->back()->with('error', 'LR Number not found.');
}




   


    public function destroy($order_id)
    {
        // Get all orders with the same order_id
        $orders = Order::where('order_id', $order_id)->get();
    
        if ($orders->isEmpty()) {
            return redirect()->route('admin.consignments.index')
                ->with('error', 'No entries found for this order ID.');
        }
    
        try {
            // Delete all related LRs
            foreach ($orders as $order) {
                $order->delete();
            }
    
            return redirect()->route('admin.consignments.index')
                ->with('success', 'All entries under this Order ID deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.consignments.index')
                ->with('error', 'Error while deleting entries.');
        }
    }
    

 public function uploadPod(Request $request)
{
    
    $request->validate([
       
        'pod_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $inputLRNumber = $request->lr_number;
    $orders = Order::all();
    $matchedOrder = null;
    $matchedLRKey = null;

    foreach ($orders as $order) {
        $lrRaw = $order->lr;

        if (is_string($lrRaw)) {
            $lrData = json_decode($lrRaw, true);
            if (is_string($lrData)) {
                $lrData = json_decode($lrData, true);
            }
        } elseif (is_array($lrRaw)) {
            $lrData = $lrRaw;
        } else {
            $lrData = [];
        }

        foreach ($lrData as $key => $entry) {
            if (isset($entry['lr_number']) && $entry['lr_number'] === $inputLRNumber) {
                $matchedOrder = $order;
                $matchedLRKey = $key;
                break 2;
            }
          
        }
    }
   

    if (!$matchedOrder || $matchedLRKey === null) {
        return back()->with('error', 'Order not found for the given LR number.');
    }

    // ✅ Check if POD already exists for this LR
    if (!empty($lrData[$matchedLRKey]['pod_files'])) {
        return back()->with('error', 'POD already uploaded for this LR number.');
    }

    // Process POD file
    if ($request->hasFile('pod_file') && $request->file('pod_file')->isValid()) {
        $file = $request->file('pod_file');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $sanitizedName = 'POD_LR-' . str_replace([' ', '_'], '-', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;

        // Validate filename format
        if (!preg_match('/^POD_LR-[A-Za-z0-9\-]+\.(' . $extension . ')$/', $sanitizedName)) {
            return back()->with('error', 'Invalid filename format. Use only letters, numbers, and hyphens. Underscores are not allowed.');
        }

        $file->move(public_path('uploads'), $sanitizedName);
        $lrData[$matchedLRKey]['pod_files'] = 'uploads/' . $sanitizedName;

        $matchedOrder->lr = json_encode($lrData);
        $matchedOrder->save();

        return back()->with('success', 'POD file uploaded successfully.');
    }

    return back()->with('error', 'Invalid file.');
}




public function multiplePodForm()
{
    return view('admin.consignments.multiple_pod_upload');
}

public function uploadMultiplePod(Request $request)
{
    // Validate multiple files
    $request->validate([
        'pod_files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $orders = Order::all();
    $uploadedAny = false;
    $errors = [];

    foreach ($request->file('pod_files') as $file) {
        $original = $file->getClientOriginalName();

        // Validate filename format POD_LR-XXXXXXXX.pdf
        if (!preg_match('/^POD_(LR-[A-Za-z0-9\-]+)\.(pdf|jpg|jpeg|png)$/i', $original, $matches)) {
            $errors[] = "Invalid filename format: {$original}";
            continue;
        }

        $lrNumber = $matches[1];
        $matchedOrder = null;
        $matchedKey = null;

        foreach ($orders as $order) {
            $lrData = $order->lr; // casted to array

            if (!is_array($lrData)) continue;

            foreach ($lrData as $key => $entry) {
                if (isset($entry['lr_number']) && trim($entry['lr_number']) === trim($lrNumber)) {

                    if (!empty($entry['pod_uploaded'])) {
                        $errors[] = "POD already uploaded for LR: {$lrNumber}";
                        continue 2;
                    }

                    $matchedOrder = $order;
                    $matchedKey = $key;
                    break 2;
                }
            }
        }

        if (!$matchedOrder || $matchedKey === null) {
            $errors[] = "LR Number not found: {$lrNumber}";
            continue;
        }

        // Save file
        $extension = $file->extension();
        $filename = "POD_{$lrNumber}_" . now()->format('YmdHis') . '_' . Str::random(4) . '.' . $extension;
        $file->move(public_path('uploads/pods'), $filename);

        // Update LR data in matched order
        $lrData = $matchedOrder->lr;

        if (!isset($lrData[$matchedKey]['pod_files']) || !is_array($lrData[$matchedKey]['pod_files'])) {
            $lrData[$matchedKey]['pod_files'] = [];
        }

        $lrData[$matchedKey]['pod_files'][] = $filename;
        $lrData[$matchedKey]['pod_uploaded'] = true;

        $matchedOrder->lr = $lrData; // Cast handles array-to-JSON
        $matchedOrder->save();

        $uploadedAny = true;
    }

    // Final response
    if ($uploadedAny) {
        $message = "POD files uploaded successfully.";
        if (!empty($errors)) {
            $message .= " Some issues: " . implode(' | ', $errors);
        }
        return back()->with('success', $message);
    } else {
        return back()->with('error', implode(' | ', $errors));
    }
}



}

