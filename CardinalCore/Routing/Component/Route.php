<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Routing\Component;

use Symfony\Component\Routing\Route as SymfonyRoute;

class Route extends SymfonyRoute
{
    protected $name;

    protected $middleware = [];

    /**
     * Route constructor.
     * @param string $path
     * @param array $defaults
     * @param array $requirements
     * @param array $options
     * @param string|null $host
     * @param array $schemes
     * @param array $methods
     * @param string|null $condition
     * @param string|null $name
     */
    public function __construct(string $path, array $defaults = [], array $requirements = [], array $options = [], ?string $host = '', $schemes = [], $methods = [], ?string $condition = '', string $name = null)
    {
        parent::__construct($path, $defaults, $requirements, $options, $host, $schemes, $methods, $condition);

        $this->name = $name;
    }

    /**
     * @param string $name
     */
    public function name(string $name) {
        $this->name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Add middleware tu route
     *
     * @param array $middleware
     * @return $this
     */
    public function middleware(array $middleware) {
        $this->middleware = array_unique(array_merge($this->middleware, $middleware));

        return $this;
    }

    /**
     * return the middleware of the route
     *
     * @return array
     */
    public function getMiddleware() {
        return $this->middleware;
    }
}
