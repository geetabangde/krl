<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class EwayConsolidatedController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';


public function generateConsolidatedEwaybill(Request $request)
{
    $authToken = '1XFueYGyTLOg1tXRprgDmuUFM'; 
    $encryptedSek = 'n2vIuPKJEgcU/EYoIWXEWVQZbK+un1BejO2mC8e49cZGgCjhGmGONERdukDluIoA'; 
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE='; 
    $gstin = '07AGAPA5363L002'; 

    $ciphering = 'AES-256-ECB';
    $options = OPENSSL_RAW_DATA;
    $decryptionKey = base64_decode($appKey);

   

    // Step 1: Decrypt SEK
    $sekBinary = openssl_decrypt(
        base64_decode($encryptedSek),
        $ciphering,
        $decryptionKey,
        $options
    );
     

    if (!$sekBinary) {
        return response()->json(['success' => false, 'error' => 'SEK decryption failed', 'openssl_error' => openssl_error_string()], 500);
    }

    // Step 2: Prepare payload for GENCONEWB (Consolidated EWB Generation)
    $vehicleData = [
        "fromPlace" => "BANGALORE",
        "fromState" => 29,
        "vehicleNo" => "PQR1234",
        "vehicleType" => "R",
        "transMode" => "1",
        "transDocNo" => "TRANS1456",
        "transDocDate" => "03/07/2025",
        "tripSheetEwbBills" => [
            ["ewbNo" => 681011955815]
           
        ]
    ];


    $RequestPayload = json_encode($vehicleData, JSON_UNESCAPED_SLASHES);
    $Base64RequestPayload = base64_encode($RequestPayload);
    
    

    // Step 3: Encrypt Payload
    function encryptBySymmetricKey($dataB64, $sekRaw)
    {
        $data = base64_decode($dataB64);
        return openssl_encrypt($data, "aes-256-ecb", $sekRaw, OPENSSL_RAW_DATA);
    }

    $encryptedRequest = encryptBySymmetricKey($Base64RequestPayload, $sekBinary);
    $reqpayload = base64_encode($encryptedRequest);
    //  dd($reqpayload);

    // Step 4: Send to API
    $payload = [
        "action" => "GENCEWB", 
        "data" => $reqpayload
    ];
  

    $headers = [
        'Content-Type' => 'application/json',
        'gstin' => $gstin,
        'Ocp-Apim-Subscription-Key' => 'AL5e2V9g1I2p9h4U3e',
        'authtoken' => $authToken
    ];

    $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";
    

    $response = Http::withHeaders($headers)->post($url, $payload);
    $jsonResponse = $response->json();

    // dd($jsonResponse);
    

    // Step 5: Decrypt the response
    if (isset($jsonResponse['data'])) {
        $encryptedResponse = base64_decode($jsonResponse['data']);
        $decryptedResponse = openssl_decrypt($encryptedResponse, $ciphering, $sekBinary, $options);

        if (!$decryptedResponse) {
            return response()->json([
                'success' => false,
                'error' => 'Decryption failed using SEK.',
                'openssl_error' => openssl_error_string(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'consolidated_ewaybill' => json_decode($decryptedResponse, true),
        ]);
    } else {
        return response()->json([
            'success' => false,
            'error' => 'No data returned from API.',
            'raw_response' => $jsonResponse
        ], 400);
    }
}


}
