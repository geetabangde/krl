<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GstEwayController extends Controller
{
  
    public function requestOtp()
    {
        $url = "https://uatapi.alankitgst.com/taxpayerapi/v1.0/authenticate";
        $headers = [
            'Ocp-Apim-Subscription-Key' => 'ALSND6m0e0h1I2I4Y9v8',
            'Content-Type' => 'application/json'
        ];

        $body = [
            "email" => "harshkhandelwal.krl@gmail.com",
            "gstin" => "23AABFM6400F1ZX"
        ];

        $response = Http::withHeaders($headers)->post($url, $body);
        return $response->json();
    }

    public function verifyOtp(Request $request)
    {
        $url = "https://gsp.alankitgst.com/authtoken";
        $headers = [
            'Ocp-Apim-Subscription-Key' => 'ALSND6m0e0h1I2l4Y9v8',
        ];

        $body = [
            "email" => "harshkhandelwal.krl@gmail.com",
            "gstin" => "23AABFM6400F1ZX",
            "otp" => $request->otp
        ];

        $response = Http::withHeaders($headers)->post($url, $body);
        return $response->json();
    }
}