<?php

namespace App\Filament\Resources\UserAccountantResource\Pages;

use App\Filament\Resources\UserAccountantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserAccountant extends EditRecord
{
    protected static string $resource = UserAccountantResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
