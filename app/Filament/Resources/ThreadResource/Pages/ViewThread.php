<?php

namespace App\Filament\Resources\ThreadResource\Pages;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ThreadResource;

class ViewThread extends ViewRecord
{
    protected static string $resource = ThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
