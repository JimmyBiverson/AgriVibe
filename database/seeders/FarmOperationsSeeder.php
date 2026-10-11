<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalBatch;
use App\Models\Breed;
use App\Models\Farm;
use App\Models\FarmFinance;
use App\Models\FarmTask;
use App\Models\HealthEvent;
use App\Models\MarketplaceItem;
use App\Models\ProductionRecord;
use App\Models\SmsLog;
use App\Models\Species;
use App\Models\User;
use App\Models\VetAppointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FarmOperationsSeeder extends Seeder
{
    public function run(): void
    {
        $farmer = User::where('email', 'farmer@agrivibe.test')->first();
        $vet = User::where('email', 'vet@agrivibe.test')->first();
        $buyer = User::where('email', 'buyer@agrivibe.test')->first();
        $supplier = User::where('email', 'supplier@agrivibe.test')->first();
        $farm = Farm::where('slug', 'nakato-family-farm')->first();

        if (! $farmer || ! $farm) {
            return;
        }

        $cattleSpecies = Species::where('slug', 'cattle')->first();
        $goatSpecies = Species::where('slug', 'goats')->first();
        $chickenSpecies = Species::where('slug', 'chicken')->first();
        $tilapiaSpecies = Species::where('slug', 'tilapia')->first();

        $friesianBreed = Breed::where('slug', 'friesian')->first();
        $ankoleBreed = Breed::where('slug', 'ankole')->first();
        $boerBreed = Breed::where('slug', 'boer')->first();
        $kuroilerBreed = Breed::where('slug', 'kuroiler')->first();
        $cobbBreed = Breed::where('slug', 'cobb-500')->first();
        $tilapiaBreed = Breed::where('slug', 'nile-tilapia')->first();

        // 1. Seed Individual Cattle & Goats
        $cows = [
            ['tag' => 'UG-KMI-101', 'name' => 'Bella', 'breed' => $friesianBreed, 'status' => 'lactating', 'weight' => 520, 'val' => 3500000],
            ['tag' => 'UG-KMI-102', 'name' => 'Daisy', 'breed' => $friesianBreed, 'status' => 'lactating', 'weight' => 495, 'val' => 3200000],
            ['tag' => 'UG-KMI-103', 'name' => 'Luna', 'breed' => $friesianBreed, 'status' => 'lactating', 'weight' => 510, 'val' => 3400000],
            ['tag' => 'UG-KMI-104', 'name' => 'Kembabazi', 'breed' => $ankoleBreed, 'status' => 'pregnant', 'weight' => 460, 'val' => 2800000],
            ['tag' => 'UG-KMI-105', 'name' => 'Mirembe', 'breed' => $ankoleBreed, 'status' => 'lactating', 'weight' => 475, 'val' => 2900000],
        ];

        $createdAnimals = [];
        foreach ($cows as $c) {
            $createdAnimals[] = Animal::updateOrCreate(
                ['farm_id' => $farm->id, 'tag_number' => $c['tag']],
                [
                    'species_id' => $cattleSpecies?->id,
                    'breed_id' => $c['breed']?->id,
                    'name' => $c['name'],
                    'gender' => 'female',
                    'date_of_birth' => now()->subYears(3),
                    'weight_kg' => $c['weight'],
                    'health_status' => 'healthy',
                    'reproductive_status' => $c['status'],
                    'housing_location' => 'Main Zero-Grazing Shed',
                    'estimated_value' => $c['val'],
                ]
            );
        }

        // Seed Goats
        for ($i = 1; $i <= 6; $i++) {
            $createdAnimals[] = Animal::updateOrCreate(
                ['farm_id' => $farm->id, 'tag_number' => "BG-0{$i}"],
                [
                    'species_id' => $goatSpecies?->id,
                    'breed_id' => $boerBreed?->id,
                    'name' => "Boer Doe #{$i}",
                    'gender' => 'female',
                    'date_of_birth' => now()->subMonths(18),
                    'weight_kg' => 42.5,
                    'health_status' => 'healthy',
                    'reproductive_status' => 'pregnant',
                    'housing_location' => 'Raised Slatted Pen',
                    'estimated_value' => 350000,
                ]
            );
        }

        // 2. Seed Animal Batches (Broilers & Layers & Tilapia)
        $broilerBatch = AnimalBatch::updateOrCreate(
            ['farm_id' => $farm->id, 'batch_code' => 'BATCH-BR-04'],
            [
                'species_id' => $chickenSpecies?->id,
                'breed_id' => $cobbBreed?->id,
                'name' => 'Commercial Broiler Batch B-04',
                'type' => 'poultry',
                'initial_quantity' => 500,
                'current_quantity' => 493,
                'mortality_count' => 7,
                'start_date' => now()->subDays(24),
                'expected_end_date' => now()->addDays(11),
                'average_weight_kg' => 1.450,
                'target_fcr' => 1.48,
                'housing_unit' => 'Deep Litter House 1',
                'status' => 'active',
                'notes' => 'Vaccinated on Day 1 (Marek\'s), Day 7 (Newcastle), Day 14 (Gumboro).',
            ]
        );

        $layersBatch = AnimalBatch::updateOrCreate(
            ['farm_id' => $farm->id, 'batch_code' => 'BATCH-LAY-02'],
            [
                'species_id' => $chickenSpecies?->id,
                'breed_id' => $kuroilerBreed?->id,
                'name' => 'Kuroiler Free-Range Layers',
                'type' => 'poultry',
                'initial_quantity' => 300,
                'current_quantity' => 294,
                'mortality_count' => 6,
                'start_date' => now()->subMonths(5),
                'expected_end_date' => now()->addMonths(12),
                'average_weight_kg' => 2.100,
                'target_fcr' => 2.20,
                'housing_unit' => 'Semi-Intensive Yard',
                'status' => 'active',
                'notes' => 'High egg production stage. Peak lay currently 88%.',
            ]
        );

        $fishBatch = AnimalBatch::updateOrCreate(
            ['farm_id' => $farm->id, 'batch_code' => 'POND-TIL-01'],
            [
                'species_id' => $tilapiaSpecies?->id,
                'breed_id' => $tilapiaBreed?->id,
                'name' => 'Nile Tilapia Earthen Pond #1',
                'type' => 'fish',
                'initial_quantity' => 1500,
                'current_quantity' => 1460,
                'mortality_count' => 40,
                'start_date' => now()->subMonths(2),
                'expected_end_date' => now()->addMonths(4),
                'average_weight_kg' => 0.220,
                'target_fcr' => 1.35,
                'housing_unit' => 'Pond Sector East (20x30m)',
                'status' => 'active',
                'notes' => 'DO 6.8 mg/L, pH 7.2. Morning and evening pellet feeding.',
            ]
        );

        // 3. Daily Production Logs (Past 7 days)
        for ($d = 6; $d >= 0; $d--) {
            $date = now()->subDays($d)->format('Y-m-d');
            // Milk
            ProductionRecord::updateOrCreate(
                ['farm_id' => $farm->id, 'record_date' => $date, 'product_type' => 'milk'],
                [
                    'quantity' => 138 + ($d * 1.5),
                    'unit' => 'litres',
                    'cracked_damaged_qty' => 0,
                    'retained_home_use' => 8,
                    'sold_quantity' => 130 + ($d * 1.5),
                    'unit_selling_price' => 1100,
                    'notes' => 'Morning and evening collection.',
                ]
            );

            // Eggs
            ProductionRecord::updateOrCreate(
                ['farm_id' => $farm->id, 'record_date' => $date, 'product_type' => 'eggs'],
                [
                    'animal_batch_id' => $layersBatch->id,
                    'quantity' => 260,
                    'unit' => 'eggs',
                    'cracked_damaged_qty' => 6,
                    'retained_home_use' => 14,
                    'sold_quantity' => 240, // 8 trays
                    'unit_selling_price' => 450, // per egg (~13,500/tray)
                    'notes' => 'Grade A brown eggs.',
                ]
            );
        }

        // 4. Clinical Events with ACTIVE Withdrawal Period Warning
        HealthEvent::updateOrCreate(
            ['farm_id' => $farm->id, 'title' => 'Mastitis Treatment (Bella #101)'],
            [
                'animal_id' => $createdAnimals[0]->id,
                'vet_id' => $vet?->id,
                'event_type' => 'treatment',
                'medicine_name' => 'Penicillin-Streptomycin intramammary',
                'dosage' => '1 syringe per quarter for 3 days',
                'administered_date' => now()->subDays(2),
                'withdrawal_period_days' => 5,
                'safe_consumption_date' => now()->addDays(3), // ACTIVE WITHDRAWAL!
                'status' => 'completed',
                'clinical_notes' => 'Do not sell or consume milk from this cow until safe date.',
            ]
        );

        HealthEvent::updateOrCreate(
            ['farm_id' => $farm->id, 'title' => 'Newcastle Booster Batch B-04'],
            [
                'animal_batch_id' => $broilerBatch->id,
                'vet_id' => $vet?->id,
                'event_type' => 'vaccination',
                'medicine_name' => 'Newcastle La Sota Strain',
                'dosage' => 'Via clean drinking water with skimmed milk stabilizer',
                'administered_date' => now()->subDays(10),
                'withdrawal_period_days' => 0,
                'safe_consumption_date' => now()->subDays(10),
                'status' => 'completed',
                'clinical_notes' => 'Flock immune response verified. Zero withdrawal days.',
            ]
        );

        // 5. Farm Financial Ledger
        $finances = [
            ['type' => 'expense', 'cat' => 'feed', 'amt' => 540000, 'desc' => 'Broiler Finisher Pellets (4 bags @ 135k)'],
            ['type' => 'expense', 'cat' => 'medicine', 'amt' => 45000, 'desc' => 'Mastitis infusion tube + mineral block'],
            ['type' => 'expense', 'cat' => 'labour', 'amt' => 120000, 'desc' => 'Weekly farm attendants allowance (2 staff)'],
            ['type' => 'income', 'cat' => 'sales', 'amt' => 1001000, 'desc' => 'Fresh milk collection payout (910L @ 1100 UGX)'],
            ['type' => 'income', 'cat' => 'sales', 'amt' => 378000, 'desc' => 'Table eggs wholesale sale (28 trays @ 13500 UGX)'],
        ];
        foreach ($finances as $f) {
            FarmFinance::updateOrCreate(
                ['farm_id' => $farm->id, 'description' => $f['desc']],
                [
                    'type' => $f['type'],
                    'category' => $f['cat'],
                    'transaction_date' => now()->subDays(rand(1, 5)),
                    'amount' => $f['amt'],
                    'currency' => 'UGX',
                    'reference_number' => 'TXN-' . strtoupper(Str::random(6)),
                ]
            );
        }

        // 6. Farm Tasks
        $tasks = [
            ['title' => 'Morning Milking & Strip Cup Mastitis Check', 'cat' => 'milking', 'priority' => 'urgent', 'due' => now()->format('Y-m-d')],
            ['title' => 'Collect Afternoon Eggs (Layers Shed)', 'cat' => 'harvest', 'priority' => 'high', 'due' => now()->format('Y-m-d')],
            ['title' => 'Evening Tilapia Pond Feeding (3.5% body weight)', 'cat' => 'feeding', 'priority' => 'normal', 'due' => now()->format('Y-m-d')],
            ['title' => 'Clean & Disinfect Broiler Water Bell Drinkers', 'cat' => 'cleaning', 'priority' => 'normal', 'due' => now()->addDay()->format('Y-m-d')],
            ['title' => 'Tick Dipping / Acaricide Spraying for Boer Goats', 'cat' => 'health', 'priority' => 'high', 'due' => now()->addDays(2)->format('Y-m-d')],
        ];
        foreach ($tasks as $t) {
            FarmTask::updateOrCreate(
                ['farm_id' => $farm->id, 'title' => $t['title']],
                [
                    'assigned_to' => $farmer->id,
                    'category' => $t['cat'],
                    'due_date' => $t['due'],
                    'priority' => $t['priority'],
                    'status' => 'pending',
                ]
            );
        }

        // 7. Vet Appointments
        if ($vet) {
            VetAppointment::updateOrCreate(
                ['farmer_id' => $farmer->id, 'vet_id' => $vet->id, 'service_type' => 'telemedicine'],
                [
                    'farm_id' => $farm->id,
                    'animal_id' => $createdAnimals[0]->id,
                    'scheduled_at' => now()->addHours(3),
                    'status' => 'confirmed',
                    'urgency' => 'high',
                    'symptoms_description' => 'Follow-up on Bella mastitis recovery and milk clear test.',
                    'fee_ugx' => 30000,
                ]
            );

            VetAppointment::updateOrCreate(
                ['farmer_id' => $farmer->id, 'vet_id' => $vet->id, 'service_type' => 'emergency_visit'],
                [
                    'farm_id' => $farm->id,
                    'scheduled_at' => now()->addDays(2)->setTime(10, 0),
                    'status' => 'confirmed',
                    'urgency' => 'normal',
                    'symptoms_description' => 'Scheduled herd reproductive ultrasound and artificial insemination check.',
                    'fee_ugx' => 85000,
                ]
            );
        }

        // 8. Marketplace Items
        $marketItems = [
            ['title' => 'Fresh Farm Table Eggs (Large Brown, Tray of 30)', 'cat' => 'produce', 'price' => 13500, 'unit' => 'tray', 'stock' => 120, 'loc' => 'Kumi Farm Gate', 'seller' => $farmer],
            ['title' => 'Live Boer Breeding Buck (14 Months, Certified)', 'cat' => 'livestock', 'price' => 450000, 'unit' => 'head', 'stock' => 3, 'loc' => 'Kumi Ranch', 'seller' => $farmer],
            ['title' => 'Broiler Finisher Pellets 50kg (High Protein)', 'cat' => 'feed', 'price' => 135000, 'unit' => 'bag', 'stock' => 250, 'loc' => 'Jinja Depot / Kampala Delivery', 'seller' => $supplier ?? $farmer],
            ['title' => 'Newcastle I-2 Thermostable Vaccine (100 Doses)', 'cat' => 'veterinary', 'price' => 18000, 'unit' => 'vial', 'stock' => 80, 'loc' => 'Kampala Vet Pharma', 'seller' => $supplier ?? $farmer],
            ['title' => 'Nile Tilapia Live Fingerlings (Sex-Reversed 5g)', 'cat' => 'livestock', 'price' => 350, 'unit' => 'fingerling', 'stock' => 10000, 'loc' => 'Entebbe Hatchery', 'seller' => $supplier ?? $farmer],
        ];

        foreach ($marketItems as $m) {
            MarketplaceItem::updateOrCreate(
                ['slug' => Str::slug($m['title'])],
                [
                    'seller_id' => $m['seller']->id,
                    'title' => $m['title'],
                    'category' => $m['cat'],
                    'price' => $m['price'],
                    'unit' => $m['unit'],
                    'available_stock' => $m['stock'],
                    'location' => $m['loc'],
                    'district' => 'Kumi',
                    'status' => 'active',
                ]
            );
        }

        // 9. SMS Delivery Logs
        $smsEntries = [
            ['msg' => 'AgriVibe Alert: Cow #UG-KMI-101 milk withdrawal active until ' . now()->addDays(3)->format('d M') . '. Do not consume.', 'dir' => 'outgoing', 'status' => 'delivered'],
            ['msg' => 'Reminder: Telemedicine appointment with Dr. Moses Okello scheduled today at 16:30.', 'dir' => 'outgoing', 'status' => 'delivered'],
            ['msg' => 'USSD *284*40# query for Maize wholesale price answered: 1,250 UGX/kg in Kampala.', 'dir' => 'incoming', 'status' => 'delivered'],
            ['msg' => 'Daily farm report: 142 Litres milk recorded, 8 trays eggs collected. Net margin +28.4%.', 'dir' => 'outgoing', 'status' => 'delivered'],
        ];

        foreach ($smsEntries as $sms) {
            SmsLog::create([
                'user_id' => $farmer->id,
                'recipient_phone' => $farmer->phone ?? '+256700000003',
                'direction' => $sms['dir'],
                'message' => $sms['msg'],
                'channel' => 'sms',
                'status' => $sms['status'],
                'cost_ugx' => 35,
            ]);
        }
    }
}
