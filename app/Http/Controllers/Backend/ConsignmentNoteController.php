<?php

namespace App\Http\Controllers\Backend;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
    $orders = Order::whereJsonLength('lr', '>', 0)->orderBy('created_at', 'desc')->get();
    //    return($orders);

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
    
    public function store(Request $request)
    {
        $order = new Order();

        $order->order_id = 'ORD-' . time();
        $order->order_method = 'order';
        $order->byorder = $request->byOrder;

    
        $key = 1;

        // Cargo
        $cargoArray = [];
        if (isset($request->cargo) && is_array($request->cargo)) {
            foreach ($request->cargo as $cargo) {
                $documentFilePath = null;
                if (isset($cargo['document_file']) && is_object($cargo['document_file']) && $cargo['document_file']->isValid()) {
                    $documentFile = $cargo['document_file'];
                    $documentFilePath = $documentFile->store('orders/cargo_documents/', 'public');
                }

                $cargoArray[] = [
                    'packages_no'         => $cargo['packages_no'] ?? null,
                    'package_type'        => $cargo['package_type'] ?? null,
                    'package_description' => $cargo['package_description'] ?? null,
                    'actual_weight'       => $cargo['actual_weight'] ?? null,
                    'charged_weight'      => $cargo['charged_weight'] ?? null,
                    'document_no'         => $cargo['document_no'] ?? null,
                    'document_name'       => $cargo['document_name'] ?? null,
                    'document_date'       => $cargo['document_date'] ?? null,
                    // 'eway_bill'           => $cargo['eway_bill'] ?? null,
                    'valid_upto'          => $cargo['valid_upto'] ?? null,
                    'declared_value'      => $cargo['declared_value'] ?? null,
                    'unit'                => $cargo['unit'] ?? null,
                    'document_file'       => $documentFilePath,
                ];
            }
        }

        // Vehicle
        $vehicleArray = [];
        if (isset($request->vehicle) && is_array($request->vehicle)) {
            foreach ($request->vehicle as $veh) {
                $vehicleArray[] = [
                    'vehicle_no' => $veh['vehicle_no'] ?? null,
                    'remarks'    => $veh['remarks'] ?? null,
                ];
            }
        }

        // Freight logic
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

        // LR Data with key
        $lrData = [
            'lr_number'           => $request->lr_number ?? ('LR-' . time() . '-' . $key),
            'lr_date'             => $request->lr_date,
            'vehicle_type'        => $request->vehicle_type,
            'vehicle_ownership'   => $request->vehicle_ownership,
            'delivery_mode'       => $request->delivery_mode,
            'from_location'       => $request->from_location,
            'to_location'         => $request->to_location,
            'insurance_description' => $request->insurance_description,
            'insurance_status'    => $request->insurance_status,
            'total_declared_value' => $request->total_declared_value,
            'order_rate'          => $request->order_rate,
            // Freight ac
            'customer_id'        => $request->customer_id,
            'gst_number'        => $request->gst_number,
            'customer_address'        => $request->customer_address,

            'consignor_id'        => $request->consignor_id,
            'consignor_gst'       => $request->consignor_gst,
            'consignor_loading'   => $request->consignor_loading,

            'consignee_id'        => $request->consignee_id,
            'consignee_gst'       => $request->consignee_gst,
            'consignee_unloading' => $request->consignee_unloading,

            'freightType'         => $request->freightType,
            'freight_amount'      => $freight_amount,
            'lr_charges'          => $lr_charges,
            'hamali'              => $hamali,
            'other_charges'       => $other_charges,
            'gst_amount'          => $gst_amount,
            'total_freight'       => $total_freight,
            'less_advance'        => $less_advance,
            'balance_freight'     => $balance_freight,

            'cargo'               => $cargoArray,
            'vehicle'             => $vehicleArray,
        ];

        // Store with key
        $order->lr = json_encode([$key => $lrData]);

        $order->save();
        // dd($order);

        return redirect()->route('admin.consignments.index')
            ->with('success', 'Single LR with multiple cargo stored successfully.');
    }
    
    public function edit($order_id, $lr_number)
    {
            
        
            $order = Order::findOrFail($order_id);

            
        $lrEntriesArray = $order->lr;
        

        if (is_string($lrEntriesArray)) {
        
            $lrEntries = json_decode($lrEntriesArray, true);
        } else {
        
            $lrEntries = is_object($lrEntriesArray) ? (array) $lrEntriesArray : $lrEntriesArray;
        }
        $lrData = null;

    
        if (is_array($lrEntries)) {
            foreach ($lrEntries as $key => $lr) {
                if (isset($lr['lr_number']) && $lr['lr_number'] == $lr_number) {
                    $lrData = $lr;
                    break;
                }
            }
        }

        // Agar aur data chahiye to wo bhi load karlo
        $vehicles = Vehicle::all();
        $users = User::all();
        $vehiclesType = VehicleType::all();
        $destination = Destination::all();
        $package = PackageType::all();


        return view('admin.consignments.edit', compact('order', 'lrData', 'vehicles', 'users', 'vehiclesType', 'destination', 'package'));
    }




    public function update(Request $request, $order_id, $lr_number)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();
        $order->order_method = 'order';
        $order->byorder = $request->byOrder;

        $cargoArray = [];

        if (isset($request->cargo) && is_array($request->cargo)) {
            foreach ($request->cargo as $cargo) {
                $documentFilePath = null;

                if (isset($cargo['document_file']) && $cargo['document_file'] instanceof \Illuminate\Http\UploadedFile && $cargo['document_file']->isValid()) {
                    $documentFilePath = $cargo['document_file']->store('orders/cargo_documents/', 'public');
                } elseif (isset($cargo['old_document_file'])) {
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
                    // 'eway_bill'           => $cargo['eway_bill'] ?? null,
                    'valid_upto'          => $cargo['valid_upto'] ?? null,
                    'document_file'       => $documentFilePath,
                ];
            }
        }

        $vehicleArray = [];
        if (isset($request->vehicle) && is_array($request->vehicle)) {
            $selectedIndex = $request->input('selected_vehicle');
            foreach ($request->vehicle as $index => $vehicle) {
                $vehicleArray[] = [
                    'vehicle_no'  => $vehicle['vehicle_no'] ?? null,
                    'remarks'     => $vehicle['remarks'] ?? null,
                    'is_selected' => ((string)$index === (string)$selectedIndex),
                ];
            }
        }

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

    
    
        $existingLrs = is_string($order->lr) ? json_decode($order->lr, true) : $order->lr;


        // Replace the matching LR by lr_number
        foreach ($existingLrs as $key => $lr) {
            if ($lr['lr_number'] === $lr_number) {
                $existingLrs[$key] = [
                    'lr_number'              => $lr_number,
                    'lr_date'                => $request->lr_date,
                    'vehicle_type'           => $request->vehicle_type,
                    'vehicle_ownership'      => $request->vehicle_ownership,
                    'delivery_mode'          => $request->delivery_mode,
                    'from_location'          => $request->from_location,
                    'to_location'            => $request->to_location,
                    'insurance_status'       => $request->insurance_status,
                    'insurance_description'  => $request->insurance_description,

                    // Freight ac
                    'customer_id'            => $request->customer_id,
                    'gst_number'             => $request->gst_number,
                    'customer_address'       => $request->customer_address,

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

                    // Nested cargo and vehicle
                    'cargo'                  => $cargoArray,
                    'vehicle'                => $vehicleArray,
                ];
                break; // Stop after updating the matching LR
            }
        }

        // Save updated LRs back
        $order->lr = json_encode($existingLrs);
        $order->save();

        return redirect()->route('admin.consignments.index')
            ->with('success', 'Order updated successfully for selected LR.');
    }
    



    public function show($id)
    {
        $orders = DB::table('orders')->get();
    

        foreach ($orders as $order) {
            $lrData = json_decode($order->lr, true);
        
        
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

    public function destroy($order_id, $lr_number)
    {
        try {
            
            $order = Order::findOrFail($order_id);

            
            $lrEntriesArray = $order->lr;

            if (is_string($lrEntriesArray)) {
                $lrEntries = json_decode($lrEntriesArray, true);
            } else {
                $lrEntries = is_object($lrEntriesArray) ? (array) $lrEntriesArray : $lrEntriesArray;
            }

        
            if (!is_array($lrEntries) || empty($lrEntries)) {
                return redirect()->route('admin.consignments.index')
                    ->with('error', 'No LR entries found for this Order.');
            }

            
            $filteredLrEntries = array_filter($lrEntries, function ($lr) use ($lr_number) {
                return isset($lr['lr_number']) && $lr['lr_number'] != $lr_number;
            });

        
            if (count($lrEntries) == count($filteredLrEntries)) {
                return redirect()->route('admin.consignments.index')
                    ->with('error', 'No matching LR Number found to delete.');
            }

        
            $order->lr = json_encode(array_values($filteredLrEntries)); // reindex array
            $order->save();

            return redirect()->route('admin.consignments.index')
                ->with('success', 'LR entry deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.consignments.index')
                ->with('error', 'Error while deleting LR entry.');
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
            // Decode LR JSON safely
            $lrData = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);

            // Check if lrData is valid array
            if (!is_array($lrData)) {
                continue; // skip this order if LR data is not usable
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

        // Decode LR data again if needed
        $lrData = is_array($matchedOrder->lr) ? $matchedOrder->lr : json_decode($matchedOrder->lr, true);

        if (!is_array($lrData)) {
            return back()->with('error', 'Invalid LR data format.');
        }

        // Check if POD already exists
        if (
            isset($lrData[$matchedLRKey]['pod_files']) &&
            is_array($lrData[$matchedLRKey]['pod_files']) &&
            count($lrData[$matchedLRKey]['pod_files']) > 0
        ) {
            return back()->with('error', 'POD already exists for this LR number.');
        }

        if ($request->hasFile('pod_file') && $request->file('pod_file')->isValid()) {
            $file = $request->file('pod_file');
            $extension = $file->extension();
            $lrNumber = $inputLRNumber;
            $filename = "POD_{$lrNumber}_" . now()->format('YmdHis') . '_' . Str::random(4) . '.' . $extension;
            $relativePath = 'uploads/pods/' . $filename;

            $file->move(public_path('uploads/pods'), $filename);

            // Initialize if not set
            if (!isset($lrData[$matchedLRKey]) || !is_array($lrData[$matchedLRKey])) {
                $lrData[$matchedLRKey] = [];
            }

            if (!isset($lrData[$matchedLRKey]['pod_files']) || !is_array($lrData[$matchedLRKey]['pod_files'])) {
                $lrData[$matchedLRKey]['pod_files'] = [];
            }

            $lrData[$matchedLRKey]['pod_files'][] = $relativePath;
            $lrData[$matchedLRKey]['pod_uploaded'] = true;

            $matchedOrder->lr = json_encode($lrData);
            $matchedOrder->save();

            return back()->with('success', 'POD uploaded successfully.');
        }

        return back()->with('error', 'Invalid file.');
    }




    public function multiplePodForm()
    {
        return view('admin.consignments.multiple_pod_upload');
    }

    public function uploadMultiplePod(Request $request)
    {
        $request->validate([
            'pod_files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $orders = Order::all();
        $uploadedAny = false;
        $errors = [];

        foreach ($request->file('pod_files') as $file) {
            $original = $file->getClientOriginalName();

            if (!preg_match('/^POD_(LR-[A-Za-z0-9\-]+)\.(pdf|jpg|jpeg|png)$/i', $original, $matches)) {
                $errors[] = "Invalid filename format: {$original}";
                continue;
            }

            $lrNumber = $matches[1];
            $matchedOrder = null;
            $matchedKey = null;

            foreach ($orders as $order) {
                $lrData = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);

                // ✅ Null check added here
                if (!is_array($lrData)) {
                    continue;
                }

                foreach ($lrData as $key => $entry) {
                    if (isset($entry['lr_number']) && strpos($entry['lr_number'], $lrNumber) === 0) {
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
            $filename = "POD_{$lrNumber}_" . now()->format('YmdHis') . '_' . \Str::random(4) . '.' . $extension;
            $relativePath = 'uploads/pods/' . $filename;

            $file->move(public_path('uploads/pods'), $filename);

            // Decode before updating
            $lrData = is_array($matchedOrder->lr) ? $matchedOrder->lr : json_decode($matchedOrder->lr, true);

            // ✅ Null check again
            if (!is_array($lrData)) {
                $errors[] = "Invalid LR data for: {$lrNumber}";
                continue;
            }

            if (!isset($lrData[$matchedKey]['pod_files']) || !is_array($lrData[$matchedKey]['pod_files'])) {
                $lrData[$matchedKey]['pod_files'] = [];
            }

            $lrData[$matchedKey]['pod_files'][] = $relativePath;
            $lrData[$matchedKey]['pod_uploaded'] = true;

            // Encode before saving
            $matchedOrder->lr = json_encode($lrData);
            $matchedOrder->save();

            $uploadedAny = true;
        }

        if ($uploadedAny) {
            $message = "POD files uploaded successfully.";
            if (!empty($errors)) {
                $message .= " Issues: " . implode(' | ', $errors);
            }
            return back()->with('success', $message);
        } else {
            return back()->with('error', implode(' | ', $errors));
        }
    }



    public function assign_old($lr_number, Request $request)
    {
        $inputDate = $request->input('date');

        // Validate date format or fallback to today
        try {
            $ewayBillDate = Carbon::parse($inputDate)->format('d/m/Y'); // Convert to correct API format
        } catch (\Exception $e) {
            $ewayBillDate = now()->format('d/m/Y'); // Fallback date
        }


        // ✅ Fetch from .env
        $authToken     = env('EWB_AUTH_TOKEN'); 
        $encryptedSek  = env('EWB_ENCRYPTED_SEK'); 
        $appKey        = env('EWB_APP_KEY'); 
        $gstin         = env('EWB_GSTIN');  

        $ciphering = 'AES-256-ECB';
        $options = OPENSSL_RAW_DATA;
        $decryption_iv = '';
        $decryptionKey = base64_decode($appKey);
        $decryptedSek = openssl_decrypt(base64_decode($encryptedSek), $ciphering, $decryptionKey, $options, $decryption_iv);

        $ewayBills = [];

        if ($decryptedSek) {
            $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi/GetEwayBillsForTransporter?date={$ewayBillDate}";

            $headers = [
                'Content-Type' => 'application/json',
                'gstin' => $gstin,
                'Ocp-Apim-Subscription-Key'    => env('EWB_API_SUBSCRIPTION_KEY', 'AL5e2V9g1I2p9h4U3e'),
                'authtoken' => $authToken,
            ];

            $response = Http::withHeaders($headers)->get($url);
            $jsonResponse = $response->json();

            if ($response->successful() && isset($jsonResponse['data']) && isset($jsonResponse['rek'])) {
                $rek = openssl_decrypt(base64_decode($jsonResponse['rek']), $ciphering, $decryptedSek, $options, $decryption_iv);
                $decryptedData = openssl_decrypt(base64_decode($jsonResponse['data']), $ciphering, $rek, $options, $decryption_iv);
                
                if ($decryptedData) {
                    $ewayBills = json_decode($decryptedData, true);
                }
            }
        }
    
        
        return view('admin.consignments.assign-ewaybill', compact('lr_number', 'ewayBills', 'ewayBillDate'));
    }

    public function assign_alkit($lr_number, Request $request)
    {
        $inputDate = $request->input('date');

        try {
            $ewayBillDate = Carbon::parse($inputDate)->format('d/m/Y');
        } catch (\Exception $e) {
            $ewayBillDate = now()->format('d/m/Y');
        }

        // ✅ Fetch credentials from .env
        $authToken    = env('EWB_AUTH_TOKEN_TRANSPORTER');
        $encryptedSek = env('EWB_ENCRYPTED_SEK_TRANSPORTER');
        $appKey       = env('EWB_APP_KEY');
        $genGstin     = env('EWB_GENERATOR_GSTIN');  // e.g. 23AABFM6400F1ZX
        $gstin        = env('EWB_GSTIN');            // e.g. 07AGAPA5363L002

        // 🔐 Decrypt SEK
        $decryptionKey = base64_decode($appKey);
        $ciphering = 'AES-256-ECB';
        $options = OPENSSL_RAW_DATA;
        $decryptedSek = openssl_decrypt(base64_decode($encryptedSek), $ciphering, $decryptionKey, $options);

        $ewayBills = [];

        if ($decryptedSek) {
            // 🚀 Call API: GetEwayBillsForTransporterByGstin
            $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi/GetEwayBillsForTransporterByGstin?Gen_gstin={$genGstin}&date={$ewayBillDate}";

            $headers = [
                'Content-Type' => 'application/json',
                'gstin' => $gstin,
                'Ocp-Apim-Subscription-Key' => env('EWB_API_SUBSCRIPTION_KEY', 'AL5e2V9g1I2p9h4U3e'),
                'authtoken' => $authToken,
            ];

            $response = Http::withHeaders($headers)->get($url);
            $jsonResponse = $response->json();

            if ($response->successful() && isset($jsonResponse['data']) && isset($jsonResponse['rek'])) {
                // 🔓 Decrypt REK
                $rek = openssl_decrypt(base64_decode($jsonResponse['rek']), $ciphering, $decryptedSek, $options);

                if ($rek) {
                    $decryptedData = openssl_decrypt(base64_decode($jsonResponse['data']), $ciphering, $rek, $options);

                    if ($decryptedData) {
                        $ewayBills = json_decode($decryptedData, true);
                    }
                }
            }
        }

        return view('admin.consignments.assign-ewaybill', compact('lr_number', 'ewayBills', 'ewayBillDate'));
    }

    // whitebox assign

    public function assign_whitebox($lr_number, Request $request)
   {
    // dd($request->all());

    $inputDate = $request->input('date');

    try {
        $ewayBillDate = Carbon::parse($inputDate)->format('d/m/Y');
    } catch (\Exception $e) {
        $ewayBillDate = now()->format('d/m/Y');
    }

    // ✅ Fetch credentials from .env
    
    $headers = [
        "ip_address"    => env('EWB_IP_ADDRESS'),
        "client_id"     => env('EWB_CLIENT_ID'),
        "client_secret" => env('EWB_CLIENT_SECRET'),
        "gstin"         => env('EWB_GSTIN'),
        "accept"        => "*/*"
    ];

    // ✅ Query params
    $query = [
        "email"     => env('EWB_EMAIL', 'ask.innovations1@gmail.com'),
        "date"      => $ewayBillDate,
        "stateCode" => $request->stateCode ?? "23"
    ];

    $ewayBills = [];

    try {
        // 🚀 Call Whitebox API
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/getewaybillreportbytransporterassigneddate";

        $response = Http::withHeaders($headers)
            ->withOptions(["verify" => false])
            ->get($url, $query);

        $json = $response->json();

        // dd($json);
        if ($response->successful() && isset($json['status_cd']) && $json['status_cd'] == "1") {
            // Whitebox response simple hota hai, directly data return hota hai
            $ewayBills = $json['data'] ?? [];
        }

    } catch (\Exception $e) {
        // agar api call fail ho jaye
        $ewayBills = [];
    }

    // 🖼️ Return same Blade view jo aap Eraahi me use kar rahe ho
    return view('admin.consignments.assign-ewaybill', compact('lr_number', 'ewayBills', 'ewayBillDate'));
   }
 



    public function assignSave(Request $request, $lr_number)
    { 
        // dd($request->all());

        $selectedEwbNos = $request->input('selected_ewb', []);
        
        if (empty($selectedEwbNos)) {
            return back()->with('error', 'Please select at least one eWay Bill.');
        }

        // Fetch all orders
        $orders = Order::all();

        $matchedOrder = null;
        $matchedLRKey = null;
        $lrData = null;

        foreach ($orders as $order) {
            //  dd($order->lr);
            // Step 1: Decode LR field
            $lrEntries = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
        

            // Handle nested/double JSON encoding if needed
            if (!is_array($lrEntries)) {
                $lrEntries = json_decode(json_decode($order->lr), true);
            }

            if (!is_array($lrEntries)) continue;

            // Step 2: Search for matching LR number
            foreach ($lrEntries as $key => $lr) {
                if (isset($lr['lr_number']) && $lr['lr_number'] == $lr_number) {
                    $matchedOrder = $order;
                    $matchedLRKey = $key;
                    $lrData = $lr;
                    //   dd($lrData,$matchedOrder, $matchedLRKey);
                    break 2; // Break both loops
                }
            }
        }

        // Step 3: If not found
        if (!$matchedOrder || $matchedLRKey === null || !$lrData) {
            return back()->with('error', 'Order with specified LR not found.');
        }

        // Step 4: Add/merge eWay bills
        if (!isset($lrData['eway_bills']) || !is_array($lrData['eway_bills'])) {
            $lrData['eway_bills'] = [];
        }

        // Merge old and new bills without duplicates
        $lrData['eway_bills'] = array_values(array_unique(array_merge(
            $lrData['eway_bills'], $selectedEwbNos
        )));
        // dd($lrData['eway_bills']);

        // Step 5: Put updated LR back into the LR list
        $lrEntries[$matchedLRKey] = $lrData;
        // dd($lrEntries);
        // dd($lrData['eway_bills'], $selectedEwbNos); 

        // Step 6: Save updated data to DB
        $matchedOrder->lr = json_encode($lrEntries);
        // return($matchedOrder->lr);

        $matchedOrder->save();
        // dd($matchedOrder);

    // ✅ Redirect to fill page with query string
        $ewbQuery = implode(',', $selectedEwbNos);
        // dd($ewbQuery);
        return redirect()->route('admin.consignments.vehicle_eway_bill', ['ewbs' => $ewbQuery]);
    }
    

    public function fillFromEwayBill_old(Request $request)
    {
        $ewbNos = explode(',', $request->query('ewbs'));

        $ewayBillDetails = [];

        // ✅ Get credentials from .env
        $authToken     = env('EWB_AUTH_TOKEN');
        $encryptedSek  = env('EWB_ENCRYPTED_SEK');
        $appKey        = env('EWB_APP_KEY');
        $gstin         = env('EWB_GSTIN');
        $subscriptionKey = env('EWB_API_SUBSCRIPTION_KEY', 'AL5e2V9g1I2p9h4U3e');

        
        $ciphering = 'AES-256-ECB';
        $options = OPENSSL_RAW_DATA;
        $decryption_iv = '';
        $decryptionKey = base64_decode($appKey);
        $decryptedSek = openssl_decrypt(base64_decode($encryptedSek), $ciphering, $decryptionKey, $options, $decryption_iv);

        foreach ($ewbNos as $ewbNo) {
            $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi/GetEwayBill?ewbNo={$ewbNo}";

            $headers = [
                'Content-Type' => 'application/json',
                'gstin' => $gstin,
                'Ocp-Apim-Subscription-Key' => $subscriptionKey,
                'authtoken' => $authToken,
            ];

            $response = \Http::withHeaders($headers)->get($url);
            $jsonResponse = $response->json();

            if ($response->successful() && isset($jsonResponse['data']) && isset($jsonResponse['rek'])) {
                $rek = openssl_decrypt(base64_decode($jsonResponse['rek']), $ciphering, $decryptedSek, $options, $decryption_iv);
                $decryptedData = openssl_decrypt(base64_decode($jsonResponse['data']), $ciphering, $rek, $options, $decryption_iv);
                $ewayBillDetails[] = json_decode($decryptedData, true);
            }
        }
        // dd($ewayBillDetails); 

        // ✅ Return JSON for AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'ewaybill_data' => $ewayBillDetails[0] ?? null
            ]);
        }
    

        return view('admin.consignments.vehicle_eway_bill', [
            'ewaybills' => $ewayBillDetails
        ]);
    }


    public function fillFromEwayBill_alkit(Request $request)
    {
        

        $ewbNos = explode(',', $request->query('ewbs'));

        $ewayBillDetails = [];

        $authToken     = env('EWB_AUTH_TOKEN');
        $encryptedSek  = env('EWB_ENCRYPTED_SEK');
        $appKey        = env('EWB_APP_KEY');
        $gstin         = env('EWB_GENERATOR_GSTIN');
        $subscriptionKey = env('EWB_API_SUBSCRIPTION_KEY', 'AL5e2V9g1I2p9h4U3e');

        $ciphering = 'AES-256-ECB';
        $options = OPENSSL_RAW_DATA;
        $decryption_iv = '';
        $decryptionKey = base64_decode($appKey);
        $decryptedSek = openssl_decrypt(base64_decode($encryptedSek), $ciphering, $decryptionKey, $options, $decryption_iv);

        foreach ($ewbNos as $ewbNo) {
            $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi/GetEwayBill?ewbNo={$ewbNo}";

            $headers = [
                'Content-Type' => 'application/json',
                'gstin' => $gstin,
                'Ocp-Apim-Subscription-Key' => $subscriptionKey,
                'authtoken' => $authToken,
            ];

            $response = \Http::withHeaders($headers)->get($url);
            $jsonResponse = $response->json();

            if ($response->successful() && isset($jsonResponse['data']) && isset($jsonResponse['rek'])) {
                $rek = openssl_decrypt(base64_decode($jsonResponse['rek']), $ciphering, $decryptedSek, $options, $decryption_iv);
                $decryptedData = openssl_decrypt(base64_decode($jsonResponse['data']), $ciphering, $rek, $options, $decryption_iv);
                $ewayBillDetails[] = json_decode($decryptedData, true);
            }
        }
        //  dd($ewayBillDetails);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'ewaybill_data' => $ewayBillDetails[0] ?? null
            ]);
        }

        return view('admin.consignments.vehicle_eway_bill', [
            'ewaybills' => $ewayBillDetails
        ]);
    }

    // getewaybill details
    public function fillFromEwayBillWhitebox(Request $request)
    {
        $ewbNos = explode(',', $request->query('ewbs'));

        $ewayBillDetails = [];

        // ✅ Fetch credentials from .env
        $headers = [
            "ip_address"    => env('EWB_IP_ADDRESS'),
            "client_id"     => env('EWB_CLIENT_ID'),
            "client_secret" => env('EWB_CLIENT_SECRET'),
            "gstin"         => env('EWB_GSTIN'),
            "accept"        => "*/*"
        ];

        foreach ($ewbNos as $ewbNo) {
            
            $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/getewaybill";

            // ✅ Query params
            $query = [
                "email" => env('EWB_EMAIL', 'ask.innovations1@gmail.com'),
                "ewbNo" => trim($ewbNo),
            ];

            try {
                $response = \Http::withHeaders($headers)
                    ->withOptions(["verify" => false])
                    ->get($url, $query);

                $json = $response->json();
                


                if ($response->successful() && isset($json['status_cd']) && $json['status_cd'] == "1") {
                    $ewayBillDetails[] = $json['ewayBill'] ?? $json['data'] ?? [];
                // dd($ewayBillDetails);
                }

            } catch (\Exception $e) {
                \Log::error("Whitebox GetEwayBill failed: " . $e->getMessage());
            }
        }

        // Debugging ke liye
        // dd($ewayBillDetails);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'ewaybill_data' => $ewayBillDetails[0] ?? null
            ]);
        }

        return view('admin.consignments.vehicle_eway_bill', [
            'ewaybills' => $ewayBillDetails
        ]);
    }
    // alikit update part b

    public function updatePartB(Request $request)
    {
        $ewaybills = $request->input('ewaybills', []);

        $authToken     = env('EWB_AUTH_TOKEN');
        $encryptedSek  = env('EWB_ENCRYPTED_SEK');
        $appKey        = env('EWB_APP_KEY');
        $gstin         = env('EWB_GENERATOR_GSTIN');
        $subscriptionKey = env('EWB_API_SUBSCRIPTION_KEY', 'AL5e2V9g1I2p9h4U3e');

        $ciphering = 'AES-256-ECB';
        $options = OPENSSL_RAW_DATA;
        $decryptionKey = base64_decode($appKey);
        $sek = openssl_decrypt(base64_decode($encryptedSek), $ciphering, $decryptionKey, $options);

        if (!$sek) {
            return back()->with('error', 'SEK decryption failed.');
        }

        $results = [];

        foreach ($ewaybills as $bill) {
            $vehicleData = [
                "ewbNo" => (int) $bill['ewb_no'],
                "vehicleNo" => $bill['vehicle_no'],
                "fromPlace" => $bill['from_place'],
                "fromState" => (int) $bill['from_state_code'] ?? 0,
                "transMode" => $bill['transMode'],
                "transDocNo" => $bill['transDocNo'],
                "transDocDate" => $bill['transDocDate'],
                "vehicleType" => $bill['vehicleType'],
                "reasonCode" => $bill['reasoncode'],
                "reasonRem" => $bill['reasonremarks'],
            ];

            $jsonPayload = json_encode($vehicleData, JSON_UNESCAPED_SLASHES);
            $base64Payload = base64_encode($jsonPayload);

            // Encrypt payload with SEK
            $encryptedRequest = openssl_encrypt(base64_decode($base64Payload), "aes-256-ecb", $sek, OPENSSL_RAW_DATA);
            $requestPayload = base64_encode($encryptedRequest);

            $apiPayload = [
                "action" => "VEHEWB",
                "data" => $requestPayload
            ];

            $headers = [
                'Content-Type' => 'application/json',
                'gstin' => $gstin,
                'Ocp-Apim-Subscription-Key' => $subscriptionKey,
                'authtoken' => $authToken
            ];

            $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";

            $response = Http::withHeaders($headers)->post($url, $apiPayload);
            $jsonResponse = $response->json();

            if (isset($jsonResponse['data'])) {
                $decrypted = openssl_decrypt(base64_decode($jsonResponse['data']), $ciphering, $sek, $options);
                $responseData = json_decode($decrypted, true);

                $results[] = [
                    'ewbNo' => $bill['ewb_no'],
                    'success' => true,
                    'message' => $responseData['message'] ?? 'Part B updated successfully'
                ];
            } else {
                $results[] = [
                    'ewbNo' => $bill['ewb_no'],
                    'error' => 'Failed to update'
                ];
            }

        // dd($results);

        return back()->with('success', 'Part B updated for selected eWay Bills.')->with('results', $results);
         }
    }

    // whitebooks update updatePartB
    public function updatePartBWhitebox(Request $request)
    {
        $ewaybills = $request->input('ewaybills', []);

        $headers = [
            "ip_address"    => env('EWB_IP_ADDRESS'),
            "client_id"     => env('EWB_CLIENT_ID'),
            "client_secret" => env('EWB_CLIENT_SECRET'),
            "gstin"         => env('EWB_GSTIN'),
            "accept"        => "*/*"
        ];

        $results = [];

        foreach ($ewaybills as $bill) {
            $payload = [
                "ewbNo"       => (int) $bill['ewb_no'],
                "vehicleNo"   => $bill['vehicle_no'],
                "fromPlace"   => $bill['from_place'],
                "fromState"   => (int) $bill['from_state_code'],
                "reasonCode"  => (string) $bill['reasoncode'],
                "reasonRem"   => $bill['reasonremarks'],
                "transDocNo"  => $bill['transDocNo'],
                "transDocDate"=> $bill['transDocDate'],
                "transMode"   => (string) $bill['transMode'],
                "vehicleType" => $bill['vehicleType'] ?? "R",
            ];

            try {
                $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/vehewb";
                $query = [
                    "email" => env('EWB_EMAIL', 'ask.innovations1@gmail.com')
                ];

                $response = \Http::withHeaders($headers)
                    ->withOptions(["verify" => false])
                    ->post($url . '?' . http_build_query($query), $payload);

                $json = $response->json();

                if ($response->successful() && isset($json['status_cd']) && $json['status_cd'] == "1") {
                    $results[] = [
                        'ewbNo'   => $bill['ewb_no'],
                        'success' => true,
                        'message' => $json['message'] ?? 'Part B updated successfully'
                    ];
                } else {
                    $results[] = [
                        'ewbNo'     => $bill['ewb_no'],
                        'error'     => $json['errorDesc'] 
                                    ?? ($json['error']['message'] ?? 'Failed to update'),
                        'errorCode' => $json['errorCode']  // ✅ सही key
                                    ?? $json['status_cd'] 
                                    ?? null,
                    ];
                }

            } catch (\Exception $e) {
                \Log::error("Whitebox Update PartB failed: " . $e->getMessage());
                $results[] = [
                    'ewbNo' => $bill['ewb_no'],
                    'error' => $e->getMessage()
                ];
            }
        }
        // dd($results);
        return back()->with('success', 'Part B updated for selected eWay Bills.')->with('results', $results);

        // return response()->json([
        //     'success' => true,
        //     'results' => $results
        // ]);
}


    // multiVehicleAdd method to show the form for adding multiple vehicles to a single LR
    public function multiVehicleInitiate()
    { 
        // dd('multiVehicleAdd called');
        return view('admin.consignments.multi-vehicle-initiate');
    }
