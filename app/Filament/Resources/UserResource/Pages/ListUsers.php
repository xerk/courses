<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UserResource\Widgets\LatestCourses;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
