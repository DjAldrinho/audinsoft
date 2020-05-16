<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('nombre', 100);
            $table->string('codigo_usuario', 100)->nullable();
            $table->string('identificacion', 30)->unique();
            $table->string('telefono', 40)->unique()->nullable();
            $table->string('escuela', 50)->nullable();
            $table->string('semestre', 50)->nullable();
            $table->string('jornada', 50)->nullable();
            $table->string('rol', 40);
            $table->string('dependencia', 50)->nullable();
            $table->string('cargo', 40)->nullable();
            $table->boolean('administrador')->default(false);
            $table->boolean('superadministrador')->default(false);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
