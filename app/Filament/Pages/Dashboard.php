<?php
 
namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;
use App\Filament\Resources\UserResource\Widgets\UserOverview;
use App\Filament\Resources\CompanyLeadResource\Widgets\ExpiredContract;
 
class Dashboard extends BasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            UserOverview::class,
            ExpiredContract::class
        ];
    }

    protected function getWidgets(): array {
        return [];
    }
}