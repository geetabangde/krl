<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class Test extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';

    // ERAAHI public key - इसे ऐसे ही multi-line string में रखें


    public function getAccessToken()
    {
             $publicKey = 
'-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2PkhjvWu+lDEv/ane+uV
N44MAZBhWn2Xbr5zEu7h9LpXJXhrwKYhtvWR6YmjAR4AcXDwA3P74Hjc8/jsW92Q
5B4ddXJrRbsU3lac1GhjCNma31FlW7Mpjr5eqPNTuImJr1WgDR9iRuCFYt4enRkv
fywdnDa++QK6fdjS4/kssJxlEXBtlXKoFuSBGjbf0JA56qHo8yqXoYoqgl9Z7e9X
8GZv6soB1JDH9dxMmaqEwsxaonDG+8NdR2RcYeJAnx2s/PBokpbCVPCQiSD5mmYW
SZePF7L4mqvYS7ByrIj1cBH8qq6TafTcLkrr/TiZjpAADPwuynQDE120BpFaqIEq
lQIDAQAB
-----END PUBLIC KEY-----';

$data = 'ewoJImFjdGlvbiI6ICJBQ0NFU1NUT0tFTiIsCgkidXNlcm5hbWUiOiAiQUwwMDEiLAoJInBhc3N3b3JkIjogIkFsYW5raXRAMTIzIiwKCSJhcHBfa2V5IjogIlJaYmlQWXVOM1ZURjJoTWhRY01NQm8wTWZINFVWTlphU3JJZVRycEtvcEU9Igp9';
  
openssl_public_encrypt($data, $encryptedData, $publicKey);
  
echo base64_encode($encryptedData);       


        // 5. Call Eraahi API to get token
        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            'Content-Type' => 'application/json',
            'gstin'=>'07AGAPA5363L002',
        ])->post('https://developers.eraahi.com/api/ewaybillapi/v1.03/auth', $payload);

        $result = $response->json();

        if (isset($result['status']) && $result['status'] == "1") {
            // 6. Success - return auth token, encrypted sek and raw app key (hex)
            return response()->json([
                'auth_token' => $result['auth_token'],
                'sek' => $result['sek'],
                'raw_app_key_hex' => bin2hex($rawAppKey),
            ]);
        }

        // 7. Error handling
        return response()->json([
            'error' => $result['error'] ?? 'Unknown error',
            'raw_response' => $result,
        ], 400);
    }
}
