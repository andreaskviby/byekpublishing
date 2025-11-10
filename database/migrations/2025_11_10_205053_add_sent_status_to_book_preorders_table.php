<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE book_preorders MODIFY COLUMN payment_status ENUM('pending', 'paid', 'sent', 'expired') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE book_preorders MODIFY COLUMN payment_status ENUM('pending', 'paid', 'expired') DEFAULT 'pending'");
    }
};
