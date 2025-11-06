<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->morphs('bookable'); // For agencies and vendors
            $table->foreignId('inquiry_id')->nullable()->constrained()->nullOnDelete();
            $table->date('event_date');
            $table->string('event_location')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('amount', 12, 2);
            $table->decimal('deposit_amount', 12, 2)->nullable();
            $table->decimal('balance_amount', 12, 2)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('client_notes')->nullable();
            $table->text('vendor_notes')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->timestamp('deposit_paid_at')->nullable();
            $table->timestamp('full_payment_received_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
