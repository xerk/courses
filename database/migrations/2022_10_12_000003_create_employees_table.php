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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('joining_date')->nullable();
            $table->string('passport_id')->nullable();
            $table->date('passport_realse_date')->nullable();
            $table->date('passport_expire_date')->nullable();
            $table->string('national_id')->nullable();
            $table->date('national_realse_date')->nullable();
            $table->date('national_expire_date')->nullable();
            $table->string('health_certificate_no')->nullable();
            $table->date('health_realse_date')->nullable();
            $table->date('health_expire_date')->nullable();
            $table->float('gross_salary')->nullable();
            $table->float('net_salary')->nullable();
            $table->float('allowances')->nullable();
            $table->integer('yearly_vacation')->nullable();
            $table->string('vacation_balance')->nullable();
            $table->string('emergancy_name')->nullable();
            $table->string('emergancy_phone')->nullable();
            $table->string('emergancy_relative_relation')->nullable();
            $table->text('note')->nullable();

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
        Schema::dropIfExists('employees');
    }
};
