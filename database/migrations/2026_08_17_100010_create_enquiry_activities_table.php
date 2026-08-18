<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Safe to re-run: checks hasTable first, same convention as the
     * Phase 1 / Phase 2 migrations in this project.
     */
    public function up(): void
    {
        if (Schema::hasTable('enquiry_activities')) {
            return;
        }

        Schema::create('enquiry_activities', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('enquiry_id');

            // Nullable: some activity may be system-generated (e.g. auto-assign)
            $table->unsignedInteger('user_id')->nullable();

            // 'note' | 'status' | 'reassign' | 'attachment' | 'followup'
            $table->string('activity_type');

            $table->text('description');

            $table->timestamps();

            $table->index('enquiry_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiry_activities');
    }
};
