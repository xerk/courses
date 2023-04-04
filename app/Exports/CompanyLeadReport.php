<?php

namespace App\Exports;

use App\Models\CompanyLead;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompanyLeadReport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CompanyLead::all()->transform(function ($lead) {
            return [
                'id' => $lead->id,
                'date' => $lead->created_at->format('Y-m-d'),
                'company_name' => $lead->name,
                'company_name_ar' => $lead->name_ar,
                'email' => $lead->email,
                'business_email' => $lead->business_email,
                'business_landline' => $lead->business_landline,
                'phone' => $lead->phone,
                'sales_name' => $lead->sales->name ?? 'No Sales',
                'category' => $lead->category->name,
                'sub_category' => $lead->subCategory->name,
                'note' => $lead->note,
            ];
        });
    }

    public function headings(): array {
        return [
            'ID',
            'Date',
            'Company Name',
            'Company Name AR',
            'Email',
            'Business Email',
            'Business Landline',
            'Phone',
            'Sales',
            'Category',
            'Sub Category',
            'Note'
        ];
    }
}
