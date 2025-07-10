<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class MultipleVehicleAddController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';

public function addMultiVehicle_OLD(Request $request)
{
    // Static credentials (Replace with dynamic in real app)
    $authToken = '1uqHxSLMWbnc8biCEYi3FthUH'; 
    $encryptedSek = '7JxeAm11VkrDeo7Jz2eLo05Xp7AH0ddTWtIgQ2D1we9GgCjhGmGONERdukDluIoA'; 
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

    // Step 2: Prepare New Vehicle Data
    $addVehicleData = [
        "ewbNo"         => 611011962418,                 
        "groupNo"       => "2",                            
        "vehicleNo"     => "PWQ4321",
        "transDocNo"    => "1256",
        "transDocDate"  => "09/07/2025",
        "quantity"     => 4,
    ];

    $jsonPayload = json_encode($addVehicleData , JSON_UNESCAPED_SLASHES);
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
        "action" => "MULTIVEHADD",
        "data" => $finalEncryptedPayload
    ];
    
    dd($payload);
    
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

    // dd($jsonResponse);
      
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

public function addMultiVehicle_new(Request $request)
{
    // Static credentials (from your integration setup)
    $authToken = '1uqHxSLMWbnc8biCEYi3FthUH'; 
    $encryptedSek = '7JxeAm11VkrDeo7Jz2eLo05Xp7AH0ddTWtIgQ2D1we9GgCjhGmGONERdukDluIoA'; 
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE='; 
    $gstin = '23AABFM6400F1ZX'; 
    $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';

    $ciphering = 'AES-256-ECB';
    $options = OPENSSL_RAW_DATA;

    $decryptionKey = base64_decode($appKey);
    dd($decryptionKey);
    

    // Step 1: Decrypt SEK
    $sekBinary = openssl_decrypt(
        base64_decode($encryptedSek),
        $ciphering,
        $decryptionKey,
        $options
    );

    //  dd($encryptedSek);

    if (!$sekBinary) {
        return response()->json(['success' => false, 'error' => 'SEK decryption failed'], 500);
    }

    // Step 2: Prepare data as per official Alankit document
    $addVehicleData = [
        "ewbNo"         => "611011962418",       // Replace with actual EWB No
        "groupNo"       => "2",                // Should match group series
        "vehicleNo"     => "MP09CD1234",       // Vehicle number
        "transDocNo"    => "LR1234",           // Transport Document Number
        "transDocDate"  => "09/07/2025",       // DD/MM/YYYY
        "quantity"      => 4                   // Quantity
    ];

    // Step 3: Base64 encode
    $jsonPayload = json_encode($addVehicleData, JSON_UNESCAPED_SLASHES);
    $base64Payload = base64_encode($jsonPayload);

    // Step 4: Encrypt with SEK
    $encryptedPayload = openssl_encrypt(
        base64_decode($base64Payload),
        "AES-256-ECB",
        $sekBinary,
        OPENSSL_RAW_DATA
    );
    $finalEncryptedPayload = base64_encode($encryptedPayload);

    // Step 5: Prepare API payload
    $payload = [
        "action" => "MULTIVEHADD",
        "data" => $finalEncryptedPayload
    ];
    dd($payload);

    // Step 6: API headers
    $headers = [
        'Content-Type' => 'application/json',
        'gstin' => $gstin,
        'authtoken' => $authToken,
        'Ocp-Apim-Subscription-Key' => $subscriptionKey,
    ];

    // Step 7: Send POST request
    $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";
    $response = Http::withHeaders($headers)->post($url, $payload);
    $jsonResponse = $response->json();

    // Step 8: Decrypt response if present
    if (isset($jsonResponse['data'])) {
        $encryptedResponse = base64_decode($jsonResponse['data']);
        $decryptedData = openssl_decrypt(
            $encryptedResponse,
            $ciphering,
            $sekBinary,
            $options
        );

        return response()->json([
            'success' => true,
            'ewaybill_response' => json_decode($decryptedData, true)
        ]);
    }

    // Step 9: Handle error response
    return response()->json([
        'success' => false,
        'error' => $jsonResponse['message'] ?? 'Unknown error',
        'raw' => $jsonResponse
    ]);
}

public function addMultiVehicle(Request $request)
{
    // Credentials
    $authToken = '1q1laJrrV9Unn81BfFSEAxwTt'; 
    $encryptedSek = 'dAi4iQBUejOdrey3uZoYcJ+wBij7vEn9iQMX09QtjZ1GgCjhGmGONERdukDluIoA'; 
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE='; 
    $gstin = '07AGAPA5363L002'; 
    $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';

    $ciphering = 'AES-256-ECB';
    $options = OPENSSL_RAW_DATA;

    // Step 1: Decrypt SEK using decrypted AppKey
    $decryptionKey = base64_decode($appKey);
    
    $sekBinary = openssl_decrypt(
        base64_decode($encryptedSek),
        $ciphering,
        $decryptionKey,
        $options
    );

    // dd($sekBinary); // Optional check

    if (!$sekBinary) {
        return response()->json(['success' => false, 'error' => 'SEK decryption failed'], 500);
    }

    // 🔐 Just to verify - print SEK
    // Expected: Kv5wOrOZ76HPicMDV4l+5mA9LVtN1us/9eWJHYo2SGE=
    // dd(base64_encode($sekBinary)); // Optional check

    // Step 2: Prepare the payload as per official documentation
    $addVehicleData = [
        "ewbNo" => "751008936089",
        "groupNo" => "1",
        "vehicleNo" => "MP09CD1234",
        "transDocNo" => "L8897678",
        "transDocDate" => "10/07/2025",
        "quantity" => 4,
    ];

    $jsonPayload = json_encode($addVehicleData, JSON_UNESCAPED_SLASHES);
    $base64Payload = base64_encode($jsonPayload);

    // dd($base64Payload); // Optional check

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
    // dd($encryptedPayload); // Optional check
    $finalEncryptedPayload = base64_encode($encryptedPayload);
    // dd($finalEncryptedPayload); // Optional check
   // 
    // Step 4: Prepare final API payload
    $payload = [
        "action" => "MULTIVEHADD",
        "data" => $finalEncryptedPayload
    ];

    // dd($payload); // Optional check
    
    // Step 5: API Headers

    $headers = [
        'Content-Type' => 'application/json',
        'gstin' => $gstin,
        'authtoken' => $authToken,
        'Ocp-Apim-Subscription-Key' => $subscriptionKey,
    ];

    // Step 6: POST to Alankit API
    $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi";
    $response = Http::withHeaders($headers)->post($url, $payload);
    $jsonResponse = $response->json();

    // Step 7: Decrypt response (if any)
    if (isset($jsonResponse['data'])) {
        $encryptedResponse = base64_decode($jsonResponse['data']);
        $decryptedData = openssl_decrypt(
            $encryptedResponse,
            $ciphering,
            $sekBinary,
            $options
        );

        return response()->json([
            'success' => true,
            'ewaybill_response' => json_decode($decryptedData, true)
        ]);
    }

    return response()->json([
        'success' => false,
        'error' => $jsonResponse['message'] ?? 'Unknown error',
        'raw' => $jsonResponse
    ]);
}


}
