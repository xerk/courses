<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CompanyResource;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;
}
