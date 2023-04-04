<?php

namespace App\Filament\Resources\CourseGroupResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CourseGroupResource;
use Filament\Pages\Actions\CreateAction;

class ListCourseGroups extends ListRecords
{
    protected static string $resource = CourseGroupResource::class;

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
