<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CategoryResource;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;
}
