<?php

namespace App\Http\Controllers;

use App\Models\Article;

class SectionController extends Controller
{
    public function marketplace()
    {
        return $this->render('marketplace', [
            'icon' => 'bag',
            'eyebrow' => 'Marketplace',
            'title' => 'Buy and sell farm products the smart way',
            'intro' => 'Agrivibe Marketplace connects farmers, suppliers and buyers across Uganda. Classified listings, verified suppliers, secure transactions and order tracking — all in one place.',
            'profileHints' => ['seller' => 'List produce, livestock and inputs', 'buyer' => 'Browse verified suppliers near you'],
        ]);
    }

    public function findVet()
    {
        return $this->render('find-a-vet', [
            'icon' => 'heart-pulse',
            'eyebrow' => 'Find a Vet',
            'title' => 'Animal health help, minutes away',
            'intro' => 'Search vets and animal health professionals by location and animal type, book appointments and get medication reminders.',
            'profileHints' => ['veterinarian' => 'Offer services and consultations'],
        ]);
    }

    public function training()
    {
        return $this->render('training', [
            'icon' => 'academy',
            'title' => 'Practical training that pays',
            'intro' => 'Short, practical courses on poultry, piggery, fish farming, crop agronomy and agribusiness — taught by verified experts.',
            'profileHints' => ['trainer' => 'Create and sell courses'],
        ]);
    }

    public function community()
    {
        return $this->render('community', [
            'icon' => 'community',
            'title' => 'Farms grow better together',
            'intro' => 'Join farmer groups, share experiences in forums, ask questions and organise bulk purchases with other farmers.',
            'profileHints' => ['cooperative' => 'Run a farmer group'],
        ]);
    }

    public function marketPrices()
    {
        return $this->render('market-prices', [
            'icon' => 'cash',
            'title' => 'Know your prices before you sell',
            'intro' => 'Real market prices for produce and livestock from markets across Uganda — updated regularly and available on any phone.',
            'profileHints' => [],
        ]);
    }

    protected function render(string $key, array $data)
    {
        $data['key'] = $key;
        $data['relatedArticles'] = Article::query()->published()
            ->with('category')
            ->latest('published_at')
            ->limit(3)
            ->get();

        $data['status'] = 'In development';
        $data['statusNote'] = 'This module is part of the core Agrivibe build and ships in an upcoming phase. You can register today and explore the Knowledge Centre while you wait.';

        return view('sections.show', $data);
    }
}
