<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Reusable email templates, picked from the "Compose Email" modal on the
 * lead detail page. Matches global-crm's email_templates table.
 *
 * type: 'global' (the single Sample Report template, see
 *       EmailTemplate::scopeSendable) | 'followup' (used only by the
 *       automated follow-up scheduler, never shown for manual picking).
 *
 * Safe to re-run - checks hasTable first.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('email_templates')) {
            return;
        }

        Schema::create('email_templates', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();

            $table->string('type')->default('global');

            $table->unsignedInteger('days_after_creation')->nullable();
            $table->unsignedInteger('followup_number')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
