<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmProductCusContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_product_cus_contract', function (Blueprint $table) {
            $table->id();
            $table->string('tr_code', 30);
            $table->integer('prg_id');
            $table->integer('prc_id');
            $table->text('product_purchased');
            $table->string('product_size', 30)->nullable();
            $table->integer('prb_id');
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
        Schema::dropIfExists('crm_product_cus_contract');
    }
}