<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'image'];

    protected $searchableFields = ['*'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function companyLeads()
    {
        return $this->hasMany(CompanyLead::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
