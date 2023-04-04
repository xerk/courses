<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Quotation;
use Filament\Resources\Pages\Page;

class PrintQuotation extends Page
{
    protected static string $resource = QuotationResource::class;

    protected static string $view = 'filament.resources.quotation-resource.pages.print-quotation';

    public $record;

    public function mount()
    {
        $this->record = Quotation::find(request()->record);
    }
}
