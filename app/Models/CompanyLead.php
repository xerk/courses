<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyLead extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'name_ar',
        'email',
        'business_email',
        'phone',
        'business_landline',
        'complete_with',
        'category_id',
        'start_date',
        'end_date',
        'category_approved',
        'status',
        'note',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'company_leads';

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }
}
