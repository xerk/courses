<?php

namespace App\Filament\Resources\LeadResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\LeadResource;
use Filament\Resources\Pages\ListRecords;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export_leads')->label('Export Leads')->color('success')->icon('heroicon-o-document-download')
            ->url(route('export.leads')),
        ];
    }
}
