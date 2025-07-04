<?php

namespace App\Services;

class EwayBillCryptoService
{
    // RSA encryption
    public static function encryptWithPublicKey($data, $publicKeyPath)
   {
        $publicKey = file_get_contents($publicKeyPath);
        $keyResource = openssl_pkey_get_public($publicKey);

        if (!$keyResource) {
            return null;
        }

        if (!openssl_public_encrypt($data, $encrypted, $keyResource, OPENSSL_PKCS1_PADDING)) {
            return null;
        }

        return base64_encode($encrypted);
   }


    // SEK decryption
    public static function decryptSek(string $encryptedSekB64, string $rawAppKeyHex): ?string
    {
        $decryptionKey = hex2bin($rawAppKeyHex);
        $encryptedSek = base64_decode($encryptedSekB64);
        return openssl_decrypt($encryptedSek, "AES-256-ECB", $decryptionKey, OPENSSL_RAW_DATA);
    }

    // AES encryption with SEK
    public static function encryptWithSymmetricKey(string $base64Payload, string $base64Sek): string
    {
        $data = base64_decode($base64Payload);
        $sek = base64_decode($base64Sek);
        return base64_encode(openssl_encrypt($data, "AES-256-ECB", $sek, OPENSSL_RAW_DATA));
    }

    // AES decryption with SEK
    public static function decryptData(string $encryptedDataB64, string $base64Sek): string
    {
        $encryptedData = base64_decode($encryptedDataB64);
        $sek = base64_decode($base64Sek);
        return openssl_decrypt($encryptedData, "AES-256-ECB", $sek, OPENSSL_RAW_DATA);
    }

    public static function encryptPayload(string $payloadJson, string $base64Sek): string
    {
        $payloadB64 = base64_encode($payloadJson);
        return openssl_encrypt(base64_decode($payloadB64), "AES-256-ECB", base64_decode($base64Sek), OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
    }

    public static function decryptResponse(string $responseDataB64, string $base64Sek): string
    {
        $raw = base64_decode($responseDataB64);
        return openssl_decrypt($raw, "AES-256-ECB", base64_decode($base64Sek), OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
    }

    public static function encryptWithPublicKeyString($data, $publicKeyPem)
    {
    $keyResource = openssl_pkey_get_public($publicKeyPem);

    if (!$keyResource) {
        return null;
    }

    if (!openssl_public_encrypt($data, $encrypted, $keyResource, OPENSSL_PKCS1_PADDING)) {
        return null;
    }

    return base64_encode($encrypted);
  }

}
