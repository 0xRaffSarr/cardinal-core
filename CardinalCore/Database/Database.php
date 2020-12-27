<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database;

use CardinalCore\Database\Collection\PDOStatementCollection;
use CardinalCore\Database\Exception\DatabaseException;
use PDO;
use PDOException;

abstract class Database
{
    /**
     * @var null | PDO
     */
    private static ?PDO $connection = null;

    /**
     * Open a new database connection and return it.
     *
     * @return PDO|null
     * @throws DatabaseException
     */
    public static function open(): ?PDO {
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
    public static function connection(): ?PDO {
        return self::$connection;
    }

    /**
     *  Set to null connection instance
     */
    public static function close() {
        self::$connection = null;
    }

    /**
     * Execute PDO Statement.
     * If fails, it perform a rollback and return false, true otherwise.
     *
     * @param \PDOStatement $stmt
     * @return bool
     */
    public static function exec(\PDOStatement $stmt): bool {
        self::connection()->beginTransaction();

        try{
            $result = $stmt->execute();

            if($result) {
                self::connection()->commit();
            }
            else {
                self::connection()->rollBack();
            }
        }
        catch (PDOException $e) {
            $result = false;
            self::$connection->rollBack();
        }

        return $result;
    }

    /**
     * Execute a collection of PDO Statement.
     * If one fails, it perform a rollback and return false, true otherwise.
     *
     * @param PDOStatementCollection $stmt
     * @return bool
     * @throws DatabaseException
     */
    public static function execMore(PDOStatementCollection $stmt): bool {
        self::connection()->beginTransaction();

        $result = true;

        try{
            foreach ($stmt as $stm) {
                if(!$stm->execute()) {
                    $result = false;
                    break;
                }
            }

            if($result) {
                self::connection()->commit();
            }
            else {
                self::connection()->rollBack();
            }
        }
        catch (PDOException $e){
            self::connection()->rollBack();
            throw new DatabaseException($e->getMessage());
        }

        return $result;
    }
}
