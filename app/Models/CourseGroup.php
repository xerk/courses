<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseGroup extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['user_id', 'course_id', 'name'];

    protected $searchableFields = ['*'];

    protected $table = 'course_groups';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assigments()
    {
        return $this->hasMany(Assigment::class);
    }

    public function users()
    {
        return $this->belongsToMany(UserTrainer::class, 'course_group_user', 'course_group_id', 'user_id');
    }
}
