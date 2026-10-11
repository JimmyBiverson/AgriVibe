<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('phone', 32)->nullable()->unique()->after('email');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->string('account_type', 40)->default('farmer')->index()->after('password');
            $table->string('status', 20)->default('active')->index();
            $table->string('avatar')->nullable();
            $table->string('referral_code', 16)->nullable()->unique();
            $table->foreignId('referred_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->timestamp('onboarding_completed_at')->nullable();
            $table->json('preferences')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referred_by');
            $table->dropColumn([
                'uuid', 'username', 'phone', 'phone_verified_at', 'account_type', 'status',
                'avatar', 'referral_code', 'is_verified', 'verified_at', 'two_factor_secret',
                'two_factor_recovery_codes', 'two_factor_confirmed_at', 'last_login_at',
                'last_login_ip', 'onboarding_completed_at', 'preferences', 'deleted_at',
            ]);
        });
    }
};
