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
        Schema::table('trainers', function (Blueprint $table) {
            $table->string('student_code')->nullable();
        });
        Schema::table('course_user', function (Blueprint $table) {
            $table->timestamp('certificate_date')->nullable();
        });
        Schema::table('company_course', function (Blueprint $table) {
            $table->timestamp('certificate_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropColumn('student_code'); 
        });
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropColumn('certificate_date');
        });
        Schema::table('company_course', function (Blueprint $table) {
            $table->dropColumn('certificate_date');
        });
    }
};
