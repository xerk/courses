<?php

namespace App\Filament\Resources\UserSallerResource\Pages;

use App\Filament\Resources\UserSallerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserSaller extends EditRecord
{
    protected static string $resource = UserSallerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
