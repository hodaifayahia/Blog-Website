<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategroyResource\Pages;
use App\Filament\Resources\CategroyResource\RelationManagers;
use App\Models\Categroy;
use Closure;
use Filament\Forms;
use Illuminate\Support\Str;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategroyResource extends Resource
{
    protected static ?string $model = Categroy::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'content';



  public static function form(Form $form): Form
{

    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255)
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set) {
                $set('slug', \Illuminate\Support\Str::slug($state));
            }),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategroys::route('/'),
        ];
    }
}
