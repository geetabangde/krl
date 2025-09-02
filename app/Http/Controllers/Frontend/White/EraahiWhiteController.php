<?php

namespace App\Http\Controllers\Frontend\White;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;


class EraahiWhiteController extends Controller
{ 
    // Authentication API

    public function getAccessToken()
    {
        $ip_address     = "49.37.135.42";
        $client_id      = "EWBS8c79e659-4ebf-41ed-a1f3-5dd7182ddc40";
        $client_secret  = "EWBS951c7b10-940a-40da-b850-651f41724b21";
        $gstin          = "23AAGCB1286Q028";
        $email          = "ask.innovations1@gmail.com";
        $username       = "BVMMP";
        $password       = "Bvm@123456";

         $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/authenticate?email={$email}&username={$username}&password={$password}";
         // https://apisandbox.whitebooks.in/ewaybillapi/v1.03/authenticate?email=ask.innovations1%40gmail.com&username=BVMGSP&password=Wbooks%400142
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: */*",
                "ip_address: $ip_address",
                "client_id: $client_id",
                "client_secret: $client_secret",
                "gstin: $gstin"
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return response()->json(json_decode($response, true));
    }

    // Generate Eway Bill

    public function generateEwayBill()
   {
        // API endpoint
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/genewaybill";

        // Headers + Query params
        $headers = [
            "ip_address"    => "49.37.135.42",  
            "client_id"     => "EWBS8c79e659-4ebf-41ed-a1f3-5dd7182ddc40",
            "client_secret" => "EWBS951c7b10-940a-40da-b850-651f41724b21",
            "gstin"         => "23AAGCB1286Q028"
        ];

        $query = [
            "email" => "ask.innovations1@gmail.com"
        ];

        // ✅ Fixed Payload (all enums & numbers in correct type)
       $payload = [
        "supplyType"        => "O",       
        "subSupplyType"     => "5",       
        "subSupplyDesc"     => "",
        "docType"           => "CHL",     
        "docNo"             => "doc/087787",
        "docDate"           => "02/09/2025",  

        "fromGstin"         => "23AAGCB1286Q028",
        "fromTrdName"       => "welton",
        "fromAddr1"         => "2ND CROSS NO 59 19 A",
        "fromAddr2"         => "GROUND FLOOR OSBORNE ROAD",
        "fromPlace"         => "FRAZER TOWN",
        "fromPincode"       => 560001,    
        "actFromStateCode"  => 29,       
        "fromStateCode"     => 23,        

        "toGstin"           => "23AAGCB1286Q028",
        "toTrdName"         => "sthuthya",
        "toAddr1"           => "Shree Nilaya",
        "toAddr2"           => "Dasarahosahalli",
        "toPlace"           => "Beml Nagar",
        "toPincode"         => 560090,    
        "actToStateCode"    => 29,        
        "toStateCode"       => 29,       
        "transactionType"   => 4,         
        "otherValue"        => -100,      

        "totalValue"        => 56099,
        "cgstValue"         => 300.67,   
        "sgstValue"         => 300.67,
        "igstValue"         => 0,
        "cessValue"         => 400.56,
        "cessNonAdvolValue" => 400,
        "totInvValue"       => 68358,
        "transporterId"     => "23AAGCB1286Q028",
        "transMode"         => "1",       
        "transDistance"     => "15",    
        "vehicleNo"         => "PVC1234",
        "vehicleType"       => "R",       
        "itemList" => [
            [
                "productName"   => "Wheat",
                "productDesc"   => "Wheat",
                "hsnCode"       => 1001,      
                "quantity"      => 4,        
                "qtyUnit"       => "BOX",    
                "cgstRate"      => 1.5,
                "sgstRate"      => 1.5,
                "igstRate"      => 0,
                "cessRate"      => 3,
                "cessNonadvol"  => 0,
                "taxableAmount" => 5609889    
            ]
        ]
    ];
        // Call API
        $response = Http::withHeaders($headers)
            ->withOptions(["verify" => false]) // disable SSL verify in sandbox
            ->post($url . '?' . http_build_query($query), $payload);

        return response()->json([
            "status"   => $response->status(),
            // "request"  => $payload,
            "response" => $response->json()
        ]);
    }

    // Update PART-B/Vehicle Number

    public function updatePartB(Request $request)
    {
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/vehewb";

        $headers = [
            "ip_address"    => "49.37.135.42",
            "client_id"     => "EWBS8c79e659-4ebf-41ed-a1f3-5dd7182ddc40",
            "client_secret" => "EWBS951c7b10-940a-40da-b850-651f41724b21",
            "gstin"         => "29AAGCB1286Q000"
        ];

        $query = [
            "email" => "ask.innovations1@gmail.com"
        ];

        $payload = [
            "ewbNo"       => $request->ewbNo ?? 171011776250, // Valid EWB Number
            "vehicleNo"   => $request->vehicleNo ?? "KA01AB1234", // Valid RTO Format
            "fromPlace"   => $request->fromPlace ?? "FRAZER TOWN",
            "fromState"   => $request->fromState ?? 29,
            "reasonCode"  => $request->reasonCode ?? "1",
            "reasonRem"   => $request->reasonRem ?? "Due to Break Down",
            "transDocNo"  => $request->transDocNo ?? "12",
            "transDocDate"=> $request->transDocDate ?? "29/08/2025",
            "transMode"   => $request->transMode ?? "1"
            
        ];

        $response = Http::withHeaders($headers)
            ->withOptions(["verify" => false])
            ->post($url . '?' . http_build_query($query), $payload);

        $json = $response->json();

        if (isset($json["status_cd"]) && $json["status_cd"] == "1") {
            return response()->json($json);
        }

        return response()->json([
            "error" => "Invalid or failed API response",
            "details" => $json
        ]);
    }


    // Get EwayBill Details

    public function getEwayBillDetails(Request $request)
    {
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/getewaybill";

        // Required headers
        $headers = [
            "ip_address"    => "49.37.135.42",
            "client_id"     => "EWBS8c79e659-4ebf-41ed-a1f3-5dd7182ddc40",
            "client_secret" => "EWBS951c7b10-940a-40da-b850-651f41724b21",
            "gstin"         => "23AAGCB1286Q028",
            "accept"        => "*/*"
        ];

