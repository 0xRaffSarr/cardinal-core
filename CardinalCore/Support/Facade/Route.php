<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Support\Facade;


use CardinalCore\Routing\Routing;

abstract class Route
{
    /**
     * @param string $path
     * @param array $action
     * @return \CardinalCore\Routing\Component\RouteControllerAction
     */
    public static function post(string $path, array $action = []): \CardinalCore\Routing\Component\RouteControllerAction
    {
        return Routing::create()->addRoute(['POST'], $path, $action);
    }

    /**
     * @param string $path
     * @param array $action
     * @return \CardinalCore\Routing\Component\RouteControllerAction
     */
    public static function get(string $path, array $action = []): \CardinalCore\Routing\Component\RouteControllerAction
    {
        return Routing::create()->addRoute(['GET', 'HEAD'], $path, $action);
    }

    /**
     * @param string $prefix
     * @return \CardinalCore\Routing\Component\RoutePrefixController
     */
    public static function prefix(string $prefix): \CardinalCore\Routing\Component\RoutePrefixController
    {
        return Routing::create()->prefix($prefix);
    }
}
