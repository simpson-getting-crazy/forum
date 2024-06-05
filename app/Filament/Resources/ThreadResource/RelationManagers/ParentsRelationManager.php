<?php

namespace App\Filament\Resources\ThreadResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Thread;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CommentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ParentsRelationManager extends RelationManager
{
    protected static string $relationship = 'parents';

    protected static ?string $title = 'Replies Thread';

    public function form(Form $form): Form
    {
        $ownerRecord = $this->getOwnerRecord();
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
                            ->required()
                            ->label('Categories')
                            ->options([
                                $ownerRecord->category_id => $ownerRecord->category->name
                            ])
                            ->default($ownerRecord->category_id),
                        Forms\Components\Select::make('parent_id')
                            ->required()
                            ->label('Parent Thread')
                            ->options([
                                $ownerRecord->id => $ownerRecord->title
                            ])
                            ->default($ownerRecord->id)
                            ->columnSpanFull()
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Thread Content Information')
                    ->schema([
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
                            ->visibleOn('edit'),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
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
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('Manage Comments')
                    ->color('success')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->url(function (Thread $thread) {
                        return route('filament.admin.resources.comments.reply.index', ['replyId' => $thread->id]);
                    }),
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
}
