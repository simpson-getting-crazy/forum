<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UsetGrowthChart extends ChartWidget
{
    protected static ?string $heading = 'User Growth Statistic';

    protected static string $color = 'primary';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';

    public function getDescription(): ?string
    {
        return 'The users growth statistic per month.';
    }

    protected function getData(): array
    {
        $data = Trend::query(User::query()->where('is_admin', false))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->count();

        $formatDate = function ($date) {
            return \Carbon\Carbon::parse($date)->format('M, Y');
        };

        return [
            'datasets' => [
                [
                    'label' => 'Users Growth',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $formatDate($value->date)),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
