<?php

namespace Database\Seeders;

use App\Models\Breed;
use App\Models\Disease;
use App\Models\EnterpriseType;
use App\Models\Medicine;
use App\Models\Species;
use App\Models\Symptom;
use App\Models\VaccinationSchedule;
use App\Models\Vaccine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AgricultureReferenceSeeder extends Seeder
{
    public function run(): void
    {
        $enterprises = [
            ['Dairy Cattle', 'dairy-cattle', 'livestock', '🐄'],
            ['Beef Cattle', 'beef-cattle', 'livestock', '🐄'],
            ['Goats', 'goats', 'livestock', '🐐'],
            ['Sheep', 'sheep', 'livestock', '🐑'],
            ['Pigs', 'pigs', 'livestock', '🐖'],
            ['Rabbits', 'rabbits', 'livestock', '🐇'],
            ['Layers', 'layers', 'poultry', '🐔'],
            ['Broilers', 'broilers', 'poultry', '🐓'],
            ['Local Chicken', 'local-chicken', 'poultry', '🐓'],
            ['Turkeys', 'turkeys', 'poultry', '🦃'],
            ['Ducks', 'ducks', 'poultry', '🦆'],
            ['Fish Farming', 'fish-farming', 'aquaculture', '🐟'],
            ['Maize', 'maize', 'crops', '🌽'],
            ['Beans', 'beans', 'crops', '🫘'],
            ['Bananas', 'bananas', 'crops', '🍌'],
            ['Coffee', 'coffee', 'crops', '☕'],
            ['Avocado', 'avocado', 'crops', '🥑'],
            ['Cashew Nuts', 'cashew-nuts', 'crops', '🥜'],
            ['Vegetables', 'vegetables', 'crops', '🥬'],
            ['Pasture', 'pasture', 'crops', '🌾'],
        ];

        $enterpriseModels = [];
        foreach ($enterprises as $i => [$name, $slug, $sector, $icon]) {
            $enterpriseModels[$slug] = EnterpriseType::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'sector' => $sector, 'icon' => $icon, 'is_active' => true, 'sort' => $i],
            );
        }

        $species = [
            ['Cattle', 'cattle', 'dairy-cattle', 'animal', 'Bovine', 'Bos taurus', 283, null, 104],
            ['Goats', 'goats', 'goats', 'animal', 'Caprine', 'Capra aegagrus hircus', 150, null, 45],
            ['Sheep', 'sheep', 'sheep', 'animal', 'Ovine', 'Ovis aries', 147, null, 40],
            ['Pigs', 'pigs', 'pigs', 'animal', 'Porcine', 'Sus scrofa domesticus', 114, null, 28],
            ['Rabbits', 'rabbits', 'rabbits', 'animal', 'Rabbit', 'Oryctolagus cuniculus', 31, null, 20],
            ['Chicken', 'chicken', 'layers', 'poultry', 'Poultry', 'Gallus gallus domesticus', null, 21, 20],
            ['Turkey', 'turkey', 'turkeys', 'poultry', 'Poultry', 'Meleagris gallopavo', null, 28, 24],
            ['Duck', 'duck', 'ducks', 'poultry', 'Poultry', 'Anas platyrhynchos', null, 28, 24],
            ['Tilapia', 'tilapia', 'fish-farming', 'fish', 'Aquaculture', 'Oreochromis niloticus', null, null, 24],
            ['Catfish', 'catfish', 'fish-farming', 'fish', 'Aquaculture', 'Clarias gariepinus', null, null, 28],
        ];

        $speciesModels = [];
        foreach ($species as [$name, $slug, $enterprise, $kingdom, $category, $sci, $gestation, $incubation, $maturity]) {
            $speciesModels[$slug] = Species::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'enterprise_type_id' => $enterpriseModels[$enterprise]->id ?? null,
                    'kingdom' => $kingdom,
                    'category' => $category,
                    'scientific_name' => $sci,
                    'gestation_days' => $gestation,
                    'incubation_days' => $incubation,
                    'maturity_weeks' => $maturity,
                    'is_active' => true,
                    'description' => "Key production guidance for {$name}.",
                ],
            );
        }

        $breeds = [
            ['cattle', 'Friesian', 'dairy', 'Netherlands'],
            ['cattle', 'Jersey', 'dairy', 'Channel Islands'],
            ['cattle', 'Ankole', 'dual-purpose', 'Uganda'],
            ['cattle', 'Boran', 'beef', 'East Africa'],
            ['cattle', 'Zebu', 'dual-purpose', 'East Africa'],
            ['goats', 'Boer', 'meat', 'South Africa'],
            ['goats', 'Alpine', 'dairy', 'France'],
            ['goats', 'Small East African', 'dual-purpose', 'East Africa'],
            ['sheep', 'Merino', 'wool', 'Spain'],
            ['sheep', 'Dorper', 'meat', 'South Africa'],
            ['pigs', 'Large White', 'meat', 'England'],
            ['pigs', 'Landrace', 'meat', 'Denmark'],
            ['rabbits', 'New Zealand White', 'meat', 'USA'],
            ['chicken', 'Lohmann Brown', 'eggs', 'Germany'],
            ['chicken', 'Cobb 500', 'meat', 'USA'],
            ['chicken', 'Kuroiler', 'dual-purpose', 'India'],
            ['chicken', 'Indigenous', 'dual-purpose', 'Uganda'],
            ['turkey', 'Broad Breasted White', 'meat', 'USA'],
            ['duck', 'Muscovy', 'dual-purpose', 'South America'],
            ['tilapia', 'Nile Tilapia', 'meat', 'Africa'],
            ['catfish', 'African Catfish', 'meat', 'Africa'],
        ];
        foreach ($breeds as [$species, $name, $purpose, $origin]) {
            if (! isset($speciesModels[$species])) {
                continue;
            }
            Breed::updateOrCreate(
                ['species_id' => $speciesModels[$species]->id, 'slug' => Str::slug($name)],
                ['name' => $name, 'purpose' => $purpose, 'origin' => $origin, 'is_active' => true],
            );
        }

        // Symptoms
        $symptomNames = ['Loss of appetite', 'High fever', 'Diarrhoea', 'Coughing', 'Nasal discharge', 'Sudden death', 'Drop in egg production', 'Lameness', 'Weight loss', 'Skin lesions', 'Difficulty breathing', 'Swollen joints'];
        $symptomModels = [];
        foreach ($symptomNames as $name) {
            $symptomModels[$name] = Symptom::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }

        // Diseases
        $diseases = [
            ['Newcastle Disease', 'chicken', 'viral', 'Newcastle disease virus', ['Loss of appetite', 'Diarrhoea', 'Coughing', 'Drop in egg production', 'Sudden death'], 'Vaccination, strict biosecurity, and isolating new birds.', true, 'high'],
            ['Infectious Bursal Disease (Gumboro)', 'chicken', 'viral', 'Birnavirus', ['Diarrhoea', 'Loss of appetite', 'Sudden death'], 'Vaccination of chicks and good hygiene.', true, 'high'],
            ['Marek\'s Disease', 'chicken', 'viral', 'Herpesvirus', ['Lameness', 'Weight loss', 'Sudden death'], 'Vaccinate day-old chicks.', true, 'high'],
            ['Coccidiosis', 'chicken', 'parasitic', 'Eimeria species', ['Diarrhoea', 'Weight loss', 'Loss of appetite'], 'Clean, dry litter and coccidiostat in feed.', false, 'moderate'],
            ['Foot and Mouth Disease', 'cattle', 'viral', 'Aphthovirus', ['High fever', 'Lameness', 'Skin lesions', 'Loss of appetite'], 'Vaccination and movement control.', true, 'high'],
            ['Anthrax', 'cattle', 'bacterial', 'Bacillus anthracis', ['Sudden death', 'High fever'], 'Annual vaccination; do not open carcasses.', true, 'high'],
            ['East Coast Fever', 'cattle', 'parasitic', 'Theileria parva', ['High fever', 'Loss of appetite', 'Difficulty breathing', 'Swollen joints'], 'Tick control and dipping.', false, 'high'],
            ['Mastitis', 'cattle', 'bacterial', 'Various bacteria', ['Swollen udder', 'Loss of appetite', 'Weight loss'], 'Hygienic milking and dry-cow therapy.', false, 'moderate'],
            ['PPR (Peste des Petits Ruminants)', 'goats', 'viral', 'Morbillivirus', ['High fever', 'Diarrhoea', 'Nasal discharge', 'Loss of appetite'], 'Annual vaccination.', true, 'high'],
            ['Orf (Contagious Ecthyma)', 'goats', 'viral', 'Parapoxvirus', ['Skin lesions', 'Loss of appetite'], 'Vaccination and wound care.', false, 'moderate'],
            ['African Swine Fever', 'pigs', 'viral', 'Asfarviridae', ['High fever', 'Sudden death', 'Skin lesions'], 'Strict biosecurity; there is no vaccine.', true, 'high'],
        ];
        foreach ($diseases as [$name, $species, $category, $cause, $symptoms, $prevention, $notifiable, $severity]) {
            $disease = Disease::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'species_id' => $speciesModels[$species]->id ?? null,
                    'category' => $category,
                    'cause' => $cause,
                    'symptoms' => implode("\n", $symptoms),
                    'prevention' => $prevention,
                    'severity' => $severity,
                    'is_notifiable' => $notifiable,
                    'is_contagious' => in_array($category, ['viral', 'bacterial'], true),
                    'is_expert_verified' => false,
                    'disclaimer' => 'This information requires validation by a qualified veterinary authority and does not replace professional diagnosis.',
                    'is_active' => true,
                ],
            );
            $disease->symptoms()->sync(
                collect($symptoms)->map(fn ($s) => $symptomModels[$s]->id ?? null)->filter()->all()
            );
        }

        // Vaccines
        $vaccines = [
            ['Newcastle Disease Vaccine', 'chicken', 'Newcastle Disease', 'Non-specific', 'I-2 / HB1 / La Sota', 'Ocular / drinking water / injection'],
            ['Gumboro Vaccine', 'chicken', 'Infectious Bursal Disease (Gumboro)', 'Non-specific', 'Intermediate strain', 'Drinking water'],
            ['Marek\'s Disease Vaccine', 'chicken', 'Marek\'s Disease', 'Non-specific', 'HVT', 'Subcutaneous injection at day-old'],
            ['FMD Vaccine', 'cattle', 'Foot and Mouth Disease', 'Non-specific', 'Bivalent/Trivalent', 'Intramuscular injection'],
            ['Anthrax Vaccine', 'cattle', 'Anthrax', 'Non-specific', 'Spore vaccine', 'Subcutaneous injection'],
            ['PPR Vaccine', 'goats', 'PPR (Peste des Petits Ruminants)', 'Non-specific', 'Live attenuated', 'Subcutaneous injection'],
        ];
        $vaccineModels = [];
        foreach ($vaccines as [$name, $species, $disease, $manufacturer, $dosage, $route]) {
            $vaccineModels[$name] = Vaccine::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'species_id' => $speciesModels[$species]->id ?? null,
                    'disease_id' => Disease::where('slug', Str::slug($disease))->value('id'),
                    'manufacturer' => $manufacturer,
                    'dosage' => $dosage,
                    'route' => $route,
                    'is_active' => true,
                    'description' => 'Store between 2-8°C. Keep the cold chain unbroken.',
                ],
            );
        }

        // Vaccination schedules (marked for expert review)
        $schedules = [
            ['chicken', 'Newcastle Disease Vaccine', 'Newcastle - Day 7', 7, 10, '1 week', 'Ocular / drinking water', '1 dose', 'Once'],
            ['chicken', 'Newcastle Disease Vaccine', 'Newcastle Booster - Week 4', 28, 35, '4 weeks', 'Drinking water', '1 dose', 'Once'],
            ['chicken', 'Gumboro Vaccine', 'Gumboro - Day 14', 14, 18, '2 weeks', 'Drinking water', '1 dose', 'Once'],
            ['chicken', 'Gumboro Vaccine', 'Gumboro Booster - Week 4', 28, 32, '4 weeks', 'Drinking water', '1 dose', 'Once'],
            ['chicken', 'Marek\'s Disease Vaccine', 'Marek\'s - Day old', 0, 1, 'Day old', 'Subcutaneous injection', '1 dose', 'Once'],
            ['cattle', 'FMD Vaccine', 'FMD - Annual', 90, null, 'From 3 months', 'Intramuscular injection', '2 ml', 'Every 6 months'],
            ['cattle', 'Anthrax Vaccine', 'Anthrax - Annual', 90, null, 'From 3 months', 'Subcutaneous injection', '1 ml', 'Annually'],
            ['goats', 'PPR Vaccine', 'PPR - Annual', 90, null, 'From 3 months', 'Subcutaneous injection', '1 ml', 'Annually'],
        ];
        foreach ($schedules as [$species, $vaccine, $name, $from, $to, $label, $route, $dose, $frequency]) {
            VaccinationSchedule::updateOrCreate(
                ['name' => $name, 'species_id' => $speciesModels[$species]->id ?? null],
                [
                    'vaccine_id' => $vaccineModels[$vaccine]->id ?? null,
                    'age_days_from' => $from,
                    'age_days_to' => $to,
                    'age_label' => $label,
                    'route' => $route,
                    'dose' => $dose,
                    'frequency' => $frequency,
                    'is_expert_verified' => false,
                    'disclaimer' => 'Requires validation by qualified local veterinary authorities before use.',
                    'source' => 'Agrivibe reference (pending expert review)',
                    'is_active' => true,
                ],
            );
        }

        // Medicines
        $medicines = [
            ['Oxytetracycline', 'antibiotic', 'Broad-spectrum antibiotic', '10 mg/kg', 'Injection', 28, 7, 7],
            ['Albendazole', 'dewormer', 'Broad-spectrum dewormer', '7.5 mg/kg', 'Oral drench', 14, 4, 4],
            ['Ivermectin', 'antiparasitic', 'Endo and ectoparasiticide', '0.2 mg/kg', 'Subcutaneous injection', 35, 0, 0],
            ['Amprolium', 'coccidiostat', 'Treats coccidiosis', 'In drinking water', 'Oral', 0, 0, 5],
            ['Multivitamins', 'supplement', 'Stress and growth support', 'As directed', 'Oral / water', 0, 0, 0],
            ['Acaricide', 'ectoparasiticide', 'Tick control', 'As directed', 'Spray / dip', 0, 0, 0],
        ];
        foreach ($medicines as [$name, $category, $description, $dosage, $route, $meat, $milk, $eggs]) {
            Medicine::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'category' => $category,
                    'description' => $description,
                    'dosage' => $dosage,
                    'route' => $route,
                    'withdrawal_days_meat' => $meat,
                    'withdrawal_days_milk' => $milk,
                    'withdrawal_days_eggs' => $eggs,
                    'is_active' => true,
                ],
            );
        }
    }
}
