<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore;


use CardinalCore\Database\Database;
use CardinalCore\Database\Exception\DatabaseException;
use CardinalCore\Exception\Exception;
use CardinalCore\Http\Controller;
use CardinalCore\Http\Request;
use CardinalCore\Kernel\Contracts\Provider;
use CardinalCore\Kernel\Kernel;
use CardinalCore\Routing\Routing;
use PhpLogger\Logger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class App
{
    private static $instance;

    private $appName;

    private $appURL;

    private $paths = [];

    private $logger;
    /**
     * @var Request
     */
    private Request $currentRequest;

    private Kernel $kernel;

    /**
     * @var Routing
     */
    private Routing $routing;

    protected $kernelAbstract = Kernel::class;

    protected $logPath = 'log/';

    protected function __construct($name, $url)
    {
        $this->appName = $name;
        $this->appURL = $url;

        //inizializzazione della request
        $this->currentRequest = Request::createFromGlobals();

        /*
        * Load the system dir from the root of the project
        */
        $this->loadPaths();

        //inizializzazione routing
        $this->routing = Routing::create($this->currentRequest);
        /*
         * Create a kernel instance
         */
        $this->kernel = call_user_func($this->kernelAbstract .'::instance');

        // set the path for the php logger
        $this->logger = Logger::instance($this->paths('app_root').'/'.$this->logPath);

        //database connection check
        if (!Database::open()) {
            throw new DatabaseException('Cannot connection to database');
        }
    }

    /**
     * Return the app name
     *
     * @return string|null
     */
    public function appName() {
        return $this->appName;
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
     * @return array|string
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
    protected function loadPaths() {
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
    protected function findDir($path) {
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
     * Boot the provider app
     *
     * @throws \ReflectionException
     */
    public function bootProvider() {
        foreach (Kernel::instance()->getProviders() as $provider) {
            try {
                $class = new \ReflectionClass($provider);
                //check that class implements Provider interface before call the boot methods
                if($class->implementsInterface(Provider::class)) {
                    ($class->newInstanceWithoutConstructor())->boot();
                }
            }
            catch (Exception $e) {
                //TODO: add log action
            }
        }
    }

    /**
     * The starting point for the execution of the wheels and related actions.
     *
     * @return false|mixed|Response
     */
    public function handle() {
        $response = null;

        $response = $this->run();

        // if action in void method, generate a response to sent
        if(!$response) {
            $response = new Response(ob_get_clean());
        }

        return $response;
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

    /**
     * Run the route action
     *
     * @return false|mixed|Response
     */
    protected function run() {

        $response = null;

        try {
            //Getting route information
            $routeAction = $this->routing()->matcher()->match($this->request()->getPathInfo());
            //Retrieving controller information and method to be performed
            $action = $routeAction['_controller'].'::'.$routeAction['_method'];
            // Add action information to request
            $this->request()->attributes->add(['_controller' => $action]);

            // get controller
            $controller = $this->kernel->controllerResolver()->getController($this->request());

            /*
             * check if required controller extends Cardinal Controller
             * If it not extends Cardinal Controller, not call it.
             */
            if(is_a($controller[0], Controller::class)) {
                $arguments = $this->kernel->argumentResolver()->getArguments($this->request(), $controller);

                $response = call_user_func_array([$controller[0], $controller[1]], $arguments);
            }
            else {
                $response = new Response('Invalid controller');
            }
        }
        catch (ResourceNotFoundException $e) {
            $response = new Response('Not found', 404);
        }
        catch (Exception $e) {
            $response = new Response('An error occurred', 500);
        }

        return $response;
    }
}
