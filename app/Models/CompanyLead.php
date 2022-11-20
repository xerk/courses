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
        'category_id',
        'sub_category_id',
        'sales_id',
        'status',
        'note',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'company_leads';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function sales()
    {
        return $this->belongsTo(UserSaller::class, 'sales_id');
    }
}
