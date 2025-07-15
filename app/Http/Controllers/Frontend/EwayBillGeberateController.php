<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class EwayBillGeberateController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';


// public function generateEwayBill(Request $request)
// {
//     // 1. Required credentials
//     $authToken = '1kvg6aeYu1G2ZGnaNFQbzfTKE'; // Replace with actual
//     $encryptedSek = 'gRk5LWrUQe7okNMXdZS3+vgxQwguU2tDQU76ZCr1IMFGgCjhGmGONERdukDluIoA';
//     $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE=';

//     // 2. Decrypt SEK
//     $ciphering = 'AES-256-ECB';
//     $options = 0;
//     $decryptionKey = base64_decode($appKey);
//     $decryption_iv = '';

//     $decryptedSek = openssl_decrypt($encryptedSek, $ciphering, $decryptionKey, $options, $decryption_iv);
//     $base64encodedDecryptedSek = base64_encode($decryptedSek);

//     // dd($base64encodedDecryptedSek);
   

//     if ($decryptionKey === false || $decryptedSek === false) {
//         return response()->json(['error' => 'Invalid appKey or SEK decryption failed.'], 400);
//     }

//     // 3. Prepare E-Way Bill Payload
//     $requestPayload = [
//         "supplyType" => "O",
//         "subSupplyType" => "1",
//         "subSupplyDesc" => "",
//         "docType" => "INV",
//         "docNo" => "Test85s105",
//         "docDate" => "09/07/2025",
//         "fromGstin" => "23AABFM6400F1ZX",
//         "fromTrdName" => "welton",
//         "fromAddr1" => "2ND CROSS NO 59  19  A",
//         "fromAddr2" => "GROUND FLOOR OSBORNE ROAD",
//         "fromPlace" => "FRAZER TOWN",
//         "fromPincode" => 110055,
//         "actFromStateCode" => 07,
//         "fromStateCode" => 07,
//         "toGstin" => "07AGAPA5363L002",
//         "toTrdName" => "sthuthya",
//         "toAddr1" => "Shree Nilaya",
//         "toAddr2" => "Dasarahosahalli",
//         "toPlace" => "Beml Nagar",
//         "toPincode" => 560090,
//         "actToStateCode" => 29,
//         "toStateCode" => 27,
//         "transactionType" => 4,
//         "otherValue" => -100,
//         "totalValue" => 56099,
//         "cgstValue" => 0,
//         "sgstValue" => 0,
//         "igstValue" => 300.67,
//         "cessValue" => 400.56,
//         "cessNonAdvolValue" => 400,
//         "totInvValue" => 57200.23,
//         "transporterId" => "07AGAPA5363L002",
//         "transporterName" => "",
//         "transDocNo" => "",
//         "transMode" => "1",
//         "transDistance" => "2145",
//         "transDocDate" => "",
//         "vehicleNo" => "PVC1234",
//         "vehicleType" => "R",
//         "itemList" => [
//             [
//                 "productName" => "Wheat",
//                 "productDesc" => "Wheat",
//                 "hsnCode" => 1001,
//                 "quantity" => 4,
//                 "qtyUnit" => "BOX",
//                 "cgstRate" => 0,
//                 "sgstRate" => 0,
//                 "igstRate" => 3,
//                 "cessRate" => 3,
//                 "cessNonadvol" => 0,
//                 "taxableAmount" => 56099
//             ]
//         ]
//     ];

//     // 4. Encode and encrypt the payload
//     $Base64RequestPayload = base64_encode(json_encode($requestPayload));
    
//     // Encrypt with SEK
//     $encryptedPayload = openssl_encrypt(
//         base64_decode($Base64RequestPayload),
//         "aes-256-ecb",
//         base64_decode($base64encodedDecryptedSek),
//         0
//     );

