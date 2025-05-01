<?php

namespace App\Filament\Resources\AutherResource\Pages;

use App\Filament\Resources\AutherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuther extends EditRecord
{
    protected static string $resource = AutherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
