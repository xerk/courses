<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_template_id',
        'user_id',
        'bill_to',
        'tel',
        'p_o_box',
        'trn',
        'tax_invoice_date',
        'tax_invoice_no',
        'supply_date',
        'lpo_count',
        'type'
    ];

    public function quotationTemplate()
    {
        return $this->belongsTo(QuotationTemplate::class);
    }

    public function student()
    {
        return $this->belongsTo(UserTrainer::class);
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

}
