<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class EraahiController extends Controller
{
    protected $subscriptionKey = 'AL5e2V9g1I2p9h4U3e';
    protected $username = 'AL001';
    protected $plainPassword = 'Alankit@123';

   


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

        // 1. Generate random 32 byte raw app key
    //     $rawAppKey = random_bytes(32);

    // //     // 2. Encrypt app key with public key (RSA)
    //     if (!openssl_public_encrypt($rawAppKey, $encryptedAppKey, $publicKey, OPENSSL_PKCS1_PADDING)) {
    //         return response()->json(['error' => 'Failed to encrypt app key'], 500);
    //     }
    //    echo  $encryptedAppKeyBase64 = base64_encode($encryptedAppKey);
        // $encryptedAppKeyBase64 = base64_encode('0625ef6042ef820a8f0c944a0d4f96f0b10edea527cd716a9cb32586013bf575');


    //    echo '<br>';
    //             echo  $rawAppKey;

        // die;
        // // // 3. Encrypt password with public key (RSA)
        // if (!openssl_public_encrypt($this->plainPassword, $encryptedPassword, $publicKey, OPENSSL_PKCS1_PADDING)) {
        //     return response()->json(['error' => 'Failed to encrypt password'], 500);
        // }
        // $encryptedPasswordBase64 = base64_encode($encryptedPassword);

        // 4. Prepare payload for API
        // $payload = [
        //     'action' => 'ACCESSTOKEN',
        //     'username' => $this->username,
        //     'password' => 'Alankit@123',
        //     'app_key' => 'kRYbxupcKwtLhlSFbEBLawoyAWPMA1r7UqISJ1NNBCV2I8Ag69jopYdlRmgKc2OScfHAfHbChyICRxxd+todhmwxRvlz8vn9EeukcbwQ2GcBLIG7/SJitsIGfVkmVMrNIzPATBKV3Dlml37pOlnm0+AOwRaNyfK9Jk177B4qgaNnvlyvN9x5ScB01EBPqAuf/g6ZwftPDd2TzAoaMgK8KC4DBQ0LSqhbg8wuqWcEwAZNFfIIbJT4qi9s7m5w+c21ARedLMQCz/T/PiRabrQUKolm90sLQ8wdRggRsuueQPdJLzLXOd/3ak+7BvAknPBT97TKn7e1HgnDXsd1fVA/ww==',
        // ];

    $RequestPayload = json_encode([
        'action' => 'ACCESSTOKEN',
        'username' => 'AL001',
        'password' => 'Alankit@123',
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

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'gstin' => '07AGAPA5363L002',
        'Ocp-Apim-Subscription-Key' => 'AL5e2V9g1I2p9h4U3e',
        'Authorization' => 'Bearer YOUR_ACCESS_TOKEN_HERE', // Replace with real token
    ])->withBody(json_encode($payload), 'application/json')
      ->post('https://developers.eraahi.com/api/ewaybillapi/v1.03/auth');

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
