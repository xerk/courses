<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model implements HasMedia
{
    use HasFactory;
    use Searchable;
    use InteractsWithMedia;

    protected $fillable = ['name', 'phone', 'email', 'address', 'joining_date', 'start_date', 'end_date'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'joining_date' => 'date',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function trainers()
    {
        return $this->hasMany(Trainer::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
