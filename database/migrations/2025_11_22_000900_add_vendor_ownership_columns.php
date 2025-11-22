<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->foreignId('created_by_user_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('owning_agency_id')
                ->nullable()
                ->after('created_by_user_id')
                ->constrained('agencies')
                ->nullOnDelete();
        });

        DB::table('agency_vendor')
            ->select('id', 'vendor_id', 'agency_id')
            ->orderBy('id')
            ->chunkById(500, function ($rows): void {
                $vendorsToUpdate = [];

                foreach ($rows as $row) {
                    if (! isset($vendorsToUpdate[$row->vendor_id])) {
                        $vendorsToUpdate[$row->vendor_id] = $row->agency_id;
                    }
                }

                foreach ($vendorsToUpdate as $vendorId => $agencyId) {
                    DB::table('vendors')
                        ->where('id', $vendorId)
                        ->whereNull('owning_agency_id')
                        ->update(['owning_agency_id' => $agencyId]);
                }
            });

        DB::statement('UPDATE vendors SET created_by_user_id = user_id WHERE created_by_user_id IS NULL');
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropConstrainedForeignId('owning_agency_id');
            $table->dropConstrainedForeignId('created_by_user_id');
        });
    }
};
