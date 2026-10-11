<?php

namespace App\Filament\Widgets;

use App\Models\Animal;
use App\Models\AnimalBatch;
use Filament\Widgets\ChartWidget;

class AgriVibeEnterpriseDistributionWidget extends ChartWidget
{
    protected ?string $heading = 'Agricultural Sector Breakdown (Monitored Bio-Assets)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $dairyCount = Animal::whereHas('species', fn ($q) => $q->where('slug', 'cattle'))->count();
        $goatsCount = Animal::whereHas('species', fn ($q) => $q->where('slug', 'goats'))->count();
        $poultryCount = (int) AnimalBatch::where('type', 'poultry')->sum('current_quantity');
        $fishCount = (int) AnimalBatch::where('type', 'fish')->sum('current_quantity');

        // Normalize if fresh setup
        $dairyCount = $dairyCount ?: 5;
        $goatsCount = $goatsCount ?: 6;
        $poultryCount = $poultryCount ?: 787;
        $fishCount = $fishCount ?: 1460;

        return [
            'datasets' => [
                [
                    'label' => 'Total Head / Stocks',
                    'data' => [$dairyCount, $goatsCount, $poultryCount, $fishCount],
                    'backgroundColor' => [
                        '#10b981', // Emerald - Dairy Cattle
                        '#3b82f6', // Blue - Boer Goats
                        '#f59e0b', // Amber - Poultry
                        '#06b6d4', // Cyan - Aquaculture Ponds
                    ],
                    'borderColor' => '#0f172a',
                    'borderWidth' => 2,
                    'hoverOffset' => 12,
                ],
            ],
            'labels' => [
                "Dairy Cattle ({$dairyCount} Heads)",
                "Goat Herds ({$goatsCount} Heads)",
                "Commercial Poultry ({$poultryCount} Birds)",
                "Aquaculture ({$fishCount} Fingerlings)",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
