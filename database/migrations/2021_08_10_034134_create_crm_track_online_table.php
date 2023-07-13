<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmTrackOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_track_online', function (Blueprint $table) {
            $table->id();
            $table->string('tr_code', 20)->unique();
            $table->text('tr_name');
            $table->string('tr_gender', 30)->nullable();
            $table->string('tr_tel', 30)->nullable();
            $table->text('tr_cus_facebook');
            $table->text('tr_cus_address')->nullable();
            $table->text('tr_con_channel');
            $table->text('tr_con_from');
            $table->integer('emp_id');
            $table->string('status', 50);
            $table->text('note')->nullable();
            $table->text('dates');
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
        Schema::dropIfExists('crm_track_online');
    }
}