<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class EraahiController extends Controller
{
    protected $subscriptionKey;
    protected $username;
    protected $plainPassword;
    protected $appKey;
    protected $gstin;

     public function __construct()
    {
        $this->subscriptionKey = env('EWB_API_SUBSCRIPTION_KEY');
        $this->username = env('EWB_USERNAME');
        $this->plainPassword = env('EWB_PASSWORD');
        $this->appKey = env('EWB_APP_KEY');
        $this->gstin = env('EWB_GENERATOR_GSTIN');
    }


    public function getAccessToken()
    {
       // ✅ Step 1: Return cached token if available
        if (Cache::has('eway_auth_token') && Cache::has('eway_auth_sek')) {
            return response()->json([
                'auth_token' => Cache::get('eway_auth_token'),
                'sek' => Cache::get('eway_auth_sek'),
                'source' => 'cache', // just for clarity
            ]);
        }


             $publicKey = 
'-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjo1FvyiKcQ9hDR2+vH0+
O2XazuLbo2bPfRiiUnpaPhE3ly+Pwh05gvEuzo2UhUIDg98cX4E0vbfWOF1po2wW
TBxb8jMY1nAJ8fz1xyHc1Wa7KZ0CeTvAGeifkMux7c22pMu6pBGJN8f3q7MnIW/u
SJloJF6+x4DZcgvnDUlgZD3Pcoi3GJF1THbWQi5pDQ8U9hZsSJfpsuGKnz41QRsK
s7Dz7qmcKT2WwN3ULWikgCzywfuuREWb4TVE2p3e9WuoDNPUziLZFeUfMP0NqYsi
GVYHs1tVI25G42AwIVJoIxOWys8Zym9AMaIBV6EMVOtQUBbNIZufix/TwqTlxNPQ
VwIDAQAB
-----END PUBLIC KEY-----';

  
$RequestPayload = json_encode([
    'action' => 'ACCESSTOKEN',
    'username' => 'krl707_API_ASK',
    'password' => 'Harsh@123454',
    'app_key' => 'RZbiPYuN3VTF2hMhQcMMBo0MfH4UVNZaSrIeTrpKopE='
]);

    $Base64RequestPayload = base64_encode($RequestPayload);

    $data =  $Base64RequestPayload;

// $data = 'ewoJImFjdGlvbiI6ICJBQ0NFU1NUT0tFTiIsCgkidXNlcm5hbWUiOiAiQUwwMDEiLAoJInBhc3N3b3JkIjogIkFsYW5raXRAMTIzIiwKCSJhcHBfa2V5IjogIlJaYmlQWXVOM1ZURjJoTWhRY01NQm8wTWZINFVWTlphU3JJZVRycEtvcEU9Igp9';
  
   openssl_public_encrypt($data, $encryptedData, $publicKey);
  
   $encryptedData_res =  base64_encode($encryptedData); 

    $payload = [
        'Data' => $encryptedData_res
    ];
    
    dd($payload);

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'gstin' => '23AABFM6400F1ZX',
        'Ocp-Apim-Subscription-Key' => 'AL5e2V9g1I2p9h4U3e',
        'Authorization' => 'Bearer YOUR_ACCESS_TOKEN_HERE', 
    ])->withBody(json_encode($payload), 'application/json')
      ->post('https://newewaybill.alankitgst.com/ewaybillgateway/v1.03/auth');

    $result = $response->json();

    // ✅ Step 5: On success, cache the token & sek
    if (isset($result['status']) && $result['status'] == "1") {
        Cache::put('eway_auth_token', $result['authtoken'], now()->addMinutes(350)); // ~5.8 hours
        Cache::put('eway_auth_sek', $result['sek'], now()->addMinutes(350));

        return response()->json([
            'auth_token' => $result['authtoken'],
            'sek' => $result['sek'],
            'source' => 'live', // just to show new fetch
        ]);
    }

    return response()->json([
        'error' => $result['error'] ?? 'Unknown error',
        'raw_response' => $result,
    ], 400);

}
}
