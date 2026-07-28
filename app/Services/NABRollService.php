<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NABRollService
{
    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->publicKey = config('services.nabroll.public_key');
        $this->secretKey = config('services.nabroll.secret_key');
        $this->baseUrl = 'https://demo.nabroll.com.ng';
    }

    /**
     * Initiate payment transaction
     *
     * @param \App\Models\Order $order
     * @return array|null Array with 'PaymentUrl' and 'TransactionRef' on success, null on failure.
     */
    public function initiatePayment($order)
    {
        // hashString = payerRefNo + amount  + publicApiKey;
        $amount = number_format((float)$order->amount, 2, '.', '');
        $payerRefNo = $order->tracking_number;

        $hashString = $payerRefNo . $amount . $this->publicKey;
        $hash = hash_hmac('sha256', $hashString, $this->secretKey);

        $payload = [
            'ApiKey' => $this->publicKey,
            'Hash' => $hash,
            'Amount' => $amount,
            'PayerRefNo' => $payerRefNo,
            'PayerName' => $order->user?->name ?? $order->pickup_contact ?? 'Customer',
            'Email' => $order->user?->email ?? 'no-reply@example.com',
            'Mobile' => $order->user?->phone ?? $order->pickup_phone ?? '0000000000',
            'Description' => 'Delivery Order ' . $order->tracking_number,
            'ResponseUrl' => route('payment.callback'),
            'FeeBearer' => 'Customer',
        ];

        try {
            $response = Http::asForm()->post($this->baseUrl . '/api/v1/transactions/initiate', $payload);
            
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['status']) && $data['status'] === 'SUCCESSFUL') {
                    return [
                        'PaymentUrl' => $data['PaymentUrl'] ?? null,
                        'TransactionRef' => $data['TransactionRef'] ?? null,
                    ];
                } else {
                    Log::error('NABRoll Initiate Error: ' . json_encode($data));
                }
            } else {
                Log::error('NABRoll Initiate HTTP Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('NABRoll Initiate Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Verify payment status.
     * 
     * @param string $transactionRef
     * @param string $payerRefNo
     * @param float|string $amount
     * @return array|null Returns verification data if successful, null otherwise.
     */
    public function verifyPayment($transactionRef, $payerRefNo, $amount)
    {
        // hashString = payerRefNo  + amount  + transactionRef + publicApiKey;
        $amountFormat = number_format((float)$amount, 2, '.', '');
        
        $hashString = $payerRefNo . $amountFormat . $transactionRef . $this->publicKey;
        $hash = hash_hmac('sha256', $hashString, $this->secretKey);

        $payload = [
            'ApiKey' => $this->publicKey,
            'Hash' => $hash,
            'TransactionRef' => $transactionRef,
        ];

        try {
            $response = Http::asForm()->post($this->baseUrl . '/api/v1/transactions/verify', $payload);
            
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['status']) && $data['status'] === 'SUCCESSFUL') {
                    return $data;
                } else {
                    Log::error('NABRoll Verify Failed: ' . json_encode($data));
                }
            } else {
                Log::error('NABRoll Verify HTTP Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('NABRoll Verify Exception: ' . $e->getMessage());
        }

        return null;
    }
}
