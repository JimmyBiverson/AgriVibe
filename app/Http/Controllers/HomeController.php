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

        return view('home', compact('featuredArticles', 'latestArticles', 'categories', 'news', 'stats'));
    }
}