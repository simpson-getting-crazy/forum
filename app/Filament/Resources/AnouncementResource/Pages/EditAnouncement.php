<?php

namespace App\Filament\Resources\AnouncementResource\Pages;

use App\Filament\Resources\AnouncementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnouncement extends EditRecord
{
    protected static string $resource = AnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
