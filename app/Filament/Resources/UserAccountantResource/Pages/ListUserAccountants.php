<?php

namespace App\Filament\Resources\UserAccountantResource\Pages;

use Closure;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UserAccountantResource;

class ListUserAccountants extends ListRecords
{
    protected static string $resource = UserAccountantResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
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
