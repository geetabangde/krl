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


public function generateEwayBill(Request $request)
{
    // 1. Required credentials
    $authToken = '1Rl2q7SDE5RuSJ9Y0dKOv2saF'; // Replace with actual
    $encryptedSek = '6upN6e0nBCTYdBdrRCkf0lReno5biLZQrk5atjemxaBGgCjhGmGONERdukDluIoA';
    $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE=';

    // 2. Decrypt SEK
    $ciphering = 'AES-256-ECB';
    $options = 0;
    $decryptionKey = base64_decode($appKey);
    $decryption_iv = '';

    $decryptedSek = openssl_decrypt($encryptedSek, $ciphering, $decryptionKey, $options, $decryption_iv);
    $base64encodedDecryptedSek = base64_encode($decryptedSek);

    // dd($base64encodedDecryptedSek);
   

    if ($decryptionKey === false || $decryptedSek === false) {
        return response()->json(['error' => 'Invalid appKey or SEK decryption failed.'], 400);
    }

    // 3. Prepare E-Way Bill Payload
    $requestPayload = [
        "supplyType" => "O",
        "subSupplyType" => "1",
        "subSupplyDesc" => "",
        "docType" => "INV",
        "docNo" => "Tes0105",
        "docDate" => "03/07/2025",
        "fromGstin" => "23AABFM6400F1ZX",
        "fromTrdName" => "welton",
        "fromAddr1" => "2ND CROSS NO 59  19  A",
        "fromAddr2" => "GROUND FLOOR OSBORNE ROAD",
        "fromPlace" => "FRAZER TOWN",
        "fromPincode" => 110055,
        "actFromStateCode" => 07,
        "fromStateCode" => 07,
        "toGstin" => "07AGAPA5363L002",
        "toTrdName" => "sthuthya",
        "toAddr1" => "Shree Nilaya",
        "toAddr2" => "Dasarahosahalli",
        "toPlace" => "Beml Nagar",
        "toPincode" => 560090,
        "actToStateCode" => 29,
        "toStateCode" => 27,
        "transactionType" => 4,
        "otherValue" => -100,
        "totalValue" => 56099,
        "cgstValue" => 0,
        "sgstValue" => 0,
        "igstValue" => 300.67,
        "cessValue" => 400.56,
        "cessNonAdvolValue" => 400,
        "totInvValue" => 57200.23,
        "transporterId" => "07AGAPA5363L002",
        "transporterName" => "",
        "transDocNo" => "",
        "transMode" => "1",
        "transDistance" => "2145",
        "transDocDate" => "",
        "vehicleNo" => "PVC1234",
        "vehicleType" => "R",
        "itemList" => [
            [
                "productName" => "Wheat",
                "productDesc" => "Wheat",
                "hsnCode" => 1001,
                "quantity" => 4,
                "qtyUnit" => "BOX",
                "cgstRate" => 0,
                "sgstRate" => 0,
                "igstRate" => 3,
                "cessRate" => 3,
                "cessNonadvol" => 0,
                "taxableAmount" => 56099
            ]
        ]
    ];

    // 4. Encode and encrypt the payload
    $Base64RequestPayload = base64_encode(json_encode($requestPayload));
    
    // Encrypt with SEK
    $encryptedPayload = openssl_encrypt(
        base64_decode($Base64RequestPayload),
        "aes-256-ecb",
        base64_decode($base64encodedDecryptedSek),
        0
    );

    $finalPayload = [
        "action" => "GENEWAYBILL",
        "data" => $encryptedPayload
    ];
    // dd($finalPayload);

    // 5. Call the API
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'gstin' => '23AABFM6400F1ZX',
        'Ocp-Apim-Subscription-Key' => 'AL5e2V9g1I2p9h4U3e',
        'authtoken' => $authToken,
    ])->withBody(json_encode($finalPayload), 'application/json')
      ->post('https://developers.eraahi.com/api/ewaybillapi/v1.03/ewayapi');

    $responseJson = $response->json();

    // dd($responseJson);
    
    // Step 6. Decrypt the 'data' from API Response

    // 6. Decrypt response
     // 6. Decrypt response
        if (isset($responseJson['data']) && !empty($responseJson['data'])) {
            $decryptedResponse = openssl_decrypt(
                $responseJson['data'], // Fixed: Directly use response data (no base64_encode)
                $ciphering,
                base64_decode($base64encodedDecryptedSek),
                $options
            );
            
            if ($decryptedResponse === false) {
                return response()->json([
                    'success' => false,
                    'error' => 'Response decryption failed.',
                    'response' => $responseJson
                ]);
            }

            return response()->json([
                'success' => true,
                'eway_bill_data' => json_decode(base64_decode($decryptedResponse), true),
                'alert' => $responseJson['alert'] ?? null,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'No data returned from API.',
                'response' => $responseJson
            ]);
        }

}

}
