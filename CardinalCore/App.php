<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore;


use CardinalCore\Http\Request;
use CardinalCore\Routing\Routing;

class App
{
    protected static $instance;

    protected $appName;

    protected $appURL;

    /**
     * @var Request
     */
    protected Request $currentRequest;

    /**
     * @var Routing
     */
    protected Routing $routing;

    private function __construct($name, $url)
    {
        $this->appName = $name;
        $this->appURL = $url;

        //inizializzazione della request
        $this->currentRequest = Request::createFromGlobals();
        //inizializzazione routing
        $this->routing = Routing::create($this->currentRequest);
    }

    /**
     * Return the current request
     *
     * @return Request
     */
    public function request(): Request
    {
        return $this->currentRequest;
    }

    /**
     * Return the routing instance
     *
     * @return Routing
     */
    public function routing() {
        return $this->routing;
    }

    /**
     * Create an instance of App class
     *
     * @param $name
     * @param $url
     * @return static
     */
    public static function create($name, $url) {
        return self::$instance = self::$instance ?? new static($name, $url);
    }

    /**
     * Return the current app instance or null
     *
     * @return static|null
     */
    public static function appInstance() {
        return self::$instance;
    }
}
