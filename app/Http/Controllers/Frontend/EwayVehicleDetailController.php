<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class EwayVehicleDetailController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';


public function getVehicleNumber(Request $request)
{
    $authToken = '1b40BN7koFkNHDIDV5JZzy5ai'; 
    $encryptedSek = 'ciyTsR8bypLHeJ98V2Km0wBQh0eWwFLBXp3yNc/VT8ZGgCjhGmGONERdukDluIoA'; 
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE='; 
    $gstin = '23AABFM6400F1ZX'; 

    $ciphering = 'AES-256-ECB';
    $options = OPENSSL_RAW_DATA; // ✅ Use RAW_DATA for correct binary output
    $decryptionKey = base64_decode($appKey);

    // ✅ Step 1: Decrypt SEK
    $sekBinary = openssl_decrypt(
        base64_decode($encryptedSek),
        $ciphering,
        $decryptionKey,
        $options
    );

    if (!$sekBinary) {
        return response()->json(['success' => false, 'error' => 'SEK decryption failed', 'openssl_error' => openssl_error_string()], 500);
    }

    // ✅ Step 2: Vehicle Update Payload
    $vehicleData = [
    "ewbNo" => 621011959442,
    "vehicleNo" => "KA01AB1234",
    "fromPlace" => "GANDHI NAGAR",
    "fromState" => 7,
    "transMode" => "1",
    "transDocNo" => "LR123456",
    "transDocDate" => "05/07/2025",
    "vehicleType" => "R",
    "reasonCode" => "1",
    "reasonRem" => "Initial dispatch"
   ];


    $RequestPayload = json_encode($vehicleData, JSON_UNESCAPED_SLASHES);
    $Base64RequestPayload = base64_encode($RequestPayload);

    // ✅ Step 3: Encrypt the Request Payload using SEK
    function encryptBySymmetricKey($dataB64, $sekRaw)
    {
        $data = base64_decode($dataB64);
        return openssl_encrypt($data, "aes-256-ecb", $sekRaw, OPENSSL_RAW_DATA);
    }

    $encryptedRequest = encryptBySymmetricKey($Base64RequestPayload, $sekBinary);
    $reqpayload = base64_encode($encryptedRequest); // ✅ Must encode again for final transmission

    // ✅ Step 4: Prepare payload and headers
    $payload = [
        "action" => "VEHEWB",
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

    // ✅ Step 5: Decrypt the response
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
            'eway_bill_data' => json_decode($decryptedResponse, true),
        ]);
    } else {
        return response()->json([
            'success' => false,
            'error' => 'No data returned from API.',
        ], 400);
    }
}

}
