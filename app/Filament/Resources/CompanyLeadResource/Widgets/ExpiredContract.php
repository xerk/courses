<?php

namespace App\Filament\Resources\CompanyLeadResource\Widgets;

use Carbon\Carbon;
use App\Models\CompanyLead;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ExpiredContract extends BaseWidget
{
    protected function getCards(): array
    {
        $companyLeads = CompanyLead::all();
        $expiredContracts = 0;
        $saveContracts = 0;
        $periodContracts = 0;
        foreach ($companyLeads as $lead) {
            if ($lead->end_date < Carbon::now()->format('Y-m-d')) {
                $expiredContracts++;
            }
            if ($lead->end_date > Carbon::now()->addMonth(3)->format('Y-m-d')) {
                $saveContracts++;
            } else if ($lead->end_date > Carbon::now()->format('Y-m-d')) {
                $periodContracts++;
            }
        }
        return [
            Card::make('Success Contracts', $saveContracts)->color('success'),
            Card::make('Period Contracts', $periodContracts)->color('warning'),
            Card::make('Expired Contracts', $expiredContracts)->color('danger'),
        ];
    }
}
