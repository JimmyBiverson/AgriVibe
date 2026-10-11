<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Disease;
use App\Models\Faq;
use App\Models\SearchQuery;
use App\Models\Species;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->string('q'));
        $type = $request->string('type')->toString();
        $categorySlug = $request->string('category')->toString();

        $allowedTypes = ['articles', 'species', 'diseases', 'faqs'];

        $results = collect();
        $total = 0;
        $categories = Category::query()->where('type', 'article')->where('is_active', true)->orderBy('sort')->get();

        if ($q !== '') {
            if ($q !== session('_last_search')) {
                $searchQuery = SearchQuery::query()->firstOrCreate(
                    ['user_id' => auth()->id(), 'query' => $q],
                    ['ip' => $request->ip()]
                );
                $searchQuery->increment('query_count');
                session(['_last_search' => $q]);
            }

            $category = $categorySlug ? Category::query()->where('slug', $categorySlug)->first() : null;

            $entities = [];

            if ($type === '' || $type === 'articles') {
                $entities['articles'] = Article::query()->published()
                    ->when($category, fn ($query) => $query->where('category_id', $category->id))
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                            ->orWhere('excerpt', 'like', "%{$q}%")
                            ->orWhere('body', 'like', "%{$q}%");
                    })
                    ->with('category')->latest('published_at')->limit(20)->get();
            }

            if ($type === '' || $type === 'species') {
                $entities['species'] = Species::query()
                    ->when($category, function ($query) use ($category) {
                        $query->where(function ($q2) use ($category) {
                            $q2->where('category', 'like', "%{$category->name}%")
                                ->orWhere('category', 'like', "%{$category->slug}%");
                        });
                    })
                    ->where(function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%")
                            ->orWhere('scientific_name', 'like', "%{$q}%")
                            ->orWhere('category', 'like', "%{$q}%");
                    })
                    ->limit(10)->get();
            }

            if ($type === '' || $type === 'diseases') {
                $entities['diseases'] = Disease::query()
                    ->where(function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%")
                            ->orWhere('symptoms', 'like', "%{$q}%")
                            ->orWhere('treatment', 'like', "%{$q}%")
                            ->orWhere('prevention', 'like', "%{$q}%");
                    })
                    ->limit(10)->get();
            }

            if ($type === '' || $type === 'faqs') {
                $entities['faqs'] = Faq::query()->where('is_active', true)
                    ->where(function ($query) use ($q) {
                        $query->where('question', 'like', "%{$q}%")
                            ->orWhere('answer', 'like', "%{$q}%");
                    })
                    ->limit(10)->get();
            }

            $results = collect($entities);
            $total = $results->sum->count();

            if ($type !== '' && ! in_array($type, $allowedTypes, true)) {
                $type = '';
            }
        }

        return view('search.index', compact('q', 'type', 'categorySlug', 'results', 'total', 'categories', 'allowedTypes'));
    }

    public function suggest(Request $request)
    {
        $q = trim((string) $request->string('q'));

        if ($q === '' || mb_strlen($q) < 2) {
            return response()->json([]);
        }

        $articles = Article::query()->published()
            ->with('category')
            ->where('title', 'like', "%{$q}%")
            ->limit(5)->get(['id', 'title', 'slug', 'category_id']);

        $species = Species::query()
            ->where('name', 'like', "%{$q}%")
            ->limit(3)->get(['id', 'name', 'slug']);

        $suggestions = $articles->map(fn ($a) => [
            'type' => 'article',
            'label' => $a->title,
            'url' => route('knowledge.category', ['category' => $a->category?->slug ?? 'livestock']).'/'.$a->slug,
        ])->merge($species->map(fn ($s) => [
            'type' => 'species',
            'label' => $s->name,
            'url' => '#', // species pages ship with the farm tools phase
        ]))->values();

        return response()->json($suggestions);
    }
}