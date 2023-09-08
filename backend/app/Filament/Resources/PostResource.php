<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\PostResource\Widgets\PostStatsOverview;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Closure;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Post Management';

    protected static ?int $navigationSort = 3;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Card::make()
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')->reactive(),
                        // Select::make('tag_id')
                        //     ->label('Tags')
                        //     ->multiple()
                        //     ->options(function (callable $get) {
                        //         $category = Category::find($get('category_id'));
                        //         if (!$category) {
                        //             return Tag::all()->pluck('name', 'id');
                        //         }
                        //         return $category->tags->pluck('name', 'id');
                        //     }),
                        TextInput::make('title')
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                if (!$get('is_slug_changed_manually') && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->reactive()
                            ->required(),
                        TextInput::make('slug')
                            ->afterStateUpdated(function (Closure $set) {
                                $set('is_slug_changed_manually', true);
                            })
                            ->required(),
                        FileUpload::make('banner')
                            ->label('Post banner'),
                        RichEditor::make('description'),
                        Radio::make('new_post')
                            ->options([
                                '1' => 'New post',
                                '0' => 'None',
                            ]),
                        Radio::make('highlight')
                            ->options([
                                '1' => 'Hightlight',
                                '0' => 'None',
                            ]),
                        Select::make('status')
                            ->options([
                                '0' => 'Pending',
                                '1' => 'Accepted',
                                '2' => 'Declined',
                            ]),
                        TextInput::make('view_count')
                            ->default(0),
                        Select::make('blogger_id')
                            ->relationship('blogger', 'name'),
                        Forms\Components\Section::make('')
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn (Post $record): ?string => $record->created_at?->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn (Post $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->hidden(fn (?Post $record) => $record === null),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id')
                    ->label('Post ID')
                    ->sortable(),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getLimit()) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('blogger.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->enum([
                        0 => 'Pending',
                        1 => 'Accepted',
                        2 => 'Declined',
                    ])
                    ->sortable(),
                TextColumn::make('slug')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getLimit()) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('view_count'),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at'),
            ])
            ->filters([
                //
                Filter::make('view_count')
                    ->label('View greater than 30')
                    ->query(fn (Builder $query): Builder => $query->where('view_count', '>', 30)),
                Filter::make('highlight')
                    ->query(fn (Builder $query): Builder => $query->where('highlight', 1)),
                SelectFilter::make('status')
                    ->options([
                        0 => 'pending',
                        1 => 'accepted',
                        2 => 'declined',
                    ]),
                SelectFilter::make('All bloggers')
                    ->relationship('blogger', 'name'),
                SelectFilter::make('All categories')
                    ->relationship('category', 'name'),
                SelectFilter::make('All tags')
                    ->multiple()
                    ->relationship('tags', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            CommentsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PostStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->where('status', 0);
    // }
}
