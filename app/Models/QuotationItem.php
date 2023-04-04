<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'course_id',
        'unit',
        'price',
        'net_count',
        'vat_amount',
        'total',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
