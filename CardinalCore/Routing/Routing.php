<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Routing;


use CardinalCore\Http\Request;
use CardinalCore\Routing\Component\Route;
use CardinalCore\Routing\Component\RouteControllerAction;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use CardinalCore\Routing\Component\RoutePrefixController;

class Routing
{
    private static $instance;

    protected Request $request;

    protected RequestContext $context;

    protected RouteCollection $routesCollection;

    protected string $prefix = '';
    protected array $prefixMiddleware = [];

    protected array $routes = [];
    protected array $routesName = [];

    private function __construct(Request $request)
    {
        $this->request = $request;

        $this->context = new RequestContext();
        $this->context->fromRequest($this->request);

        $this->routesCollection = new RouteCollection();
    }

    /**
     * @param $methods
     * @param $uri
     * @param $action
     * @return RouteControllerAction
     */
    public function addRoute($methods, $uri, $action) {
        return $this->add($this->createRoute($methods, $uri, $action));
    }

    /**
     * Adda a route to collection
     *
     * @param Route $route
     * @return RouteControllerAction
     */
    private function add(Route $route) {
        foreach ($route->getMethods() as $method) {
            $this->routes[$method][$route->getPath()] = $route;
        }

        $routeName = ($this->routesCollection->get($route->getPath())) ? '' : $route->getPath();

        $this->routesCollection->add($routeName, $route);

        return new RouteControllerAction($route, $this->routesName);
    }

    /**
     * Create a new route
     *
     * @param $methods
     * @param $uri
     * @param $action
     * @return Route
     */
    private function createRoute($methods, $uri, $action) {
        $prefix = $this->prefix;

        if(substr($uri, 0, 1) !== '/') {
            $uri = '/'.$uri;
        }

        if(substr($prefix, strlen($prefix)-1, 1) === '/') {
            $prefix = ubstr($prefix, 0, strlen($prefix)-1);
        }

        $route = new Route($prefix.$uri, $action, $methods);

        if(count($this->prefixMiddleware) > 0) {
            $route->middleware($this->prefixMiddleware);
        }

        return $route;
    }

    /**
     * Create a new Routing instance if not exists or existing instance
     *
     * @param Request $request
     * @return static
     */
    public static function create(Request $request) {
        return self::$instance = self::$instance ?? new static($request);
    }

    /**
     * @param string $prefix
     * @return RoutePrefixController
     */
    public function prefix(string $prefix) {
        return new RoutePrefixController($prefix, $this->prefix, $this->prefixMiddleware);
    }
}
