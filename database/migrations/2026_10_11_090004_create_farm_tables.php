<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enterprise_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sector', 32)->default('livestock')->index();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type', 40)->default('individual');
            $table->string('country_code', 3)->default('UG');
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('district')->nullable();
            $table->string('sub_county')->nullable();
            $table->string('parish')->nullable();
            $table->string('village')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('acreage', 10, 2)->nullable();
            $table->string('land_tenure', 30)->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('water_sources')->nullable();
            $table->boolean('has_electricity')->default(false);
            $table->text('infrastructure')->nullable();
            $table->unsignedInteger('workers_count')->default(0);
            $table->json('emergency_contacts')->nullable();
            $table->foreignId('assigned_vet_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('preferred_language', 12)->default('en');
            $table->string('preferred_contact', 20)->default('sms');
            $table->string('visibility', 20)->default('private');
            $table->string('status', 20)->default('active')->index();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('farm_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role', 40)->default('viewer');
            $table->json('permissions')->nullable();
            $table->string('status', 20)->default('active');
            $table->foreignId('invited_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            $table->unique(['farm_id', 'user_id']);
        });

        Schema::create('farm_enterprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();
            $table->foreignId('enterprise_type_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->string('unit', 32)->nullable();
            $table->decimal('size', 12, 2)->nullable();
            $table->string('status', 20)->default('active');
            $table->date('started_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farm_enterprises');
        Schema::dropIfExists('farm_members');
        Schema::dropIfExists('farms');
        Schema::dropIfExists('enterprise_types');
    }
};
