<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['available', 'partially_booked', 'fully_booked', 'unavailable'])->default('available');
            $table->text('notes')->nullable();
            $table->time('available_from')->nullable();
            $table->time('available_to')->nullable();
            $table->timestamps();

            $table->unique(['vendor_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_availabilities');
    }
};
