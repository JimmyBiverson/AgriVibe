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
use App\Models\VaccinationSchedule;
use App\Models\VetAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user()->load(['profile', 'farms']);

        $role = $request->query('role', $user->account_type ?: 'farmer');

        $farms = $user->ownedFarms()->get()
            ->merge($user->farms()->get())
            ->unique('id')
            ->values();

        $farm = $farms->firstWhere('id', (int) $request->query('farm'))
            ?? $user->ownedFarms()->first()
            ?? $user->farms()->first()
            ?? Farm::where('slug', 'nakato-family-farm')->first();

        $animals = $farm ? Animal::where('farm_id', $farm->id)->with(['species', 'breed'])->get() : collect();
        $batches = $farm ? AnimalBatch::where('farm_id', $farm->id)->with(['species', 'breed'])->get() : collect();
        $productionRecords = $farm ? ProductionRecord::where('farm_id', $farm->id)->latest('record_date')->limit(10)->get() : collect();
        $withdrawalAlert = $farm ? HealthEvent::where('farm_id', $farm->id)
            ->where('safe_consumption_date', '>', now())
            ->with('animal')
            ->first() : null;
        $allTasks = $farm ? FarmTask::where('farm_id', $farm->id)->orderBy('due_date')->get() : collect();
        $tasks = $allTasks->where('status', 'pending')->values();

        $totalIncome = $farm ? FarmFinance::where('farm_id', $farm->id)->where('type', 'income')->sum('amount') : 0;
        $totalExpense = $farm ? FarmFinance::where('farm_id', $farm->id)->where('type', 'expense')->sum('amount') : 0;
        $netProfit = $totalIncome - $totalExpense;

        $recentFinances = $farm ? FarmFinance::where('farm_id', $farm->id)->latest('transaction_date')->limit(5)->get() : collect();

        $alerts = $this->buildAlerts($farm, $allTasks, $withdrawalAlert);

        $recentActivity = $this->buildRecentActivity($farm, $recentFinances, $productionRecords);

        $upcomingVaccinations = $farm
            ? VaccinationSchedule::query()
                ->whereIn('species_id', $animals->pluck('species_id')->filter()->unique())
                ->where('is_active', true)
                ->orderBy('age_days_from')
                ->limit(5)
                ->get()
            : collect();

        $vetAppointments = VetAppointment::with(['farmer', 'animal', 'farm'])->latest('scheduled_at')->limit(8)->get();

        $marketplaceItems = MarketplaceItem::with('seller')->where('status', 'active')->latest()->limit(8)->get();

        $enterpriseTypes = EnterpriseType::query()->orderBy('name')->limit(6)->get();

        return view('dashboard', compact(
            'user',
            'role',
            'farms',
            'farm',
            'alerts',
            'recentActivity',
            'upcomingVaccinations',
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

    /**
     * @return Collection<int, array{level: string, icon: string, title: string, description: string, href: ?string}>
     */
    private function buildAlerts(?Farm $farm, Collection $tasks, ?HealthEvent $withdrawalAlert): Collection
    {
        $alerts = collect();

        if ($withdrawalAlert) {
            $alerts->push([
                'level' => 'danger',
                'icon' => 'exclamation-triangle',
                'title' => 'Active withdrawal period',
                'description' => ($withdrawalAlert->animal?->name ?? 'Tagged animal')
                    .' — do not sell milk or meat until '
                    .$withdrawalAlert->safe_consumption_date?->format('d M Y').'.',
                'href' => null,
            ]);
        }

        $overdue = $tasks->filter(fn (FarmTask $task) => $task->due_date && $task->due_date->isPast());
        if ($overdue->isNotEmpty()) {
            $alerts->push([
                'level' => 'warning',
                'icon' => 'clock',
                'title' => $overdue->count().' overdue task(s)',
                'description' => 'Oldest: '.$overdue->first()->title.' (due '.$overdue->first()->due_date->diffForHumans().').',
                'href' => route('dashboard', ['tab' => 'tasks']),
            ]);
        }

        $dueSoon = $tasks->filter(fn (FarmTask $task) => $task->due_date && $task->due_date->isToday());
        if ($dueSoon->isNotEmpty()) {
            $alerts->push([
                'level' => 'info',
                'icon' => 'bell',
                'title' => $dueSoon->count().' task(s) due today',
                'description' => $dueSoon->pluck('title')->take(2)->implode(', ').'.',
                'href' => route('dashboard', ['tab' => 'tasks']),
            ]);
        }

        return $alerts;
    }

    /**
     * @return Collection<int, array{icon: string, title: string, description: string, time: string}>
     */
    private function buildRecentActivity(?Farm $farm, Collection $recentFinances, Collection $productionRecords): Collection
    {
        $activity = collect();

        foreach ($recentFinances as $finance) {
            $activity->push([
                'icon' => $finance->type === 'income' ? 'banknotes' : 'cash',
                'title' => ucfirst($finance->type).': '.$finance->category,
                'description' => agri_setting('default_currency', 'UGX').' '.number_format((float) $finance->amount),
                'time' => $finance->transaction_date?->diffForHumans(),
                'sort' => $finance->transaction_date,
            ]);
        }

        foreach ($productionRecords as $record) {
            $activity->push([
                'icon' => 'beaker',
                'title' => ucfirst($record->product_type).' recorded',
                'description' => number_format((float) $record->quantity, 1).' '.$record->unit,
                'time' => $record->record_date?->diffForHumans(),
                'sort' => $record->record_date,
            ]);
        }

        if ($farm) {
            foreach (HealthEvent::where('farm_id', $farm->id)->with('animal')->latest('administered_date')->limit(3)->get() as $event) {
                $activity->push([
                    'icon' => 'heart-pulse',
                    'title' => $event->title ?: ucfirst(str_replace('_', ' ', $event->event_type ?? 'Health event')),
                    'description' => $event->animal?->name ?? $event->clinical_notes ?? 'Farm health record',
                    'time' => $event->administered_date?->diffForHumans(),
                    'sort' => $event->administered_date,
                ]);
            }
        }

        return $activity
            ->sortByDesc(fn (array $item) => $item['sort'])
            ->take(6)
            ->values()
            ->map(fn (array $item) => [
                'icon' => $item['icon'],
                'title' => $item['title'],
                'description' => $item['description'],
                'time' => $item['time'],
            ]);
    }
}
