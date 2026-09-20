<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            $invoices = \App\Models\Invoice::with('transactions')->get();

            foreach ($invoices as $invoice) {
                if ($invoice->invoice_date && $invoice->transactions()->exists()) {
                    $txDate = \Illuminate\Support\Carbon::parse($invoice->invoice_date)->setTime(14, 30, 0);

                    foreach ($invoice->transactions as $tx) {
                        $tx->update([
                            'paid_at' => $txDate,
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
            // Safe fallback
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed
    }
};
