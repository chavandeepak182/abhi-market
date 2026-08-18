<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds timezone auto-detection support to the public enquiry form, mirroring
 * the global-crm project:
 *
 *   - timezone         The exact browser IANA timezone captured via JS
 *                       (e.g. "Asia/Kolkata", "America/Chicago"). Used to
 *                       show each lead's local time on the All Enquiries
 *                       page.
 *   - timezone_region  That timezone resolved to one of 8 broad regions
 *                       (via App\Services\TimezoneRegionMapper), used for
 *                       auto agent assignment. Kept separate from the
 *                       existing country-based `region_id` column so we
 *                       never touch/reinterpret that column's existing
 *                       meaning.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            if (! Schema::hasColumn('enquiries', 'timezone')) {
                $table->string('timezone', 100)->nullable()->after('country_id');
            }

            if (! Schema::hasColumn('enquiries', 'timezone_region')) {
                $table->string('timezone_region', 50)->nullable()->after('timezone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            if (Schema::hasColumn('enquiries', 'timezone_region')) {
                $table->dropColumn('timezone_region');
            }

            if (Schema::hasColumn('enquiries', 'timezone')) {
                $table->dropColumn('timezone');
            }
        });
    }
};
