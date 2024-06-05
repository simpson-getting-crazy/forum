<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Thread;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Colors\Color;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Registered User', User::query()->where('is_admin', false)->count())
                ->icon('heroicon-o-user-plus'),
            Stat::make('Categories', Category::count())
                ->icon('heroicon-o-square-3-stack-3d'),
            Stat::make('Thread', Thread::query()->where('parent_id', null)->where('other_thread_replies', null)->count())
                ->icon('heroicon-o-chat-bubble-bottom-center-text'),
        ];
    }
}
