<?php

namespace App\Filament\Resources\CompanyLeadResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CompanyLeadResource;

class ListCompanyLeads extends ListRecords
{
    protected static string $resource = CompanyLeadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export_company-leads')->label('Export Company Leads')->color('success')->icon('heroicon-o-document-download')
            ->url(route('export.company-leads')),
        ];
    }
}
