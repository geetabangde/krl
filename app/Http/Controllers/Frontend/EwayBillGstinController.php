<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class EwayBillGstinController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';

    


public function getEwayGstin(Request $request)
{
    $authToken = '17W26cDYl448RVNLFe5WtkHTd';
    $encryptedSek = 'CKZt6VLOOV6XOLCvWF6LxhUceMazHRLR8/9LKdTWfttGgCjhGmGONERdukDluIoA';
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE=';

    $genGstin = '23AABFM6400F1ZX'; // EWB Generator GSTIN (in query param)
    $gstin = '07AGAPA5363L002';    // Transporter GSTIN (in header)
    $ewayBillDate = '05/07/2025';  // Format: dd/MM/yyyy

    // Step 1: Decrypt SEK using AppKey
    $decryptionKey = base64_decode($appKey);
    $ciphering = 'AES-256-ECB';
    $options = OPENSSL_RAW_DATA;

    $decryptedSek = openssl_decrypt(
        base64_decode($encryptedSek),
        $ciphering,
        $decryptionKey,
        $options
    );

    if (!$decryptedSek) {
        return response()->json(['success' => false, 'error' => 'SEK decryption failed']);
    }

    // Step 2: Prepare API URL
    $url = "https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi/GetEwayBillsForTransporterByGstin?Gen_gstin={$genGstin}&date={$ewayBillDate}";

    // Step 3: Prepare Headers
    $headers = [
        'Content-Type' => 'application/json',
        'gstin' => $gstin,
        'Ocp-Apim-Subscription-Key' => 'AL5e2V9g1I2p9h4U3e',
        'authtoken' => $authToken,
    ];

    // Step 4: Make the GET Request
    $response = Http::withHeaders($headers)->get($url);
    $jsonResponse = $response->json();

    // Step 5: Check response
    if ($response->successful() && isset($jsonResponse['data']) && isset($jsonResponse['rek'])) {
        // Decrypt REK
        $rek = openssl_decrypt(
            base64_decode($jsonResponse['rek']),
            $ciphering,
            $decryptedSek,
            $options
        );

        if (!$rek) {
            return response()->json(['success' => false, 'error' => 'REK decryption failed']);
        }

        // Decrypt Data using REK
        $decryptedData = openssl_decrypt(
            base64_decode($jsonResponse['data']),
            $ciphering,
            $rek,
            $options
        );

        if (!$decryptedData) {
            return response()->json(['success' => false, 'error' => 'Data decryption failed']);
        }

        // Final: Return Success
        return response()->json([
            'success' => true,
            'eway_bills' => json_decode($decryptedData, true)
        ]);
    }

    // Final Fallback
    return response()->json([
        'success' => false,
        'error' => 'Invalid API response',
        'raw_response' => $jsonResponse
    ], $response->status());
}


}
