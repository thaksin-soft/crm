<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmProductCusInterestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_product_cus_interest', function (Blueprint $table) {
            $table->id();
            $table->string('tr_code', 20);
            $table->integer('prg_id');
            $table->integer('prc_id');
            $table->text('cus_interest_product'); 
            $table->string('pr_size', 10)->nullable();
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
        Schema::dropIfExists('crm_product_cus_interest');
    }
}