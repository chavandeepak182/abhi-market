<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Completed-followup log shown on the lead detail page's "Followup
 * History" timeline. This is separate from the existing `enquiry_followups`
 * table (which is the older manual followup-note system already used by
 * /followup/{id} and the "Add Followup" flow) - this new table matches
 * global-crm's `followup_histories` (renamed with the enquiry_ prefix to
 * follow this project's convention) and is written to by the automated /
 * scheduled followup flow (see App\Models\ScheduledFollowup).
 *
 * Safe to re-run - checks hasTable first.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('enquiry_followup_histories')) {
            return;
        }

        Schema::create('enquiry_followup_histories', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('enquiry_id');

            $table->unsignedInteger('followup_no')->default(1);

            // Short label, e.g. "Followup #2" or a template name.
            $table->string('header')->nullable();

            $table->unsignedInteger('user_id')->nullable();

            $table->text('remarks')->nullable();

            $table->dateTime('completed_at')->nullable();

            $table->timestamps();

            $table->index('enquiry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiry_followup_histories');
    }
};
