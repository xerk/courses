<?php

namespace App\Filament\Resources\CourseGroupResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CourseGroupResource;

class ListCourseGroups extends ListRecords
{
    protected static string $resource = CourseGroupResource::class;
}
