<?php

namespace App\Filament\Resources\UserTrainerResource\Pages;

use App\Filament\Resources\UserTrainerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserTrainers extends ListRecords
{
    protected static string $resource = UserTrainerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