//     $finalPayload = [
//         "action" => "GENEWAYBILL",
//         "data" => $encryptedPayload
//     ];
//     // dd($finalPayload);
//      $data = "ewogICJzdXBwbHlUeXBlIjogIk8iLAogICJzdWJTdXBwbHlUeXBlIjogIjEiLAogICJzdWJTdXBwbHlEZXNjIjogIiIsCiAgImRvY1R5cGUiOiAiSU5WIiwKICAiZG9jTm8iOiAiVGU4NXMxMDUiLAogICJkb2NEYXRlIjogIjA0LzA3LzIwMjUiLAogICJmcm9tR3N0aW4iOiAiMjNBQUJGTTY0MDBGMVpYIiwKICAiZnJvbVRyZE5hbWUiOiAid2VsdG9uIiwKICAiZnJvbUFkZHIxIjogIjJORCBDUk9TUyBOTyA1OSAgMTkgIEEiLAogICJmcm9tQWRkcjIiOiAiR1JPVU5EIEZMT09SIE9TQk9STkUgUk9BRCIsCiAgImZyb21QbGFjZSI6ICJGUkFaRVIgVE9XTiIsCiAgImZyb21QaW5jb2RlIjogMTEwMDU1LAogICJhY3RGcm9tU3RhdGVDb2RlIjogNywKICAiZnJvbVN0YXRlQ29kZSI6IDcsCiAgInRvR3N0aW4iOiAiMDdBR0FQQTUzNjNMMDAyIiwKICAidG9UcmROYW1lIjogInN0aHV0aHlhIiwKICAidG9BZGRyMSI6ICJTaHJlZSBOaWxheWEiLAogICJ0b0FkZHIyIjogIkRhc2FyYWhvc2FoYWxsaSIsCiAgInRvUGxhY2UiOiAiQmVtbCBOYWdhciIsCiAgInRvUGluY29kZSI6IDU2MDA5MCwKICAiYWN0VG9TdGF0ZUNvZGUiOiAyOSwKICAidG9TdGF0ZUNvZGUiOiAyNywKICAidHJhbnNhY3Rpb25UeXBlIjogNCwKICAib3RoZXJWYWx1ZSI6IC0xMDAsCiAgInRvdGFsVmFsdWUiOiA1NjA5OSwKICAiY2dzdFZhbHVlIjogMCwKICAic2dzdFZhbHVlIjogMCwKICAiaWdzdFZhbHVlIjogMzAwLjY3LAogICJjZXNzVmFsdWUiOiA0MDAuNTYsCiAgImNlc3NOb25BZHZvbFZhbHVlIjogNDAwLAogICJ0b3RJbnZWYWx1ZSI6IDU3MjAwLjIzLAogICJ0cmFuc3BvcnRlcklkIjogIjA3QUdBUEE1MzYzTDAwMiIsCiAgInRyYW5zcG9ydGVyTmFtZSI6ICIiLAogICJ0cmFuc0RvY05vIjogIiIsCiAgInRyYW5zTW9kZSI6ICIxIiwKICAidHJhbnNEaXN0YW5jZSI6ICIyMTQ1IiwKICAidHJhbnNEb2NEYXRlIjogIiIsCiAgInZlaGljbGVObyI6ICJQVkMxMjM0IiwKICAidmVoaWNsZVR5cGUiOiAiUiIsCiAgIml0ZW1MaXN0IjogWwogICAgewogICAgICAicHJvZHVjdE5hbWUiOiAiV2hlYXQiLAogICAgICAicHJvZHVjdERlc2MiOiAiV2hlYXQiLAogICAgICAiaHNuQ29kZSI6IDEwMDEsCiAgICAgICJxdWFudGl0eSI6IDQsCiAgICAgICJxdHlVbml0IjogIkJPWCIsCiAgICAgICJjZ3N0UmF0ZSI6IDAsCiAgICAgICJzZ3N0UmF0ZSI6IDAsCiAgICAgICJpZ3N0UmF0ZSI6IDMsCiAgICAgICJjZXNzUmF0ZSI6IDMsCiAgICAgICJjZXNzTm9uYWR2b2wiOiAwLAogICAgICAidGF4YWJsZUFtb3VudCI6IDU2MDk5CiAgICB9CiAgXQp9Cg==";
//     // 5. Call the API
//     $response = Http::withHeaders([
//         'Content-Type' => 'application/json',
//         'gstin' => '23AABFM6400F1ZX',
//         'Ocp-Apim-Subscription-Key' => 'AL5e2V9g1I2p9h4U3e',
//         'authtoken' => $authToken,
        
//     ])->withBody(json_encode($finalPayload), 'application/json')
//       ->post('https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi');

//     $responseJson = $response->json();

//     // dd($responseJson);
    

//      // 6. Decrypt response
//         if (isset($responseJson['data']) && !empty($responseJson['data'])) {
//             $decryptedResponse = openssl_decrypt(
//                 $responseJson['data'], // Fixed: Directly use response data (no base64_encode)
//                 $ciphering,
//                 base64_decode($base64encodedDecryptedSek),
//                 $options
//             );
            
