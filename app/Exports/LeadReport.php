<?php

namespace App\Exports;

use App\Models\Lead;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LeadReport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lead::all()->transform(function ($lead) {
            return [
                'id' => $lead->id,
                'date' => $lead->created_at->format('Y-m-d'),
                'Sales Name' => $lead->sales->name ?? 'No Sales',
                'category' => $lead->category->name,
                'sub-category' => $lead->subCategory->name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'person_name' => $lead->name,
                'note' => $lead->note,
            ];
        });
    }

    public function headings(): array {
        return [
            'ID',
            'Date',
            'Sales',
            'Category',
            'Sub Category',
            'Email',
            'Phone',
            'Person Name',
            'Note'
        ];
    }
}
