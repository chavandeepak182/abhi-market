<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_email_logs', function (Blueprint $table) {

    $table->id();

    $table->unsignedInteger('enquiry_id');

    $table->text('research_data')->nullable();

    $table->string('email_subject')->nullable();

    $table->longText('email_body')->nullable();

    $table->json('faqs')->nullable();

    $table->enum('status', [
        'pending',
        'generated',
        'sent',
        'failed'
    ])->default('pending');

    $table->text('error_message')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_email_logs');
    }
};
