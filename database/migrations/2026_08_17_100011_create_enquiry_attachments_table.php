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
        if (Schema::hasTable('enquiry_attachments')) {
            return;
        }

        Schema::create('enquiry_attachments', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('enquiry_id');

            $table->unsignedInteger('user_id')->nullable();

            $table->string('file_name');

            // Path relative to the 'public' disk, e.g. enquiry-attachments/xyz.pdf
            $table->string('file_path');

            $table->timestamps();

            $table->index('enquiry_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiry_attachments');
    }
};
