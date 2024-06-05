<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Thread;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ThreadResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ThreadResource\RelationManagers;
use App\Filament\Resources\ThreadResource\RelationManagers\ParentsRelationManager;

class ThreadResource extends Resource
{
    protected static ?string $model = Thread::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationLabel = 'Thread';

    protected static ?string $modelLabel = 'Thread';

    protected static ?string $navigationGroup = 'Forum';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thread Information')
                    ->schema([
                        Forms\Components\Hidden::make('last_activity')
                            ->default(now()),
                        Forms\Components\Select::make('user_id')
                            ->required()
                            ->label('Author')
                            ->options([
                                Auth::id() => Auth::user()->getFilamentName()
                            ])
                            ->default(Auth::id()),
                        Forms\Components\Select::make('category_id')
                            ->relationship(name: 'category', titleAttribute: 'name')
                            ->required()
                            ->label('Categories')
                            ->preload()
                            ->searchable()
                            ->native(condition: false),
                        Forms\Components\Select::make('parent_id')
                            ->nullable()
                            ->label('Parent Thread')
                            ->preload()
                            ->searchable()
                            ->native(condition: false)
                            ->options(
                                self::$model::query()
                                    ->where('parent_id', null)
                                    ->where('other_thread_replies', null)
                                    ->get()
                                    ->pluck('title', 'id')
                                    ->toArray()
                            ),
                        Forms\Components\Select::make('other_thread_replies')
                            ->nullable()
                            ->label('Replied Thread')
                            ->preload()
                            ->searchable()
                            ->native(condition: false)
                            ->options(
                                self::$model::query()
                                    ->where('parent_id', '!=', null)
                                    ->get()
                                    ->map(function ($item) {
                                        return [
                                            'id' => $item->id,
                                            'description' => Str::limit(strip_tags($item->description), 30)
                                        ];
                                    })
                                    ->pluck('description', 'id')
                                    ->toArray()

                            ),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Thread Content Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->requiredWithout('parent_id,other_thread_replies')
                            ->label('Thread Title')
                            ->placeholder('Thread Title')
                            ->helperText('nullable when parent thread and replied thread are not filled')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->requiredWithout('parent_id,other_thread_replies')
                            ->label('Thread Slug')
                            ->placeholder('Thread Slug')
                            ->helperText('nullable when parent thread and replied thread are not filled'),
                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->label('Thread Description')
                            ->placeholder('Thread Description')
                            ->columnSpanFull(),
                        Forms\Components\Radio::make('visibility')
                            ->required()
                            ->label('Visibility')
                            ->options(['all' => 'All', 'friends' => 'Friends'])
                            ->default('all')
                            ->inline()
                            ->inlineLabel(condition: false),
                        Forms\Components\Toggle::make('is_remove_by_admin')
                            ->required()
                            ->label('Is Ban ?')
                            ->default(false)
                            ->visibleOn('edit')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->where('parent_id', null)
                    ->where('other_thread_replies', null);
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('visibility')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'all' => 'success',
                        'friends' => 'warning'
                    }),
                Tables\Columns\IconColumn::make('is_remove_by_admin')
                    ->label('Is Banned ?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('upvote')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('downvote')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('replies')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_activity')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
            ParentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThreads::route('/'),
            'create' => Pages\CreateThread::route('/create'),
            'view' => Pages\ViewThread::route('/{record}'),
            'edit' => Pages\EditThread::route('/{record}/edit'),
        ];
    }
}
