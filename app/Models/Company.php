<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'phone', 'email', 'address', 'joining_date'];

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
}