        // Required query parameters
        $query = [
            "email" => "ask.innovations1@gmail.com",
            "ewbNo" => $request->ewbNo ?? "171011776250"
        ];

        try {
            $response = Http::withHeaders($headers)
                ->withOptions(["verify" => false])
                ->get($url, $query);

            $json = $response->json();

            if (isset($json["status_cd"]) && $json["status_cd"] == "1") {
                return response()->json($json);
            }

            return response()->json([
                "error" => "Invalid or failed API response",
                "details" => $json
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "API request failed",
                "message" => $e->getMessage()
            ], 500);
        }
    }
    // Get EwayBill Report By Transporter assigned Date

    public function getEwayBillReportByTransporterDate(Request $request)
    {
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/getewaybillreportbytransporterassigneddate";

        // Required headers
        $headers = [
            "ip_address"    => "49.37.135.42",
            "client_id"     => "EWBS8c79e659-4ebf-41ed-a1f3-5dd7182ddc40",
            "client_secret" => "EWBS951c7b10-940a-40da-b850-651f41724b21",
            "gstin"         => "23AAGCB1286Q028",
            "accept"        => "*/*"
        ];

        // Query params
        $query = [
            "email"     => "ask.innovations1@gmail.com",
            "date"      => $request->date ?? "02/09/2025", // Date format must be dd/MM/yyyy
            "stateCode" => $request->stateCode ?? "23"
        ];

        try {
            $response = Http::withHeaders($headers)
                ->withOptions(["verify" => false])
                ->get($url, $query);

            $json = $response->json();

            if (isset($json["status_cd"]) && $json["status_cd"] == "1") {
                return response()->json($json);
            }

            return response()->json([
                "error" => "Invalid or failed API response",
                "details" => $json
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "API request failed",
                "message" => $e->getMessage()
            ], 500);
        }
    }
    
    // Add Multi Vehicles

    public function initiateMultiVehicle(Request $request)
    {
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/initmulti";

        // Headers
        $headers = [
            "ip_address"    => "49.37.135.42",
            "client_id"     => "EWBS8c79e659-4ebf-41ed-a1f3-5dd7182ddc40",
            "client_secret" => "EWBS951c7b10-940a-40da-b850-651f41724b21",
            "gstin"         => "07AGAPA5363L002",
            "accept"        => "*/*",
            "Content-Type"  => "application/json",
        ];

        // Query params
        $query = [
            "email" => "ask.innovations1@gmail.com"
        ];

        // Payload (request body)
        $payload = [
            "ewbNo"         => $request->ewbNo ?? 171011776250, // Valid EWB Number
            "fromPlace"     => $request->fromPlace ?? "FRAZER TOWN",
            "fromState"     => $request->fromState ?? 29,
            "toPlace"       => $request->toPlace ?? "Beml Nagar",
            "toState"       => $request->toState ?? 5,
            "reasonCode"    => $request->reasonCode ?? "1",
            "reasonRem"     => $request->reasonRem ?? "Due to Break Down",
            "totalQuantity" => $request->totalQuantity ?? 1,
            "unitCode"      => $request->unitCode ?? "BOX",
            "transMode"     => $request->transMode ?? "1"
        ];

        try {
            $response = Http::withHeaders($headers)
                ->withOptions(["verify" => false])
                ->post($url . '?' . http_build_query($query), $payload);

            $json = $response->json();

            if (isset($json["status_cd"]) && $json["status_cd"] == "1") {
                return response()->json($json);
            }

            return response()->json([
                "error" => "Invalid or failed API response",
                "details" => $json
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error"   => "API request failed",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    // Add Multi Vehicles
    public function addMultiVehicles(Request $request)
    {
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/addmulti";

        // Headers
        $headers = [
            "ip_address"    => "49.37.135.42",
            "client_id"     => "EWBS8c79e659-4ebf-41ed-a1f3-5dd7182ddc40",
            "client_secret" => "EWBS951c7b10-940a-40da-b850-651f41724b21",
            "gstin"         => "07AGAPA5363L002",
            "accept"        => "*/*",
            "Content-Type"  => "application/json",
        ];

        // Query params
        $query = [
            "email" => "ask.innovations1@gmail.com"
        ];

        // Payload (request body)
        $payload = [
            "ewbNo"        => $request->ewbNo ?? 171011776250,
            "vehicleNo"    => $request->vehicleNo ?? "ABC1234",
            "groupNo"      => $request->groupNo ?? "1",
            "transDocNo"   => $request->transDocNo ?? "12",
            "transDocDate" => $request->transDocDate ?? "11/12/2024",
            "quantity"     => $request->quantity ?? 1
        ];

        try {
            $response = Http::withHeaders($headers)
                ->withOptions(["verify" => false])
                ->post($url . '?' . http_build_query($query), $payload);

            $json = $response->json();

            if (isset($json["status_cd"]) && $json["status_cd"] == "1") {
                return response()->json($json);
            }

            return response()->json([
                "error" => "Invalid or failed API response",
                "details" => $json
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error"   => "API request failed",
                "message" => $e->getMessage()
            ], 500);
        }
    }
    // Change Multi Vehicles

    public function changeMultiVehicles(Request $request)
    {
        $url = "https://apisandbox.whitebooks.in/ewaybillapi/v1.03/ewayapi/updtmulti";

        // Headers
        $headers = [
            "ip_address"    => "49.37.135.42",
            "client_id"     => "EWBS8c79e659-4ebf-41ed-a1f3-5dd7182ddc40",
            "client_secret" => "EWBS951c7b10-940a-40da-b850-651f41724b21",
            "gstin"         => "07AGAPA5363L002",
            "accept"        => "*/*",
            "Content-Type"  => "application/json",
        ];

        // Query params
        $query = [
            "email" => "ask.innovations1@gmail.com"
        ];

        // Request payload
        $payload = [
            "ewbNo"        => $request->ewbNo ?? 171011776250,
            "groupNo"      => $request->groupNo ?? 1,
            "oldvehicleNo" => $request->oldvehicleNo ?? "ABC1234",
            "newVehicleNo" => $request->newVehicleNo ?? "ABC4321",
            "oldTranNo"    => $request->oldTranNo ?? "sumitra/06/2020",
            "newTranNo"    => $request->newTranNo ?? "sumitra/06/2021",
            "fromPlace"    => $request->fromPlace ?? "FRAZER TOWN",
            "fromState"    => $request->fromState ?? 29,
            "reasonCode"   => $request->reasonCode ?? "1",
            "reasonRem"    => $request->reasonRem ?? "Due to Break Down",
        ];

        try {
            $response = Http::withHeaders($headers)
                ->withOptions(["verify" => false])
                ->post($url . '?' . http_build_query($query), $payload);

            $json = $response->json();

            if (isset($json["status_cd"]) && $json["status_cd"] == "1") {
                return response()->json($json);
            }

            return response()->json([
                "error"   => "Invalid or failed API response",
                "details" => $json
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error"   => "API request failed",
                "message" => $e->getMessage()
            ], 500);
        }
    }


}


// requested payloads
// trsporterbygstin

// {
//   "supplyType": "O",
//   "subSupplyType": "5",
//   "subSupplyDesc": " ",
//   "docType": "CHL",
//   "docNo": "ratna/098",
//   "docDate": "01/09/2025",
//   "fromGstin": "23AAGCB1286Q028",
//   "fromTrdName": "welton",
//   "fromAddr1": "2ND CROSS NO 59  19  A",
//   "fromAddr2": "GROUND FLOOR OSBORNE ROAD",
//   "fromPlace": "FRAZER TOWN",
//   "actFromStateCode": 29,
//   "fromPincode": 560001,
//   "fromStateCode": 23,
//   "toGstin": "23AAGCB1286Q028",
//   "toTrdName": "sthuthya",
//   "toAddr1": "Shree Nilaya",
//   "toAddr2": "Dasarahosahalli",
//   "toPlace": "Beml Nagar",
//   "toPincode": 263652,
//   "actToStateCode": 5,
//   "toStateCode": 5,
//   "transactionType": 4,
//   "dispatchFromGSTIN": "29AAAAA1303P1ZV",
//   "dispatchFromTradeName": "ABC Traders",
//   "shipToGSTIN": "29ALSPR1722R1Z3",
//   "shipToTradeName": "XYZ Traders",
//   "totalValue": 56099,
//   "cgstValue": 0,
//   "sgstValue": 0,
//   "igstValue": 300.67,
//   "cessValue": 400.56,
//   "cessNonAdvolValue": 400,
//   "totInvValue": 57200.23,
//   "transMode": "1",
//   "transDistance": "2487",
//   "transporterName": "",
//   "transporterId": "23AAGCB1286Q028",
//   "transDocNo": "12",
//   "transDocDate": "",
//   "vehicleNo": "APR3214",
//   "vehicleType": "R",
//   "itemList": [
//     {
//       "productName": "Wheat",
//       "productDesc": "Wheat",
//       "hsnCode": 1001,
//       "quantity": 4,
//       "qtyUnit": "BOX",
//       "taxableAmount": 56099,
//       "sgstRate": 0,
//       "cgstRate": 0,
//       "igstRate": 3,
//       "cessRate": 0
//     }
//   ]
// }