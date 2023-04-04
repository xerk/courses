<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CompanyResource;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export_companies')->label('Export companies')->color('success')->icon('heroicon-o-document-download')
            ->url(route('export.companies')),
        ];
    }
}
