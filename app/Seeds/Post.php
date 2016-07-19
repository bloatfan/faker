<?php

namespace App\Seeds;

use \Faker\Generator as Faker;

class Post extends Model
{
    public $table = 'posts';

    public $timestamps = true;

    private static $users;

    public function seed(Faker $faker) 
    {
        // cache
        if (!isset(static::$users)) {
            static::$users = User::fetchAll();

            if (count(static::$users) == 0) {
                throw new \Exception('no users, please add it first');
            }
        }

        $count = count(static::$users);
        $random = mt_rand(0, $count - 1);
        $p = mt_rand(5, 15);

        return [
            'title' => $faker->sentence,
            'body' => $faker->paragraph($p),
            'user_id' => static::$users[$random]['id']
        ];
    }
}