<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mirrors global-crm's on-leave substitute behaviour: if an agent is on
 * leave and has a designated substitute, new leads for their region route
 * straight to the substitute instead. Only affects NEW leads - an agent's
 * existing assigned leads are untouched.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'on_leave')) {
                $table->boolean('on_leave')->default(false)->after('role_id');
            }

            if (! Schema::hasColumn('users', 'covered_by_id')) {
                $table->unsignedBigInteger('covered_by_id')->nullable()->after('on_leave');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'covered_by_id')) {
                $table->dropColumn('covered_by_id');
            }

            if (Schema::hasColumn('users', 'on_leave')) {
                $table->dropColumn('on_leave');
            }
        });
    }
};
