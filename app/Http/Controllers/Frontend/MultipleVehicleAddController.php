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

public function addMultiVehicle(Request $request)
{
    // Static credentials (Replace with dynamic in real app)
    $authToken = '1ApUMHKh4LS3peujlCAhFEWL0'; 
    $encryptedSek = 'Hd0Z7y/7PFFUQlohUq+CNUrYlhY7ncbC8Di3PDBgEjpGgCjhGmGONERdukDluIoA'; 
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
    $addVehicleData = [
        "ewbNo"         => "621011959442",
        "fromPlace"     => "GANDHI NAGAR",      
        "fromState"     => 7,                   
        "toPlace"       => "Beml Nagar",        
        "toState"       => 27,                  
        "reasonCode"    => 1,                   
        "reasonRem"     => "Initial dispatch",  
        "groupNo"       => 1,                   
        "vehicleNo"     => "MP09CD1234",        
        "transMode"     => 1,
        "transDocNo"    => "LR789456",                   
        "transDocDate"  => "05/07/2025",        
        "totalQuantity" => 22,
        "unitCode"      => "NOS"
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

    // dd($finalEncryptedPayload);
    
    // Step 4: Final API Payload
    $payload = [
        "action" => "MULTIVEHADD",
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
