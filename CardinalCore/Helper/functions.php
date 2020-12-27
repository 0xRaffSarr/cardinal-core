<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */


if(! function_exists('env')) {
    /**
     * Return the env configuration value or default it not exists
     *
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    function env($key, $default = '') {
        if(isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        return $default;
    }
}
