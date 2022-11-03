<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DocumentResource;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;
}
