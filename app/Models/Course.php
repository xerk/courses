<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model implements HasMedia
{
    use HasFactory;
    use Searchable;
    use InteractsWithMedia;

    protected $fillable = ['category_id', 'title', 'cost'];

    protected $searchableFields = ['*'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function courseGroups()
    {
        return $this->hasMany(CourseGroup::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function userTrainers()
    {
        return $this->belongsToMany(UserTrainer::class, 'course_user', 'user_id', 'course_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
