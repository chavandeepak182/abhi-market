<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Queued automated follow-up emails (a scheduled_at time + which
 * email_template to send). Matches global-crm's scheduled_followups table,
 * pointed at enquiries instead of leads.
 *
 * Not wired into a UI yet in this pass - the table/model exist so the
 * automated follow-up scheduler can be built on top of them later,
 * matching how it works in global-crm.
 *
 * Safe to re-run - checks hasTable first.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('enquiry_scheduled_followups')) {
            return;
        }

        Schema::create('enquiry_scheduled_followups', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('enquiry_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedBigInteger('email_template_id')->nullable();

            $table->unsignedInteger('sequence')->default(1);

            $table->dateTime('scheduled_at');
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();

            $table->string('subject')->nullable();
            $table->longText('body')->nullable();

            $table->timestamps();

            $table->index('enquiry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiry_scheduled_followups');
    }
};
