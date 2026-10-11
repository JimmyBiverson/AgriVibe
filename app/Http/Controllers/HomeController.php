<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\EnterpriseType;

class HomeController extends Controller
{
    public function __invoke()
    {
        $featuredArticles = Article::query()->published()->where('is_featured', true)
            ->with('category')->latest('published_at')->limit(4)->get();

        $latestArticles = Article::query()->published()
            ->with('category')->latest('published_at')->limit(6)->get();

        $categories = Category::query()->where('type', 'article')->where('is_active', true)
            ->orderBy('sort')->get();

        $news = Article::query()->published()->where('content_type', 'news')
            ->latest('published_at')->limit(3)->get();

        $stats = [
            'articles' => Article::published()->count(),
            'categories' => $categories->count(),
            'farms' => \App\Models\Farm::count(),
            'species' => \App\Models\Species::count(),
        ];

        $marketPrices = [
            ['commodity' => 'White Maize (Dry)', 'market' => 'Kampala (Kisenyi)', 'price' => 1250, 'unit' => 'kg', 'change' => '+4.2%', 'up' => true],
            ['commodity' => 'Fresh Farm Milk', 'market' => 'Mbarara Central', 'price' => 1100, 'unit' => 'litre', 'change' => '+2.8%', 'up' => true],
            ['commodity' => 'Table Eggs (Large Tray)', 'market' => 'Wakiso / Kampala', 'price' => 13500, 'unit' => 'tray', 'change' => '-1.5%', 'up' => false],
            ['commodity' => 'Broiler Live (1.8kg)', 'market' => 'Jinja Main', 'price' => 14000, 'unit' => 'bird', 'change' => '+3.1%', 'up' => true],
            ['commodity' => 'Nile Tilapia (Whole)', 'market' => 'Gulu / Lira', 'price' => 9500, 'unit' => 'kg', 'change' => '+5.0%', 'up' => true],
            ['commodity' => 'Boer Goat Live (Mature)', 'market' => 'Kumi Cattle Market', 'price' => 280000, 'unit' => 'head', 'change' => '+1.2%', 'up' => true],
            ['commodity' => 'Robusta Coffee FAQ', 'market' => 'Masaka Hub', 'price' => 8400, 'unit' => 'kg', 'change' => '+6.3%', 'up' => true],
            ['commodity' => 'Yellow Beans (Nambale)', 'market' => 'Mbale Market', 'price' => 3800, 'unit' => 'kg', 'change' => '-0.8%', 'up' => false],
        ];

        return view('home', compact('featuredArticles', 'latestArticles', 'categories', 'news', 'stats', 'marketPrices'));
    }
}