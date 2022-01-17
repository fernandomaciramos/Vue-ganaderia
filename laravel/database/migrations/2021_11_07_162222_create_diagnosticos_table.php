<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('diagnostico');
            $table->text('tratamiento');
            $table->dateTime('inicio');
            $table->dateTime('final');
            $table->timestamps();
            $table->unsignedBigInteger('ganado_id'); 
            $table->foreign('ganado_id')->references('id')->on('ganados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnosticos');
    }
}
