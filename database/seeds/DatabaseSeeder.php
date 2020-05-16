<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        //factory('App\User', 5)->create();
        //factory('App\Activo', 20)->create();
        //factory('App\Aula', 200)->create();
        Model::reguard();
    }
}
