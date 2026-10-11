<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function show()
    {
        $stats = [
            ['value' => '9+', 'label' => 'Knowledge categories'],
            ['value' => '10', 'label' => 'Farming enterprises supported'],
            ['value' => '24/7', 'label' => 'Access on any phone'],
        ];

        return view('about.show', compact('stats'));
    }
}