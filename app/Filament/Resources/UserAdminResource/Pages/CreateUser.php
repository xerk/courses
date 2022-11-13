<?php

namespace App\Filament\Resources\UserAdminResource\Pages;

use App\Filament\Resources\UserAdminResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserAdminResource::class;
}
