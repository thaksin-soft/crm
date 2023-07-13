<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmProductCusDecideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_product_cus_decide', function (Blueprint $table) {
            $table->id();
            $table->string('tr_code', 30);
            $table->integer('prg_id');
            $table->integer('prc_id');
            $table->text('product_buy');
            $table->string('size', 30)->nullable();
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
        Schema::dropIfExists('crm_product_cus_decide');
    }
}