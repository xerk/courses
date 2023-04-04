<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\EmployeeResource;
use Filament\Pages\Actions\CreateAction;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    // getActions
    protected function getActions(): array
    {
        return [
            Action::make('export_students')->label('Export Students')->color('success')->icon('heroicon-o-document-download')
                ->url(route('export.students')),
            CreateAction::make(),
        ];
    }
}
