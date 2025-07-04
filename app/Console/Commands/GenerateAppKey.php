<?php

namespace App\Console\Commands;
use App\Services\EwayBillCryptoService;


use Illuminate\Console\Command;

class GenerateAppKey extends Command
{
    protected $signature = 'ewaybill:generate-appkey';
    protected $description = 'Generate and encrypt App Key for Eraahi E-Way Bill API';

    public function handle()
    {
        $publicKeyPath = storage_path('app/public_key.pem');
      
        if (!file_exists($publicKeyPath)) {
        $this->error("🔴 Public key file not found at: {$publicKeyPath}");
        return;
        }

        try {
            // Step 1: Generate 32 random bytes
            $rawKey = random_bytes(32);

            // Step 2: Load public key
            $publicKey = file_get_contents($publicKeyPath);

            // Step 3: Encrypt using RSA
            if (!openssl_public_encrypt($rawKey, $encryptedKey, $publicKey, OPENSSL_PKCS1_PADDING)) {
                $this->error("🔴 Failed to encrypt with public key.");
                return;
            }

            // Step 4: Encode
            $encryptedKeyBase64 = base64_encode($encryptedKey);
            $rawKeyHex = bin2hex($rawKey);

            // Output
            $this->info("🔐 Encrypted App Key for API:\n" . $encryptedKeyBase64);
            $this->line("\n🧩 Raw AES Key (save it for decrypting 'sek'):\n" . $rawKeyHex);

        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
        }
    }
}
