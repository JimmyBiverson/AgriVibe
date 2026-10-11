<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::query()->with('category')->where('is_active', true)->orderBy('sort')->get()->groupBy(fn ($faq) => $faq->category?->name ?? 'General');

        return view('about.faq', compact('faqs'));
    }
}