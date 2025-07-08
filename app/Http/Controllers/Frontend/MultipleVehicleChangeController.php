<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class MultipleVehicleChangeController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';

public function ChnageMultiVehicle(Request $request)
{
    // Static credentials (Replace with dynamic in real app)
    $authToken = '1wMSRe7KakwNpecMBQWRfepdF'; 
    $encryptedSek = 'fZFDbKo1Bpgf8UZt7TF3Gxzl5ex8lPKGS8FLjupJGupGgCjhGmGONERdukDluIoA'; 
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE='; 
    $gstin = '23AABFM6400F1ZX'; 
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
    $changeVehicleData = [
        "ewbNo"         => 621011959442,
        "groupNo"       => 0,                    // existing groupNo from VehiclListDetails
        "oldvehicleNo"  => "KA01AB1234",         // existing vehicleNo to be replaced
        "newVehicleNo"  => "MP09CD1234",         // new vehicleNo you want to update
        "oldTranNo"     => "LR123456",           // old transDocNo (existing)
        "newTranNo"     => "LR789456",           // new transDocNo you want to use
        "fromPlace"     => "FRAZER TOWN",        // fromPlace from ewb
        "fromState"     => 7,                    // fromStateCode from ewb
        "reasonCode"    => "1",                  // Transhipment reason code
        "reasonRem"     => "vehicle broke down"  // Your own reason
   ];


    $jsonPayload = json_encode($changeVehicleData , JSON_UNESCAPED_SLASHES);
    $base64Payload = base64_encode($jsonPayload);
    
    function encryptBySymmetricKey($dataB64, $sekRaw)
    {
        $data = base64_decode($dataB64);
        return openssl_encrypt($data, "aes-256-ecb", $sekRaw, OPENSSL_RAW_DATA);
    }
    

    // Step 3: Encrypt using SEK
    $encryptedPayload = openssl_encrypt(base64_decode($base64Payload), "AES-256-ECB", $sekBinary, OPENSSL_RAW_DATA);
    $finalEncryptedPayload = base64_encode($encryptedPayload);

    // dd($finalEncryptedPayload);
    
    // Step 4: Final API Payload
    $payload = [
        "action" => "MULTIVEHUPD",
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

    dd($jsonResponse);
      
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
