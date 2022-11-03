<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'file',
        'size',
        'name',
        'documentable_type',
        'documentable_id',
        'type',
    ];

    protected $searchableFields = ['*'];

    public function documentable()
    {
        return $this->morphTo();
    }
}
