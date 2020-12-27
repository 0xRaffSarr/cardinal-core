<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database;

use CardinalCore\Database\Exception\DatabaseException;
use PDO;
use PDOException;

abstract class Database
{
    private static $connection = null;

    /**
     * Open a new database connection and return it.
     *
     * @return PDO|null
     * @throws DatabaseException
     */
    public static function open()
    {
        if(!self::$connection) {
            $dns = env('DB_CONNECTION').':host='.env('DB_HOST').';dbname='.env('DB_DATABASE');

            try{
                self::$connection = new PDO($dns,env('DB_USERNAME'),env('DB_PASSWORD'));
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_AUTOCOMMIT, env('DB_AUTOCOMMIT'));
            }
            catch (PDOException $e)
            {
                throw new DatabaseException($e->getMessage());
            }
        }
        return self::connection();
    }

    /**
     * Return instance of connection if it is opened, else null
     *
     * @return PDO|null
     */
    public static function connection()
    {
        return self::$connection;
    }

    /**
     *  Set to null connection instance
     */
    public static function close()
    {
        self::$connection = null;
    }
}
