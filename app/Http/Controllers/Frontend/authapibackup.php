<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class EraahiController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'Road3050';
    protected $plainPassword = 'Road@3050';

    


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

  
$RequestPayload = json_encode([
    'action' => 'ACCESSTOKEN',
    'username' => 'krl707#kk',
    'password' => 'Kratik@1997',
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
