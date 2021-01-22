<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Kernel;


use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class Kernel
{
    private static $instance;

    /**
     * Registered provider list
     *
     * @var array
     */
    protected array $provider = [];

    private ControllerResolver $controllerResolver;
    private ArgumentResolver $argumentResolver;

    /**
     * Kernel constructor.
     */
    private function __construct()
    {
        $this->controllerResolver = new ControllerResolver();
        $this->argumentResolver = new ArgumentResolver();
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
     * @return ControllerResolver
     */
    public function controllerResolver() {
        return $this->controllerResolver;
    }

    /**
     * @return ArgumentResolver
     */
    public function argumentResolver() {
        return $this->argumentResolver;
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
