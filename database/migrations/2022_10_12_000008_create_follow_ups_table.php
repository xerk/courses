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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->date('follow_date')->nullable();
            $table->date('next_follow_date')->nullable();
            $table->text('Note')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('company_lead_id')->nullable();
            $table
                ->enum('follow_up_from', ['visit', 'email', 'call'])
                ->nullable();

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
        Schema::dropIfExists('follow_ups');
    }
};
