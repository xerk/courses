<?php

namespace App\Filament\Resources\UserEmployeeResource\Pages;

use App\Filament\Resources\UserEmployeeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserEmployee extends EditRecord
{
    protected static string $resource = UserEmployeeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
