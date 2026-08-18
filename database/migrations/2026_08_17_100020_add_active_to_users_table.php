<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Powers the "Deactivate" toggle on /admin/agents. Deactivated agents are
 * excluded from new-lead auto-assignment (EnquiryController already checks
 * users.active there) and are blocked from logging in.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'active')) {
                $table->boolean('active')->default(true)->after('role_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'active')) {
                $table->dropColumn('active');
            }
        });
    }
};
