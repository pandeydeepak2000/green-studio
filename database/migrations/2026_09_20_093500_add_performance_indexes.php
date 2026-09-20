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
        // Add performance indexes to invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->index('invoice_date');
            $table->index('status');
            $table->index(['invoice_date', 'status']);
        });

        // Add index on paid_at for invoice_transactions
        if (Schema::hasTable('invoice_transactions')) {
            Schema::table('invoice_transactions', function (Blueprint $table) {
                $table->index('paid_at');
            });
        }

        // Add index on created_at for activity_logs
        if (Schema::hasTable('activity_logs')) {
            Schema::table('activity_logs', function (Blueprint $table) {
                $table->index('created_at');
            });
        }

        // Add search indexes on customers
        if (Schema::hasTable('customers')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->index('name');
                $table->index('company_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex(['invoice_date']);
            $table->dropIndex(['status']);
            $table->dropIndex(['invoice_date', 'status']);
        });

        if (Schema::hasTable('invoice_transactions')) {
            Schema::table('invoice_transactions', function (Blueprint $table) {
                $table->dropIndex(['paid_at']);
            });
        }

        if (Schema::hasTable('activity_logs')) {
            Schema::table('activity_logs', function (Blueprint $table) {
                $table->dropIndex(['created_at']);
            });
        }

        if (Schema::hasTable('customers')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropIndex(['name']);
                $table->dropIndex(['company_name']);
            });
        }
    }
};
