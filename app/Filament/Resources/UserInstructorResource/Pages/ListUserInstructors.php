<?php

namespace App\Filament\Resources\UserInstructorResource\Pages;

use App\Filament\Resources\UserInstructorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserInstructors extends ListRecords
{
    protected static string $resource = UserInstructorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
