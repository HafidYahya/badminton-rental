<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use RuntimeException;

class PakasirService
{
    public function createTransaction(Order $order): array
    {
        if (RateLimiter::tooManyAttempts('pakasir-create-transaction', 2)) {
            return [
                'success' => false,
                'retryable' => true,
                'error' => 'Pembuatan transaksi sedang padat. Silakan coba lagi sebentar.',
            ];
        }
        RateLimiter::hit('pakasir-create-transaction', 1);

        $response = $this->request()
            ->post($this->endpoint('create-transaction/' . rawurlencode($order->project_slug) . '/' . rawurlencode($order->order_id)), [
                'method' => $order->payment_method,
                'amount' => (int) $order->amount,
            ]);

        return $this->parseCreateResponse($response, $order);
    }

    public function transactionStatus(Order $order): array
    {
        if (!$order->pakasir_txn_id) {
            throw new RuntimeException('ID transaksi Pakasir belum tersedia.');
        }

        $response = $this->request()->get(
            $this->endpoint('transaction-status/' . rawurlencode($order->project_slug) . '/' . rawurlencode($order->pakasir_txn_id))
        );

        if (!$response->successful()) {
            throw new RuntimeException($this->responseError($response));
        }

        $transaction = $response->json();
        if (!is_array($transaction) || empty($transaction['status'])) {
            throw new RuntimeException('Respons status transaksi Pakasir tidak valid.');
        }

        return $transaction;
    }

    public function cancelTransaction(Order $order): bool
    {
        if (!$order->pakasir_txn_id) {
            return true;
        }

        if (RateLimiter::tooManyAttempts('pakasir-cancel-transaction', 2)) {
            throw new RuntimeException('Permintaan pembatalan sedang padat. Coba lagi sebentar.');
        }
        RateLimiter::hit('pakasir-cancel-transaction', 1);

        $response = $this->request()->post(
            $this->endpoint('cancel-transaction/' . rawurlencode($order->project_slug) . '/' . rawurlencode($order->pakasir_txn_id))
        );

        if (!$response->successful()) {
            throw new RuntimeException($this->responseError($response));
        }

        return true;
    }

    private function request()
    {
        $apiKey = config('services.pakasir.api_key');
        if (!$apiKey) {
            throw new RuntimeException('Konfigurasi API Pakasir belum lengkap.');
        }

        return Http::acceptJson()
            ->asJson()
            ->withHeader('X-Api-Key', $apiKey)
            ->timeout(15);
    }

    private function endpoint(string $path): string
    {
        $baseUrl = rtrim((string) config('services.pakasir.base_url'), '/');
        $baseUrl = preg_replace('~/api$~i', '', $baseUrl);
        if (!$baseUrl || !config('services.pakasir.slug')) {
            throw new RuntimeException('Konfigurasi proyek Pakasir belum lengkap.');
        }

        return $baseUrl . '/api/v2/' . ltrim($path, '/');
    }

    private function parseCreateResponse(Response $response, Order $order): array
    {
        if (!$response->successful()) {
            return [
                'success' => false,
                'retryable' => $response->serverError() || $response->status() === 429,
                'http_status' => $response->status(),
                'error' => $this->responseError($response),
            ];
        }

        $payment = $response->json();
        if (!is_array($payment) || empty($payment['txn_id'])) {
            return [
                'success' => false,
                'retryable' => true,
                'error' => 'Respons pembuatan transaksi Pakasir tidak valid.',
            ];
        }

        if ((isset($payment['order_id']) && $payment['order_id'] !== $order->order_id)
            || (isset($payment['amount']) && (int) $payment['amount'] !== (int) $order->amount)) {
            return [
                'success' => false,
                'retryable' => false,
                'error' => 'Data transaksi Pakasir tidak cocok dengan order aplikasi.',
            ];
        }

        if (array_key_exists('is_sandbox', $payment)
            && filter_var($payment['is_sandbox'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== (bool) config('services.pakasir.is_sandbox')) {
            return [
                'success' => false,
                'retryable' => false,
                'error' => 'Mode transaksi Pakasir tidak sesuai dengan konfigurasi aplikasi.',
            ];
        }

        return ['success' => true, 'payment' => $payment];
    }

    private function responseError(Response $response): string
    {
        foreach (['message', 'error', 'detail', 'description'] as $key) {
            $message = $response->json($key);

            if (is_string($message) && trim($message) !== '') {
                return trim($message);
            }

            if (is_array($message)) {
                $messages = collect($message)
                    ->flatten()
                    ->filter(fn ($item) => is_string($item) && trim($item) !== '')
                    ->map(fn ($item) => trim($item))
                    ->values();

                if ($messages->isNotEmpty()) {
                    return $messages->implode(' ');
                }
            }
        }

        return 'Pakasir mengembalikan HTTP ' . $response->status() . '.';
    }
}
