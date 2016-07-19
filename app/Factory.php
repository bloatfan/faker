<?php

namespace App;

use \App\App;
use \App\Seeds\Model;

class Factory
{
    public static $app;
    private static $connect;
    private $locale;

    public function __construct($locale = 'en_US')
    {
        if (!isset(static::$connect)) {
            $app = static::$app;
            static::$connect = $app['db']();
        }

        $this->locale = $locale;
    }

    public function create(Model $model)
    {
        if (!($model instanceof Model)) {
            throw new InvalidArgumentException('not is a valid model, it must be extended model');
        }

        $faker = \Faker\Factory::create($this->locale);

        // peek, grab all key
        $keys = array_keys($model->seed($faker));

        $sql = 'insert into ' . $model->table . '(';

        for ($i = 0, $count = count($keys); $i < $count; $i++) {
            $sql .= $keys[$i] . ',';
        }

        if (isset($model->timestamps) && $model->timestamps) {
            $sql .= 'created_at, updated_at,';
        }

        $sql = trim($sql, ',') . ') values ';

        for ($i = 0, $count = $model->count(); $i < $count; $i++) {
            $seed = $model->seed($faker);
            $item = '(';
            foreach ($seed as $key => $value) {
                $item .= '"' . $value . '",';
            }

            if (isset($model->timestamps) && $model->timestamps) {
                $item .= 'now(), now(),';
            }

            $item = trim($item, ',') . '),';
            $sql .= $item;
        }

        $sql = trim($sql, ',');

        static::$connect->exec($sql);
    }

    public static function fetchAll($table)
    {
        $sql = 'select * from ' . $table;
        $state = static::$connect->prepare($sql);
        $state->setFetchMode(\PDO::FETCH_ASSOC);
        $state->execute();

        return $state->fetchAll();
    }
}
