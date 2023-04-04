<?php

// $table->id();
//             $table->string('title');
//             $table->foreignId('invoice_template_id')->constrained();
//             $table->foreignId('user_id')->constrained();
//             $table->date('date');
//             $table->string('received_from');
//             $table->decimal('amount', 8, 2);
//             $table->string('amount_ar');
//             $table->string('amount_en');
//             $table->integer('dhs');
//             $table->integer('fils');
//             $table->string('cheque_no');
//             $table->date('due_date');
//             $table->string('bank');
//             $table->string('account_no');
//             $table->string('being');

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'invoice_template_id',
        'user_id',
        'date',
        'received_from',
        'amount',
        'amount_ar',
        'amount_en',
        'dhs',
        'fils',
        'cheque_no',
        'due_date',
        'bank',
        'account_no',
        'being',
    ];

    public function invoiceTemplate()
    {
        return $this->belongsTo(InvoiceTemplate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
