<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class MultiVehicleController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';

public function initiateMultiVehicle(Request $request)
{
    // Static credentials (Replace with dynamic in real app)
    $authToken = '1wuF10gvTXYcPkiTWNN1a5wHW'; 
    $encryptedSek = 'o7m1bM8msIbFhP9vLnUWx9dFjWq6KC4PcaIaMzPoNrVGgCjhGmGONERdukDluIoA'; 
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE='; 
    $gstin = '07AGAPA5363L002'; 
    $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';

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
        return response()->json(['success' => false, 'error' => 'SEK decryption failed'], 500);
    }

    // Step 2: Create Vehicle Movement Payload
    $multiVehicleData = [
        "ewbNo" => 701008936183,
        "reasonCode" => 1,
        "reasonRem" => "vehicle broke down",
        "fromPlace" => "BANGALORE",
        "fromState" => 07,             
        "toPlace" => "Chennai",
        "toState" => 27,               
        "transMode" => 1,
        "totalQuantity" => 4,
        "unitCode" => "BOX"
   ];
    
    $jsonPayload = json_encode($multiVehicleData, JSON_UNESCAPED_SLASHES);
    $base64Payload = base64_encode($jsonPayload);
    
    function encryptBySymmetricKey($dataB64, $sekRaw)
    {
        $data = base64_decode($dataB64);
        return openssl_encrypt($data, "aes-256-ecb", $sekRaw, OPENSSL_RAW_DATA);
    }

    // Step 3: Encrypt using SEK
    $encryptedPayload = openssl_encrypt(base64_decode($base64Payload), "AES-256-ECB", $sekBinary, OPENSSL_RAW_DATA);
    $finalEncryptedPayload = base64_encode($encryptedPayload);

    // Step 4: Final API Payload
    $payload = [
        "action" => "MULTIVEHMOVINT",
        "data" => $finalEncryptedPayload
    ];
    // dd($payload);

    // Step 5: Headers
    $headers = [
        'Content-Type' => 'application/json',
        'gstin' => $gstin,
        'authtoken' => $authToken,
        'Ocp-Apim-Subscription-Key' => $subscriptionKey,
    ];

    // Step 6: Send POST request
    $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";
    $response = Http::withHeaders($headers)->post($url, $payload);
    $jsonResponse = $response->json();

    //  dd($jsonResponse);
    
    // Step 7: Handle API Response
    if (isset($jsonResponse['data'])) {
        $encryptedResponse = base64_decode($jsonResponse['data']);
        $decryptedData = openssl_decrypt(
            $encryptedResponse,
            $ciphering,
            $sekBinary,
            $options
        );

        if (!$decryptedData) {
            return response()->json(['success' => false, 'error' => 'Response decryption failed'], 500);
        }

        return response()->json([
            'success' => true,
            'ewaybill_response' => json_decode($decryptedData, true)
        ]);
    }

    return response()->json([
        'success' => false,
        'error' => $jsonResponse['message'] ?? 'Unknown error'
    ]);
}


}
