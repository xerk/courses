<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainer extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'company',
        'company_id',
        'occupation',
        'work_place',
        'sufer_diseases',
        'diseases_note',
        'job_title',
        'note',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
