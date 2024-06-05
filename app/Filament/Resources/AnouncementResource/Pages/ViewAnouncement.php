<?php

namespace App\Filament\Resources\AnouncementResource\Pages;

use App\Filament\Resources\AnouncementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAnouncement extends ViewRecord
{
    protected static string $resource = AnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
