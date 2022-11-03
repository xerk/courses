<?php

namespace App\Filament\Resources\UserEmployeeResource\Pages;

use App\Filament\Resources\UserEmployeeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserEmployees extends ListRecords
{
    protected static string $resource = UserEmployeeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
