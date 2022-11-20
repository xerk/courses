<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'course_type',
        'category_id',
        'sub_category_id',
        'sales_id',
        'lead_from',
        'note',
    ];

    protected $searchableFields = ['*'];

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

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
