<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->date('starting_date')->nullable();
            $table->date('ending_date')->nullable();
            $table->date('joining_date')->nullable();
            $table->mediumText('note')->nullable();
            $table->tinyInteger('cleared_fees')->nullable();
            $table->tinyInteger('receipt_certificate')->nullable();
            $table->string('duration_days')->nullable();
            $table->enum('training_method', ['online', 'offline'])->nullable();
            $table->string('training_vinue')->nullable();
            $table->string('invoice_no')->nullable();
            $table->float('paid_amount')->nullable();
            $table->float('remain_amount')->nullable();
            $table->string('invoice_amount')->nullable();
            $table->string('paid_status')->nullable();
            $table->string('total_payment')->nullable();
            $table->date('payment_date')->nullable();
            $table->enum('payment_method', ['bank', 'cash'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_user');
    }
};
