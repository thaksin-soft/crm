<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_employee', function (Blueprint $table) {
            $table->id();
            $table->string('emp_name', 100);
            $table->string('emp_lname', 50)->nullable();
            $table->string('emp_gender', 30)->nullable();
            $table->string('tel', 30);
            $table->string('email', 50);
            $table->integer('depend_id')->nullable();
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
        Schema::dropIfExists('crm_employee');
    }
}