<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Company Name
            $table->string('gstin')->nullable();  // GSTIN
            $table->string('state')->nullable();  // Company State (for GST logic)
            $table->string('state_code')->nullable(); // Optional: numeric state code
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('logo_path')->nullable(); // logo file path
            $table->string('signature_path')->nullable(); // signature image
            $table->boolean('is_default')->default(false); // current active company
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
