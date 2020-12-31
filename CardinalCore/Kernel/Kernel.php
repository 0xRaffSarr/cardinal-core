<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Kernel;


class Kernel
{
    private static $instance;

    /**
     * Registered provider list
     *
     * @var array
     */
    protected array $provider = [];

    /**
     * Kernel constructor.
     */
    private function __construct()
    {

    }

    /**
     * Return registered providers
     *
     * @return array
     */
    public function getProviders() {
        return $this->provider;
    }

    /**
     * create a new Kernel instance if not exists and return it, or return kernel instance
     *
     * @return static
     */
    public static function instance() {
        return self::$instance = self::$instance ?? new static();
    }
}
