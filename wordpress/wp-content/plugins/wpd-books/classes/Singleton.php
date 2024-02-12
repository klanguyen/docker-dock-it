<?php
namespace KN\BookPlugin;
/**
 * Represents a singleton
 */
abstract class Singleton
{

    /**
     * @var static $intance Hold the single instance per class
     */
    protected static $instance;

    /**
     * @return void
     */
    abstract protected function __construct();

    /**
     * @return void Prevent cloning (PHP specific)
     */
    private function __clone(){}

    /**
     * @return mixed Method for creating/returning the existing instance
     */
    public static function getInstance()
    {
        // self == the class that it is written in
        // static == the class that implements/calls the method
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}