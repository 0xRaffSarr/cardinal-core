<?php
/*
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Http;

abstract class Controller
{
    /**
     * The controller middleware list
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Add one or more middlewate to controller
     *
     * @param array $middleware
     */
    public function middleware(array $middleware) {
        $this->middleware = array_unique(array_merge($this->middleware, $middleware));
    }

    /**
     * Return the controller middleware list
     *
     * @return array
     */
    public function getMiddleware() {
        return $this->middleware;
    }
}
