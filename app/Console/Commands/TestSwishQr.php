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
        $identifier = 'test-' . time();

        $this->info("Testing Swish QR code generation...");
        $this->info("Amount: {$amount} SEK");
        $this->info("Message: {$message}");
        $this->newLine();

        $filename = SwishQrService::generateAndSaveQrCode($amount, $message, $identifier);

        if ($filename) {
            $this->info("✓ QR code generated and saved successfully!");
            $this->info("Filename: {$filename}");
            $this->newLine();

            $publicUrl = SwishQrService::getPublicUrl($filename);
            $this->info("Public URL: {$publicUrl}");
            $this->newLine();

            $paymentUrl = SwishQrService::generatePaymentUrl($amount, $message);
            $this->info("Payment URL: {$paymentUrl}");
            $this->newLine();

            $this->info("Open this URL in your browser to view the QR code:");
            $this->line($publicUrl);
        } else {
            $this->error("✗ QR code generation failed!");
            $this->warn("Check the Laravel logs (storage/logs/laravel.log) for detailed error information.");
        }

        return $filename ? Command::SUCCESS : Command::FAILURE;
    }
}
