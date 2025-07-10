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
    $authToken = '1NM07DijNlNsqe6oUQIed4zfz'; 
    $encryptedSek = 'ycKJPrzM/HHRjaJn3wL2EZcFsIYcACR64qiJvU8rI2lGgCjhGmGONERdukDluIoA'; 
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
    
    //  dd($sekBinary);

    if (!$sekBinary) {
        return response()->json(['success' => false, 'error' => 'SEK decryption failed'], 500);
    }

    // Step 2: Create Vehicle Movement Payload
    $changeVehicleData = [
        "ewbNo"         => "751008936089",
        "groupNo"       => "1",
        "oldvehicleNo"  => "MP09CD1234",     
        "newVehicleNo"  => "MP10XY7789",     
        "oldTranNo"     => "L8897678",       
        "newTranNo"     => "LR789456",      
        "fromPlace"     => "BANGALORE",
        "fromState"     => 07,
        "reasonCode"    => "1",
        "reasonRem"     => "vehicle broke down"
    ];

    //  dd($changeVehicleData);
    
    $jsonPayload = json_encode($changeVehicleData , JSON_UNESCAPED_SLASHES);
    $base64Payload = base64_encode($jsonPayload);

    // dd($base64Payload);

    // Step 3: Encrypt base64Payload using SEK
    $encryptedPayload = openssl_encrypt(
        base64_decode($base64Payload),
        $ciphering,
        $sekBinary,
        $options
    );

    if (!$encryptedPayload) {
        return response()->json(['success' => false, 'error' => 'Payload encryption failed'], 500);
    }

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
