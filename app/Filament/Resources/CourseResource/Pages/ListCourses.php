<?php

namespace App\Filament\Resources\CourseResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CourseResource;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;
}
