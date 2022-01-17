<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('asunto');
            $table->text('mensaje');
            $table->dateTime('fecha');
            $table->timestamps();
            $table->unsignedBigInteger('emisor_id'); 
            $table->foreign('emisor_id')->references('id')->on('users');
            $table->unsignedBigInteger('receptor_id'); 
            $table->foreign('receptor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correos');
    }
}
