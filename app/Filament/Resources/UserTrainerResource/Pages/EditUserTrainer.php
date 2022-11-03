<?php

namespace App\Filament\Resources\UserTrainerResource\Pages;

use App\Filament\Resources\UserTrainerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserTrainer extends EditRecord
{
    protected static string $resource = UserTrainerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
