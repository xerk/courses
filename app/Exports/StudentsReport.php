<?php

namespace App\Exports;

use App\Models\CourseGroup;
use App\Models\UserTrainer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsReport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $courseGroup = CourseGroup::all()->transform(function ($group) {
            return $group->users = $group->users->transform(function ($student) use($group) {
                $contract = \DB::table('course_user')->where('user_id', $student->id)->where('course_id', $group->course_id)->first();

                return [
                    'id' => $student->id,
                    'date' => $contract->joining_date ?? '',
                    'student_name' => $student->name ?? '',
                    'tel_mobile' => $student->tel_mobile ?? '',
                    'email' => $student->email ?? '',
                    'course_name' => $group->course->title ?? '',
                    'instructor_name' => $group->user->name ?? '',
                    'start_date' => $contract->starting_date ?? '',
                    'end_date' => $contract->ending_date ?? '',
                    'certification' => optional($contract)->receipt_certificate ? 'Yes' : 'No',
                    'issue_date' => $contract->certificate_date ?? '',
                    'training_methods' => $contract->training_method ?? '',
                    'Total Amount' => $contract->invoice_amount ?? '',
                    'Paid' => $contract->paid_amount ?? '',
                    'Remaining' => $contract->remain_amount ?? '',
                ];
            });
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date',
            'Student Name',
            'Tel Mobile',
            'Email',
            'Course Name',
            'Instructor Name',
            'Start Date',
            'End Date',
            'Certification',
            'Issue Date',
            'Training Methods',
            'Total Fees',
            'Payed',
            'balance',
        ];
    }
}
