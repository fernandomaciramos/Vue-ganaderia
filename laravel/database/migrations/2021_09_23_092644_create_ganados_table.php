<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGanadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ganados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('crotal')->unique();
            $table->integer('costillar')->unique();
            $table->string('raza');
            $table->unsignedBigInteger('ganaderia_id'); 
            $table->foreign('ganaderia_id')->references('id')->on('ganaderias');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ganados');
    }
}
