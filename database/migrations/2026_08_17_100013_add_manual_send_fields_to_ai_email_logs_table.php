<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * `agent_id` was already being read in EnquiryController::showLead()
     * even though no migration ever added it - this adds it for real
     * (and the two new columns needed for manual sends), each guarded by
     * hasColumn so it's safe to re-run and won't error if your live DB
     * already has some of these from manual changes.
     */
    public function up(): void
    {
        Schema::table('ai_email_logs', function (Blueprint $table) {

            if (! Schema::hasColumn('ai_email_logs', 'agent_id')) {
                $table->unsignedInteger('agent_id')->nullable()->after('enquiry_id');
            }

            if (! Schema::hasColumn('ai_email_logs', 'source')) {
                // 'ai' = automated pipeline, 'manual' = admin/agent compose-and-send
                $table->string('source')->default('ai')->after('agent_id');
            }

            if (! Schema::hasColumn('ai_email_logs', 'to_email')) {
                $table->string('to_email')->nullable()->after('source');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_email_logs', function (Blueprint $table) {
            $table->dropColumn(['agent_id', 'source', 'to_email']);
        });
    }
};
