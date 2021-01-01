<?php
/**
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Support\Facade;

use PhpLogger\Logger as PhpLogger;

abstract class Logger
{
    /**
     * If the append option is set to true, the data is append to endo of file, else append to start of file.
     * Return it self
     *
     * @param bool $append
     * @return PhpLogger
     * @throws \Exception
     */
    public static function setAppendToFile(bool $append) {
        return PhpLogger::instance()->setAppendToFile($append);
    }

    /**
     * If the json is set to true, log as saved as json, else as string.
     * Return it self
     *
     * @param bool $json
     * @return PhpLogger
     * @throws \Exception
     */
    public static function setJson(bool $json) {
        return PhpLogger::instance()->setJson($json);
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public static function emergency($message, array $context = array()) {
        PhpLogger::instance()->emergency($message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public static function alert($message, array $context = array()) {
        PhpLogger::instance()->alert($message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public static function critical($message, array $context = array()) {
        PhpLogger::instance()->critical($message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public static function error($message, array $context = array()) {
        PhpLogger::instance()->error($message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public static function warning($message, array $context = array()) {
        PhpLogger::instance()->warning($message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public static function notice($message, array $context = array()) {
        PhpLogger::instance()->notice($message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public static function info($message, array $context = array()) {
        PhpLogger::instance()->info($message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     * @throws \Exception
     */
    public static function debug($message, array $context = array()) {
        PhpLogger::instance()->debug($message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed   $level
     * @param string  $message
     * @param mixed[] $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException|\Exception
     */
    public static function log($level, $message, array $context = array()) {
        PhpLogger::instance()->log($level, $message, $context);
    }
}
