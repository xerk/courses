<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_phone',
        'p_o_box',
        'trn',
        'account_no',
        'iban',
        'bank_name',
        'bank_account_name',
    ];

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
