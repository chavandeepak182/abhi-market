<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Schema parity with global-crm's contacts / campaigns / campaign_leads
 * tables, for the App\Models\Contact and App\Models\Campaign that were
 * copied over. Not wired into any controller/view in this pass - no page
 * in abhi-market creates or lists contacts/campaigns yet, so this only
 * creates the tables so those models don't point at nothing.
 *
 * campaign_leads links a campaign to enquiries (abhi-market's lead
 * equivalent) rather than to a `leads` table.
 *
 * Safe to re-run - checks hasTable first for each table.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('company')->nullable();
                $table->unsignedInteger('enquiry_id')->nullable();
                $table->timestamps();

                $table->index('enquiry_id');
            });
        }

        if (! Schema::hasTable('campaigns')) {
            Schema::create('campaigns', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('status')->default('draft');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('campaign_leads')) {
            Schema::create('campaign_leads', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('campaign_id');
                $table->unsignedInteger('enquiry_id');
                $table->timestamps();

                $table->unique(['campaign_id', 'enquiry_id']);

                $table->foreign('campaign_id')
                    ->references('id')->on('campaigns')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_leads');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('contacts');
    }
};
