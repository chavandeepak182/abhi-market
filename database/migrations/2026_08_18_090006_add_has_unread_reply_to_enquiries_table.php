<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mirrors global-crm's `has_unread_reply` flag on leads: set true when an
 * inbound email reply comes in (see SyncGmail / SyncCustomerEmails /
 * FetchEmails), cleared when the lead detail page is opened (see
 * LeadController::show / AgentController::leadDetails). Used by the My
 * Leads list to highlight leads with a reply waiting.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            if (! Schema::hasColumn('enquiries', 'has_unread_reply')) {
                $table->boolean('has_unread_reply')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            if (Schema::hasColumn('enquiries', 'has_unread_reply')) {
                $table->dropColumn('has_unread_reply');
            }
        });
    }
};
