<?php

namespace App\Seeds;

use \Faker\Generator as Faker;
use \App\App;
use \App\Factory;

abstract class Model implements \Countable
{
    private $count;

    public $timestamps = false;

    public function __construct($count = 3)
    {
        $this->count = $count;
    }

    public function count()
    {
        return $this->count;
    }

    public static function __callStatic($name, array $arguments)
    {
        if ($name == 'fetchAll') {
            $instance = new static();
            return call_user_func_array([$instance, $name], $arguments);
        }
    }

    private function fetchAll()
    {
        return Factory::fetchAll($this->table);
    }

    /*
     * @return array 
     */
    abstract public function seed(Faker $faker);
}
