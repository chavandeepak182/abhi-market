<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Which broad timezone regions (see App\Services\TimezoneRegionMapper) each
 * agent covers. An agent can cover more than one region. New enquiries are
 * auto-assigned to the least-loaded active, non-on-leave agent covering the
 * lead's resolved region - same behaviour as global-crm's Region/timezones
 * pivot, just named for this project's existing `users`/agent setup.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('agent_regions')) {
            return;
        }

        Schema::create('agent_regions', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('user_id');
            $table->string('region_name', 50);
            $table->timestamps();

            $table->unique(['user_id', 'region_name']);
           $table->foreignId('user_id')
    ->constrained('users')
    ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_regions');
    }
};
