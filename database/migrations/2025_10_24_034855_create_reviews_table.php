<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->morphs('reviewable'); // For both agencies and vendors
            $table->text('comment');
            $table->integer('rating'); // 1-5 stars
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();
            $table->json('rating_breakdown')->nullable(); // For rating different aspects
            $table->string('event_date')->nullable(); // When the service was provided
            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->text('admin_notes')->nullable();
            $table->text('vendor_response')->nullable(); // Vendor can respond to review
            $table->timestamp('vendor_responded_at')->nullable();
            $table->boolean('is_reported')->default(false);
            $table->text('report_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
