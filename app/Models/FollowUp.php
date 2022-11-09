<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowUp extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'Note',
        'lead_id',
        'status',
        'company_lead_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'follow_ups';

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function companyLead()
    {
        return $this->belongsTo(CompanyLead::class);
    }
}
