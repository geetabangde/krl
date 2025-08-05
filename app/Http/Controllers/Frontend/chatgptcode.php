<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class EraahiController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e'; // Alankit-provided
    protected $username = 'krl707#kk'; // Production Username (Format: username#GSP)
    protected $plainPassword = 'Kratik@1997'; // Password of the e-Way bill portal
    protected $gstin = '23AABFM6400F1ZX'; // GSTIN of taxpayer
    protected $appKey = 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE='; // Base64 of AES key

    // Public key for encrypting the payload
    protected $publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjo1FvyiKcQ9hDR2+vH0+
O2XazuLbo2bPfRiiUnpaPhE3ly+Pwh05gvEuzo2UhUIDg98cX4E0vbfWOF1po2wW
TBxb8jMY1nAJ8fz1xyHc1Wa7KZ0CeTvAGeifkMux7c22pMu6pBGJN8f3q7MnIW/u
SJloJF6+x4DZcgvnDUlgZD3Pcoi3GJF1THbWQi5pDQ8U9hZsSJfpsuGKnz41QRsK
s7Dz7qmcKT2WwN3ULWikgCzywfuuREWb4TVE2p3e9WuoDNPUziLZFeUfMP0NqYsi
GVYHs1tVI25G42AwIVJoIxOWys8Zym9AMaIBV6EMVOtQUBbNIZufix/TwqTlxNPQ
VwIDAQAB
-----END PUBLIC KEY-----
EOD;

    public function getAccessToken()
    {
        // Step 1: Create base payload
        $requestPayload = json_encode([
            'action' => 'ACCESSTOKEN',
            'username' => $this->username,
            'password' => $this->plainPassword,
            'app_key' => $this->appKey,
        ]);

        // Step 2: Base64 encode
        $base64Payload = base64_encode($requestPayload);

        // Step 3: Encrypt using RSA public key
        openssl_public_encrypt($base64Payload, $encrypted, $this->publicKey);
        $finalEncryptedPayload = base64_encode($encrypted);

        // Step 4: Prepare full JSON payload
        $body = json_encode([
            'Data' => $finalEncryptedPayload
        ]);

        // Step 5: Send request to production API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'gstin' => $this->gstin,
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
        ])->withBody($body, 'application/json')
            ->post('https://newewaybill.alankitgst.com/ewaybillgateway/v1.03/auth');

        $result = $response->json();

        // Step 6: Check and return
        if (isset($result['status']) && $result['status'] == "1") {
            return response()->json([
                'auth_token' => $result['authtoken'],
                'sek' => $result['sek'],
            ]);
        }

        return response()->json([
            'error' => $result['error'] ?? 'Unknown error',
            'raw_response' => $result,
        ], 400);
    }
}
