<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class,10)->create();
        DB::table('users')->insert(
            [
                'name' => 'constantine',
                'email' => '643711690@qq.com',
                'avatar'=>'/image/avatar.gif',
                'questions_count'=>0,
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make('hp123456'), // password
                'remember_token' => Str::random(10),
                'api_token'=> Str::random(60),
            ]
        );
    }
}
