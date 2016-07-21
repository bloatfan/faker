<?php

namespace App;

class App implements \ArrayAccess
{
    private $container = [];

    private static $instance;

    public function __construct(array $container = null)
    {
        if (isset(static::$instance)) {
            throw new \Exception('There already exists a App');
        }

        static::$instance = $this;
        Factory::$app = $this;

        if (is_array($container)) {
            $this->container = $container;
        }
    }

    public function __get($property)
    {
        return $this->container[$property];
    }

    public function __set($property, $value)
    {
        $this->container[$property] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }
    
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}
