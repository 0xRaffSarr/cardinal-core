<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Routing\Middleware;

use CardinalCore\Routing\Exception\InvalidMiddleware;

class MiddlewareProcessor
{
    private $middleware;

    /**
     * MiddlewareProcessor constructor.
     * 
     * @param array $middleware
     * @throws InvalidMiddleware
     */
    public function __construct(array $middleware = []) {
        $this->middleware($middleware);
    }

    /**
     * Set the middleware list to check
     *
     * @param MiddlewareContracts[] $middleware
     * @throws InvalidMiddleware
     */
    public function middleware(array $middleware = []) {
        foreach ($middleware as $mid) {
            if(!$mid instanceof MiddlewareContracts) {
                throw new InvalidMiddleware('Middleware not valid');
            }
        }

        $this->middleware = array_unique(array_merge($this->middleware, $middleware));
    }

    /**
     * Check the middleware list
     */
    public function check() {
        //TODO: complete check method
    }

    /**
     * Return the middleware list
     *
     * @return MiddlewareContracts[]|null
     */
    public function getMiddlewares() {
        return $this->middleware;
    }
}
