<?php

namespace App\Models;

use Parental\HasParent;


class UserTrainer extends User
{
    use HasParent;

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'course_id', 'user_id');
    }
}
