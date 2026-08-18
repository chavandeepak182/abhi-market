<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the columns the new CRM-style lead detail pages
 * (admin/leads/show.blade.php, agent/lead-details.blade.php) need for a
 * proper threaded email history, on top of the existing `ai_email_logs`
 * table (kept as-is rather than adding a parallel `email_messages` table,
 * since ai_email_logs is already the live email log used by
 * ProcessEnquiryAI, SyncGmail, SyncCustomerEmails, FetchEmails, etc).
 *
 * `email_subject` / `email_body` remain the canonical columns written by
 * the existing AI pipeline - App\Models\EmailMessage exposes `subject` /
 * `body` as accessors on top of them so both naming conventions keep
 * working without touching that existing code.
 *
 * Safe to re-run - every column is guarded with hasColumn.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_email_logs', function (Blueprint $table) {

            // 'sent' | 'received' - inbound replies vs outbound sends.
            if (! Schema::hasColumn('ai_email_logs', 'message_type')) {
                $table->string('message_type')->default('sent')->after('source');
            }

            if (! Schema::hasColumn('ai_email_logs', 'delivery_status')) {
                $table->string('delivery_status')->nullable()->after('status');
            }

            if (! Schema::hasColumn('ai_email_logs', 'delivery_error')) {
                $table->text('delivery_error')->nullable()->after('delivery_status');
            }

            if (! Schema::hasColumn('ai_email_logs', 'subject')) {
                $table->string('subject')->nullable()->after('email_subject');
            }

            if (! Schema::hasColumn('ai_email_logs', 'body')) {
                $table->longText('body')->nullable()->after('email_body');
            }

            if (! Schema::hasColumn('ai_email_logs', 'from_email')) {
                $table->string('from_email')->nullable()->after('to_email');
            }

            if (! Schema::hasColumn('ai_email_logs', 'cc_email')) {
                $table->text('cc_email')->nullable();
            }

            if (! Schema::hasColumn('ai_email_logs', 'bcc_email')) {
                $table->text('bcc_email')->nullable();
            }

            if (! Schema::hasColumn('ai_email_logs', 'reply_to')) {
                $table->string('reply_to')->nullable();
            }

            if (! Schema::hasColumn('ai_email_logs', 'attachment_path')) {
                $table->string('attachment_path')->nullable();
            }

            if (! Schema::hasColumn('ai_email_logs', 'attachment_name')) {
                $table->string('attachment_name')->nullable();
            }

            // Threading - groups a reply chain together in the UI.
            if (! Schema::hasColumn('ai_email_logs', 'message_id')) {
                $table->string('message_id')->nullable();
            }

            if (! Schema::hasColumn('ai_email_logs', 'in_reply_to')) {
                $table->string('in_reply_to')->nullable();
            }

            if (! Schema::hasColumn('ai_email_logs', 'thread_id')) {
                $table->string('thread_id')->nullable();
            }

            if (! Schema::hasColumn('ai_email_logs', 'conversation_id')) {
                $table->string('conversation_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ai_email_logs', function (Blueprint $table) {
            $table->dropColumn([
                'message_type', 'delivery_status', 'delivery_error',
                'subject', 'body', 'from_email', 'cc_email', 'bcc_email',
                'reply_to', 'attachment_path', 'attachment_name',
                'message_id', 'in_reply_to', 'thread_id', 'conversation_id',
            ]);
        });
    }
};
