<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CRM-parity additions to the existing enquiry_meetings table:
 * - title: short meeting title shown on the Today's Tasks / Meetings pages.
 * - meeting_with: free-text fallback name when a meeting isn't tied to a
 *   specific enquiry (matches global-crm's Meeting.meeting_with).
 * - conducted: agent has ticked the meeting off as actually held, distinct
 *   from `status` (scheduled/cancelled/etc).
 *
 * Safe to re-run - checks hasColumn first.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiry_meetings', function (Blueprint $table) {
            if (! Schema::hasColumn('enquiry_meetings', 'title')) {
                $table->string('title')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('enquiry_meetings', 'meeting_with')) {
                $table->string('meeting_with')->nullable()->after('title');
            }

            if (! Schema::hasColumn('enquiry_meetings', 'conducted')) {
                $table->boolean('conducted')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enquiry_meetings', function (Blueprint $table) {
            foreach (['title', 'meeting_with', 'conducted'] as $column) {
                if (Schema::hasColumn('enquiry_meetings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
