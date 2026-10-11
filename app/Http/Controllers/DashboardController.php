<?php

namespace App\Http\Controllers;

use App\Models\EnterpriseType;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        $farmCount = $user->farmMemberships()->count();
        $farms = $user->farms()->with('enterpriseType')->get();
        $ownedFarms = $user->ownedFarms()->count();
        $enterpriseTypes = EnterpriseType::query()->orderBy('name')->limit(6)->get();

        return view('dashboard', compact('user', 'farmCount', 'farms', 'ownedFarms', 'enterpriseTypes'));
    }
}