<?php

class Database
{
    private static $dbName = 'customer_crud';
    private static $dbHost = 'localhost';
    private static $dbUserName = 'laravel';
    private static $dbUserPassword = 'laravel';

    private static $connection = null;

    public function __construct()
    {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if (null == self::$connection) {
            try {
                self::$connection = new PDO("mysql:host=" . self::$dbHost . ";" .
                    "dbname=" . self::$dbName,
                    self::$dbUserName, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}