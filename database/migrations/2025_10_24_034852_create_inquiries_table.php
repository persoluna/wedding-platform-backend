<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('event_date')->nullable();
            $table->string('event_location')->nullable();
            $table->integer('guest_count')->nullable();
            $table->text('message');
            $table->decimal('budget', 12, 2)->nullable();
            $table->enum('status', ['new', 'in_progress', 'responded', 'booked', 'cancelled', 'unavailable'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->text('internal_notes')->nullable(); // For agency/vendor private notes
            $table->text('client_notes')->nullable(); // For client visible notes
            $table->boolean('is_urgent')->default(false);
            $table->string('source')->nullable(); // Where the inquiry came from
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('last_follow_up_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
