<?php

namespace Database\Seeders;

use App\Models\EnterpriseType;
use App\Models\Farm;
use App\Models\FarmEnterprise;
use App\Models\FarmMember;
use App\Models\Location;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = $this->makeUser('Agrivibe Admin', 'admin@agrivibe.test', '+256700000001', 'admin', 'active');
        $admin->syncRoles(['super_admin', 'admin']);
        $admin->forceFill(['email_verified_at' => now(), 'is_verified' => true])->save();

        $manager = $this->makeUser('Platform Manager', 'manager@agrivibe.test', '+256700000002', 'admin', 'active');
        $manager->syncRoles(['admin']);
        $manager->forceFill(['email_verified_at' => now(), 'is_verified' => true])->save();

        $farmer = $this->makeUser('Sarah Nakato', 'farmer@agrivibe.test', '+256700000003', 'farmer', 'active');
        $farmer->syncRoles(['farmer', 'farm_owner']);
        $farmer->forceFill(['email_verified_at' => now(), 'phone_verified_at' => now()])->save();

        $vet = $this->makeUser('Dr. Moses Okello', 'vet@agrivibe.test', '+256700000004', 'veterinarian', 'active');
        $vet->syncRoles(['veterinarian']);
        $vet->forceFill(['email_verified_at' => now(), 'is_verified' => true, 'verified_at' => now()])->save();

        $buyer = $this->makeUser('Kampala Fresh Foods', 'buyer@agrivibe.test', '+256700000005', 'buyer', 'active');
        $buyer->syncRoles(['buyer']);
        $buyer->forceFill(['email_verified_at' => now()])->save();

        $supplier = $this->makeUser('Uganda Feeds Ltd', 'supplier@agrivibe.test', '+256700000006', 'supplier', 'active');
        $supplier->syncRoles(['supplier']);
        $supplier->forceFill(['email_verified_at' => now()])->save();

        $trainer = $this->makeUser('AgriSkills Academy', 'trainer@agrivibe.test', '+256700000007', 'trainer', 'active');
        $trainer->syncRoles(['trainer']);
        $trainer->forceFill(['email_verified_at' => now(), 'is_verified' => true, 'verified_at' => now()])->save();

        // Sample farm for the farmer.
        $kumi = Location::where('type', 'district')->where('name', 'Kumi')->first();

        $farm = Farm::updateOrCreate(
            ['slug' => 'nakato-family-farm'],
            [
                'owner_id' => $farmer->id,
                'name' => 'Nakato Family Farm',
                'type' => 'individual',
                'country_code' => 'UG',
                'location_id' => $kumi?->id,
                'district' => 'Kumi',
                'sub_county' => 'Kumi',
                'village' => 'Ongino',
                'acreage' => 12.5,
                'land_tenure' => 'owned',
                'description' => 'Mixed smallholder farm keeping goats, local chicken and growing maize.',
                'water_sources' => ['borehole', 'rainwater'],
                'has_electricity' => false,
                'workers_count' => 3,
                'assigned_vet_id' => $vet->id,
                'preferred_language' => 'en',
                'preferred_contact' => 'sms',
                'visibility' => 'public',
                'status' => 'active',
                'verified_at' => now(),
            ],
        );

        FarmMember::updateOrCreate(
            ['farm_id' => $farm->id, 'user_id' => $farmer->id],
            ['role' => 'farm_owner', 'status' => 'active', 'joined_at' => now()],
        );

        foreach (['goats', 'layers', 'maize'] as $slug) {
            $type = EnterpriseType::where('slug', $slug)->first();
            if ($type) {
                FarmEnterprise::updateOrCreate(
                    ['farm_id' => $farm->id, 'enterprise_type_id' => $type->id],
                    ['name' => $type->name, 'status' => 'active', 'started_at' => now()->subMonths(8)],
                );
            }
        }
    }

    protected function makeUser(string $name, string $email, string $phone, string $accountType, string $status): User
    {
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'username' => Str::before($email, '@'),
                'phone' => $phone,
                'password' => 'password',
                'account_type' => $accountType,
                'status' => $status,
                'referral_code' => strtoupper(Str::random(8)),
                'preferences' => [],
            ],
        );

        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            ['preferred_language' => 'en', 'preferred_contact' => 'sms', 'country_code' => 'UG'],
        );

        return $user;
    }
}
