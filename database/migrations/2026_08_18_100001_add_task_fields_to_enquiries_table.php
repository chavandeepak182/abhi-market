<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Backs the Today's Tasks dashboard (agent.today-tasks / admin equivalent):
 * - today_task_completed: agent has ticked off today's new-lead-contacted
 *   / today's-followup-done checkbox for this enquiry.
 * - followup_count: how many followups have been completed for this
 *   enquiry so far (shown as "x/6" on the lead detail page and used to
 *   sort the Today's Followups list).
 *
 * Safe to re-run - checks hasColumn first.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            if (! Schema::hasColumn('enquiries', 'today_task_completed')) {
                $table->boolean('today_task_completed')->default(false)->after('has_unread_reply');
            }

            if (! Schema::hasColumn('enquiries', 'followup_count')) {
                $table->unsignedInteger('followup_count')->default(0)->after('today_task_completed');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            foreach (['today_task_completed', 'followup_count'] as $column) {
                if (Schema::hasColumn('enquiries', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
