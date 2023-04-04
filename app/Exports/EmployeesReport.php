<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesReport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::whereHas('user')->get()->transform(function ($employee) {
            return [
                'id' => $employee->id,
                'date' => $employee->created_at->format('Y-m-d'),
                'employee_name' => $employee->user->name,
                'tel_mobile' => $employee->user->phone,
                'email' => $employee->user->email,
                'address' => $employee->user->inside_address,
                'nationality' => $employee->user->country,
                'address_outside' => $employee->user->address,
                'jointing_date' => $employee->joining_date->format('Y-m-d'),
                'emergency_no' => $employee->emergancy_phone,
                'emergency_name' => $employee->emergancy_name,
                // 'notes' => $employee->note,
                'gross_salary' => $employee->gross_salary,
                'net_salary' => $employee->net_salary,
                'allowances' => $employee->allowances,
                'yearly_vacation' => $employee->yearly_vacation,
                'vacation_balance' => $employee->vacation_balance,
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Date',
            'Employee Name',
            'Tel Mobile',
            'Email',
            'Address',
            'Nationality',
            'Address Outside',
            'Jointing Date',
            'Emergency No',
            'Emergency Name',
            // 'Notes',
            'Gross Salary',
            'Net Salary',
            'Allowances',
            'Yearly Vacation',
            'Vacation Balance',
        ];
    }
}
