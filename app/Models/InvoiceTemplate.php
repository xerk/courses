<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// $table->string('title_ar');
//             $table->string('title_en');
//             $table->string('phone');
//             $table->string('commercial_no');
//             $table->string('vat_no');
//             $table->string('email');
//             $table->string('website');
//             $table->string('received_by');
//             $table->string('accountant_name');
//             $table->string('manager_name');

class InvoiceTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'phone',
        'commercial_no',
        'vat_no',
        'email',
        'website',
        'received_by',
        'accountant_name',
        'manager_name',
        'address_ar',
        'address_en',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
