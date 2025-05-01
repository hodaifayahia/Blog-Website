<?php

namespace App\Filament\Resources\CategroyResource\Pages;

use App\Filament\Resources\CategroyResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCategroys extends ManageRecords
{
    protected static string $resource = CategroyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
