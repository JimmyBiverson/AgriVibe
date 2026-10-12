<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class KnowledgeController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->where('type', 'article')
            ->where('is_active', true)
            ->withCount('articles')
            ->orderBy('sort')
            ->get();

        $featured = Article::query()->published()->where('is_featured', true)
            ->with('category')->latest('published_at')->limit(3)->get();

        $latest = Article::query()->published()
            ->with('category')->latest('published_at')->limit(9)->get();

        $trending = Article::query()->published()
            ->with('category')
            ->orderByDesc('views')->limit(4)->get();

        return view('knowledge.index', compact('categories', 'featured', 'latest', 'trending'));
    }

    public function category(Category $category)
    {
        abort_unless($category->is_active && $category->type === 'article', 404);

        $articles = $category->articles()->published()
            ->with('category')->latest('published_at')->paginate(12);

        $relatedCategories = Category::query()
            ->where('type', 'article')
            ->where('id', '!=', $category->id)
            ->where('is_active', true)
            ->orderBy('sort')
            ->limit(5)
            ->get();

        return view('knowledge.category', compact('category', 'articles', 'relatedCategories'));
    }

    public function article(Category $category, Article $article)
    {
        abort_unless(
            $category->is_active
                && $category->type === 'article'
                && $article->category_id === $category->id
                && $article->status === 'published',
            404
        );

        $article->increment('views');

        $related = Article::query()->published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with('category')
            ->latest('published_at')
            ->limit(3)
            ->get();

        $news = Article::query()->published()->where('content_type', 'news')
            ->latest('published_at')->limit(3)->get();

        return view('knowledge.article', compact('article', 'related', 'news'));
    }
}
