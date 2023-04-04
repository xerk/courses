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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            // quotation template
            $table->foreignId('quotation_template_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->enum('type', ['quotation', 'invoice'])->nullable();
            $table->string('bill_to')->nullable();
            $table->string('tel')->nullable();
            $table->string('p_o_box')->nullable();
            $table->string('trn')->nullable();

            $table->string('tax_invoice_date')->nullable();
            $table->string('tax_invoice_no')->nullable();
            $table->string('supply_date')->nullable();
            $table->string('lpo_count')->nullable();

            $table->timestamps();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quotation_id')->nullable()->constrained()->nullOnDelete();

            // courses
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();

            $table->integer('unit')->nullable();
            $table->float('price', 16, 2)->nullable();
            $table->float('net_count', 16, 2)->nullable();
            $table->float('vat_amount', 16, 2)->nullable();
            $table->float('total', 16, 2)->nullable();

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
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('quotation_items');
    }
};
