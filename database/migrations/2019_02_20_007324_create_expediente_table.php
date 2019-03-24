<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('caratula');
            $table->integer('user_id')->unsigned();
            $table->integer('usuario');
            $table->integer('nombre_usuario');
            $table->integer('rol_usuario');
            $table->integer('archivado');
            $table->integer('tipo_expediente_id')->unsigned();
            $table->date('fecha');
            $table->string('slug')->unique();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('Users');
            $table->foreign('tipo_expediente_id')->references('id')->on('Tipoexpediente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expediente');
    }
}