//             if ($decryptedResponse === false) {
//                 return response()->json([
//                     'success' => false,
//                     'error' => 'Response decryption failed.',
//                     'response' => $responseJson
//                 ]);
//             }

//             return response()->json([
//                 'success' => true,
//                 'eway_bill_data' => json_decode(base64_decode($decryptedResponse), true),
//                 'alert' => $responseJson['alert'] ?? null,
//             ]);
//         } else {
//             return response()->json([
//                 'success' => false,
//                 'error' => 'No data returned from API.',
//                 'response' => $responseJson
//             ]);
//         }

// }


// {
//   "supplyType": "O",
//   "subSupplyType": "1",
//   "subSupplyDesc": "",
//   "docType": "INV",
//   "docNo": "Test098547",
//   "docDate": "09/07/2025",
//   "fromGstin": "23AABFM6400F1ZX",
//   "fromTrdName": "welton",
//   "fromAddr1": "2ND CROSS NO 59  19  A",
//   "fromAddr2": "GROUND FLOOR OSBORNE ROAD",
//   "fromPlace": "FRAZER TOWN",
//   "fromPincode": 110055,
//   "actFromStateCode": 23,
//   "fromStateCode": 23,
//   "toGstin": "07AGAPA5363L002",
//   "toTrdName": "sthuthya",
//   "toAddr1": "Shree Nilaya",
//   "toAddr2": "Dasarahosahalli",
//   "toPlace": "Beml Nagar",
//   "toPincode": 560090,
//   "actToStateCode": 29,
//   "toStateCode": 27,
//   "transactionType": 4,
//   "otherValue": "-100",
//   "totalValue": 56099,
//   "cgstValue": 0,
//   "sgstValue": 0,
//   "igstValue": 300.67,
//   "cessValue": 400.56,
//   "cessNonAdvolValue": 400,
//   "totInvValue": 68358,
//   "transporterId": "07AGAPA5363L002",
//   "transporterName": "",
//   "transDocNo": "",
//   "transMode": "1",
//   "transDistance": "2145",
//   "transDocDate": "",
//   "vehicleNo": "PVC1234",
//   "vehicleType": "R",
//   "itemList": [
//     {
//       "productName": "Wheat",
//       "productDesc": "Wheat",
//       "hsnCode": 1001,
//       "quantity": 4,
//       "qtyUnit": "BOX",
//       "cgstRate": 0,
//       "sgstRate": 0,
//       "igstRate": 3,
//       "cessRate": 3,
//       "cessNonadvol": 0,
//       "taxableAmount": 5609889
//     }
//   ]
// }




