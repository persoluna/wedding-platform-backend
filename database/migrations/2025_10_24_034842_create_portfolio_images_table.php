<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_images', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable'); // For both agencies and vendors
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image_path');
            $table->string('thumbnail_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable(); // For EXIF data, dimensions, etc.
            $table->string('alt_text')->nullable(); // For accessibility
            $table->string('tags')->nullable(); // For categorizing images
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_images');
    }
};
