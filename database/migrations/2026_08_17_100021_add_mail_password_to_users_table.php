<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Stores each agent's Gmail App Password (encrypted at rest via
 * Crypt::encryptString in AgentController::store), matching global-crm's
 * "App Password" field on the Add Agent form. Kept as a plain nullable
 * string column - encryption/decryption is handled in the controller
 * since abhi-market's User model isn't an Eloquent model with casts here.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'mail_password')) {
                $table->text('mail_password')->nullable()->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'mail_password')) {
                $table->dropColumn('mail_password');
            }
        });
    }
};
