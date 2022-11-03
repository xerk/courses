<?php

namespace App\Filament\Resources\UserEmployeeResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserEmployeeResource;

class CreateUserEmployee extends CreateRecord
{
    protected static string $resource = UserEmployeeResource::class;
}
