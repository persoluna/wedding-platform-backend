<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('price_unit')->default('per event'); // per event, per hour, per day, etc.
            $table->text('price_notes')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->json('attributes')->nullable(); // For service-specific attributes
            $table->boolean('available')->default(true);
            $table->integer('duration_minutes')->nullable(); // Service duration if applicable
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
