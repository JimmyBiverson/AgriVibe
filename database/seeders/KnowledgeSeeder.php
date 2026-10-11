<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Species;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Livestock' => '🐄', 'Poultry' => '🐔', 'Fish Farming' => '🐟',
            'Crop Farming' => '🌾', 'Animal Health' => '🩺', 'Farm Management' => '📋',
            'Agribusiness' => '💼', 'News & Updates' => '📰', 'Success Stories' => '🌟',
        ];
        $categoryModels = [];
        foreach ($categories as $name => $icon) {
            $categoryModels[$name] = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'type' => 'article', 'icon' => $icon, 'is_active' => true],
            );
        }

        $tags = ['Vaccination', 'Feeding', 'Housing', 'Biosecurity', 'Profitability', 'Breeding', 'Disease Control', 'Marketing'];
        $tagModels = [];
        foreach ($tags as $tag) {
            $tagModels[$tag] = Tag::updateOrCreate(['slug' => Str::slug($tag)], ['name' => $tag]);
        }

        $articles = [
            ['When should I vaccinate my chickens?', 'Poultry', 'Animal Health', 'beginner', 'knowledge', true, ['Vaccination', 'Disease Control'], 'A practical day-by-day vaccination road map for layers, broilers and dual-purpose flocks in East Africa.'],
            ['How much space do 500 broilers need?', 'Poultry', 'Farm Management', 'beginner', 'knowledge', true, ['Housing'], 'Deep-litter spacing, ventilation and stocking density explained for a 500-bird broiler batch.'],
            ['Starting a profitable piggery in Uganda', 'Livestock', 'Agribusiness', 'intermediate', 'knowledge', false, ['Profitability', 'Feeding'], 'Costs, housing, feed and market strategy for a small-to-medium piggery.'],
            ['Water quality management in fish ponds', 'Fish Farming', 'Fish Farming', 'intermediate', 'knowledge', false, ['Feeding'], 'pH, dissolved oxygen, ammonia and how to keep your ponds healthy.'],
            ['Understanding East Coast Fever in cattle', 'Livestock', 'Animal Health', 'intermediate', 'knowledge', true, ['Disease Control', 'Vaccination'], 'Symptoms, tick control and treatment for ECF. Always consult a veterinarian.'],
            ['Choosing the right chicken breed', 'Poultry', 'Poultry', 'beginner', 'knowledge', false, ['Breeding'], 'Layers, broilers, dual-purpose and indigenous breeds compared.'],
            ['Maize farming: from planting to harvest', 'Crop Farming', 'Crop Farming', 'beginner', 'knowledge', false, ['Feeding', 'Marketing'], 'Land preparation, spacing, fertiliser and post-harvest handling for maize.'],
            ['From two goats to a herd: Sarah\'s story', 'Livestock', 'Success Stories', 'all', 'success_story', true, ['Profitability'], 'How a smallholder in Kumi built a 60-goat herd in three years.'],
            ['Agrivibe launches SMS reminders for farmers', 'News & Updates', 'News & Updates', 'all', 'news', false, [], 'Essential vaccination and feeding reminders now available on any phone.'],
        ];

        foreach ($articles as $i => [$title, $category, $catFallback, $audience, $type, $featured, $tags, $excerpt]) {
            $article = Article::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'category_id' => ($categoryModels[$category] ?? $categoryModels[$catFallback])->id,
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'body' => "<p>{$excerpt}</p><p>This guide covers the essentials in clear, practical language. Follow the recommended steps and always consult a qualified professional for health decisions.</p><h3>Key points</h3><ul><li>Plan before you invest.</li><li>Keep accurate records.</li><li>Maintain strict biosecurity.</li></ul><p class=\"text-sm text-muted\"><em>Veterinary and medical content must be validated by qualified local authorities and does not replace professional advice.</em></p>",
                    'audience' => $audience,
                    'content_type' => $type,
                    'status' => 'published',
                    'is_featured' => $featured,
                    'is_expert_verified' => false,
                    'requires_vet_validation' => str_contains($title, 'vaccin') || str_contains($title, 'Fever'),
                    'disclaimer' => 'General guidance only. Consult a qualified veterinary professional.',
                    'meta_title' => $title.' | Agrivibe',
                    'meta_description' => Str::limit($excerpt, 150),
                    'views' => random_int(50, 900),
                    'published_at' => now()->subDays(($i + 1) * 3),
                ],
            );

            $article->tags()->sync(collect($tags)->map(fn ($t) => $tagModels[$t]->id ?? null)->filter()->all());
        }

        $faqs = [
            ['How do I create an account on Agrivibe?', 'Click Register, choose your account type, enter your details and verify your email.'],
            ['Is Agrivibe free to use?', 'Yes. Core farming tools and knowledge are free. Optional premium plans add advanced features.'],
            ['Can I use Agrivibe without a smartphone?', 'Yes. Essential reminders and market prices are available via SMS.'],
            ['How do I find a veterinarian near me?', 'Use Find a Vet, filter by animal type and location, then book an appointment.'],
            ['Is my farm data private?', 'Yes. Your farm records are private unless you choose to share them.'],
            ['How accurate is the veterinary information?', 'Content is for general guidance and must not replace professional veterinary advice.'],
        ];
        foreach ($faqs as [$q, $a]) {
            Faq::updateOrCreate(['question' => $q], ['answer' => $a, 'is_active' => true]);
        }
    }
}
