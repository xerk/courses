<?php

namespace App\Filament\Resources\UserAdminResource\Widgets;

use App\Models\UserAdmin;
use App\Models\UserTrainer;
use App\Models\UserEmployee;
use App\Models\UserInstructor;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $admin = new UserAdmin();
        $trainer = new UserTrainer();
        $employee = new UserEmployee();
        $instructor = new UserInstructor();
        return [
            Card::make('Admins', $admin->count()),
            Card::make('Students', $trainer->count()),
            Card::make('Employee', $employee->count()),
            Card::make('Instructor', $instructor->count()),
        ];
    }
}
