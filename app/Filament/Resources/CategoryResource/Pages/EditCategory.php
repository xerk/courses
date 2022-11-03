<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CategoryResource;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;


    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Saved successfully');
    }
}
