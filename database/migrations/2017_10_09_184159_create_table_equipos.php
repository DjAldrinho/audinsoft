<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEquipos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->string('estado', 50)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('equipos_activos', function (Blueprint $table) {
            $table->integer('activo_id')->unsigned();
            $table->foreign('activo_id')->references('id')->on('activos')->onDelete('cascade');
            $table->integer('equipo_id')->unsigned()->nullable();
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos_activos');
        Schema::dropIfExists('equipos');
    }
}
