<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Filament\Resources\ThreadResource\RelationManagers\ParentsRelationManager;
use App\Models\Thread;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    protected static ?string $model = Thread::class;

    protected static ?string $modelLabel = 'Reply Comments';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Forum';

    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool
    {
       return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (!is_null(request('replyId'))) {
                    return $query->where('other_thread_replies', request('replyId'));
                }

                return $query
                    ->where('parent_id', null)
                    ->where('other_thread_replies', '!=', null);
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Reply Content')
                    ->searchable()
                    ->html(),
                Tables\Columns\TextColumn::make('upvote')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('downvote')
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
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            // 'create' => Pages\CreateComment::route('/create'),
            // 'view' => Pages\ViewComment::route('/{record}'),
            // 'edit' => Pages\EditComment::route('/{record}/edit'),
            'reply.index' => Pages\ListComments::route('/{replyId}/list'),
        ];
    }
}
