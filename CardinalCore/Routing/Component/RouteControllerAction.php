<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Routing\Component;


class RouteControllerAction
{
    protected Route $route;
    private $nameList = null;

    /**
     * RouteControllerAction constructor.
     * @param Route $route
     * @param array $nameList
     */
    public function __construct(Route $route, array &$nameList)
    {
        $this->route = $route;
        $this->nameList = &$nameList;
    }
    /**
     * @param string $name
     * @return $this
     */
    public function name(string $name): self {
        $this->nameList[$name] = $this->route;
        $this->route->name($name);
        return $this;
    }

    /**
     * @param array $middleware
     * @return $this
     */
    public function middleware(array $middleware):self {
        $this->route->middleware($middleware);
        return $this;
    }

    public function route() {
        return $this->route;
    }
}
