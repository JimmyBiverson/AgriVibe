<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalBatch;
use App\Models\EnterpriseType;
use App\Models\Farm;
use App\Models\FarmFinance;
use App\Models\FarmTask;
use App\Models\HealthEvent;
use App\Models\MarketplaceItem;
use App\Models\ProductionRecord;
use App\Models\VetAppointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user()->load(['profile', 'farms']);

        $role = $request->query('role', $user->account_type ?: 'farmer');

        // Target farm for farmer view
        $farm = $user->ownedFarms()->first()
            ?? $user->farms()->first()
            ?? Farm::where('slug', 'nakato-family-farm')->first();

        // 1. Farmer operational metrics
        $animals = $farm ? Animal::where('farm_id', $farm->id)->with(['species', 'breed'])->get() : collect();
        $batches = $farm ? AnimalBatch::where('farm_id', $farm->id)->with(['species', 'breed'])->get() : collect();
        $productionRecords = $farm ? ProductionRecord::where('farm_id', $farm->id)->latest('record_date')->limit(10)->get() : collect();
        $withdrawalAlert = $farm ? HealthEvent::where('farm_id', $farm->id)
            ->where('safe_consumption_date', '>', now())
            ->with('animal')
            ->first() : null;
        $tasks = $farm ? FarmTask::where('farm_id', $farm->id)->where('status', 'pending')->orderBy('due_date')->get() : collect();

        $totalIncome = $farm ? FarmFinance::where('farm_id', $farm->id)->where('type', 'income')->sum('amount') : 0;
        $totalExpense = $farm ? FarmFinance::where('farm_id', $farm->id)->where('type', 'expense')->sum('amount') : 0;
        $netProfit = $totalIncome - $totalExpense;

        $recentFinances = $farm ? FarmFinance::where('farm_id', $farm->id)->latest('transaction_date')->limit(5)->get() : collect();

        // 2. Veterinarian operational metrics
        $vetAppointments = VetAppointment::with(['farmer', 'animal', 'farm'])->latest('scheduled_at')->limit(8)->get();

        // 3. Buyer & Supplier marketplace listings
        $marketplaceItems = MarketplaceItem::with('seller')->where('status', 'active')->latest()->limit(8)->get();

        // 4. Quick enterprise types
        $enterpriseTypes = EnterpriseType::query()->orderBy('name')->limit(6)->get();

        return view('dashboard', compact(
            'user',
            'role',
            'farm',
            'animals',
            'batches',
            'productionRecords',
            'withdrawalAlert',
            'tasks',
            'totalIncome',
            'totalExpense',
            'netProfit',
            'recentFinances',
            'vetAppointments',
            'marketplaceItems',
            'enterpriseTypes'
        ));
    }
}