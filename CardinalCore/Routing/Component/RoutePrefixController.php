<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Routing\Component;


class RoutePrefixController
{
    protected string $actualPrefix;
    protected array $prefixMiddleware;
    protected string $prefix;
    protected array $middleware;

    public function __construct(string $prefix, string &$actualPrefix, array &$middlewarePrefix){
        $this->actualPrefix = $actualPrefix;
        $this->prefixMiddleware = $middlewarePrefix;
        $this->prefix = $prefix;
    }

    /**
     * Add middleware to prefix
     *
     * @param array $middleware
     * @return $this
     */
    public function middleware(array $middleware): self {
        $this->middleware = array_unique(array_merge($middleware, $this->prefixMiddleware));

        return $this;
    }

    /**
     * Add route to prefix
     *
     * @param \Closure $routes
     */
    public function group(\Closure $routes) {
        $oldPrefix = $this->actualPrefix;

        $this->actualPrefix = $this->actualPrefix.$this->prefix;
        $this->prefixMiddleware = $this->middleware;

        if(is_callable($routes)) {
            call_user_func($routes);
        }

        $this->actualPrefix = $oldPrefix;
        $this->prefixMiddleware = [];
    }
}
