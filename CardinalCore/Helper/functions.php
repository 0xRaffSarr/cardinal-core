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

if(! function_exists('app')) {
    /**
     * @param $key
     * @return \CardinalCore\App|null
     */
    function app($key = null) {
        return \CardinalCore\App::appInstance();
    }
}

if(! function_exists('systPath')) {
    /**
     * Return all system path if key is null or a specific path. If path not exists return null.
     *
     * @param string|null $key
     * @return array|null
     */
    function systPath(string $key = null) {
        return app()->paths($key);
    }
}
