<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SwishQrService
{
    private const API_URL = 'https://mpc.getswish.net/qrg-swish/api/v1/prefilled';
    private const SWISH_NUMBER = '46734642332';

    public static function generateAndSaveQrCode(
        float $amount,
        string $message,
        string $identifier,
        string $format = 'png',
        int $size = 300
    ): ?string {
        try {
            $payload = [
                'format' => $format,
                'size' => $size,
                'payee' => [
                    'value' => self::SWISH_NUMBER,
                    'editable' => false,
                ],
                'amount' => [
                    'value' => $amount,
                    'editable' => false,
                ],
                'message' => [
                    'value' => $message,
                    'editable' => false,
                ],
            ];

            Log::info('Swish QR code generation attempt', [
                'url' => self::API_URL,
                'payload' => $payload,
            ]);

            $response = Http::timeout(10)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post(self::API_URL, $payload);

            if ($response->successful()) {
                $filename = "qr-codes/swish-{$identifier}.{$format}";
                Storage::disk('public')->put($filename, $response->body());

                Log::info('Swish QR code saved successfully', [
                    'filename' => $filename,
                ]);

                return $filename;
            }

            Log::error('Swish QR code generation failed', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Swish QR code generation exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    public static function generatePaymentUrl(float $amount, string $message): string
    {
        $params = http_build_query([
            'sw' => self::SWISH_NUMBER,
            'amt' => number_format($amount, 2, '.', ''),
            'msg' => $message,
        ]);

        return 'https://app.swish.nu/1/p/sw/?' . $params;
    }

    public static function getPublicUrl(?string $filename): ?string
    {
        if (! $filename) {
            return null;
        }

        return asset('storage/' . $filename);
    }

    public static function cleanupOldQrCodes(int $olderThanHours = 24): void
    {
        $files = Storage::disk('public')->files('qr-codes');
        $threshold = now()->subHours($olderThanHours)->timestamp;

        foreach ($files as $file) {
            if (Storage::disk('public')->lastModified($file) < $threshold) {
                Storage::disk('public')->delete($file);
                Log::info('Deleted old QR code', ['file' => $file]);
            }
        }
    }
}
