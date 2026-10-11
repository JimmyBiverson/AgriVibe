<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('gender', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('bio')->nullable();
            $table->string('organization')->nullable();
            $table->string('job_title')->nullable();
            $table->string('phone_alt', 32)->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('address')->nullable();
            $table->string('country_code', 3)->nullable();
            $table->string('preferred_language', 12)->nullable()->default('en');
            $table->string('preferred_contact', 20)->nullable()->default('sms');
            $table->string('timezone')->nullable()->default('Africa/Kampala');
            $table->string('website')->nullable();
            $table->json('socials')->nullable();
            $table->timestamps();
        });

        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('identifier')->index();
            $table->string('channel', 20)->default('sms');
            $table->string('purpose', 40)->index();
            $table->string('code_hash');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('consumed_at')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('login_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('identifier')->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device')->nullable();
            $table->string('location')->nullable();
            $table->boolean('successful')->default(true);
            $table->string('failure_reason')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
        });

        Schema::create('consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 60)->index();
            $table->string('version', 20)->nullable();
            $table->boolean('granted')->default(true);
            $table->timestamp('accepted_at')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'type', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consents');
        Schema::dropIfExists('login_histories');
        Schema::dropIfExists('otp_codes');
        Schema::dropIfExists('user_profiles');
    }
};
