<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore;


use CardinalCore\Http\Request;
use CardinalCore\Routing\Routing;
use mysql_xdevapi\Result;

class App
{
    protected static $instance;

    protected $appName;

    protected $appURL;

    protected $paths = [];
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
        /*
         * Load the system dir from the root of the project
         */
        $this->loadPaths();
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
     * Return all system path if key is null or a specific path. If path not exists return null.
     *
     * @return array
     */
    public function paths(string $key = null) {
        if(is_null($key)) {
            return $this->paths;
        }

        $keyList = explode('.', $key);
        $tmpArr = $this->paths;

        foreach ($keyList as $key) {
            if(array_key_exists($key, $tmpArr)) {
                $tmpArr = $tmpArr[$key];
            }
            else {
                return null;
            }
        }

        return $tmpArr;
    }

    /**
     * Load the system paths
     */
    private function loadPaths() {
        $appRoot = realpath(dirname((new \ReflectionClass($this))->getFileName()).'/..');
        $sourcePath = realpath($appRoot.'/src');

        $this->paths = [
            'app_root' => $appRoot,
            'source_path' => [
                'root' => $sourcePath,
            ]
        ];

        $this->paths['source_path'] = array_merge($this->paths['source_path'], $this->findDir($this->paths['source_path']['root']));
    }

    /**
     * Recursive scan of the path and find dir
     *
     * @param $path
     * @return array
     */
    private function findDir($path) {
        $dir = [];
        $scandir = array_diff(scandir($path), ['.', '..']);

        foreach ($scandir as $d) {
            $dirRealPath = realpath($path.'/'.$d);

            if(is_dir($dirRealPath)) {
                $dir[strtolower($d)]['root'] = $dirRealPath;
                $dir[strtolower($d)] = array_merge($dir[strtolower($d)], $this->findDir($dirRealPath));
            }
        }

        return $dir;
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
