<?php

namespace App\Filament\Resources\AutherResource\Pages;

use App\Filament\Resources\AutherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuthers extends ListRecords
{
    protected static string $resource = AutherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
