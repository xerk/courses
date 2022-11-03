<?php

namespace App\Filament\Resources\CourseResource\Pages;

use Filament\Notifications\Notification;
use App\Filament\Resources\CourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Saved successfully');
    }
}
