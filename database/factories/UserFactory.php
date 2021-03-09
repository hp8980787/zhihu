<?php

use App\User;
use App\Topic;
use App\Question;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar'=>'/image/avatar',
        'questions_count'=>0,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
$factory->define(Topic::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'bio'=>$faker->paragraph,
        'questions_count'=>1,
    ];
});

$factory->define(Question::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'title' => $faker->title,
        'body'=>$faker->text(300),

    ];
});
