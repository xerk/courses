<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssigmentAnswer extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'assigment_id',
        'instructor_id',
        'file',
        'status',
        'reason',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'assigment_answers';

    public function assigment()
    {
        return $this->belongsTo(Assigment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
