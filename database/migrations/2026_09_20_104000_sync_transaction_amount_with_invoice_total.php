<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('invoice_transactions') && Schema::hasTable('invoices')) {
            DB::statement("
                UPDATE invoice_transactions t
                JOIN invoices i ON t.invoice_id = i.id
                SET t.amount = i.total_amount
                WHERE t.amount <= 0 OR t.amount IS NULL
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse operation needed
    }
};
