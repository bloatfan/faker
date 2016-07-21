<?php

namespace App\Seeds;

use \Faker\Generator as Faker;

class User extends Model
{
    public $table = 'users';

    public $timestamps = true;

    public function seed(Faker $faker)
    {
        return [
            'username' => $faker->userName,
            'email' => $faker->email,
            'password' => password_hash('123456', PASSWORD_DEFAULT)
        ];
    }
}
