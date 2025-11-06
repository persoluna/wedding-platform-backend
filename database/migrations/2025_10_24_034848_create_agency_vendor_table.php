<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agency_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->boolean('is_preferred')->default(false); // Agency can mark as preferred vendor
            $table->text('terms_and_conditions')->nullable(); // Special terms between agency and vendor
            $table->decimal('commission_rate', 5, 2)->nullable(); // If agency gets commission
            $table->boolean('visible_on_agency_profile')->default(true);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            // Each vendor can be associated with an agency only once
            $table->unique(['agency_id', 'vendor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agency_vendor');
    }
};
