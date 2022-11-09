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
        Schema::create('company_leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('email');
            $table->string('business_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_landline')->nullable();
            $table->string('complete_with');
            $table->unsignedBigInteger('category_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('category_approved')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('company_leads');
    }
};
