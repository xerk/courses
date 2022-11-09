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
        Schema::create('company_course', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('company_id');
            $table->date('starting_date')->nullable();
            $table->date('ending_date')->nullable();
            $table->tinyInteger('receipt_certificate')->nullable();
            $table->string('duration_days')->nullable();
            $table->enum('training_method', ['online', 'offline'])->nullable();
            $table->string('training_vinue')->nullable();
            $table->string('certificate_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('issuing_date')->nullable();
            $table->float('invoice_amount')->nullable();
            $table->tinyInteger('paid_status')->nullable();
            $table->string('total_payment')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('remain_amount')->nullable();
            $table->text('note')->nullable();
            $table->enum('payment_method', ['bank', 'cash'])->nullable();
            $table->float('paid_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_course');
    }
};
