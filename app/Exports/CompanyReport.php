<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompanyReport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Company::all()->transform(function ($company) {
            return $company->courses = $company->courses->transform(function ($course) use ($company) {
                $instructor = collect($course->courseGroup)->where('course_id', $course->id)->first()->user->name ?? 'No Instructor';
                return [
                    'id' => $company->id,
                    'company_name' => $company->name,
                    'category' => $course->category->name,
                    'starting_date' => $company->start_date,
                    'ending_date' => $company->end_date,
                    'company_email' => $company->email,
                    // 'student_name' => $trainer->name,
                    'mobile' => $company->phone,
                    'instructor_name' => $instructor,
                    'exam_course' => $course->title,
                    'exam_date' => $course->pivot->starting_date,
                    'total_fees' => $course->pivot->invoice_amount,
                    'payed' => $course->pivot->paid_amount,
                    'remaining' => $course->pivot->remain_amount,
                ];

            });
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Company Name', // From Company
            'Category', // From Courses
            'Starting Date', // From Company
            'Ending Date', // From Company
            'Company Email', // From Company
            // 'Student Name', // Trainers Related to Company
            'Mobile', // From Company
            'Instructor Name', // Complix Query
            'Exam / Course', // From Courses
            'Exam Date', // From Courses
            'Total Fees', // From Courses
            'Payed', // From Courses
            'Remaining', // From Courses
        ];
    }
}
