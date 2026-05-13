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
    Schema::create('invoice_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();

        $table->string('description');
        $table->string('hsn_sac')->nullable();
        $table->decimal('qty', 12, 2)->default(1);
        $table->string('unit')->nullable();
        $table->decimal('rate', 12, 2)->default(0);   // price per unit
        $table->decimal('taxable', 12, 2)->default(0);
        $table->decimal('gst_percent', 5, 2)->default(0);
        $table->decimal('cgst_amount', 12, 2)->default(0);
        $table->decimal('sgst_amount', 12, 2)->default(0);
        $table->decimal('igst_amount', 12, 2)->default(0);
        $table->decimal('line_total', 12, 2)->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
