<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('partner_name')->nullable();
            $table->date('wedding_date')->nullable();
            $table->string('wedding_city')->nullable();
            $table->string('wedding_state')->nullable();
            $table->string('wedding_venue')->nullable();
            $table->integer('guest_count')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->enum('wedding_type', ['traditional', 'destination', 'themed', 'intimate', 'other'])->nullable();
            $table->text('preferences')->nullable(); // JSON encoded preferences
            $table->text('cultural_requirements')->nullable(); // Any cultural/religious requirements
            $table->string('phone')->nullable();
            $table->text('additional_info')->nullable();
            $table->enum('planning_status', ['just_engaged', 'planning', 'finalizing', 'completed'])->default('just_engaged');
            $table->json('booked_vendors')->nullable(); // Track vendors they've booked
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
