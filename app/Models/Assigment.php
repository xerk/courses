<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assigment extends Model implements HasMedia
{
    use HasFactory;
    use Searchable;
    use InteractsWithMedia;

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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
