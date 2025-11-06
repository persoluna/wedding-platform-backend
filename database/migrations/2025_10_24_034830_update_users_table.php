<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'type')) {
                $table->enum('type', ['admin', 'agency', 'vendor', 'client'])->default('client')->after('password');
            }
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('type');
            }
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'active')) {
                $table->boolean('active')->default(true)->after('avatar');
            }
            if (! Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
            if (! Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->after('active');
            }
            if (! Schema::hasColumn('users', 'login_type')) {
                $table->string('login_type')->default('email')->after('google_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['type', 'phone', 'avatar', 'active', 'google_id', 'login_type']);
            $table->dropSoftDeletes();
        });
    }
};
