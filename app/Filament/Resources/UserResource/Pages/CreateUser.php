<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CreateUser extends CreateRecord 
{
    protected static string $resource = UserResource::class;
    // get redirect url after create
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    // mutate the record
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = bcrypt($data['password']);
        $data['email_verified_at'] = Carbon::now();
        

        return $data;
    }
    // handel recored creartion
    protected function handleRecordCreation(array $data): Model
    {
        /** @var \App\Models\User $user */
        $user = parent::handleRecordCreation($data);
        // Assign the role to the user
        $user->assignRole('admin');
        return $user;
    }
}
