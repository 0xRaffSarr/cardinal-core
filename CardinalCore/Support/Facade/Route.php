<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Support\Facade;

use CardinalCore\Routing\Component\RouteControllerAction;
use CardinalCore\Routing\Component\RoutePrefixController;

abstract class Route
{
    /**
     * @param string $path
     * @param array $action
     * @return RouteControllerAction
     */
    public static function post(string $path, array $action = []): RouteControllerAction
    {
        return app()->routing()->addRoute(['POST'], $path, $action);
    }

    /**
     * @param string $path
     * @param array $action
     * @return RouteControllerAction
     */
    public static function get(string $path, array $action = []): RouteControllerAction
    {
        return app()->routing()->addRoute(['GET', 'HEAD'], $path, $action);
    }

    /**
     * @param string $prefix
     * @return RoutePrefixController
     */
    public static function prefix(string $prefix): RoutePrefixController
    {
        return app()->routing()->prefix($prefix);
    }
}