// 
    public function callInitiateApi(Request $request)
   {
        $response = $this->initiateMultiVehicleWhitebox($request);

                if ($response['success']) {
            $data = $response['ewaybill_response']['data'] ?? [];

            return view('admin.consignments.multi-vehicle-initiate', [
                'response' => [
                    'ewbNo'      => $data['ewbNo'] ?? null,
                    'groupNo'    => $data['groupNo'] ?? null,
                    'createdDate'=> $data['createdDate'] ?? null,
                ],
                'formData' => $request->all(),
                'vehicleAdded' => session("vehicle_added_{$data['ewbNo']}_{$data['groupNo']}", false),
                'vehicleChanged' => session("vehicle_changed_{$data['ewbNo']}_{$data['groupNo']}", false),
            ]);
        }


        return back()->with('error', $response['error'] ?? 'API failed');
   }


   
   //    Whitebooks Initiate Multi-Vehicle API
    private function initiateMultiVehicleWhitebox(Request $request)
    {
        $headers = [
            "ip_address"    => env('EWB_IP_ADDRESS'),
            "client_id"     => env('EWB_CLIENT_ID'),
            "client_secret" => env('EWB_CLIENT_SECRET'),
            "gstin"         => env('EWB_GSTIN'),
            "accept"        => "*/*",
            "Content-Type"  => "application/json"
        ];

        // Request body exactly API ke format me
        $payload = [
            "ewbNo"         => (int) $request->ewbNo,       // Number
            "fromPlace"     => (string) $request->fromPlace,
            "fromState"     => (int) $request->fromState,   // Number
            "toPlace"       => (string) $request->toPlace,
            "toState"       => (int) $request->toState,     // Number
            "reasonCode"    => (string) ($request->reasonCode ?? "1"), // String
            "reasonRem"     => (string) ($request->reasonRem ?? "Due to Break Down"),
            "totalQuantity" => (int) $request->totalQuantity, // Number
            "unitCode"      => (string) ($request->unitCode ?? "BOX"), // String
            "transMode"     => (string) ($request->transMode ?? "1")   // String
        ];

        try {
            $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/initmulti";
            $query = [
                "email" => env('EWB_EMAIL', 'ask.innovations1@gmail.com')
            ];

            $response = \Http::withHeaders($headers)
                ->withOptions(["verify" => false]) // SSL bypass
                ->post($url . '?' . http_build_query($query), $payload);

            $json = $response->json();
            // dd($json); 

            if ($response->successful() && isset($json['status_cd']) && $json['status_cd'] == "1") {
                return [
                    'success' => true,
                    'ewaybill_response' => $json
                ];
            } else {
                return [
                    'success' => false,
                    'error'   => $json['error']['message'] ?? 'Unknown error',
                    'response'=> $json
                ];
            }

        } catch (\Exception $e) {
            \Log::error("Whitebox InitiateMultiVehicle failed: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
   }




  //    alkit Initiate Multi-Vehicle API

    private function initiateMultiVehicle(Request $request)
    {
        $authToken     = env('EWB_AUTH_TOKEN');
        $encryptedSek  = env('EWB_ENCRYPTED_SEK');
        $appKey        = env('EWB_APP_KEY');
        $gstin         = env('EWB_GSTIN');
        $subscriptionKey = env('EWB_API_SUBSCRIPTION_KEY', 'AL5e2V9g1I2p9h4U3e');

        $ciphering = 'AES-256-ECB';
        $options = OPENSSL_RAW_DATA;
        $decryptionKey = base64_decode($appKey);

        $sekBinary = openssl_decrypt(
            base64_decode($encryptedSek),
            $ciphering,
            $decryptionKey,
            $options
        );

        if (!$sekBinary) {
            return ['success' => false, 'error' => 'SEK decryption failed'];
        }

        $multiVehicleData = [
            "ewbNo"         => $request->ewbNo,
            "reasonCode"    => 1,
            "reasonRem"     => $request->reasonRem,
            "fromPlace"     => $request->fromPlace,
            "fromState"     => (int)$request->fromState,
            "toPlace"       => $request->toPlace,
            "toState"       => (int)$request->toState,
            "transMode"     => (int)$request->transMode,
            "totalQuantity" => (int)$request->totalQuantity,
            "unitCode"      => $request->unitCode
        ];

        $jsonPayload = json_encode($multiVehicleData, JSON_UNESCAPED_SLASHES);
        $base64Payload = base64_encode($jsonPayload);
        $encryptedPayload = openssl_encrypt(base64_decode($base64Payload), "AES-256-ECB", $sekBinary, $options);
        $finalEncryptedPayload = base64_encode($encryptedPayload);

        $payload = [
            "action" => "MULTIVEHMOVINT",
            "data" => $finalEncryptedPayload
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'gstin' => $gstin,
            'authtoken' => $authToken,
            'Ocp-Apim-Subscription-Key' => $subscriptionKey,
        ];

        $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";
        $response = Http::withHeaders($headers)->post($url, $payload);
        $jsonResponse = $response->json();

        if (isset($jsonResponse['data'])) {
            $encryptedResponse = base64_decode($jsonResponse['data']);
            $decryptedData = openssl_decrypt($encryptedResponse, $ciphering, $sekBinary, $options);

            if (!$decryptedData) {
                return ['success' => false, 'error' => 'Response decryption failed'];
            }

            return [
                'success' => true,
                'ewaybill_response' => json_decode($decryptedData, true)
            ];
        }

        return [
            'success' => false,
            'error' => $jsonResponse['message'] ?? 'Unknown error'
        ];
    }

   
    public function showAddVehicleForm(Request $request)
   {
    return view('admin.consignments.add_vehicle_form', [
        'ewbNo' => $request->input('ewbNo'),
        'groupNo' => $request->input('groupNo'),
    ]);
   }
//    addmultivehiclefor whitebox public function addMultiVehicle(Request $request)
    public function addMultiVehicleWhitebox(Request $request)
   {
    
    $headers = [
        "ip_address"    => env('EWB_IP_ADDRESS'),
        "client_id"     => env('EWB_CLIENT_ID'),
        "client_secret" => env('EWB_CLIENT_SECRET'),
        "gstin"         => env('EWB_GSTIN'),
        "accept"        => "*/*",
        "Content-Type"  => "application/json"
    ];

    // Request body exactly API format me
        $payload = [
        "ewbNo"         => (int) $request->ewbNo,   // API कुछ cases में string मांगती है
        "vehicleNo"    => strtoupper((string) $request->vehicleNo), // vehicle no capital में
        "groupNo"      => (string) $request->groupNo,
        "transDocNo"   => (string) $request->transDocNo,
        "transDocDate" => date('d/m/Y', strtotime($request->transDocDate)), // dd/MM/yyyy
        "quantity"     => (int) $request->quantity,
    ];


    try {
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/addmulti";
        $query = [
            "email" => env('EWB_EMAIL', 'ask.innovations1@gmail.com')
        ];

        $response = \Http::withHeaders($headers)
            ->withOptions(["verify" => false]) // SSL bypass
            ->post($url . '?' . http_build_query($query), $payload);

        $json = $response->json();

        // Debugging ke liye
        // return($json);

        if ($response->successful() && isset($json['status_cd']) && $json['status_cd'] == "1") {
            // ✅ Vehicle Added Successfully
            $key = "vehicle_added_" . $request->ewbNo . "_" . $request->groupNo;
            session()->put($key, true);

            return view('admin.consignments.add_vehicle_form', [
                'success' => true,
                'ewbNo'   => $request->ewbNo,
                'groupNo' => $request->groupNo,
                'data'    => $json['data'] ?? []
            ]);
        } else {
            // ❌ API Error
            return back()->with('error', $json['status_desc'] ?? 'Add Vehicle Failed');
        }

    } catch (\Exception $e) {
        \Log::error("Whitebox AddMultiVehicle failed: " . $e->getMessage());
        return back()->with('error', $e->getMessage());
    }
}





    // addvehiclemulti for alkkit
    public function callAddVehicleApi_alkit(Request $request)
    {
        $authToken     = env('EWB_AUTH_TOKEN');
        $encryptedSek  = env('EWB_ENCRYPTED_SEK');
        $appKey        = env('EWB_APP_KEY');
        $gstin         = env('EWB_GSTIN');
        $subscriptionKey = env('EWB_API_SUBSCRIPTION_KEY', 'AL5e2V9g1I2p9h4U3e');


        $ciphering = 'AES-256-ECB';
        $options = OPENSSL_RAW_DATA;
        $decryptionKey = base64_decode($appKey);
        $sekBinary = openssl_decrypt(base64_decode($encryptedSek), $ciphering, $decryptionKey, $options);

        if (!$sekBinary) {
            return back()->with('error', 'SEK decryption failed');
        }
        
        $addVehicleData = [
            "ewbNo" => $request->ewbNo,
            "groupNo" => $request->groupNo,
            "vehicleNo" => $request->vehicleNo,
            "transDocNo" => $request->transDocNo,
            "transDocDate" => date('d/m/Y', strtotime($request->transDocDate)),
            "quantity" => $request->quantity,
        ];

        $jsonPayload = json_encode($addVehicleData, JSON_UNESCAPED_SLASHES);
        $base64Payload = base64_encode($jsonPayload);

        $encryptedPayload = openssl_encrypt(base64_decode($base64Payload), $ciphering, $sekBinary, $options);
        $finalEncryptedPayload = base64_encode($encryptedPayload);

        $payload = [
            "action" => "MULTIVEHADD",
            "data" => $finalEncryptedPayload
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'gstin' => $gstin,
            'authtoken' => $authToken,
            'Ocp-Apim-Subscription-Key' => $subscriptionKey,
        ];

        $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";
        $response = Http::withHeaders($headers)->post($url, $payload)->json();
        
        // dd($response); 

        if (isset($response['data'])) {
            $key = "vehicle_added_" . $request->ewbNo . "_" . $request->groupNo;
            session()->put($key, true);
            return view('admin.consignments.add_vehicle_form', [
                'success' => true,
                'ewbNo' => $request->ewbNo,
                'groupNo' => $request->groupNo,
            ]);
        }

        return back()->with('error', $response['message'] ?? 'Add Vehicle Failed');
    }
    

    public function showChangeVehicleForm(Request $request)
   {
    if (!$request->input('ewbNo') || !$request->input('groupNo')) {
        return redirect()->route('admin.consignments.multi_vehicle_initiate')->with('error', 'Invalid Access');
    }

    return view('admin.consignments.change_vehicle_form', [
        'ewbNo' => $request->input('ewbNo'),
        'groupNo' => $request->input('groupNo'),
    ]);
   }
//    callChangeVehicleApi assign_whitebox
public function callChangeVehicleWhitebox(Request $request)
{
    $headers = [
        "ip_address"    => env('EWB_IP_ADDRESS'),
        "client_id"     => env('EWB_CLIENT_ID'),
        "client_secret" => env('EWB_CLIENT_SECRET'),
        "gstin"         => env('EWB_GSTIN'),
        "Accept"        => "application/json",
        "Content-Type"  => "application/json"
    ];

    // ✅ Payload as per API Docs
    
    $payload = [
        "ewbNo"         => (int) $request->ewbNo,          // Number
        "groupNo"       => (int) $request->groupNo,        // Number
        "oldvehicleNo"  => $request->oldvehicleNo,         // 🔹 Small v
        "newVehicleNo"  => $request->newVehicleNo,
        "oldTranNo"     => $request->oldTranNo,
        "newTranNo"     => $request->newTranNo,
        "fromPlace"     => $request->fromPlace,
        "fromState"     => (int) $request->fromState,
        "reasonCode"    => (string) ($request->reasonCode ?? "1"), // String
        "reasonRem"     => $request->reasonRem ?? "Vehicle broke down"
    ];

    try {
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/updtmulti";
        $query = [
            "email" => env('EWB_EMAIL', 'ask.innovations1@gmail.com')
        ];

        $response = \Http::withHeaders($headers)
            ->withOptions(["verify" => false])
            ->post($url . '?' . http_build_query($query), $payload);

        $json = $response->json();

        // 🔹 Debug Response
        if (isset($response['data'])) {
            $key = "vehicle_changed_" . $request->ewbNo . "_" . $request->groupNo;
            session()->put($key, true); // ✅ Save change status
        return back()->with('success', 'Vehicle Changed Successfully');
        } else {
            return back()->with('error', $json['error']['message'] ?? 'Vehicle Change Failed');
        }
    } catch (\Exception $e) {
        \Log::error("Whitebox ChangeVehicle failed: " . $e->getMessage());
        return response()->json([
            "success" => false,
            "message" => $e->getMessage()
        ], 500);
    }
}

//    assign_alkit

   public function callChangeVehicleApi_alkit(Request $request)
   {
        $authToken     = env('EWB_AUTH_TOKEN');
        $encryptedSek  = env('EWB_ENCRYPTED_SEK');
        $appKey        = env('EWB_APP_KEY');
        $gstin         = env('EWB_GSTIN');
        $subscriptionKey = env('EWB_API_SUBSCRIPTION_KEY', 'AL5e2V9g1I2p9h4U3e');


        $ciphering = 'AES-256-ECB';
        $options = OPENSSL_RAW_DATA;
        $decryptionKey = base64_decode($appKey);
        $sekBinary = openssl_decrypt(base64_decode($encryptedSek), $ciphering, $decryptionKey, $options);

        if (!$sekBinary) {
            return back()->with('error', 'SEK decryption failed');
        }

    $changeData = [
        "ewbNo"         => $request->ewbNo,
        "groupNo"       => $request->groupNo,
        "oldvehicleNo"  => $request->oldvehicleNo,
        "newVehicleNo"  => $request->newVehicleNo,
        "oldTranNo"     => $request->oldTranNo,
        "newTranNo"     => $request->newTranNo,
        "fromPlace"     => $request->fromPlace,
        "fromState"     => (int)$request->fromState,
        "reasonCode"    => 1,
        "reasonRem"     => "vehicle broke down"
    ];

    $jsonPayload = json_encode($changeData, JSON_UNESCAPED_SLASHES);
    $base64Payload = base64_encode($jsonPayload);
    $encryptedPayload = openssl_encrypt(base64_decode($base64Payload), $ciphering, $sekBinary, $options);
    $finalEncryptedPayload = base64_encode($encryptedPayload);

    $payload = [
        "action" => "MULTIVEHUPD",
        "data" => $finalEncryptedPayload
    ];

    $headers = [
        'Content-Type' => 'application/json',
        'gstin' => $gstin,
        'authtoken' => $authToken,
        'Ocp-Apim-Subscription-Key' => $subscriptionKey,
    ];

    $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";
    $response = Http::withHeaders($headers)->post($url, $payload)->json();

    if (isset($response['data'])) {
         $key = "vehicle_changed_{$request->ewbNo}_{$request->groupNo}";
         session()->put($key, true); // ✅ Save change status
        return back()->with('success', 'Vehicle Changed Successfully');
    }

    return back()->with('error', $response['message'] ?? 'Vehicle Change Failed');
   }

}

