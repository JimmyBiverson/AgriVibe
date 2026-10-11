<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Individual Animals (Cattle, Goats, Sheep, Pigs, etc.)
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnDelete();
            $table->foreignId('species_id')->nullable()->constrained('species')->nullOnDelete();
            $table->foreignId('breed_id')->nullable()->constrained('breeds')->nullOnDelete();
            $table->string('tag_number', 50)->index();
            $table->string('rfid_code', 50)->nullable()->index();
            $table->string('name', 100)->nullable();
            $table->string('gender', 10)->default('female'); // male, female, castrated
            $table->date('date_of_birth')->nullable();
            $table->decimal('weight_kg', 8, 2)->nullable();
            $table->string('health_status', 30)->default('healthy'); // healthy, sick, quarantined, recovering
            $table->string('reproductive_status', 30)->default('open'); // open, pregnant, lactating, dry
            $table->string('housing_location', 100)->nullable();
            $table->decimal('estimated_value', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Animal Batches / Flocks / Ponds (Poultry, Aquaculture, Swine litters)
        Schema::create('animal_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnDelete();
            $table->foreignId('species_id')->nullable()->constrained('species')->nullOnDelete();
            $table->foreignId('breed_id')->nullable()->constrained('breeds')->nullOnDelete();
            $table->string('batch_code', 50)->index();
            $table->string('name', 100);
            $table->string('type', 30)->default('poultry'); // poultry, fish, piglet, other
            $table->unsignedInteger('initial_quantity')->default(0);
            $table->unsignedInteger('current_quantity')->default(0);
            $table->unsignedInteger('mortality_count')->default(0);
            $table->date('start_date');
            $table->date('expected_end_date')->nullable();
            $table->decimal('average_weight_kg', 8, 3)->nullable();
            $table->decimal('target_fcr', 5, 2)->default(1.50); // Feed conversion ratio
            $table->string('housing_unit', 100)->nullable();
            $table->string('status', 30)->default('active'); // active, harvested, sold, closed
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Daily Production Logs (Milk, Eggs, Fish, Crops harvest)
        Schema::create('production_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnDelete();
            $table->foreignId('animal_id')->nullable()->constrained('animals')->nullOnDelete();
            $table->foreignId('animal_batch_id')->nullable()->constrained('animal_batches')->nullOnDelete();
            $table->string('product_type', 30); // milk, eggs, meat, fish, grain
            $table->date('record_date');
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 20)->default('litres'); // litres, trays, kg, bags
            $table->unsignedInteger('cracked_damaged_qty')->default(0);
            $table->decimal('retained_home_use', 10, 2)->default(0);
            $table->decimal('sold_quantity', 10, 2)->default(0);
            $table->decimal('unit_selling_price', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Clinical Events, Treatments & Mandatory Withdrawal Warnings
        Schema::create('health_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnDelete();
            $table->foreignId('animal_id')->nullable()->constrained('animals')->nullOnDelete();
            $table->foreignId('animal_batch_id')->nullable()->constrained('animal_batches')->nullOnDelete();
            $table->foreignId('vet_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('event_type', 40); // vaccination, deworming, treatment, checkup
            $table->string('title', 150);
            $table->string('medicine_name', 150)->nullable();
            $table->string('dosage', 100)->nullable();
            $table->date('administered_date');
            $table->unsignedInteger('withdrawal_period_days')->default(0);
            $table->date('safe_consumption_date')->nullable();
            $table->string('status', 30)->default('completed'); // scheduled, completed, cancelled
            $table->text('clinical_notes')->nullable();
            $table->timestamps();
        });

        // 5. Farm Financial Ledger (Income & Expenses, Feeding costs, Sales)
        Schema::create('farm_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnDelete();
            $table->foreignId('animal_batch_id')->nullable()->constrained('animal_batches')->nullOnDelete();
            $table->string('type', 20); // income, expense
            $table->string('category', 50); // feed, medicine, labour, chicks, sales, equipment, utilities
            $table->date('transaction_date');
            $table->decimal('amount', 14, 2);
            $table->string('currency', 5)->default('UGX');
            $table->string('description', 255);
            $table->string('reference_number', 50)->nullable();
            $table->timestamps();
        });

        // 6. Farm Operational Tasks & Reminders
        Schema::create('farm_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title', 200);
            $table->string('category', 50)->default('general'); // feeding, health, cleaning, harvest, maintenance
            $table->date('due_date');
            $table->string('priority', 20)->default('normal'); // low, normal, high, urgent
            $table->string('status', 30)->default('pending'); // pending, in_progress, completed
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 7. Marketplace Listings
        Schema::create('marketplace_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->string('title', 200);
            $table->string('slug')->unique();
            $table->string('category', 50); // produce, livestock, feed, veterinary, equipment
            $table->decimal('price', 12, 2);
            $table->string('unit', 30)->default('unit'); // kg, tray, bag, head, litre
            $table->decimal('available_stock', 10, 2)->default(1);
            $table->string('location', 100);
            $table->string('district', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('status', 30)->default('active'); // active, out_of_stock, paused
            $table->timestamps();
        });

        // 8. Veterinary Telemedicine & Field Appointments
        Schema::create('vet_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vet_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('farm_id')->nullable()->constrained('farms')->nullOnDelete();
            $table->foreignId('animal_id')->nullable()->constrained('animals')->nullOnDelete();
            $table->string('service_type', 50)->default('telemedicine'); // telemedicine, emergency_visit, routine_check, vaccination
            $table->dateTime('scheduled_at');
            $table->string('status', 30)->default('confirmed'); // pending, confirmed, in_progress, completed, cancelled
            $table->string('urgency', 20)->default('normal'); // low, normal, high, critical
            $table->text('symptoms_description')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('prescription')->nullable();
            $table->decimal('fee_ugx', 12, 2)->default(0);
            $table->timestamps();
        });

        // 9. SMS & USSD Delivery Logs
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('recipient_phone', 30)->index();
            $table->string('direction', 10)->default('outgoing'); // incoming, outgoing
            $table->text('message');
            $table->string('channel', 20)->default('sms'); // sms, ussd
            $table->string('status', 30)->default('delivered'); // pending, delivered, failed
            $table->decimal('cost_ugx', 8, 2)->default(35);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
        Schema::dropIfExists('vet_appointments');
        Schema::dropIfExists('marketplace_items');
        Schema::dropIfExists('farm_tasks');
        Schema::dropIfExists('farm_finances');
        Schema::dropIfExists('health_events');
        Schema::dropIfExists('production_records');
        Schema::dropIfExists('animal_batches');
        Schema::dropIfExists('animals');
    }
};
