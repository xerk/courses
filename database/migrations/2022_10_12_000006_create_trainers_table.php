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
        Schema::create('trainers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('company')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('occupation')->nullable();
            $table->string('work_place')->nullable();
            $table->tinyInteger('sufer_diseases')->nullable();
            $table->longText('diseases_note')->nullable();
            $table->string('job_title')->nullable();
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
        Schema::dropIfExists('trainers');
    }
};
