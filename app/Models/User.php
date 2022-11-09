<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasApiTokens;
    use HasRoles; //or HasFilamentShield
    use InteractsWithMedia;

    protected $fillable = [
        'username',
        'name',
        'name_ar',
        'avatar',
        'email',
        'private_email',
        'password',
        'phone',
        'phone2',
        'address',
        'inside_address',
        'type',
        'category_id',
        'city',
        'country',
        'company_id',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly($this->fillable);
    }

    public function trainer()
    {
        return $this->hasOne(Trainer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    
    public function courseGroups()
    {
        return $this->belongsToMany(CourseGroup::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function isSuperAdmin()
    {
        return in_array($this->email, config('auth.super_admins'));
    }

    
}
