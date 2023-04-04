<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('invoice_template_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->string('received_from');
            $table->decimal('amount', 8, 2);
            $table->string('amount_ar');
            $table->string('amount_en');
            $table->integer('dhs');
            $table->integer('fils');
            $table->string('cheque_no');
            $table->date('due_date');
            $table->string('bank');
            $table->string('account_no');
            $table->string('being');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
