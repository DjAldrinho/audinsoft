<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espacios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('sede', 100);
            $table->integer('capacidad')->nullable();
            $table->string('tipo', 20);
            $table->string('dependencia', 50);
            $table->text('descripcion')->nullable();
            $table->string('estado', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('espacios');
    }
}
