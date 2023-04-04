<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'joining_date',
        'passport_id',
        'passport_realse_date',
        'passport_expire_date',
        'national_id',
        'national_realse_date',
        'national_expire_date',
        'health_certificate_no',
        'health_realse_date',
        'health_expire_date',
        'gross_salary',
        'net_salary',
        'allowances',
        'yearly_vacation',
        'vacation_balance',
        'emergancy_name',
        'emergancy_phone',
        'emergancy_relative_relation',
        'note',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'joining_date' => 'datetime',
        'passport_realse_date' => 'date',
        'passport_expire_date' => 'date',
        'national_realse_date' => 'date',
        'national_expire_date' => 'date',
        'health_realse_date' => 'date',
        'health_expire_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(UserEmployee::class);
    }
}
