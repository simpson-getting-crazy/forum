<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnouncementResource\Pages;
use App\Filament\Resources\AnouncementResource\RelationManagers;
use App\Models\Anouncement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnouncementResource extends Resource
{
    protected static ?string $model = Anouncement::class;

    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';

    protected static ?string $navigationLabel = 'Anouncement';

    protected static ?string $modelLabel = 'Anouncement';

    protected static ?string $navigationGroup = 'Forum';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Anouncement Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Anouncement Title')
                            ->placeholder('Anouncement Title'),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->rows(5)
                            ->label('Anouncement Description')
                            ->placeholder('Anouncement Description'),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->label('Is Active ?')
                            ->afterStateUpdated(function (Get $get) {
                                if ($get('is_active') == true) {
                                    Anouncement::query()
                                        ->where('is_active', true)
                                        ->update(['is_active' => false]);
                                }
                            }),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Anouncement Title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Is Active ?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnouncements::route('/'),
            'create' => Pages\CreateAnouncement::route('/create'),
            'view' => Pages\ViewAnouncement::route('/{record}'),
            'edit' => Pages\EditAnouncement::route('/{record}/edit'),
        ];
    }
}
