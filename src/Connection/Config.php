<?php


namespace Mikola\Connection;


class Config
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

}

// db
Config::write('db.host', '94.152.11.141');
Config::write('db.port', '3306');
Config::write('db.basename', 'baza22641_mikola');
Config::write('db.user', 'admin22641_mikola');
Config::write('db.password', 'Mik11ola!');

