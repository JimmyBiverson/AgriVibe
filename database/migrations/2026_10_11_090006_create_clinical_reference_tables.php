<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('species_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category', 40)->nullable()->index();
            $table->text('cause')->nullable();
            $table->longText('symptoms')->nullable();
            $table->longText('prevention')->nullable();
            $table->longText('treatment')->nullable();
            $table->string('severity', 20)->nullable();
            $table->boolean('is_notifiable')->default(false);
            $table->boolean('is_contagious')->default(false);
            $table->string('image')->nullable();
            $table->boolean('is_expert_verified')->default(false);
            $table->text('disclaimer')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->fullText(['name', 'symptoms', 'cause']);
        });

        Schema::create('symptoms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('disease_symptom', function (Blueprint $table) {
            $table->foreignId('disease_id')->constrained()->cascadeOnDelete();
            $table->foreignId('symptom_id')->constrained()->cascadeOnDelete();
            $table->primary(['disease_id', 'symptom_id']);
        });

        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('species_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('disease_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('manufacturer')->nullable();
            $table->text('description')->nullable();
            $table->string('dosage')->nullable();
            $table->string('route', 40)->nullable();
            $table->unsignedInteger('withdrawal_days_meat')->nullable();
            $table->unsignedInteger('withdrawal_days_milk')->nullable();
            $table->unsignedInteger('withdrawal_days_eggs')->nullable();
            $table->text('storage')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('vaccination_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('species_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vaccine_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->unsignedInteger('age_days_from')->default(0);
            $table->unsignedInteger('age_days_to')->nullable();
            $table->string('age_label')->nullable();
            $table->string('route', 40)->nullable();
            $table->string('dose')->nullable();
            $table->string('frequency')->nullable();
            $table->string('production_system', 40)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_expert_verified')->default(false);
            $table->text('disclaimer')->nullable();
            $table->string('source')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category', 60)->nullable();
            $table->text('description')->nullable();
            $table->string('dosage')->nullable();
            $table->string('route', 40)->nullable();
            $table->unsignedInteger('withdrawal_days_meat')->nullable();
            $table->unsignedInteger('withdrawal_days_milk')->nullable();
            $table->unsignedInteger('withdrawal_days_eggs')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('vaccination_schedules');
        Schema::dropIfExists('vaccines');
        Schema::dropIfExists('disease_symptom');
        Schema::dropIfExists('symptoms');
        Schema::dropIfExists('diseases');
    }
};
