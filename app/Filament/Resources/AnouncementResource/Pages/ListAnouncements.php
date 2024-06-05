<?php

namespace App\Filament\Resources\AnouncementResource\Pages;

use App\Filament\Resources\AnouncementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnouncements extends ListRecords
{
    protected static string $resource = AnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