public function generateEwayBill(Request $request)
{
    // 🔐 Step 1: Credentials and config
    $authToken = '15T7ou9Mt1iyrPja72ppZQt2h'; 
    $encryptedSek = 'cn2H9QXMWWQkTyH2kinv6bH3y8CPn5Nc87AKchEr2AxGgCjhGmGONERdukDluIoA'; 
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE=';
    $gstin = '07AGAPA5363L002'; 

    // 💡 Decrypt SEK
    $decryptionKey = base64_decode($appKey);
    $sek = openssl_decrypt(
        base64_decode($encryptedSek),
        'AES-256-ECB',
        $decryptionKey,
        OPENSSL_RAW_DATA
    );

    if (!$sek) {
        return response()->json(['success' => false, 'message' => 'SEK decryption failed']);
    }

    // 🟩 Step 2: Use your manually generated Base64 JSON payload (from CodeBeautify)
    $base64JsonPayload = 'ewoJInN1cHBseVR5cGUiOiAiTyIsCgkic3ViU3VwcGx5VHlwZSI6ICIxIiwKCSJzdWJTdXBwbHlEZXNjIjogIiIsCgkiZG9jVHlwZSI6ICJJTlYiLAoJImRvY05vIjogIlRlc3Q4NTQ3MjAyNSIsCgkiZG9jRGF0ZSI6ICIxNS8wNy8yMDI1IiwKCSJmcm9tR3N0aW4iOiAiMDdBR0FQQTUzNjNMMDAyIiwKCSJmcm9tVHJkTmFtZSI6ICJ3ZWx0b24iLAoJImZyb21BZGRyMSI6ICIyTkQgQ1JPU1MgTk8gNTkgIDE5ICBBIiwKCSJmcm9tQWRkcjIiOiAiR1JPVU5EIEZMT09SIE9TQk9STkUgUk9BRCIsCgkiZnJvbVBsYWNlIjogIkZSQVpFUiBUT1dOIiwKCSJmcm9tUGluY29kZSI6IDExMDA1NSwKCSJhY3RGcm9tU3RhdGVDb2RlIjogMDcsCgkiZnJvbVN0YXRlQ29kZSI6IDA3LAoJInRvR3N0aW4iOiAiMDJBQUpGSDczNzZQMVpTIiwKCSJ0b1RyZE5hbWUiOiAic3RodXRoeWEiLAoJInRvQWRkcjEiOiAiU2hyZWUgTmlsYXlhIiwKCSJ0b0FkZHIyIjogIkRhc2FyYWhvc2FoYWxsaSIsCgkidG9QbGFjZSI6ICJCZW1sIE5hZ2FyIiwKCSJ0b1BpbmNvZGUiOiA1NjAwOTAsCgkiYWN0VG9TdGF0ZUNvZGUiOiAyOSwKCSJ0b1N0YXRlQ29kZSI6IDI3LAoJInRyYW5zYWN0aW9uVHlwZSI6IDQsCgkib3RoZXJWYWx1ZSI6ICItMTAwIiwKCSJ0b3RhbFZhbHVlIjogNTYwOTksCgkiY2dzdFZhbHVlIjogMCwKCSJzZ3N0VmFsdWUiOiAwLAoJImlnc3RWYWx1ZSI6IDMwMC42NywKCSJjZXNzVmFsdWUiOiA0MDAuNTYsCgkiY2Vzc05vbkFkdm9sVmFsdWUiOiA0MDAsCgkidG90SW52VmFsdWUiOiA2ODM1OCwKCSJ0cmFuc3BvcnRlcklkIjogIiIsCgkidHJhbnNwb3J0ZXJOYW1lIjogIiIsCgkidHJhbnNEb2NObyI6ICIiLAoJInRyYW5zTW9kZSI6ICIxIiwKCSJ0cmFuc0Rpc3RhbmNlIjogIjIxNDUiLAoJInRyYW5zRG9jRGF0ZSI6ICIiLAoJInZlaGljbGVObyI6ICJQVkMxMjM0IiwKCSJ2ZWhpY2xlVHlwZSI6ICJSIiwKCSJpdGVtTGlzdCI6IFt7CgkJInByb2R1Y3ROYW1lIjogIldoZWF0IiwKCQkicHJvZHVjdERlc2MiOiAiV2hlYXQiLAoJCSJoc25Db2RlIjogMTAwMSwKCQkicXVhbnRpdHkiOiA0LAoJCSJxdHlVbml0IjogIkJPWCIsCgkJImNnc3RSYXRlIjogMCwKCQkic2dzdFJhdGUiOiAwLAoJCSJpZ3N0UmF0ZSI6IDMsCgkJImNlc3NSYXRlIjogMywKCQkiY2Vzc05vbmFkdm9sIjogMCwKCQkidGF4YWJsZUFtb3VudCI6IDU2MDk4ODkKCX1dCn0='; // 🔁 Paste your full base64 JSON payload here

    // 🔐 Step 3: Encrypt Base64 JSON using SEK
    $encryptedPayload = openssl_encrypt(
        base64_decode($base64JsonPayload), // decode before encrypt
        'AES-256-ECB',
        $sek,
        OPENSSL_RAW_DATA
    );

    if (!$encryptedPayload) {
        return response()->json(['success' => false, 'message' => 'Payload encryption failed']);
    }

    $finalPayload = base64_encode($encryptedPayload); // re-encode after encrypting

    // 📦 Step 4: Prepare API payload
    $postPayload = [
        "action" => "GENEWAYBILL",
        "data" => $finalPayload
    ];

    // 📡 Step 5: Headers
    $headers = [
        'Content-Type' => 'application/json',
        'gstin' => $gstin,
        'Ocp-Apim-Subscription-Key' => 'AL5e2V9g1I2p9h4U3e',
        'authtoken' => $authToken
    ];

    // 📤 Step 6: API Call
    $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";
    $response = Http::withHeaders($headers)->post($url, $postPayload);
    $responseJson = $response->json();

    // 🔓 Step 7: Decrypt response
    if (isset($responseJson['data'])) {
        $decrypted = openssl_decrypt(
            base64_decode($responseJson['data']),
            'AES-256-ECB',
            $sek,
            OPENSSL_RAW_DATA
        );

        return response()->json([
            'success' => true,
            'ewaybill_response' => json_decode($decrypted, true)
        ]);
    } else {
        return response()->json([
            'success' => false,
            'error' => $responseJson
        ]);
    }
}

}
