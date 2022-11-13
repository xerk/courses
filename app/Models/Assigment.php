<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assigment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'title',
        'file',
        'dead_line',
        'points',
        'body',
        'course_group_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'dead_line' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseGroup()
    {
        return $this->belongsTo(CourseGroup::class);
    }

    public function assigmentAnswers()
    {
        return $this->hasMany(AssigmentAnswer::class);
    }
}
