<?php


namespace Mikola\Connection;


use Mikola\Connection\Config;

class Connect
{

    public $dbh;
    private static $instance;

    private function __construct()
    {
        // building data source name from config
        $dsn = 'mysql:host=' . Config::read('db.host') .
            ';dbname='    . Config::read('db.basename') .
            ';port='      . Config::read('db.port') .
            ';connect_timeout=15';

        $user = Config::read('db.user');
        $password = Config::read('db.password');
        $this->dbh = new \PDO($dsn, $user, $password);


    }

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

}

