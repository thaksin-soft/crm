<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmCusDecidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_customer_decides', function (Blueprint $table) {
            $table->id();
            $table->string('tr_code', 30)->unique();
            $table->string('decide_status', 50);
            $table->string('cus_name', 100);
            $table->string('cus_gender', 50);
            $table->text('cus_address', 50);
            $table->string('cus_tel', 20)->nullable();
            $table->string('bill_id', 50)->nullable();
            $table->date('date_sale')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('crm_customer_decides');
    }
}