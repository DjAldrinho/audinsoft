<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'nombre' => $faker->name,
        'apellidos' => $faker->lastName,
        'identificacion' => $faker->bankRoutingNumber,
        'telefono' => $faker->phoneNumber,
        'tipo' => $faker->randomElement(['Administrativo', 'Docente', 'Estudiante']),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Activo::class, function (Faker\Generator $faker) {
    return [
        'nombre' => $faker->numerify('Activo ###'),
        'marca' => $faker->numerify('Marca ###'),
        'modelo' => $faker->numerify('Modelo ###'),
        'serial' => $faker->optional()->ean8,
        'manual' => $faker->optional()->imageUrl($width = 200, $height = 200),
        'cantidad' => $faker->optional()->randomDigit,
        'dependencia' => $faker->randomElement(['Servicios Informaticos', 'Bienestar Universitario', 'Audiovisuales', 'Infraestructura']),
        'descripcion' => $faker->optional()->paragraph($nbSentences = 3, $variableNbSentences = true),
        'tipo' => $faker->word,
        'estado' => $faker->randomElement(['Pendiente_reserva', 'Disponible', 'Ocupado'])
    ];
});


$factory->define(App\Aula::class, function (Faker\Generator $faker) {
    return [
        'nombre' => $faker->numerify('Aula ###'),
        'sede' => $faker->numerify('Sede ###'),
        'descripcion' => $faker->optional()->paragraph($nbSentences = 3, $variableNbSentences = true),
        'tipo' => $faker->randomElement(['Aula', 'Escenario Deportivo']),
        'estado' => $faker->randomElement(['Disponible', 'Ocupado', 'Mantenimiento'])
    ];
});
