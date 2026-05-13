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
    Schema::create('invoices', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_number')->unique(); // e.g. INV-2026-0001
        $table->date('invoice_date');
        $table->foreignId('company_id')->constrained()->cascadeOnDelete();
        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

        $table->string('sale_type')->nullable(); // LOCAL / CENTRAL
        $table->decimal('taxable_amount', 12, 2)->default(0);
        $table->decimal('cgst_amount', 12, 2)->default(0);
        $table->decimal('sgst_amount', 12, 2)->default(0);
        $table->decimal('igst_amount', 12, 2)->default(0);
        $table->decimal('total_amount', 12, 2)->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
