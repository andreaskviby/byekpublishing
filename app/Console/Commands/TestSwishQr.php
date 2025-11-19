<?php

namespace App\Console\Commands;

use App\Services\SwishQrService;
use Illuminate\Console\Command;

class TestSwishQr extends Command
{
    protected $signature = 'test:swish-qr {amount=100} {message=Test}';

    protected $description = 'Test Swish QR code generation';

    public function handle(): int
    {
        $amount = (float) $this->argument('amount');
        $message = $this->argument('message');

        $this->info("Testing Swish QR code generation...");
        $this->info("Amount: {$amount} SEK");
        $this->info("Message: {$message}");
        $this->newLine();

        $qrCode = SwishQrService::generateQrCode($amount, $message);

        if ($qrCode) {
            $this->info("✓ QR code generated successfully!");
            $this->info("Base64 length: " . strlen($qrCode) . " characters");
            $this->newLine();

            $paymentUrl = SwishQrService::generatePaymentUrl($amount, $message);
            $this->info("Payment URL: {$paymentUrl}");
            $this->newLine();

            $this->info("You can test the QR code by saving this base64 string to an HTML file:");
            $this->line('<img src="data:image/png;base64,' . substr($qrCode, 0, 50) . '..." />');
        } else {
            $this->error("✗ QR code generation failed!");
            $this->warn("Check the Laravel logs (storage/logs/laravel.log) for detailed error information.");
        }

        return $qrCode ? Command::SUCCESS : Command::FAILURE;
    }
}
