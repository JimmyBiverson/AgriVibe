<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationAndLanguageSeeder extends Seeder
{
    public function run(): void
    {
        // Languages
        $languages = [
            ['en', 'English', 'English', true],
            ['sw', 'Swahili', 'Kiswahili', true],
            ['lg', 'Luganda', 'Luganda', true],
            ['teo', 'Ateso', 'Ateso', false],
            ['nyn', 'Runyankole', 'Runyankole', false],
            ['luo', 'Luo', 'Dholuo', false],
        ];
        foreach ($languages as [$code, $name, $native, $active]) {
            Language::updateOrCreate(
                ['code' => $code],
                ['name' => $name, 'native_name' => $native, 'is_active' => $active, 'is_default' => $code === 'en'],
            );
        }

        // Country
        $uganda = Location::updateOrCreate(
            ['type' => 'country', 'code' => 'UG'],
            ['name' => 'Uganda', 'country_code' => 'UG', 'is_active' => true, 'sort' => 0],
        );

        $regions = ['Central' => 'C', 'Eastern' => 'E', 'Northern' => 'N', 'Western' => 'W'];

        $districts = [
            'Central' => ['Kampala', 'Wakiso', 'Mukono', 'Masaka', 'Entebbe', 'Mpigi', 'Buikwe', 'Luweero', 'Nakaseke'],
            'Eastern' => ['Jinja', 'Mbale', 'Soroti', 'Kumi', 'Tororo', 'Busia', 'Iganga', 'Kamuli', 'Pallisa'],
            'Northern' => ['Gulu', 'Lira', 'Arua', 'Kitgum', 'Adjumani', 'Apac', 'Nebbi', 'Yumbe'],
            'Western' => ['Mbarara', 'Kasese', 'Fort Portal', 'Hoima', 'Kabale', 'Bushenyi', 'Masindi', 'Kabarole'],
        ];

        $regionModels = [];
        foreach ($regions as $name => $code) {
            $regionModels[$name] = Location::updateOrCreate(
                ['type' => 'region', 'parent_id' => $uganda->id, 'name' => $name],
                ['code' => $code, 'country_code' => 'UG', 'is_active' => true],
            );
        }

        $districtModels = [];
        foreach ($districts as $region => $names) {
            foreach ($names as $name) {
                $districtModels[$name] = Location::updateOrCreate(
                    ['type' => 'district', 'parent_id' => $regionModels[$region]->id, 'name' => $name],
                    ['country_code' => 'UG', 'is_active' => true],
                );
            }
        }

        // Sub-counties for a couple of districts
        $subCounties = [
            'Kampala' => ['Central Division', 'Nakawa Division', 'Kawempe Division', 'Makindye Division', 'Rubaga Division'],
            'Kumi' => ['Kumi', 'Ongino', 'Kanyum', 'Nyero'],
            'Wakiso' => ['Nansana', 'Kira', 'Makindye Ssabagabo', 'Entebbe'],
            'Mbarara' => ['Mbarara City', 'Kakoba', 'Nyamitanga'],
        ];
        foreach ($subCounties as $district => $names) {
            if (! isset($districtModels[$district])) {
                continue;
            }
            foreach ($names as $name) {
                Location::updateOrCreate(
                    ['type' => 'sub_county', 'parent_id' => $districtModels[$district]->id, 'name' => $name],
                    ['country_code' => 'UG', 'is_active' => true],
                );
            }
        }
    }
}
