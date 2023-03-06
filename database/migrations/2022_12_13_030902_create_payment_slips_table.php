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
        Schema::create('payment_slips', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('receipt')->nullable();
            $table->string('dhs')->nullable();
            $table->string('fils')->nullable();
            $table->string('amount')->nullable();
            $table->string('amount_ar')->nullable();
            $table->string('amount_en')->nullable();
            $table->date('date')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('due_date')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_no')->nullable();
            $table->string('being')->nullable();
            $table->string('manager_sig')->nullable();
            $table->string('accountant_sig')->nullable();
            $table->string('received_by')->nullable();
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
        Schema::dropIfExists('payment_slips');
    }
};
