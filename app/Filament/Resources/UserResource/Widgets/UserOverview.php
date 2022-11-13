<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $trainer = User::where('type', 'trainer');
        $employee = User::where('type', 'employee');
        return [
            Card::make('Admins', User::where('type', 'admin')->count()),
            Card::make('Students', $trainer->count()),
            Card::make('Employee', $employee->count()),
        ];
    }
}
