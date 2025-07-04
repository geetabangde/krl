<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Destination;
use App\Models\Contract;
use App\Models\VehicleType;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContractController extends Controller implements HasMiddleware

{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage contract', only: ['index']),
            new Middleware('admin.permission:create contract', only: ['create']),
            new Middleware('admin.permission:edit contract', only: ['edit']),
            new Middleware('admin.permission:delete contract', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $contracts = Contract::all();
        // Fetch related data for mapping
        $vehicles = VehicleType::pluck('vehicletype', 'id')->toArray(); // [id => type]
        $locations = Destination::pluck('destination', 'id')->toArray(); // [id => name]
        $contracts = Contract::with('vehicle', 'fromDestination', 'toDestination')->get();

        return view('admin.contract.index', compact('users','contracts','vehicles','locations'));
    }
    
   
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id); 
        $vehicles = VehicleType::all();
        $destinations = Destination::all();
        $contracts = Contract::with('vehicle', 'fromDestination', 'toDestination')->get();
    
        return view('admin.contract.view', compact('user', 'vehicles', 'destinations','contracts'));
    }

    public function getRate(Request $request)
    {
        // return response()->json($request->all());
        try {
            // Get values from the request
            $customer_id = $request->customer_id; // Customer ID
            $vehicle_type = $request->vehicle_type;
            $from_location = $request->from_location;
            $to_location = $request->to_location;
    
            // Fetch rate from the Contract model based on vehicle type, from location, and to location
            $rate = Contract::where('type_id', $vehicle_type)
                            ->where('from_destination_id', $from_location)
                            ->where('to_destination_id', $to_location)
                            ->where('user_id', $customer_id)
                            ->value('rate');
                           
            // Return rate if found
            if ($rate) {
                return response()->json(['rate' => $rate, 'customer_id' => $customer_id]);
            } else {
                return response()->json(['rate' => null, 'message' => 'No rate found for this selection.'], 404);
            }
        } catch (\Exception $e) {
            // Return error message if any exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    

    public function store(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $vehicleTypes = $request->input('vehicletype'); // array of arrays
        $rates = $request->input('rate'); // array of arrays
        $descriptions = $request->input('description'); // array of descriptions
        $user_id = $request->input('user_id');
    
        // Loop through each from-to pair
        for ($i = 0; $i < count($from); $i++) {
            $fromDestination = $from[$i];
            $toDestination = $to[$i];
    
            // Check if both from and to exist
            if (empty($fromDestination) || empty($toDestination)) {
                continue;
            }
    
            // Check if vehicle and rate blocks exist for this from-to pair
            if (isset($vehicleTypes[$i]) && isset($rates[$i])) {
                for ($j = 0; $j < count($vehicleTypes[$i]); $j++) {
                    $vehicleType = $vehicleTypes[$i][$j];
                    $rate = $rates[$i][$j];
                    $description = $descriptions[$i][$j]; // Assign the description for this vehicleType and rate
    
                    if (empty($vehicleType) || !is_numeric($rate)) {
                        continue;
                    }
    
                    // Store in DB
                  Contract::create([
                        'type_id' => $vehicleType,
                        'from_destination_id' => $fromDestination,
                        'to_destination_id' => $toDestination,
                        'user_id' => $user_id,
                        'rate' => $rate,
                       'description' => $description, // Now using the $description variable
                    ]);
                }
            }
        }
    
        return redirect()->route('admin.contract.index')->with('success', 'Contract created successfully');
    }
    
    
    
   

    /**
     * Show the form for editing the specified resource.
     */

     public function update(Request $request, $id)
{
    // Step 1: Validate input (excluding 'documents' field)
    $request->validate([
        'vehicletype' => 'required|integer|exists:vehicle_types,id',
        'from' => 'required|integer|exists:destinations,id',
        'to' => 'required|integer|exists:destinations,id',
        'rate' => 'required|numeric',
        'description' => 'required',
        'documents' => 'nullable|array', // Allow null or an array of files
    ]);

    // Step 2: Find the contract
    $contract = Contract::findOrFail($id);
    $contract->type_id = $request->vehicletype;
    $contract->from_destination_id = $request->from;
    $contract->to_destination_id = $request->to;
    $contract->rate = $request->rate;
    $contract->description = $request->description;

    if ($request->hasFile('documents')) {
    $documentPaths = [];

    // 🧪 Debugging: Check file names
    foreach ($request->file('documents') as $file) {
        if ($file->isValid()) {
            \Log::info('Uploaded File: ' . $file->getClientOriginalName());

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            // Move file to 'uploads' folder
            $file->move(public_path('uploads'), $filename);
            // Store path
            $documentPaths[] = 'uploads/' . $filename;
        }
    }

        if (!empty($documentPaths)) {
            $contract->documents = json_encode($documentPaths); // Save paths as JSON
        }
    }
    $contract->save();
    

    return redirect()->back()->with('success', 'Contract updated successfully.');
}
       public function destroy($id)
    {
        try {

            $tyre = Contract::findOrFail($id);

            if ($tyre->delete()) {
                return redirect()->route('admin.contract.index')->with('success', 'Destination deleted successfully!');
            }

            return redirect()->route('admin.contract.index')->with('error', 'Failed to delete the tyre.');
        } catch (Exception $e) {
            return redirect()->route('admin.contract.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
