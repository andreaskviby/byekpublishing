<?php

namespace App\Console\Commands;

use App\Services\SwishQrService;
use Illuminate\Console\Command;

class CleanupOldSwishQrCodes extends Command
{
    protected $signature = 'swish:cleanup-qr-codes {--hours=24 : Hours after which QR codes are considered old}';

    protected $description = 'Clean up old Swish QR code images';

    public function handle(): int
    {
        $hours = (int) $this->option('hours');

        $this->info("Cleaning up Swish QR codes older than {$hours} hours...");

        SwishQrService::cleanupOldQrCodes($hours);

        $this->info('✓ Cleanup completed successfully!');

        return Command::SUCCESS;
    }
}
