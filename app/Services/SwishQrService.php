<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SwishQrService
{
    private const API_URL = 'https://mpc.getswish.net/qrg-swish/api/v1/prefilled';
    private const SWISH_NUMBER = '46734642332';

    public static function generateQrCode(
        float $amount,
        string $message,
        string $format = 'png',
        int $size = 300
    ): ?string {
        try {
            $response = Http::timeout(10)->post(self::API_URL, [
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
            ]);

            if ($response->successful()) {
                return base64_encode($response->body());
            }

            Log::error('Swish QR code generation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Swish QR code generation exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public static function getInlineImageData(?string $base64Image, string $format = 'png'): ?string
    {
        if (! $base64Image) {
            return null;
        }

        return "data:image/{$format};base64,{$base64Image}";
    }
}
