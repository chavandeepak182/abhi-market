<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Extra PDF attachments on a single email (beyond the one auto-attached
 * report). Mirrors global-crm's email_message_attachments table, pointed
 * at ai_email_logs (abhi-market's equivalent of CRM's email_messages).
 *
 * Safe to re-run - checks hasTable first.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('email_message_attachments')) {
            return;
        }

        Schema::create('email_message_attachments', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('email_message_id');

            $table->string('file_name');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->nullable();

            $table->timestamps();

            $table->index('email_message_id');

            $table->foreign('email_message_id')
                ->references('id')->on('ai_email_logs')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_message_attachments');
    }
};
