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
     * earlier phase migrations in this project.
     */
    public function up(): void
    {
        if (Schema::hasTable('enquiry_meetings')) {
            return;
        }

        Schema::create('enquiry_meetings', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('enquiry_id');

            // Agent who scheduled it
            $table->unsignedInteger('user_id')->nullable();

            $table->dateTime('scheduled_at');

            $table->unsignedInteger('duration_minutes')->default(30);

            $table->text('notes')->nullable();

            $table->enum('status', ['scheduled', 'completed', 'cancelled'])
                ->default('scheduled');

            $table->timestamps();

            $table->index('enquiry_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiry_meetings');
    }
};
