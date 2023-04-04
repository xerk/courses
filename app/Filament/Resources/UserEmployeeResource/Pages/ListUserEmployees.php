<?php

namespace App\Filament\Resources\UserEmployeeResource\Pages;

use Closure;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UserEmployeeResource;

class ListUserEmployees extends ListRecords
{
    protected static string $resource = UserEmployeeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export_employees')->label('Export Employees')->color('success')->icon('heroicon-o-document-download')
            ->url(route('export.employees')),
        ];
    }


    protected function getTableRecordClassesUsing(): ?Closure
    {
        return function (Model $record) {
            $passport = $record->employee->passport_expire_date;
            $national = $record->employee->national_expire_date;
            $health = $record->employee->health_expire_date;
            $passportWarning = Carbon::parse($passport)->subMonths(3);
            $nationalWarning = Carbon::parse($national)->subMonths(3);
            $healthWarning = Carbon::parse($health)->subMonths(3);
            if ((isset($passport) && $passport->isPast())
                || (isset($national) && $national->isPast())
                || (isset($health) && $health->isPast()))
            {
                return 'bg-danger-500/10 text-danger-500 dark:text-danger-500';
            } else if ((isset($passport) && $passportWarning->isPast()) || (isset($national) && $nationalWarning->isPast()) || (isset($health) && $healthWarning->isPast())) {
                return 'bg-warning-500/10 text-warning-500 dark:text-warning-500';
            }
        };
    }
}
