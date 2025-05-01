<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()  // Wrap the form inside a Card
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                }),
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->maxLength(2048),
                        ]),
                        Forms\Components\RichEditor::make('body')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('meata_title')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('meta_description')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('active')
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at'),
                    ])
                    ->columnSpan(8), // Corrected typo 'cloumnSpan' to 'columnSpan'
                    
                Card::make()  // Wrap the form inside a Card
                    ->schema([
                        FileUpload::make('thumbnail'),
                        Forms\Components\Select::make('categories')  // Assuming you have a relationship for categories
                            ->required()
                            ->multiple()
                            ->relationship('categories', 'name') // The 'categories' relation in your Post model
                    ])
                    ->columnSpan(4), // Corrected method to use columnSpan properly
            ])
            ->columns(12);  // This sets the form layout to have 12 columns (standard grid layout)
    }
    
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(['title','body'])
                    ->sortable()
                    ,
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                    Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('published_at')
                        ->dateTime()
                        ->sortable(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
